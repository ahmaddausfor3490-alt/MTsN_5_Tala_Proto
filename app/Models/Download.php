<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Download extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'file_path',
        'file_type',
        'category',
        'file_size',
        'download_count',
        'is_active',
        'uploaded_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function incrementDownloads(): void
    {
        $this->increment('download_count');
    }
}
