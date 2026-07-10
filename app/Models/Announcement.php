<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'valid_from',
        'valid_until',
        'is_pinned',
        'is_active',
        'author_id',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_active' => 'boolean',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where(function ($q) {
                         $q->whereNull('valid_from')
                           ->orWhere('valid_from', '<=', now());
                     })
                     ->where(function ($q) {
                         $q->whereNull('valid_until')
                           ->orWhere('valid_until', '>=', now());
                     });
    }
}
