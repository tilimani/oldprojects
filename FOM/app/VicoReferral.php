<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VicoReferral extends Model
{
    protected $table = 'vico_referrals';

    protected $fillable = [
        'id',
        'code',
        'user_id',
        'expiration_date',
        'type',
        'amount_usd',
        'payout',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'vico_referral_id');
    }

    public function referralsCountSuccess()
    {
        return $this->bookings()->where('status','>','4');
    }

    public function referralsCountUsed()
    {
        return $this->hasMany(Booking::class);
    }

    public function referralsCountActive()
    {
        return $this->bookings()->where('status','=','5');
    }

    public function referralsUses()
    {
        return $this->hasMany(ReferralUse::class);
    }
}
