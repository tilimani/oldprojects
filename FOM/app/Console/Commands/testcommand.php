<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Twilio\Rest\Client as TwilioClient;
use Carbon\Carbon;
use App\Manager;
use App\Bill;
use App\Notifications\WeeklyPaymentReminder;
use App\Notifications\WeeklyNewActiveBookings;
use App\Booking;

class testcommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:testcommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $booking = Booking::find(2245);
        $room = $booking->Room;
        $house = $room->House;
        $twilio = new TwilioClient(env('TWILIO_SID'), env('TWILIO_TOKEN'));

        $message = $twilio->messages
                        ->create("whatsapp:+57", // to
                                array(
                                    "from" => "whatsapp:+13024824478",
                                    "body" => "Congratulations! Your payment for room ".$room->number." in the ".$house->name." has been received and your reservation has been confirmed."
                                )
                        );

        print($message->sid);
    }
    
}
