<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodMeal extends Model
{
    use HasFactory;

    public $table = 'food_meals';

    public function food() {
        return $this->belongsTo(Food::class);
    }
}
