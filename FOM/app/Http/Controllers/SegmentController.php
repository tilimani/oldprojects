<?php

namespace App\Http\Controllers;

use App\Booking;
use App\House;
use App\Room;
use App\User;
use Segment as Analytics;

class SegmentController extends Controller
{
    static public function initSegment()
    {
        Analytics::init(env('SEGMENT_WRITE_KEY'));
    }

    public static function signedUpEvent(User $user)
    {
        self::initSegment();
        Analytics::track(array(
            "userId" => $user->id,
            "event" => "Signed Up",
            "properties" => array(
                "type" => "organic",
                "category" => "Main stream",
                "role" => $user->role_id
            )
        ));
    }
    
    public static function bookingCompleted(User $manager, User $user, Booking $booking, Room $room)
    {
        self::initSegment();
        Analytics::track(array(
            "userId" => $manager->id,
            "event" => "Booking Complete/Manager",
            "properties" => array(
                "category" => "Main stream",
                "bookingId" => $booking->id,
                "userId" => $manager->id,
                "houseId" => $booking->Room->House->id,
                "roomId" => $booking->Room->id,
                "roomPrice" => $room->price
            )
        ));

        Analytics::track(array(
            "userId" => $user->id,
            "event" => "Booking Complete/User",
            "properties" => array(
                "category" => "Main stream",
                "bookingId" => $booking->id,
                "managerId" => $manager->id,
                "houseId" => $booking->Room->House->id,
                "roomId" => $booking->Room->id,
                "roomPrice" => $room->price
            )
        ));
    }

    public static function addHouseToFavorites(User $user, House $house)
    {
        self::initSegment();
        Analytics::track(array(
            "userId" => $user->id,
            "event" => "Add favorites",
            "properties" => array(
                "category" => "Main stream",
                "houseId"=> $house->id,
                "houseCity"=> $house->Neighborhood->Location->Zone->City->name,
                "managerId"=> $house->Manager->first()->User->id
            )
        ));
    }

    public static function removeHouseFromFavorites(User $user, House $house)
    {
        self::initSegment();
        Analytics::track(array(
            "userId" => $user->id,
            "event" => "Remove favorites",
            "properties" => array(
                "category" => "Main stream",
                "houseId"=> $house->id,
                "houseCity"=> $house->Neighborhood->Location->Zone->City->name,
                "managerId"=> $house->Manager->first()->User->id
            )
        ));
    }

    public static function houseUploaded(User $manager, House $house)
    {
        self::initSegment();
        Analytics::track(array(
            "userId" => $manager->id,
            "event" => "House upload",
            "properties" => array(
                "category" => "Main stream",
                "room_quantity" => $house->room_quantity,
                "city" => $house->neighborhood->location->zone->city->name,
                "country" => $house->neighborhood->location->zone->city->country->name
            )
        ));        
    }

    public static function newBookingEvent(User $user, User $manager, Booking $booking, Room $room)
    {
        self::initSegment();
        Analytics::track(array(
            "userId" => $user->id,
            "event" => "Booking Created",
            "properties" => array(
                "category" => "Main stream",
                "bookingId" => $booking->id,
                "managerId" => $manager->id,
                "houseId" => $booking->Room->House->id,
                "roomId" => $booking->Room->id,
                "roomPrice" => $room->price
            )
        ));

        Analytics::track(array(
            "userId" => $manager->id,
            "event" => "Booking received",
            "properties" => array(
                "category" => "Main stream",
                "bookingId" => $booking->id,
                "userId" => $user->id,
                "houseId" => $booking->Room->House->id,
                "roomId" => $booking->Room->id,
                "roomPrice" => $room->price
            )
        ));
    }

    public static function contractDownloaded(Booking $booking, User $user)
    {
        self::initSegment();
        Analytics::track(array(
        "userId" => $user->id,
        "event" => "Contract Downloaded",
        "properties" => array(
            "category" => "User knowlage",
            "bookingId" => $booking->id,
        )
        ));
        
    }
}
