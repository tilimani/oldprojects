<?php

namespace App\Http\Controllers;

use App\Booking;
use \Cache;
use App\Message;
use App\Jobs\SendMessage;
use Illuminate\Http\Request;
use App\Events\MessageWasSended;
use App\Events\MessageWasReceived;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\BookingNotification;
use App\Notifications\MessageNotificationWpp;

class MessagesController extends Controller
{
	/**
	* Get messages than there are not read
    * @param Request $request need booking_id
    * @author Cristian
	**/
    public function getNotifications(Request $request)
    {
    	$messages = Message::where('bookings_id','=',$request->booking_id)
    				    ->where('read','=',0)
    					->get()->toJson();
    	return $messages;
    }

    /**
	* Get messages than there are not read
    * @param Request $request need message's id
    * @author Cristian
	**/
    public function updateNotification(Request $request)
    {
        $message = Message::find($request->id);
        $message->read = 1;
        $message->save();
    }


    public function updateReadStatus($id)
    {
        return response()->json($id, 200);
        $message = Message::find($request->input('id'));
        $message->read = 0;
        $message->save();
    }

    public function update(Request $request)
    {
        try {
            $messages = Message::where([
                    ['bookings_id', '=', $request->id],
                    ['destination', '=', $request->destination],
                ])->get();
            foreach ($messages as $message) {
                $message->read = 2;
                $message->save();
            }
            return response()->json('ok', 200);
        } catch (\Exception $ex) {
            return response()->json($ex, 200);
        }

    }

	/**
	* sended messages
    * @param Request $request need message's id, booking's id
    * @author Cristian
	**/
	public function store(Request $request)
	{
        $booking = Booking::find($request->bookings_id);
        broadcast(new MessageWasReceived($request->all(), 1, 1, $booking));
        try {
            $message = new Message();
            $message->fill($request->all());
            $message->read = 1;
            $message->save();

            $user = $booking->user;
            $manager = $booking->room->house->manager->user;
            $house = $booking->room->house;

            if ($message->destination == 0 ) { //user sended
                $manager->notify(new BookingNotification($booking, true, $message->message, 'user'));
                $user->notify(new BookingNotification($booking, true, $message->message, 'user'));
            } else {
                $manager->notify(new BookingNotification($booking, true, $message->message, 'manager'));
                $user->notify(new BookingNotification($booking, true, $message->message, 'manager'));
            }

            // is not a cache and flag is 1 ?
            if (!(Cache::has('email_' . '1_' . $booking->id)) && $request->flag == 1) {
                event(new MessageWasSended($booking->id, $request->flag)); //send notification
                Cache::put('email_1_'.$booking->id, true, now()->addDays(1)); // put cache
            }
            // is not a cache and flag is 0 ?
            if (!(Cache::has('email_'.'0_'.$booking->id)) && $request->flag == 0) {
                event(new MessageWasSended($booking->id, $request->flag)); //send notification
                Cache::put('email_0_'.$booking->id, true, now()->addDays(1)); // put cache
            }
            // is not a cache and flag is 1 ?
            if (!(Cache::has('twilio_' . '1_' . $booking->id)) && $request->flag == 1) {
                // NOTIFICAR AL USER
                $user->notify(new MessageNotificationWpp($manager, $user, $house,'user'));
                Cache::put('twilio_1_'.$booking->id, true, now()->addHours(1)); // put cache
            }
            // is not a cache and flag is 0 ?
            if (!(Cache::has('twilio_'.'0_'.$booking->id)) && $request->flag == 0) {
                // NOTIFICAR AL MANAGER
                $manager->notify(new MessageNotificationWpp($manager, $user, $house,'manager'));
                Cache::put('twilio_0_'.$booking->id, true, now()->addHours(1)); // put cache
            }
            return response()->json('ok', 200);
        } catch(\Exception $ex) {
            return response()->json('error '.$ex, 500);
        }

		return response()->json('ok', 200);
	}

	public function get(){
		return view('messages');
	}
}
