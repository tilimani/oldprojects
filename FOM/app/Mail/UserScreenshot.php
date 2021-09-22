<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserScreenshot extends Mailable
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
    public $manager_image;
    public $date_from;
    public $date_to;
    public $manager_phone;
    public $house_adress;
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
        $this->manager_image = $data['manager_image'];
        $this->date_from = $data['date_from'];
        $this->date_to = $data['date_to'];   
    }

    /**
     * Build the message.
     *
     * @return $this
    */
    public function build()
    {
        return $this->from('hello@getvico.com', 'VICO - ¡Vivir entre amigos!')
                    ->subject('Screenshot hochgelanden')
                    ->view('emails.bookings.screenshot');
    }
}
