<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Room;
use App\House;
use App\ImageRoom;
use App\RuleRoom;
use App\DevicesRoom;
use App\Device;
use App\Rule;
use App\Booking;
use App\Country;
use App\Verification;
use App\User;
use App\Homemate;
use Illuminate\Http\Request;
use App\Events\BookingWasChanged;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Mail;
use App\City;
use Illuminate\Support\Str;
use App\Notifications\BookingNotification;
use App\Notifications\NewRequest;
use App\Http\Controllers\SegmentController as Analytics;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('manager_room', ['only' => 'edit']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $id_house)
    {
        $rooms = Room::where('id_house', $id_house);

        return view('rooms.index', [
            'rooms' => $rooms,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id_house)
    {
        // dd(Rule::all());
        $count = DB::table('rooms')->select('rooms.number', 'rooms.house_id')
        ->where('house_id', '=', $id_house)->count();
        return view('rooms.create', [
            'houses' => House::all(),
            'rules' => Rule::all(),
            'devices' => Device::all(),
            'id_house' =>$id_house,
            'count' =>$count
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd($request->all());
        //dd($request);

       $request->validate([
           'number' => 'required',
           'price' => 'required',
           'bed_type' => 'required',
           'bath_type' => 'required',
           'desk' => 'required',
           'window_type' => 'required',
           'house' => 'required',
           'available_from' => 'required',
           'has_tv' => 'required',
           'has_closet' => 'required'
       ]);

        try {
//
            DB::beginTransaction();
//
            $room = new Room();
            $room->number = $request->number;
            $room->description = $request->description;
            $room->house_id = $request->house;
//            $room->bed_type = $request->bed_type;
//            $room->window_type = $request->window_type;
//            $room->desk = $request->desk;
//            $room->main_image = "temp";
//            $room->bath_type = $request->bath_type;
            $available_from = Carbon::createFromFormat('d/m/Y', $request->available_from)->toDateTimeString();
            $room->available_from = $available_from;
            $room->price = $request->price;
            $room->price_for_two = $request->price_for_two;
//            $room->has_tv = $request->has_tv;
            // dd($room);
            $room->save();

//
            $device_room = new DevicesRoom();
            $device_room->room_id = $room->id;
            $device_room->bed_type = $request->bed_type;
            $device_room->bath_type = $request->bath_type;
            $device_room->desk = $request->desk;
            $device_room->windows_type = $request->window_type;
            $device_room->tv = $request->has_tv;
            $device_room->closet = $request->has_closet;

            // dd($device_room);
            $device_room->save();



           $s3 = Storage::disk('s3');
//            $main_image = $request->file('main-image')[0];
//            $s3->put('room_'.$room->id.'.'.$main_image->extension(), file_get_contents($main_image), 'public');
////            $room->main_image = env("AWS_URL").'room_'.$room->id.'.'.$main_image->extension();
//
////            $room->save();
//

                        for ($i=0; $i < count($request->file('second-image')); $i++) {

              $second_images = $request->file('second-image')[$i];

              // dd($second_images->extension());
              if($second_images->getClientMimeType() === "image/jpeg" || $second_images->getClientMimeType() === "image/png"){
                $time = Carbon::now();
                $time=$time->year.$time->month.$time->day.$time->hour.$time->minute.$time->second;
                $s3->put('room_'.$room->id."_".$i."_".$time.".".$second_images->extension()
                        , file_get_contents($second_images)
                        , 'public');

                $image_room = new ImageRoom();
                // dd($image_room);
                $image_room->room_id = $room->id;
                $image_room->image ='room_'.$room->id."_".$i."_".$time.".".$second_images->extension();
                $image_room->priority = $i;
                $image_room->save();
              }
}

            // for ($i=0; $i < count($request->file('second-image')); $i++) {

            //     $second_images = $request->file('second-image')[$i];

            //     $s3->put('room_'.$room->id."_".$i.".".$second_images->extension()
            //             , file_get_contents($second_images)
            //             , 'public');

            //     $image_room = new ImageRoom();
            //     // dd($image_room);
            //     $image_room->room_id = $room->id;
            //     $image_room->image ='room_'.$room->id."_".$i.".".$second_images->extension();
            //     $image_room->priority = $i;
            //     $image_room->save();
            // }

            DB::commit();
//
        }
        catch (\PDOException $e) {
            DB::rollBack();
            return $e;
        }
//
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(int $id_house, Room $room)
    {
        return view('rooms.show', [
            'room' => $room,
        ]);
    }

    /**
     * Display the specified resource.
     * Updated to eloquent
     * @param  App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function reservation(Room $room)
    {
        // $house = DB::table('houses')->where('id', '=', $room->house_id)->first();

        // $rules = DB::table('rule_houses')->where('house_id', '=', $house->id)->get();

        $house = $room->house;

        $rules = $house->rules;

        for ($i=0; $i < count($room->house->Rules); $i++) {
            $room->house->Rules[$i]->description = $rules[$i]->description;
        }

        return view('rooms.reservation', [
            'room' => $room
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reserve(Request $request)
    {
        $room = DB::table('rooms')->where('rooms.id', '=', $request->room_id)->get();
        $house = DB::table('houses')->where('id', '=', $room[0]->house_id)->get();
        //dd($house);
        try {
            DB::beginTransaction();
            $booking = new Booking();
            $booking->status = 1;
            $booking->date_from = $request->datefrom;
            $booking->date_to = $request->dateto;
            $booking->room_id = $request->room_id;
            $booking->user_id = Auth::user()->id;
            $booking->mode = $request->options;
            // 2/3 Discount Code in Database
            $booking->vico_referral_id = $request->referral;
            $user = User::findOrFail($booking->user_id);
            if (isset($request->message))
            {
                $message = preg_replace('/([1-9]+[\- ]?[1-9]+[\- ]?[1-9])/','*****',$request->message);
                $booking->message = $message;
            }else
            {
                $booking->message = $user->name." está interesado en su habitación";
            }
            // dd($booking);
            $booking->save();
            event(new BookingWasChanged($booking));
            $user = $booking->user;
            $manager = $booking->room->house->manager->user;
            $user->notify(new BookingNotification($booking));
            $manager->notify(new BookingNotification($booking));
            $manager->notify(new NewRequest($manager,$booking));
            DB::commit();
        }
        catch (\PDOException $e) {
            DB::rollBack();
            return $e;
        }
        try{
            $data = [
                'booking_id' => $booking->id,
                'email' => Auth::user()->email,
                'subject' => 'Tu solicitud esta en proceso!',
                'bodyMessage' => 'Sent from VICO - ¡Vivir entre amigos!',
                'datefrom' => $request->datefrom,
                'dateto' => $request->dateto,
                'message_student' => $request->message,
                'room_id' => $request->room_id,
                'room_num' => $room[0]->number,
                'house_name' => $house[0]->name,
                // 'how_long' => $request->how_long,
                'room_price' => $room[0]->price,
                'name' => Auth::user()->name,
                'last_name' => Auth::user()->last_name,
                //    'are' => Auth::user()->are,
                //   'where_study' => Auth::user()->where_study,
                'phone' => Auth::user()->phone,
                'user_id' => Auth::user()->id,
                'option' => $request->options,
                'referral' => $request->referral,
            ];
            // Mail::send('rooms.mail_estudiante', $data, function ($message) use ($data) {
            //     $message->from('friendsofmedellin@gmail.com', 'VICO - ¡Vivir entre amigos!');
            //     if(Auth::user()->email_spam !=  NULL){
            //         $message->to(Auth::user()->email_spam);
            //     }
            //     else{
            //         $message->to($data['email']);
            //     }
            //     $message->subject($data['subject']);
            // });
            Mail::send('rooms.mail_friendsofmedellin', $data, function ($message) use ($data) {
                $message->from('hello@getvico.com', 'VICO - ¡Vivir entre amigos!');
                $message->to('sebastian@getvico.com');
                $message->subject($data['house_name'].' Room: '.$data['room_num'].' Rent: '.$data['room_price'].' Booking id: '.$data['booking_id']);
            });
            // SEGMENT TRACKING INIT-------------------
            if (env('APP_ENV')=='production' && Auth::user()->role_id!=1){
                Analytics::newBookingEvent($user, $manager, $booking, $room[0]);
            }
            // SEGMENT TRACKING END-------------------
        }
        catch(Exception $e){
        }
        finally{
            return redirect()->route('booking.success',$booking->id);
        }
    }

    public function reserveSuccess($id){
        if (\Session::has('city_code')) {
            $city_code = \Session::get('city_code');
            $city = City::where('city_code', $city_code)->first();
        } else {
            $city = City::where('city_code', 'MDE')->first();
        }
        $booking = Booking::find($id);

        $city_name = strtolower(Str::ascii($city->name));
        return view('rooms.confirmation',['booking' => $booking])->with(compact('city_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data = Room::findOrFail($id);
        $device_room = DB::table('devices_rooms')->select('bed_type','bath_type','desk','windows_type','tv','closet')->where('room_id', '=', $id)->get()->first();
        $images_room = DB::table('image_rooms')->where('room_id', '=', $id)->get();
        if(sizeof($images_room) == 0){
            $non_image = ['priority'=>'0','id'=>0,'room_id'=>$id,'image'=>'room_4.jpeg'];
            $non_image= (object) $non_image;
            for($j=0;$j<1;$j++){
              $images_room->push($non_image);
            }
        }
        foreach($images_room as $image){
            $image->priority=intval($image->priority);
        }
        $images_room=$images_room->sortBy('priority');
        // dd($images_room);

        $house = DB::table('houses')->select('houses.id', 'houses.name')->get();
        // dd($images_room);
        return view('rooms.edit', [
            'data' => $data,
            'images' => $images_room,
            'houses' => House::all(),
            'rules' => Rule::all(),
            'devices' => $device_room,
            'house' =>$house
        ]);
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
        $room = Room::findOrFail($request->id);
        $room->number = $request->number;
        $room->description = $request->description;
        $room->price_for_two = $request->price_for_two;
        $available_from = Carbon::createFromFormat('d/m/Y', $request->available_from)->toDateTimeString();
        $room->available_from = $available_from;
        $room->price = $request->price;
        $room->nickname = $request->nickname;
        $room->save();

        $device_room =  DevicesRoom::firstOrFail()->where('room_id', '=', $request->id);
        $device_room->update([
            'bed_type' => $request->bed_type,
            'bath_type'=> $request->bath_type,
            'desk' => $request->desk,
            'windows_type' => $request->window_type,
            'tv' => $request->has_tv,
            'closet' => $request->has_closet
        ]);
        foreach ($request->all() as $key => $value) {

            if (starts_with($key, 'image_')) {

                if ($value == '1') DB::table('image_rooms')->where('id', str_replace_first('image_', '', $key))->delete();

            }
        }

        if(isset($request->new_image_profile)){
            $s3 = Storage::disk('s3');
            $count_images= DB::table('image_rooms')->where('room_id', '=', $room->id)->count();

            foreach ($request->new_image_profile as $image) {
                $second_images = $image;
                $time = Carbon::now();
                $time=$time->year.$time->month.$time->day.$time->hour.$time->minute.$time->second;
                $s3->put('room_'.$request->id.'_'.$count_images."_".$time.".".$second_images->extension()
                        , file_get_contents($second_images)
                        , 'public');
                $image_room = new ImageRoom();
                $image_room->room_id = $request->id;
                $image_room->image ='room_'.$request->id.'_'.$count_images."_".$time.".".$second_images->extension();
                $image_room->priority = $count_images;
                $count_images++;
                $image_room->save();
            }
        }


        foreach($request->gallery as $index => $gallery){
            $image=ImageRoom::firstOrFail()->where('id', '=', $gallery);
            $image->update([
                'priority'=> $index
            ]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Room::findOrFail($id)->destroy();
        return redirect('/');
    }

    public function roomdata(Room $room){
      return $room;
    }

    /**
     *
     *
     */
    public function roomDataBooking($room_id){

        $user = Auth::user();

        $room=Room::where('id','=',$room_id)->firstOrFail();
        $bookings=$this->getBooking([5,100])->where('room_id','=',$room->id)->sortBy('date_to');
        $dates=[];
        foreach($bookings as $booking){
            if (Carbon::parse($booking->date_from) <= Carbon::parse($booking->date_to)) {
                $date_from=Carbon::parse($booking->date_from);
                $date_to=Carbon::parse($booking->date_to);
            } else {
                $date_from=Carbon::parse($booking->date_to);
                $date_to=Carbon::parse($booking->date_from);
            }
            $number_days=$date_to->diffInDays($date_from);
            for($i=0;$i<=$number_days;$i++){
                if (Carbon::parse($booking->date_from) <= Carbon::parse($booking->date_to)) {
                    $temp_date=Carbon::parse($booking->date_from);
                } else {
                    $temp_date=Carbon::parse($booking->date_to);
                }
                $temp_date=$temp_date->addDays($i)->toDateTimeString();
                $temp_date=explode(' ',$temp_date);
                array_push($dates,$temp_date[0]);
            }
        }
        $house = DB::table('houses')->where('id', '=', $room->house_id)->first();
        $manager_house=DB::table('managers')->where('id','=',$house->manager_id)->first();
        $manager=DB::table('users')->where('id','=',$manager_house->user_id)->first();
        $min_stay=DB::table('houses_rules')->where('rule_id','=',2)->where('house_id','=',$house->id)->first();
        $time_advance=DB::table('houses_rules')->where('rule_id','=',7)->where('house_id','=',$house->id)->first();
        $max_days=end($dates);

        $daysTour = [
          Carbon::now()->addDays(2)->format('D, d/m/y'),
          Carbon::now()->addDays(3)->format('D, d/m/y'),
          Carbon::now()->addDays(4)->format('D, d/m/y'),
          Carbon::now()->addDays(5)->format('D, d/m/y'),
          Carbon::now()->addDays(6)->format('D, d/m/y'),
          Carbon::now()->addDays(7)->format('D, d/m/y')
        ];

        $discount = null;
        if ($user ) {
            $bookings = $user->bookings();
            if (count($bookings->get()) > 0) {
                $referrals = $bookings->orderBy('created_at', 'desc')->first()->vicoreferrals();
                if (count($referrals->get()) > 0) {
                    $discount = $referrals->first()->id;
                }
            }
        }
        $view=view('rooms.ask_for_room', [
            'room' => $room,
            'manager' => $manager,
            'date' => $max_days,
            'min_stay' => $min_stay->description,
            'daysTour' => $daysTour,
            'discount'  =>  $discount

        ])->render();
        // dd($view);
        return [$dates,$view,$max_days,$time_advance->description,$min_stay->description];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeNew(Request $request)
    {
        // return $request;
        // return [$request->room['price']=== null];
        $room = new Room();
        $room->number = $request->room['number'];
        if ($request->room['description'] == '') {
            $description=null;
        } else {
            $description = $request->room['description'];
        }

        $room->description = $description;
        if ($request->room['price'] === null) {
            $room->price=9999999;
        } else {
            $room->price = $request->room['price'];
        }
        $room->house_id=$request->room['house'];
        $room->nickname=$request->room['nickname'];
        switch ($request->room['isAvailable']) {

        case '1':
            $room->available_from=Carbon::today();
            break;
        case '2':
            $room->available_from=Carbon::parse($request->room['unavailable']);
            $user = new User();
            $count = User::all()->last()->id+1;
            $user->country_id = $request->homemate['country'];
            $user->gender = $request->homemate['gender'];
            $user->name = $request->homemate['name'];
            $user->role_id = 3;
            $user->email
                = $request->homemate['name'].$count.'@fakeuser.vico';
            $user->password
                = bcrypt(
                    $request->homemate['name'].
                    $request->homemate['gender'].
                    Carbon::now()->toDateTimeString()
                );
            $user->externalAccount = 0;
            $user->save();
            break;
        case '3':
            $room->available_from = Carbon::parse('9999-12-31');
            if (isset($request->homemate['country']) && isset($request->homemate['gender']) && isset($request->homemate['name'])) {
                $count = User::all()->last()->id+1;
                $user=new User();
                $user->country_id = $request->homemate['country'];
                $user->gender = $request->homemate['gender'];
                $user->name = $request->homemate['name'];
                $user->role_id = 3;
                $user->email = $request->homemate['name'].$count.'@fakeuser.vico';
                $user->password
                    = bcrypt(
                        $request->homemate['name'].
                        $request->homemate['gender'].
                        Carbon::now()->toDateTimeString()
                    );
                $user->externalAccount = 0;
                $user->save();
            }
            break;
        }

        if (isset($request->room['price_for_two'])) {
            $room->price_for_two = $request->room['price_for_two'];
        } else {
            $room->price_for_two = 0;
        }

        $room->save();
        $devices = new DevicesRoom();
        $devices->room_id = $room->id;
        $devices->bed_type = $request->devices['bed_type'];
        $devices->bath_type = $request->devices['bath_type'];
        isset($request->devices['desk']) ? $desk = 1:$desk = 0;
        isset($request->devices['has_closet']) ? $closet = 1:$closet = 0;
        isset($request->devices['has_tv']) ? $tv = 1:$tv = 0;
        $devices->desk = $desk;
        $devices->closet = $closet;
        $devices->tv = $tv;
        $devices->windows_type = $request->devices['windows_type'];
        $devices->save();
        if ($request->room['isAvailable'] === '2') {
            $booking = new Booking();
            $booking->user_id = $user->id;
            $booking->room_id = $room->id;
            $booking->date_from = Carbon::today();
            $booking->date_to = $request->room['unavailable'];
            $booking->status = 100;
            $booking->note = 'Fake Booking';
            $booking->save();
        } else if($request->room['isAvailable'] === '3' && isset($user)) {
            $booking = new Booking();
            $booking->user_id = $user->id;
            $booking->room_id = $room->id;
            $booking->date_from = Carbon::today();
            $booking->date_to = Carbon::parse('9999-12-31');
            $booking->status = 100;
            $booking->note = 'Fake Booking';
            $booking->save();
        }

        $count = DB::table('houses')
            ->select('rooms_quantity')
            ->where('id', '=', $room->house_id)->get();
        if ($count[0]->rooms_quantity == $room->number) {
            return ['last_item',$room->house_id];
        }
        $view_form = view(
            'rooms.create_form', [
                'houses' => House::all(),
                'rules' => Rule::all(),
                'devices' => Device::all(),
                'id_house' =>$room->house_id,
                'count' =>$count[0]->rooms_quantity,
                'countries' => Country::all()->sortBy('name'),
                'today_date' => Carbon::now()->toDateString()
            ]
        )->render();
        return [$view_form, $room->id];
    }

    public function updateNew(Request $request)
    {
        $room= Room::where('id','=',$request->room_id)->first();
        // return $request->room['number'];
        DB::beginTransaction();
        if($request->room['description'] == ''){
            $description='no hay descripcion';
        }
        else{
            $description=$request->room['description'];
        }
        DB::table('rooms')->where('id', '=', $request->room_id)->update([
            'number' =>$request->room['number'],
            'description' => $description,
            'price' => $request->room['price'],
            'nickname' => $request->room['nickname'],
        ]);
        DB::commit();
        switch ($request->room['isAvailable']) {
            case '1':
                DB::beginTransaction();
                DB::table('rooms')->where('id', '=', $request->room_id)->update([
                    'available_from' => Carbon::today()
                ]);
                DB::commit();
                break;
            case '2':
                DB::beginTransaction();
                DB::table('rooms')->where('id', '=', $request->room_id)->update([
                    'available_from' => $request->room['unavailable']
                ]);
                DB::commit();
                if (isset($request->user_id)) {
                    $user=User::where('id','=',$request->user_id)->first();
                    $user->update([
                        'country_id'=>$request->homemate['country'],
                        'gender' => $request->homemate['gender'],
                        'name' => $request->homemate['name']
                    ]);
                } else {
                    $user=new User();
                    $count=User::all()->last()->id+1;
                    $user->country_id=$request->homemate['country'];
                    $user->gender=$request->homemate['gender'];
                    $user->name=$request->homemate['name'];
                    $user->role_id=3;
                    $user->email=$request->homemate['name'].$count.'@fakeuser.vico';
                    $user->password=bcrypt($request->homemate['name'].$request->homemate['gender'].Carbon::now()->toDateTimeString());
                    $user->externalAccount=0;
                    $user->save();
                }

                break;
            case '3':
                DB::beginTransaction();
                DB::table('rooms')->where('id', '=', $request->room_id)->update([
                    'available_from' => Carbon::parse('9999-12-31')
                ]);
                DB::commit();
                if (isset($request->homemate['country']) && isset($request->homemate['gender']) && isset($request->homemate['name'])) {
                    if (isset($request->user_id)) {
                        $user=User::where('id','=',$request->user_id)->first();
                        $user->update([
                            'country_id'=>$request->homemate['country'],
                            'gender' => $request->homemate['gender'],
                            'name' => $request->homemate['name']
                        ]);
                    } else {
                        $user=new User();
                        $user->country_id=$request->homemate['country'];
                        $user->gender=$request->homemate['gender'];
                        $user->name=$request->homemate['name'];
                        $user->role_id=3;
                        $user->email=$request->homemate['name'].$count.'@fakeuser.vico';
                        $user->password=bcrypt($request->homemate['name'].$request->homemate['gender'].Carbon::now()->toDateTimeString());
                        $user->externalAccount=0;
                        $user->save();
                    }
                }
                break;
        }

        if (isset($request->room['price_for_two'])) {
            DB::beginTransaction();
            DB::table('rooms')->where('id', '=', $request->room_id)->update([
                'price_for_two' => $request->room['price_for_two']
            ]);
            DB::commit();
        } else {
            DB::beginTransaction();
            DB::table('rooms')->where('id', '=', $request->room_id)->update([
                'price_for_two' => 0
            ]);
            DB::commit();
        }

        DB::beginTransaction();
        // $devices =DevicesRoom::where('id','=',$request->room_id)->first();
        isset($request->devices['desk']) ? $desk=1:$desk=0;
        isset($request->devices['has_closet']) ? $closet=1:$closet=0;
        isset($request->devices['has_tv']) ? $tv=1:$tv=0;
        DB::table('devices_rooms')->where('room_id', '=', $request->room_id)->update([
            'bed_type' => $request->devices['bed_type'],
            'bath_type' => $request->devices['bath_type'],
            'desk' => $desk,
            'closet' => $closet,
            'tv' => $tv,
            'windows_type' => $request->devices['windows_type']
        ]);
        DB::commit();
        switch ($request->room['isAvailable']) {
            case '1':
                if(isset($request->booking_id)){
                    $booking=Booking::where('id','=',$request->booking_id)->first();
                    $user=User::where('id','=',$booking->user_id)->first();
                    $user->delete();
                    $booking->delete();
                }
                break;
            case '2':
                if(isset($request->booking_id)){
                    DB::beginTransaction();
                    DB::table('bookings')->where('id','=',$request->booking_id)->update([
                        'user_id' => $user->id,
                        'room_id' => $room->id,
                        'date_from' => Carbon::today(),
                        'date_to' => Carbon::parse($request->room['unavailable'])
                    ]);
                    DB::commit();
                }
                else{
                    $booking=new Booking();
                    $booking->user_id=$user->id;
                    $booking->room_id=$room->id;
                    $booking->date_from=Carbon::today();
                    $booking->date_to=Carbon::parse($request->room['unavailable']);
                    $booking->status=100;
                    $booking->note='Fake Booking';
                    $booking->save();
                }
                break;
            case '3':
                if(isset($request->booking_id)){
                    DB::beginTransaction();
                    DB::table('bookings')->where('id','=',$request->booking_id)->update([
                        'user_id' => $user->id,
                        'room_id' => $room->id,
                        'date_from' => Carbon::today(),
                        'date_to' => Carbon::parse('9999-12-31')
                    ]);
                    DB::commit();
                }
                else{
                    if(isset($user)){
                        $booking=new Booking();
                        $booking->user_id=$user->id;
                        $booking->room_id=$room->id;
                        $booking->date_from=Carbon::today();
                        $booking->date_to=Carbon::parse('9999-12-31');
                        $booking->status=100;
                        $booking->note='Fake Booking';
                        $booking->save();
                    }
                }
                break;
        }

        $count = DB::table('houses')->select('rooms_quantity')->where('id', '=', $room->house_id)->get();
        $view_form=view('rooms.create_form', [
            'houses' => House::all(),
            'rules' => Rule::all(),
            'devices' => Device::all(),
            'id_house' =>$room->house_id,
            'count' =>$count[0]->rooms_quantity,
            'countries' => Country::all()->sortBy('name'),
            'today_date' => Carbon::now()->toDateString()
        ])->render();
        return [$view_form,$room->id];
    }

    public function createNew($id_house)
    {
        // dd(Rule::all());
        $count = DB::table('houses')->select('houses.rooms_quantity')->where('houses.id', '=', $id_house)->get();
        // dd($count[0]->rooms_quantity);
        return view('rooms.create_julian', [
            'houses' => House::all(),
            'rules' => Rule::all(),
            'devices' => Device::all(),
            'id_house' =>$id_house,
            'count' =>$count[0]->rooms_quantity,
            'countries' => Country::all()->sortBy('name'),
            'today_date' => Carbon::now()->toDateString()
        ]);
    }

    public function editNew($room_id){
        $room=Room::where('id','=',$room_id)->first();
        $devices=DevicesRoom::where('room_id','=',$room_id)->first();
        $booking=Booking::where('room_id','=',$room_id)->where('status','=',100)->first();
        if(isset($booking)){
            $user=User::where('id','=',$booking->user_id)->first();
            $booking->user=$user;
        }
        return [view('rooms.update_form',[
            'room' => $room,
            'id_house' => $room->house_id,
            'today_date' => \Carbon\Carbon::today(),
            'countries' => Country::all()->sortBy('name'),
            'devices' => $devices,
            'booking' => $booking
        ])->render()];

    }


    public function updatePriceRoom(Request $request){
        $room =  Room::firstOrFail()->where('id', '=', $request->room_id);
        $room->update([
            'price' => $request->new_price
        ]);
        return 'true';
    }
}
