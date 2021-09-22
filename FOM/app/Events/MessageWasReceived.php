<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\User;
use App\Booking;

class MessageWasReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public $id;

    public $flag;

    public $booking;

    public $user;
    /**
     * Create a new event instance.
     *
     * @return void
     */

    public function __construct($message, $id, $flag, Booking $booking)
    {
        $this->id = $id;
        $this->message = $message;
        $this->flag = $flag;
        $this->booking = $booking;
        $this->user = $booking->user;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getBookingId()
    {
        return $this->id;
    }

    public function getFlag()
    {
        return $this->flag;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('BookingMessageChannel.'.$this->booking->id);
    }
}
