<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageRoom extends Model
{
    protected $table = 'image_rooms';

    protected $fillable = [
        'image',
        'priority',
        'description'
    ];
    
    public function room(){
    	return $this->belongsTo(Room::class);
    }
}
