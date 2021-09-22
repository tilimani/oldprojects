<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Verification;

use App\Booking;

use Carbon\Carbon;

class PaymentComplete extends Notification
{
    use Queueable;

    public $user, $home, $room, $paymentPeriod, $paymentPriceEU, $paymentPriceCOP, $paymentType;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Booking $booking, $paymentPeriod, $paymentPriceEU, $paymentPriceCOP)
    {
        $this->user = $booking->user()->first();

        $this->room = $booking->room()->first();

        $this->home = $this->room->house()->first();

        $this->paymentDate = Carbon::now()->format('d/m/Y');

        $this->paymentPeriod = $paymentPeriod;

        $this->paymentPriceEU = $paymentPriceEU;

        $this->paymentPriceCOP = $paymentPriceCOP;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $verification = Verification::firstOrCreate(['user_id' => $this->user->id]);
        return ($verification->canISendMail())? ['mail']: [];
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
                    ->subject('Payment Complete! '.$this->paymentDate.' VICO:'.$this->home->name.' Room:'.$this->room->number)
                    ->line('Hi '.$this->user->name.'!')
                    ->line('You paid '.$this->paymentPriceCOP.'COP ('.$this->paymentPriceEU.'EU) for the room '.$this->room->number.' on the vico '.$this->home->name)
                    ->line('This payment corresponds to the period from '.$this->paymentPeriod['from'].' to '.$this->paymentPeriod['to'])
                    ->line('Enjoy your stay!')
                    ->line('Team VICO. <3');
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
