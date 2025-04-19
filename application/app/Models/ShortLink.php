<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'expires_at',
        'slug',
    ];

    protected $hidden = [];

    protected $casts = [
        'url' => 'string',
        'expires_at' => 'datetime',
        'slug' => 'string'
    ];
}
