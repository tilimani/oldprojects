<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingDate extends Model
{
    protected $fillable = ['id','booking_id', 'user_date', 'manager_date','vico_date','validation'];
    public function booking(){
    	return $this->belongsTo(Booking::class, 'booking_id');
    }
}
