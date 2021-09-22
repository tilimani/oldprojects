<?php

namespace App\Listeners;

use App\Events\UserContact;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendContactMail implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserContact  $event
     * @return void
     */
    public function handle(UserContact $event)
    {
        $data = [
            'name' => $event->getName(),
            'email' => $event->getEmail(),
            'cellphone' => $event->getCellphone(),
            'full_number' => $event->getNumber(),
            'option' => 'Contact Form: '.$event->getOption(),
            'description' => $event->getDescription(),
        ];

        Mail::send('emails.contact', $data, function($message) use ($data){
            $message->from($data['email'], $data['name']);
            $message->to('help@getvico.com');
            $message->subject($data['option']);
        });

    }
}
