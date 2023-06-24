<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    public $fillable = [
    	'name',
    	'image'
    ];

    public $dates = ['created_at', 'updated_at'];

    public function users() {
    	return $this->belongsToMany(User::class);
    }
}
