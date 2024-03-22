<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'is_publishing',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];
}
