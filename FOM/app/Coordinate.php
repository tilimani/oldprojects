<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Coordinate extends Model
{
	protected $table = 'coordinates';

	protected $fillable = ['lat', 'lng', 'house_id'];

    public function house(){
    	return $this->belongsTo(House::class);
    }
}
