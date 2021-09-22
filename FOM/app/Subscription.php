<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    Protected $table = 'verifications';

    protected $fillable =[
        'user_id',
        'name',
        'stripe_id',
        'stripe_plan',
        'quantity',
        'trial_ends_at',
        'ends_at'
    ];

    public function user(){
    	return $this->belongsTo(User::class, 'user_id');
    }
}
