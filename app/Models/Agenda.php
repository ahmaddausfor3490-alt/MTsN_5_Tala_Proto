<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agenda extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'event_date',
        'event_time',
        'location',
        'description',
        'category',
        'image',
        'is_recurring',
        'recurrence_pattern',
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_recurring' => 'boolean',
    ];

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now()->toDateString())
                     ->orderBy('event_date', 'asc');
    }
}
