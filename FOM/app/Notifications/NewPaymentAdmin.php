<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Channels\SendGridInfo;
use App\Channels\SendGridChannel;
use SendGrid\Mail\To;
use App\Booking;
use App\User;
use App\Currency;

class NewPaymentAdmin extends Notification
{
    use Queueable;

    public $tos, 
    $id_template = 'd-b4abfcddfb6245c1b3fcbfe23bd9f6a1';
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Booking $booking, $import, $payment_period, $total_amount_EUR,User $user, User $manager)
    {
        $admin = User::find(1);
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

        $this->tos = [
            new To(
                $admin->email,
                $admin->name,
                [
                    "user_name"=>$user->name,
                    "import"=>$import == "Deposit" ? "Deposito":"Renta",
                    "vico_transaction_fee"=> (string) $vico_transaction_fee,
                    "discount_info" => ($import == 'Deposit') ? "Descuento por referido VICO:" : "",
                    "discount_amount" => ($import == 'Deposit') ? (string) $referral_amount : "",
                    "vico_management"=>($import == "Deposit") ? "Coste por manejo VICO:": "",
                    "vico_management_fee"=>($import == "Deposit") ? (string) ($payment_period['price']*0.05): "",
                    "total_amount"=>(string) $total_amount,
                    "vico_name"=> $house->name,
                    "room_number"=>(string) $room->number,
                    "room_price" =>(string) $room->price,
                    "payment_period" => ($import == "Deposit") ? "" : "Periodo del pago: ",
                    "period_info" => ($import == "Deposit") ? "" : "desde el ".$payment_period['from']->format('d/m/Y')." hasta ".$payment_period['to']->format('d/m/Y'),
                    "vico_id" => $house->id,
                    "booking_id" => $booking->id,
                    "user_id" => $user->id,

                ]
            )
        ];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [SendGridChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

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
