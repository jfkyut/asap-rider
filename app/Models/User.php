<?php

namespace App\Models;

use App\Models\Delivery\DeliveryFeedback;
use App\Models\Pasuyo\Pasuyo;
use App\Models\PickAndDrop\PickAndDrop;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable // implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'face_verified_at',
        'email_verified_at',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function pasuyos()
    {
        return $this->hasMany(Pasuyo::class);
    }

    public function pickAndDrops()
    {
        return $this->hasMany(PickAndDrop::class);
    }

    public function deliveries()
    {
        return $this->hasMany(\App\Models\Delivery\Delivery::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(\App\Models\Subscription\Subscription::class, 'user_id');
    }

    public function isSubscriber()
    {
        $subscription = $this->subscriptions()->latest()->first();

        if ($subscription && $subscription->end_date >= now()) {
            return true;
        }

        return false;
    }

    public function currentSubscription()
    {
        return $this->subscriptions()->latest()->first();
    }

    public function consumedTrialPlan()
    {
        $subscription = $this->subscriptions()->whereHas('plan', function ($query) {
            $query->where('name', 'Trial Plan');
        })->first();

        return $subscription !== null;
    }

    // attachments relationship
    public function attachments()
    {
        return $this->hasMany(UserAttachment::class);
    }

    public function deliveryFeedbacks()
    {
        return $this->hasMany(DeliveryFeedback::class, 'user_id');
    }
}
