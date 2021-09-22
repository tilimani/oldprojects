<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;
use SendGrid\Mail\To;
use App\Channels\SendGridInfo;
use App\Channels\SendGridChannel;
use App\Booking;
use App\User;
use App\Verification;
use App\Channels\TwilioChannel;
use App\Mail\FirstRequestVico as Mailable;

class NewRequest extends Notification
{
    use Queueable;

    public $tos, $id_template='d-6236774d28314cadb0012d3b9560ef2f', $message;
    public $verification;
    public $booking;
    public $data;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $manager, Booking $booking)
    {
        $this->booking = $booking;
        $room = $booking->Room;
        $house = $room->House;
        $user = $booking->User;

        $this->verification = Verification::firstOrCreate(['user_id' => $manager->id]);
        // if this is the first request then change templade
        $this->id_template = ($this->verification->thisIsMyFirstRequest())?
        // $this->id_template = (true)?
            'd-55045964d430414f8fe1a8d72c0fbe1c' :
            $this->id_template;

        $this->tos = new To(
            $manager->email,
            $manager->name,
            [
                "manager_name"=>(string)$manager->name,
                "user_name" => $user->name,
                "user_city" => $user->Country->name,
                "house_name"=>$house->name,
                "room_number"=>(string)$room->number,
                "period_info"=>(string)"desde ".Carbon::parse($booking->date_from)->format('d/m/Y')." hasta ".Carbon::parse($booking->date_to)->format('d/m/Y'),
                "date_from" => (string)Carbon::parse($booking->date_from)->format('d/m/Y'),
                "date_to" =>(string) Carbon::parse($booking->date_to)->format('d/m/Y'),
                "url" => (string)route('vico.process')
            ]
        );
        $this->booking = $booking;
        $this->message = "Hola ".$manager->name.", tienes una nueva solicitud de reserva para ".$house->name.
        " en las fechas de ".Carbon::parse($booking->date_from)->format('d/m/Y')." a ".Carbon::parse($booking->date_to)->format('d/m/Y').
        ". Entra a www.getvico.com para aceptarla.";

        $this->data = [
            'manager_name' => $manager->name,
            'manager_id' => $manager->id,
            'date_to' => $booking->date_to,
            'date_from' => $booking->date_from,
            'house_name' => $house->name,
            'room_number' => $room->number
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
        return ['broadcast',
            'database',
            $this->verification->canISendMail() ? SendGridChannel::class: null,
            $this->verification->thisIsMyFirstRequest() ? 'mail' : null,
            TwilioChannel::class
        ];

    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'messsage' => 'tienes una nueva solicitud',
            'usuario' => $this->booking->User->name,
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'messsage' => 'tienes una nueva solicitud',
            'usuario' => $this->booking->User,
            'is_active' => $this->booking->isActive(),
            'mode' => ($this->booking->mode == 1)?'presencial':'virtual',
            'has_payment' => $this->booking->hasPayment(),
            'status' => $this->booking->status,
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // return (new MailMessage)
        //             ->greeting('Primera solicitud!')
        //             ->to('hello@getvico.com')
        //             ->subject('la primera solicitud para '.$this->booking->manager()->name)
        //             ->line('Esta es la primera vez que le hacen una solicitud')
        //             ->line('Solicitud para: '.$this->booking->Room->House->name)
        //             ->line('Habitacion: '.$this->booking->Room->number);

        return (new Mailable($this->data))->to('hello@getvico.com');
    }

    public function toSendGrid($notifiable)
    {
        return (new SendGridInfo)->to($this->tos);
    }
}
