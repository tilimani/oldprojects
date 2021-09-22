<?php

namespace App\Http\Controllers;

use App\Room;
use App\House;
use App\Booking;
use App\Homemate;
use App\ImageRoom;
use App\RuleHouse;
use Carbon\Carbon;
use App\DeviceRoom;
use App\ImageHouse;
use App\DeviceHouse;
use App\Verification;
use App\VicoRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Twilio\Twiml\MessagingResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        if(Auth::user() || true)
        {
            $query = DB::table('houses')->join('rooms','rooms.house_id','=','houses.id');
            $query = DB::table('houses')->join('image_houses','image_houses.house_id','=','houses.id');
            $query = DB::table('houses')->join('managers','managers.id','=','houses.manager_id');
            $houses=$query->select('houses.id','houses.name','houses.address','houses.neighborhood_id',
                DB::raw("(SELECT MIN(rooms.price) FROM rooms WHERE rooms.house_id = houses.id) as min_price"),
                DB::raw("(SELECT COUNT(rooms.house_id) FROM rooms WHERE rooms.house_id = houses.id AND rooms.available_from <= now()) as available_rooms"),
                DB::raw("(SELECT MIN(rooms.available_from) FROM rooms WHERE rooms.house_id = houses.id) as min_date"))
            ->orderBy('managers.vip','desc')
            ->groupBy(['houses.id','houses.name','houses.address','managers.vip','houses.neighborhood_id'])
            ->get();

            foreach ($houses as $house) {
                $house->image = ImageHouse::where('house_id', '=', $house->id)->orderBy('priority')->firstOrFail();
            }

            return view('admin.index', [
                'houses' => $houses,
            ]);
        }
        return redirect('/');
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
    public function update(Request $request)
    {
        //
    }

    /**
     * Show the dashboard for user links.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboardForAdmin()
    {
        $verifications = Verification::where('document_image','!=',"")->where('document_verified','=', '')->get();
        $count = $verifications->count();
        
        $active_bookings = Booking::where('status', '=', '5')->get()->count();
        $open_requests = Booking::where('status', '=', '1')->get()->count();

        $bad = VicoRating::where('rating', '<', "7")->get()->count();
        $good = VicoRating::where('rating', '>', "8")->get()->count();

        $net_promoter_score = $good - $bad;


        // 1 - Request
        // 4 - Approved
        // 5 - Actively living there




        return view('admin.dashboard', compact('count', 'active_bookings', 'net_promoter_score', 'open_requests'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        
        if(isset($request->eliminar_vico))
        {
            // for($i = 0; $i < count($request->eliminar_vico); $i++){
            //     $house_id = $request->eliminar_vico[$i];
            //     $query_deviceHouse = DeviceHouse::where('house_id', '=', $house_id);
            //     $query_imageHouse = ImageHouse::where('house_id', '=', $house_id);
            //     $query_houseRules = RuleHouse::where('house_id', '=', $house_id);
            //     $query_homemates = Homemate::where('house_id', '=', $house_id);
            //     $query_houseRooms = Room::where('house_id', '=', $house_id);
            //     if($query_deviceHouse->select('device_houses.house_id')->count() > 0){
            //         $query_deviceHouse->delete();
            //     }
            //     if($query_imageHouse->select('image_houses.house_id')->count() > 0){
            //         $query_imageHouse->delete();
            //     }
            //     if($query_houseRules->select('rule_houses.house_id')->count() > 0){
            //         $query_houseRules->delete();
            //     }
            //     if($query_homemates->select('homemates.house_id')->count() > 0){
            //         $query_homemates->delete();
            //     }
            //     if($query_houseRooms->count() > 0){
            //         foreach ($query_houseRooms->get() as $room) {
            //             # code...
            //             $roomId = $room->id;
            //             $query_roomDevices = DeviceRoom::where('room_id', '=', $roomId);
            //             $query_roomImages = ImageRoom::where('room_id', '=', $roomId);
            //             if($query_roomDevices->select('device_rooms.room_id')->count() > 0){
            //                 $query_roomDevices->delete();
            //             }
            //             if($query_roomImages->select('image_rooms.room_id', 'image_rooms.id')->count() > 0){
            //                 foreach ($query_roomImages->get() as $image) {
            //                     # code...
            //                     $image->delete();
            //                 }
            //             }
            //             Room::where('house_id', '=', $house_id)->where('id', '=', $roomId)->delete();
            //         }
            //     }

            //     House::where('id', '=', $house_id)->forceDelete();
                
            // }

            foreach ($request->eliminar_vico as $id) {
                $house = House::findOrFail($id);
                $house->delete();

            }
        }



        return back();
    }

    public function whatsappBoard()
    {
        $response = new MessagingResponse();
        $message = $response->message('');
        $message->body('Hello World!');
        $response->redirect('https://demo.twilio.com/welcome/sms/');
        $response = new MessagingResponse();
        $response->message("The Robots are coming! Head for the hills!");
        print $response;
        dd($response);
        // return view('admin.whatsapp');
    }
}
