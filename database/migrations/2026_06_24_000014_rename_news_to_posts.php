<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            $this->upSqlite();
        } elseif ($driver === 'pgsql') {
            $this->upPgsql();
        } else {
            $this->upMysql();
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            $this->downSqlite();
        } elseif ($driver === 'pgsql') {
            $this->downPgsql();
        } else {
            $this->downMysql();
        }
    }

    /**
     * MySQL: straightforward ALTER TABLE operations
     */
    protected function upMysql(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->enum('status', ['draft', 'published', 'archived'])->default('published')->after('is_published');
            $table->integer('views_count')->default(0)->after('status');
            $table->longText('gallery_images')->nullable()->after('views_count');
        });

        $this->mergeGalleryImages();

        Schema::rename('news', 'posts');

        DB::statement('ALTER TABLE posts CHANGE COLUMN content body LONGTEXT NULL');
        Schema::table('posts', function (Blueprint $table) {
            $table->renameColumn('thumbnail', 'cover_image');
        });
    }

    /**
     * PostgreSQL: cannot RENAME COLUMN away from ENUM in some versions, use rebuild
     */
    protected function upPgsql(): void
    {
        // For PG, add new columns, merge galleries, then rename/drop
        Schema::table('news', function (Blueprint $table) {
            $table->string('status')->default('published')->after('is_published');
            $table->integer('views_count')->default(0)->after('status');
            $table->text('gallery_images')->nullable()->after('views_count');
        });

        $this->mergeGalleryImages();

        // In PG, rename column and table atomically
        Schema::table('news', function (Blueprint $table) {
            $table->renameColumn('content', 'body');
            $table->renameColumn('thumbnail', 'cover_image');
        });

        Schema::rename('news', 'posts');
    }

    /**
     * SQLite: rebuild table since ALTER COLUMN is limited
     */
    protected function upSqlite(): void
    {
        $existingGalleries = DB::table('galleries')->get();

        Schema::table('news', function (Blueprint $table) {
            $table->string('status')->default('published')->after('is_published');
            $table->integer('views_count')->default(0)->after('status');
            $table->text('gallery_images')->nullable()->after('views_count');
        });

        // Merge gallery images
        foreach ($existingGalleries as $gallery) {
            $matched = $this->findMatchingPost($gallery);
            if ($matched) {
                $images = json_decode($matched->gallery_images, true) ?: [];
                $images[] = $gallery->image_path;
                DB::table('news')->where('id', $matched->id)
                    ->update(['gallery_images' => json_encode(array_values(array_unique($images)))]);
            }
        }

        // Rename table
        Schema::rename('news', 'posts');

        // Rebuild posts with correct column names
        // PRAGMA output gives us the current schema
        $columns = DB::select("PRAGMA table_info(posts)");
        $colMap = [];
        foreach ($columns as $c) {
            $arr = (array) $c;
            $colMap[$arr['name']] = $arr['type'] ?? 'TEXT';
        }

        // Build new table with body/cover_image naming
        $newCols = [];
        foreach ($colMap as $name => $type) {
            $safeName = $name === 'content' ? 'body' : ($name === 'thumbnail' ? 'cover_image' : $name);
            // Skip sqlite_sequence
            if ($name === 'sqlite_sequence') {
                continue;
            }
            $colDef = $safeName;
            if ($name === 'id') {
                $colDef .= ' INTEGER PRIMARY KEY AUTOINCREMENT';
            } else {
                $colDef .= ' ' . ($type ?: 'TEXT');
            }
            $newCols[] = $colDef;
        }

        DB::statement('CREATE TABLE posts_new (' . implode(', ', $newCols) . ')');

        // Build INSERT column list and SELECT expressions in same order as colMap
        $insertCols = [];
        $selectExprs = [];
        foreach ($colMap as $origName => $type) {
            $targetCol = ($origName === 'content' ? 'body' : ($origName === 'thumbnail' ? 'cover_image' : $origName));
            $insertCols[] = $targetCol;
            // SELECT from old column name
            $selectExprs[] = $origName;
        }

        DB::statement(
            'INSERT INTO posts_new (' . implode(', ', $insertCols) . ') SELECT ' . implode(', ', $selectExprs) . ' FROM posts'
        );

        DB::statement('DROP TABLE posts');
        DB::statement('ALTER TABLE posts_new RENAME TO posts');
    }

    /**
     * MySQL down
     */
    protected function downMysql(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->renameColumn('cover_image', 'thumbnail');
            $table->renameColumn('body', 'content');
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['status', 'views_count', 'gallery_images']);
        });
        Schema::rename('posts', 'news');
    }

    /**
     * PostgreSQL down
     */
    protected function downPgsql(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->renameColumn('cover_image', 'thumbnail');
            $table->renameColumn('body', 'content');
            $table->dropColumn(['status', 'views_count', 'gallery_images']);
        });
        Schema::rename('posts', 'news');
    }

    /**
     * SQLite down
     */
    protected function downSqlite(): void
    {
        // Read current columns
        $columns = DB::select("PRAGMA table_info(posts)");
        $colMap = [];
        foreach ($columns as $c) {
            $arr = (array) $c;
            $colMap[$arr['name']] = $arr['type'] ?? 'TEXT';
        }
        // Drop content_type if it exists (added by later migration)
        if (isset($colMap['content_type'])) {
            unset($colMap['content_type']);
        }

        // Build rebuild with body→content, cover_image→thumbnail
        $newCols = [];
        foreach ($colMap as $name => $type) {
            $safeName = $name === 'body' ? 'content' : ($name === 'cover_image' ? 'thumbnail' : $name);
            if ($name === 'id' || $name === 'sqlite_sequence') {
                $newCols[] = $name . ' INTEGER PRIMARY KEY AUTOINCREMENT';
                continue;
            }
            $newCols[] = $safeName . ' ' . ($type ?: 'TEXT');
        }

        // Drop extra columns that don't exist in original schema
        foreach (['status', 'views_count', 'gallery_images', 'content_type'] as $dropCol) {
            unset($colMap[$dropCol]);
        }

        DB::statement('CREATE TABLE posts_new (' . implode(', ', $newCols) . ')');

        // Build select with renamed columns
        $selectParts = [];
        foreach ($colMap as $origName => $type) {
            $targetName = $origName === 'body' ? 'content' : ($origName === 'cover_image' ? 'thumbnail' : $origName);
            if ($targetName === $origName) {
                $selectParts[] = $origName;
            } else {
                $selectParts[] = "{$origName} AS {$targetName}";
            }
        }

        // Build INSERT column list with renamed columns matching posts_new
        $insertCols = [];
        foreach ($colMap as $origName => $type) {
            $insertCols[] = ($origName === 'body' ? 'content' : ($origName === 'cover_image' ? 'thumbnail' : $origName));
        }

        DB::statement(
            'INSERT INTO posts_new (' . implode(', ', $insertCols) . ') SELECT ' . implode(', ', $selectParts) . ' FROM posts'
        );

        DB::statement('DROP TABLE posts');
        DB::statement('ALTER TABLE posts_new RENAME TO posts');
        Schema::rename('posts', 'news');
    }

    /**
     * Shared: merge gallery images into posts
     */
    protected function mergeGalleryImages(): void
    {
        $galleries = DB::table('galleries')->get();
        foreach ($galleries as $gallery) {
            $matched = DB::table('news')
                ->where(function ($q) use ($gallery) {
                    $q->where('title', 'LIKE', "%{$gallery->title}%")
                      ->orWhere('title', 'LIKE', "%{$gallery->album}%")
                      ->orWhereRaw('LOWER(REPLACE(title," ","-")) = ? OR LOWER(REPLACE(title," ","-")) LIKE ?', [
                          strtolower(str_replace(' ', '-', mb_substr($gallery->title, 0, 40))),
                          '%' . strtolower(str_replace(' ', '-', mb_substr($gallery->title, 0, 30))) . '%',
                      ]);
                })
                ->first();

            if ($matched) {
                $images = json_decode($matched->gallery_images, true) ?: [];
                $images[] = $gallery->image_path;
                DB::table('news')
                    ->where('id', $matched->id)
                    ->update(['gallery_images' => json_encode(array_values(array_unique($images)))]);
            }
        }
    }

    /**
     * Find matching post for a gallery
     */
    protected function findMatchingPost(object $gallery): ?object
    {
        return DB::table('news')
            ->where(function ($q) use ($gallery) {
                $q->where('title', 'LIKE', "%{$gallery->title}%")
                  ->orWhere('title', 'LIKE', "%{$gallery->album}%")
                  ->orWhereRaw('LOWER(REPLACE(title," ","-")) = ? OR LOWER(REPLACE(title," ","-")) LIKE ?', [
                      strtolower(str_replace(' ', '-', mb_substr($gallery->title, 0, 40))),
                      '%' . strtolower(str_replace(' ', '-', mb_substr($gallery->title, 0, 30))) . '%',
                  ]);
            })
            ->first();
    }
};
