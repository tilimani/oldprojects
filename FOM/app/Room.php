<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';

    protected $fillable = [
        'number',
        'description',
        'price',
        'available_from',
        'price_for_two',
        'nickname'
    ];

    public function imageRooms()
    {
    	return $this->hasMany(ImageRoom::class);
    }

    public function images()
    {
        return $this->hasMany(ImageRoom::class)->orderBy('priority');
    }

    public function homemates()
    {
    	return $this->hasMany(Homemate::class);
    }

    public function devicesRooms()
    {
    	return $this->hasMany(DevicesRoom::class);
    }

    public function bookings()
    {
    	return $this->hasMany(Booking::class);
    }

    public function house()
    {
    	return $this->belongsTo(House::class, 'house_id');
    }

    public function averageRooms()
    {
        return $this->hasMany(AverageRooms::class);
    }
}
