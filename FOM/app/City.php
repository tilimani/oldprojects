<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{

	protected $table = 'cities';

    //MassAssignmentException
    protected $fillable = [
        'name',
        'country_id',
        'city_code'
    ];

    public function zones()
    {
        return $this->hasMany(Zone::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function neighborhoods()
    {
        return $this->hasManyThrough(Neighborhood::class, Zone::class);
    }

    public function locations()
    {
        return $this->hasManyThrough(Location::class, Zone::class);
    }

    public function specificInterestPoints()
    {
        return $this->belongsToMany(SpecificInterestPoint::class, 'cities_specific_interest_points');
    }

    public function isAvailable()
    {
        return $this->available === 1;
    }
}
