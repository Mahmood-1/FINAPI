<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymPrice extends Model
{
    use HasFactory;

    public $table = 'gym_prices';

    public function gym() {
        return $this->belongsTo(Gym::class);
    }
}
