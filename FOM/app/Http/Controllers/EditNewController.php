<?php

namespace App\Http\Controllers;

use Mail;
use Carbon\Carbon;
use App\Coordinate;
use App\Country;
use App\Device;
use App\DeviceHouse;
use App\House;
use App\Homemate;
use App\HousesRule;
use App\ImageHouse;
use App\ImageRoom;
use App\Manager;
use App\Room;
use App\Rule;
use App\User;
use App\Booking;
use App\Neighborhood;
use App\Verification;
use App\Http\Controllers\Controller;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
// use Symfony\Component\HttpFoundation\Request;

class EditNewController extends Controller
{
    public function __construct()
    {
        $this->middleware('manager_house', ['only' => ['show']]);
        $this->middleware('manager_house_post', ['only' => ['destroy', 'update']]);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  App\House $house
    * @return \Illuminate\Http\Response
    */
    public function show(House $house)
    {
        set_time_limit(300);

        $rooms = $house->Rooms->sortBy('number');
        $house->Rooms = $rooms;
        foreach ($house->Rooms as $room) {
           $room= self::setMinDateAvailableRoom($room);
        }
        $neighborhood = Neighborhood::where('id', '=', $house->neighborhood_id)->firstOrFail();

        foreach ($rooms as $room) {
            $room->devices = DB::table('devices_rooms')->where('room_id', '=', $room->id)->first();
        }

        for ($i = 0; $i < count($rooms); $i++) {
            $house->Rooms[$i]->main_image = DB::table('image_rooms')
                ->select('image', 'priority')
                ->where('room_id', '=', $house->Rooms[$i]->id)
                ->get();

            $house->Rooms[$i]->available = $rooms[$i]->available_from < Carbon::now() ? 'Disponible' : 'No disponible';
        }

        $manager = DB::table('managers')
            ->join('users', 'users.id', '=', 'managers.user_id')
            ->where('managers.id', '=', $house->manager_id)
            ->get();

        $devices = DB::select( 'SELECT FOMDB.devices.id, FOMDB.devices.name, FOMDB.devices.icon, FOMDB.device_houses.device_id
                                FROM FOMDB.devices
                                    LEFT JOIN FOMDB.device_houses
                                        ON FOMDB.devices.id = FOMDB.device_houses.device_id
                                        AND FOMDB.device_houses.house_id  = ?', [$house->id]);

        $rules = DB::select(   'SELECT  FOMDB.rules.id, FOMDB.houses_rules.description, FOMDB.houses_rules.rule_id
                                FROM FOMDB.rules
                                	LEFT JOIN FOMDB.houses_rules
                                        ON FOMDB.rules.id = FOMDB.houses_rules.rule_id
                                		AND FOMDB.houses_rules.house_id  = ?', [$house->id]);

        $house->main_image = DB::table('houses')
            ->select('image_houses.priority', 'houses.id', 'image_houses.image')
            ->join('image_houses', 'image_houses.house_id', '=', 'houses.id')
            ->orderBy('image_houses.priority', 'asc')
            ->where('house_id', '=', $house->id)
            ->get();

        if (sizeof($house->main_image) < 5) {
            $non_image = ['priority'=>'100','id'=>'0','house_id'=>$house->id,'image'=>'room_4.jpeg'];
            $non_image= (object) $non_image;
            for($j=sizeof($house->main_image);$j<5;$j++){
                $house->main_image->push($non_image);
            }
        }
        $availableCount = $house->Rooms->where('available_from', '<', Carbon::now())->count();
        foreach ($house->Rooms as $room) {
            $bookings_room=$this->getBooking([5,100])->where('room_id','=',$room->id)->where('date_to','>=',Carbon::today())->sortBy('date_from');
            // dd($bookings_room);
            $devices_room=DB::table('devices_rooms')
                ->where('room_id','=',$room->id)
                ->first();
            $room->occupant='';
            $room->date='';
            $room->status='';
            $room->next=false;
            $room->status='';
            $room->icon='';
            $room->booking='';
            foreach ($bookings_room as $booking) {
                $occupant=User::where('id','=',$booking->user_id)->first();
                $country=Country::where('id','=',$occupant->country_id)->first();
                $booking->gender=$occupant->gender;
                $booking->name=$occupant->name;
                $booking->icon=$country->icon;
                if($booking->date_from <= Carbon::now()->toDateTimeString() && Carbon::now()->toDateTimeString() <= $booking->date_to && $room->occupant == ''){
                    $room->icon=$country->icon;
                    $room->occupant=$occupant->name;
                    $room->date=$booking->date_to;
                    $room->status=$booking->status;
                    $room->gender=$occupant->gender;
                    $room->booking=$booking->id;
                }
                if($booking->date_from > Carbon::now()->toDateTimeString()  && $room->occupant == ''){
                    $room->icon=$country->iiconcon;
                    $room->occupant=$occupant->name;
                    $room->date=$booking->date_from;
                    $room->status=$booking->status;
                    $room->gender=$occupant->gender;
                    $room->booking=$booking->id;
                    $room->next=true;
                }
            }
            $room->count_images=DB::table('image_rooms')
                ->where('room_id','=',$room->id)
                ->count();
            $room->bookings=$bookings_room;
            $room->devices=$devices_room;
        }
        // dd($rooms[0]->bookings);
        return view('houses.editnew.show', [
            'house' => $house,
            'manager'=> $manager,
            'rules' => $rules,
            'availableCount' => $availableCount,
            'devices'=> $devices,
            'countries' => Country::all()->sortBy('name'),
            'neighborhood' => $neighborhood
        ])->with(compact('neighborhood'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  App\House $house
    * @return \Illuminate\Http\Response
    */
    public function images(House $house)
    {
        $house->images = DB::table('houses')
        ->select('image_houses.id', 'image_houses.priority', 'houses.id as house_id', 'image_houses.image')
        ->join('image_houses', 'image_houses.house_id', '=', 'houses.id')
        ->orderBy('image_houses.priority', 'asc')
        ->where('house_id', '=', $house->id)
        ->get();
        foreach ($house->images as $index => $image) {
            $image->priority=$index;
        }
        return view('houses.editnew.images', [
            'house' => $house
        ]);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  App\House $house
    * @return \Illuminate\Http\Response
    */
    public function bookings(House $house)
    {
        return view('houses.editnew.bookings', [
            'images' => 'images'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function manager(int $house_id, User $user)
    {
        return view('houses.editnew.manager', [
            'manager' => $user,
            'house_id' => $house_id
        ]);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  App\House $house
    * @return \Illuminate\Http\Response
    */
    public function vico(House $house)
    {
        return view('houses.editnew.vico', [
            'house' => $house
        ]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    **/
    public function deleteImages(Request $request)
    {
        // dd($request->all());

        //  PENDIENTE AVERIGUAR SI VAN A BORRAR LOS ARCHIVOS DE S3
        // $s3 = Storage::disk('s3');

        try {

            DB::beginTransaction();

            foreach ($request->all() as $key => $value) {

                if (starts_with($key, 'image_')) {

                    if ($value == '1') DB::table('image_houses')->where('id', str_replace_first('image_', '', $key))->delete();

                }
            }

            DB::commit();
        }
        catch (\PDOException $e) {
            DB::rollBack();
            dd($e);
        }

        return back()->withInput();
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    **/
    public function storeImages(Request $request)
    {
        // dd($request->house_id);

        $s3 = Storage::disk('s3');

        try {

            DB::beginTransaction();

            for ($i=0; $i < count($request->file('second-image')); $i++) {

                $second_images = $request->file('second-image')[$i];

                if ($second_images->getClientMimeType() === "image/jpeg" || $second_images->getClientMimeType() === "image/png") {

                    $time = Carbon::now();
                    $time = $time->year.$time->month.$time->day.$time->hour.$time->minute.$time->second;
                    $s3->put('house_'.$request->house_id."_".$i."_".$time.".".$second_images->extension(), file_get_contents($second_images), 'public');

                    $image_house = new ImageHouse();
                    $image_house->house_id = $request->house_id;
                    $image_house->image = 'house_'.$request->house_id."_".$i."_".$time.".".$second_images->extension();
                    $image_house->priority = '1';
                    $image_house->description = "";

                    $image_house->save();
                }
            }

            DB::commit();

        }
        catch (\PDOException $e) {
            DB::rollBack();
            dd($e);
        }

        return back()->withInput();
    }

    /**
     * Update controller to save or deletes images
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     **/
    public function update(Request $request)
    {
        $s3 = Storage::disk('s3');

        try {

            DB::beginTransaction();
            if(isset($request->gallery)){
                foreach($request->gallery as $index => $gallery){
                    DB::table('image_houses')->where('id', '=', $gallery)->where('house_id','=',$request->house_id)->update([
                        'priority' => $index
                    ]);
                }
            }
            foreach ($request->all() as $key => $value) {
                if (starts_with($key, 'image_')) {
                    if ($value == '1') DB::table('image_houses')->where('id', str_replace_first('image_', '', $key))->delete();
                }
            }

            if(isset($request->new_image_profile)){
                $count_images= DB::table('image_houses')->where('house_id', '=', $request->Fup)->count();

                    foreach ($request->new_image_profile as $image) {
                        $second_images = $image;
                        $time = Carbon::now();
                        $time=$time->year.$time->month.$time->day.$time->hour.$time->minute.$time->second;
                        $s3->put('house_'.$request->house_id.'_'.$count_images."_".$time.".".$second_images->extension()
                                , file_get_contents($second_images)
                                , 'public');
                        $image_house_new = new ImageHouse();
                        $image_house_new->house_id = $request->house_id;
                        $image_house_new->image ='house_'.$request->house_id.'_'.$count_images."_".$time.".".$second_images->extension();
                        $image_house_new->priority = $count_images;
                        $count_images++;
                        $image_house_new->save();
                    }
            }


            DB::commit();
        }
        catch (\PDOException $e) {
            DB::rollBack();
            dd($e);
        }

        return redirect()->back();

    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    **/
    public function storeBookings(Request $request)
    {
        return redirect('houses/editnew/37');
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    **/
    public function storeManager(Request $request)
    {
        try {
            DB::beginTransaction();

            DB::table('users')
                        ->where('id', $request->manager_id)
                        ->update([
                            'name' => trim($request->manager_name, " "),
                            'description' => trim($request->manager_description, " ")
                        ]);

            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            dd($e);
        }

        return redirect('houses/editnew/'.$request->house_id);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    **/
    public function storeVico(Request $request)
    {
        // dd(trim($request->description_house, " "));

        try {
            DB::beginTransaction();

            DB::table('houses')
            ->where('id', $request->house_id)
            ->update([
                'description_house' => trim($request->description_house, " "),
                'description_zone' => trim($request->description_zone, " ")
            ]);

            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            dd($e);
        }

        //return redirect('houses/editnew/'.$request->house_id);
    }

    public function storeDevices(Request $request)
    {

        try {

            DB::beginTransaction();

            DB::table('device_houses')->where('house_id', str_replace_first('device_', '', $request->house_id))->delete();

            foreach ($request->devices as $key => $value) {

                if ($value['checked'] == 'true') {

                    $id = str_replace_first('device_', '', $value['id']);

                    $device_house = new DeviceHouse();
                    $device_house->house_id = $request->house_id;
                    $device_house->device_id = $id;

                    $device_house->save();
                }

            }

            DB::commit();

        }
        catch (\PDOException $e) {
            DB::rollBack();
            return response()->json($e);
        }

        $response = array(
            'status' => 200,
            'house_id' => $request->house_id
        );

        return response()->json($response);
    }

    public function storeRules(Request $request)
    {

        try {

            DB::beginTransaction();

            DB::table('houses_rules')->where('house_id', str_replace_first('rule_', '', $request->house_id))->delete();

            foreach ($request->rules as $key => $value) {

                if ($value['checked'] == 'true') {

                    $id = str_replace_first('rule_', '', $value['id']);

                    $rule_house = new HousesRule();
                    $rule_house->house_id = $request->house_id;
                    $rule_house->rule_id = $id;
                    $rule_house->description = 'Casa: '.$request->house_id.', Regla: '.$id;

                    $rule_house->save();
                }

            }

            DB::commit();

        }
        catch (\PDOException $e) {
            DB::rollBack();
            return response()->json($e);
        }

        $response = array(
            'status' => 200,
            'house_id' => $request->house_id
        );

        return response()->json($response);
    }

    public function newHomemate(Request $request){
        // dd($request->all());
        $date=Carbon::today()->toDateTimeString();
        $date=str_replace(' ','_',$date);
        $date=str_replace('/','_',$date);
        $date=str_replace(':','_',$date);
        $homemate=new User();
        $count=User::all()->last()->id+1;
        $homemate->name=$request->name;
        if($request->gender_female === 1){
            $homemate->gender=2;
        }
        else{
            $homemate->gender=1;
        }
        $homemate->country_id=$request->country_id;
        $homemate->role_id=3;
        $homemate->password=bcrypt($request->name.$request->country_id.$request->gender);
        $homemate->email=$request->name.$count.'@fakeuser.vico';
        $homemate->email_spam=$request->name.$count.'@fakeuser.vico';
        $homemate->externalAccount=1;
        $homemate->description='';
        $homemate->save();
        $booking=new Booking();
        $booking->room_id=$request->room_id;
        $booking->date_from=$request->date_from;
        $booking->date_to=$request->date_to;
        $booking->user_id=$homemate->id;
        $booking->status=100;
        $booking->mode=0;
        $booking->message='';
        $booking->note='';
        $booking->save();
        return redirect()->back();
    }

    public function updateHomemate(Request $request){
        $homemate=User::firstOrFail()->where('id', '=', $request->user_id);
        if($request->gender_male == 1){
            $gender=1;
        }
        else{
            $gender=2;
        }
        $homemate->update([
            'name' => $request->name,
            'gender' => $gender,
            'country_id' => $request->country_id
        ]);
        $booking=Booking::firstOrFail()->where('id', '=', $request->booking_id);
        $booking->update([
            'room_id' => $request->room_id,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to
        ]);

        return redirect()->back();
    }

    public function getInfoBooking(Request $request){
        $booking=Booking::where('id','=',$request->booking_id)->firstOrFail();
        $user=User::where('id','=',$booking->user_id)->firstOrFail();
        $booking->name_user=$user->name;
        $booking->gender_user=$user->gender;
        $booking->country_id_user=$user->country_id;
        return $booking;
    }

    public function eraseRoomie(Request $request){
        $booking=Booking::where('id','=',$request->booking_id)->delete();
        $user=DB::table('users')->where('id', '=', $request->user_id)->delete();
        return redirect()->back();
    }

    public function setMinDateAvailableRoom($room)
    {
        $available_date='';
        $bookings=$this->getBooking([5,100])->where('room_id', '=', $room->id)->sortBy('date_to');
        if (sizeof($bookings)>0) {
            foreach ($bookings as $booking) {
                if (Carbon::parse($booking->date_to)->year === 9999 || Carbon::parse($booking->date_from)->year === 9999) {
                    if (Carbon::parse($booking->date_from) < Carbon::parse($booking->date_to)) {
                        $available_date=$booking->date_to;
                    } else {
                        $available_date=$booking->date_from;
                    }
                    break;
                }
                elseif (Carbon::parse($available_date)->year == 9999) {
                    break;
                }
                else {
                    if ($available_date == '') {
                        if (Carbon::parse($booking->date_from) < Carbon::parse($booking->date_to)) {
                            $available_date=$booking->date_to;
                        } else {
                            $available_date=$booking->date_from;
                        }
                    } else {
                        if (Carbon::parse($booking->date_from) < Carbon::parse($booking->date_to)) {
                            $date_booking=Carbon::parse($booking->date_to);
                        } else {
                            $date_booking=Carbon::parse($booking->date_from);
                        }
                        $temp_date=Carbon::parse($available_date);
                        if ($date_booking->diffInDays($temp_date) >= 30) {
                            $available_date= $date_booking->toDateTimeString();
                        }
                    }
                }

            }
        }
        if($available_date == ''){
            $available_date=Carbon::now()->toDateTimeString();
        }
        $room->available_from=$available_date;
        DB::beginTransaction();
        DB::table('rooms')->where('id', '=', $room->id)->update([
            'available_from' => $available_date
            ]);
        DB::commit();
        return $room;
    }

    public function getAjax(){
        return view('houses.editnew.ajax');
    }

    /**
    * If a manager wants to make a room available
    *
    * @param Request $request
    * @return \Illuminate\Http\Response
    **/
    public function makeRoomAvailable(Request $request)
    {
        $data = [
            'booking_id' => $request->booking_id_request,
            'room_id' => $request->room_id_request,
        ];
        $booking = find($request->booking_id);
        $user = $booking->User;
        $verification = Verification::firstOrCreate(['user_id' => $user->id]);
        if ($verification->canISendMail())
        {
            Mail::send('emails.test', $data, function ($message) use ($data) {
                     $message->from('hello@getvico.com', 'Team VICO');
                     $message->to('mails@friendsofmedellin.com');
                     $message->to('vicovivirentreamigos@gmail.com');
                     $message->subject('Make Room #'.$data['room_id'].' available, change Bookings #'.$data['booking_id']);
                 }); // mail is sended
        }

        return redirect()->back()->with('WhatsAppNumber','Ya puedes ver el número de WhatsApp')->with('message_sent','Gracias, tu solicitud ha sido enviada exitosamente. Cuando el cambio se realice, te notificaremos.');
    }
}
