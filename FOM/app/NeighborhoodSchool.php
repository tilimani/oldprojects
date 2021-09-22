<?php

namespace App;

use App\Neighborhood;
use App\School;
use Illuminate\Database\Eloquent\Model;

class NeighborhoodSchool extends Model
{
    protected $table = 'neighborhood_schools';

    protected $fillable = [
        'neighborhood_id',
        'school_id'
    ];

    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class);
    }

    public function school(){
        return $this->belongsTo(School::class);
    }
}
