<?php

namespace App\Listeners;

use App\Verification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\IDValidation;
use App\Events\IDWasUploaded;

class SendPassportEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(IDWasUploaded $event)
    {
        $verification = Verification::firstOrCreate(['user_id' => $event->user_id]);
        if ($verification->canISendMail())
        {
            Mail::to("passports@friendsofmedellin.com")->send(new IDValidation($event->user_id));
        }
    }
}
