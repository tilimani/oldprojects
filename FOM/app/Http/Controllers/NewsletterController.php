<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;
use App\Booking;
use App\Room;
use App\House;
use App\User;
use App\Verification;
use Illuminate\Support\Facades\DB;


class NewsletterController extends Controller
{
    public function sendWelcomeMail(){

        //get bookings for status 5 which were made after $limit_day
        $limit_day = '2018-12-01';
        $bookings = Booking::all()->where('status', '=', 5)->where('date_from', '>', $limit_day);
        $count=0;
        foreach ($bookings as $booking) {

            //get user of booking
            $user = User::find($booking->user_id);

            //define if email has been sent before, if sent before $sent = true
            $alreadySent = Verification::all()->where('user_id', '=', $user->id)->first();

            if($alreadySent!=null && $alreadySent->email_welcome === 1){
                $sent=true;
            }
            else{
                $sent=false;
            }

            //if not already sent, start transaction
            if($sent===false){
                //get data of booking for the email
                $booking->booking = $booking;

                $id = DB::table('rooms')->select('houses.manager_id')
                          ->join('houses','houses.id','=','rooms.house_id')
                          ->where('rooms.id','=',$booking->room_id)
                          ->first(); //get id of house's manager

                $manager = DB::table('managers')
                              ->select('users.id','users.name','users.last_name', 'users.email','users.image','users.phone')
                              ->join('users','users.id','=','managers.user_id')
                              ->where('managers.id','=',$id->manager_id)
                              ->first(); // get house's manager info

                $room = Room::findOrFail($booking->room_id); //get booking's room info

                $house = House::findOrFail($room->house_id); //get room's house info

                $booking->manager = $manager;
                $booking->user = $user;
                $booking->room = $room;
                $booking->house = $house;
                //make sure mail has got @ in it.
                strpos($user->email, '@') ? $user->email=$user->email : $user->email='hello@getvico.com';

                $data = [
                    'email' => $user->email,
                    'name' => $user->name,
                    'user_name' => $user->name,
                    'user_lastname' => $user->last_name,
                    'user_id' => $user->id,
                    'user_created_at' => $user->created_at,
                    'house_id' => $house->id,
                    'house_name' => $house->name,
                    'booking_id' => $booking->id,
                    'manager_name' => $manager->name,
                    'manager_lastname' => $manager->last_name,
                    'manager_image' => $manager->image,
                    'manager_email' => $manager->email,
                    'manager_phone' => $manager->phone,
                    'house_adress' => $house->address,
                    'view' => 'user_welcomeMail',
                    'subject' => '¡La aventura empieza!',

                ];

                $send_email = self::userEmailSuscription($user->id);

                // Send Mail
                if ($send_email)
                {
                    $verification = Verification::firstOrCreate(['user_id' => $user->id]);
                    if ($verification->canISendMail())
                    {
                        Mail::send('emails.bookings.'.$data['view'], $data, function ($message) use ($data) {
                            $message->from('hello@getvico.com', 'Team VICO');
                            $message->to($data['email']);
                            $message->subject($data['subject']);
                        }); // mail is sended
                    }
                }
                $count++;
                // Set email_welcome in Subscripton Table to true, actualize or create entry
                if($alreadySent!=null){
                    $verification = Verification::all()->where('id', '=', $alreadySent->id)->first();
                    $verification->email_welcome = true;
                    $verification->save();
                    DB::commit();
                    }else{
                     DB::beginTransaction();
                     $verification = new Subscription();
                     $verification->user_id = $user->id;
                     $verification->email_welcome = true;
                     $verification->save();
                     DB::commit();
                };

            }
        }
    return $count.' Messages sent';
    }
}
