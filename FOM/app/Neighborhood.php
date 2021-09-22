<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Neighborhood extends Model
{

	protected $table = 'neighborhoods';

    //MassAssignmentException
    protected $fillable = [
        'name',
        'location_id',
        'zone_id'
    ];

    public function houses()
    {
        return $this->hasMany(House::class, 'neighborhood_id');
    }

    public function schools()
    {
        return $this->belongsToMany(School::class, 'neighborhood_schools');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function interestPoints()
    {
        return $this->hasMany(InterestPoint::class, 'neighborhood_id');
    }

    public function averageNeighborhoods()
    {
        return $this->hasMany(AverageNeighborhood::class);
    }

    public function averagesHouses()
    {
        return $this->hasManyThrough(AverageHouses::class, House::class);
    }

    public function houseCoordinates()
    {
        return $this->hasManyThrough(Coordinate::class, House::class);
    }

    public function favorites()
    {
        return $this->hasManyThrough(Favorite::class, House::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }
}
