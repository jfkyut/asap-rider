<?php

namespace App\Models\Pasuyo;

use App\Models\User;
use App\Models\Job\Job;
use App\Models\Pasuyo\PasuyoTracking;
use Illuminate\Database\Eloquent\Model;

class Pasuyo extends Model
{
    protected $fillable = [
        'location',
        'location_coordinates',
        'landmark_location',
        'landmark_location_coordinates',
        'full_name',
        'phone',

        'location_details',
        'note',
        
        'content',
        'budget',
        'status',
        'payment_method',
        'user_id',
    ];

    public function attachments()
    {
        return $this->hasMany(PasuyoAttachment::class);
    }

    public function trackings()
    {
        return $this->hasMany(PasuyoTracking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function delivery()
    {
        return $this->hasOne(\App\Models\Delivery\Delivery::class);
    }
}
