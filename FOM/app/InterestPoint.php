<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InterestPoint extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	 protected $table = 'interest_points';

     //MassAssignmentException
     protected $fillable = [
         'name',
         'lat',
         'lng',
         'neighborhood_id',
         'type_interest_point_id'
        ];

    public function typeInterestPoint(){
    	return $this->belongsTo(TypeInterestPoint::class);
    }

    public function neighborhood(){
    	return $this->belongsTo(Neighborhood::class);
    }
}
