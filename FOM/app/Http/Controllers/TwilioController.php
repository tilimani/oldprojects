<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client as TwilioClient;
use App\User;
use App\Verification;

class TwilioController extends Controller
{
    protected $client;
    protected $test_number; //Number to test in development

    public function __construct()
    {
        $this->test_number = "+573206843458";
        $this->client = new TwilioClient(env('TWILIO_SID'), env('TWILIO_TOKEN'));
    }

    /**
     * Function that determines which is the selected channel by the user
     *
     * Determines the $user_id preferred channel and send the notification via that channel
     *
     * @param string $message Message body to be sended to user
     * @param int $user_id id of the user to be notified
     * @author Santiago Osorio <santisanchez.1214@gmail.com>
     *
     **/
    public function SendMessage(string $message, int $user_id)
    {
        $verification = Verification::firstOrCreate(['user_id' => $user_id]);
        if($verification->channel === ''){//the user dont want to be notified
            return;
        }
        $user = User::find($user_id);
        $channel = $verification->channel === 'sms' ? 'whatsapp:' : 'whatsapp:';
        $from = $verification->channel === 'sms' ? env('TWILIO_FROM_NUMBER') : env('TWILIO_WHATSAPP_NUMBER');
        if(env('APP_ENV') === 'production'){
            $this->client->messages->create(
                $channel . $user->phone,
                array(
                    "body" => $message,
                    "from" => $channel . $from
                )
            );
        }else{
            $this->client->messages->create(
                $channel . $this->test_number,
                array(
                    "body" => $message,
                    "from" => $channel . $from
                )
            );
        }
    }
    /**
     * Function to send sms to a user
     *
     * @param string $message message body to be sended to receiver
     * @param string $to user phone number
     * @author Santiago Osorio <santisanchez.1214@gmail.com>
     **/
    public function SendSMS(string $message, string $to)
    {
        if(env('APP_ENV') === 'production'){
            $this->client->messages->create(
                $to,
                array(
                    'from' => env('TWILIO_FROM_NUMBER'),
                    'body' => $message,
                )
            );
        // }elseif(env('APP_ENV')=== 'development'){
        }else {
            $this->client->messages->create(
                $this->test_number,
                array(
                    "from" => env('TWILIO_FROM_NUMBER'),
                    "body" => $message
                )
            );
        }
    }
    /**
     * Function to send whatsapp message to a user
     *
     * @param string $message message body to be sended to receiver
     * @param string $to user phone number
     * @author Santiago Osorio <santisanchez.1214@gmail.com>
     **/
    public function SendWhatsapp(string $message, string $to)
    {
        if(env('APP_ENV') === 'production'){
            $this->client->messages->create(
                "whatsapp:" . $to,
                array(
                    "from" => "whatsapp:" . env('TWILIO_WHATSAPP_NUMBER'),
                    "body" => $message
                )
            );
        }elseif(env('APP_ENV')=== 'development'){
            $this->client->messages->create(
                "whatsapp:" . $this->test_number,
                array(
                    "from" => "whatsapp:" . env('TWILIO_WHATSAPP_NUMBER'),
                    "body" => $message
                )
            );
        }
    }
}
