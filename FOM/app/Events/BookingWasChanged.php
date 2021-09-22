<?php

namespace App\Events;

use Carbon\Carbon;
use App\Room;
use App\House;
use App\Booking;
use Illuminate\Support\Facades\DB;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Booking was changed class
 * @category Content
 * @package  Contet
 * @author Name <email@email.com>
 * @license asd
 * @link  http://url.com
 *
 */

class BookingWasChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $booking, $manager, $manager_id, $user, $room, $house, $image_room;
    /**
     * Create a new event instance.
     * @param Booking $booking Booking changed
     * @return void
     * @author Andrés Cano <andresfe98@gmail.com>
     */
    public function __construct($booking)
    {

        // $this->booking = $booking->get()->first();

        // $this->room = $this->booking->room()->get()->first();

        // $this->house =$this->room->house()->get()->first();

        // $this->manager = $this->house->manager()->get()->first();

        // $this->manager_id = $this->manager->id;

        // $this->user = $this->booking->user()->get()->first();

        // $this->image_room = $this->room->imageRooms()->get();

        // if ($this->image_room) {

        //     $this->image_room = 'room_4.jpeg';

        // } else {

        //     $this->image_room = $this->image_room[0]->image;

        // }
        $this->booking = $booking;

        $id = DB::table('rooms')->select('houses.manager_id')
            ->join('houses', 'houses.id', '=', 'rooms.house_id')
            ->where('rooms.id', '=', $booking->room_id)
            ->first(); //get id of house's manager

        $manager = DB::table('managers')
            ->select('users.id', 'users.name', 'users.last_name', 'users.email', 'users.image', 'users.phone')
            ->join('users', 'users.id', '=', 'managers.user_id')
            ->where('managers.id', '=', $id->manager_id)
            ->first(); // get house's manager info


        $user = DB::table('bookings')->select('users.gender', 'users.image', 'users.email', 'users.name', 'users.id', 'users.last_name', 'countries.name as country_name', 'users.phone')
            ->where('bookings.id', '=', $booking->id)
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->join('countries', 'countries.id', '=', 'users.country_id')
                    // ->join()
            ->first();// get booking's user info

        $room = Room::findOrFail($booking->room_id); //get booking's room info
        $house = House::findOrFail($room->house_id); //get room's house info

        $image_room = DB::table('image_rooms')
            ->select('image_rooms.image')
            ->where('image_rooms.room_id', '=', $room->id)
            ->orderBy('priority')
            ->get();// get room's image

        $this->manager = $manager;
        $this->user = $user;
        $this->room = $room;
        $this->house = $house;

        if (sizeof($image_room) < 1) {

            $this->image_room = 'room_4.jpeg';

        } else {

            $this->image_room = $image_room[0]->image;

        }
    }

    /**
     * Undocumented function
     *
     * @param [type] $name
     * @return void
     */
    public function __get($name)
    {
        return $this->name;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
