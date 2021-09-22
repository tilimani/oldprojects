<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AverageHouses extends Model
{
    protected $table = 'average_houses';

    protected $fillable = [
      'global',
      'global',
      'experience',
      'data',
      'devices',
      'wifi',
      'bath',
      'roomies',
      'loudparty',
      'house_id'
    ];

    public function house()
    {
      return $this->belongsTo(House::class);
    }

}
