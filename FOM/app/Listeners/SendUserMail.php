<?php

namespace App\Listeners;

use Mail;
use App\Verification;
use Carbon\Carbon;
use App\Mail\UserInitProcess;
use App\Mail\UserAvailibilty;
use App\Mail\UserGranted;
use App\Mail\UserScreenshot;
use App\Mail\UserConfirmation;
use App\Mail\UserReviewLeaveAComment;
use App\Events\BookingWasChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Crypt;
use App\PaymentWithVICO as Payments;
use App\Http\Controllers\Controller;
use App\Currency;

class SendUserMail implements ShouldQueue
{
    /**
     * Handle the event. A mail will send to booking's student, the mail changes for each status that it was changed.
     *
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
        // $payment = Payments::first(['booking_id' => $booking->id]);
        $payment = Payments::where('booking_id', $booking->id)->first();

        //encrypted manager id for unsubscribe feature
        $encrypted = Crypt::encryptString($user->id);

        $currency = new Currency();
        $currency = $currency->getCurrentCurrency();

        // $send_email = Controller::userEmailSuscription($manager->id);

        $data = [
            'email' => $user->email,
            'name' => $user->name,
            'house_id' => $house->id,
            'house_name' => $house->name,
            'room_number' => $room->number,
            'room_price' => $room->price,
            'room_total' => $room->price*1.08,
            'room_image' => $image_room,
            'booking_id' => $booking->id,
            'manager_name' => $manager->name,
            'manager_lastname' => $manager->last_name,
            'manager_image' => $manager->image,
            'manager_email' => $manager->email,
            'date_from' => Carbon::createFromFormat('Y-m-d', $booking->date_from),
            'date_to' => Carbon::createFromFormat('Y-m-d', $booking->date_to),
            'encrypted' => $encrypted,
            'currency' => $currency,
        ];
        $verification = Verification::firstOrCreate(['user_id' => $user->id]);

        switch ($booking->status) {
            case 1:
                try {
                    //Trigger the email action
                    if ($verification->canISendMail())
                    {
                        Mail::to($data['email'])->send(new UserInitProcess($data));
                        $data=[];
                    }

                } catch (\Exception $e) { return $e;}
                break;
            case 2:
                // try {
                //Trigger the email action
                    if ($verification->canISendMail())
                    {
                        Mail::to($data['email'])->send(new UserAvailibilty($data));
                        $data=[];
                    }
                // } catch (\Exception $e) { return $e;}
                break;
            case 4:
                    // try {
                    //Trigger the email action
                    if ($verification->canISendMail())
                    {
                        Mail::to($data['email'])->send(new UserGranted($data));
                        $data=[];
                    }

                // } catch (\Exception $e) { return $e;}
                break;
            case 50:
                $data = [
                    'name' => $user->name,
                    'house_id' => $house->id,
                    'house_name' => $house->name,
                    'room_number' => $room->number,
                    'room_price' => $room->price,
                    'room_total' => $room->price*1.03,
                    'room_image' => $image_room,
                    'booking_id' => $booking->id,
                    'manager_name' => $manager->name,
                    'manager_image' => $manager->image,
                    'date_from' => Carbon::createFromFormat('Y-m-d', $booking->date_from),
                    'date_to' => Carbon::createFromFormat('Y-m-d', $booking->date_to),
                    'manager_phone' => $manager->phone,
                    'house_adress' => $house->adress,
                    'subject' => 'Screenshot hochgelanden',
                    'view' => 'emails.screenshot',
                    'email' => 'mfranz795@gmail.com',
                    'payment' => $payment
                ];
                // try {
                    //Trigger the email action
                    if ($verification->canISendMail())
                    {
                        Mail::to($data['email'])->send(new UserScreenshot($data));
                        $data=[];
                    }

                // } catch (\Exception $e) { return $e;}
                break;

            case 5:
                $data += [
                    'manager_phone' => $manager->phone,
                    'house_adress' => $house->address,
                    'view' => '',
                ];
                // Set data fake in payment to send message
                if (isset($payment->charge_id))
                {
                    $data += ['payment_charge_id' => $payment->charge_id];
                }else
                {
                    $data += ['payment_charge_id' => $booking->id];
                }
                if (isset($payment->amountCop))
                {
                    $data += ['payment_amountCop' => $payment->amountCop];
                }else
                {
                    $data += ['payment_amountCop' => $room->price];
                }
                try {
                    // Trigger the email action
                    if ($verification->canISendMail())
                    {
                        Mail::to($data['email'])->send(new UserConfirmation($data));
                        $data=[];
                    }

                } catch (\Exception $e) { return $e;}
                break;
            case 6:
                $data += [
                    'email' => $user->email,
                    'manager_name' => $manager->name,
                    'manager_image' => $manager->image,
                    'review_id' => '',
                    'subject' => 'Solicitud de calificación',
                    'view' => 'emails.bookings.user_6_review_pleaseleaveacomment'
                ];
                // try {
                    //Trigger the email action
                    if ($verification->canISendMail())
                    {
                        Mail::to($data['email'])->send(new UserReviewLeaveAComment($data));
                        $data=[];
                    }

                // } catch (\Exception $e) { return $e;}
                break;
            case -6:
                $data = [
                    'email' => $user->email,
                    'manager_name' => $manager->name,
                    'manager_image' => $manager->image,
                    'review_id' => '',
                    'subject' => 'Solicitud de calificación',
                    'view' => '',
                    'encrypted' => $encrypted,
                ];
                break;
            case 72:
                $data = [
                    'email' => $user->email,
                    'manager_name' => $manager->name,
                    'manager_image' => $manager->image,
                    'review_id' => '',
                    'subject' => 'Correo de notifación',
                    'view' => '',
                    'encrypted' => $encrypted,
                ];
                break;
            default:
                $data["view"] = "";
                break;
        }

        if (isset($data["view"]))
        {
            if($data["view"] != "" && $verification->canISendMail())
            {
                // Mail::send('bookings.mail_prueba', $data, function ($message) use ($data) {
                Mail::send('bookings.'.$data['view'], $data, function ($message) use ($data) {
                    $message->from('hello@getvico.com', 'Team VICO');
                    $message->to($data['email']);
                    $message->to('solicitudes@friendsofmedellin.com');
                    $message->subject($data['subject']);
                }); // mail is sended
            }
        }
    }
}
