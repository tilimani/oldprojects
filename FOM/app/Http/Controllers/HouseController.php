<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Coordinate;
use App\Country;
use App\Device;
use App\DeviceHouse;
use App\DevicesRoom;
use App\House;
use App\Location;
use App\Homemate;
use App\HousesRule;
use App\ImageHouse;
use App\ImageRoom;
use App\Manager;
use App\Neighborhood;
use App\Room;
use App\CustomRule;
use App\Rule;
use App\School;
use App\User;
use App\Zone;
use App\City;
use App\Verification;
use App\Mail\ChangePetition;
use App\InterestPoint;
use App\VicoReferral;
/* Datos de las calificaciones */
use App\AverageHouses;
use App\AverageNeighborhood;
use App\AverageRooms;
use App\Booking;
use App\QualificationHouse;
use App\QualificationManager;
use App\QualificationNeighborhood;
use App\QualificationRoom;
use App\QualificationUser;
use Session;
use App\Events\BookingCacheWasExpired;
use App\Jobs\BookingPolice;
use App\Jobs\ReviewPolice;
use App\Jobs\ManagerPolice;
use App\Jobs\NotifyPendingPayments;
use App\Jobs\WeeklyReminderForManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Mail;
use Illuminate\Support\Facades\Cache;
use App\Currency;
use App\GenericInterestPoint;
use App\SpecificInterestPoint;
use App\Notifications\RegisteredVico;
use App\Notifications\RegisteredVicoNotifier;
use App\Notifications\UnPostedVico;
use App\Notifications\PostedVico;
use App\Http\Controllers\SegmentController as Analytics;


class HouseController extends Controller
{

    public function __construct()
    {
        $this->middleware('manager_house', ['only' => ['edit']]);
        // $this->middleware('manager_house', ['only' => ['edit','destroy','update']]);
    }

    protected $numberHouses = 15; //DEBERIA SER SINGULAR
    /**
    * Display a listing of the resource.
    *
    * @return view with the houses in te database
    */
    public function index($city)
    {
        //$query=self::getGeneralQuery();
        // dd($query);

        // $key = 'houses.page.' . request('page', 1);
        // $housescano = Cache::remember($key , 5, function(){
        //     return House::paginate(10);
        // });

        if (!Cache::has('booking_proccess')) {
        // if (true) {
            // proccess
            dispatch (new BookingPolice());
            dispatch (new ReviewPolice());
            dispatch (new ManagerPolice());
        // if (true) {

            $expiresAt = now()->addHours(12);
            Cache::put('booking_proccess', true, $expiresAt);
        }
        // if (true) {
            // News Leters
        if (!Cache::has('manager_pending_payments') && today()->englishDayOfWeek == 'Monday') {
            dispatch( new WeeklyReminderForManager() );
            dispatch( new NotifyPendingPayments() );
            Cache::put('manager_pending_payments', true, now()->addDays(3));
        }

        // [$houses,$housescoordinates] = self::getHouses('');
        $houses = self::getHousesIndex($city);
        $houses = self::orderHouses($houses,[1,0]);
        $count = 0;
        // $houses=self::paginateCollection($houses, 18, true);
        $houses = self::paginateCollection($houses,18,true);
        foreach ($houses as $key => $house) {
            $houses[$key] = (object)$house;
        }
        [$price_lower,$price_upper]=self::getPrices();

        $favorites = [];
        if (Auth::check()) {
            $favorites = DB::table('houses')
                ->select('houses.id')
                ->join('favorites', 'house_id', '=', 'houses.id')
                ->where('favorites.user_id', Auth::user()->id)
                ->orderBy('houses.id', 'desc')
                ->get();
        }
        $currency = new Currency;
        $currency = $currency->getCurrentCurrency();

        $interestPoints=InterestPoint::paginate(10);
        return view('houses.index', [
            'houses' => $houses,
            'schools' => School::all()->sortBy('name'),
            'neighborhoods' => Neighborhood::all()->sortBy('name'),
            'today' => Carbon::now(),
            'today_30' => Carbon::now()->addWeeks(4),
            // 'housescoordinates' =>$housescoordinates,
            // 'neighborhoodCount' => $neighborhoodCount,
            'price_lower' => $price_lower,
            'price_upper' => $price_upper,
            'favorites' => $favorites,
            'interestPoints' => $interestPoints,
            'currency' => $currency,
        ]);
    }
    /**
    * Display a listing of the resource.
    *
    * @return view with the houses in te database
    */
    public function indexNew($city_code = null, Request $request = null)
    {
        //$query=self::getGeneralQuery();

        // $key = 'houses.page.' . request('page', 1);
        // $housescano = Cache::remember($key , 5, function(){
        //     return House::paginate(10);
        // });
        if($request){
            $city = City::where('city_code', '=',$request->city_code)->firstOrFail();
            Session::put('city_code',$request->city_code);
        }else{
            $city = City::where('name', '=', $city_code)->orWhere('city_code','=',$city_code)->firstOrFail();

            if($city){
                Session::put('city_code',$city->city_code);
            }
        }

        // if (true) {
        if (!Cache::has('booking_proccess')) {
            dispatch (new BookingPolice());
            dispatch (new ReviewPolice());
            dispatch (new ManagerPolice());
            $expiresAt = now()->addHours(12);
            Cache::put('booking_proccess', true, $expiresAt);
        }
        // if (true) {
        if (!Cache::has('manager_pending_payments') && today()->englishDayOfWeek == 'Thuesday') {
            dispatch( new WeeklyReminderForManager() );
            dispatch( new NotifyPendingPayments() );
            Cache::put('manager_pending_payments', true, now()->addDays(3));
        }

        $page = Input::get('page', 1); // Get the ?page=1 from the url

        $houses = self::getHousesIndex($city->name);
        $zones = self::getZones($city->name);

        if($page < 2){
            $houses = self::orderHouses($houses, [1,0]);
        }
        // Temporalmente:
        if(count($houses) <2 && $city->city_code== 'BOG'){
             return redirect()->route('landingpage.bogota');
        }


        $count = 0;
        $neighborhoods = [];
        $neighborhoodsAll = Neighborhood::whereHas('location.zone.city',function($query) use ($city){
            $query->where('id',$city->id);
        })->get();

        foreach ($neighborhoodsAll as $neighborhood) {
            if (count($neighborhood->houses) > 0) {
                array_push($neighborhoods, $neighborhood);
            }
        }
        $neighborhoods = collect($neighborhoods);
        $houses=self::paginateCollection($houses, 18, true);
        // dd($houses);
        $coordinates = array();
        $arrayHouses = array();
        foreach ($houses as $key => $house) {
            array_push($coordinates, collect([
                    'lat'   =>  $house['coordinates']->lat,
                    'lng'   =>  $house['coordinates']->lng
                ]
            ));
            array_push($arrayHouses, $house);
            $houses[$key] = (object)$house;
        }
        [$price_lower,$price_upper]=self::getPrices();

        $favorites = [];
        if (Auth::check()) {
            $favorites = DB::table('houses')
                ->select('houses.id')
                ->join('favorites', 'house_id', '=', 'houses.id')
                ->where('favorites.user_id', Auth::user()->id)
                ->orderBy('houses.id', 'desc')
                ->get();
        }
        $currency = new Currency;
        $currency = $currency->getCurrentCurrency();
        $usd_currency = $currency->get('USD');
        $interestPoints=InterestPoint::paginate(10);
        $schools = School::whereHas(
                'neighborhoods.location.zone.city',
                function($query) use ($city){
                    $query->where('id', $city->id);
                }
            )->with('neighborhoods')
            ->get();

        foreach ($schools as $school) 
        {
            $ids = collect();
            $school->neighborhoods = $school->Neighborhoods->each( function ($item, $key) use ($ids) 
                { 
                    $ids = $ids->push($item->id);
                });
            $school->neighborhoods = $ids;
        }
        // dd($schools->sortBy('name'), $neighborhoods->sortBy('name'));

        return view(
            'houses.index', [
                'houses' => $houses,
                'schools' => $schools->sortBy('name'),
                'zones' => $zones->sortBy('name'),
                'today' => Carbon::now(),
                'today_30' => Carbon::now()->addWeeks(4),
                'price_lower' => $price_lower,
                'price_upper' => $price_upper,
                'favorites' => $favorites,
                'interestPoints' => $interestPoints,
                'currency' => $currency,
                'city' => $city,
                'coordinates'   =>  $coordinates,
                'arrayHouses'   =>  $arrayHouses,
                'strict_usd_currency' => $usd_currency->value,
            ]
        );
    }

    public function paginateCollection($collection, $offset_collection, $flag) //LA VARIABLE COLLECTION DEBERIA SER PLURAL
    {
        $page = Input::get('page', 1); // Get the ?page=1 from the url
        $perPage = $offset_collection; // Number of items per page
        $offset = ($page * $perPage) - $perPage;
        if ($flag) {
            $collection = $collection->toArray();
        }
        $collection= new LengthAwarePaginator(
            array_slice($collection, $offset, $perPage, true), // Only grab the items we need
            count($collection), // Total items
            $perPage, // Items per page
            $page, // Current page
            ['path' => url()->current()] // We need this so we can keep all old query parameters from the url
        );
        return $collection;
    }

    /**
    * Generate a base query for  in the database
    *
    * @return Query general, it's the base to  the houses in the database
    */
    public function getGeneralQuery()
    {
        $general_query = DB::table('houses')->join('rooms', 'rooms.house_id', '=', 'houses.id');
        $general_query = DB::table('houses')->join('neighborhoods', 'neighborhoods.id', '=', 'houses.neighborhood_id');
        $general_query = DB::table('houses')->join('managers', 'managers.id', '=', 'houses.manager_id');
        $general_query = $general_query->where('houses.status', '=', 1);
        $general_query = $general_query->orderBy('managers.vip', 'desc');
        return $general_query;
    }

    public function getPrices()
    {
        $prices = DB::table('rooms')->select('price')->get();
        foreach ($prices as $price) {
            $price->price=intval($price->price);
        }
        $price_lower=$prices->min();
        $price_upper=$prices->max();
        return [$price_lower,$price_upper];
    }

    /**
    *
    * Get the houses that we  with the query
    *
    * @param $query: is the var with the rules to find the houses in the database
    * @return Houses in the database that follow the rules
    */
    public function getHouses($query)
    {
        set_time_limit(300);
        $city = City::where('name',Session::get('city_name'))->first();
        if (isset($query->wheres[0]))
        {
            $where = $query->wheres[0];
            $houses=House::where([
                    'houses.status' => 1,
                    'houses.city_id' => $city->id,
                ])
                ->Whereraw($where['sql']->getValue())
            ->get();
        }else
        {
            $houses = House::where([
                'status' => 1,
                'city_id' => $city->id,
            ])->get();
        }
        $houses = self::setHousesValues($houses);
        return $houses;
    }

    /**
    *
    * Get the houses that we  with the query
    *
    * @param $query: is the var with the rules to find the houses in the database
    * @return Houses in the database that follow the rules
    */
    /**
    *
    * Get the zones that we  with the query
    *
    * @param $query: is the var with the rules to find the houses in the database
    * @return Zones in the database that follow the rules
    */
    public function getZones($city)
    {
        set_time_limit(300);
        if ($city) {
            $city = City::where('name', $city)->first();
            $zones = Zone::where('city_id', $city->id)
            ->with('locations.neighborhoods')
            ->get();
            foreach ($zones as $zone){
                $zone->neighborhoods = Neighborhood::wherehas('location.zone',function ($query) use ($zone) {
                    $query->where('id',$zone->id);
                })->get();
            }
            return $zones;
        } else {
            $zones = Collect();
            return $zones;
        }
    }
    public function getHousesIndex($city)
    {
        set_time_limit(300);
        if ($city) {
            $city = City::where('name', $city)->first();
            $houses = House::whereHas('neighborhood.location.zone.city', function ($query) use ($city) {
                $query->where('id',$city->id);
            })->where('status',1)->get();
            $houses = self::setHousesValues($houses);
            return $houses;
        } else {
            $houses = Collect();
            return $houses;
        }
    }

    /**
    *
    * Get the houses that we  with the query
    *
    * @param $query: is the var with the rules to find the houses in the database
    * @return Houses in the database that follow the rules
    */
    public function getHousesSearch ($inputs,$city)
    {
        // dd($inputs,$city);
        set_time_limit(300);
        if($city)
        {
            if (count($inputs) > 0)
            {
                $houses = House::whereHas('neighborhood',function($query) use ($inputs){
                    $query->whereIn('id',$inputs);
                })->where('status',1)->get();
                $houses = self::setHousesValues($houses);
                return $houses;
            }else 
            {
                $houses = House::whereHas('neighborhood.location.zone.city',function($query) use ($city){
                    $query->where('id',$city->id);
                })->where('status',1)->get();
                $houses = self::setHousesValues($houses);
                return $houses;
            }
        }
        else{
            $houses = Collect();
            return $houses;
        }
    }

    /**
    *
    * Set values to index in houses collection
    *
    * @param $query: is the var with the rules to find the houses in the database
    * @return Houses in the database that follow the rules
    */
    public function setHousesValues($houses)
    {
        // dd($houses->availableRooms;        );
        // dd($houses);
        foreach( $houses as $house)
        {
            $house->available_rooms = $house->availableRooms();
            $house->min_date = $house->minDate();
            $house->neighborhood_name = $house->neighborhood()->first()->name;
            $house->min_price = $house->minPrice();
            $house->main_image = $house->imageHouses()->orderBy('image_houses.priority')->take(4)->get();
            $house->coordinates = $house->coordinates()->first();
        }
        return $houses;
    }

    public function getMinDateAvailableRoom($room)
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
        if ($available_date == '') {
            $available_date=$room->available_from;
        }
        if(Carbon::parse($available_date) < Carbon::now()){
            $available_date=Carbon::now()->toDateTimeString();
        }
        $room->available_from=$available_date;
        DB::beginTransaction();
        DB::table('rooms')->where('id', '=', $room->id)->update([
            'available_from' => $available_date
            ]);
        DB::commit();
        return $available_date;
    }

    /**
    * Generate a query with the rules to  houses wih specific rules
    *
    * @param $inputs: var that have the inputs values with the rules to  the houses
    * @return Query with the specific and required rules,'joins' and 'wheres' to  in the database
    * @author Josue
    */
    public function getQuery(array $inputs)
    {
        // $query=self::getGeneralQuery();
        // dd($inputs);
        $query = DB::table('houses');
        if (isset($inputs['alld']) && $inputs['alld'] != '') {
            $inputs['alld']=str_replace('/', ' ', $inputs['alld']);
            // dd($inputs['alld']);
            $query_school = DB::table('schools')->where('name', '=', $inputs['alld'])->distinct()->get();
            if (count($query_school)>0) {
                $query_schools = DB::table('neighborhood_schools')->where('school_id', '=', $query_school[0]->id)->distinct()->get();
                if (count($query_schools) > 0) {
                    $this->to=$inputs['alld'];
                    $validator = true;
                    $array_schools = [];
                    for ($i=0; $i < count($query_schools); $i++) {
                        array_push($array_schools, $query_schools[$i]->neighborhood_id);
                    }
                    $query->whereRaw(DB::raw("neighborhood_id IN(".implode(",", $array_schools).")"));
                }
            } else {
                $query_neighborhoods = DB::table('neighborhoods')->where('name', '=', $inputs['alld'])->distinct()->get();
                if (count($query_neighborhoods) > 0) {
                    $this->to=$inputs['alld'];
                    $validator = true;
                    $array_neighborhoods = [];

                    for ($i=0; $i < count($query_neighborhoods); $i++) {
                        array_push($array_neighborhoods, $query_neighborhoods[$i]->id);
                    }

                    $query->whereRaw(DB::raw("neighborhood_id IN(".implode(",", $array_neighborhoods).")"));
                }
            }
            if (isset($inputs['date']) && !is_null($inputs['date'])) {
                $this->dateto=$inputs['date'];
                $date = Carbon::createFromFormat('Y-m-d', $inputs['date'])->toDateTimeString();
                $query->whereRaw(DB::raw("DATE(rooms.available_from) <= DATE('".$date."')"));
            }
        } elseif (isset($inputs['date']) && !is_null($inputs['date'])) {
            $this->dateto=$inputs['date'];
            $date = Carbon::createFromFormat('Y-m-d', $inputs['date'])->toDateTimeString();
            $query->whereRaw(DB::raw("DATE(rooms.available_from) <= DATE('".$date."')"));
        }
        return $query;
    }

    /**
    * Order houses by topics.
    * houses is a Collection of houses
    * topics is a array whit flags to sort houses
    * topics[0] sort by vip and min_date
    * @param Houses,topics
    * @return Houses
    * @author Cristian
    * Modificado por Andres Cano
    * Comentado por Tilman para cambiar algoritmo
    **/
    // public static function orderHouses($houses,Array $topics)
    // {
    //     if($topics[0] == 1)
    //     {
    //         foreach ($houses as $house)
    //         {
    //             $manager = Manager::find($house->manager_id);

    //             $qualification = AverageHouses::where('house_id','=',$house->id)
    //                 ->first();

    //             // $countReview = QualificationHouse::where('')
    //             $quaVal = (isset($qualification)) ? $qualification->global : 1 ;

    //             $house->average_house = $quaVal;

    //             if (strtotime(Carbon::now()) >= strtotime($house->min_date))
    //             {
    //                 if ($manager->vip == 1)
    //                 {
    //                     // if ($quaVal >= 4)
    //                     // {
    //                     //         $house->order = 0;
    //                     // // }else if (condition) {
    //                     // //      $house->order = 1;
    //                     // } else
    //                     // {
    //                     // temporaly off
    //                             $house->order = 3;
    //                     // }
    //                 }else
    //                 {
    //                     // if ((float)$quaVal >= 4 /*|| condition */)
    //                     // {
    //                     //         $house->order = 2;
    //                     // } else
    //                     // {
    //                     // temporaly off
    //                             $house->order = 4;
    //                     // }
    //                 }
    //             } elseif (strtotime(Carbon::now()->addWeeks(4)) >= strtotime($house->min_date))
    //             {
    //                 if ($manager->vip == 1)
    //                 {
    //                     // if ((float)$quaVal > 4)
    //                     // {
    //                     //         $house->order = 5;
    //                     // // }else if (condition) {
    //                     //     //      $house->order = 1;
    //                     // } else
    //                     // {
    //                     // temporaly off
    //                     $house->order = 7;
    //                     // }
    //                 }else
    //                 {
    //                     // if ((float)$quaVal > 4 /*|| condition */)
    //                     // {
    //                     //     $house->order = 8;
    //                     // } else
    //                     // {
    //                     // temporaly off
    //                         $house->order = 9;
    //                     // }
    //                 }
    //             } else
    //             {
    //                 $house->order = 10;
    //             }
    //         }
    //         $houses =  $houses->sortBy('order');
    //     }

    //     if ($topics[1] > 0)
    //     {
    //         if ($topics[1] == 1)
    //         {
    //             $house->sortByDesc('min_price');
    //         }
    //         if ($topics[1] == 2)
    //         {
    //             $house->sortBy('min_price');
    //         }
    //     }
    //     // // $collect=$collect->sortBy('order')->sortByDesc('min_price');
    //     return $houses;
    // }


    /**
    * Order houses by topics.
    * houses is a Collection of houses
    * topics is a array whit flags to sort houses
    * topics[0] sort by vip and min_date
    * @param Houses,topics
    * @return Houses
    * @author Tilman
    **/
    public static function orderHouses($houses,Array $topics)
    {
        // dd($houses);
        if($topics[0] == 1)
        {
            foreach ($houses as $house)
            {
                $manager = Manager::find($house->manager_id);

                // $qualification = AverageHouses::where('house_id','=',$house->id)
                //     ->first();

                // // $countReview = QualificationHouse::where('')
                // $quaVal = (isset($qualification)) ? $qualification->global : 1 ;

                // $house->average_house = $quaVal;
                // $house->order = intval($house->video);
                // // dd($house->video);
                // // if($manager->vip == 1){
                // //     $house->order
                // // }
                // if($house->order == 0){
                //     if (strtotime(Carbon::now()) >= strtotime($house->min_date))
                //     {
                //         if ($manager->vip == 1)
                //         {
                //             if ($quaVal >= 4)
                //             {
                //                     $house->order = 0+300;
                //             // }else if (condition) {
                //                  // $house->order = 1;
                //             } else
                //             {
                //             // temporaly off
                //                     $house->order = 3+300;
                //             }
                //         }else
                //         {
                //             if ((float)$quaVal >= 4 /*|| condition */)
                //             {
                //                     $house->order = 2+300;
                //             } else
                //             {
                //             // temporaly off
                //                     $house->order = 4+300;
                //             }
                //         }
                //     } elseif (strtotime(Carbon::now()->addWeeks(4)) >= strtotime($house->min_date))
                //     {
                //         if ($manager->vip == 1)
                //         {
                //             if ((float)$quaVal > 4)
                //             {
                //                     $house->order = 5+300;
                //             // }else if (condition) {
                //                 //      $house->order = 1;
                //             } else
                //             {
                //             // temporaly off
                //             $house->order = 7+300;
                //             }
                //         }else
                //         {
                //             if ((float)$quaVal > 4 /*|| condition */)
                //             {
                //                 $house->order = 8+300;
                //             } else
                //             {
                //             // temporaly off
                //                 $house->order = 9+300;
                //             }
                //         }
                //     } else
                //     {
                //         $house->order = 10+300;
                //     }
                // }

                if(strtotime(Carbon::now()) >= strtotime($house->min_date)){
                    $house->order = mt_rand(200, 400);

                    if ($manager->vip == 1){
                        $house->order = mt_rand(0, 199);
                    }

                }else{
                    $house->order = mt_rand(401, 600);
                }

                $house->order = intval($house->order);
            }
            // Sort houses, starting from the smallest to the biggest
            $houses =  $houses->sortBy('order');
        }

        if ($topics[1] > 0)
        {
            if ($topics[1] == 1)
            {
                $house->sortByDesc('min_price');
            }
            if ($topics[1] == 2)
            {
                $house->sortBy('min_price');
            }
        }
        // // $collect=$collect->sortBy('order')->sortByDesc('min_price');
        return $houses;
    }



    /**
    * filter houses by users criteria
    * @param Houses, Collection with houses to filter
    * @param housescoordinates, Collection with house's coodinates
    * @param filters, Array with values for each criteria to filter
    * filters[0], this variable filter for houses by environment,
    *   if variable is 0 so, it not filter
    *   if variable is 1 so, it filter by independ environment
    *   if variable is 2 so, it filter by familiar environment
    * filters[1], this variable filter for bath type in rooms,
    *   if variable is 0 so, it not filter
    *   if variable is > 0 so, it filter by variable value of rooms with private bath in house
    * filters[2], this variable filter for available rooms in house,
    *   if variable is 0 so, it not filter
    *   if variable is > 0 so, it filter by variable value of rooms in house
    * filters[3], this variable filter for max rooms in house,
    *   if variable is 0 so, it not filter
    *   if variable is > 0 so, it filter by variable value of max rooms in house
    * filters[4], this variable filter for max price in rooms,
    *   if variable is 0 so, it not filter
    *   if variable is > 0 so, it filter by variable value of rooms price in house
    * filters[5], this variable is a array that filter by house's type
    *   Array have 3 flags if someone is 0, so unset all houses by house's type
    * filters[6], this variable is a array that filter by house's devices
    *   Array have 3 flags if someone is 1, so unset all houses without a same house's device
    * @author Cristian
    * @return  Collection with houses filtered
    */
    public function filter($houses,$filters,$currency)
    {

        if ($filters[0] == 1)
        {
            foreach ($houses as $key => $house)
            {
                $rule = HousesRule::where('house_id','=',$house->id)
                    ->where('rule_id','=',13)
                    ->first();
                if ($rule->description == "0")
                {
                    unset($houses[$key]);
                }
            }
        }
        if ($filters[0] == 2)
        {
            foreach ($houses as $key => $house)
            {
                $rule = HousesRule::where('house_id','=',$house->id)
                    ->where('rule_id','=',13)
                    ->first();
                if ($rule->description == "1")
                {
                    unset($houses[$key]);
                }
            }
        }
        if ($filters[1] > 0)
        {
            foreach ($houses as $key => $house)
            {
                $count = 0;
                foreach ($house->Rooms as $room) {
                    $devices_rooms = DevicesRoom::where('room_id','=',$room->id)
                        ->first();

                    if ($devices_rooms->bath_type == 'privado')
                    {
                        $count++;
                    }
                }

                if ($count < $filters[1])
                {
                    unset($houses[$key]);
                }
            }
        }

        if ($filters[2] > 0 )
        {
            foreach ($houses as $key => $house)
            {
                if ($house->available_rooms < $filters[2])
                {
                    unset($houses[$key]);
                }
            }
        }
        if ($filters[3] > 0)
        {
            foreach ($houses as $key => $house)
            {
                if ($house->rooms_quantity > $filters[3])
                {
                    unset($houses[$key]);
                }
            }
        }
        if ($filters[4] > 0)
        {
            $max_price=intval(str_replace(".", "", $filters[4]));
            foreach ($houses as $key => $house)
            {
                foreach ($house->Rooms as $room)
                {
                    $house->min_price = intVal($house->Rooms->min('price'));
                }
                if ( $max_price <= $house->min_price * $currency->value) // if count >= quantity of rooms so, house is unset
                {
                    unset($houses[$key]);
                }
            }
        }
        for ($i=0; $i < sizeof($filters[5]) ; $i++)
        {
            $array = $filters[5];

            switch ($i) {
                case 0:
                    $type = 'Casa';
                    break;
                case 1:
                    $type = 'Apartamento';
                    break;
                case 2:
                    $type = 'Aparta-estudio';
                    break;
                default:
                    $type = '';
                    break;
            }

            if ($array[$i] == 0) {
                foreach ($houses as $key => $house)
                {
                    if($house->type == $type)
                    {
                        unset($houses[$key]);
                    }
                }
            }

        }

        // $array = [0,0,0,0,0,[],[]];
        $array = $filters[6];
        $array[0] = ($array[0] == 1)? 11 :null;
        $array[1] = ($array[1] == 1)? 10 :null;
        $array[2] = ($array[2] == 1)? 16 :null;

        foreach ($houses as $key => $house)
        {
            $device = ($array[0] != null || $array[1] != null || $array[2] != null) ?
            DeviceHouse::where('house_id','=',$house->id)
                ->whereIn('device_id',$array)
                ->exists() :
            true;
            // dd($array, $device);
            if(!$device)
            {
                unset($houses[$key]);
            }
        }

        return $houses;
    }

    /**
     * Show results of the search.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function searchNew(Request $request)
    {
        // dd($request->all());
        $inputs = [];
        $neighborhoodCount = [];
        $hrefSeeMore='';
        $filters = [0,0,0,0,0,[],[]];
        $houseTypes = (!isset($request->houseType0) && !isset($request->houseType1) && !isset($request->houseType2)) ?
        [1,1,1] :[0,0,0];
        $others = [0,0,0];
        
        if (isset($request->neighborhood) ) {
            $inputs['alld']=$request->neighborhood;
        }else
        {
            $inputs['alld'] = [];
        }
        if (isset($request->date)) {
            $inputs['date']=$request->date;
            if (strpos($hrefSeeMore,'?') === 0) {
                $hrefSeeMore=$hrefSeeMore.'&date_filter='.$request->date;
            } else {
                $hrefSeeMore=$hrefSeeMore.'?date_filter='.$request->date;
            }
        }

        if (isset($request->houseType0))
        {
            $houseTypes[0] = (int)$request->houseType0;
        }

        if (isset($request->houseType1))
        {
            $houseTypes[1] = (int)$request->houseType1;
        }

        if (isset($request->houseType2))
        {
            $houseTypes[2] = (int)$request->houseType2;
        }

        if (isset($request->otherFilters0))
        {
            $others[0] = (int)$request->otherFilters0;
        }

        if (isset($request->otherFilters1))
        {
            $others[1] = (int)$request->otherFilters1;
        }

        if (isset($request->otherFilters2))
        {
            $others[2] = (int)$request->otherFilters2;
        }

        if (isset($request->enviroment))
        {
            $filters[0] = $request->enviroment;
        }
        if (isset($request->enviroment))
        {
            $filters[0] = $request->enviroment;
        }

        if (isset($request->availableRooms))
        {
            $filters[2] = $request->availableRooms;
        }

        if (isset($request->maxRooms))
        {
            $filters[3] = $request->maxRooms;
        }

        if (isset($request->privateBathroom))
        {
            $filters[1] = $request->privateBathroom;
            if (strpos($hrefSeeMore,'?') === 0) {
                $hrefSeeMore=$hrefSeeMore.'&private_bathroom_filter='.$request->privateBathroom;
            } else {
                $hrefSeeMore=$hrefSeeMore.'?private_bathroom_filter='.$request->privateBathroom;
            }
        }

        if (isset($request->maxPrice))
        {
            $filters[4] = $request->maxPrice;
            if (strpos($hrefSeeMore,'?') === 0) {
                $hrefSeeMore=$hrefSeeMore.'&price_filter='.$request->maxPrice;
            } else {
                $hrefSeeMore=$hrefSeeMore.'?price_filter='.$request->maxPrice;
            }
        }

        $filters[5] = $houseTypes;
        $filters[6] = $others;
        // if($inputs['alld'] != "")
        // {
        $city = City::where('city_code',Session::get('city_code'))->first();
        $zones = self::getZones($city->name);

        $houses = self::getHousesSearch($inputs['alld'],$city);

        if (isset($request->sortBy)) {
            $houses=self::sortHousesBy($houses,$request->sortBy);
        }else
        {
            $page = Input::get('page', 1); // Get the ?page=1 from the url
            if($page < 2){
                $houses=self::orderHouses($houses,[1,0]);
            }
        }
        $currency = new Currency;
        $currency = $currency->getCurrentCurrency();

        $houses =self::filter($houses, $filters, $currency);

        $houses->toArray();
        $houses=self::paginateCollection($houses, 18, true);
        [$price_lower,$price_upper]=self::getPrices();
        $houses->appends(request()->all())->links();
        $favorites = [];
        if (Auth::check()) {
            $favorites = DB::table('houses')
            ->select('houses.id')
            ->join('favorites', 'house_id', '=', 'houses.id')
            ->where('favorites.user_id', Auth::user()->id)
            ->orderBy('houses.id', 'asc')
            ->get();
        }
        // dd($houses->links());
        foreach ($houses as $key => $house) {
            $houses[$key] = (object)$house;
        }
        $interestPoints=InterestPoint::all();

        $neighborhoods = [];
        try {
            $neighborhoodsAll = Neighborhood::whereHas('location.zone.city', function ($query) use ($city) {
                $query->where('id', $city->id);
            })->get();
        } catch (\Exception $ex) {
            $city = City::find(1);
            $neighborhoodsAll = Neighborhood::whereHas('location.zone.city', function ($query) use ($city) {
                $query->where('id', $city->id);
            })->get();
        }

        foreach ($neighborhoodsAll as $neighborhood) {
            if (count($neighborhood->houses) > 0) {
                array_push($neighborhoods, $neighborhood);
            }
        }
        $arrayHouses = array();

        foreach ($houses as $house) {
            array_push($arrayHouses, $house);
        }

        $schools = School::whereHas(
                'neighborhoods.location.zone.city',
                function($query) use ($city){
                    $query->where('id', $city->id);
                }
            )->with('neighborhoods')
            ->get();

        foreach ($schools as $school) 
        {
            $ids = collect();
            $school->neighborhoods = $school->Neighborhoods->each( function ($item, $key) use ($ids) 
                { 
                    $ids = $ids->push($item->id);
                });
            $school->neighborhoods = $ids;
        }
        return view('houses.index', [
            'arrayHouses' => $arrayHouses,
            'houses' => $houses,            
            'schools' => $schools->sortBy('name'),
            'zones' => $zones->sortBy('name'),
            'today' => Carbon::now(),
            'today_30' => Carbon::now()->addWeeks(4),
            'numberHouses' => $this->numberHouses,
            'price_lower' => $price_lower,
            'price_upper' => $price_upper,
            'favorites' => $favorites,
            'hrefSeeMore' => $hrefSeeMore,
            'interestPoints' => $interestPoints,
            'currency' => $currency,
            'city' => $city,
        ]);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $managers=DB::table('users')->where('role_id', '=', '2')->join('managers', 'managers.user_id', '=', 'users.id')->get();
        return view('houses.create', [
      'neighborhoods' => Neighborhood::all()->sortBy('name'),
      'managers' => $managers->sortBy('name'),
      'rules' => Rule::all(),
      'devices' => Device::all(),
      'schools' => School::all()->sortBy('name'),
      'today' => Carbon::now(),
      'today_30' => Carbon::now()->addWeeks(4),
      'countries' => Country::all()->sortBy('name')
    ]);
    }

    /**
    * Sort houses by a parameter
    *
    * @return \Illuminate\Http\Response
    */
    public function sortHousesBy($houses,$sortBy)
    {
        foreach ($houses as $house)
        {
            $house->min_price = $house->minPrice();
            $house->min_date = $house->minDate();
        }

        switch ($sortBy) {
            case 1:
                $houses=$houses->sortBy('min_date');
            break;
            case 2:
                $houses=$houses->sortByDesc('min_date');
            break;
            case 3:
                $houses=$houses->sortByDesc('min_price');
            break;
            case 4:
                $houses=$houses->sortBy('min_price');
            break;
        }
        return $houses;
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {

        $request->validate([
      'name' => 'required|max:128',
      'address' => 'required|max:128',
      'description_house' => 'required|max:766',
      'description_zone' => 'required|max:766',
      'manager_id' => 'required',
      'neighborhood' => 'required',
      'second_image' => 'required',
      'rooms' => 'required',
      'baths' => 'required',
      'type' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $house = new House();
            $house->name = $request->name;
            $house->address = $request->address;
            $house->description_house = $request->description_house;
            $house->description_zone = $request->description_zone;
            $house->manager_id = $request->manager_id;
            $house->neighborhood_id = $request->neighborhood;
            $house->video = $request->video;
            $house->rooms_quantity = $request->rooms;
            $house->baths_quantity = $request->baths;
            $house->type = $request->type;
            $house->video='youtube.com';
            // $house->status='5';  # Deberia ser 0 y no 5 REVIZAR
            $house->status=5;
            $house->save();

            $coordinate = new Coordinate();
            $coordinate->house_id = $house->id;
            $coordinate->lat = $request->lat;
            $coordinate->lng = $request->lng;
            $coordinate->save();


            $s3 = Storage::disk('s3');

            if(isset($request->customRule)){
                foreach ($request->custom_rules as $custom)
                {
                    $custom_rule = new CustomRule();
                    $custom_rule->description = $custom;
                    $custom_rule->house_id = $house->id;
                    $custom_rule->save();
                }
            }
            for ($i=0; $i < count($request->file('second_image')); $i++) {
                $second_images = $request->file('second_image')[$i];
                if ($second_images->getClientMimeType() === "image/jpeg" || $second_images->getClientMimeType() === "image/png") {
                    $time = Carbon::now();
                    $time=$time->year.$time->month.$time->day.$time->hour.$time->minute.$time->second;
                    $s3->put('house_'.$house->id."_".$i."_".$time.".".$second_images->extension(), file_get_contents($second_images), 'public');

                    $image_house = new ImageHouse();
                    $image_house->house_id = $house->id;
                    $image_house->image = 'house_'.$house->id."_".$i."_".$time.".".$second_images->extension();
                    $image_house->priority='1';
                    $image_house->description="";
                    $image_house->save();
                }
            }
            foreach ($request->all() as $key => $value) {
                if (starts_with($key, 'device_')) {
                    $id = str_replace_first('device_', '', $key);

                    $device_house = new DeviceHouse();
                    $device_house->house_id = $house->id;
                    $device_house->device_id = $id;

                    $device_house->save();
                }

                if (starts_with($key, 'rule_')) {
                    $id = str_replace_first('rule_', '', $key);

                    $rule_house = new HousesRule();
                    $rule_house->house_id = $house->id;
                    $rule_house->rule_id = $id;
                    $rule_house->description = $value;

                    $rule_house->save();
                }
            }
            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            // return $e; ## esto no se debe mostrar
        }

        /*return view('houses.index', [
        'houses' => House::all(),
        'schools' => School::all()->sortBy('name'),
        'neighborhoods' => Neighborhood::all()->sortBy('name'),
        'today' => Carbon::now(),
        'today_30' => Carbon::now()->addWeeks(4)
        ])*/

        return redirect('houses/edit/'.$house->id);
    }


    /**
    * Display the specified resource.
    *
    * @param  App\House $house
    * @return \Illuminate\Http\Response
    */
    public function show(House $house,Request $filters)
    {
        $neighborhood=Neighborhood::where('id','=',$house->neighborhood_id)->first();
        // dd($neighborhood);
        $interestPoints=InterestPoint::where('neighborhood_id','=',$neighborhood->id)->get();
        $schools=DB::table('neighborhood_schools')->where('neighborhood_id','=',$neighborhood->id)->get();
        foreach ($schools as $school) {
            $school=School::where('id','=',$school->school_id)->first();
        }
        $rooms = $house->Rooms->sortBy('number'); //Inicializar las habitaciones ordenadas por número
        $house->Rooms=$rooms;
        $min_price= $house->Rooms->min('price');
        $neighborhood = Neighborhood::where('id', '=', $house->neighborhood_id)->firstOrFail(); // Inicializar los barrios por casa

        $city = City::find($neighborhood->location->zone->city_id);
        foreach ($rooms as $room) {
            $room->devices = DB::table('devices_rooms')
          ->where('room_id', '=', $room->id)
          ->first(); // Inicializar los dispositovs por casa
        }
        $rules = DB::table('houses_rules')
            ->select('houses_rules.description','rules.name','rules.icon','rules.icon_span')
            ->join('rules', 'rules.id', '=', 'houses_rules.rule_id')
            ->where('houses_rules.house_id', '=', $house->id)->distinct()
            ->orderBy('rules.icon')
            ->get(); // Inicializar reglas de la casa
        
        $custom_rules = $house->CustomRules;

        foreach ($house->Rooms as $key => $room) {
            $room=$this->getImagesRoom($room);
            $room->available_from=self::getMinDateAvailableRoom($room);
            $room->available = $room->available_from < Carbon::now() ? 'Disponible' : 'No disponible';//Dispoinibilidad
            $room->priority=0;

            if(isset($filters->private_bathroom_filter)){
                if($room->devices->bath_type === 'privado' && intval($filters->private_bathroom_filter) === 1){
                    $room->priority++;
                }
                $house->filteredRooms=true;
            }
            if(isset($filters->price_filter)){
                $filters->price_filter=str_replace('.','',$filters->price_filter);
                if(intval($room->price) <= $filters->price_filter){
                    $room->priority++;
                }
                $house->filteredRooms=true;
            }
            if(isset($filters->date_filter)){
                if($room->available_from <= $filters->date_filter){
                    $room->priority+=3;
                }
                $house->filteredRooms=true;
            }
        }

        //Calculate the date of every month from today to six months ago
        $six_months_ago = Carbon::now()->subMonth(6)->format('Y-m-d');
        $five_months_ago = Carbon::now()->subMonth(5)->format('Y-m-d');
        $four_months_ago = Carbon::now()->subMonth(4)->format('Y-m-d');
        $three_months_ago = Carbon::now()->subMonth(3)->format('Y-m-d');
        $two_months_ago = Carbon::now()->subMonth(2)->format('Y-m-d');
        $one_months_ago = Carbon::now()->subMonth(1)->format('Y-m-d');

        //Calculate the date of every month from today to six months forward
        $six_months_fw = Carbon::now()->addMonth(6)->format('Y-m-d');
        $five_months_fw = Carbon::now()->addMonth(5)->format('Y-m-d');
        $four_months_fw = Carbon::now()->addMonth(4)->format('Y-m-d');
        $three_months_fw = Carbon::now()->addMonth(3)->format('Y-m-d');
        $two_months_fw = Carbon::now()->addMonth(2)->format('Y-m-d');
        $one_months_fw = Carbon::now()->addMonth(1)->format('Y-m-d');

        //group the specific months date for send it to the view
        $months_specific_dates = array('-6' => $six_months_ago,
            '-5' => $five_months_ago,
            '-4' => $four_months_ago,
            '-3' => $three_months_ago,
            '-2' => $two_months_ago,
            '-1' => $one_months_ago,
            '0'=> Carbon::now()->format('Y-m-d'),
            '6' => $six_months_fw,
            '5' => $five_months_fw,
            '4' => $four_months_fw,
            '3' => $three_months_fw,
            '2' => $two_months_fw,
            '1' => $one_months_fw);

        //Set locale lenguage for dateTime types to spanish
        setlocale(LC_TIME, 'es');

        //Months name
        $months_name = array('-6' => Carbon::now()->subMonth(6)->formatLocalized("%B"),
            '-5' => Carbon::now()->subMonth(5)->formatLocalized("%B"),
            '-4' => Carbon::now()->subMonth(4)->formatLocalized("%B"),
            '-3' => Carbon::now()->subMonth(3)->formatLocalized("%B"),
            '-2' => Carbon::now()->subMonth(2)->formatLocalized("%B"),
            '-1' => Carbon::now()->subMonth(1)->formatLocalized("%B"),
            '6' => Carbon::now()->addMonth(6)->formatLocalized("%B"),
            '5' => Carbon::now()->addMonth(5)->formatLocalized("%B"),
            '4' => Carbon::now()->addMonth(4)->formatLocalized("%B"),
            '3' => Carbon::now()->addMonth(3)->formatLocalized("%B"),
            '2' => Carbon::now()->addMonth(2)->formatLocalized("%B"),
            '1' => Carbon::now()->addMonth(1)->formatLocalized("%B"));

        //Restart the local lenguage for dataTime types
        setlocale(LC_TIME, '');

        $homemates=DB::table('houses')
            ->select('users.name', 'users.gender', 'countries.name as country', 'countries.icon', 'bookings.date_from', 'bookings.date_to', 'bookings.status')
            ->join('rooms', 'rooms.house_id', '=', 'houses.id')
            ->join('bookings', 'bookings.room_id', '=', 'rooms.id')
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->join('countries', 'countries.id', '=', 'users.country_id')
            ->where('houses.id', '=', $house->id)
            ->where(function ($q) {
                $q->where('bookings.status', '=', 5)->orWhere('bookings.status', '=', 100);
            })
            ->where('bookings.date_from', '>=', $six_months_ago)
            ->where('bookings.date_from', '<=', $six_months_fw)
            ->orderBy('houses.id', 'desc')
            ->groupBy('houses.id', 'users.name', 'users.gender', 'country', 'countries.icon', 'bookings.date_from', 'bookings.date_to')
            ->get(); // Inicializar compañeros de habitación

        $month_homemates_correct = [];

        for ($i = -6; $i<=6; $i++) {
            $monthly = [];
            foreach ($homemates as $homemate) {
                // Check if there are dates in the fakebooking
                if(!$homemate->date_to){
                    $homemate->date_to = '9999-12-31';
                }
                if(!$homemate->date_from){
                    $homemate->date_from ='2018-12-31';
                }
                if (Carbon::createFromFormat('Y-m-d', $months_specific_dates[strval($i)])->between(Carbon::createFromFormat('Y-m-d', $homemate->date_from), Carbon::createFromFormat('Y-m-d', $homemate->date_to))) {
                    array_push($monthly, $homemate);
                }
            }
            $month_homemates_correct[strval($i)]=$monthly;
        }

        $manager=DB::table('managers')
            ->join('users', 'users.id', '=', 'managers.user_id')
            ->where('managers.id', '=', $house->manager_id)
            ->get()->first(); // Inicializar Managers

        $devices=DB::table('device_houses')
      ->select('devices.id as id_devices', 'devices.name', 'devices.icon')
      ->join('houses', 'houses.id', '=', 'device_houses.house_id')
      ->join('devices', 'devices.id', '=', 'device_houses.device_id')
      ->where('device_houses.house_id', '=', $house->id)
      ->groupBy('id_devices', 'devices.name', 'devices.icon')
      ->get(); // Inicializar dispositivos

        $query=DB::table('houses')
      ->join('managers', 'managers.id', '=', 'houses.manager_id'); // Join con managers
        $house->main_image = DB::table('houses')
      ->select('image_houses.priority', 'houses.id', 'image_houses.image')
      ->join('image_houses', 'image_houses.house_id', '=', 'houses.id')
      ->orderBy('image_houses.priority', 'asc')
      ->where('house_id', '=', $house->id)
      ->get(); // Imagen principal
      if(sizeof($house->main_image) < 5){
        $non_image = ['priority'=>100,'id'=>0,'image'=>'room_4.jpeg'];
        $non_image= (object) $non_image;
        for($i=sizeof($house->main_image);$i<5;$i++){
          $house->main_image->push($non_image);
        }
      }
        foreach ($house->main_image as $image) {
            $image->priority=intval($image->priority);
        }
        $house->main_image=$house->main_image->sortBy('priority');

        $check=Auth::check(); // Tomar si el usuario está autentificado

        $housescoordinates = DB::table('houses')
      ->select(
          'houses.id',
          'houses.name',
          'houses.address',
          'cities.name as city',
          'coordinates.lat',
          'coordinates.lng',
      DB::raw("(SELECT MIN(rooms.price) FROM rooms WHERE rooms.house_id = houses.id) as min_price")
      )
        // ->where('houses.status', '=', 1)
      ->where('houses.id', '=', $house->id)
      ->join('neighborhoods', 'neighborhoods.id', '=', 'houses.neighborhood_id')
      ->join('locations', 'locations.id', '=', 'neighborhoods.location_id')
      ->join('zones','zones.id','=','locations.zone_id')
      ->join('cities', 'cities.id', '=', 'zones.city_id')
      ->join('coordinates', 'coordinates.house_id', '=', 'houses.id')
      ->get(); // Coordenadas de la casa

        /**
        **  Inicializar las calificaciones de la habitación para ser procesadas en el controlador.
        ** @Andres Felipe Cano
        **/
        $count = 0; //contador auxiliar

        $bookings_house = []; //booking de cada casa

        $reviewCount = 0; //contador de reseñas

        /**
        * calificaciones realizadas por usuario,
        * esta es necesario realizar paginación
        **/
        $qualification_users = [];

        $reviews_house = DB::table('average_houses')
        ->where('house_id', '=', $house->id)
        ->get();
        $reviews_neighborhood = DB::table('average_neighborhoods')
        ->where('neighborhood_id', '=', $house->neighborhood_id)
        ->get();


        //Obtener todos reviews por booking y así llegar al comentario
        foreach ($house->rooms as $room) {
            $bookings = DB::table('bookings')
                ->select('id', 'room_id', 'user_id')
                ->where('room_id', '=', $room->id)
                ->get();
            foreach ($bookings as $booking) {
                $bookings_house[$count] = $booking; //Se guarda el id y el id_room de cada booking asociado a la casa
                $count++;
            }
        }

        $count = 0; // Se reinicia el contador
        foreach ($bookings_house as $booking) {
            $qualification_user = DB::table('bookings')->select('bookings.id','bookings.user_id','bookings.date_from','bookings.date_to','users.name','users.last_name','users.image','users.country_id','users.gender','countries.icon','countries.name as country_name','qualification_houses.house_comment')
                ->where('bookings.id', '=', $booking->id)
                ->join('users', 'users.id', '=', 'bookings.user_id')
                ->join('qualification_houses', 'qualification_houses.bookings_id', '=', 'bookings.id')
                ->join('countries', 'countries.id', '=', 'users.country_id')
                ->get();
            //  dd($qualification_user);
            if ((count($qualification_user)) >  0) {
                $dateFrom = Carbon::parse($qualification_user[0]->date_from);
                $dateInMonths = (Carbon::now()->diffInDays($dateFrom))/30;
                $merged = $qualification_user->merge($dateInMonths);
                $result = $merged->all();
                $qualification_users[$count] = $result;
                $count ++; //Se aumenta el contador porque se encontró un valor
                $reviewCount ++;
            }
        }

        if ($count > 1) {
            $qualification_users = self::paginateCollection($qualification_users, 10, false);
        }

        $check=Auth::check();
        $housescoordinates = DB::table('houses')->select(
        'houses.id',
        'houses.name',
        'houses.address',
        'cities.name as city',
        'coordinates.lat',
        'coordinates.lng',
        DB::raw("(SELECT MIN(rooms.price) FROM rooms WHERE rooms.house_id = houses.id) as min_price")
        )
        // ->where('houses.status', '=', 1)
        ->where('houses.id', '=', $house->id)
        ->join('neighborhoods', 'neighborhoods.id', '=', 'houses.neighborhood_id')
        ->join('locations', 'locations.id', '=', 'neighborhoods.location_id')
        ->join('zones','zones.id','=','locations.zone_id')
        ->join('cities', 'cities.id', '=', 'zones.city_id')
        ->join('coordinates', 'coordinates.house_id', '=', 'houses.id')
        ->get();
        // dd($months_name);
        // check if the house is a user favorite house
        $favorite_house = false;
        if ($check) {
            $favorite = DB::table('favorites')->where('house_id','=',Auth::user()->id)->where('house_id','=',$house->id)->get();
            if(sizeof($favorite) > 0){
                $favorite_house = true;
            }
        }

        $availableCount = $house->Rooms->where('available_from', '<', Carbon::now())
        ->count();

        // dd(Auth::user()->id);
        $house->Rooms=$house->Rooms->sortByDesc('priority');

        //Get all referralcodes the ones of the user will be excluded in the js
        $referralcodes = VicoReferral::all('id','code','user_id')->toArray();
        // Get the user_id to be able to discard the ones of the own user
        if(Auth::check()){
            $user_id = Auth::user()->id;
        }else{
            $user_id = 0;
        }
        $currency = new Currency();
        $currency = $currency->getCurrentCurrency();

        $generic_interest_points = $house->genericInterestPoints;
        $specific_interest_points = $house->specificInterestPoints;

        #Get the three closest houses from the requested house
        #With available rooms
        $suggested_houses = self::getSuggestedHouses($house);

        return view('houses.show', [
            'house' => $house,
            'manager'=>$manager,
            'rules' => $rules,
            'custom_rules' => $custom_rules,
            'homemates' => $homemates,
            'availableCount' => $availableCount,
            'devices'=>$devices,
            'today' => Carbon::now(),
            'today_30' => Carbon::now()->addWeeks(4),
            'auth'=> $check,
            'neighborhood' => $neighborhood,
            'months_name' => $months_name,
            'month_homemates_correct' => $month_homemates_correct,
            'countries' => Country::all()->sortBy('name'),
            'housescoordinates' =>response()->json($housescoordinates),
            'reviews_house' => $reviews_house,
            'reviews_neighborhood' => $reviews_neighborhood,
            'reviewCount' => $reviewCount,
            'qualification_users' => $qualification_users,
            'favorite_house' => $favorite_house,
            'interestPoints' => $interestPoints,
            'schools' => $schools,
            'referralcodes' => $referralcodes,
            'user_id' => $user_id,
            'currency' => $currency,
            'city' => $city,
            'generic_interest_points' => $generic_interest_points,
            'specific_interest_points' => $specific_interest_points,
            'suggested_houses' => $suggested_houses,
        ])->with(compact('neighborhood'));
    }

    /**
    * Invoke the main functions get the three closest houses
    *
    * @param  House $house
    * @return Collection $houses
    */
    public function getSuggestedHouses(House $house){

        [$house_coordinates, $closest_houses]= self::getClosestHouses($house);

        $houses_distances = self::getHousesDistances($house_coordinates, $closest_houses);

        $wildcard_for_store_values = array();
        $minimun_values = self::findThreeClosestHouses($houses_distances,$wildcard_for_store_values);

        $houses = House::whereIn('id',$minimun_values)->get();
        
        return $houses;
    }

    /**
    * Get maximum 10 closest houses depending on latitude, available rooms 
    * and houses status from the DB
    *
    * @param  House $house
    * @return Collection $houses
    */
    public function getClosestHouses(House $house)
    {
        $now = Carbon::now()->format('Y-m-d');
        $house_coordinates = $house->Coordinates;
        $house_city = $house->Neighborhood->Location->Zone->City->name;

        $coordinates1 = Coordinate::where(function ($query) use ($house, $house_coordinates)
        {
            $query->where('house_id','!=',$house->id);
            $query->where('lat','>',$house_coordinates->lat);
        }
        )->whereHas('house.neighborhood.location.zone.city', function($query) use ($house_city)
        {
            $query->where('name',$house_city);
        }
        )->whereHas('house.rooms', function($query) use($now)
        {
            $query->whereDate('available_from','<=',$now);
        }
        )->whereHas('house', function($query) use($now)
        {
            $query->where('status',1);
        }
        )->where('lat','!=','')->orderBy('lat')->limit(5)->get()->groupBy('house_id');


        $coordinates2 = Coordinate::where(function ($query) use ($house, $house_coordinates)
        {
            $query->where('house_id','!=',$house->id);
            $query->where('lat','<',$house_coordinates->lat);
        }
        )->whereHas('house.neighborhood.location.zone.city', function($query) use ($house_city)
        {
            $query->where('name',$house_city);
        }
        )->whereHas('house.rooms', function($query) use($now)
        {
            $query->whereDate('available_from','<=',$now);
        }
        )->whereHas('house', function($query) use($now)
        {
            $query->where('status',1);
        }
        )->where('lat','!=','')->orderBy('lat')->limit(5)->get()->groupBy('house_id');

        return [$house_coordinates, $coordinates1->union($coordinates2)];

    }


    /**
    * Calculate the distance between the requested house and the closest
    * houses based on latitude and longitude, wrapped on array with 
    * key=>value format, where the key is the house id and the value is 
    * the euclidean distance 
    *
    * @param  Coordinate $house_coordinates
    * @param  Collection of Coordinates $closest_houses
    * @return Array $houses_distances
    */
    public function getHousesDistances($house_coordinates, $closest_houses)
    {
        $houses_distances = array();
        foreach ($closest_houses as $coordinate) {
            $houses_distances = $houses_distances + 
            self::eucDistance(
                [$coordinate[0]->lat,$coordinate[0]->lng],
                [$house_coordinates->lat, $house_coordinates->lng], 
                $coordinate[0]->house_id)
            ;
        }

        return $houses_distances;
    }

    /**
    * Calculate the distance between two vectors (coordinates) and
    * add the house id
    *
    * @param  Array $a
    * @param  Array $b
    * @param  int $house_id
    * @return Array
    */
    function eucDistance(array $a, array $b, $house_id) {
        return
        [$house_id => array_sum(
            array_map(
                function($x, $y) {
                    return abs($x - $y) ** 2;
                }, $a, $b
            )
        ) ** (1/2)];
    }

    /**
    * Recursive function that search the 3 closest houses 
    * based on the euclidean distance already calculated
    *
    * @param  Array $houses_distances: Array with euclidean 
    *               distance on the value and house id on the 
    *               key
    *
    * @param  Array $wildcard_for_store_values: Wildcard 
    *               array for store specific values
    * @return function findThreeClosestHouses()
    *
    * @return Array $wildcard_for_store_values: Array with 
    *                three closest houses id
    */
    public function findThreeClosestHouses($houses_distances, $wildcard_for_store_values)
    {
        if (($key = array_search(min($houses_distances), $houses_distances)) !== false) {
            array_push($wildcard_for_store_values, $key);
            unset($houses_distances[$key]);
        }

        if (sizeof($wildcard_for_store_values) < 3) {
            $wildcard_for_store_values = self::findThreeClosestHouses($houses_distances, $wildcard_for_store_values);
        }
        return $wildcard_for_store_values;
        
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  House $house
    * @return \Illuminate\Http\Response
    */
    public function edit(House $house)
    {
        $rooms = $house->Rooms;
        $availableCount = $house->Rooms->where('available_from', '<', Carbon::now())
      ->count();

        $rules = DB::table('houses_rules')
        ->select('rules.name','houses_rules.rule_id','houses_rules.description')
        ->where('house_id', '=', $house->id)
        ->join('rules', 'rules.id', '=', 'houses_rules.rule_id')->distinct()
        ->orderBy('rules.id')->get();
        $devices=DB::table('devices')->get();

        $house_devices=DB::table("device_houses")->where("device_houses.house_id", '=', $house->id)->get();

        for ($i=0; $i < count($rooms); $i++) {
            $house->Rooms[$i]->available = $rooms[$i]->available_from < Carbon::now() ? 'Disponible' : 'No disponible';
        }


        $images = DB::table('image_houses')->select('id','priority', 'house_id', 'image')->where('house_id', '=', $house->id)->get();

        if(sizeof($images) < 5){
            $non_image = ['priority'=>'100','id'=>'0','house_id'=>$house->id,'image'=>'room_4.jpeg'];
            $non_image= (object) $non_image;
            for($j=sizeof($images);$j<5;$j++){
              $images->push($non_image);
            }
        }
        foreach ($images as $image) {
            $image->priority=intval($image->priority);
        }
        $images=$images->sortBy('priority');

        $manager=DB::table('managers')->select('managers.id as id','managers.vip','users.image', 'users.name','users.description')
                    ->join('users', 'users.id', '=', 'managers.user_id')->where('managers.id', '=', $house->manager_id)->first();


        foreach ($house->Rooms as $key => $room) {
            $room->main_image = DB::table('image_rooms')->select('image','priority')->where('room_id','=',$room->id)->get();
            if (sizeof($room->main_image) < 1) {
                $non_image = ['priority'=>'100','id'=>'0','room_id'=>$room->id,'image'=>'room_4.jpeg'];
                $non_image= (object) $non_image;
                for($j=sizeof($room->main_image);$j<5;$j++){
                    $room->main_image->push($non_image);
                }
            }
            foreach ($room->main_image as $key => $image) {
                $image->priority=intval($image->priority);
            }
            $room->main_image=$room->main_image->sortBy('priority');
        }

        $homemates=DB::table('houses')->select('houses.id', 'rooms.id as room_id', 'homemates.id as id_homemate', 'homemates.name', 'homemates.profession', 'homemates.gender', 'countries.id as country')
        ->join('rooms', 'rooms.house_id', '=', 'houses.id')
        ->join('homemates', 'homemates.room_id', '=', 'rooms.id')
        ->join('countries', 'countries.id', '=', 'homemates.country_id')
        ->where('houses.id', '=', $house->id)
        ->orderBy('houses.id', 'desc')
        ->groupBy('houses.id', 'rooms.id', 'room_id', 'id_homemate', 'homemates.name', 'homemates.profession', 'homemates.gender', 'country')
        ->get();

        return view('houses.edit', [
        'house' => $house,
        'rules' => $rules,
        'images' => $images,
        // 'imagesroom' => $imagesroom,
        'homemates'=> $homemates,
        'manager'=>$manager,
        'availableCount' => $availableCount,
        'now' => Carbon::now(),
        'devices' => $devices,
        'house_devices' => $house_devices,
        'countries' => Country::all()->sortBy('name')
      ]);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  App\House $house
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request)
    {
        $houses = House::findOrFail($request->house_id);
        $houses->name = $request->name;
        $houses->type = $request->type;
        $houses->baths_quantity = $request->baths_quantity;
        $houses->address = $request->address;
        $houses->description_house = $request->description_house;
        $houses->description_zone = $request->description_zone;
        $managers=Manager::find($request->manager_id);
        $user=User::firstOrFail()->where('id', '=', $managers->user_id);

        $houses->rooms_quantity = $request->rooms_quantity;
        $current_devices=DB::table("device_houses")->where("device_houses.house_id", '=', $request->house_id)->get();

        $s3 = Storage::disk('s3');
        $user->update([
            'name' => $request->manager_name,
            'description' => $request->manager_description
            ]);
            $managers->vip =$request->manager_vip;
            $managers->save();
        /*
        $coordinate = Coordinate::firstOrNew(['house_id' => $request->house_id],[
            'lat' => $request->lat,
            'lng' => $request->lng
            ]);
            */
        DB::table('coordinates')->where('house_id', '=', $request->house_id)->update([
            'lat' => $request->lat,
            'lng' => $request->lng
            ]);
            if (isset($request->devices)) {
                for ($i=0;$i<count($request->devices);$i++) {
                    $flag=false;
                for ($j=0;$j<count($current_devices);$j++) {
                    if ($request->devices[$i]==$current_devices[$j]->device_id) {
                        $flag=true;
                        break;
                    }
                }
                if (!$flag) {
                    $new_device= new DeviceHouse();
                    $new_device->house_id=$request->house_id;
                    $new_device->device_id=$request->devices[$i];
                    $new_device->save();
                }
            }
            for ($i=0;$i<count($current_devices);$i++) {
                $flag=false;
                for ($j=0;$j<count($request->devices);$j++) {
                    if ($request->devices[$j]==$current_devices[$i]->device_id) {
                        $flag=true;
                        break;
                    }
                }
                if (!$flag) {
                    $old_device=DeviceHouse::firstOrFail()->where('house_id', '=', $request->house_id)->where('device_id', '=', $current_devices[$i]->device_id);
                    $old_device->delete();
                }
            }
        }
        if(isset($request->id_homemate))
        {
            // PROBLEMA CON EL ID DEL HOMEMATE, EL CODIGO ESTA BIEN PERO EL ID QUE LLEGA DEL REQUEST ES ERRONEO
            // for ($i=0; $i < sizeOf($request->id_homemate); $i++) {
                //     $room_homemate=DB::table('rooms')->where('number', '=', $request->room_id_homemate[$i])->where('house_id', '=', $houses->id)->get();
            //     $homemate = Homemate::find($request->id_homemate[$i]);
            //     $homemate->name = $request->nombre_homemate[$i];
            //     $homemate->profession = $request->profession_homemate[$i];
            //     $homemate->gender = $request->gender_homemate[$i];
            //     $homemate->country_id = $request->country_id_homemate[$i];
            //     $homemate->room_id = $room_homemate[0]->id;
            //     $homemate->save();
            // }
        }
        $countrules=DB::table('rules')->get();
        if (isset($request->rules))
        {
            for ($i=0; $i < count($request->rules); $i++) {
                $Rule1 = HousesRule::where('house_id', '=', $request->house_id)->where('rule_id', '=', $i + 1)->update(['description' => $request->rules[$i]]);
            }
        }
        // dd($request);
        if (isset($request->delete_room))
        {
            for ($i=0; $i < count($request->delete_room) -1 ; $i++) {
                $rooms = DB::table('rooms')->where('id', '=', $request->delete_room[$i])->get();
                $device_room = DB::table('devices_rooms')->where('room_id', '=', $rooms[$i]->id)->delete();
                $image_room = DB::table('image_rooms')->where('room_id', '=', $rooms[$i]->id)->delete();
                DB::table('rooms')->where('id', '=', $request->delete_room[$i])->delete();
            }
        }
        if (isset($request->delete_homemate))
        {
            for ($i=0; $i < count($request->delete_homemate); $i++) {
                DB::table('homemates')->where('id', '=', $request->delete_homemate[$i])->delete();
            }
        }
        if(isset($request->delete_houseimage))
        {
            for ($i=0; $i < count($request->delete_houseimage); $i++) {
                DB::table('image_houses')->where('id', '=', $request->delete_houseimage[$i])->delete();
            }
        }

        for ($i=0; $i < count($request->image_img); $i++) {
            DB::table('image_houses')
            ->where('image', $request->image_img[$i])
            ->update(['priority' => $request->priority_pic[$i]]);
        }

        if (isset($request->manager_image)) {
            $manager_image = $request->file('manager_image')[0];
            $time = Carbon::now();
            $time=$time->year.$time->month.$time->day.$time->hour.$time->minute.$time->second;
            $s3->put('manager_'.$request->house_id.'_'.$time.'.'.$manager_image->extension(), file_get_contents($manager_image), 'public');
            $user->update([
                'image' => 'manager_'.$request->house_id.'_'.$time.'.'.$manager_image->extension()
                ]);
            }
            $count_imageHouse = ImageHouse::where('house_id', '=', $request->house_id)->count() - 1;

            if (isset($request->second_image)) {
                foreach($request->file('second_image') as $image) {
                    $time = Carbon::now();
                $time=$time->year.$time->month.$time->day.$time->hour.$time->minute.$time->second;
                $second_images = $image;
                $s3->put('house_'.$request->house_id."_".$count_imageHouse."_".$time.".".$second_images->extension(), file_get_contents($second_images), 'public');


                $image_house = new ImageHouse();
                $image_house->house_id = $request->house_id;
                $image_house->image = 'house_'.$request->house_id."_".$count_imageHouse."_".$time.".".$second_images->extension();
                $image_house->priority=$count_imageHouse;
                $image_house->description="";
                $count_imageHouse++;
                $image_house->save();
            }
        }
        $s3 = Storage::disk('s3');

        if ($request->main_image!=null) {
            DB::table('image_houses')
            ->where('image', $request->current_image)
            ->update(['priority' => 1]);
            $time = Carbon::now();
            $time=$time->year.$time->month.$time->day.$time->hour.$time->minute.$time->second;
            $newm_image = $request->file('main_image')[0];
            $s3->put('house_'.$request->house_id."_".$count_imageHouse."_".$time.".".$newm_image->extension(), file_get_contents($newm_image), 'public');

            $img=new ImageHouse();
            $img->house_id=$request->house_id;
            $img->image = 'house_'.$request->house_id."_".$count_imageHouse."_".$time.".".$newm_image->extension();
            $img->priority=0;
            $img->description="";
            $img->save();
        }
        /*
        Falta: main_image, manager_image, house_images        */
        $houses->save();

        return back();
    }
    public function getRoomAvailability($rooms)
    {
        $now=Carbon::now();
        $months=[
        '1' => 'ENE',
        '2' => 'FEB',
        '3' => 'MAR',
        '4' => 'ABR',
        '5' => 'MAY',
        '6' => 'JUN',
        '7' => 'JUL',
        '8' => 'AGO',
        '9' => 'SEP',
        '10' => 'OCT',
        '11' => 'NOV',
        '12' => 'DIC',
        ];
        $months_to_show=[];
        for ($i = $now->month;$i<($now->month+8);$i++) {
            if ($i>12) {
                $month_obj_1=['idx' => $i-12,'month' => $months[$i-12],'bussy' => false,'last' => false,'day' => 1];
                $month_obj_2=['idx' => $i-12,'month' => $months[$i-12],'bussy' => false,'last' => false,'day' => 15];
            } else {
                $month_obj_1=['idx' => $i,'month' => $months[$i],'bussy' => false,'last' => false,'day' => 1];
                $month_obj_2=['idx' => $i,'month' => $months[$i],'bussy' => false,'last' => false,'day' => 15];
            }
            $month_obj_1= (object) $month_obj_1;
            $month_obj_2= (object) $month_obj_2;
            if ($i==($now->month+7)) {
                $month_obj_1->last= true;
                $month_obj_2->last= true;
            }
            array_push($months_to_show, $month_obj_1);
            array_push($months_to_show, $month_obj_2);
        }
        $months_to_show=collect($months_to_show);
        foreach ($rooms as $room) {
            $bookings=DB::table('bookings')->select('id', 'date_from', 'date_to', 'status')->where('room_id', '=', $room->id)->where(function ($q) {
                $q->where('status', '=',5)->orWhere('status','=', 100);
            })->orderBy('date_from', 'asc')->get();
            foreach ($bookings as $booking) {
                $date_from=Carbon::parse($booking->date_from);
                $date_to=Carbon::parse($booking->date_to);
                if ($date_to->year == 9999) {
                    foreach ($months_to_show as $month) {
                        $month->bussy=true;
                    }
                } else {
                    if (($date_to->year - $now->year == 0 && $date_to->month - $now->month >= 0) || ($date_to->year - $now->year == 1)) {
                        if ($date_from->year == $now->year) {
                            while ($date_from->month < $now->month) {
                                $date_from->addMonth(1);
                            }
                        }
                        for ($i=0; $i < 8; $i++) {
                            $month_tmp=$months_to_show->where('idx', '=', ($date_from->month));
                            if (sizeof($month_tmp)>0) {
                                if ($date_from->day >= 1 && $date_from->day <= 15) {
                                    $months_to_show->where('idx', '=', ($date_from->month))->where('day', '=', 1)->first()->bussy=true;
                                } else {
                                    $months_to_show->where('idx', '=', ($date_from->month))->where('day', '=', 15)->first()->bussy=true;
                                }
                            }
                            if ($date_from->month == $date_to->month && $date_from->year == $date_to->year) {
                                break;
                            }
                            $date_from->addDays(15);
                        }
                    }
                }
            }
            $room->info_dates=view('rooms.disavailable_dates', [
        'id' => $room->id,
        'months' =>  $months_to_show
      ])->render();
            foreach ($months_to_show as $month) {
                $month->bussy=false;
            }
        }
        return $rooms;
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  App\House $house
    * @return \Illuminate\Http\Response
    */
    public function destroy(Request $house)
    {
        return findOrDie($house->id)->destroy();
    }

    /**
    *
    * Generate a view with the all houses in the a neighborhood or near to 1 university
    *
    * @param $string: neighborhood's name or university's name
    * @return View with the houses to  sort $string
    */
    public function All(String $string)
    {
        $string=str_replace("x", " ", $string);
        $inputs=[];
        $inputs['alld']=$string;
        $query=self::getQuery($inputs);
        unset($query->wheres[0]);
        [$houses,$housescoordinates] = self::getHouses($query);
        return view('houses.index', [
      'houses' => $houses,
      'schools' => School::all()->sortBy('name'),
      'neighborhoods' => Neighborhood::all()->sortBy('name'),
      'today' => Carbon::now(),
      'today_30' => Carbon::now()->addWeeks(4)
        ]);
    }

    /**
    *
    * Generate a json with the rooms of the specific house
    *
    * @param $house: var that specific the current house, id
    * @return json with the rooms
    */
    public function housedata(House $house, $id)
    {
        $rooms = $house->Rooms;
        foreach ($rooms as $room) {
            $room->choose=false;
            $booking=DB::table("bookings")->where("id", "=", $id)->get()->first();
            if (!$booking===null && $room->id === $booking->room_id) {
                $room->choose=true;
            } else {
                $room->choose=false;
            }
        }
    }


    // A partir de aquí son métodos para probar el nuevo create
    /**
       * Show the form for creating a new resource.
       *
       * @return \Illuminate\Http\Response
       */
    public function createNew()
    {
        $managers = DB::table('users')
            ->where('role_id', '=', '2')
            ->join('managers', 'managers.user_id', '=', 'users.id')
            ->get()
            ->sortBy('name');
        $neighborhoods = Neighborhood::all()->sortBy('name');
        $rules = Rule::all();
        $devices = Device::all();
        $schools = School::all()->sortBy('name');
        $today = Carbon::now();
        $today_30 = Carbon::now()->addWeeks(4);
        $countries = Country::all()->sortBy('name');
        $interestPoints = InterestPoint::all()->sortBy('name');

        return view(
            'houses.create_julian',
            [
                'neighborhoods'  => $neighborhoods,
                'managers'  => $managers,
                'rules'  => $rules,
                'devices'   => $devices,
                'schools'   => $schools,
                'today'     => $today,
                'today_30'  => $today_30,
                'countries'     => $countries,
                'interestPoints'     => $interestPoints,
            ]
        );
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeNew(Request $request)
    {
        if (!isset($request->manager_id)) {
            $manager=Manager::where('user_id', '=', Auth::id())->firstOrFail();
        } else {
            $manager=Manager::where('id', '=', $request->manager_id)->firstOrFail();
        }
        //temp callback
        // if(!isset($request->type)){
        //   $request->type="casa";
        // }

        $request->validate([
            'name' => 'required|max:128',
            'address' => 'required|max:128',
            'description_house' => 'required|max:766',
            'description_zone' => 'required|max:766',
            //'manager_id' => 'required',
            'neighborhood' => 'required',
            //'second_image' => 'required',
            'rooms' => 'required',
            'baths' => 'required',
            'type' => 'required'
        ]);
        try {
            // dd($request);
            DB::beginTransaction();
            $house = new House();
            $house->name = $request->name;
            $house->address = $request->newAddress;
            $house->description_house = $request->description_house;
            $house->description_zone = $request->description_zone;
            $house->manager_id = $manager->id;
            $house->neighborhood_id = $request->neighborhood;
            $house->rooms_quantity = $request->rooms;
            $house->baths_quantity = $request->baths;
            $house->type = $request->type;
            $house->video='';
            $house->status='5';
            $house->save();
            $coordinate = new Coordinate();
            $coordinate->house_id = $house->id;
            $coordinate->lat = $request->lat;
            $coordinate->lng = $request->lng;
            $coordinate->save();
            for ($i=0; $i < 5 ; $i++) {
                $image_house = new ImageHouse();
                $image_house->house_id = $house->id;
                $image_house->image = 'room_4.jpeg'; // se debe usar una foto que no se vaya a cambiar
                $image_house->priority='1';
                $image_house->description="";
                $image_house->save();
            }
            $s3 = Storage::disk('s3');

            if(isset($request->customRule)){
                foreach ($request->customRule as $custom)
                {
                    $custom_rule = new CustomRule();
                    $custom_rule->description = $custom;
                    $custom_rule->house_id = $house->id;
                    $custom_rule->save();
                }
            }

            $rules = Rule::all();
            $housesRules = array();
            foreach($rules as $rule) {
                $houseRule = new HousesRule;
                $houseRule->house_id = $house->id;
                $houseRule->rule_id = $rule->id;
                $houseRule->description = '';
                $houseRule->save();

                array_push($housesRules, $houseRule);
            }
            foreach ($request->all() as $key => $value) {
                if (starts_with($key, 'device_')) {
                    $id = str_replace_first('device_', '', $key);
                    $device_house = new DeviceHouse();
                    $device_house->house_id = $house->id;
                    $device_house->device_id = $id;
                    $device_house->save();
                }
                if (starts_with($key, 'rule_')) {
                    $id = str_replace_first('rule_', '', $key);

                    $rule_house = $housesRules[$id-1];
                    $rule_house->description = ($value === 'on')? 1:$value;
                    $rule_house->save();
                }
            }
            if (($genericInterestPoints = $request->input('genericInterestPoints')) !== null ) {
                foreach ($genericInterestPoints as $key => $value) {
                    $genericInterestPoint = GenericInterestPoint::where('name', $key)->where('description', $value)->get();
                    $house->genericInterestPoints()->attach($genericInterestPoint);
                }
            }
            if (($specificInterestPoints = $request->input('specificInterestPoints')) !== null ) {
                foreach ($specificInterestPoints as $key => $value) {
                    $specificInterestPoint = SpecificInterestPoint::where('name', $key)->where('description', $value)->get();
                    $house->specificInterestPoints()->attach($specificInterestPoint);
                }
            }

            if(isset($request->close_to)){
                $university = $request->close_to;
                $university_explode = explode(' ', $university, 2);
                $university_new = $university_explode[1];
                $closeTo=School::where('name','=',$university_new)->firstOrFail();
                if(DB::table('neighborhood_schools')->where('neighborhood_id', '=',$request->neighborhood)->where('school_id', '=',$closeTo->id)->doesntExist()){
                        DB::table('neighborhood_schools')->insert([
                            'neighborhood_id' => $request->neighborhood,
                            'school_id' => $closeTo->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                    ]);
                }
            }
            DB::commit();

        } catch (\PDOException $e) {
            DB::rollBack();
            return $e;
        }
        /*return view('houses.index', [
            'houses' => House::all(),
            'schools' => School::all(),
            'neighborhoods' => Neighborhood::all()->sortBy('name'),
            'today' => Carbon::now(),
            'today_30' => Carbon::now()->addWeeks(4)
        ])*/
        try{
            $data = [
                'email' => 'friendsofmedellin@gmail.com',
                'subject' => '¡Nueva casa! - '.$house->name.' (ID:'.$house->id.')',
                'bodyMessage' => $house,
            ];

            Mail::send('houses.house_alert', $data, function ($message) use ($data) {
                $message->from('friendsofmedellin@gmail.com', 'Friends of Medellín');
                $message->to('friendsofmedellin@gmail.com');
                $message->subject($data['subject']);

            });
        }
        catch(Exception $e){
        }
        finally{
            return redirect('rooms/createNew/'.$house->id);
        }

    }

    /**
    *
    *
    **/
    public function init($flag)
    {
        if($flag == '1'){
            return view('houses.introduction');
        }
    }

    public function initPreCreate(){
        return view('houses.preCreate');
    }
    /**
    *
    *
    **/
    public function finish($house)
    {
        $house = House::find($house);
        $manager = $house->Manager->User;
        $manager->notify(new RegisteredVico($manager, $house));
        $admin = User::find(1);
        $admin->notify(new RegisteredVicoNotifier($admin, $manager));

        // SEGMENT TRACKING INIT-------------------
        if (env('APP_ENV')=='production' && Auth::user()->role_id!=1){
            Analytics::houseUploaded($manager, $house);
        }
        // SEGMENT TRACKING END-------------------

        return view('houses.finalization');
    //     return view('houses.finalization', [
    //     'house_id' => $id
    //   ]);
    }

    /**
    * Function that displays the view and all the necesary data to update the
    * map of the selected vico
    * @return \Iluminate\Http\Response
    **/
    public function getMapStep($house_id)
    {
        $countries = Country::with(['cities'=>function ($query){
            $query->where('available',1);
        }])->whereHas('cities',function($query){
            $query->where('available',1);
        })->orderBy('name', 'asc')->get();

        // $neighborhoods = Neighborhood::whereHas('location.zone.city',function($query){
        //     $query->where('available',1);
        // })->orderBy('name', 'asc')->get();

        //First we need to return all the Manager's VICOs. (not done)
        return view('houses.preCreate', [
          'house' => House::where('id', '=', $house_id)->first(),
        //   'neighborhoods' => $neighborhoods,
          'countries' => $countries,
      ]);
    }

    /**
    * this stores the house map cordinates.
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    **/
    public function postMapStep(Request $request)
    {
        $this->validate($request, [
          'lat' => 'required|max:128',
          'lng' => 'required|max:128',
          'house_id' => 'required|max:766',
          'address' => 'required|max:766',
          'aditionalAddress' => 'required|max:766',
          'neighborhood' => 'required|max:766',
      ]);  //Validate all data entry is ok (check this validation process)

        try {
            DB::beginTransaction();

            $coordinate = new Coordinate;
            $coordinate->house_id = $request->house_id;
            $coordinate->lat = $request->lat;
            $coordinate->lng = $request->lng;
            $coordinate->save();


            $house = House::where('id', '=', $request->house_id)->get();
            $house->address = $request->address.$request->aditionalAddress;
            $house->neighborhood_id = $request->neighborhood_id;


            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            return $e;
        }

        return redirect('rooms/createNew/'.$request->house_id);
    }


    /**
    * Send a email to a specific user with the house allowed changes
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    **/
    public function editMailRequest(Request $request)
    {
        try {
            \Mail::to('hello@getvico.com')->send(new ChangePetition($request)); //Trigger the email action

            return 1;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function updateStatusHouse(Request $request){
        $house=House::where('id','=',$request->house_id)->first();
        $house->update([
            'status' => $request->new_status
        ]);
        $manager = $house->Manager;
        $manager = $manager->User;
        if ($request->new_status == 1) {
            $manager->notify(new PostedVico($manager, $house));
        } else if($request->new_status == 5){
            // $manager->notify(new UnPostedVico($manager, $house));
        }
        return back();
    }

}
