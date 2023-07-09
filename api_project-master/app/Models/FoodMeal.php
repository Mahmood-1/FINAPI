<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodMeal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'desc',
        'food_id'
    ];

    public function food()
    {
        return $this->belongsTo(Food::class, 'food_id');
    }
}
