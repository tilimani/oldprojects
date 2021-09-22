<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AverageRooms extends Model
{
  protected $table = 'average_rooms';
  
  protected $fillable = [
    'global',
    'room_id',
    'general',
    'loud',
    'data',
    'wifi'
  ];

  public function room()
  {
    return  $this->belongsTo(Room::class);
  }

}
