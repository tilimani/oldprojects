<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AverageNeighborhood extends Model
{
  protected $table = 'average_neighborhoods';

  protected $fillable = [
    'global',
    'general',
    'access',
    'shopping',
    'neighborhood_id'
  ];

  public function neighborhood()
  {
    return $this->belongsTo(Neighborhood::class);
  }

}
