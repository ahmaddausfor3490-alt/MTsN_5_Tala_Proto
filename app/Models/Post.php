<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'cover_image',
        'author_id',
        'is_published',
        'status',
        'published_at',
        'views_count',
        'gallery_images',
        'content_type',
    ];

    protected $casts = [
        'is_published'  => 'boolean',
        'published_at'  => 'datetime',
        'views_count'   => 'integer',
        'gallery_images' => 'array',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($post) {
            // Auto-generate title for gallery posts
            if ($post->content_type === 'gallery' && empty($post->title)) {
                $post->title = 'Galeri ' . now()->format('Y-m-d H:i');
            }

            // Generate slug from title if empty
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });

        static::updating(function ($post) {
            $original = $post->getOriginal('slug');
            if ($original && $original !== $post->slug) {
                Post::where('slug', $original)->update(['slug' => $post->slug]);
            }
        });

        // Auto-publish on create
        static::created(function ($post) {
            if ($post->is_published && !$post->published_at) {
                $post->published_at = now();
            }
        });

        // Auto-publish on update
        static::updating(function ($post) {
            if ($post->isDirty('is_published') && $post->is_published && !$post->published_at) {
                $post->published_at = now();
            }
        });
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'post_categories');
    }

    public function scopePublished(Builder $query)
    {
        return $query->where('status', 'published')
                     ->orWhere(function ($q) {
                         $q->where('is_published', true)
                           ->whereNotNull('published_at')
                           ->where('published_at', '<=', now());
                     });
    }

    public function scopeDraft(Builder $query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeNews(Builder $query): Builder
    {
        return $query->where('content_type', 'news');
    }

    public function scopeGallery(Builder $query): Builder
    {
        return $query->where('content_type', 'gallery');
    }

    public function scopeNewsPublished(Builder $query): Builder
    {
        return $query->news()->published();
    }

    public function scopeGalleryPublished(Builder $query): Builder
    {
        return $query->gallery()->published();
    }

    public function recordView(): void
    {
        $this->increment('views_count');
    }
}
