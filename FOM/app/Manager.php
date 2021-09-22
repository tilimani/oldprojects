<?php

namespace App;
use App\Users;
use App\Houses;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    protected $table = 'managers';

        protected $fillable = [
            'vip',
            'user_id',
            'house_id'
        ];

    public function user(){
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function houses(){
    	return $this->hasMany(House::class);
    }

    public function imagesHouses()
    {
        return $this->hasManyThrough(ImageHouse::class, House::class);
    }

    public function housesCoordinates()
    {
        return $this->hasManyThrough(Coordinate::class, House::class);
    }

    public function favorites()
    {
        return $this->hasManyThrough(Favorite::class, House::class);
    }

    public function averagesHouses()
    {
        return $this->hasManyThrough(AverageHouses::class, House::class);
    }

}
