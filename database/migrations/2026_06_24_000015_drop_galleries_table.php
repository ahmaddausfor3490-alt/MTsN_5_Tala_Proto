<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Drop standalone galleries table — merged into posts.gallery_images JSON.
     * Data preservation: gallery images migrated to posts in the preceding migration.
     */
    public function up(): void
    {
        Schema::dropIfExists('galleries');
    }

    public function down(): void
    {
        Schema::create('galleries', function ($table) {
            $table->id();
            $table->string('title');
            $table->text('caption')->nullable();
            $table->string('image_path');
            $table->string('album')->default('umum');
            $table->integer('order')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }
};
