<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use \SendGrid\Mail\To as To;
use App\Booking;
use App\Currency;
use App\Verification;
use App\Channels\SendGridChannel;
use App\Channels\SendGridInfo;
use App\Channels\TwilioChannel;

class NewPaymentUser extends Notification
{
    public $tos, 
    $id_template = 'd-a47db80808d241a099d83ef49179dc9c',
    $message;

    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Booking $booking, $import, $payment_period, $total_amount_EUR)
    {
        $user = $booking->User;
        $room = $booking->Room;
        $house = $room->House;
        $import = $import;
        $payment_period = $payment_period;
        $vico_transaction_fee = ($room->price * 0.03);

        if ($import == 'Rent' && $payment_period['isFirstPayment'] ) {
            $vico_transaction_fee = "Primer renta mensual 🤗";
        }

        $currency = new Currency();
        $currency = $currency->get('USD');

        $vicoReferral = $booking->vicoReferrals()->first();

        if ($vicoReferral) {
            
            $vicoReferral = $vicoReferral->amount_USD;
            $referral_amount = $vicoReferral / $currency->value;

        } else {
            $referral_amount = 0;
        }

        $currency = $currency->get('EUR');        

        $total_amount = round($total_amount_EUR / $currency->value,0);

        $this->tos = [
            new To(
                $user->email,
                $user->name,
                [
                    "name"=>$user->name,
                    "import"=>$import == "Deposit" ? "Deposito":"Renta",
                    "vico_transaction_fee"=> (string) $vico_transaction_fee,
                    "discount_info" => ($import == 'Deposit') ? "Descuento por referido VICO: " : "",
                    "discount_amount" => ($import == 'Deposit') ? (string) $referral_amount : "",
                    "vico_management"=>($import == "Deposit") ? "Coste por manejo VICO: ": "",
                    "vico_management_fee"=>($import == "Deposit") ? (string) ($payment_period['price']*0.05): "",
                    "total_amount"=>(string) $total_amount,
                    "vico_name"=> $house->name,
                    "room_number"=>(string) $room->number,
                    "room_price" =>(string) $room->price,
                    "period_info" => ($import == "Deposit") ? "" : "desde el ".$payment_period['from']->format('d/m/Y')." hasta ".$payment_period['to']->format('d/m/Y')
                ]
            )
        ];

        $this->message = "Congratulations! Your payment for room ".$room->number.
        " in the ".$house->name." has been received and your reservation has been confirmed.";
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $verification = Verification::firstOrCreate(['user_id' => $notifiable->id]);
        return [$verification->canISendMail() ? SendGridChannel::class: '', TwilioChannel::class ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toSendGrid($notifiable)
    {
        
        return (new SendGridInfo)->to($this->tos);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toSendMail($notifiable)
    {
        dd($notifiable);
    }
}
