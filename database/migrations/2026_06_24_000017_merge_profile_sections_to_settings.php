<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Replace profile_sections with settings rows for school profile & vision mission.
     *
     * Data preserved → settings key mapping:
     *   ProfileSection slug "sejarah-madrasah"  → settings.key "school.sejarah"
     *   ProfileSection slug "visi-misi"         → settings.key "school.vision"
     *                                               settings.key "school.mission"
     *
     * DESTRUCTIVE: Drops profile_sections table. Its data is migrated to settings.
     */
    public function up(): void
    {
        $sections = DB::table('profile_sections')->get();
        $mapped = [];

        foreach ($sections as $section) {
            $slug = $section->slug;

            if ($slug === 'sejarah-madrasah') {
                DB::table('settings')->upsert([
                    [
                        'key'         => 'school.sejarah',
                        'value'       => $section->content,
                        'type'        => 'textarea',
                        'description' => 'Sejarah singkat madrasah',
                    ],
                ], ['key']);
                $mapped[] = $slug;
            } elseif ($slug === 'visi-misi') {
                DB::table('settings')->upsert([
                    [
                        'key'         => 'school.vision',
                        'value'       => $section->content,
                        'type'        => 'textarea',
                        'description' => 'Visi madrasah',
                    ],
                    [
                        'key'         => 'school.mission',
                        'value'       => '',
                        'type'        => 'textarea',
                        'description' => 'Misi madrasah (comma-separated lines)',
                    ],
                ], ['key']);
                $mapped[] = $slug;
            }
        }

        Schema::dropIfExists('profile_sections');
    }

    public function down(): void
    {
        Schema::create('profile_sections', function ($table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('slug')->unique();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
