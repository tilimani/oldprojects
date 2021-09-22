<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Booking;
use App\User;
use SendGrid\Mail\To;
use App\Channels\SendGridChannel;
use App\Channels\SendGridInfo;
use App\Currency;
use App\Verification;
use App\Channels\TwilioChannel;
use Carbon\Carbon;

class NewPaymentManager extends Notification
{
    use Queueable;

    public $tos,
    $verification,
    $id_template = 'd-18423b7cc6634b8291644d490d502e02',
    $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Booking $booking, $import, $payment_period, $total_amount_EUR,User $user)
    {
        $manager = $booking->manager();
        $room = $booking->Room;
        $house = $room->House;
        $import = $import;
        $payment_period = $payment_period;
        $vico_transaction_fee = ($room->price * 0.03);

        if ($import == 'Rent' && $payment_period['isFirstPayment'] ) {
            $vico_transaction_fee =0;
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

        $this->verification = Verification::firstOrCreate(['user_id' => $manager->id]);
        // if this is the first request then change templade
        $this->id_template = ($this->verification->thisIsMyFirstSuccess())?
        // $this->id_template = (true)?
            'd-f813f6b64f5e470083026acad6ad816c' :
            $this->id_template;

        $this->tos = [
            new To(
                $manager->email,
                $manager->name,
                [
                    "manager_name"=>$manager->name,
                    "user_name"=>$user->name,
                    "import"=>$import == "Deposit" ? "Deposito":"Renta",
                    "vico_transaction_fee"=> (string) $vico_transaction_fee,
                    "discount_info" => ($import == 'Deposit') ? "Descuento por referido VICO:" : "",
                    "discount_amount" => ($import == 'Deposit') ? (string) $referral_amount : "",
                    "vico_management"=>($import == "Deposit") ? "Coste por manejo VICO:": "",
                    "vico_management_fee"=>($import == "Deposit") ? (string) ($payment_period['price']*0.05): "",
                    "total_amount"=>($import == "Deposit") ? (string) $room->price: (string) $total_amount,
                    "vico_name"=> $house->name,
                    "room_number"=>(string) $room->number,
                    "room_price" =>(string) $room->price,
                    "payment_period" => ($import == "Deposit") ? "" : "Periodo del pago: ",
                    "period_info" => ($import == "Deposit") ? "" : "desde el ".$payment_period['from']->format('d/m/Y')." hasta ".$payment_period['to']->format('d/m/Y'),
                    "house_name" => $house->name,
                    "date_from" => Carbon::parse($booking->date_from)->format('d/m/Y'),
                    "date_to" => Carbon::parse($booking->date_to)->format('d/m/Y'),
                    "user_phon" => $user->phone,
                    "text" => "Hola ".$user->name.", soy ".$manager->name." el propietario de la ".$house->name.
                            " y te escribo para confirmarte que he recibido el pago de tu deposito para la habitación número ".
                            $room->number.". Este texto es auto generado por VICO <3"
                ]
            )
        ];

        $this->message = "Congratulations! ".$user->name." just paid the ".$import." for the room ".
            $room->number." of ".$house->name." in the dates from ".$payment_period['from']->format('d/m/Y').
            " until ".$payment_period['to']->format('d/m/Y').". If you have any questions don't hesitate to contact us.";
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [$this->verification->canISendMail() ? SendGridChannel::class: '', TwilioChannel::class];
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
}
