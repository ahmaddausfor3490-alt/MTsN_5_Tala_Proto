<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'role',
        'avatar',
        'text',
        'rating',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'rating'    => 'integer',
    ];
}
