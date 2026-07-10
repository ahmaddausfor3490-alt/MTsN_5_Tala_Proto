<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'label',
        'value',
        'type',
        'description',
        'options',
    ];

    protected $casts = [
        'value' => 'string',
    ];
}
