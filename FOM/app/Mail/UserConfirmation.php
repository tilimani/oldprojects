<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Barryvdh\DomPDF\PDF;
use App\Currency;
use App\Booking;

class UserConfirmation extends Mailable
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
    public $manager_phone;
    public $house_adress;
    public $payment_charge_id;
    public $payment_amountCop;
    // public $pdf;
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
        $this->manager_phone = $data['manager_phone'];
        $this->house_adress = $data['house_adress'];
        $this->payment_charge_id = $data['payment_charge_id'];
        $this->payment_amountCop = $data['payment_amountCop'];

        // $booking = Booking::find($data['booking_id']);
        // $user = $booking->User->first();
        // $room = $booking->Room->first();
        // $house = $room->House->first();
        // $manager = $house->manager()->first()->user()->first();
        // $currency = new Currency();
        // $currency = $currency->getCurrentCurrency();

        // $dataPDF = [
        //     'house'=>$house,
        //     'booking'=>$booking,
        //     'room'      => $room,
        //     'user'      => $user,
        //     'manager'   => $manager,
        //     'payment'   => $data['payment'],
        //     'payment_date' => $data['payment']->created_at->format('d.m.Y h:i a'),
        //     'currency' => $currency
        // ];

        // $this->pdf = \PDF::loadView(
        //     'payments.final.sections.confirmationPDF',
        //     [
        //         'data'=>$dataPDF
        //     ]
        // ); 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('hello@getvico.com', 'VICO - ¡Vivir entre amigos!')
                    ->subject('¡Pago exitoso! Hab. '.$this->room_number.' - '.$this->house_name)
                    ->view('emails.bookings.user_5_confirmation');
                    // ->attachData($this->pdf->output(), 'ConfirmacionPagoVICO.pdf');
    }
}
