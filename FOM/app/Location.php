<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
	protected $table = 'locations';

    //MassAssignmentException
    protected $fillable = [
        'name',
        'zone_id'
    ];

    public function neighborhoods()
    {
        return $this->hasMany(Neighborhood::class, 'location_id');
    }

    public function typeInterestPoints()
    {
        return $this->hasMany(TypeInterestPoint::class);
    }


    public function averagesNeighborhoods()
    {
        return $this->hasManyThrough(AverageNeighborhood::class, Neighborhood::class);
    }

    public function interestPoints()
    {
        return $this->hasManyThrough(InterestPoint::class, Neighborhood::class);
    }

    public function houses()
    {
        return $this->hasManyThrough(House::class, Neighborhood::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }
}
