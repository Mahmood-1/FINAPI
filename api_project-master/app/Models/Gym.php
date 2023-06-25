<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gym extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'image',
        'desc',
        'location'
    ];

    public function prices() {
        return $this->hasMany(GymPrice::class);
    }
}
