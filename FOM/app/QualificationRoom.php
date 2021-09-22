<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QualificationRoom extends Model
{
  /**
    * The table associated with the model.
    *
    * @var string
    */
  protected $table = 'qualification_rooms';

  //MassAssignmentException
  protected $fillable =[
    'general', 
    'loud', 
    'data', 
    'wifi'
  ];

  public function booking(){
    return $this->belongsTo(Booking::class, 'bookings_id');
  }

  public function averageRoom(){
    return $this->hasOne(AverageRooms::class);
  }
}
