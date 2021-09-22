<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


use App\Events\MessageWasSended;
use App\Http\Controllers\TwilioController;


class SendTwilioMessage implements ShouldQueue
// class SendTwilioMessage
{    
    
    public $tries = 1;

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(MessageWasSended $event)
    {
        $verification = $event->verification;
        if($verification->whatsapp_verified == true) {
            $twilio = new TwilioController();
            $destination = $event->destination;
            $user = $event->user;            
            $manager = $event->manager;                  
            if($destination===1){
                $twilio->SendMessage("Nuevo mensaje de usuario",$manager->user_id);            
            }else{
                $twilio->SendMessage("New message from manager",$user->id);            
            }                            
        }
    }
}
