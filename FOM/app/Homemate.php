<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Homemate extends Model
{
    protected $table = 'homemates';

    protected $fillable = [
        'name',
        'profession',
        'gender',
    ];

    public function room(){
    	return $this->belongsTo(Room::class);
    }

    public function country(){
    	return $this->belongsTo(Country::class);
    }
}
