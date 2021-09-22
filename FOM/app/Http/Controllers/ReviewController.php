<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\User;
use App\Booking;
use App\Habitant;
use App\Room;
use App\QualificationHouse;
use App\QualificationNeighborhood;
use App\QualificationRoom;
use App\QualificationUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    /**
     * Obtiene la información actual del booking
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getvico($id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        $idRoom = DB::table('bookings')->where('user_id', $id)->value('room_id');
        $idHouse = DB::table('rooms')->where('id', $idRoom)->value('house_id');
        $room = DB::table('rooms')->where('id', $idRoom)->get();
        $house = DB::table('houses')->where('id', $idHouse)->get();
        $booking = DB::table('bookings')->where('user_id', $id)->get();
        $images = DB::table('image_rooms')->where('room_id', $idRoom)->get();
        return view('customers.uservico', [
            'user' => $user,
            'room' => $room,
            'house' => $house,
            'booking' => $booking,
            'image_room' => $images
        ]);


    }
    /**
     * Muestra la información de la review
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showReview($id){
        $user = DB::table('users')->where('id', $id)->get();
        $idRoom = DB::table('bookings')->where('user_id', $id)->value('room_id');
        $idHouse = DB::table('rooms')->where('id', $idRoom)->value('house_id');
        $room = DB::table('rooms')->where('id', $idRoom)->get();
        $house = DB::table('houses')->where('id', $idHouse)->get();
        $booking = DB::table('bookings')->where('user_id', $id)->get();
        $image_house = DB::table('image_houses')->where('house_id', $idHouse)->first();
        return view('customers.review', [
            'user' => $user,
            'room' => $room,
            'house' => $house,
            'booking' => $booking,
            'image_house' => $image_house
        ]);
    }

    public function showFomComment($id){
        $user = DB::table('users')->where('id', $id)->get();
        return view('customers.fomquestion', [
            'user' => $user
        ]);
    }
}
