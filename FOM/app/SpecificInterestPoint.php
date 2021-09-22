<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecificInterestPoint extends Model
{
    protected $table = 'specific_interest_points';

    protected $fillable = [
        'name',
        'description',
        'lat',
        'lng',
        'icon'
    ];

    public function houses()
    {
        return $this->morphToMany(House::class, 'interestable');
    }

    public function cities()
    {
        return $this->belongsToMany(City::class, 'cities_specific_interest_points');
    }
}
