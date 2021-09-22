<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use \SendGrid\Mail\Mail as GridMail;
use \SendGrid\Mail\From as From;
use \SendGrid\Mail\To as To;

class SendGridInfo
{
    public $tos;
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */

    public function from()
    {
        # code...
    }

    public function to($info)
    {
        foreach ($info as $key=>$to) {
            if (!is_a($to,'\SendGrid\Mail\To')) {
                throw new Exception("La variable {[$info]} debe ser una instancia de la clase \SendGrid\Mail\To", 1);
            };
        }
        $this->tos = $info;
        return $this->tos;
    }


}
