<?php

namespace App\Listeners;


use Mail;
use App\Events\MessageWasSended;
use App\Mail\MessageNotification;
use App\Verification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Crypt;

// class UserMessageNotification implements ShouldQueue
class UserMessageNotification
{
    /**
     * Handle the event. A mail will to sent booking's user, the mail notificate for each message sended by house's manager
     *
     * @param  MessageWasSended  $event <- event has data
     * @author Cristian
     * @return void
     */
    public function handle(MessageWasSended $event)
    {
        $destination = $event->destination;
        $booking = $event->booking;
        $manager = $event->manager;
        $user = $event->user;
        $room = $event->room;
        $house = $event->house;
        $image_house = $event->image_house;
        //encrypted manager id for unsubscribe feature
        $encrypted = Crypt::encryptString(($destination == 1) ? $manager->id : $user->id);

        $data = [
            'image_house' => $image_house,
            'house_name' => $house->name,
            'room_number' => $room->number,
            'date_to' => $booking->date_to,
            'date_from' => $booking->date_from,
            'manager_image' => ($destination == 1) ? $manager->image : $user->image,
            'manager_name' => ($destination == 1) ? $manager->name : $user->name,
            'user_type' => ($destination == 1) ? 'show' : 'user',
            'booking_id' => $booking->id,
            'user' => $user,
            'house' => $house,
            'room' => $room,
            'email' => ($destination == 1) ? $user->email : $manager->email ,
            'encrypted' => $encrypted,
        ];
        try {
            $verification = Verification::firstOrCreate(['user_id' => $user->id]);
            if ($verification->canISendMail())
            {
                \Mail::to($data['email'])->send(new MessageNotification($data)); //Trigger the email action
            }
        } catch (\Exception $e) { return $e;}


    }
}
