<?php

namespace App\Models\Delivery;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class DeliveryFeedback extends Model
{
    protected $fillable = [
        'comment',
        'star_count',
        'delivery_id',
        'user_id'
    ];

    public function delivery()
    {
        return $this->belongsTo(Delivery::class, 'delivery_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
