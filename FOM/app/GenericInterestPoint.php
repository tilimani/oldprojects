<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GenericInterestPoint extends Model
{
    protected $table = 'generic_interest_points';

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
}
