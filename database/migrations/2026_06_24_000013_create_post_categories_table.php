<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Post_categories pivot table linking posts ↔ categories (many-to-many).
     */
    public function up(): void
    {
        Schema::create('post_categories', function (Blueprint $table) {
            // Reference 'news' table (which will be renamed to 'posts' in migration 000014)
            $table->foreignId('post_id')->constrained('news')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->primary(['post_id', 'category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_categories');
    }
};
