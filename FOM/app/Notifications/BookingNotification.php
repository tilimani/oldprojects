<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class BookingNotification extends Notification
{
    use Queueable;

    public $booking_id;

    public $status;

    public $sender;

    public $message;

    public $user_name;

    public $user_image;
    
    public $country_icon;

    public $manager_name;

    public $manager_image;

    public $manager_country_icon;

    public $house_id;

    public $room_id;

    public $room_number;

    public $room_nickname;

    public $house_name;

    public $booking_message;

    public $ismessage;

    public $destination;

    public $user;

    public $manager;

    public $date_from;

    public $date_to;

    public $user_genere;

    public $user_age;

    public $user_nationallity;
    
    public $manager_genere;

    public $manager_age;

    public $manager_nationallity;

    public $depositPrice;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Booking $booking, $mode = false, $message = '', $sender = false)
    {
        $room = $booking->room;
        $house = $room->house;
        $user = $booking->user;
        $user_country = $user->country;
        $manager = $booking->manager();
        $manager_country = $manager->country;
        $status = (int) $booking->status;

        
        $this->user_name = $user->name;

        $this->user_lastname = $user->last_name;

        $this->user_image = $user->image;
        
        $this->country_icon = $user_country->icon;

        $this->manager_name = $manager->name;

        $this->manager_lastname = $manager->last_name;

        $this->manager_image = $manager->image;

        $this->manager_country_icon = $manager_country->icon;

        $this->room_id = (int) $room->id;

        $this->room_number = (int) $room->number;

        $this->room_nickname = ($room->nickname === null) ? 'La que no tiene nombre.': $room->nickname;

        $this->house_name = $house->name;

        $this->house_id = $house->id;

        $this->booking_id = (int) $booking->id;

        $this->status = $status;

        $this->booking_message = $booking->message;

        $this->booking_mode = $booking->mode;

        $this->user_id = $user->id;

        $this->user = $user;

        $this->manager = $manager;

        $this->updated_at = $booking->updated_at;

        $this->vico_count = count($manager->houses);

        $this->date_from = Carbon::parse($booking->date_from)->format('d.m.y');

        $this->date_to = Carbon::parse($booking->date_to)->format('d.m.y');

        $this->user_age = (isset($user->brithdate)) ? Carbon::parse($user->birthdate)->diffInYears(Carbon::now()): '';
        
        $this->user_genere = ($user->gender === 1) ? 'Hombre': 'Mujer';

        $this->user_nationallity = $user->country;

        $this->manager_age = (isset($manager->brithdate)) ? Carbon::parse($manager->birthdate)->diffInYears(Carbon::now()): '';
        
        $this->manager_genere = ($manager->gender === 1) ? 'Hombre': 'Mujer';

        $this->manager_nationallity = $manager->country;


        // if (count($booking->payments->where('type', 'deposit')) > 0) {
        //     $this->depositPrice = $booking->payments->where('type', 'deposit')->first()->amountCop;
        // }
        $this->depositPrice = $booking->deposit;

        if ($mode) {
            $this->ismessage = true;
            $this->message = $message;
            $this->sender = $sender;
        } else {
            $this->ismessage = false;
            switch ($status) {
            case 1:
                // '1' => 'espera de aceptacion',
                $message = 'Espera de aceptacion';
                $this->message = $message;
                break;
            case 2:
                // '2' => 'espera de confirmacion estudiante',
                $message = 'Espera de confirmacion estudiante';
                $this->message = $message;
                break;
            case 3:
                // '3' => 'espera de reserva dueño',
                $message = 'Espera de reserva dueño';
                $this->message = $message;
                break;
            case 4:
                // '4' => 'espera de pago al propietario',
                $message = 'Plazo de pago';
                $this->message = $message;
                break;
            case 50:
                // '50' => 'espera confirmacion de screenshot',
                $message = 'Espera confirmacion de screenshot';
                $this->message = $message;
                break;
            case 5:
                // '5' => 'estudiante en vico',j F
                $message 
                    = 'Fechas: '.
                    Carbon::parse($booking->date_from)->format('j F')
                    .' - '.
                    Carbon::parse($booking->date_to)->format('j F');
                $this->message = $message;
                break;
            case -73:
                // '-73' => 'calificado terminacion extraordinaria',
                $message = 'Calificado terminacion extraordinaria';
                $this->message = $message;
                break;
            case -72:
                // '-72' => 'calificado por propietario terminacion extraordinaria',
                $message = 'Calificado por propietario terminacion extraordinaria';
                $this->message = $message;
                break;
            case -71:
                // '-71' => 'calificado por estudiante terminacion extraordinaria',
                $message = 'Calificado por estudiante terminacion extraordinaria';
                $this->message = $message;
                break;
            case -70:
                // '-70' => 'calificado terminacion extraordinaria',
                $message = 'Calificado terminacion extraordinaria';
                $this->message = $message;
                break;
            case -6:
                // '-6' => 'espera calificacion terminacion extraordinaria',
                $message = 'Espera calificacion terminacion extraordinaria';
                $this->message = $message;
                break;
            case -50:
                // '-50' => 'screenshot denegado',
                $message = 'Screenshot denegado';
                $this->message = $message;
                break;
            case -5:
                // '-5' => 'estudiante no llega',
                $message = 'Estudiante no llega';
                $this->message = $message;
                break;
            case -4:
                // '-4' => 'estudiante no paga',
                $message = 'Estudiante no paga';
                $this->message = $message;
                break;
            case -3:
                // '-3' => 'estudiante no contesta',
                $message = 'Cancelado por inactividad';
                $this->message = $message;
                break;
            case 23:
                //'23' => 'rechazado por estudiante',
                $message = 'Sujerencia Rechazada por estudiante';
                $this->message = $message;
            case -22:
                // '-22' => 'perfil no apto',
                $message = 'Perfil no apto';
                $this->message = $message;
                break;
            case -21:
                // '-21' => 'no disponible',
                $message = 'No disponible';
                $this->message = $message;
                break;
            case -11:
                // '-11' => 'propietario no contesta',
                $message = 'Propietario no contesta';
                $this->message = $message;
                break;
            case -2:
                // '-2' => 'cancelado por propietario',
                $message = 'Cancelado por propietario';
                $this->message = $message;
                break;
            case -1:
                // '-1' => 'cancelado por usuario',
                $message = 'Cancelado por usuario';
                $this->message = $message;
                break;
            default:
    
            }
        }
    }

    /**
     * Get the notification's delivery channels.
     *  If a massive notification task is needed, disable broadcast
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast', 'database'];
        // return ['database'];
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
        if($notifiable->role_id == 2 || $notifiable->role_id == 1){
            return [
                'booking_id'    =>  $this->booking_id,
                'status'    =>  $this->status,
                'message'    =>  $this->message,
                'role_id'   =>  $notifiable->role_id,
                'user_id' => $this->user_id,
                'user_name' =>  $this->user_name,
                'user_lastname' =>  $this->user_lastname,
                'user_image' =>  $this->user_image,   
                'user_age' => $this->user_age,
                'user_genere' => $this->user_genere,
                'user_nationallity' => $this->user_nationallity,             
                'country_icon' =>  $this->country_icon,
                'room_id' => $this->room_id,
                'room_number' =>  $this->room_number,
                'room_nickname' =>  $this->room_nickname,
                'house_name' =>  $this->house_name,
                'booking_message'   =>  $this->booking_message,
                'booking_mode' => $this->booking_mode,
                'sender'   =>  $this->sender,
                'ismessage' =>  $this->ismessage,
                'updated_at'    =>  $this->updated_at,
                'vico_count'    =>  $this->vico_count,
                'date_from'     =>  $this->date_from,
                'date_to'       =>  $this->date_to,
                'depositPrice'  =>  $this->depositPrice,
                'house_id'  =>  $this->house_id
            ];
        }
        else{
            return [
                'booking_id'    =>  $this->booking_id,
                'status'    =>  $this->status,
                'message'    =>  $this->message,
                'role_id'   =>  $notifiable->role_id,
                'user_id' => $this->manager->id,
                'user_name' =>  $this->manager_name,
                'user_lastname' =>  $this->manager_lastname,
                'user_image' =>  $this->manager_image,
                'user_age' => $this->manager_age,
                'user_genere' => $this->manager_genere,
                'user_nationallity' => $this->manager_nationallity,               
                'country_icon' =>  $this->manager_country_icon,
                'room_id' => $this->room_id,
                'room_number' =>  $this->room_number,
                'room_nickname' =>  $this->room_nickname,
                'house_name' =>  $this->house_name,
                'booking_message'   =>  $this->booking_message,
                'booking_mode' => $this->booking_mode,
                'sender'   =>  $this->sender,
                'ismessage' =>  $this->ismessage,
                'updated_at'    =>  $this->updated_at,
                'vico_count'    =>  $this->vico_count,
                'date_from'     =>  $this->date_from,
                'date_to'       =>  $this->date_to,
                'depositPrice'  =>  $this->depositPrice,
                'house_id'  =>  $this->house_id
            ];            
        }
        
    }
}
