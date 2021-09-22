<?php

namespace App\Listeners;

use Mail;
use Carbon\Carbon;
use App\Events\BookingWasChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use App\Verification;
use App\Currency;

/**
 * Send admin mail class
 * @category Content
 * @package  Contet
 * @author Name <email@email.com>
 * @license asd
 * @link  http://url.com
 *
 */

class SendAdminMail implements ShouldQueue
{
    /**
     * Handle the event. A mail will send to house's manager, the mail changes for each status that it was changed.
     * Edited By: Andrés Cano <andresfe98@gmail.com>
     * @param  BookingWasChanged  $event <- this param has the booking
     * @author Cristian
     */

    public function handle(BookingWasChanged $event)
    {
        $booking = $event->booking;
        $manager = $event->manager;
        $user = $event->user;
        $room = $event->room;
        $house = $event->house;
        $image_room = $event->image_room;

        $count = DB::table('bookings')->where('bookings.user_id', '=', $booking->user_id)->count(); //count of bookings active for house's admin (this is incluyed)

        //here it will be send a mail to house's admin or if there isnt a valid mail to getvico
        strpos($manager->email, '@') ?
            $email=$manager->email : $email =' hello@getvico.com';

        //encrypted manager id for unsubscribe feature
        $encrypted = Crypt::encryptString($manager->id);

        // $send_email = Controller::userEmailSuscription($manager->id);

        $currency = new Currency();
        $currency = $currency->getCurrentCurrency();

        $verification = Verification::firstOrCreate(['user_id' => $manager->id]);

        $data2 = [
            'email' => $email,
            'manager_name' => $manager->name,
            'house_id' => $house->id,
            'house_name' => $house->name,
            'user_name' => $user->name,
            'user_lastname' => $user->last_name,
            'user_email' => $user->email,
            'user_nationality' => $user->country_name,
            'user_gender' => $user->gender,
            'user_image' => $user->image,
            'room_number' => $room->number,
            'room_image' => $image_room,
            'room_nickname' => $room->nickname,
            'room_price' => $room->price,
            'currency' => $currency,
            'booking_id' => $booking->id,
            'date_from' => Carbon::createFromFormat('Y-m-d', $booking->date_from),
            'date_to' => Carbon::createFromFormat('Y-m-d', $booking->date_to),
            'count' => $count -1,
            'encrypted' => $encrypted,
        ];
        switch ($booking->status)
        {
        case 1:
                // $manager->notify(new ); notificacion de solicitud
                $data2 += [
                    'message' => $booking->message,
                    'subject' => '¡Tienes una nueva Solicitud! - '.$data2['house_name'].' - Hab.'.$data2['room_number'],
                    'view' => 'emails.bookings.manager_1_initprocess'
                ];
            break;
        case 3:
              $data2 += [
                  'subject' => 'Reserva en proceso: '.$data2['house_name'].' - Hab.'.$data2['room_number'],
                  // 'view' => 'emails.bookings.manager_3_paymentprocess'
                  'view' => ''
              ];
            break;
        case 4:
              $data2 += [
                  'email' => $email,
                  'subject' => 'Recordatorio que significa reservar la habitación',
                  'view' => ''
              ];
            break;
        case 5:
                // $manager->notify(new ); notificacion de booking exitoso
              $data2 += [
                  'user_phone' => $user->phone,
                  'room_price' => $room->price,
                  'subject' => '¡Pago exitoso! - Hab. '.$data2['room_number'].' en '.$data2['house_name'],
                  'view' => 'emails.bookings.manager_5_confirmation'
              ];
            break;
        case 6:
              $data2 = [
                  'email' => $email,
                  'user_name' => $user->name,
                  'user_image' => $user->image,
                  'review_id' => '',
                  'subject' => 'Solicitud de calificación',
                  'view' => '',
                  'encrypted' => $encrypted,
            ];
            break;
        case -6:
              $data2 = [
                  'email' => $email,
                  'user_name' => $user->name,
                  'user_image' => $user->image,
                  'review_id' => '',
                  'subject' => 'Solicitud de calificación',
                  'view' => '',
                  'encrypted' => $encrypted,
              ];
            break;
        case 71:
              $data2 = [
                  'email' => $email,
                  'user_name' => $user->name,
                  'user_image' => $user->image,
                  'review_id' => '',
                  'subject' => 'Correo de notifación',
                  'view' => '',
                  'encrypted' => $encrypted,
              ];
            break;
        case -1:
              $data2 = [
                  'email' => $email,
                  'user_name' => $user->name,
                  'user_image' => $user->image,
                  'review_id' => '',
                  'manager_id' => $manager->id,
                  'subject' => 'Correo de notifación',
                  'view' => '',
                  'encrypted' => $encrypted,
              ];
            break;
        default:
              $data2 = null;
            break;
        }

        if (
            $data2 != null &&
            $data2["view"] != "" &&
            $verification->canISendMail()
        ){
            // Mail::send('bookings.mail_prueba', $data2, function ($message) use ($data2) {
            Mail::send($data2['view'], $data2, function ($message) use ($data2) {
                // $message->from('friendsofmedellin@gmail.com', 'VICO - ¡Vivir entre amigos!');
                $message->to($data2['email']);
                $message->to('solicitudes@friendsofmedellin.com');
                $message->subject($data2['subject']);
            }); // mail is sended
        }
    }
}
