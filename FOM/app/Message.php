<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{   
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'messages';

    protected $fillable = [
        'message',
        'status',
        'destination',
        'read',
        'bookings_id'
    ];

    public function booking(){
    	return $this->belongsTo(Booking::class, 'bookings_id');
    }
}
