<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DevicesRoom extends Model
{
    protected $table = 'devices_rooms';

    protected $fillable = [
        'bed_type',
        'bath_type',
        'desk',
        'window_type',
        'tv',
        'closet'
    ];

    public function room(){
        return $this->belongsTo(Room::class);
    }
}
