<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;


class Invitation extends Model
{
    use Notifiable;
    
    public $incrementing = false;
    
    protected $fillable = ['expiration_date','room_id','booking_id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invitation) {
            $invitation->{$invitation->getKeyName()} = (string) Str::uuid();
        });
    }

    public function booking(){
        return $this->belongsTo(Booking::class);
    }

    public function room(){
        return $this->belongsTo(Room::class);
    }
}
