<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'color',
        'description',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    protected static function booted()
    {
        static::creating(function (Category $category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function (Category $category) {
            $original = $category->getOriginal('slug');
            if ($original && $original !== $category->slug) {
                Category::where('slug', $original)->update(['slug' => $category->slug]);
            }
        });
    }

    /**
     * Posts belong to this category (many-to-many).
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_categories');
    }
}
