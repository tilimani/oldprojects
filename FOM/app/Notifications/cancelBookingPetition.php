<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\Booking;
use App\Verification;

class cancelBookingPetition extends Notification
{
    use Queueable;
    private $user;
    private $booking;
    private $information;
    private $source_role;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($source_role,User $user, Booking $booking, $information)
    {
        $this->user = $user;
        $this->booking = $booking;
        $this->information = $information;
        $this->source_role = $source_role;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        //find or create user verifications credentials
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
        if ($this->source_role!=1) {
            return (new MailMessage)
                    ->subject($this->source_role==3 ? 'Cancelación de estadía': 'Cancelación de solicitud')
                    ->level('Success')
                    ->greeting('Hola '.$this->user->name.'!')
                    ->line('Hemos recibido tu solicitud de cancelación, en poco días estaremos contactandote.')
                    ->line('Razón de la cancelación: '.$this->information['problem'])
                    ->line('Detalles: '.$this->information['explanation_details'])
                    ->line('Team VICO <3');
        }
        elseif ($this->source_role==1) {
            return (new MailMessage)
                    ->subject(''.$this->user->role_id == 3 ? 'Cancelación de booking por usuario':'Cancelación de booking por manager'.': '.$this->booking->id)
                    ->level('Success')
                    ->greeting($this->user->role_id == 3 ? 'Usuario ':'Manager '.$this->user->name.' quiere cancelar la vico.')
                    ->line('Id Usuario: '.$this->user->id)
                    ->line('Correo: '.$this->user->email)
                    ->line('Telefono: '.$this->user->phone)
                    ->line('Booking: '.$this->booking->id)
                    ->line('Razón de la cancelación: '.$this->information['problem'])
                    ->line('Detalles: '.$this->information['explanation_details']);
        }
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
