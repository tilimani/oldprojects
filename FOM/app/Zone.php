<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected  $fillable = [
        'name'
    ];

    public function neighborhoods()
    {
        return $this->hasManyThrough(Neighborhood::class, Location::class);
    }

    public function locations()
    {
    	return $this->hasMany(Location::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
