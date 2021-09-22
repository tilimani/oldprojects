<?php

namespace App\Events;

use App\Room;
use App\House;
use App\Booking;
use App\Manager;
use App\User;
use App\Verification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageWasSended
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $booking;
    public $destination;
    public $room;
    public $house;
    public $manager;
    public $user;
    public $image_house;
    public $booking_id;
    public $verification;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($booking_id,$destination)
    {
        $booking = Booking::find($booking_id);
        $room = Room::find($booking->room_id);
        $house = House::find($room->house_id);
        $manager = Manager::find($house->manager_id);
        $manager = User::find($manager->user_id);
        $user = User::find($booking->user_id);

        $image_house = DB::table('image_houses')
                          ->select('image_houses.image')
                          ->where('image_houses.house_id','=',$house->id)
                          ->orderBy('priority')
                          ->first();// get house's image
        // $verification = session()->get('verification');
        $verification = Verification::firstOrCreate(
            ['user_id' => ($destination == 1)? $manager->id :$user->id ],
            [
                'user_id' => ($destination == 1)? $manager->id :$user->id ,
                'facebook' => false,
                'google' => false,
                'email' => 1,
            ]
        );

        $this->destination = $destination;
        $this->booking = $booking;
        $this->room = $room;
        $this->house = $house;
        $this->manager = $manager;
        $this->user = $user;
        $this->image_house = (isset($image_house)) ? $image_house->image : 'room_4.jpeg';
        $this->verification = $verification;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('channel-name');
    }
}
