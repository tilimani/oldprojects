<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Carbon\Carbon;
use App\User;
use App\Verification;
use App\House;
use App\Room;
use App\Booking;
use App\Manager;
use App\Habitant;
use App\Country;
use App\City;
use App\Location;
use App\Neighborhood;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App;
use App\Http\Middleware\SetLang;
use App\Traits\SetCallback;
use Illuminate\Support\Str;
use App\Notifications\Photoshoot;
use App\Notifications\PostedPhotos;
use App\Notifications\PhotoshootWhatsapp;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, SetCallback;

    public function newUser(Request $request)
    {
        $redirectTo = '';
        // dd($request);
        if (isset($request->flag)) {
            //  dd($data);
            if ($request->email === null) {
                $email = $request->name . $request->lastname . $request->cellphone;
            } else {
                $email = $request->email;
            }
            $user = User::create([
                'name' => $request->name,
                'last_name' => $request->lastname,
                'phone' => $request->cellphone,
                'email' => $email,
                'birthdate' => null,
                'image_id' => null,
                'gender' => $request->gender,
                'image' => null,
                'description' => $request->Description,
                'password' => bcrypt($request->password),
                'country_id' => $request->country,
                'role_id' => $request->rol,
                'externalAccount' => 0
            ]);
            if ($request->rol === "2") {
                $manager = new Manager();
                $manager->vip = $request->vip;
                $manager->user_id = $user->id;
                $manager->save();
                $redirectTo = '/houses/create/1';
            } else {
                $habitant = new Habitant();
                $habitant->user_id = $user->id;
                $habitant->save();
                $redirectTo = '/booking/create';
            }
            DB::commit();
            return $redirectTo;
        } else {
            try {
                $count=User::all()->last()->id+1;
                DB::beginTransaction();
                $user = new User();
                $user->name = $request['name'];
                $user->gender = $request['gender'];
                $user->role_id = 3;
                $user->country_id = $request['country'];
                $user->email = $request['name'].$count.'denied@fakeuser.vico';
                $user->save();
                DB::commit();
                return $user;

            } catch (\PDOException $e) {
                DB::rollBack();
                return $e;
            }

        }
    }

    /*function that return all countries on json */
    public function countriesJson()
    {
        $countries = Country::all('id', 'name','icon');
        return response()->json($countries);
    }

    public function getBooking(array $status = [])
    {
        $this->status_booking = $status;
        $bookings = sizeof($status) > 0 ? Booking::where(function ($query) {
            for ($i = 0; $i < sizeof($this->status_booking); $i++) {
                $query->orWhere('status', '=', $this->status_booking[$i]);
            }
        })->get() : Booking::all()->where('status', '!=', 100);
        return $bookings;

    }

    /**
    * validate user's suscription before send a mail
    * @param user_id user's id
    * @return result boolean true if suscription is available
    * @author Cristian
    **/
    public static function userEmailSuscription ($user_id)
    {
        $verification = Verification::firstOrCreate(['user_id' => $user_id]);
        $result = $verification->email;
        return $result;
    }

    public function roomDatesBooking($room_id)
    {
        $bookings = self::getBooking([5, 100])->where('room_id', '=', $room_id)->where('date_to', '>', Carbon::now())->sortBy('date_to');
        $room = Room::where('id', '=', $room_id)->firstOrFail();
        $dates = [];
        foreach ($bookings as $booking) {
            if (Carbon::parse($booking->date_to) >= Carbon::parse($booking->date_from)) {
                $date_from = Carbon::parse($booking->date_from);
                $date_to = Carbon::parse($booking->date_to);
            } else {
                $date_from = Carbon::parse($booking->date_to);
                $date_to = Carbon::parse($booking->date_from);
            }
            $number_days = $date_to->diffInDays($date_from);
            for ($i = 0; $i <= $number_days; $i++) {
                if (Carbon::parse($booking->date_to) >= Carbon::parse($booking->date_from)) {
                    $temp_date = Carbon::parse($booking->date_from);
                } else {
                    $temp_date = Carbon::parse($booking->date_to);
                }

                $temp_date = $temp_date->addDays($i)->toDateTimeString();
                $temp_date = explode(' ', $temp_date);
                array_push($dates, $temp_date[0]);
            }
        }
        if (sizeof($dates) < 1) {
            $date_from = Carbon::today();
            $date_to = Carbon::parse($room->available_from);
            if ($date_to->diffInDays($date_from) > 0) {
                $number_days = $date_to->diffInDays($date_from);
                for ($i = 0; $i <= $number_days; $i++) {
                    $temp_date = Carbon::today();
                    $temp_date = $temp_date->addDays($i)->toDateTimeString();
                    $temp_date = explode(' ', $temp_date);
                    array_push($dates, $temp_date[0]);
                }
            }
        }
        return $dates;
    }

    public function getImagesRoom(Room $room)
    {
        $room->main_image = DB::table('image_rooms')->select('image', 'priority')->where('room_id', '=', $room->id)->get();
        if (sizeof($room->main_image) < 1) {
            $non_image = ['priority' => 100, 'id' => '0', 'room_id' => $room->id, 'image' => 'room_4.jpeg'];
            $non_image = (object)$non_image;
            for ($j = sizeof($room->main_image); $j < 5; $j++) {
                $room->main_image->push($non_image);
            }
        }
        foreach ($room->main_image as $image) {
            $image->priority = intval($image->priority);
        }
        $room->main_image = $room->main_image->sortBy('priority');
        return $room;
    }

    public function getImagesHouse(House $house)
    {
        $house->main_image = DB::table('houses')
            ->select('image_houses.priority', 'houses.id', 'image_houses.image')
            ->join('image_houses', 'image_houses.house_id', '=', 'houses.id')
            ->orderBy('image_houses.priority', 'asc')
            ->where('house_id', '=', $house->id)
            ->get(); // Imagen principal
        if (sizeof($house->main_image) < 5) {
            $non_image = ['priority' => 100, 'id' => 0, 'image' => 'room_4.jpeg'];
            $non_image = (object)$non_image;
            for ($i = sizeof($house->main_image); $i < 5; $i++) {
                $house->main_image->push($non_image);
            }
        }
        foreach ($house->main_image as $image) {
            $image->priority = intval($image->priority);
        }
        $house->main_image = $house->main_image->sortBy('priority');
        return $house;
    }

    /**
     *
     * This function change de lang on session, with the intention to set a language in the VICO platform
     * @param $request:Inputs values sended by the view
     * @Author: Josue Esneider Fernandez Martinez
     */
    public function multilanguageUpdate(Request $request)
    {
        switch ($request->language) {
            case 'CO':
                $lang='es';
                break;
            case 'US':
                $lang='en';
                break;
            case 'DE':
                $lang='de';
                break;
            case 'FR':
                $lang='fr';
                break;
        }
        \App::setLocale($lang);
        return back()->with('lang',$lang);
    }

    public function addNeighborhood(Request $request){
        $location=new Location();
        $location->name=$request->name;
        $location->city_id=$request->city_id;
        $location->save();
        $neighborhood=new Neighborhood();
        $neighborhood->name=$request->name;
        $neighborhood->location_id=$location->id;
        $neighborhood->save();
        return $neighborhood;
    }

    public function addCity(Request $request){
        $city=new City();
        $city->name=$request->name;
        $city->country_id=$request->country_id;
        $city->save();
        return $city;
    }

    public function myVicos(){
        if(Auth::user()){
            if(Auth::user()->role_id === 1){
                $houses=House::all();
            }
            else if(Auth::user()->role_id == 2){
                $manager=Manager::where('user_id','=',Auth::user()->id)->first();
                $houses=House::where('manager_id','=',$manager->id)->get();
            }
            foreach ($houses as $house) {
                $house->main_image = DB::table('image_houses')
                    ->select('priority','house_id', 'image')
                    ->orderBy('image_houses.priority','asc')
                    ->where('house_id','=',$house->id)
                    ->limit(5)
                    ->get();
                if(sizeof($house->main_image) == 0){
                    $dummy_array=[];
                    $dummy_image=['priority'=>'0','house_id'=>$house->id,'image'=>'room_4.jpeg'];
                    $dummy_image=(object) $dummy_image;
                    for($i=0;$i<5;$i++){
                        array_push($dummy_array, $dummy_image);
                    }
                    $house->main_image=$dummy_array;
                }
                $house->min_date=$house->Rooms->min('available_from');
                $house->min_price=$house->Rooms->min('price');
                $neighborhood=Neighborhood::select('name')->where('id','=',$house->neighborhood_id)->first();
                $house->neighborhood_name=$neighborhood->name;
            }

            return view('houses.my_vicos',[
              'houses'=>$houses,
              'today_30' => Carbon::now()->addWeeks(4),
              'today' => Carbon::now()
            ]);
        }
        else{
            return view('auth.login',[
                'url'=>'myhouses'
            ]);
        }

    }

    /**
     * Show the jeffboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function jeffboard()
    {
        $houses=House::all();
                    foreach ($houses as $house) {
                        $house->available_rooms =  $house->rooms()->where('available_from','<',now())->count();
                    };
        return view('admin.jeffboard', [
            'houses' => $houses,
        ]);
    }

    public function notifyPhotoshootToManager(Request $request)
    {
        $manager = User::find($request->manager_as_user_id);
        $house = House::find($request->house_id);
        $manager->notify(new Photoshoot($manager, $house));

        return redirect()->back()->with('notification-sended','La notificación se ha enviado al manager');
    }

    public function notifyPhotoshootToManagerWhatsapp(Request $request)
    {
        $manager = User::find($request->manager_as_user_id);
        $manager->notify(new PhotoshootWhatsapp($manager));

        return redirect()->back()->with('notification-sended','La notificación se ha enviado al manager');
    }

    public function notifyPostedPhotosToManager(Request $request)
    {
        $manager = User::find($request->manager_as_user_id);
        $house = House::find($request->house_id);
        $manager->notify(new PostedPhotos($manager, $house));

        return redirect()->back()->with('notification-sended','La notificación se ha enviado al manager');
    }

    /**
     * Saves the user preferences
     *
     * This function is used to save lang,currency and region to user session
     * when the user is at /vicos/{city} it changes the city to the region selected
     * or redirects to the same view if the user is at other view
     *
     * @param Request $request receive a post request with city_code,currency and language.
     * @return View return to /vicos/{city} or the same view user was
     **/
    public function setUserPreferences(Request $request){        
        $lang = 'es';      
        switch ($request->language) {
            case 'CO':
                $lang='es';
                break;
            case 'US':
                $lang='en';
                break;
            case 'DE':
                $lang='de';
                break;
            case 'FR':
                $lang='fr';
                break;
        }        
        $url = url()->previous();       
        if($request->city_code != null){
            if($request->city_code != \Session::get('city_code')){
                if(strpos($url,'/vicos/')){
                    $city = City::where('city_code',$request->city_code)->first();
                    $url = "/vicos/" . strtolower(Str::ascii($city->name));
                    \Session::put('currency',$request->currency);
                    \Session::put('city_code',$request->city_code);
                    return redirect($url)->with('lang',$lang);
                }else{
                    \Session::put('city_code',$request->city_code);
                    \Session::put('currency',$request->currency);
                    return back()->with('lang',$lang);
                }
            }
        }
        \Session::put('currency',$request->currency);
        \App::setLocale($lang);
        return back()->with('lang',$lang);        
    }
}
