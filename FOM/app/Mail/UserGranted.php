<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserGranted extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $house_id;
    public $house_name;
    public $room_number;
    public $room_price;
    public $room_total;
    public $room_image;
    public $booking_id;
    public $manager_name;
    public $manager_lastname;
    public $manager_image;
    public $manager_email;
    public $date_from;
    public $date_to;
    public $encrypted;
    public $currency;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->name = $data['name'];
        $this->house_id = $data['house_id'];
        $this->house_name = $data['house_name'];
        $this->room_number = $data['room_number'];
        $this->room_price = $data['room_price'];
        $this->room_total = $data['room_total'];
        $this->room_image = $data['room_image'];
        $this->booking_id = $data['booking_id'];
        $this->manager_name = $data['manager_name'];
        $this->manager_lastname = $data['manager_lastname'];
        $this->manager_image = $data['manager_image'];
        $this->manager_email = $data['manager_email'];
        $this->date_from = $data['date_from'];
        $this->date_to = $data['date_to'];   
        $this->encrypted = $data['encrypted'];
        $this->currency = $data['currency'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('hello@getvico.com', 'VICO - ¡Vivir entre amigos!')
                    ->subject('🏃🏃 Tienes 24 horas para pagar tu reserva! '.$this->house_name.' - Hab.'.$this->room_number)
                    ->view('emails.bookings.user_4_granted');
    }
}