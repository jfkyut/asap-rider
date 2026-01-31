<?php

namespace App\Models\Plan;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'price',
        'description',
        'duration'
    ];
}
