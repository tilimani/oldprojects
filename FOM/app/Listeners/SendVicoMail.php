<?php

namespace App\Listeners;

use App\Events\BookingWasChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendVicoMail implements ShouldQueue
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
     * @param  =BookingWasChanged  $event
     * @return void
     */
    public function handle(BookingWasChanged $event)
    {
        //
    }
}
