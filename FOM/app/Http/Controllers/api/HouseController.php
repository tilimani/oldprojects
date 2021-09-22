<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\City;
use App\House;
use App\Currency;
use App\Room;
use App\Notifications\BookingNotification;
use App\Http\Controllers\HouseController as base;
use App\Booking;
use Carbon\Carbon;
use App\User;

class HouseController extends Controller
{
    /**
     * Get all houses
     *
     * @return JSON
     */
    public function index()
    {
        $houses = House::where('status', 1)->get();
        $housesIndex = [];
        foreach ($houses as $house) {
            if ($house->coordinates()->first()) {
                $coordinates = $house->coordinates()->first();
                $minPrice = $house->minPrice();
                $maxPrice = $house->maxPrice();

                array_push(
                    $housesIndex,
                    array(
                        'minPrice' =>$minPrice,
                        'maxPrice'=>$maxPrice,
                        'house'=>$house,
                        'coordinates'=>$coordinates
                    )
                );
            }
        }
        return response()->json($housesIndex, 200);
    }

    /**
     * Get all houses given a city
     *
     * @param City $city
     * @return JSON
     */
    public function indexCity($city)
    {
        $city = City::where('name', $city)->first();
        $locations = $city->locations;
        $housesIndex = [];
        foreach ($locations as $location) {
            $houses = $location->houses->where('status', 1);
            if (count($houses) > 0) {
                foreach ($houses as $house) {
                    if ($house->coordinates()->first()) {
                        $coordinates = $house->coordinates()->first();
                        $minPrice = $house->minPrice();
                        $maxPrice = $house->maxPrice();

                        array_push(
                            $housesIndex,
                            array(
                                'minPrice' =>$minPrice,
                                'maxPrice'=>$maxPrice,
                                'house'=>$house,
                                'coordinates'=>$coordinates
                            )
                        );
                    }
                }
            }
        }
        // $houses = House::whereHas('neighborhood.location.zone.city',function($query) use ($city){
        //     $query->where('id',$city->id);
        // })->where('status',1)->get();

        return response()->json($housesIndex, 200);
    }

    /**
     * Get one specific house
     *
     * @param House $house
     * @return JSON
     */
    public function show(House $house)
    {
        return response()->json($house, 200);
    }

    /**
     * Store one house on database
     *
     * @param Request $request
     * @return JSON
     */
    public function store(Request $request)
    {
        $house = House::create($request->all);

        return response()->json($house, 201);
    }

    /**
     * Update one house
     *
     * @param Request $request
     * @param House $house
     * @return JSON
     */
    public function update(Request $request, House $house)
    {
        $house->update($request->all);

        return response()->json($house, 201);
    }

    /**
     * Delete one house
     *
     * @param House $house
     * @return JSON
     */
    public function destroy(House $house)
    {
        $house->delete();

        return response()->json(null, 204);
    }

    /**
     * Get all House's Coordinates
     *
     * @return JSON
     */
    public function allCoordinates()
    {
        $houses = House::where('status', 1)->get();
        $houseCoordinates = [];
        foreach ($houses as $house) {
            $coordinate = $house->coordinates()->first();
            if ($coordinate) {
                array_push($houseCoordinates, $coordinate);
            }
        }
        return response()->json($houseCoordinates, 200);
    }

    /**
     * Get all House's Coordinates given a city
     *
     * @param City $city
     * @return JSON
     */
    public function cityCoordinates(City $city)
    {
        $houses = House::where('city_id', $city->id)->get();
        $houseCoordinates = [];
        foreach ($houses as $house) {
            $coordinate = $house->coordinates()->first();
            if ($coordinate) {
                array_push($houseCoordinates, $coordinate);
            }
        }
        return response()->json($houseCoordinates, 200);
    }


    public function getHouses(Booking $booking)
    {
        $manager = $booking->manager();

        $houses = $manager->houses;

        return response()->json($houses, 200);
    }

    public function getHousesByManager(User $user){
        $role = $user->role_id;
        if($role == 1){
            $houses = House::all();
        }else if($role == 2){
            $houses = $user->houses;
        }
        return response()->json($houses,200);
    }

    public function getHouseRooms(House $house)
    {
        $rooms = array();
        foreach ($house->rooms as $room) {
            $room->available_from = Carbon::parse($room->available_from)->format('y-m-d');
            array_push($rooms, $room);
        }
        return response()->json($rooms, 200);
    }

    public function changeBookingHouse(Request $request)
    {
        $booking = Booking::find($request->booking_id);
        
        $bookingRoom = $booking->room;

        $booking->status = 1;

        $room = Room::find($request->room_id);

        $booking->room()->associate($room);

        $booking->save();

        $room->available_from = $booking->date_to;
        
        $room->save();

        $bookingRoom->available_from = now()->addDay(-1);

        $bookingRoom->save();

        $user = $booking->user;

        $manager = $booking->manager();

        $user->notify(new BookingNotification($booking));
        $manager->notify(new BookingNotification($booking));

        return response()->json('ok', 200);

    }

    public function sendChangeRoomNotification(Request $request){
        $booking = Booking::find($request->booking_id);

        $bookingRoom = $booking->room;

        $room = Room::find($request->room_id);

        $booking->room()->associate($room);

        $booking->status = 2;

        $booking->save();

        $user = $booking->user;

        $manager = $booking->manager();

        $user->notify(new BookingNotification($booking));
        $manager->notify(new BookingNotification($booking));

        $booking->room()->associate($bookingRoom);
        // $bookingRoom->available_from = now();
        // $bookingRoom->save();
        $booking->save();
    }

    public function denyRoomChange(Request $request){
        $booking = Booking::find($request->booking_id);

        $booking->status = -23;

        $booking->save();

        $user = $booking->user;
        $manager = $booking->manager();

        $user->notify(new BookingNotification($booking));
        $manager->notify(new BookingNotification($booking));
    }


    public function landingpageHouses(String $flag)
    {
        switch ($flag) {
            case 'med': 
            $houses = House::findMany([258, 208, 308, 195, 220]);
            $response = array();
            foreach ($houses as $house) {
                $price = $house->minPrice();
                $images = $house->ImageHouses;

                array_push($response, collect([
                    'name' => $house->name,
                    'price' => $price,
                    'images'    =>  $images,
                    'id'    =>  $house->id
                ]));
            }


            return response()->json($response);
            
            case 'bog': 
            $houses = House::findMany([327, 421, 356, 332, 437]);
            $response = array();
            foreach ($houses as $house) {
                $price = $house->minPrice();
                $images = $house->ImageHouses;

                array_push($response, collect([
                    'name' => $house->name,
                    'price' => $price,
                    'images'    =>  $images,
                    'id'    =>  $house->id
                ]));
            }


            return response()->json($response);


        }
    }
}
