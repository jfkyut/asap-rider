<?php

namespace App\Models\PickAndDrop;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PickAndDrop extends Model
{
    protected $fillable = [
        'sender_location',
        'sender_location_coordinates',
        'sender_full_name',
        'sender_phone',
        'sender_note',
        'receiver_location',
        'receiver_location_coordinates',
        'receiver_full_name',
        'receiver_phone',
        'receiver_note',
        'item_description',
        'status',
        'payment_method',
        'user_id',
    ];

    public function trackings()
    {
        return $this->hasMany(PickAndDropTracking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
