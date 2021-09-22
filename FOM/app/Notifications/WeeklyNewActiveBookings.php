<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Channels\SendGridChannel;
use SendGrid\Mail\To;
use App\Verification;
use Carbon\Carbon;

class WeeklyNewActiveBookings extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    /**
     * Instance of To for sendgrid
     *
     * @var To
    */
    public $tos;

    /**
     * Templade in SendGrid
     *
     * @var id_template
    */
    public $id_template = 'd-979e98cf4ed94ea99a9d45da50bb2ffd';


    public function __construct($manager, $bookings)
    {
        $bookings_info = array();
        foreach ($bookings as $booking) {
            switch ($booking->status) {
            case 1:
                // '1' => 'espera de aceptacion',
                $message = 'Espera de aceptacion';
                break;
            case 2:
                // '2' => 'espera de confirmacion estudiante',
                $message = 'Espera de confirmacion estudiante';
                break;
            case 3:
                // '3' => 'espera de reserva dueño',
                $message = 'Espera de reserva dueño';
                break;
            case 4:
                // '4' => 'espera de pago al propietario',
                $message = 'Plazo de pago';
                break;
            case 50:
                // '50' => 'espera confirmacion de screenshot',
                $message = 'Espera confirmacion de screenshot';
                break;
            case 5:
                // '5' => 'estudiante en vico',j F
                $message 
                    = 'Estudiante en VICO, Fechas: '.
                    Carbon::parse($booking->date_from)->format('d/m/Y')
                    .' - '.
                    Carbon::parse($booking->date_to)->format('d/m/Y');
                break;
            case -73:
                // '-73' => 'calificado terminacion extraordinaria',
                $message = 'Calificado terminacion extraordinaria';
                break;
            case -72:
                // '-72' => 'calificado por propietario terminacion extraordinaria',
                $message = 'Calificado por propietario terminacion extraordinaria';
                break;
            case -71:
                // '-71' => 'calificado por estudiante terminacion extraordinaria',
                $message = 'Calificado por estudiante terminacion extraordinaria';
                break;
            case -70:
                // '-70' => 'calificado terminacion extraordinaria',
                $message = 'Calificado terminacion extraordinaria';
                break;
            case -6:
                // '-6' => 'espera calificacion terminacion extraordinaria',
                $message = 'Espera calificacion terminacion extraordinaria';
                break;
            case -50:
                // '-50' => 'screenshot denegado',
                $message = 'Screenshot denegado';
                break;
            case -5:
                // '-5' => 'estudiante no llega',
                $message = 'Estudiante no llega';
                break;
            case -4:
                // '-4' => 'estudiante no paga',
                $message = 'Estudiante no paga';
                break;
            case -3:
                // '-3' => 'estudiante no contesta',
                $message = 'Cancelado por inactividad';
                break;
            case -22:
                // '-22' => 'perfil no apto',
                $message = 'Perfil no apto';
                break;
            case -21:
                // '-21' => 'no disponible',
                $message = 'No disponible';
                break;
            case -11:
                // '-11' => 'propietario no contesta',
                $message = 'Propietario no contesta';
                break;
            case -2:
                // '-2' => 'cancelado por propietario',
                $message = 'Cancelado por propietario';
                break;
            case -1:
                // '-1' => 'cancelado por usuario',
                $message = 'Cancelado por usuario';
                break;
            default:
            }

            $booking_data = array();
            $booking_data += ['house_name' => $booking->Room->House->name];
            $booking_data += ['room_number' => $booking->Room->number];
            $booking_data += ['status' => $message];

            array_push($bookings_info, $booking_data);
        }



        $this->tos = new To(
            $manager->email,
            $manager->name,
            [
                'manager_name' => $manager->name,
                'bookings' => $bookings_info
            ]
        );
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
        return ($verification->canISendMail())? [SendGridChannel::class] : [];
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
