<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferralUse extends Model
{
    public function vicoReferral()
    {
    	return $this->belongsTo(VicoReferral::class, 'vico_referral_id');
    }

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }
}
