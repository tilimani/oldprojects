<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'schools';

    //MassAssignmentException
    protected $fillable =[
        'name',
        'prefix',
        'lat',
        'lng'
    ];

    public function neighborhoods()
    {
    	return $this->belongsToMany(Neighborhood::class, 'neighborhood_schools');
    }

}
