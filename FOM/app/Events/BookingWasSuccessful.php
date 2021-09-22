<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BookingWasSuccessful
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $booking;
    public $self;
    public $foreign;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($booking,$self = false,$foreign = false)
    {
        $this->booking = $booking;
        $this->self = $self;
        $this->foreign = $foreign;
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
