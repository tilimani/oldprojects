<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Events\BookingCacheWasExpired;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExcecuteBookingQueue implements ShouldQueue
{

    /**
     * Handle the event.
     *
     * @param  BookingCacheWasExpired  $event
     * @return void
     */
    public function handle(BookingCacheWasExpired $event)
    {
        $bookings = Booking::where(['status' => 4])
            ->get();

        foreach ($bookings as $booking ) {
            $status_update = SatusUpdate::where(['booking_id' => $booking->id])
                ->orderBy('created_at')
                ->first();
            $date = Carbon::createFromTimestamp($status_update->created_at);
            if (now() >= $date->addHours(24)) {
                $booking->status = 1;
                $booking->save();
                $user = $booking->user;
                $manager = $booking->room->house->manager->user;
                $user->notify(new BookingNotification($booking));
                $manager->notify(new BookingNotification($booking));
            }
        }
    }
}
