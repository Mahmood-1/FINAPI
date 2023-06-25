<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;
    public $table = 'foods';

    public $fillable = [
        'name',
        'image',
        'desc',
    ];

    public function meals() {
        return $this->hasMany(FoodMeal::class);
    }
}
