<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'nip',
        'position',
        'photo',
        'bio',
        'education',
        'contact',
        'is_active',
        'is_principal',
        'designation',
        'order',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'is_principal' => 'boolean',
    ];

    /**
     * Get the principal of the school.
     */
    public static function getPrincipal(): ?self
    {
        return static::where('is_principal', true)->first();
    }

    /**
     * Scope: only principals.
     */
    public function scopePrincipal($query)
    {
        return $query->where('is_principal', true);
    }
}
