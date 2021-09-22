<?php

namespace App;

use app\Device;
use app\House;
use Illuminate\Database\Eloquent\Model;

class DeviceHouse extends Model
{
    protected $table = 'device_houses';
    
    protected $fillable = [
        'house_id',
        'device_id'
    ];
}
