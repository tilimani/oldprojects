<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Events\BookingWasChanged;
use App\Listeners\SendAdminMail;
use App\Listeners\SendUserMail;
use App\Listeners\SendVicoMail;
use App\Events\MessageWasSended;
use App\Listeners\UserMessageNotification;
use App\Events\BookingWasSuccessful;
use App\Listeners\CancelForeingBookings;
use App\Listeners\CancelSelfBookings;
use App\Events\UserContact;
use App\Listeners\SendContactMail;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\MessageWasReceived;
use App\Listeners\MessageNotification;
use App\Listeners\SendTwilioMessage;
use App\Events\IDWasUploaded;
use App\Listeners\SendPassportEmail;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        BookingWasChanged::class => [
            SendUserMail::class,
            SendAdminMail::class,
            SendVicoMail::class,
        ],

        MessageWasSended::class => [
            UserMessageNotification::class,
            // SendTwilioMessage::class,
        ],

        BookingWasSuccessful::class => [
            CancelSelfBookings::class,
            CancelForeingBookings::class,
        ],

        UserContact::class => [
            SendContactMail::class,
        ],

        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        MessageWasReceived::class => [
            MessageNotification::class,
        ],
        IDWasUploaded::class =>[
            SendPassportEmail::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
