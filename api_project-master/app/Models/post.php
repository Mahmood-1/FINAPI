<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    use HasFactory;

    public $fillable = [
        'title',
        'body',
        'image',
        'video',
        'audio',
        'category',
        'gender',
        'youtube',
    ];
}
