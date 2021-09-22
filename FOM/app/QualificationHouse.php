<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QualificationHouse extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'qualification_houses';

    //MassAssignmentException
    protected $fillable = [
      'experience', 
      'data', 
      'devices', 
      'wifi', 
      'bath', 
      'roomies', 
      'loudparty', 
      'recommend', 
      'house_comment', 
      'fom_comment'
    ];

    public function booking(){
    	return $this->belongsTo(Booking::class, 'bookings_id');
    }

    public function averageHouse(){
      return $this->hasOne(AverageHouses::class);
    }
}
