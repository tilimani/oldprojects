<?php

namespace App\Listeners;

use App\Booking;
use Carbon\Carbon;
use App\Events\BookingWasSuccessful;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TwilioController;
use App\Notifications\BookingNotification;

class CancelForeingBookings implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  BookingWasSuccessful  $event
     * @return void
     */
    public function handle(BookingWasSuccessful $event)
    {
        if ($event->foreign)
        {
            $booking = $event->booking;
            //Cancel all Bookings for the same Room in the same time frame
            $ForeignBookings = Booking::where('room_id','=',$booking->room_id)
            ->whereBetween('status',[0,4])
            ->whereNotIn('id',[$booking->id])
            ->get();

            //BookingsCancel are Foreign-bookings
            foreach ($ForeignBookings as $bookingCancel)
            {
                // Renmame Variables for easier use
                $bookingOriginalArrival = $booking->date_from;
                $bookingOriginalExit = $booking->date_to;
                $bookingCancelArrival = $bookingCancel->date_from;
                $bookingCancelExit = $bookingCancel->date_to;

                // Has this booking to be canceled?
                $bookingToBeCanceled = false;

                // How many days the bookings can be within the other?
                $bookingToBeCanceledLimit = 6;

                // Case 1: Date To Canceled is between Date From and Date to of original Booking
                if($bookingOriginalArrival < $bookingCancelExit && $bookingCancelExit < $bookingOriginalExit && Carbon::parse($bookingOriginalArrival)->diffInDays(Carbon::parse($bookingCancelExit),false) > $bookingToBeCanceledLimit){
                    $bookingToBeCanceled = true;
                    $bookingToBeCanceledReason = 'Booking Canceled Date To is between Date From and Date to of Original Booking.';
                }
                // Case 2: Date From Canceled is between Date From and Date To of original Booking
                elseif($bookingOriginalArrival < $bookingCancelArrival && $bookingCancelArrival < $bookingOriginalExit && Carbon::parse($bookingCancelArrival)->diffInDays(Carbon::parse($bookingOriginalExit),false) > $bookingToBeCanceledLimit){

                    $bookingToBeCanceled = true;
                    $bookingToBeCanceledReason = 'Booking Canceled Date From is between Date From and Date To of Original Booking.';
                }
                // Case 3: Booking Canceled from and to are within the original booking
                elseif($bookingOriginalArrival <= $bookingCancelArrival && $bookingCancelExit <= $bookingOriginalExit){
                    $bookingToBeCanceled = true;
                    $bookingToBeCanceledReason = 'Canceled Booking Dates are within or igual to the Original Booking dates.';
                }
                // Case 4: Original Booking is within the Canceled Booking
                elseif($bookingCancelArrival < $bookingOriginalArrival && $bookingOriginalExit < $bookingCancelExit){
                    $bookingToBeCanceled = true;
                    $bookingToBeCanceledReason = 'Original Booking Dates are within the Canceled Booking.';
                }
                // Case 5: Original Booking has same arrival or exit date
                elseif($bookingCancelArrival = $bookingOriginalArrival || $bookingOriginalExit = $bookingCancelExit){
                    $bookingToBeCanceled = true;
                    $bookingToBeCanceledReason = 'Original Booking Arrival or Exit Date are igual to the Canceled Booking.';
                }
                if($bookingToBeCanceled === true)
                {
                    $bookingCancel->status = -21;
                    $bookingCancel->note = $bookingCancel->note.' || Canceled due to other successful Booking (#'.$booking->id.') in this room: '.$bookingToBeCanceledReason;
                    $bookingCancel->save();
                    $user = $bookingCancel->user;
                    $manager = $bookingCancel->manager();
                    $manager->notify(new BookingNotification($bookingCancel));
                    $user->notify(new BookingNotification($bookingCancel));
                    $data2 = [
                        'id' => $bookingCancel->id,
                        'status' => $bookingCancel->status,
                    ];
                    BookingController::SendSuggestionsPublic($bookingCancel);
                    // $this->SendMessage($bookingCancel);
                }
            }
        }
    }

    private function SendMessage($booking){
        $twilio = new TwilioController();
        $message = 'Hola, tu solicitud para '.
            $booking->house()->name.
            " fue cancelada ".
            'Esto porque alguien mas realizó el pago de la habitacion '.
            $booking->Room->number.
            '. Puedes buscar mas ofertas en getvico.com';

        $twilio->SendMessage($message,$booking->user_id);
    }
}
