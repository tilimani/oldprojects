<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Booking;
use App\Events\BookingWasChanged;
use App\Notifications\BookingNotification;
use App\Notifications\BookingUpdateUser;
use App\Http\Controllers\BookingController as BaseBookingController;
use Illuminate\Support\Facades\DB;
use App\Events\BookingWasSuccessful;
use Faker\Factory as Faker;
use App\Room;



class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $userNotifications = $user->notifications->where('type','App\Notifications\BookingNotification')->sortByDesc('created_at');

        $notifications = array();
        $ids = array();
        foreach ($userNotifications as $notification) {
            $booking_id = $notification->data['booking_id'];
            if (!in_array($booking_id, $ids)) {
                array_push($ids, $booking_id);
                array_push($notifications, $notification);
            }
        }
        return response()->json($notifications, 200);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function manager(Booking $booking)
    {
        $manager = $booking->room->house->manager->user;

        return response()->json($manager, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function user(User $user)
    {

        return response()->json($user, 200);
    }

    public function read(User $user) 
    {
        try {
            if (count($user->unreadNotifications) > 0) {
                $user->unreadNotifications->markAsRead();
            }
            $userNotifications = $user->notifications->sortByDesc('created_at');

            $notifications = array();
            $ids = array();
            foreach ($userNotifications as $notification) {
                $booking_id = $notification->data['booking_id'];
                if($notification->type === "App\Notifications\BookingNotification") {
                    if (!in_array($booking_id, $ids)) {
                        array_push($ids, $booking_id);
                        array_push($notifications, $notification);
                    }
                }
            }
            return response()->json($notifications, 200);
        } catch(\Exception $ex) {
            return response()->json($ex, 500);
        }
    }

    public function acceptBooking(Request $request)
    {
        $booking = Booking::find($request->input('id'));

        $booking->status = 4;
        
        $booking->save();

        event(new BookingWasChanged($booking));
        
        $user = $booking->user;
        $manager = $booking->room->house->manager->user;
        
        $user->notify(new BookingNotification($booking));
        $manager->notify(new BookingNotification($booking));

        $user->notify(new BookingUpdateUser($booking));
        // $manager->notify(new BookingUpdateNotifyManager($booking));
        
        return response()->json('ok', 200);
    }

    public function denyBooking(Request $request)
    {
        // return response()->json(['deny'=> $request->all()]);

        $bookingCurrent = Booking::findOrFail($request->id);
        $bookingController = new BaseBookingController();
        BaseBookingController::SendSuggestionsPublic($bookingCurrent);        

        $bookingCurrent->status = -22;
        $bookingCurrent->note = (isset($request->massage)) ? $request->message : 'sin mensaje';
        $bookingCurrent->save();

        event(new BookingWasChanged($bookingCurrent));

        $user = $bookingCurrent->user;
        $manager = $bookingCurrent->room->house->manager->user;
        $user->notify(new BookingNotification($bookingCurrent));
        $manager->notify(new BookingNotification($bookingCurrent));

        $user->notify(new BookingUpdateUser($bookingCurrent));

        $info = [
            'id' => $bookingCurrent->id,
            'status' => -22
        ];
        // self::statusUpdate($info);

        return response()->json('ok', 200);
    }

    public function denyAndBlock(Request $request)
    {        
        $bookingCurrent = Booking::findOrFail($request->id);
        $bookingController = new BaseBookingController();
        $bookingController->SendSuggestionsPublic($bookingCurrent);

        if ($request->deny == 'block') {
            $bookingCurrent->status = -21;
            $bookingCurrent->save();

            event(new BookingWasChanged($bookingCurrent));
            $user = $bookingCurrent->user;
            $manager = $bookingCurrent->room->house->manager->user;
            $user->notify(new BookingNotification($bookingCurrent));
            $manager->notify(new BookingNotification($bookingCurrent));
            
            $user->notify(new BookingUpdateUser($bookingCurrent));

            try {
                DB::beginTransaction();
                if (isset($request->name) && isset($request->gender) && isset($request->country_id)) {
                    $user = $this->createFakeUser($request->name, $request->gender, $request->country_id);
                } else {
                    $user = $this->createFakeUser();
                }
                $booking = new Booking();
                $booking->status = 100;
                $booking->date_to = $request->date_to;
                $booking->date_from = $request->date_from;
                $booking->room_id = $request->room_id;
                $booking->user_id = $user->id;
                $booking->mode = 1;
                $booking->message = "without message";
                $booking->note = "FAKE booking";

                if ($request->dateask != null) {
                    $booking->created_at = date('Y-m-d', time());
                }
                $booking->save();

                event(new BookingWasSuccessful($booking, false, true));

                DB::commit();
            } catch (\PDOException $e) {
                DB::rollBack();

                //delete user if some was bad
                $user->delete();

                return back();
            }
        }
        return response()->json('block', 200);
    }

    public function blockAndSuggest(Request $request){
        // return response()->json($request->all());
        /* This is where the room is suggested by manager */
        
        /* This is where the room selected by user is blocked by a fake booking */
        try {
            DB::beginTransaction();
            if (isset($request->name) && isset($request->gender) && isset($request->country_id)) {
                $user = $this->createFakeUser($request->name, $request->gender, $request->country_id);
            } else {
                $user = $this->createFakeUser();
            }
            $booking = new Booking();
            $booking->status = 100;
            $booking->date_to = $request->date_to;
            $booking->date_from = $request->date_from;
            $booking->room_id = $request->room_id;
            $booking->user_id = $user->id;
            $booking->mode = 1;
            $booking->message = "without message";
            $booking->note = "FAKE booking";

            if ($request->dateask != null) {
                $booking->created_at = date('Y-m-d', time());
            }
            $booking->save();

            $current_booking = Booking::find($request->booking_id);

            $bookingRoom = $current_booking->room;
    
            $room = Room::find($request->changeRoomId);
    
            $current_booking->room()->associate($room);
            // $current_booking->room_id = $room->id;
            $current_booking->status = 2;
    
            $current_booking->save();
    
            $real_user = $current_booking->user;
    
            $manager = $current_booking->manager();
    
            $real_user->notify(new BookingNotification($current_booking));
            $manager->notify(new BookingNotification($current_booking));
            event(new BookingWasSuccessful($booking, false, true));
    
            // $current_booking->room()->associate($bookingRoom);
            // $current_booking->save();
            DB::commit();
            return response()->json('suggest',200);
        } catch (\PDOException $e) {
            DB::rollBack();

            //delete user if some was bad
            $user->delete();

            return back();
        }
        // $bookingRoom->available_from = now();
        // $bookingRoom->save();
    }

    public function setRoomAvailable(Request $request){
        $bookingCurrent = Booking::findOrFail($request->id);
        $bookingCurrent->status = 3;
        $bookingCurrent->save();
        event(new BookingWasChanged($bookingCurrent));
        $user = $bookingCurrent->user;
        $manager = $bookingCurrent->room->house->manager->user;
        $manager->notify(new BookingNotification($bookingCurrent));
        $user->notify(new BookingNotification($bookingCurrent));
        $user->notify(new BookingUpdateUser($bookingCurrent));
        return response()->json(['request'=>$request]);
    }

    public function createFakeUser($name = null, $country_id = null, $gender = null){
        $faker = Faker::create();
        if (!isset($name)) {
            $name = $faker->name;
        }
        if (!isset($country_id)) {
            $country_id = $faker->numberBetween(1, 10);
        }
        if (!isset($gender)) {
            $gender = $faker->numberBetween(1, 2);
        }
        $user = User::create([
            'name'  =>  $name,
            'country_id'    =>  $country_id,
            'gender'    =>  $gender,
            'email'     =>  $faker->email(),
            'password'  =>  bcrypt('123'),
            'phone'     =>  $faker->e164PhoneNumber,
            'birthdate' =>  $faker->date(),
            'image'     =>  'manager_7.png',
            'description'   =>  'FAKE USER',
            'remember_token'    =>  encrypt('123'),
            'created_at'    =>  now(),
            'updated_at'    =>  now(),
            'role_id'       =>  3,
            'externalAccount'   =>  1,
            'email_spam'    =>  $faker->email(),
            'provider'  =>  'fakeuser'
        ]);
        
        return $user;
    }
    // public function denyBooking(Request $request)
    // {
    //     $booking = Booking::find($request->input('id'));
    //     return response()->json($booking, 200);
    // }


    public function readNotification(Request $request)
    {
        // return response()->json(['request'=>$request]);
        $booking = Booking::find($request->booking_id);
        if ($booking) {
            $user = User::find($request->user_id);
        
            $userNotifications = $user->notifications
                ->where('type','App\Notifications\BookingNotification')
                ->sortByDesc('created_at');
    
            $notifications = array();
            $ids = array();
            foreach ($userNotifications as $notification) {
                $booking_id = $notification->data['booking_id'];
                if (isset($booking_id)) {
                    if ($booking_id == $booking->id) {
                        $notification->markAsRead();
                    }
                    if (!in_array($booking_id, $ids)) {
                        array_push($ids, $booking_id);
                        array_push($notifications, $notification);
                    }
                }
            }
            
            return response()->json($notifications, 200);
        } else {
            return response()->json('booking not found',  500);
        }
    }


    public function sendNotifications()
    {
        $bookings = Booking::where('status', '>=', '1')->get();

        foreach ($bookings as $booking) {
            $user = $booking->User;
            $manager = $booking->manager();
            $user->notify(new BookingNotification($booking));
            $manager->notify(new BookingNotification($booking));
        }

        $countNotifications = count(User::find(1)->notifications);

        return response()->json($countNotifications, 200);
    }


    public function cancelBooking(Request $request)
    {
        $bookingCurrent = Booking::findOrFail($request->id);
        $bookingController = new BaseBookingController();
        BaseBookingController::SendSuggestionsPublic($bookingCurrent);        

        $bookingCurrent->status = -1;
        $bookingCurrent->note = (isset($request->massage)) ? $request->message : 'sin mensaje';
        $bookingCurrent->save();

        event(new BookingWasChanged($bookingCurrent));

        $user = $bookingCurrent->user;
        $manager = $bookingCurrent->room->house->manager->user;
        $user->notify(new BookingNotification($bookingCurrent));
        $manager->notify(new BookingNotification($bookingCurrent));

        $user->notify(new BookingUpdateUser($bookingCurrent));

        $info = [
            'id' => $bookingCurrent->id,
            'status' => -22
        ];
        // self::statusUpdate($info);
        
        return response()->json(':c', 200);
    }
}
