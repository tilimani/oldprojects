<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Invitation;
use App\Room;
use Carbon\Carbon;
use App\User;
use App\Booking;
use App\Notifications\BookingInvitation;
use App\Notifications\BookingNotification;



class InvitationController extends Controller
{
  public function getInvitationById(Invitation $invitation){
    $room = $invitation->Room;
    $house = $room->House;
    $booking_dates = $room->bookings()->select('date_from', 'date_to')->where('status','=',"5")->get();

    $data=[
      'invitation' => $invitation,
      'room'=>$room,
      'dates'=>$booking_dates,
      'room_images'=> $room->Images,
      'house' => $house,
      'neighborhood' => $house->Neighborhood,
      'manager' => $house->manager->user
    ];
    return response()->json($data,200);
  }

   public function createInvitation(Request $request){
        $invitation = new Invitation();
        $invitation->room_id = $request->roomId;
        $invitation->deposit_price = $request->depositPrice;
        $invitation->deposit_paid = $request->depositPaid;
        if($request->sendViaEmail){
          // SENDGRID
          $invitation->notify(new BookingInvitation($invitation->room,$invitation,$invitation->room->house));
          $invitation->user_email = $request->email;
        }
        $invitation->expiration_date = $request->expiration_date ? $request->expiration_date : Carbon::now()->addDays(7);
        $invitation->save();
        return response()->json($invitation->id,200);

   }

   public function acceptInvitation(Request $request){
    // $acceptedInvitation = new AcceptedInvitation;
    // $acceptedInvitation->booking_id = $booking->id;
    // $acceptedInvitation->invitation_id = $invitation->id
    // $acceptedInvitation->save();
    $booking = new Booking();
    $booking->status = 1;
    $booking->date_from = $request->date_from;
    $booking->date_to = $request->date_to;
    $booking->room_id = $request->room_id;
    $booking->user_id = $request->user_id;
    $booking->mode = 1;
    $booking->save();
    $user = $booking->User;
    $manager = $booking->Room->House->Manager->User;
    $user->notify(new BookingNotification($booking));
    $manager->notify(new BookingNotification($booking));
    return response()->json($booking->id,200);
  }
}
