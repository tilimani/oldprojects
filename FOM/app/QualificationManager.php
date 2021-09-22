<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QualificationManager extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'qualification_managers';

  //MassAssignmentException
  protected $fillable = [
    'clean',
    'communication',
    'rules',
    'public_comment',
    'private_comment',
    'fom_comment',
    'bookings_id'
  ];

  public function booking(){
    return $this->belongsTo(Booking::class, 'bookings_id');
  }
}
