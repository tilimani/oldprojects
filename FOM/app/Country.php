<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

	protected $table = 'countries';

    //MassAssignmentException
    protected $fillable = [
        'name',
        'icon'
    ];

    public function cities()
    {
        return $this->hasMany(City::class, 'country_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function homemates()
    {
        return $this->hasMany(Homemate::class);
    }

    public function zones()
    {
        return $this->hasManyThrough(Zone::class,City::class);
    }

    public function favorites()
    {
        return $this->hasManyThrough(Favorite::class, User::class);
    }
}
