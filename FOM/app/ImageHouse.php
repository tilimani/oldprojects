<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageHouse extends Model
{
    protected $table = 'image_houses';

    protected $fillable = [
        'image',
        'priority',
        'description'
    ];

    public function house(){
    	return $this->belongsTo(House::class);
    }
}
