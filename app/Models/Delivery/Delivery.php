<?php

namespace App\Models\Delivery;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = [
        'type',
        'pasuyo_id',
        'pick_and_drop_id',
        'status',
        'user_id',
    ];

    public function pasuyo()
    {
        return $this->belongsTo(\App\Models\Pasuyo\Pasuyo::class);
    }

    public function pickAndDrop()
    {
        return $this->belongsTo(\App\Models\PickAndDrop\PickAndDrop::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function trackings()
    {
        return $this->hasMany(DeliveryTracking::class);
    }
}
