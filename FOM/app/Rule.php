<?php

namespace App;

use app\House;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $table = 'rules';

    protected $fillable = [
        'name',
        'icon',
        'icon_span'
    ];

    public function houses(){
    	return $this->belongsToMany(House::class,'houses_rules','rule_id','house_id');
    }
}
