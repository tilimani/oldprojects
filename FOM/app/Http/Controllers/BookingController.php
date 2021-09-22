<?php

namespace App\Http\Controllers;

use Mail;
use App\Room;
use App\Rule;
use App\User;
use App\House;
use App\Device;
use App\School;
use App\Booking;
use App\Country;
use App\Manager;
use App\Message;
use App\Currency;
use App\RateVico;
use App\ImageRoom;
use Carbon\Carbon;
use App\Coordinate;
use App\HousesRule;
use App\ImageHouse;
use App\DeviceHouse;
use App\AverageRooms;
use App\Neighborhood;
use App\Verification;
use App\AverageHouses;
use App\Mail\UserDenied;
use App\QualificationRoom;
use App\QualificationUser;
use App\QualificationHouse;
use Illuminate\Support\Arr;
use App\AverageNeighborhood;
use Illuminate\Http\Request;
use App\QualificationManager;
use App\Events\BookingWasChanged;
use App\Notifications\NewRequest;
use App\Notifications\ReviewDone;
use App\QualificationNeighborhood;
use Illuminate\Support\Facades\DB;
use App\Events\BookingWasSuccessful;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Notifications\BookingUpdateUser;
use Illuminate\Support\Facades\Validator;
use App\Notifications\BookingNotification;
use App\Notifications\BookingUpdateManager;
use App\Notifications\cancelBookingPetition;
use App\Notifications\BookingUpdateUserManager;
use App\Http\Controllers\SegmentController as Analytics;
use App\UserRatings;

class BookingController extends Controller{

    protected $STATUS= [
            '-73' => 'calificado terminacion extraordinaria',
            '-72' => 'calificado por propietario terminacion extraordinaria',
            '-71' => 'calificado por estudiante terminacion extraordinaria',
            '-70' => 'calificado terminacion extraordinaria',
            '-6' => 'espera calificacion terminacion extraordinaria',
            '-50' => 'screenshot denegado',
            '-5' => 'estudiante no llega',
            '-4' => 'estudiante no paga',
            '-3' => 'Cancelado por inactividad',
            '-23' => 'Sujerencia Rechazada por estudiante',
            '-22' => 'perfil no apto',
            '-21' => 'no disponible',
            '-11' => 'propietario no contesta',
            '-2' => 'cancelado por propietario',
            '-1' => 'cancelado por usuario',
            '0' => 'manual',
            '1' => 'espera de aceptacion',
            '2' => 'espera de confirmacion estudiante',
            '3' => 'espera de reserva dueño',
            '4' => 'espera de pago al propietario',
            '50' => 'espera confirmacion de screenshot',
            '5' => 'estudiante en vico',
            '6' => 'espera a calificacion',
            '70' => 'calificado',
            '71' => 'calificado por estudiante',
            '72' => 'calificado por propietario',
            '73' => 'No calificado',
            '8' => 'problema estudiante',
            '9' => 'problema propietario',
            '100' => 'usuario FAKE no FOM'
        ];

    protected $ROOM_ID_CURRENT = 0; //Constant used in suggestions

    /**
    * Set a log o changes in bookings
    * @param array with booking id and status of change $data[$status,$id];
    * @author Cristian
    */
    protected function statusUpdate($data)
    {
        // DB::table('status_update')->insert(['date' => Carbon::now(),
        //                                     'status' => $data['status'],
        //                                     'booking_id' => $data['id'],
        //                                     'created_at' => Carbon::now()
        //                                 ]);
    }

    /**
    * send a mail when a booking was deni
    * @param Booking
    * @author Cristian
    **/
    protected function SendSuggestions ($booking)
    {
        $this->ROOM_ID_CURRENT = $booking->room_id;
        $result =  self::getSuggestions($booking);
        $user = User::find($booking->user_id);
        $room = Room::find($booking->room_id);
        $house = House::find($room->house_id);

        //encrypted manager id for unsubscribe feature
        $encrypted = Crypt::encryptString($user->id);
        // dd($result);

        //here it will be send a mail to the student
        $data = [
            'suggestions' => $result['suggestions'], //3 rooms suggestions to student
            'count_rooms' => $result['count_rooms'], //how many rooms are avaliable in right there house
            'user' => $user,
            'house' => $house,
            'room' => $room,
            'booking' => $booking,
            'subject' => $house->name.' - Hab.'.$room->number,
            'encrypted' => $encrypted,
        ];
        $verification = Verification::firstOrCreate(['user_id' => $user->id]);
        if ($verification->canISendMail())
        {
            Mail::to($user->email)->send(new UserDenied($data));
        }
    }

    /**
    * send a mail when a booking was deni
    * @param Booking
    * @author Cristian
    **/
    public static function SendSuggestionsPublic ($booking)
    {
        $bookingController = new BookingController;
        $bookingController->ROOM_ID_CURRENT = $booking->room_id;
        $result =  $bookingController->getSuggestions($booking);
        $user = User::find($booking->user_id);
        $room = Room::find($booking->room_id);
        $house = House::find($room->house_id);

        //encrypted manager id for unsubscribe feature
        $encrypted = Crypt::encryptString($user->id);
        // dd($result);

        //here it will be send a mail to the student
        $data = [
            'suggestions' => $result['suggestions'], //3 rooms suggestions to student
            'count_rooms' => $result['count_rooms'], //how many rooms are avaliable in right there house
            'user' => $user,
            'house' => $house,
            'room' => $room,
            'booking' => $booking,
            'subject' => $house->name.' - Hab.'.$room->number,
            'encrypted' => $encrypted,
        ];
        $verification = Verification::firstOrCreate(['user_id' => $user->id]);
        if ($verification->canISendMail())
        {
            Mail::to($user->email)->send(new UserDenied($data));
        }
    }

    /**
    * builder of query to suggestions in function denied
    * @return builder with generals params of queries
    * @author Cristian
    */
    protected function querySuggestions()
    {
        $query = DB::table('rooms')->select('rooms.id','rooms.number','rooms.price','houses.name','houses.id as house_id','houses.description_house','houses.description_zone','neighborhoods.name as neighborhood');
        $query->join('houses','houses.id','=','rooms.house_id');
        $query->where('houses.status','=',1);
        $query->WhereNotIn('rooms.id',[$this->ROOM_ID_CURRENT]);
        $query->join('neighborhoods','neighborhoods.id','=','houses.neighborhood_id');
        return $query;
    }
    //this is the contructor of class
    public function __construct()
    {
        $this->middleware('manager_booking', ['only' => ['show']]); //config the middleware
        $this->middleware('manager_bookingPost', ['only' => ['denied','accepted','reserved']]); //config the middleware
        $this->middleware('user_booking', ['only' => ['userView']]); //config the middleware
        $this->middleware('user_bookingPost', ['only' => ['cancel','timeRequest']]); //config the middleware
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookings=DB::table('bookings')->select('bookings.id','bookings.created_at','houses.id as house_id','houses.name as house_name','rooms.number','rooms.price','bookings.status','bookings.date_from','bookings.date_to','users.name','users.last_name','bookings.mode','bookings.message','bookings.note','managers.id as manager_id','users.id as user_id')
            ->join('users','users.id','=','bookings.user_id')
            ->join('rooms','rooms.id','=','bookings.room_id')
            ->join('houses', 'houses.id','=','rooms.house_id')
            ->join('managers','managers.id', '=', 'houses.manager_id')
            ->latest()
            ->paginate(10);

        foreach ($bookings as $booking)
        {
            $booking->manager_info = DB::table('managers')
                                    ->select('users.name', 'users.phone')
                                    ->join('users','users.id','=','managers.user_id')
                                    ->where('managers.id','=',$booking->manager_id)
                                    ->get()->first();
            $booking->rooms_data=DB::table('rooms')->select('id','number')->where('house_id','=',$booking->house_id)->get();

        }
        // dd($status);
        //dd($bookings);

        return view('bookings.index',[
            'bookings' => $bookings,
            'houses' => House::all(),
            'status' => $this->STATUS
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexConfirmedBookings()
    {
        $bookings=DB::table('bookings')->select('bookings.id','bookings.created_at','houses.id as house_id','houses.name as house_name','rooms.number','rooms.price','bookings.status','bookings.date_from','bookings.date_to','users.name','users.last_name','bookings.mode','bookings.message','bookings.note','managers.id as manager_id','users.id as user_id')
            ->join('users','users.id','=','bookings.user_id')
            ->join('rooms','rooms.id','=','bookings.room_id')
            ->join('houses', 'houses.id','=','rooms.house_id')
            ->join('managers','managers.id', '=', 'houses.manager_id')
            ->where('bookings.status','=','5')
            ->orderBy('bookings.date_from')
            ->latest()
            ->paginate(10);

        foreach ($bookings as $booking)
        {
            $booking->manager_info = DB::table('managers')
                                    ->select('users.name', 'users.phone')
                                    ->join('users','users.id','=','managers.user_id')
                                    ->where('managers.id','=',$booking->manager_id)
                                    ->get()->first();
            $booking->rooms_data=DB::table('rooms')->select('id','number')->where('house_id','=',$booking->house_id)->get();

        }
        // dd($status);
        //dd($bookings);

        return view('bookings.index',[
            'bookings' => $bookings,
            'houses' => House::all(),
            'status' => $this->STATUS
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchBooking(Request $request)
    {
        $qName = $request->name;
        // $users = Booking::where('id','LIKE','%'.$qName.'%')->orWhere($booking->user()->name,'LIKE','%'.$qName.'%')->orderBy('created_at', 'desc')->paginate(10);
        $bookings=DB::table('bookings')->select('bookings.id','bookings.created_at','houses.id as house_id','houses.name as house_name','rooms.number','rooms.price','bookings.status','bookings.date_from','bookings.date_to','users.name','users.last_name','bookings.mode','bookings.message','bookings.note','managers.id as manager_id','users.id as user_id')
            ->join('users','users.id','=','bookings.user_id')
            ->join('rooms','rooms.id','=','bookings.room_id')
            ->join('houses', 'houses.id','=','rooms.house_id')
            ->join('managers','managers.id', '=', 'houses.manager_id')
            ->where('bookings.id','LIKE','%'.$qName.'%')
            ->orWhere('users.name','LIKE','%'.$qName.'%')
            ->latest()
            ->paginate(10);

        // $bookings = Booking::where('id','LIKE','%'.$qName.'%')->orderBy('created_at', 'desc')->paginate(10);

        foreach ($bookings as $booking)
        {
            $booking->manager_info = DB::table('managers')
                                    ->select('users.name', 'users.phone')
                                    ->join('users','users.id','=','managers.user_id')
                                    ->where('managers.id','=',$booking->manager_id)
                                    ->get()->first();
            $booking->rooms_data=DB::table('rooms')->select('id','number')->where('house_id','=',$booking->house_id)->get();

        }
        // dd($bookings);


        return view('bookings.index',[
            'bookings' => $bookings,
            'houses' => House::all(),
            'status' => $this->STATUS
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminIndex($id)

    //New function made by Gabriel Alfonso
    {
        // $vicos = House::where('manager_id', Auth::user()->id)->get();
        // $manager =  Manager::where('manager_id', Auth::user()->id)->get();
        // $vicos = House::where('manager_id', 1)->get();

        //this functionallity is used to get the id based on manager table
        //@author Andres Felipe Cano
        $user = Auth::user();
        if ($id != 1 && $user->role_id === 1) {
                $managers = Manager::where('user_id', $id)->select('id')->get();
                    $vicos = [];
                    foreach($managers as $manager){
                        $managerVicos = House::where('manager_id', $manager->id)->get();
                        foreach($managerVicos as $vico){
                            array_push($vicos, $vico);
                        }
                    }
        } else {
            if($user->role_id === 1){
                $vicos = House::all();
            } else {
                if ($user->role_id === 2){
                    $managers = Manager::where('user_id', $user->id)->select('id')->get();
                    $vicos = [];
                    foreach($managers as $manager){
                        $managerVicos = House::where('manager_id', $manager->id)->get();
                        foreach($managerVicos as $vico){
                            array_push($vicos, $vico);
                        }
                    }
                } else {
                    if ($user->role_id === 3){
                        return redirect()->route('bookings_user');
                    }
                }
            }
        }


        $rooms1 = [];
        $rooms2 = [];
        $rooms3 = [];
        $rooms4 = [];
        $sum1 = 0;
        $sum2 = 0;
        $sum3 = 0;
        $sum4 = 0;
        $today = "2018-11-26 12:00:00";

        foreach ($vicos as $vico) {

            foreach ($vico->rooms as $room) {

                $bookings = $room->bookings->where('created_at', '>', $today);
                // $bookings1 = $bookings->whereIn('status', [1, 3])->sortBy('date_from');
                // $bookings2 = $bookings->whereIn('status', [2, 4])->sortBy('date_from');
                // $bookings3 = $bookings->whereIn('status', [50, 5])->sortBy('date_from');
                $bookings1 = $bookings->whereIn('status', [1, 3, 4])->sortBy('created_at');
                $bookings2 = $bookings->whereIn('status', [2, 4])->sortBy('created_at');
                $bookings3 = $bookings->whereIn('status', [50, 5])->sortBy('created_at');
                $bookings4 = $bookings->whereIn('status', [6,70,71,72])->sortBy('created_at');

                if($bookings1->count() > 0) {

                    $iRoom1 = $room;
                    $iRoom1->bookings1 = $bookings1;
                    $iRoom1->vico = $vico;
                    $iRoom1->booking_sort = $bookings1->first()->date_from; //define earliest booking
                    $sum1 += count($iRoom1->bookings1);
                    array_push($rooms1, $iRoom1);

                }

                if($bookings2->count() > 0) {

                    $iRoom2 = $room;
                    $iRoom2->bookings2 = $bookings2;
                    $iRoom2->vico = $vico;
                    $sum2 += count($iRoom2->bookings2);
                    $iRoom2->booking_sort = $bookings2->first()->date_from; //define earliest booking
                    array_push($rooms2, $iRoom2);

                }

                if($bookings3->count() > 0) {

                    $iRoom3 = $room;
                    $iRoom3->bookings3 = $bookings3;
                    $iRoom3->vico = $vico;
                    $iRoom3->booking_sort = $bookings3->first()->date_from; //define earliest booking
                    $sum3 += count($iRoom3->bookings3);
                    array_push($rooms3, $iRoom3);

                }

                if($bookings4->count() > 0) {

                    $iRoom4 = $room;
                    $iRoom4->bookings4 = $bookings4;
                    $iRoom4->vico = $vico;
                    $iRoom4->booking_sort = $bookings4->first()->date_from; //define earliest booking
                    $sum4 += count($iRoom4->bookings4);
                    array_push($rooms4, $iRoom4);

                }

            }

        }

        //Sort rooms by their earliest booking
        $rooms1 = Arr::sort($rooms1, function($room)
        {
            return $room->booking_sort;
        });

        $rooms2 = Arr::sort($rooms2, function($room)
        {
            return $room->booking_sort;
        });

        $rooms3 = Arr::sort($rooms3, function($room)
        {
            return $room->booking_sort;
        });

        $rooms4 = Arr::sort($rooms4, function($room)
        {
            return $room->booking_sort;
        });

        // dd($rooms3,$bookings3);
        return view('bookings.admin', [
            'rooms1' => $rooms1,
            'rooms2' => $rooms2,
            'rooms3' => $rooms3,
            'rooms4' => $rooms4,
            'sum1' => $sum1,
            'sum2' => $sum2,
            'sum3' => $sum3,
            'sum4' => $sum4,
            'users' => User::all()
        ]);
    }


    /**
    * Display user's bookings in a view
    * @author Cristian
    **/
    public function userIndex ()
    {
        $user = Auth::user();

        if ($user) {
            $bookings = DB::table('bookings')->select('bookings.id','houses.id as house_id','houses.name as house_name','rooms.number','rooms.price','rooms.nickname','bookings.status','bookings.date_from','bookings.date_to','bookings.created_at','users.name','bookings.message','bookings.note','users.id as user_id')
            ->where('bookings.status', '>', '0')
            ->where('bookings.user_id','=', $user->id)
            ->join('users','users.id','=','bookings.user_id')
            ->join('rooms','rooms.id','=','bookings.room_id')
            ->join('houses', 'houses.id','=','rooms.house_id')
            ->join('managers','managers.id', '=', 'houses.manager_id')
            // ->latest()
            ->paginate(15);

            foreach ($bookings as $booking)
            {
                $im = DB::table('image_houses')->select('image')
                            ->where('house_id','=',$booking->house_id)
                            ->orderBy('priority')
                            ->first();
                if ($im == null) {
                    $non_image = ['priority'=>'100','id'=>'0', 'image'=>'room_4.jpeg'];
                    $non_image= (object) $non_image;
                    $im=$non_image;
                }

                $query = DB::table('status_update as su')->select('su.date')
                                    ->where('su.booking_id','=',$booking->id)
                                    ->latest()
                                    ->first();

                $booking->image = $im->image;
                $booking->update = (isset($query->date)) ? $query->date : $booking->created_at;
            }
            // dd($bookings);
            return view('bookings.adminuser',[
                'bookings' => $bookings
            ]);
        } else {
            return view('auth.login',[
                'url'=>'/booking/user'
            ]);
        }
    }

    /**
    * Display user's bookings in a view
    * @author Cristian
    **/
    public function userIndexMyStays ()
    {
        if(Auth::user()){
            $bookings = DB::table('bookings')->select('bookings.id','houses.id as house_id','houses.name as house_name','rooms.number','rooms.price','rooms.nickname','bookings.status','bookings.date_from','bookings.date_to','bookings.created_at','users.name','bookings.message','bookings.note','users.id as user_id')
                ->where('bookings.status', '=', '5')
                ->where('bookings.user_id','=', Auth::user()->id)
                ->join('users','users.id','=','bookings.user_id')
                ->join('rooms','rooms.id','=','bookings.room_id')
                ->join('houses', 'houses.id','=','rooms.house_id')
                ->join('managers','managers.id', '=', 'houses.manager_id')
                // ->latest()
                ->paginate(15);

                foreach ($bookings as $booking)
                {
                    $im = DB::table('image_houses')->select('image')
                                  ->where('house_id','=',$booking->house_id)
                                  ->orderBy('priority')
                                  ->first();
                    if ($im == null) {
                        $non_image = ['priority'=>'100','id'=>'0', 'image'=>'room_4.jpeg'];
                        $non_image= (object) $non_image;
                        $im=$non_image;
                    }

                    $query = DB::table('status_update as su')->select('su.date')
                                           ->where('su.booking_id','=',$booking->id)
                                           ->latest()
                                           ->first();

                    $booking->image = $im->image;
                    $booking->update = (isset($query->date)) ? $query->date : $booking->created_at;
                }
                // dd($bookings);
                return view('bookings.adminuser',[
                    'bookings' => $bookings
                ]);
        }
        else{
            return view('auth.login',[
                'url'=>'booking/confirmed/user'
            ]);
        }
        
    }

    /**
    * Display user's bookings ready to review
    * @author Tilman
    **/
    public function userIndexReviews ()
    {
        $bookings = DB::table('bookings')->select('bookings.id','houses.id as house_id','houses.name as house_name','rooms.number','rooms.price','rooms.nickname','bookings.status','bookings.date_from','bookings.date_to','bookings.created_at','users.name','bookings.message','bookings.note','users.id as user_id')
        ->where('bookings.user_id','=', Auth::user()->id)
        ->whereIn('bookings.status', [6,72])
        ->join('users','users.id','=','bookings.user_id')
        ->join('rooms','rooms.id','=','bookings.room_id')
        ->join('houses', 'houses.id','=','rooms.house_id')
        ->join('managers','managers.id', '=', 'houses.manager_id')
        // ->latest()
        ->paginate(15);

        foreach ($bookings as $booking)
        {
            $im = DB::table('image_houses')->select('image')
                          ->where('house_id','=',$booking->house_id)
                          ->orderBy('priority')
                          ->first();
            if ($im == null) {
                $non_image = ['priority'=>'100','id'=>'0', 'image'=>'room_4.jpeg'];
                $non_image= (object) $non_image;
                $im=$non_image;
            }

            $query = DB::table('status_update as su')->select('su.date')
                                   ->where('su.booking_id','=',$booking->id)
                                   ->latest()
                                   ->first();

            $booking->image = $im->image;
            $booking->update = (isset($query->date)) ? $query->date : $booking->created_at;
        }
        // dd($bookings);
        return view('bookings.adminuser',[
            'bookings' => $bookings
        ]);
    }


    /**
    * Display user's bookings in a view
    * @author Cristian
    **/
    public function adminBookingsPerUser ($id)
    {
        $bookings = DB::table('bookings')->select('bookings.id','houses.id as house_id','houses.name as house_name','rooms.number','rooms.price','rooms.nickname','bookings.status','bookings.date_from','bookings.date_to','bookings.created_at','users.name','bookings.message','bookings.note','users.id as user_id')
        ->where('bookings.user_id','=', $id)
        ->join('users','users.id','=','bookings.user_id')
        ->join('rooms','rooms.id','=','bookings.room_id')
        ->join('houses', 'houses.id','=','rooms.house_id')
        ->join('managers','managers.id', '=', 'houses.manager_id')
        // ->latest()
        ->paginate(15);

        foreach ($bookings as $booking)
        {
            $im = DB::table('image_houses')->select('image')
                          ->where('house_id','=',$booking->house_id)
                          ->orderBy('priority')
                          ->first();
            if ($im == null) {
                $non_image = ['priority'=>'100','id'=>'0', 'image'=>'room_4.jpeg'];
                $non_image= (object) $non_image;
                $im=$non_image;
            }

            $query = DB::table('status_update as su')->select('su.date')
                                   ->where('su.booking_id','=',$booking->id)
                                   ->latest()
                                   ->first();

            $booking->image = $im->image;
            $booking->update = (isset($query->date)) ? $query->date : $booking->created_at;
        }
        // dd($bookings);
        return view('bookings.adminuser',[
            'bookings' => $bookings
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $users=DB::table('users')->where('role_id','=',3)->get();
       //dd($users);
       $succes = 0;
               /*foreach ($status as $state => $description) {
           dd($description);
       }*/
       //dd($status);
        return view('bookings.create', [
            'users' => $users,
            'rooms' => Room::all(),
            'varsucces' => $succes,
            'status' => $this->STATUS
        ]);
    }
    /**
    * Show the screenshot of booking to FOM
    *
    * @param $id of booking in url
    * @author Cristian
    */
    public function screenshot($id)
    {
        $count = DB::table('screenshots')
                    ->where('screenshots.status','=',0)
                    ->join('bookings','bookings.id','=','screenshots.bookings_id')
                    ->count(); //count next screenshot for accept

        $screenshot =  DB::table('screenshots')->select('image')
                           ->where('screenshots.bookings_id','=',$id)
                           ->where('screenshots.status','=',0)
                           ->join('bookings','bookings.id','=','screenshots.bookings_id')
                           ->first(); //count next screenshot for accept

        if(isset($screenshot) == false)
        {
            abort(404);
        }
        return view('bookings.screenshot', [
            'booking' => Booking::findOrFail($id),
            'image' => $screenshot->image,
            'count' => $count -1,
        ]); // Return view whit booking's screenshot
    }

    /**
     * load screenshot to validate.
     *
     * @param Request $request, need image file and booking id
     * @return \Illuminate\Http\Response
     * @author Cristian
     */
    public function screenLoad(Request $request)
    {
        $image = $request->file('image');
        $s3 = Storage::disk('s3');
        if($image->getClientMimeType() === "image/jpeg" || $image->getClientMimeType() === "image/png") {
            $time = Carbon::now();
            $time=$time->year.$time->month.$time->day.$time->hour.$time->minute.$time->second;

            $s3->put('screen_'.$request->booking_id."_".$time.".".$image->extension()
                        , file_get_contents($image)
                        , 'public');

            DB::beginTransaction();

            DB::table('screenshots')->insert([
                'image' => 'screen_'.$request->booking_id."_".$time.".".$image->extension(),
                'status' => 0,
                'created_at' => Carbon::now(),
                'bookings_id' => $request->booking_id
            ]);

            $booking = Booking::findOrFail($request->booking_id);
            $booking->status = 50;
            $booking->save();
            $user = $booking->user;
            $manager = $booking->room->house->manager->user;
            $user->notify(new BookingNotification($booking));
            $manager->notify(new BookingNotification($booking));

            DB::commit();

            event(new BookingWasChanged($booking));

            return redirect()->back()->with('accepted_success','Se realizo el cambio');
        }

        return error('problemas con el screenshot');

    }

    /**
    * Screenshot process by FOM, use a flag if it's 1 booking's screenshot was accepted, else it was denied
    *
    * @param \Illuminate\Http\Request  $request
    * @author Cristian
    */
    public function screenProcess(Request $request)
    {
        $booking = Booking::findOrFail($request->id);
        $booking->status = ($request->flag == 1 ? 5: -50); // update status booking for 50 accepted or -50 denied
        $booking->save();
        $user = $booking->user;
        $manager = $booking->room->house->manager->user;
        $user->notify(new BookingNotification($booking));
        $manager->notify(new BookingNotification($booking));

        DB::table('screenshots')->where('screenshots.bookings_id','=',$request->id)
            ->update(['screenshots.status' => ($request->flag == 1 ? 1: -1)]); //update status screenshot for 1 accepted or -1 denied

        $data= [
            'id' => $booking->id,
            'status' => $booking->status
        ];

        if ($booking->status == 5)
        {
            $user = $booking->user;
            $manager = $booking->room->house->manager->user;
            $user->notify(new BookingNotification($booking));
            $manager->notify(new BookingNotification($booking));
            event(new BookingWasSuccessful($booking,true,true));
        }

        // self::statusUpdate($data); //update of status

        $query = DB::table('screenshots')->select('screenshots.bookings_id')
                    ->where('screenshots.status','=', 0);

        $count = $query->count(); //count next screenshot for accept

        if($count > 0)
        {
            $next = $query->first(); //next id os screenshot for accept
            return redirect('/booking/screenshot/'.$next->booking_id); //next view whit screenshot
        }

        return redirect('/');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        //dd($request->status);
        $users=DB::table('users')->where('role_id','=',3)->get();
        $succes=1;

        $request->validate([
            'room' => 'required',
            'user' => 'required',
            'dateto' => 'required',
            'datefrom' => 'required',
            'option' => 'required',
            'status' => 'required'
        ]);

        try
        {
            DB::beginTransaction();

            $booking=new Booking();
            $booking->date_to=$request->dateto;
            $booking->date_from=$request->datefrom;
            $booking->room_id=$request->room;
            $booking->user_id=$request->user;
            $booking->mode=$request->option;
            $booking->status=$request->status;
            if (isset($request->message)) {
                $booking->message=$request->message;
            } else {
                $booking->message="without message";
            }
            if (isset($request->note)) {
                $booking->note=$request->note;
            } else {
                $booking->note="without note";
            }
            if ($request->dateask!=null) {
                $booking->created_at=$request->dateask;
            }

            $booking->save();
            $manager = $booking->manager(); // $manager is a user model
            $data= [
                'id' => $booking->id,
                'status' => $booking->status
            ];

            $user = $booking->user;

            $user->notify(new BookingNotification($booking));
            $manager->notify(new BookingNotification($booking));
            $manager->notify(new NewRequest($manager,$booking));

            // self::statusUpdate($data);
            DB::commit();
        }
        catch (\PDOException $e) {
            DB::rollBack();
            $succes=-1;

            return view('bookings.create', [
                'users' => $users,
                'houses' => House::all(),
                'status' => $this->STATUS,
                'varsucces' => $succes
            ]);

        }

        return view('bookings.create', [
            'users' => $users,
            'houses' => House::all(),
            'status' => $this->STATUS,
            'varsucces' => $succes,
            'rooms' => Room::all()
        ]);
    }


    public function userView(Booking $booking)
    {
        $room = $booking->room;

        $house = $room->house;

        $user = $booking->user;

        $manager = $house->manager->user;

        $count = count($room->bookings->where('status', '>=', '1')->where('status', '<=', '3')) - 1;

        $available = ($room->bookings->where('status', 4)->count() > 0) ? true:false;

        if (($image_room = $room->images->first()) === null) {
            $image_room = [
                'id'        =>  '0',
                'priority'  =>  '100',
                'room_id'   =>  $room->id,
                'image'     =>  'room_4.jpeg'
            ];
            $image_room = (object) $image_room;
        }

        $query = DB::table('status_update as status')
            ->select('status.created_at')
            ->where('status.booking_id', '=', $booking->id)
            ->orderBy('created_at', 'desc')
            ->first();
        if (isset($query)) {
            $date_limit = Carbon::now(); //TIENEN QUE ARREGLARLO
            $date_limit->addDays(2);
            $now = Carbon::now();
            $milliseconds = $date_limit->diffInSeconds($now) * 1000;
        } else {
            $milliseconds = 0;
        }

        $whatsappnumberforlink = substr($user->phone, 1);

        $user_country = $user->country;

        $verification = Verification::firstOrCreate(
            ['user_id' => $user->id],
            [
                'user_id' => $user->id,
                'phone_verified' => false,
                'whatsapp_verified' => false,
                'document_verified' => false,
            ]
        );

        $currency = new Currency();

        $currency = $currency->getCurrentCurrency();

        return view('bookings.request', [
            'image_room' => $image_room->image,
            'count' => $count - 1,
            'booking' => $booking,
            'countries' => Country::all('id', 'name', 'icon')->sortBy('name'),
            'houses' => House::all(),
            'house' => $house,
            'status' => $this->STATUS,
            'room' => $room,
            'user' => $user,
            'whatsappnumberforlink' => $whatsappnumberforlink,
            'milliseconds' => $milliseconds,
            'today_date' => Carbon::now()->toDateString(),
            'today_time' => Carbon::now()->toTimeString(),
            'verification' => $verification,
            'currency' => $currency,
            'manager'   =>  $manager
        ]);


    }
     /**
     * Display the specified resource.
     *
     * @param  int  $id id of booking
     * @return \Illuminate\Http\Response
     * @author Cristian
     */
    public function userViewOld($id)
    {
        $booking=DB::table('bookings')->select('bookings.id','bookings.status',
                          'bookings.created_at','houses.name as house_name',
                          'rooms.number','rooms.id as room_id','rooms.price',
                          'bookings.status','bookings.date_from','bookings.date_to',
                          'users.name','users.last_name','users.birthdate','users.image',
                          'users.gender','bookings.mode','bookings.message','bookings.note',
                          'managers.id as manager_id','users.id as user_id',
                          'users.email as user_email', 'countries.name as country')
            ->join('users','users.id','=','bookings.user_id')
            ->join('rooms','rooms.id','=','bookings.room_id')
            ->join('houses', 'houses.id','=','rooms.house_id')
            ->join('managers','managers.id', '=', 'houses.manager_id')
            ->join('countries','countries.id','=','users.country_id')
            ->where('bookings.id', '=', $id)
            ->first();

        $status= $booking->status;

        $booking->manager_info = DB::table('managers')
                                ->select('users.id','users.name','users.last_name','users.description','users.image','users.email','users.phone','countries.icon', 'users.gender', 'countries.name as country_name')
                                ->join('users','users.id','=','managers.user_id')
                                ->join('countries','countries.id','=','users.country_id')
                                ->where('managers.id','=',$booking->manager_id)
                                ->first();

        $image_room = DB::table('image_rooms')
                      ->select('image_rooms.image')
                      ->where('image_rooms.room_id','=',$booking->room_id)
                      ->orderBy('priority')
                      ->first();
        if ($image_room == null) {
            $non_image = ['priority'=>'100','id'=>'0','room_id'=>$booking->room_id,'image'=>'room_4.jpeg'];
            $non_image= (object) $non_image;
            $image_room=$non_image;
        }

        $messages = Message::where('bookings_id','=',$booking->id)->get();

        $count = DB::table('bookings')->whereBetween('status',[1,3])
                     ->where('bookings.room_id', '=', $booking->room_id )
                     ->count();

        $query = DB::table('status_update as status')
             ->select('status.created_at')
             ->where('status.booking_id','=',$id)
             ->orderBy('created_at', 'desc')
             ->first();
        if (isset($query)) {
            $date_limit = Carbon::now(); //TIENEN QUE ARREGLARLO
            $date_limit->addDays(2);
            $now = Carbon::now();
            $milliseconds = $date_limit->diffInSeconds($now)*1000;
        } else {
            $milliseconds = 0;
        }
        $user=DB::table('users')->where('id','=',$booking->user_id)->first();
        $room=DB::table('rooms')->where('id','=',$booking->room_id)->first();
        $house=DB::table('houses')->where('id','=',$room->house_id)->first();
        // $vico_chat=View('bookings.vico_chat_user',[
        //     'booking' => $booking,
        //     'messages' => $messages,
        //     'user'=> $user,
        //     'today_time' => Carbon::now()->toTimeString(),
        //     'room' => $room,
        //     'house'=>$house
        // ])->render();

        $whatsappnumberforlink = substr($booking->manager_info->phone, 1);

        $verification = Verification::firstOrCreate(
            ['user_id' => $booking->manager_info->id],
            [
                'user_id' => $user->id,
                'phone_verified' => false,
                'whatsapp_verified' => false,
                'document_verified' => false,
            ]
        );

        $currency = new Currency();
        $currency = $currency->getCurrentCurrency();

        return view('bookings.request', [
            'image_room' => $image_room->image,
            'count' => $count -1,
            'booking' => $booking,
            'countries' => Country::all('id','name','icon')->sortBy('name'),
            'houses' => House::all(),
            'house' => $house,
            'status' => $this->STATUS,
            'room' => $room,
            'user' => $user,
            'whatsappnumberforlink' => $whatsappnumberforlink,
            'milliseconds' => $milliseconds,
            'today_date' => Carbon::now()->toDateString(),
            'today_time' => Carbon::now()->toTimeString(),
            'messages' => $messages,
            // 'vico_chat'=>$vico_chat,
            'verification' => $verification,
            'currency' => $currency
        ]);
    }
    public function printConfirmation($id){
            $booking=DB::table('bookings')->select('bookings.id','bookings.status',
                              'bookings.created_at','houses.name as house_name',
                              'rooms.number','rooms.id as room_id','rooms.price',
                              'bookings.status','bookings.date_from','bookings.date_to',
                              'users.name','users.last_name','users.birthdate','users.image',
                              'users.gender','bookings.mode','bookings.message','bookings.note',
                              'managers.id as manager_id','users.id as user_id',
                              'users.email as user_email', 'countries.name as country')
                ->join('users','users.id','=','bookings.user_id')
                ->join('rooms','rooms.id','=','bookings.room_id')
                ->join('houses', 'houses.id','=','rooms.house_id')
                ->join('managers','managers.id', '=', 'houses.manager_id')
                ->join('countries','countries.id','=','users.country_id')
                ->where('bookings.id', '=', $id)
                ->first();

            $status= $booking->status;

            $booking->manager_info = DB::table('managers')
                                    ->select('users.name','users.last_name','users.description','users.image','users.email','users.phone','countries.icon', 'users.gender', 'countries.name as country_name')
                                    ->join('users','users.id','=','managers.user_id')
                                    ->join('countries','countries.id','=','users.country_id')
                                    ->where('managers.id','=',$booking->manager_id)
                                    ->first();

            $image_room = DB::table('image_rooms')
                          ->select('image_rooms.image')
                          ->where('image_rooms.room_id','=',$booking->room_id)
                          ->orderBy('priority')
                          ->first();

            $messages = Message::where('bookings_id','=',$booking->id)->get();

            $count = DB::table('bookings')->whereBetween('status',[1,3])
                         ->where('bookings.room_id', '=', $booking->room_id )
                         ->count();

            $query = DB::table('status_update as status')
                 ->select('status.created_at')
                 ->where('status.booking_id','=',$id)
                 ->orderBy('created_at', 'desc')
                 ->first();
            if (isset($query)) {
                $date_limit = Carbon::now(); //TIENEN QUE ARREGLARLO
                $date_limit->addDays(2);
                $now = Carbon::now();
                $milliseconds = $date_limit->diffInSeconds($now)*1000;
            } else
            {
                $milliseconds = 0;
            }
            $user=DB::table('users')->where('id','=',$booking->user_id)->first();
            $room=DB::table('rooms')->where('id','=',$booking->room_id)->first();
            $house=DB::table('houses')->where('id','=',$room->house_id)->first();

            return view('bookings.print', [
                'image_room' => $image_room->image,
                'count' => $count -1,
                'booking' => $booking,
                'countries' => Country::all('id','name','icon')->sortBy('name'),
                'houses' => House::all(),
                'house' => $house,
                'status' => $this->STATUS,
                'room' => $room,
                'user' => $user,
                'milliseconds' => $milliseconds,
                'today_date' => Carbon::now()->toDateString(),
                'today_time' => Carbon::now()->toTimeString(),
                'messages' => $messages
            ]);
        }

        public function printConfirmationManager($id){
            $booking=Booking::where('id','=',$id)->firstOrFail();
            $user=User::where('id','=',$booking->user_id)->firstOrFail();
            $room=Room::where('id','=',$booking->room_id)->firstOrFail();
            $house=House::where('id','=',$room->house_id)->firstOrFail();
            $manager=Manager::where('id','=',$house->manager_id)->firstOrFail();
            $manager=User::where('id','=',$manager->user_id)->firstOrFail();
            $user->country=DB::table('countries')->select('name')->where('id','=',$user->country_id)->first()->name;

            $date=Carbon::today();

            if($date->day >= 1 && $date->day < 15){
                $new_date=$date->year.'/'.$date->month.'/'.'15';
            }
            else{
                $date=$date->addWeeks(4);
                $new_date=$date->year.'/'.$date->month.'/'.'1';
            }
            $date=Carbon::parse($new_date);
            // dd($user->country);zz
            return view('bookings.manager_print', [
                'user' => $user,
                'manager' => $manager,
                'room' => $room,
                'house' => $house,
                'booking' => $booking,
                'date_next_pay' => $date
            ]);
        }


    public function show(Booking $booking)
    {
        $status = $booking->status;

        $room = $booking->room;

        $house = $room->house;

        $user = $booking->user;

        $count = count($user->bookings) - 1;

        $available = ($room->bookings->where('status', 4)->count() > 0) ? true:false;

        $manager = $house->manager->user;

        if (($image_room = $room->images->first()) === null) {
            $image_room = [
                'id'        =>  '0',
                'priority'  =>  '100',
                'room_id'   =>  $room->id,
                'image'     =>  'room_4.jpeg'
            ];
            $image_room = (object) $image_room;
        }

        $whatsappnumberforlink = substr($user->phone, 1);

        $user_country = $user->country;

        $verification = Verification::firstOrCreate(
            ['user_id' => $user->id],
            [
                'user_id' => $user->id,
                'phone_verified' => false,
                'whatsapp_verified' => false,
                'document_verified' => false,
            ]
        );

        return view('bookings.show', [
            'user_country' => $user_country,
            'image_room' => $image_room->image,
            'available' => $available,
            'count' => $count - 1,
            'booking' => $booking,
            'room' => $room,
            'house' => $house,
            'user' => $user,
            'whatsappnumberforlink' => $whatsappnumberforlink,
            'countries' => Country::all('id', 'name', 'icon')->sortBy('name'),
            'houses' => House::all(),
            'status' => $this->STATUS,
            'today_date' => Carbon::now()->toDateString(),
            'today_time' => Carbon::now()->toTimeString(),
            'verification' => $verification,
            'manager'   =>  $manager
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showOld($id)
    {
        // dd(\Session::has('accepted_success'));
        $booking=DB::table('bookings')->where('id','=',$id)->first();
        // dd($booking);
        $status=$booking->status;
        $room=DB::table('rooms')->where('id','=',$booking->room_id)->first();
        $house=DB::table('houses')->where('id','=',$room->house_id)->first();
        $booking->manager_info = DB::table('managers')
                                ->join('users','users.id','=','managers.user_id')
                                ->where('managers.id','=',$house->manager_id)
                                ->first();
        $user=DB::table('users')->where('id','=',$booking->user_id)->first();
        $image_room = DB::table('image_rooms')
                      ->select('image_rooms.image')
                      ->where('image_rooms.room_id','=',$booking->room_id)
                      ->orderBy('priority')
                      ->first();
        if ($image_room == null) {
            $non_image = ['priority'=>'100','id'=>'0','room_id'=>$booking->room_id,'image'=>'room_4.jpeg'];
            $non_image= (object) $non_image;
            $image_room=$non_image;
        }
        $available = DB::table('bookings')
                         ->where('bookings.room_id','=',$booking->room_id)
                         ->where('bookings.status','=',4)
                         ->exists(); // is true if exists some booking is reserved
        // $deadline = DB::table('status_update')->where('booking_id', '=', $booking->id)->orderByDesc('created_at')->first();
        // $deadline = Carbon::parse($deadline->created_at)->addDays(1);
        $count = DB::table('bookings')->where('bookings.user_id','=',$booking->user_id)->count();
        // dd($country);

        $messages = DB::table('messages')
                        ->where('messages.bookings_id','=',$booking->id)
                        ->get();
        $vico_chat=View('bookings.vico_chat_show',[
            'booking' => $booking,
            'messages' => $messages,
            'user'=> $user,
            'room' => $room,
            'house' => $house,
            // 'deadline' => $deadline

        ])->render();

        $whatsappnumberforlink = substr($user->phone, 1);

        $user_country = Country::find($user->country_id);

        $verification = Verification::firstOrCreate(['user_id' => $user->id],
                            [
                                'user_id' => $user->id,
                                'phone_verified' => false,
                                'whatsapp_verified' => false,
                                'document_verified' => false,
                            ]
        );
        // dd($user_country);
        return view('bookings.show',[
            'user_country' => $user_country,
            'image_room' => $image_room->image,
            'available' => $available,
            'count' => $count -1,
            'booking' => $booking,
            'room' => $room,
            'house' => $house,
            'user' => $user,
            'whatsappnumberforlink' => $whatsappnumberforlink,
            'countries' => Country::all('id','name','icon')->sortBy('name'),
            'houses' => House::all(),
            'status' => $this->STATUS,
            'today_date' => Carbon::now()->toDateString(),
            'today_time' => Carbon::now()->toTimeString(),
            'messages' => $messages,
            'vico_chat' => $vico_chat,
            'verification' => $verification,
            // 'deadline' => $deadline

        ]);
    }

    public function refreshMessages(Request $request){
        // return $request;
        // try{
        //     $booking=DB::table('bookings')->select('bookings.id','bookings.status',
        //                     'bookings.created_at','houses.name as house_name',
        //                     'rooms.number','rooms.id as room_id','rooms.price',
        //                     'bookings.status','bookings.date_from','bookings.date_to',
        //                     'users.name','users.last_name','users.birthdate','users.image',
        //                     'users.gender','bookings.mode','bookings.message','bookings.note',
        //                     'managers.id as manager_id','users.id as user_id',
        //                     'users.email as user_email', 'countries.name as country')
        //         ->join('users','users.id','=','bookings.user_id')
        //         ->join('rooms','rooms.id','=','bookings.room_id')
        //         ->join('houses', 'houses.id','=','rooms.house_id')
        //         ->join('managers','managers.id', '=', 'houses.manager_id')
        //         ->join('countries','countries.id','=','users.country_id')
        //         ->where('bookings.id', '=', $request->id)
        //         ->first();
        //     $booking->manager_info = DB::table('managers')
        //         ->select('users.name','users.last_name','users.description','users.image','users.email','users.phone','countries.icon', 'users.gender', 'countries.name as country_name')
        //         ->join('users','users.id','=','managers.user_id')
        //         ->join('countries','countries.id','=','users.country_id')
        //         ->where('managers.id','=',$booking->manager_id)
        //         ->first();
        //     $room=Room::where('id','=',$booking->room_id)->first();
        //     $house=House::where('id','=',$room->house_id)->first();
        //     $user=User::where('id','=',$booking->user_id)->first();
        //     $messages = DB::table('messages')
        //     ->where('messages.bookings_id','=',$booking->id)
        //     ->get();
        //     $vico_chat='';
        //     if ($request->flag === '1') {
        //         $vico_chat=View('bookings.vico_chat_show',[
        //             'booking' => $booking,
        //             'messages' => $messages,
        //             'user'=> $user,
        //             'room' => $room,
        //             'house' => $house
        //         ])->render();
        //     } else {
        //         $vico_chat=View('bookings.vico_chat_user',[
        //             'booking' => $booking,
        //             'messages' => $messages,
        //             'user'=> $user,
        //             'today_time' => Carbon::now()->toTimeString(),
        //             'room' => $room,
        //             'house' => $house
        //         ])->render();
        //     }
        //     return  $vico_chat;
        // }
        // catch(Exception $e){
        //     return false;
        // }
        return response()->json('ok', 200);
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


    public function updateBooking($id_booking,$user_id,$house,$room,$date_from,$date_to,$status,$mode,$note){

        try{
            $booking=Booking::find($id_booking);
            $previous_status=$booking->status;
            $booking->status=$status;
            $room=Room::find($room);
            $user=$booking->user;
            $manager=$booking->Manager();
            if($mode == "1"){
                $booking->status = $status;
                $booking->room_id = $room->id;
                $booking->date_to = $date_to;
                $booking->date_from = $date_from;
                $booking->note = $note;
                $booking->mode = 1;
            //   DB::table('bookings')->where('id',$booking->id)->update([
            //       'status' => $status,
            //       'room_id' => $room->id,
            //       'date_to' => $date_to,
            //       'date_from' => $date_from,
            //       'note' => $note,
            //       'mode' => 1
            //   ]);
            } elseif ($mode == "2") {
                $booking->status = $status;
                $booking->room_id = $room->id;
                $booking->date_to = $date_to;
                $booking->date_from = $date_from;
                $booking->note = $note;
                $booking->mode = 2;
            //   DB::table('bookings')->where('id',$booking->id)->update([
            //       'status' => $status,
            //       'room_id' => $room->id,
            //       'date_to' => $date_to,
            //       'date_from' => $date_from,
            //       'note' => $note,
            //       'mode' => 2
            //   ]);
            }
            $room->available_from = $date_from;
            // DB::table('rooms')->where('id','=',$room->id)->update([
            //     'available_from' => $date_from
            // ]);
            // DB::table('bookings')->where('id',$booking->id)->update([
            //     'status' => $status
            // ]);
            $data = [
                'status' => $status,
                'id' => $id_booking
            ];
            if ($status == 5 && $previous_status > 0 && $previous_status < 5 || $status == 5 && $previous_status == 50 )
            {
                event(new BookingWasChanged($booking));
                event(new BookingWasSuccessful($booking,true,true));
                $manager = $booking->manager();
                $manager->notify(new BookingUpdateManager($booking));
                 // SEGMENT TRACKING INIT-------------------
                if (env('APP_ENV')=='production' && Auth::user()->role_id!=1) {
                    Analytics::bookingCompleted($manager, $user, $booking, $room);
                }
                // SEGMENT TRACKING END-------------------
            }
            if ($status != 5) {
                // self::statusUpdate($data);
            }

            //event(new BookingWasChanged($booking));

            $booking->save();
            $user = $booking->user;
            $manager = $booking->room->house->manager->user;
            $user->notify(new BookingNotification($booking));
            $manager->notify(new BookingNotification($booking));
        }
        catch(\PDOException $e){
            DB::rollBack();
          return $e;
        }
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
        if(is_array($request->id_booking)){
            for($i=0;$i<sizeof($request->id_booking);$i++){
                self::updateBooking($request->id_booking[$i],$request->user_id[$i],$request->house[$i],$request->room[$i],$request->date_from[$i],$request->date_to[$i],$request->status[$i],$request->mode[$i],$request->note[$i]);
            }
        }
        else{
            self::updateBooking($request->id_booking,$request->user_id,$request->house,$request->room,$request->date_from,$request->date_to,$request->status,$request->mode,$request->note);
        }
        return redirect("/booking");
    }
    /**
    * Trigger to update booking when payment is accepted
    *
    * @param Request $id
    * @return \Illuminate\Http\Response
    **/
     public function payment($id)
    {


    }

    /**
    * Trigger to update booking status with accepted
    *
    * @param Request $request
    * @return \Illuminate\Http\Response
    **/
    public function accepted(Request $request)
    {
        $booking = Booking::findOrFail($request->id);
        $booking->status = 4;
        $booking->note = $request->message_admin;
        $booking->save();

        event(new BookingWasChanged($booking));
        $user = $booking->user;
        $manager = $booking->room->house->manager->user;
        $user->notify(new BookingNotification($booking));
        $manager->notify(new BookingNotification($booking));

        $info = [
            'id' => $request->id,
            'status' => 2
        ];
        // self::statusUpdate($info);
        $user = $booking->user()->first();
        $user->notify(new BookingUpdateUser($booking));

        return redirect()->back()->with('accepted_success','Se realizo el cambio');
    }

    /**
    * If a use request the show of the whatsappnumber in the process "staying in medellín."
    *
    * @param Request $request
    * @return \Illuminate\Http\Response
    **/
    public function showPhoneNumber(Request $request)
    {
        $data = [
            'id' => $request->booking_id,
            'sender' => $request->sender
        ];
        $booking = find($request->booking_id);
        $user = $booking->User;
        $verification = Verification::firstOrCreate(['user_id' => $user->id]);
        if ($verification->canISendMail())
        {
            Mail::send('emails.test', $data, function ($message) use ($data) {
                     $message->from('hello@getvico.com', 'Team VICO');
                     $message->to('mails@friendsofmedellin.com');
                     $message->subject('WhatsApp in B#'.$data['id'].' requested by '.$data['sender']);
                 }); // mail is sended
        }

        return redirect()->back()->with('WhatsAppNumber','Ya puedes ver el número de WhatsApp')->with('message_sent','Ya puedes ver el número de WhatsApp');
    }

    /**
    * Trigger to update booking status with denied
    *
    * @param Request $request
    * @return \Illuminate\Http\Response
    * @author Cristian
    **/
    public function denied(Request $request)
    {
        // return response()->json(['respondio'=>$request->all()]);
        $bookingCurrent = Booking::findOrFail($request->id);

        self::SendSuggestions($bookingCurrent);

        // Mail::send('bookings.emails.user_0_suggestions', $data, function ($message) use ($data) {
        //     $message->from('friendsofmedellin@gmail.com', 'VICO - ¡Vivir entre amigos!');
        //     // $message->to($data['email']); //there is comment until test
        //     $message->to('friendsofmedellin@gmail.com');
        //     $message->subject($data['subject']);
        // });
        // event(new BookingWasChanged($bookingCurrent));

        if ($request->flag == 1)
        {
            //booking current is updated
            $bookingCurrent->status = -21;
            $bookingCurrent->save();
            $info = [
                'id' => $bookingCurrent->id,
                'status' => -21
            ];
            // self::statusUpdate($info);

            // it's created a new user
            $request->flag = null; //change the flag because in newUser There is a flag
            $user = self::newUser($request);

            try
            {
                DB::beginTransaction();

                $booking=new Booking();
                $booking->status=100;
                $booking->date_to=$request->dateto;
                $booking->date_from=$request->date_from;
                $booking->room_id=$request->room_id;
                $booking->user_id=$user->id;
                $booking->mode= 1;
                $booking->message="without message";
                $booking->note="FAKE booking";
                if($request->dateask!=null){
                    $booking->created_at=date('Y-m-d', time());
                }

                $booking->save();

                event(new BookingWasSuccessful($booking,false,true));
                $manager = $booking->manager();
                // $manager->notify(new BookingUpdateManager($booking));
                $info = [
                    'id' => $booking->id,
                    'status' => 100
                ];
                // self::statusUpdate($info);
                DB::commit();
            }
            catch (\PDOException $e) {
                DB::rollBack();

                //delete user if some was bad
                $user->delete();

                return back();
                // return $e;

              // dd($e);
            }
        }
        else
        {
            $bookingCurrent->status = -22;
            $bookingCurrent->note = (isset($request->massage)) ? $request->message : 'sin mensaje' ;
            $bookingCurrent->save();

            $info = [
                'id' => $bookingCurrent->id,
                'status' => -22
            ];
            // self::statusUpdate($info);

        }

        return redirect()->back()->with('accepted_success','Se realizo el cambio');
    }
    /**
     * give 48h of time to student.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @author Cristian
     */
    public function reserved(Request $request)
    {
        $booking = Booking::findOrFail($request->id);
        $available = DB::table('bookings')
                                 ->where('bookings.room_id','=',$booking->room_id)
                                 ->where('bookings.status','=',4)
                                 ->exists(); // is true if exists some booking is reserved
        if ($available) {
          return back()->withErrors(['Ya reservaste esta habitación']); //return back because other booking is reserved
        }
        $booking->note = $request->message;
        $booking->status = 4;
        $booking->save();

        event(new BookingWasChanged($booking));

        $user = $booking->user;
        $manager = $booking->room->house->manager->user;
        $user->notify(new BookingNotification($booking));
        $manager->notify(new BookingNotification($booking));

        $info = [
            'id' => $booking->id,
            'status' => $booking->status
        ];
        // self::statusUpdate($info);
        return redirect()->back()->with('accepted_success','Se realizo el cambio');
    }

    /**
     * request 48h of time to manager of house.
     *
     * @param  int  $id id of booking
     * @return \Illuminate\Http\Response
     * @author Cristian
     */
    public function timeRequest(Request $request)
    {
        $booking = Booking::findOrFail($request->id);
        $booking->note = $request->message_admin;
        $booking->status = 3;
        $booking->save();

        event(new BookingWasChanged($booking));

        $user = $booking->user;
        $manager = $booking->room->house->manager->user;
        $user->notify(new BookingNotification($booking));
        $manager->notify(new BookingNotification($booking));

        $info = [
            'id' => $booking->id,
            'status' => $booking->status
        ];
        // self::statusUpdate($info);
        return redirect()->back()->with('accepted_success','Se realizo el cambio');
    }

    /**
     * Cancel a booking when user say.
     *
     * @param  int  $id id of booking
     * @return \Illuminate\Http\Response
     * @author Cristian
     */
    public function cancel(Request $request)
    {
        $booking = Booking::findOrFail($request->id);
        $booking->status = -1;
        $booking->save();
        $user = $booking->user;
        $manager = $booking->room->house->manager->user;
        $user->notify(new BookingNotification($booking));
        $manager->notify(new BookingNotification($booking));


        //event(new BookingWasChanged($booking));

        $result =  self::getSuggestions($booking);
        //here it will be send a mail to the student
        $email_check=explode("@", Auth::user()->email);
        if(sizeof($email_check) > 1){
            $email=Auth::user()->email;
        }
        else{
            $email='hello@getvico.com';
        }
        $data = [
            'suggestions' => $result['suggestions'], //3 rooms suggestions to student
            'count_rooms' => $result['count_rooms'], //how many rooms are avaliable in right there house
            'email' => Auth::user()->email,
            'subject' => 'solicitud cancelada',
        ];

        // Mail::send('bookings.emails.user_0_suggestions', $data, function ($message) use ($data) {
        //     $message->from('friendsofmedellin@gmail.com', 'VICO - ¡Vivir entre amigos!');
        //     // $message->to($data['email']); //there is comment until test
        //     $message->to('friendsofmedellin@gmail.com');
        //     $message->subject($data['subject']);
        // });

        $info = [
            'id' => $booking->id,
            'status' => $booking->status
        ];
        // self::statusUpdate($info);
        return redirect()->back()->with('accepted_success','Se realizo el cambio');
    }

    public function cancelRequest(Request $request)
    {
        $booking = Booking::findOrFail($request->id);
        if (Route::currentRouteName() == 'cancel.request.user') {
            $user = User::findOrFail($booking->user_id);            
        }else if(Route::currentRouteName() == 'cancel.request.manager'){
            $user = $booking->manager();
        }

        return view('bookings.canceled',
            [
                'user'      => $user,
                'booking'   => $booking,
            ]
        );
    }
    public function cancelRequestUser(Booking $booking)
    {
        $user = User::findOrFail($booking->user_id);            

        return view('bookings.canceled',
            [
                'user'      => $user,
                'booking'   => $booking,
            ]
        );
    }
    public function cancelRequestManager(Booking $booking)
    {
        $booking = Booking::findOrFail($booking->id);
        
        $user = $booking->manager();

        return view('bookings.canceled',
            [
                'user'      => $user,
                'booking'   => $booking,
            ]
        );
    }

    public function cancelNotify(Request $request)
    {
        $booking = Booking::findOrFail($request->booking_id);

        if (Route::currentRouteName() == 'cancel.notify.user') {  
            $booking->status = 8;
            $user = User::findOrFail($booking->user_id);
        }else if(Route::currentRouteName() == 'cancel.notify.manager'){
            $booking->status = 9;
            $user = $booking->manager();
        }
        
        $booking->save();

        $user = $booking->user;
        $manager = $booking->room->house->manager->user;
        $user->notify(new BookingNotification($booking));
        $manager->notify(new BookingNotification($booking));

        // $user = User::findOrFail($booking->user_id);
        $admin = User::findOrFail(1);

        $user->notify(new cancelBookingPetition($user->role_id, $user, $booking,
            ['problem' => $request->problem,
            'explanation_details' => $request->explanation_details])
        );

        $admin->notify(new cancelBookingPetition($admin->role_id, $user, $booking,
            ['problem' => $request->problem,
            'explanation_details' => $request->explanation_details])
        );

        return redirect($user->role_id == 3 ? '/booking/user/' : '/booking/show/'.$request->booking_id)->with('message_sent','Tu mensaje fue enviado.');
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
       // dd($id);
        $booking = Booking::findOrFail($id)->delete();
        // dd($booking);
        return back();
    }

    /**
     * Obtiene la información que será desplegada en la página para el booking
     * @param int $id: Identificador único del bookings
     * @return \Iluminate\Http\Response
     * @author Andres Felipe Cano
     */
    public function getReview(int $id){
      $booking = Booking::where('id', $id)->firstOrFail();
      if(self::validateReview($booking)){
        if($booking->status != '70' && $booking->status != '72'){
            $usuario = User::where('id', $booking->user_id)->firstOrFail();
            $habitacion = Room::where('id', $booking->room_id)->firstOrFail();
            $casa = House::where('id', $habitacion->house_id)->firstOrFail();
            return view('bookings.review')
                ->with(compact('booking'))
                ->with(compact('usuario'))
                ->with(compact('habitacion'))
                ->with(compact('casa'));
        }
        else{
            //El booking ya fue calificado por el usuario
            return view('bookings.answer');
        }
      }
      else{
          //Ya no se puede hacer el booking
          return view('bookings.answer');
      }
    }

    /**
     * Obtiene la información que será desplegada en la página para el booking
     * @param int $id: Identificador único del bookings
     * @return \Iluminate\Http\Response
     * @author Andres Felipe Cano
     */
    public function getReviewManager(int $id){
        $booking = Booking::where('id', $id)->firstOrFail();
        if(self::validateReview($booking)){
            if($booking->status != '70' && $booking->status != '71'){
                $habitacion = Room::where('id', $booking->room_id)->firstOrFail();
                $casa = House::where('id', $habitacion->house_id)->firstOrFail();
                $managerId = Manager::select('user_id')->where('id', $casa->manager_id)->firstOrFail();
                $manager = User::where('id', $managerId->user_id)->firstOrFail();
                $usuario = User::where('id', $booking->user_id)->firstOrFail();
                return view('bookings.reviewManager')
                    ->with(compact('booking'))
                    ->with(compact('habitacion'))
                    ->with(compact('casa'))
                    ->with(compact('manager'))
                    ->with(compact('usuario'));
            }
            else{
                //El booking ya fue calificado por el manager
                return view('bookings.answer');
            }
        }
        else{
            //Ya no se puede hacer el booking
            return view('bookings.answer');
        }
    }

    /**
     * Obtiene la información que será desplegada en la página para el booking
     * @param int $id: Identificador único del bookings
     * @return \Iluminate\Http\Response
     * @author Andres Felipe Cano
     */
    public function getReviewManagerComment(int $id){
        $booking = Booking::where('id', $id)->firstOrFail();
        if(self::validateReview($booking)){
            $habitacion = Room::where('id', $booking->room_id)->firstOrFail();
            $casa = House::where('id', $habitacion->house_id)->firstOrFail();
            $managerId = Manager::select('user_id')->where('id', $casa->manager_id)->firstOrFail();
            $manager = User::where('id', $managerId->user_id)->firstOrFail();
            return view('bookings.reviewManagerComment')
                ->with(compact('booking'))
                ->with(compact('manager'));
        }
        else{
            return view('bookings.answer');
        }


    }

    /**
     * Obtiene la información que será desplegada en la página para el booking
     * @param int $id: Identificador único del bookings
     * @return \Iluminate\Http\Response
     * @author Andres Felipe Cano
     */
    public function getManagerReviewPrivateComment(int $id, int $manager_id){
        $booking = Booking::where('id', $id)->firstOrFail();
        if(self::validateReview($booking)){
            $usuario = User::where('id', $booking->user_id)->firstOrFail();
            return view('bookings.reviewManagerPrivateComment')
                ->with(compact('booking'))
                ->with(compact('usuario'))
                ->with(compact('manager_id'));
        }
        else{
            return view('bookings.answer');
        }
    }

    /**
     * Obtiene la información que será desplegada en la página para el booking
     * @param int $id: Identificador único del bookings
     * @return \Iluminate\Http\Response
     * @author Andres Felipe Cano
     */
    public function getManagerReviewFomComment(int $id, int $manager_id){
        $booking = Booking::where('id', $id)->firstOrFail();
        if(self::validateReview($booking)){
            return view('bookings.reviewManagerFomComment')
                ->with(compact('booking'))
                ->with(compact('manager_id'));
        }
        else{
            return view('bookings.answer');
        }
    }

    /**
     * Obtiene la información que será desplegada en la página para el booking
     * @param int $id: Identificador único del bookings
     * @return \Iluminate\Http\Response
     * @author Andres Felipe Cano
     */
    public function getReviewFomComment(int $id){
        $user = Auth::user();

        $booking = Booking::where('id', $id)->firstOrFail();
        $showNPSModal = false;
        if (!is_null($user->UserRatings->last())){
            $ratevico = $user->UserRatings->last()->updated_at;
            if(strtotime($ratevico) > strtotime('-30 days')) {
                $showNPSModal = false;
            }
            else {
                $showNPSModal = true;
            }
        }
        else {
            $showNPSModal = true;
        }
        
      //if(self::validateReview($booking)){
        return view('bookings.reviewFomComment')->with(compact('booking', 'showNPSModal'));
      //}
      //else{
      //  return view('bookings.answer');
      //}

    }

    /**
    * Guarda la información entregada por bookings.review en la base de datos
    * @param Request $request: petición POST de la vista
    * @param Booking $booking: El booking al que se le está haciendo la calificación, se valida antes de continuar con las transacciones
    * @return \Iluminate\Http\Response
    * @author Andres Felipe Cano
    **/

    public function postReview(Request $request, Booking $booking){
      if(self::validateReview($booking)){ //Booking validate status
        if($booking->status != '70' && $booking->status != '71'){ //Pasan las validaciones ($request->user_id === $booking->user_id) || $request->role_id === "1"
          /* Validamos los datos que nos envían por el formulario (Front end de la vista)*/
          $this->validate($request, [
            'qualificationHouseData' => 'required',
            'qualificationHouseExperience' => 'required',
            'qualificationHouseDevices' => 'required',
            'qualificationHousewifi' => 'required',
            'qualificationHouseBath' => 'required',
            'qualificationHouseRoomies' => 'required',
            'qualificationHouseLoudparty' => 'required',
            'qualificationHouseRecommend' => 'required',
            'qualificationHouseHouseComment' => 'required',
            'qualificationRoomsData' => 'required',
            'qualificationRoomsGeneral' => 'required',
            'qualificationRoomsLoud' => 'required',
            'qualificationRoomswifi' => 'required',
            'qualificationNeighborhoodsGeneral' => 'required',
            'qualificationNeighborhoodsAccess' => 'required',
            'qualificationNeighborhoodsShopping' => 'required',
            'qualificationUsersManagerCommunication' => 'required',
            'qualificationUsersManagerComprise' => 'required',
          ]);

          $house_id = DB::table('rooms')
            ->select('house_id')
            ->where('id', '=', $booking->room_id)
            ->get();

          $house = DB::table('houses')
            ->select('id', 'neighborhood_id')
            ->where('id', '=', $house_id[0]->house_id)
            ->get();

          $room = DB::table('rooms')
            ->select('id')
            ->where('id', '=', $booking->room_id)
            ->get();

          /* Calificación del barrio */
          $qualificationNeighborhood = QualificationNeighborhood::firstOrNew(['bookings_id' => $booking->id]); //Creamos la instancia del modelo, y luego añadimos atributos
          $qualificationNeighborhood->general = $request->qualificationNeighborhoodsGeneral;
          $qualificationNeighborhood->access = $request->qualificationNeighborhoodsAccess;
          $qualificationNeighborhood->shopping = $request->qualificationNeighborhoodsShopping;
          $qualificationNeighborhood->booking()->associate($booking); //App/QualificationNeighborhohd tiene el método belongsTo(Booking), por ende debemos asociar el modelo booking

          $qualificationNeighborhood->push(); //Guardamos en la base de datos


          /* Promedio para: Calificación del barrio */
          $averageNeighborhood = AverageNeighborhood::firstOrNew(['neighborhood_id' => $house[0]->neighborhood_id]);
          $averageNeighborhood->neighborhood_id = $house[0]->neighborhood_id;
          $general = $request->qualificationNeighborhoodsGeneral;
          $access = $request->qualificationNeighborhoodsAccess;
          $shopping =   $request->qualificationNeighborhoodsShopping;
          $average = (($request->qualificationNeighborhoodsGeneral +
            $request->qualificationNeighborhoodsAccess +
            $request->qualificationNeighborhoodsShopping))/3;


          $averageNeighborhood->global = ($averageNeighborhood->global === null)? $average:($averageNeighborhood->global + $average) /2;

          if($general != 0.0){
              $averageNeighborhood->general = ($averageNeighborhood->general === null)?
              $general: ($averageNeighborhood->general + $general) /2;
          }
          if($access != 0.0){
            $averageNeighborhood->access = ($averageNeighborhood->access === null)?
            $access: ($averageNeighborhood->access + $access) /2;
          }
          if($shopping != 0.0){
              $averageNeighborhood->shopping = ($averageNeighborhood->shopping === null)?
              $shopping: ($averageNeighborhood->shopping + $shopping) /2;
          }

          $averageNeighborhood->save();

          /* Calificacion de la habitación */
          $qualificationRoom = QualificationRoom::firstOrNew(['bookings_id' => $booking->id]);; //Creamos la instancia del modelo, y luego añadimos atributos
          $qualificationRoom->general = $request->qualificationRoomsGeneral;
          $qualificationRoom->loud = $request->qualificationRoomsLoud;
          $qualificationRoom->data = $request->qualificationRoomsData;
          $qualificationRoom->wifi = $request->qualificationRoomswifi;
          $qualificationRoom->booking()->associate($booking); //App/QualificationNeighborhohd tiene el método belongsTo(Booking), por ende debemos asociar el modelo booking

          $qualificationRoom->push(); //Guardamos en la base de datos



          /* Calificación del dueño */
          $qualificationManager = QualificationUser::firstOrNew(['bookings_id' => $booking->id]);; //Creamos la instancia del modelo, y luego añadimos atributos
          $qualificationManager->manager_comunication = $request->qualificationUsersManagerCommunication;
          $qualificationManager->manager_compromise = $request->qualificationUsersManagerComprise;
          $qualificationManager->manager_comment = "No apply";
          $qualificationManager->booking()->associate($booking); //App/QualificationNeighborhohd tiene el método belongsTo(Booking), por ende debemos asociar el modelo booking

          $qualificationManager->push(); //Guardamos en la base de datos

          /* Calificación de la casa*/
          $qualificationHouse = QualificationHouse::firstOrNew(['bookings_id' => $booking->id]);; //Creamos la instancia del modelo y luego añadimos atributos
          $qualificationHouse->experience = $request->qualificationHouseExperience;
          $qualificationHouse->data = $request->qualificationHouseData;
          $qualificationHouse->devices = $request->qualificationHouseDevices;
          $qualificationHouse->wifi = $request->qualificationHousewifi;
          $qualificationHouse->bath = $request->qualificationHouseBath;
          $qualificationHouse->roomies = $request->qualificationHouseRoomies;
          $qualificationHouse->loudparty = $request->qualificationHouseLoudparty;
          $qualificationHouse->recommend = $request->qualificationHouseRecommend;
          $qualificationHouse->house_comment = $request->qualificationHouseHouseComment;
          $qualificationHouse->booking()->associate($booking);

          $qualificationHouse->push(); //Guardamos en la base de datos

          /* Promedio para: Calificacion de la casa */
          $averageHouse = AverageHouses::firstOrNew(['house_id' => $house[0]->id]);
          $averageHouse->house_id = $house[0]->id;
          $experience = $request->qualificationHouseExperience;
          $data = $request->qualificationHouseData;
          $devices = $request->qualificationHouseDevices;
          $wifi = $request->qualificationHousewifi;
          $bath = $request->qualificationHouseBath;
          $roomies = $request->qualificationHouseRoomies;
          $loudparty = $request->qualificationHouseLoudparty;
          $managerCompromise = $request->qualificationUsersManagerComprise;
          $managerComunication = $request->qualificationUsersManagerCommunication;
          $average = ((
            $request->qualificationHouseExperience +
            $request->qualificationHouseData +
            $request->qualificationHouseDevices +
            $request->qualificationHousewifi +
            $request->qualificationHouseBath +
            $request->qualificationHouseRoomies

          ) / 6);

          if($managerComunication != 0.0){
            $averageHouse->manager_comunication = ($averageHouse->$managerComunication === null)?
              $managerComunication:($averageHouse->manager_communication + $managerComunication) /2;
          }

          if($managerCompromise != 0.0){
            $averageHouse->manager_compromise = ($averageHouse->manager_compromise === null)?
              $managerCompromise:($averageHouse->manager_compromise + $managerCompromise) /2;
          }

          if($average != 0.0){
            $averageHouse->global = ($averageHouse->global === null)?
              $average:($averageHouse->global + $average) /2;
          }

          if($experience != 0.0){
            $averageHouse->experience = ($averageHouse->experience === null) ?
              $experience:($averageHouse->experience + $experience)/2;
          }

          if($data != 0.0){
            $averageHouse->data = ($averageHouse->data === null) ?
              $data:($averageHouse->data + $data)/2;
          }
          if($devices != 0.0){
            $averageHouse->devices = ($averageHouse->devices === null) ?
              $devices:($averageHouse->devices + $devices)/2;
          }
          if($wifi != 0.0){
            $averageHouse->wifi = ($averageHouse->wifi === null) ?
              $wifi:($averageHouse->wifi + $wifi)/2;
          }
          if($bath != 0.0){
            $averageHouse->bath = ($averageHouse->bath === null) ?
              $bath:($averageHouse->bath + $bath)/2;
          }
          if($roomies != 0.0){
            $averageHouse->roomies = ($averageHouse->roomies === null) ?
              $roomies:($averageHouse->roomies + $roomies)/2;
          }
          if($loudparty != 0.0){
            $averageHouse->loudparty = ($averageHouse->loudparty === null) ?
              $loudparty:($averageHouse->loudparty + $loudparty)/2;
          }

          $averageHouse->save();

          $averageRoom = AverageRooms::firstOrNew(['room_id' => $room[0]->id]);
          $averageRoom->room_id = $room[0]->id;
          $global   = $request->qualiicationRoomsGeneral;
          $loud     = $request->qualificationRoomsLoud;
          $data     = $request->qualificationRoomsData;
          $wifi     = $request->qualificationRoomswifi;
          $average = ((
              $request->qualiicationRoomsGeneral +
              $request->qualificationRoomsLoud +
              $request->qualificationRoomsData +
              $request->qualificationRoomswifi
          ) / 4);
          if($general != 0.0){
            $averageRoom->general = ($averageRoom->general === null) ?
                $general: ($averageRoom->general + $general) / 2;
          }
          if($loud != 0.0){
            $averageRoom->loud = ($averageRoom->loud === null) ?
                $loud: ($averageRoom->loud + $loud) / 2;
          }
          if($data != 0.0){
            $averageRoom->data = ($averageRoom->data === null) ?
                $data: ($averageRoom->data + $data) / 2;
          }
          if($wifi != 0.0){
            $averageRoom->wifi = ($averageRoom->wifi === null) ?
                $wifi: ($averageRoom->wifi + $wifi) / 2;
          }
          if($average != 0.0){
            $averageRoom->global = ($averageRoom->global === null) ?
                $average: ($averageRoom->global + $average) / 2;
          }

          $averageRoom->save();
          $booking->status = ($booking->status === '5' || $booking->status === '6')? 71:70;
          $booking->push();
          $manager= $booking->manager();
          $manager->notify(new ReviewDone($booking,$manager));
            $user = $booking->user;

            $user->notify(new BookingNotification($booking));
            $manager->notify(new BookingNotification($booking));
          return redirect()->route('get_manager_comment', [$booking->id]);

        }
        else{
            //Booking already reviewed
            return view('bookings.answer');
        }
      }
      else{
          //Booking cant be reviewed
          return view('bookings.answer');
      }
    }


    /**
    * Guarda la información entregada por bookings.review en la base de datos
    * @param Request $request: petición POST de la vista
    * @param Booking $booking: El booking al que se le está haciendo la calificación, se valida antes de continuar con las transacciones
    * @return \Iluminate\Http\Response
    * @author Andres Felipe Cano
    **/

    public function postReviewManager(Request $request, Booking $booking){

        if(self::validateReview($booking)){ //Validate user_id is the same as manager_id from de house as follows: booking->room->house->manager $request->manager_id === $request->user_id || $request->role_id === '1'
            if($booking->status != '70' && $booking->status != '72'){
                /* Validamos los datos que nos envían por el formulario (Front end de la vista)*/
                $this->validate($request, [
                    'qualificationManagerClean' => 'required',
                    'qualificationManagerComunication' => 'required',
                    'qualificationManagerRules' => 'required',
                    'qualificationManagerRecommend' => 'required',
                    'qualificationManagerPublicComment' => 'required'

                ]);
                /* Calificación del barrio*/
                $qualificationManager = QualificationManager::firstOrNew(['bookings_id' => $booking->id]); //Creamos la instancia del modelo, y luego añadimos atributos
                $qualificationManager->clean = $request->qualificationManagerClean;
                $qualificationManager->communication = $request->qualificationManagerComunication;
                $qualificationManager->rules = $request->qualificationManagerRules;
                $qualificationManager->public_comment = $request->qualificationManagerPublicComment;
                $qualificationManager->private_comment = "";
                $qualificationManager->fom_comment = "";
                $qualificationManager->recommend = $request->qualificationManagerRecommend;
                // $qualificationManager->booking()->associate($booking); //App/QualificationManager tiene el método belongsTo(Booking), por ende debemos asociar el modelo booking
                // $qualificationManager->push();
                // $booking->status = ($booking->status === '5' || $booking->status === '6') ? 72:70;
                // $bookingId = $booking->id;
                // $booking->push();

                $qualificationManager->save();
                $booking->status = ($booking->status === '5' || $booking->status === '6') ? 72:70;
                $bookingId = $booking->id;
                $booking->save();
                $user = $booking->user()->first();
                $user->notify(new ReviewDone($booking,$user));

                $manager = $booking->room->house->manager->user;
                $user->notify(new BookingNotification($booking));
                $manager->notify(new BookingNotification($booking));

                return redirect()->route('get_private_comment', ['id' => $bookingId, 'manager_id' => $request->manager_id]);
            }
            else{
                //Bookig already reviewed
                return view('bookings.answer');
            }
        }
        else{
            //Booking cant be reviewd
            return view('bookings.answer');
        }

    }

    /**
    *
    **/
    public function postManagerReviewPrivateComment(Request $request, Booking $booking){

        if(self::validateReview($booking)){ //Validate user_id is the same as manager_id from de house as follows: booking->room->house->manager $request->manager_id === $request->user_id || $request->role_id === '1'
            $this->validate($request, [
            'role_id' => 'required',
            ]);
            $qualificationManager = QualificationManager::where('bookings_id', $booking->id)->first();
            $qualificationManager->private_comment = $request->private_comment;
            $qualificationManager->push();
            return view('bookings.answer');
        }
        else{
            //Booking cant be reviewd
            return view('bookings.answer');
        }
    }

    /**
    *
    **/
    public function postManagerReviewFomComment(Request $request, Booking $booking){

        if(self::validateReview($booking)){ //Validate user_id is the same as manager_id from de house as follows: booking->room->house->manager $request->manager_id === $request->user_id || $request->role_id === '1'
            $this->validate($request, [
            'role_id' => 'required',
            'user_id' => 'required',
            // 'fom_comment' => 'required'
            ]);
            $qualificationManager = QualificationManager::where('bookings_id', $booking->id)->first();
            $qualificationManager->fom_comment = $request->fom_comment;
            $qualificationManager->push();
            return view('bookings.answer');
        }
        else{
            return view('bookings.answer');
        }
    }

    /**
    *
    **/
    public function postReviewManagerComment(Request $request, Booking $booking){

        if(self::validateReview($booking)){ // Validate user_id is the same as booking->_id $request->user_id === $booking->user_id || $request->role_id === "1"
          $this->validate($request, [
            'role_id' => 'required',
            'user_id' => 'required',
            // 'manager_comment' => 'required'
          ]);
          $qualificationUser = QualificationUser::where('bookings_id', $booking->id)->first();
          $qualificationUser->manager_comment = $request->manager_comment;
          $qualificationUser->push();
          return redirect()->route('get_fom_comment_user', [$booking->id]);
        }
        else{
            return view('bookings.answer');
        }
    }

    /**
    *
    **/
    public function postReviewFomComment(Request $request, Booking $booking){

        if(self::validateReview($booking)){ // Validate user_id is the same as booking->_id $request->user_id === $booking->user_id || $request->role_id === "1"
          $this->validate($request, [
            'role_id' => 'required',
            'user_id' => 'required',
          ]);
          $qualificationUser = QualificationUser::where('bookings_id', $booking->id)->first();
          $qualificationUser->fom_comment = $request->fom_comment;
          $qualificationUser->push();
          return view('bookings.answer');
        }
        else{
            return view('bookings.answer');
        }

    }


    public function getSuggestions($booking)
    {
        /*------------------------------------ suggestions ----------------------------------------------------------*/

        // suggestions for students by neighborhood or university
        $bookingCurrent = $booking; //set current booking

        $info_house = DB::table('rooms')->select('houses.id as house_id','neighborhoods.id as neighborhood_id','rooms.price')
                         ->where('rooms.id','=',$bookingCurrent->room_id)
                         ->join('houses','houses.id','=','rooms.house_id')
                         ->join('neighborhoods','neighborhoods.id','=','houses.neighborhood_id')
                         ->first(); //info of house in current booking

        $info_house->count = DB::table('rooms')->select('rooms.id')
                                 ->where('houses.id','=',$info_house->house_id)
                                 ->join('houses','houses.id','=','rooms.house_id')
                                 ->count(); //count of rooms in rigth there house

        $count_rooms = self::querySuggestions();
        $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                      ->where('houses.id','=',$info_house->house_id);
        $count_rooms = $count_rooms->count(); //count of rooms in right there house

        /**
        * elections tree for suggestions of students
        * @param count_houses count of rooms avalaible on right house
        * @return a collection with 3 rooms suggestions for student
        * @author Cristian
        **/
        switch ($count_rooms)
        {
            case 0:
                // without rooms in house
                $count_rooms = self::querySuggestions();
                $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                             ->where('neighborhoods.id','=',$info_house->neighborhood_id)
                             ->whereBetween('rooms.price',[$info_house->price - 100000 ,$info_house->price + 100000])
                             ->whereBetween('houses.rooms_quantity',[$info_house->count -3,$info_house->count + 3]);
                $count_rooms = $count_rooms->count();  // count of rooms whit date,neighborhood,price,quantity
                if ($count_rooms == 0)
                {
                    //without rooms like neighborhood and rooms quantity and price
                    $count_rooms = self::querySuggestions();
                    $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                 ->where('neighborhoods.id','=',$info_house->neighborhood_id)
                                 ->whereBetween('rooms.price',[$info_house->price - 100000 ,$info_house->price + 100000]);
                    $count_rooms = $count_rooms->count(); // count of rooms whit date,neighborhood,price
                    if ($count_rooms == 0)
                    {
                        //without rooms like neighborhood and price
                        $count_rooms = self::querySuggestions();
                        $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                            ->where('neighborhoods.id','=',$info_house->neighborhood_id);
                        $count_rooms = $count_rooms->count(); // count of rooms whit date,neighborhood
                        if ($count_rooms == 0)
                        {
                            //without rooms like neighborhood
                            $count_rooms = self::querySuggestions();
                            $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                            $count_rooms = $count_rooms->count(); // count of rooms whit date
                            if ($count_rooms == 0)
                            {
                                //without rooms like available from
                                $suggestions = self::querySuggestions();
                                $suggestions->whereDate('rooms.available_from','<=', Carbon::today());
                                $suggestions = $suggestions->limit(3)->get();
                            }elseif ($count_rooms == 1)
                            {
                                //with 1 rooms like available from
                                $suggestions = self::querySuggestions();
                                $suggestions->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                                $suggestions = $suggestions->limit(1)->get();
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<=', Carbon::today());
                                $items = $items->limit(2)->get();
                                foreach ($items as $item){ $suggestions->push($item);} //foreach to push items on suggestions
                            }elseif ($count_rooms == 2)
                            {
                                //with 2 rooms like available from
                                $suggestions = self::querySuggestions();
                                $suggestions->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                                $suggestions = $suggestions->limit(2)->get();

                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<=', Carbon::today());
                                $items = $items->first();

                                $suggestions->push($items); //it push items on suggestions
                            }else
                            {
                                //with 3 or more rooms like available from
                                $suggestions = self::querySuggestions();
                                $suggestions->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                                $suggestions = $suggestions->limit(3)->get();
                            }
                        }elseif ($count_rooms == 1)
                        {
                            //with 1 rooms like neighborhood
                            $suggestions = self::querySuggestions();
                            $suggestions->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                        ->where('neighborhoods.id','=',$info_house->neighborhood_id);
                            $suggestions = $suggestions->limit(1)->get();

                            $count_rooms = self::querySuggestions();
                            $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                           $count_rooms = $count_rooms->count();
                            if ($count_rooms == 0)
                            {
                                //without rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<=', Carbon::today());
                                $items = $items->limit(2)->get();
                                foreach ($items as $item){ $suggestions->push($item);} //foreach to push items on suggestions
                            }elseif ($count_rooms == 1)
                            {
                                //with 1 rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                                $items = $items->first();
                                $items2 = self::querySuggestions();
                                $items2->whereDate('rooms.available_from','<=', Carbon::today());
                                $items2 = $items2->first();

                                $suggestions->push($items); //it push items on suggestions
                                $suggestions->push($items2);
                            }else
                            {
                                //with 2 or more rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                                $items = $items->limit(2)->get();
                                foreach ($items as $item){ $suggestions->push($item);} //foreach to push items on suggestions
                            }
                        }elseif ($count_rooms == 2)
                        {
                            //with 2 rooms like neighborhood
                            $suggestions = self::querySuggestions();
                            $suggestions->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                        ->where('neighborhoods.id','=',$info_house->neighborhood_id);
                            $suggestions = $suggestions->limit(2)->get();

                            $count_rooms = self::querySuggestions();
                            $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                            $count_rooms = $count_rooms->count();
                            if ($count_rooms == 0)
                            {
                                //without rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<=', Carbon::today());
                                $items = $items->first();
                                $suggestions->push($items); //it push items on suggestions
                            }else
                            {
                                //with 1 or more rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                                $items = $items->first();
                                $suggestions->push($items); //it push items on suggestions
                            }
                        }else
                        {
                            //with 3 or more rooms like price
                            $suggestions = self::querySuggestions();
                            $suggestions->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                        ->where('neighborhoods.id','=',$info_house->neighborhood_id);
                            $suggestions = $suggestions->limit(3)->get();
                        }
                    }elseif ($count_rooms == 1)
                    {
                        //with 1 room like neighboorhood and price
                        $suggestions = self::querySuggestions();
                        $suggestions->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                    ->where('neighborhoods.id','=',$info_house->neighborhood_id)
                                    ->whereBetween('rooms.price',[$info_house->price - 100000 ,$info_house->price + 100000]);
                       $suggestions = $suggestions->limit(1)->get();

                        $count_rooms = self::querySuggestions();
                        $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                     ->where('neighborhoods.id','=',$info_house->neighborhood_id);
                        $count_rooms = $count_rooms->count();
                        if ($count_rooms == 0)
                        {
                            //without rooms like neighborhood
                            $count_rooms = self::querySuggestions();
                            $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                            $count_rooms = $count_rooms->count();
                            if ($count_rooms == 0)
                            {
                                //without rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<=', Carbon::today());
                                $items = $items->limit(2)->get();
                                foreach ($items as $item){ $suggestions->push($item);} //foreach to push items on suggestions
                            }elseif ($count_rooms == 1)
                            {
                                //with 1 rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                                $items = $items->first();

                                $items2 = self::querySuggestions();
                                $items2->whereDate('rooms.available_from','<=', Carbon::today());
                                $items2 = $items2->first();
                                $suggestions->push($items); //it push items on suggestions
                                $suggestions->push($items2);
                            }else
                            {
                                //with 2 or more rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                                $items = $items->limit(2)->get();
                                foreach ($items as $item){ $suggestions->push($item);} //foreach to push items on suggestions
                            }
                        }elseif ($count_rooms == 1)
                        {
                            //with 1 rooms like neighborhood
                            $items = self::querySuggestions();
                            $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                  ->where('neighborhoods.id','=',$info_house->neighborhood_id);
                            $items = $items->first();
                            $suggestions->push($items); //it push items on suggestions

                            $count_rooms = self::querySuggestions();
                            $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                            $count_rooms = $count_rooms->count();
                            if ($count_rooms == 0)
                            {
                                //without rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<=', Carbon::today());
                                $items = $items->first();
                                $suggestions->push($items); //it push items on suggestions
                            }else
                            {
                                //with 1 or more rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                                $items = $items->first();
                                $suggestions->push($items); //it push items on suggestions
                            }
                        }elseif ($count_rooms == 2)
                        {
                            //with 2 rooms like neighborhood
                            $items = self::querySuggestions();
                            $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                  ->where('neighborhoods.id','=',$info_house->neighborhood_id);
                            $items = $items->limit(2)->get();
                            foreach ($items as $item){ $suggestions->push($item);} //foreach to push items on suggestions
                        }
                    }elseif ($count_rooms == 2)
                    {
                        //with 2 room like neighboorhood and price
                        $suggestions = self::querySuggestions();
                        $suggestions->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                    ->where('neighborhoods.id','=',$info_house->neighborhood_id)
                                    ->whereBetween('rooms.price',[$info_house->price - 100000 ,$info_house->price + 100000]);
                        $suggestions = $suggestions->limit(2)->get();

                        $count_rooms = self::querySuggestions();
                        $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                     ->where('neighborhoods.id','=',$info_house->neighborhood_id);
                        $count_rooms = $count_rooms->count();
                        if ($count_rooms == 0)
                        {
                            //without rooms like neighborhood
                            $count_rooms = self::querySuggestions();
                            $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                            $count_rooms = $count_rooms->count();
                            if ($count_rooms == 0)
                            {
                                //without rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<=', Carbon::today());
                                $items = $items->first();
                                $suggestions->push($items); //it push items on suggestions
                            }else                            {
                                //with 1 or more rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                                $items = $items->first();
                                $suggestions->push($items); //it push items on suggestions
                            }
                        }else
                        {
                            //with 1 or more rooms like neighborhood
                            $items = self::querySuggestions();
                            $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                  ->where('neighborhoods.id','=',$info_house->neighborhood_id);
                            $items = $items->first();
                            $suggestions->push($items); //it push items on suggestions
                        }
                    }else
                    {
                      //with 3 or more room like neighboorhood and price
                        $suggestions = self::querySuggestions();
                        $suggestions->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                    ->where('neighborhoods.id','=',$info_house->neighborhood_id)
                                    ->whereBetween('rooms.price',[$info_house->price - 100000 ,$info_house->price + 100000]);
                        $suggestions = $suggestions->limit(3)->get();
                    }
                }else if($count_rooms  == 1)
                {
                    //with 1 rooms like neighborhood and rooms quantity and price
                    $suggestions = self::querySuggestions();
                    $suggestions->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                ->where('neighborhoods.id','=',$info_house->neighborhood_id)
                                ->whereBetween('rooms.price',[$info_house->price - 100000 ,$info_house->price + 100000])
                                ->whereBetween('houses.rooms_quantity',[$info_house->count -3,$info_house->count + 3]);
                    $suggestions = $suggestions->limit(1)->get();

                    $count_rooms = self::querySuggestions();
                    $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                 ->where('neighborhoods.id','=',$info_house->neighborhood_id)
                                 ->whereBetween('rooms.price',[$info_house->price - 100000 ,$info_house->price + 100000]);
                    $count_rooms = $count_rooms->count();
                    if ($count_rooms == 0)
                    {
                        //without rooms like neighborhood and price
                        $count_rooms = self::querySuggestions();
                        $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                     ->where('neighborhoods.id','=',$info_house->neighborhood_id);
                        $count_rooms = $count_rooms->count();
                        if ($count_rooms == 0)
                        {
                            //without rooms like neighborhood
                            $count_rooms = self::querySuggestions();
                            $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                            $count_rooms = $count_rooms->count();
                            if ($count_rooms == 0)
                            {
                                //without rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<=', Carbon::today());
                                $items = $items->limit(2)->get();
                                foreach ($items as $item){ $suggestions->push($item);} //foreach to push items on suggestions
                            }elseif ($count_rooms == 1)
                            {
                                //with 1 rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                                $items = $items->first();

                                $items2 = self::querySuggestions();
                                $items2->whereDate('rooms.available_from','<=', Carbon::today());
                                $items2 = $items2->first();

                                $suggestions->push($items); //it push items on suggestions
                                $suggestions->push($items2);
                            }else
                            {
                                //with 2 or more rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                                $items = $items->limit(2)->get();
                                foreach ($items as $item){ $suggestions->push($item);} //foreach to push items on suggestions
                            }
                        }elseif ($count_rooms == 1)
                        {
                            //with 1 rooms like neighborhood
                            $items = self::querySuggestions();
                            $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                  ->where('neighborhoods.id','=',$info_house->neighborhood_id);
                            $items = $items->first();
                            $suggestions->push($items); //it push items on suggestions

                            $count_rooms = self::querySuggestions();
                            $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                            $count_rooms = $count_rooms->count();
                            if ($count_rooms == 0)
                            {
                                //without rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<=', Carbon::today());
                                $items = $items->first();
                                $suggestions->push($items); //it push items on suggestions
                            }else
                            {
                                //with 1 or more rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                                $items = $items->first();
                                $suggestions->push($items); //it push items on suggestions
                            }
                        }else
                        {
                            //with 2 or more rooms like neighborhood
                            $items = self::querySuggestions();
                            $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                  ->where('neighborhoods.id','=',$info_house->neighborhood_id);
                            $items = $items->limit(2)->get();
                            foreach ($items as $item){ $suggestions->push($item);} //foreach to push items on suggestions
                        }
                    }elseif ($count_rooms == 1)
                    {
                        //with 1 room like neighboorhood and price
                        $items = self::querySuggestions();
                        $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                              ->where('neighborhoods.id','=',$info_house->neighborhood_id)
                              ->whereBetween('rooms.price',[$info_house->price - 100000 ,$info_house->price + 100000]);
                        $items = $items->first();
                        $suggestions->push($items); //it push items on suggestions

                        $count_rooms = self::querySuggestions();
                        $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                     ->where('neighborhoods.id','=',$info_house->neighborhood_id);
                        $count_rooms = $count_rooms->count();
                        if ($count_rooms == 0)
                        {
                            //without rooms like neighborhood
                            $count_rooms = self::querySuggestions();
                            $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                            $count_rooms = $count_rooms->count();
                            if ($count_rooms == 0)
                            {
                                //without rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<=', Carbon::today());
                                $items = $items->first();
                                $suggestions->push($items); //it push items on suggestions
                            }else
                            {
                                //with 1 or more rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                                $items = $items->first();
                                $suggestions->push($items); //it push items on suggestions
                            }
                        }elseif ($count_rooms == 1)
                        {
                            //with 1 rooms like neighborhood
                            $items = self::querySuggestions();
                            $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                  ->where('neighborhoods.id','=',$info_house->neighborhood_id);
                            $items = $items->first();
                            $suggestions->push($items); //it push items on suggestions

                            $count_rooms = self::querySuggestions();
                            $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                            $count_rooms = $count_rooms->count();
                            if ($count_rooms == 0)
                            {
                                //without rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<=', Carbon::today());
                                $items = $items->first();
                                $suggestions->push($items); //it push items on suggestions
                            }else
                            {
                                //with 1 or more rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                                $items = $items->first();
                                $suggestions->push($items); //it push items on suggestions
                            }
                        }else
                        {
                            //with 2 rooms like neighborhood
                            $items = self::querySuggestions();
                            $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                  ->where('neighborhoods.id','=',$info_house->neighborhood_id);
                            $items = $items->limit(2)->get();
                            foreach ($items as $item){ $suggestions->push($item);} //foreach to push items on suggestions
                        }
                    }else
                    {
                        //with 2 or more room like neighboorhood and price
                        $items = self::querySuggestions();
                        $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                              ->where('neighborhoods.id','=',$info_house->neighborhood_id)
                              ->whereBetween('rooms.price',[$info_house->price - 100000 ,$info_house->price + 100000]);
                        $items = $items->limit(2)->get();
                        foreach ($items as $item){ $suggestions->push($item);} //foreach to push items on suggestions
                    }
                }else if($count_rooms  == 2)
                {
                    //with 2 rooms like neighborhood and rooms quantity and price
                    $suggestions = self::querySuggestions();
                    $suggestions->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                ->where('neighborhoods.id','=',$info_house->neighborhood_id)
                                ->whereBetween('rooms.price',[$info_house->price - 100000 ,$info_house->price + 100000])
                                ->whereBetween('houses.rooms_quantity',[$info_house->count -3,$info_house->count + 3]);
                    $suggestions = $suggestions->limit(2)->get();

                    $count_rooms = self::querySuggestions();
                    $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                 ->where('neighborhoods.id','=',$info_house->neighborhood_id)
                                 ->whereBetween('rooms.price',[$info_house->price - 100000 ,$info_house->price + 100000]);
                    $count_rooms = $count_rooms->count();
                    if ($count_rooms == 0)
                    {
                        //without rooms like neighborhood and price
                        $count_rooms = self::querySuggestions();
                        $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                     ->where('neighborhoods.id','=',$info_house->neighborhood_id);
                        $count_rooms = $count_rooms->count();
                        if ($count_rooms == 0)
                        {
                            //without rooms like neighborhood
                            $count_rooms = self::querySuggestions();
                            $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                            $count_rooms = $count_rooms->count();
                            if ($count_rooms == 0)
                            {
                                //without rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<=', Carbon::today());
                                $items = $items->first();
                                $suggestions->push($items); //it push items on suggestions
                            }else
                            {
                                //with 1 or more rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                                $items = $items->first();
                                $suggestions->push($items); //it push items on suggestions
                            }
                        }else
                        {
                            //with 1 or more rooms like neighborhood
                            $items = self::querySuggestions();
                            $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                  ->where('neighborhoods.id','=',$info_house->neighborhood_id);
                            $items = $items->first();
                            $suggestions->push($items); //it push items on suggestions
                        }
                    }else
                    {
                        //with 1 or more room like neighboorhood and price
                        $items = self::querySuggestions();
                        $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                              ->where('neighborhoods.id','=',$info_house->neighborhood_id)
                              ->whereBetween('rooms.price',[$info_house->price - 100000 ,$info_house->price + 100000]);
                        $items = $items->first();
                        $suggestions->push($items); //it push items on suggestions
                    }
                }else
                {
                    //with 3 or more rooms like neighborhood and rooms quantity and price
                    $suggestions = self::querySuggestions();
                    $suggestions->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                ->where('neighborhoods.id','=',$info_house->neighborhood_id)
                                ->whereBetween('rooms.price',[$info_house->price - 100000 ,$info_house->price + 100000])
                                ->whereBetween('houses.rooms_quantity',[$info_house->count -3,$info_house->count + 3]);
                    $suggestions = $suggestions->limit(3)->get();
                }
                break;
            case 1:
                // whit 1 room in house
                $suggestions = self::querySuggestions();
                $suggestions->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                            ->where('houses.id','=',$info_house->house_id);
                $suggestions = $suggestions->limit(1)->get();

                $count_rooms = self::querySuggestions();
                $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                             ->where('neighborhoods.id','=',$info_house->neighborhood_id)
                             ->whereBetween('rooms.price',[$info_house->price - 100000 ,$info_house->price + 100000])
                             ->whereBetween('houses.rooms_quantity',[$info_house->count -3,$info_house->count + 3]);
                $count_rooms = $count_rooms->count();
                if ($count_rooms == 0)
                {
                    //without rooms like neighborhood and rooms quantity and price
                    $count_rooms = self::querySuggestions();
                    $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                 ->where('neighborhoods.id','=',$info_house->neighborhood_id)
                                 ->whereBetween('rooms.price',[$info_house->price - 100000 ,$info_house->price + 100000]);
                    $count_rooms = $count_rooms->count();
                    if ($count_rooms == 0)
                    {
                        //without rooms like neighborhood and price
                        $count_rooms = self::querySuggestions();
                        $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                     ->where('neighborhoods.id','=',$info_house->neighborhood_id);
                        $count_rooms = $count_rooms->count();
                        if ($count_rooms == 0)
                        {
                            //without rooms like neighborhood
                            $count_rooms = self::querySuggestions();
                            $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                            $count_rooms = $count_rooms->count();
                            if ($count_rooms == 0)
                            {
                                //without rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<=', Carbon::today());
                                $items = $items->limit(2)->get();
                                foreach ($items as $item) {$suggestions->push($item);}
                            }elseif ($count_rooms == 1)
                            {
                                //with 1 rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                                $items = $items->first();

                                $items2 = self::querySuggestions();
                                $items2->whereDate('rooms.available_from','<=', Carbon::today());
                                $items2 = $items2->first();

                                $suggestions->push($items); //it push items on suggestions
                                $suggestions->push($items2);
                            }else
                            {
                                //with 2 or more rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                                $items = $items->limit(2)->get();
                                foreach ($items as $item){ $suggestions->push($item);} //foreach to push items on suggestions
                            }
                        }elseif ($count_rooms == 1)
                        {
                            //with 1 rooms like neighborhood
                            $items = self::querySuggestions();
                            $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                  ->where('neighborhoods.id','=',$info_house->neighborhood_id);
                            $items = $items->first();
                            $suggestions->push($items); //it push items on suggestions

                            $count_rooms = self::querySuggestions();
                            $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                            $count_rooms = $count_rooms->count();
                            if ($count_rooms == 0)
                            {
                                //without rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<=', Carbon::today());
                                $items = $items->first();
                                $suggestions->push($items); //it push items on suggestions
                            }else
                            {
                                //with 1 or more rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                                $items = $items->first();
                                $suggestions->push($items); //it push items on suggestions
                            }
                        }else
                        {
                            //with 2 or more rooms like price
                            $items = self::querySuggestions();
                            $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                  ->where('neighborhoods.id','=',$info_house->neighborhood_id);
                            $items = $items->limit(2)->get();
                            foreach ($items as $item){ $suggestions->push($item);} //foreach to push items on suggestions
                        }
                    }elseif ($count_rooms == 1)
                    {
                        //with 1 room like neighboorhood and price
                        $items = self::querySuggestions();
                        $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                              ->where('neighborhoods.id','=',$info_house->neighborhood_id)
                             ->whereBetween('rooms.price',[$info_house->price - 100000 ,$info_house->price + 100000]);
                        $items = $items->first();
                        $suggestions->push($items); //it push items on suggestions

                        $count_rooms = self::querySuggestions();
                        $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                     ->where('neighborhoods.id','=',$info_house->neighborhood_id);
                        $count_rooms = $count_rooms->count();
                        if ($count_rooms == 0)
                        {
                            //without rooms like neighborhood
                            $count_rooms = self::querySuggestions();
                            $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                            $count_rooms = $count_rooms->count();
                            if ($count_rooms == 0)
                            {
                                //without rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<=', Carbon::today());
                                $items = $items->first();
                                $suggestions->push($items); //it push items on suggestions
                            }else
                            {
                                //with 1 or more rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                                $items = $items->first();
                                $suggestions->push($items); //it push items on suggestions
                            }
                        }else
                        {
                            //with 1 rooms like neighborhood
                            $items = self::querySuggestions();
                            $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                  ->where('neighborhoods.id','=',$info_house->neighborhood_id);
                            $items = $items->first();
                            $suggestions->push($items); //it push items on suggestions
                        }
                    }else
                    {
                        //with 2 or more room like neighboorhood and price
                        $items = self::querySuggestions();
                        $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                              ->where('neighborhoods.id','=',$info_house->neighborhood_id)
                              ->whereBetween('rooms.price',[$info_house->price - 100000 ,$info_house->price + 100000]);
                        $items = $items->limit(2)->get();
                        foreach ($items as $item){ $suggestions->push($item);} //foreach to push items on suggestions
                    }
                }else if($count_rooms  == 1)
                {
                    //with 1 rooms like neighborhood and rooms quantity and price
                    $items = self::querySuggestions();
                    $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                          ->where('neighborhoods.id','=',$info_house->neighborhood_id)
                          ->whereBetween('rooms.price',[$info_house->price - 100000 ,$info_house->price + 100000])
                          ->whereBetween('houses.rooms_quantity',[$info_house->count -3,$info_house->count + 3]);
                    $items = $items->first();
                    $suggestions->push($items); //it push items on suggestions

                    $count_rooms = self::querySuggestions();
                    $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                 ->where('neighborhoods.id','=',$info_house->neighborhood_id)
                                 ->whereBetween('rooms.price',[$info_house->price - 100000 ,$info_house->price + 100000]);
                    $count_rooms = $count_rooms->count();
                    if ($count_rooms == 0)
                    {
                        //without rooms like neighborhood and price
                        $count_rooms = self::querySuggestions();
                        $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                     ->where('neighborhoods.id','=',$info_house->neighborhood_id);
                        $count_rooms = $count_rooms->count();
                        if ($count_rooms == 0)
                        {
                            //without rooms like neighborhood
                            $count_rooms = self::querySuggestions();
                            $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                            $count_rooms = $count_rooms->count();
                            if ($count_rooms == 0)
                            {
                                //without rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<=', Carbon::today());
                                $items = $items->first();
                                $suggestions->push($items); //it push items on suggestions
                            }else
                            {
                                //with 1 or more rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                                $items = $items->first();
                                $suggestions->push($items); //it push items on suggestions
                            }
                        }else
                        {
                            //with 1 or more rooms like neighborhood
                            $items = self::querySuggestions();
                            $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                  ->where('neighborhoods.id','=',$info_house->neighborhood_id);
                            $items = $items->first();
                            $suggestions->push($items); //it push items on suggestions
                        }
                    }else
                    {
                        //with 1 or more room like neighboorhood and price
                        $items = self::querySuggestions();
                        $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                              ->where('neighborhoods.id','=',$info_house->neighborhood_id)
                              ->whereBetween('rooms.price',[$info_house->price - 100000 ,$info_house->price + 100000]);
                        $items = $items->first();
                        $suggestions->push($items); //it push items on suggestions
                    }
                }else
                {
                    //with 2 or more rooms like neighborhood and rooms quantity and price
                    $items = self::querySuggestions();
                    $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                          ->where('neighborhoods.id','=',$info_house->neighborhood_id)
                          ->whereBetween('rooms.price',[$info_house->price - 100000 ,$info_house->price + 100000])
                          ->whereBetween('houses.rooms_quantity',[$info_house->count -3,$info_house->count + 3]);
                    $items = $items->limit(2)->get();
                    foreach ($items as $item){ $suggestions->push($item);} //foreach to push items on suggestions
                }
                break;
            case 2:
                // whit 2 room in house
                $suggestions = self::querySuggestions();
                $suggestions->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                            ->where('houses.id','=',$info_house->house_id);
                $suggestions = $suggestions->limit(2)->get();

                $count_rooms = self::querySuggestions();
                $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                             ->where('neighborhoods.id','=',$info_house->neighborhood_id)
                             ->whereBetween('rooms.price',[$info_house->price - 100000 ,$info_house->price + 100000])
                             ->whereBetween('houses.rooms_quantity',[$info_house->count -3,$info_house->count + 3]);
                $count_rooms = $count_rooms->count();
                if ($count_rooms == 0)
                {
                    //without rooms like neighborhood and rooms quantity and price
                    $count_rooms = self::querySuggestions();
                    $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                ->where('neighborhoods.id','=',$info_house->neighborhood_id)
                                ->whereBetween('rooms.price',[$info_house->price - 100000 ,$info_house->price + 100000]);
                    $count_rooms = $count_rooms->count();
                    if ($count_rooms == 0)
                    {
                        //without rooms like neighborhood and price
                        $count_rooms = self::querySuggestions();
                        $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                    ->where('neighborhoods.id','=',$info_house->neighborhood_id);
                        $count_rooms = $count_rooms->count();
                        if ($count_rooms == 0)
                        {
                            //without rooms like neighborhood
                            $count_rooms = self::querySuggestions();
                            $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                            $count_rooms = $count_rooms->count();
                            if ($count_rooms == 0)
                            {
                                //without rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<=', Carbon::today());
                                $items = $items->first();
                                $suggestions->push($items); //it push items on suggestions
                            }else
                            {
                                //with 1 or more rooms like available from
                                $items = self::querySuggestions();
                                $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from);
                                $items = $items->first();
                                $suggestions->push($items); //it push items on suggestions
                            }
                        }else
                        {
                            //with 1 or more rooms like price
                            $items = self::querySuggestions();
                            $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                                  ->where('neighborhoods.id','=',$info_house->neighborhood_id);
                            $items = $items->first();
                            $suggestions->push($items); //it push items on suggestions

                        }
                    }else
                    {
                        //with 1 or more room like neighboorhood and price
                        $items = self::querySuggestions();
                        $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                              ->where('neighborhoods.id','=',$info_house->neighborhood_id)
                              ->whereBetween('rooms.price',[$info_house->price - 100000 ,$info_house->price + 100000]);
                        $items = $items->first();
                        $suggestions->push($items); //it push items on suggestions
                    }
                }else
                {
                    //with 1 or more rooms like neighborhood and rooms quantity and price
                    $items = self::querySuggestions();
                    $items->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                          ->where('neighborhoods.id','=',$info_house->neighborhood_id)
                          ->whereBetween('rooms.price',[$info_house->price - 100000 ,$info_house->price + 100000])
                          ->whereBetween('houses.rooms_quantity',[$info_house->count -3,$info_house->count + 3]);
                    $items = $items->first();
                    $suggestions->push($items); //it push items on suggestions
                }
                break;
            default:
                // whit 3 or more rooms in house
                $suggestions = self::querySuggestions();
                $suggestions->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                            ->where('houses.id','=',$info_house->house_id);
                $suggestions = $suggestions->limit(3)->get();
                break;
        }

        $count_rooms = self::querySuggestions();
        $count_rooms->whereDate('rooms.available_from','<', $bookingCurrent->date_from)
                    ->where('houses.id','=',$info_house->house_id);
        $count_rooms = $count_rooms->count(); //count of rooms in right there house

        foreach ($suggestions as $suggestion) //foreach to complete info of mail
        {
            $data_img = DB::table('rooms')->select('ih.image')
                                     ->where('rooms.id','=',$suggestion->id)
                                     ->join('houses','houses.id','=','rooms.house_id')
                                     ->join('image_houses as ih','ih.house_id','=','houses.id')
                                     ->orderBy('ih.priority')
                                     ->first(); // there find the principal image of house
            $data_dev = DB::table('devices_rooms as dr')->select('dr.bath_type','dr.windows_type')
                            ->where('dr.room_id','=',$suggestion->id)
                            ->first(); // there find the beth and windows type of room

            $suggestion->image = $data_img->image;
            $suggestion->bath = $data_dev->bath_type;
            $suggestion->windows = $data_dev->windows_type;
        }
        /*------------------------------------end suggestions----------------------------------------------------------*/

            return ['suggestions' => $suggestions,
                    'count_rooms' => $count_rooms];
    }
    public function updateDateTo(Request $request){
        $booking=Booking::firstOrFail()->where('id', '=', $request->booking_id);
        $booking->update([
            'date_to' => $request->new_date
          ]);
        return 'true';
    }
  /**
     * Redirects the authenticated user to the booking review page,
     * if the user is a manager, is redirected to the booking admin page.
     * @param int $id: Authenticated user id
     * @param int $role: Authenticated user role
     */
    public function redirectReview(int $id, int $role){
        if($role === 2){
            return redirect()->route('bookings_admin','1');
        }
        else{
            $assign = Booking::where('user_id', $id)->firstOrFail();
            $booking = $assign;
            return redirect()->route('get_user_review', $booking->id);
        }
        return redirect()->response('error', 404);
    }
    /**
     * Checks if the booking can be reviewed, this is holded by
     * the booking date_to < 2 weeks
     * @param Booking $booking: Booking to be validated
     * @return boolean true if booking can be reviewed, false otherwise
     */
    public function validateReview(Booking $booking){
        $today = Carbon::now();
        $bookingDate = Carbon::parse($booking->date_to);
        if($today->diffInWeeks($bookingDate) > 52){//Cambiar el 100 a 2***
            return false;
        }
        else{
            if($booking->status === '5' || $booking->status === '6' || $booking->status === '71' || $booking->status === '72' || $booking->status === '70'){
                return true;
            }
            else{
                return false;
            }
        }
    }

    /**
     *
     * @param User
     * @return \Illuminate\Http\Response
     */
    public function getAdminReviews(){
        if(!Auth::user()){
            return redirect('/login');
        }
        $user = Auth::user();

        $manager = Manager::where('user_id', 101)->select('id')->get();

        $managerVicos = Manager::all()[0]->houses()->get();

        $vicos = [];

        $reviewsPerHouse = [];

        $bookingsWithReviews = [];

        $reviews = [];

        foreach ($managerVicos as $vico) {
            array_push($vicos, $vico);
        }

        foreach ($vicos as $vico) {
            foreach ($vico->rooms as $room) {
                $bookings = $room->bookings->whereIn('status', [6, 70, 71, 72]);
                foreach ($bookings as $booking) {
                    if (Booking::find($booking->id)->qualificationHouses) {
                        array_push($bookingsWithReviews, $booking);
                    }
                }
            }
        }

        $reviewCollection = [];

        foreach ($bookingsWithReviews as $review) {
            $reviewCollection[$review->id] = [
                'house_id'      =>  Booking::find($review->id)->room->house->id,
                'reviewHouse'   =>  Booking::find($review->id)->qualificationHouses,
                'reviewRoom'    =>  Booking::find($review->id)->qualificationRooms,
                'reviewNeighborhoods' => Booking::find($review->id)->qualificationNeighborhoods,
                'reviewManager' =>  Booking::find($review->id)->qualificationUsers
            ];
        }
        $reviews = collect($reviewCollection)->groupBy('house_id');

        return view('reviews.index', [
            'reviews' =>    $reviews
        ]);
    }

    /**
    * Complain Methods
    */
    public function userComplain(Request $request){
        dd($request);
        $request->validate([
            'manager_comment' => 'required',
            'fom_comment' => 'required',
            'manager_comunication' => 'required',
            'manager_compromise' => 'required',
            'bookings_id' => 'required',
            '_token' => 'required',
            'complainText' => 'required',
            'qualification_date' => 'required',
            'email' => 'required',
            'today_date' => 'required',
        ]);
    }

    public function bookingComplain(Request $request){
        dd($request);
        $request->validate([
            'message' => 'required',
            'status' => 'required',
            'room_id' => 'required',
            'booking_date' => 'required',
            '_token' => 'required',
            'complainText' => 'required',
            'email' => 'required',
            'today_date' => 'required',
        ]);
    }

    public function confirmedBookingsCsv(){

        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
        ,   'Content-type'        => 'text/csv'
        ,   'Content-Disposition' => 'attachment; filename=galleries.csv'
        ,   'Expires'             => '0'
        ,   'Pragma'              => 'public'
        ];

        $list = DB::select(DB::raw("Select B.id, CONVERT(B.status USING utf8), B.date_from, B.date_to, R.price, M.Vip, M.user_id as Manager_user_id from FOMDB.bookings B inner join FOMDB.rooms R on R.id = B.room_id inner join FOMDB.houses H on H.id = R.house_id inner join FOMDB.managers M on H.manager_id = M.id where B.status in ('5','6','70','71','72','73')"));
        foreach ($list as $key => $item) {
            $new_list[$key] = (array)$item;
        }

        array_unshift($new_list, array_keys($new_list[0]));
        $callback = function() use ($new_list) 
        {
            $FH = fopen('php://output', 'w');
            foreach ($new_list as $row) { 
                fputcsv($FH, $row);
            }
            fclose($FH);
        };
        
        return response()->streamDownload($callback, 200, $headers);
    }

}
