<?php

namespace App\Listeners;

use App\Booking;
use App\Events\BookingWasSuccessful;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\BookingNotification;
use App\User;

class CancelSelfBookings implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  BookingWasSuccessful  $event
     * @return void
     */
    public function handle(BookingWasSuccessful $event)
    {
        if ($event->self)
        {
            $booking = $event->booking;
            //Cancel all of the users own Bookings
            $bookings = Booking::where('user_id','=',$booking->user_id)
            ->whereBetween('status',[0,5])
            ->whereNotIn('id',[$booking->id])
            ->get();

            foreach ($bookings as $bookingCancel)
            {
                $bookingCancel->status = -1;
                $bookingCancel->note = $bookingCancel->note.' || Canceled due to other successful Booking of the same user.';
                $bookingCancel->save();
                $user = $bookingCancel->user;
                $manager = $bookingCancel->manager();
                $manager->notify(new BookingNotification($bookingCancel));
                $user->notify(new BookingNotification($bookingCancel));
            }
        }
    }
}
