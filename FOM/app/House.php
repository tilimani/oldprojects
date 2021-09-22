<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

    class House extends Model
    {
    protected $table = 'houses';

    protected $fillable = [
        'name',
        'address',
        'description_house',
        'description_zone',
        'rooms_quantity',
        'type',
        'video',
        'status',
        'neighborhood_id'
    ];
    /**
     * Return all rooms of a House instance
    * @test ok
    */
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    /**
     * Return all rooms of a House instance
    * @test ok
    */
    public function customRules()
    {
        return $this->hasMany(CustomRule::class);
    }

    /**
     * Return all House images of a House instance
    * @test ok
    */
    public function imageHouses()
    {
        return $this->hasMany(ImageHouse::class);
    }

    /**
     * Return the coordinates of a House instance
    * @test ok
    */
    public function coordinates()
    {
        return $this->hasOne(Coordinate::class);
    }

    /**
     * Return all devices of a House instance
    * @test ok
    */
    public function devices()
    {
        return $this->belongsToMany(Device::class, 'device_houses', 'device_id', 'house_id');
    }

    /**
     * Return all rules of a House instance
    * @test ok
    */
    public function rules()
    {
        return $this->belongsToMany(Rule::class, 'houses_rules');
    }

    public function house_rules()
    {
        return $this->hasMany(HousesRule::class);
    }

    /**
     * Return all favorite instances of a House instance
    * @test ok
    */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Return the manager of a House instance
    * @test ok
    */
    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }

    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class, 'neighborhood_id');
    }

    /**
     * Return the average qualification of a House instance
    * @test ok
    */
    public function averageHouses()
    {
        return $this->hasOne(AverageHouses::class);
    }

    /**
     * Return all  rooms images of a House instance
    * @test
    */
    public function imagesRooms()
    {
        return $this->hasManyThrough(ImageRoom::class, Room::class);
    }

    /**
     * Return all roomies/homemates of a House instance
    * @test ok
    */
    public function homemates()
    {
        return $this->hasManyThrough(Homemate::class, Room::class);
    }

    /**
     * Return all rooms average of a House instance
    * @test ok
    */
    public function averagesRooms()
    {
        return $this->hasManyThrough(AverageRooms::class, Room::class);
    }

    /**
     * Return all rooms devices of a House instance
    * @test ok
    */
    public function devicesRooms()
    {
        return $this->hasManyThrough(DevicesRoom::class, Room::class);
    }

    /**
     * Return all bookings of a House instance
    * @test ok
    */
    public function bookings()
    {
        return $this->hasManyThrough(Booking::class, Room::class);
    }

    /**
     * return the min or the max price of all rooms on a house instance
    * @param $option: values: 'min' or 'max' accepted
    * @return value: min or max price of all rooms from a house instance
    */
    public function price($option){
        switch($option){
        case 'min':
            $min = $this->rooms->min('price');
            return $min;
        case 'max':
            $max = $this->rooms->max('price');
            return $max;
        }
    }
    /**
     * return the min price of rooms on a house instance
    * @return value: min price of all rooms from a house instance
    */
    public function minPrice()
    {
        $min = $this->rooms->min('price');
        return (int)$min;
    }
    /**
     * return the max price of rooms on a house instance
    * @return value: max price of all rooms from a house instance
    */
    public function maxPrice()
    {
        $max = $this->rooms->max('price');
        return (int)$max;
    }

    /**
     * return count of available rooms in house instance
    * @return value: max price of all rooms from a house instance
    */
    public function availableRooms()
    {
        $available_rooms = $this->rooms()->where('available_from','<=', now())->count();
        return $available_rooms;
    }
    /**
     * return date more close of available rooms in house instance
    * @return value: max price of all rooms from a house instance
    */
    public function minDate()
    {
        $min_date = $this->rooms()->min('available_from');
        return $min_date;
    }
    /**
     * return true if house instance is availabe now
    * @return boolean: true is positive
    */
    public function isAvailable()
    {
        return self::availableRooms() > 0;
    }
    /**
     * return true if house instance has a manager vip
    * @return boolean: true is positive
    */
    public function isVip()
    {
        $manager = $this->manager()->first();
        return $manager->vip >= 1;
    }
    /**
    * return true if house instance is availabe from
    * @param $date: value: date from
    * @return boolean: true is positive
    */
    public function isAvailableFrom($date)
    {
        $available_rooms = $this->rooms()->where('available_from','<=', $date)->count();
        return $available_rooms > 0;
    }
    /**
     * Count the amount of houses on the same neighborhood on this house instance
    * @return int: amount of houses on the same neighborhood
    */
    public function neighborhoodCount()
    {
        return House::where('neighborhood_id', $this->neighborhood->id)->count();
    }

    /**
     * Returns a collection of the house related generic interest points
     *
     * @return GenericInterestPoints     
     **/    
    public function genericInterestPoints()
    {
        return $this->morphedByMany(GenericInterestPoint::class, 'interestable');
    }

    /**
     * Returns a collection of the house related specific interest points
     *
     * @return SpecificInterestPoints     
     **/    
    public function specificInterestPoints()
    {
        return $this->morphedByMany(SpecificInterestPoint::class, 'interestable');
    }

}
