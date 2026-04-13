<?php

namespace App\Models\Delivery;

use Illuminate\Database\Eloquent\Model;

class DeliveryAttachment extends Model
{
    protected $fillable = [
        'delivery_id',
        'file_path',
    ];

    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }
}
