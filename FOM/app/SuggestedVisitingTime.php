<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuggestedVisitingTime extends Model
{
    public function booking()
    {
        return $this->belongsTo(Booking::class);     
    }
}
