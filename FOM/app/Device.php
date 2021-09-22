<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $table = 'devices';

    protected $fillable = [
        'name',
        'icon',
    ];
    public function houses(){
    	return $this->belongsToMany(House::class,'device_houses','house_id','device_id');
    }
}
