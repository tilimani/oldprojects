<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QualificationNeighborhood extends Model
{

  /**
    * The table associated with the model.
    *
    * @var string
    */
  protected $table = 'qualification_neighborhoods';

  //MassAssignmentException
  protected $fillable = [
    'general', 
    'access', 
    'shopping', 
  ];

  public function booking(){
    return $this->belongsTo(Booking::class, 'bookings_id');
  }

  public function averageNeighborhood(){
    return $this->hasOne(AverageNeighborhood::class);
  }
}
