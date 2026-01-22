<?php

namespace App\Models\PickAndDrop;

use Illuminate\Database\Eloquent\Model;

class PickAndDropTracking extends Model
{
    protected $fillable = [
        'pick_and_drop_id',
        'status_update',
    ];
}
