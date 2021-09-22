<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Habitant extends Model
{
    protected $table = 'habitants';

    protected $fillable = [];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function bookings()
    {
    	return $this->hasMany(Homemate::class);
    }
}
