<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use App\Channels\SendGridInfo;
use \SendGrid\Mail\Mail as GridMail;
use \SendGrid\Mail\From as From;
use \SendGrid\Mail\To as To;
use App\Http\Controllers\TwilioController;

class TwilioChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $twilio = new TwilioController();

        $twilio->SendMessage($notification->message, $notifiable->id);
    }
}