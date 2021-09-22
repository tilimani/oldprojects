<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Booking;
use App\Message;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the messages given a Booking
     *
     * @param  Booking  $booking Booking's id
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {             
        // $messages = collect();
        // $first_message = $booking->message;
        // if( $first_message != "Sin message."){
        //     $messages->push( $first_message);
        // }
        // $messages = $messages->toBase()->merge($booking->messages()->orderBy('created_at','ASC')->get());
        $firstMessage = new Message;
        $firstMessage->message = $booking->message;
        $firstMessage->status = 1;
        $firstMessage->destination = 0;
        $firstMessage->read = 2;
        $firstMessage->created_at = now();       
        $firstMessage->updated_at = now();
        $firstMessage->bookings_id = $booking->id;
        $messages = array();
        array_push($messages, $firstMessage);
        foreach ($booking->messages->sortBy('created_at') as $message) {
            array_push($messages, $message);
        }
        return response()->json($messages, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
