<?php

namespace App\Listeners;

use App\Message;
use App\Events\MessageWasReceived;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Jobs\SendMessage;
use App\Booking;

// class MessageNotification implements ShouldQueue
class MessageNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MessageWasReceived  $event
     * @return void
     */
    public function handle(MessageWasReceived $event)
    {
        // $event->__wakeup();
        // $messageEvent = $event->message;
        // $message = new Message();
        // $message->fill($messageEvent);
        // $message->destination = $event->flag;
        // $message->bookings_id = $event->id;
        // $message->save();
    }
}
