<?php

namespace App\Models\Delivery;

use Illuminate\Database\Eloquent\Model;

class DeliveryTracking extends Model
{
    protected $fillable = [
        'status_update',
        'delivery_id',
    ];

    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }
}
