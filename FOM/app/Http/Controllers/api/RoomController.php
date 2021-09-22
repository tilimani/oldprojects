<?php

namespace App\Http\Controllers\api;

use App\Room;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoomController extends Controller
{
	public function getRoomsById(Request $request)
    {        
        $rooms = Room::whereIn('id',$request->roomIds)->get();
    	return response()->json($rooms);
    }

    public function getRoomById(Request $request)
    {
        $room = Room::find($request->roomId);
        $bookings = $room->bookings()->select('date_from', 'date_to')->where('status','=',"5")->get();
        $house = $room->House;
        $room_images = $room->images;
        $room_data = collect();
        $room_data['room'] = $room; 
        $room_data['dates'] = $bookings;
        $room_data['images'] = $room_images;
        $room_data['house'] = $house;
        $room_data['manager'] = $house->Manager->user;
        $room_data['is_vip'] = $house->Manager->vip;
        $room_data['verification'] = $house->Manager->user->verification;
        $room_data['min_stay'] = $house->house_rules()->select('description')->where('rule_id','=','2')->get();
        $room_data['time_advance'] = $house->house_rules()->select('description')->where('rule_id','=','7')->get();
        return response()->json($room_data);
    }
}