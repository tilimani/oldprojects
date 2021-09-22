<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table = 'favorites';

    protected $fillable = [''];

    public function house(){
    	return $this->belongsTo(House::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }
}
