<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use App\Channels\SendGridInfo;
use \SendGrid\Mail\Mail as GridMail;
use \SendGrid\Mail\From as From;
use \SendGrid\Mail\To as To;

class SendGridChannel
{
    public $tos;
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $from = new From("hello@getvico.com", "VICO");

        if(env('APP_ENV') === 'production'){
            $tos = (new SendGridInfo)->to($notification->tos);
        }else{
            $tos = new To(
                "vico.testing@gmail.com",
                "VICO test",
                []
            );
        }
        
        $email = new GridMail(
            $from,
            $tos
        );

        $email->setTemplateId($notification->id_template);
        $sendgrid = new \SendGrid(env('SENDGRID_API_KEY'));
        // try {
            $response = $sendgrid->send($email);
        // } catch (Exception $e) {
            // echo 'Caught exception: '.  $e->getMessage(). "\n";
        // }
        // $url = url('/bookingdate/user/'.$this->booking->id);
        // Send notification to the $notifiable instance...
    }
}