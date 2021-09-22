<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use App\Booking;

class NotificationController extends Controller
{

    public function index()
    {
    if (Auth::check()) {
        // The user is logged in...
        if (Auth::user()->role_id == 1) {

            $creation_history = DB::connection('dataevents')->table('vw_created_booking')->limit(40)->get();
            $creation_history_amount = [
                'creation_history_amount_day' => DB::connection('dataevents')->table('vw_created_booking')->whereBetween('creation_date',[Carbon::now()->subDay(1)->toDateTimeString(),Carbon::now()->toDateTimeString()])->count(),
                'creation_history_amount_week' => DB::connection('dataevents')->table('vw_created_booking')->whereBetween('creation_date',[Carbon::now()->subWeek(1)->toDateTimeString(),Carbon::now()->toDateTimeString()])->count(),
                'creation_history_amount_month' => DB::connection('dataevents')->table('vw_created_booking')->whereBetween('creation_date',[Carbon::now()->subMonth(1)->toDateTimeString(),Carbon::now()->toDateTimeString()])->count()
            ];
            $update_history = DB::connection('dataevents')->table('vw_updated_booknig')->limit(50)->get();
            $bookings_amount = [
                1 => DB::connection('dataevents')->table('data_bookings')->where('status','=',1)->count(),
                2 => DB::connection('dataevents')->table('data_bookings')->where('status','=',2)->count(),
                3 => DB::connection('dataevents')->table('data_bookings')->where('status','=',3)->count(),
                4 => DB::connection('dataevents')->table('data_bookings')->where('status','=',4)->count(),
                5 => DB::connection('dataevents')->table('data_bookings')->where('status','=',5)->count(),
                50 => DB::connection('dataevents')->table('data_bookings')->where('status','=',50)->count()
            ];
            $bookings_transition_amount = [
                1 => DB::connection('dataevents')->table('event_update_bookings')->where('old_status','=',1)->where('new_status','=',2)->count(),
                2 => DB::connection('dataevents')->table('event_update_bookings')->where('old_status','=',2)->where('new_status','=',3)->count(),
                3 => DB::connection('dataevents')->table('event_update_bookings')->where('old_status','=',3)->where('new_status','=',4)->count(),
                4 => DB::connection('dataevents')->table('event_update_bookings')->where('old_status','=',4)->where('new_status','=',50)->count(),
                50 => DB::connection('dataevents')->table('event_update_bookings')->where('old_status','=',50)->where('new_status','=',5)->count()
            ];
            $new_users = DB::connection('dataevents')->table('vw_new_users')->get();
            $messages = DB::connection('dataevents')->table('vw_messages')->get();
            $new_rooms = DB::connection('dataevents')->table('vw_new_rooms')->get();

            return view('notifications.index',[
                'creation_history' => $creation_history,
                'creation_history_amount' => $creation_history_amount,
                'update_history' => $update_history,
                'bookings_amount' => $bookings_amount,
                'bookings_transition_amount' => $bookings_transition_amount,
                'new_users' => $new_users,
                'messages' => $messages,
                'new_rooms' => $new_rooms
            ]);

        }
        else if (Auth::user()->role_id == 2) {

            $update_history = DB::connection('dataevents')
                                ->table('event_update_bookings')
                                ->select('data_bookings.id as booking_id', 'data_bookings.status as booking_status', 'event_update_bookings.old_status as old_status',
                                        'event_update_bookings.new_status as new_status', 'data_rooms.number as room_number', 'data_rooms.house_name as house_name',  'data_rooms.house_id as house_id',
                                        'event_update_bookings.change_date as change_date', 'event_creation_bookings.user_id as user_id')
                                ->leftJoin('data_bookings','event_update_bookings.booking_id','=','data_bookings.id')
                                ->leftJoin('event_creation_bookings','data_bookings.id','=','event_creation_bookings.booking_id')
                                ->leftJoin('data_rooms','event_creation_bookings.room_id','=','data_rooms.id')
                                ->whereNotNull('event_update_bookings.old_status')
                                ->where('event_creation_bookings.manager_id','=',Auth::user()->id)
                                ->orderBy('event_update_bookings.old_status', 'desc')
                                ->limit(15)
                                ->get();


            $creation_history =  DB::connection('dataevents')
                                ->table('event_creation_bookings')
                                ->select('event_creation_bookings.creation_date', 'data_bookings.id as booking_id', 'data_bookings.status as booking_status', 'data_bookings.date_from as booking_from',
                                        'data_bookings.date_to as booking_to', 'data_rooms.id as room_id', 'data_rooms.number as room_number', 'data_rooms.house_name', 'data_users.name as user_name', 'data_users.id as user_id', 'data_rooms.house_id', 'data_rooms.house_name')
                                ->leftJoin('data_bookings','event_creation_bookings.booking_id','=','data_bookings.id')
                                ->leftJoin('data_rooms','event_creation_bookings.room_id','=','data_rooms.id')
                                ->leftJoin('data_users','event_creation_bookings.user_id','=','data_users.id')
                                ->orderBy('event_creation_bookings.creation_date', 'desc')
                                ->where('event_creation_bookings.manager_id','=',Auth::user()->id)
                                ->get();


            $messages = DB::connection('dataevents')
                        ->table('event_messages')
                        ->select('event_messages.sender as sender_id', 'event_messages.addressee as adreesee_id', 'event_messages.booking_id', 'event_messages.message_date', 'dus.name as sender_name', 'dua.name as adreesee_name')
                        ->leftJoin('data_users as dus','event_messages.sender','=','dus.id')
                        ->leftJoin('data_users as dua','event_messages.addressee','=','dua.id')
                        ->orderBy('event_messages.message_date','desc')
                        ->where('event_messages.addressee','=',Auth::user()->id)
                        ->orWhere('event_messages.sender','=',Auth::user()->id)
                        ->get();

            $bookings_for_newsfeed = DB::connection('dataevents')
                                    ->table('data_bookings AS db')
                                    ->leftJoin('event_creation_bookings as ecb', 'db.id', '=', 'ecb.booking_id')
                                    ->leftJoin('event_messages as em', 'db.id', '=', 'em.booking_id')
                                    ->leftJoin('event_update_bookings as eub', 'db.id', '=', 'eub.booking_id')
                                    ->select('db.id', 'db.date_from', 'db.date_to', 'ecb.creation_date','em.message_date','eub.change_date')
                                    ->where('ecb.manager_id',Auth::user()->id)
                                    ->orderBy('em.message_date', 'desc')
                                    ->orderBy('ecb.creation_date', 'desc')
                                    ->orderBy('eub.change_date', 'desc')
                                    ->get();

            $id_counter = self::idFinder($bookings_for_newsfeed)[1];
            $existing_bookings = self::idFinder($bookings_for_newsfeed)[0];
            $information_newsfeed = self::createNewsfeed($id_counter, $existing_bookings, $bookings_for_newsfeed);
            
            return view('notifications.index',[
                'creation_history' => $creation_history,
                'update_history' => $update_history,
                'messages' => $messages,
                'information_newsfeed' => $information_newsfeed
            ]);

        }

        else if (Auth::user()->role_id == 3) {


            $update_history = DB::connection('dataevents')
                                ->table('event_update_bookings')
                                ->select('data_bookings.id as booking_id', 'data_bookings.status as booking_status', 'event_update_bookings.old_status as old_status',
                                        'event_update_bookings.new_status as new_status', 'data_rooms.number as room_number', 'data_rooms.house_name as house_name',
                                        'event_update_bookings.change_date as change_date', 'event_creation_bookings.user_id as user_id', 'data_rooms.house_id')
                                ->leftJoin('data_bookings','event_update_bookings.booking_id','=','data_bookings.id')
                                ->leftJoin('event_creation_bookings','data_bookings.id','=','event_creation_bookings.booking_id')
                                ->leftJoin('data_rooms','event_creation_bookings.room_id','=','data_rooms.id')
                                ->whereNotNull('event_update_bookings.old_status')
                                ->where('event_creation_bookings.user_id','=',Auth::user()->id)
                                ->orderBy('event_update_bookings.old_status', 'desc')
                                ->limit(15)
                                ->get();

            $creation_history =  DB::connection('dataevents')
                                ->table('event_creation_bookings')
                                ->select('event_creation_bookings.creation_date', 'data_bookings.id as booking_id', 'data_bookings.status as booking_status', 'data_bookings.date_from as booking_from',
                                'data_bookings.date_to as booking_to', 'data_rooms.id as room_id', 'data_rooms.number as room_number', 'data_rooms.house_name', 'data_users.name as user_name', 'data_rooms.house_id', 'data_rooms.house_name')
                                ->leftJoin('data_bookings','event_creation_bookings.booking_id','=','data_bookings.id')
                                ->leftJoin('data_rooms','event_creation_bookings.room_id','=','data_rooms.id')
                                ->leftJoin('data_users','event_creation_bookings.user_id','=','data_users.id')
                                ->orderBy('event_creation_bookings.creation_date', 'desc')
                                ->where('event_creation_bookings.user_id','=',Auth::user()->id)
                                ->get();

            $messages = DB::connection('dataevents')
                        ->table('event_messages')
                        ->select('event_messages.sender', 'event_messages.addressee', 'event_messages.booking_id', 'event_messages.message_date', 'dus.name as sender_name', 'dua.name as adreesee_name')
                        ->leftJoin('data_users as dus','event_messages.sender','=','dus.id')
                        ->leftJoin('data_users as dua','event_messages.addressee','=','dua.id')
                        ->orderBy('event_messages.message_date','desc')
                        ->where('event_messages.addressee','=',Auth::user()->id)
                        ->orWhere('event_messages.sender','=',Auth::user()->id)
                        ->get();

            return view('notifications.index',[
                'creation_history' => $creation_history,
                'update_history' => $update_history,
                'messages' => $messages
            ]);

        }
    }
    }

    public function getDaily()
    {

        $creation_history = DB::connection('dataevents')->table('vw_created_booking')->whereBetween('creation_date',[Carbon::now()->subDay(1)->toDateTimeString(),Carbon::now()->toDateTimeString()])->get();

        return view('notifications.information',[
            'creation_history' => $creation_history
        ]);
    }

    public function getWeekly()
    {
        $creation_history = DB::connection('dataevents')->table('vw_created_booking')->whereBetween('creation_date',[Carbon::now()->subWeek(1)->toDateTimeString(),Carbon::now()->toDateTimeString()])->get();
        return view('notifications.information',[
            'creation_history' => $creation_history
        ]);
    }

    public function getMonthly()
    {
        $creation_history = DB::connection('dataevents')->table('vw_created_booking')->whereBetween('creation_date',[Carbon::now()->subMonth(1)->toDateTimeString(),Carbon::now()->toDateTimeString()])->get();
        return view('notifications.information',[
            'creation_history' => $creation_history
        ]);
    }

    public function idFinder($bookings_for_newsfeed)
    {
        $id_counter = 0;
        $existing_bookings = [];
        if (!empty($bookings_for_newsfeed)) {
            array_push($existing_bookings, $bookings_for_newsfeed[0]->id);
            $current_id = $bookings_for_newsfeed[0]->id;
            $id_counter++;

            for ($i=1; $i < sizeof($bookings_for_newsfeed); $i++) {
                if ($bookings_for_newsfeed[$i]->id != $current_id) {
                    if (!in_array($bookings_for_newsfeed[$i]->id, $existing_bookings)) {
                        array_push($existing_bookings, $bookings_for_newsfeed[$i]->id);
                        $current_id = $bookings_for_newsfeed[$i]->id;
                        $id_counter++;
                    }
                }
            }
        }

        return array( $existing_bookings, $id_counter);
    }

    public function createNewsfeed($id_counter, $existing_bookings, $bookings_for_newsfeed)
    {
        for ($i=0; $i < $id_counter; $i++) {
            $bookings_array_wildcard = [];
            $action_flag = -1;
            $a_new_date = Carbon::now()->subMonth(6)->toDateTimeString();
            foreach ($bookings_for_newsfeed as $booking) {
                if ($booking->id == $existing_bookings[$i]) {
                    array_push($bookings_array_wildcard, $booking);
                }
            }
            foreach ($bookings_array_wildcard as $booking_object) {
                if ($booking_object->creation_date > $a_new_date) {
                    $a_new_date = $booking_object->creation_date;
                    $action_flag = 0;
                }
                if ($booking_object->message_date > $a_new_date) {
                    $a_new_date = $booking_object->message_date;
                    $action_flag = 1;
                }
                if ($booking_object->change_date > $a_new_date) {
                    $a_new_date = $booking_object->change_date;
                    $action_flag = 2;
                }
            }

            $information_newsfeed[$i] = array('booking_id' => $existing_bookings[$i],
                                        'action' => $action_flag,
                                        'date' => $a_new_date);
        }

        return $information_newsfeed;
    }

    public function UserBookingNotifications()
    {
        $user = Auth::user();                
        if ($user) {
            if ($user->isUser()) {
                $pending = $user->bookings->where('status', 1);
                $accepted = $user->bookings->where('status', 5);
                $denied = $user->bookings->where('status', '<', 0);
                $payment = $user->bookings->where('status', 4);
            } else {
                $pending = array();
                $accepted = array();
                $denied = array();
                $payment = array();
                foreach ($user->houses as $house) {
                    $pendings = $house->bookings->where('status', 1);
                    $accepteds = $house->bookings->where('status', 5);
                    $denieds = $house->bookings->where('status', '<', 0);
                    $payments = $house->bookings->where('status', 4);
    
    
                    foreach ($pendings as $pd) {
                        array_push($pending, $pd);
                    }
                    foreach ($accepteds as $pd) {
                        array_push($accepted, $pd);
                    }
                    foreach ($denieds as $pd) {
                        array_push($denied, $pd);
                    }
                    foreach ($payments as $pd) {
                        array_push($payment, $pd);
                    }
                }
            }
            $unread = $user->unreadNotifications;
    
            return view('notifications.userBookingNotification', [
                'user'  =>  $user,
                'pending'   =>  count($pending),
                'unread'    =>  count($unread),
                'accepted'  =>  count($accepted),
                'denied'    =>  count($denied),
                'payment'   =>  count($payment)
            ]);        
        } else {
            return view('auth.login',[
                'url'=>'notification'
            ]);
        }    
    }

    public function managerBookingsNotifications(Booking $booking){
        $user = $booking->manager();

        if ($user) {
            if ($user->isUser()) {
                $pending = $user->bookings->where('status', 1);
                $accepted = $user->bookings->where('status', 5);
                $denied = $user->bookings->where('status', '<', 0);
                $payment = $user->bookings->where('status', 4);
            } else {
                $pending = array();
                $accepted = array();
                $denied = array();
                $payment = array();
                foreach ($user->houses as $house) {
                    $pendings = $house->bookings->where('status', 1);
                    $accepteds = $house->bookings->where('status', 5);
                    $denieds = $house->bookings->where('status', '<', 0);
                    $payments = $house->bookings->where('status', 4);
    
    
                    foreach ($pendings as $pd) {
                        array_push($pending, $pd);
                    }
                    foreach ($accepteds as $pd) {
                        array_push($accepted, $pd);
                    }
                    foreach ($denieds as $pd) {
                        array_push($denied, $pd);
                    }
                    foreach ($payments as $pd) {
                        array_push($payment, $pd);
                    }
                }
            }
            $unread = $user->unreadNotifications;
    
            return view('notifications.managerNotifications',[
                'user'  =>  $user,
                'pending'   =>  count($pending),
                'unread'    =>  count($unread),
                'accepted'  =>  count($accepted),
                'denied'    =>  count($denied),
                'payment'   =>  count($payment)
            ]);    
        } else {
            return redirect()->back();
        }
        
    }

    public function studentBookingsNotifications(Booking $booking){
        $user = $booking->user;
        if ($user) {
            if ($user->isUser()) {
                $pending = $user->bookings->where('status', 1);
                $accepted = $user->bookings->where('status', 5);
                $denied = $user->bookings->where('status', '<', 0);
                $payment = $user->bookings->where('status', 4);
            } else {
                $pending = array();
                $accepted = array();
                $denied = array();
                $payment = array();
                foreach ($user->houses as $house) {
                    $pendings = $house->bookings->where('status', 1);
                    $accepteds = $house->bookings->where('status', 5);
                    $denieds = $house->bookings->where('status', '<', 0);
                    $payments = $house->bookings->where('status', 4);
    
    
                    foreach ($pendings as $pd) {
                        array_push($pending, $pd);
                    }
                    foreach ($accepteds as $pd) {
                        array_push($accepted, $pd);
                    }
                    foreach ($denieds as $pd) {
                        array_push($denied, $pd);
                    }
                    foreach ($payments as $pd) {
                        array_push($payment, $pd);
                    }
                }
            }
            $unread = $user->unreadNotifications;
            return view('notifications.studentNotifications',[
                'user'  =>  $user,
                'pending'   =>  count($pending),
                'unread'    =>  count($unread),
                'accepted'  =>  count($accepted),
                'denied'    =>  count($denied),
                'payment'   =>  count($payment)
            ]);
        } else {
            return redirect()->back();
        }
    }
}
