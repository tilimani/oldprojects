<?php
    // WARNING: ALL CODE HERE COULD BE DELETED

namespace App\Http\Controllers;

use App\ApiMessage;
use App\Booking;
use App\Message;
use App\Room;
use App\House;
use App\Manager;
use Illuminate\Http\Request;
use App\Events\BookingWasChanged;
use App\Events\BookingWasSuccessful;
use App\Events\MessageWasSended;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\PaymentWithVICO as Payments;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use App\User;
use App\Country;
use App\Neighborhood;
use App\Location;
use App\Verification;
use App\City;
use App\TermsAndConditionsVersion;
use App\UserTermsAndConditions;
use App\InterestPoint;
use App\School;
use \Session;
use \Cache;
use App\SatusUpdate;
use Hash;
use Mail;
use App\Mail\UserDenied;
use App\Mail\EmailValidation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\TwilioController;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\AlertController;
use Stripe\Stripe;
use App\Bill;
use App\Currency;
use Stripe\Customer;
use App\Notifications\EndStay;
use App\Notifications\ReviewDone;
use App\Notifications\RememberReview;
use App\Notifications\MessageSend;
use App\Notifications\NewRequest;
use App\Notifications\BookingUpdateUser;
use App\Notifications\BookingUpdateManager;
use App\Events\MessageWasReceived;
use App\Notifications\BookingNotification;
use App\Notifications\SixWeeksBeforeEnd;
use App\Notifications\WeeklyPaymentReminder;
use App\Notifications\ChangeDate;
use App\Notifications\Welcome;
use App\Notifications\ManagerWithoutVico;
use App\Notifications\RegisteredVico;
use App\Notifications\RegisteredVicoNotifier;
use App\Notifications\Photoshoot;
use App\Notifications\PostedPhotos;
use App\Notifications\PostedVico;
use App\Notifications\VicoWithoutBookings;
use App\Notifications\TwoDaysBeforeArrival;
use App\Notifications\SevenDaysAfterArrival;

use \SendGrid\Mail\Mail as GridMail;
use \SendGrid\Mail\From as From;
use \SendGrid\Mail\To as To;
use \SendGrid\Mail\Subject as Subject;
use \SendGrid\Mail\PlainTextContent as PlainTextContent;
use \SendGrid\Mail\HtmlContent as HtmlContent;
use \SendGrid\Mail\Personalization as Personalization;
use App\PaymentWithVICO;
use Barryvdh\DomPDF\PDF;
use App\Jobs\NotifyPendingPayments;
use App\Notifications\WeeklyNewActiveBookings;
use Illuminate\Pagination\Paginator;
use Twilio\Rest\Client as TwilioClient;
use App\VicoReferral;
use Illuminate\Database\Eloquent\Collection as Collection;
use App\Jobs\BookingPolice;
use App\Jobs\ReviewPolice;
use App\Jobs\ManagerPolice;
use App\Jobs\WeeklyReminderForManager;

use App\Notifications\PasswordChanged;
use App\Jobs\GenerateReferralCode;
use App\Coordinate;
use App\Invitation;
use App\Notifications\BookingInvitation;
use PHPUnit\Util\Json;

use function GuzzleHttp\json_decode;
use Segment as Analytics;

class TestController extends Controller // <---- IMPORTANT THE CHANGE ON EXTENDS
{
    // this controller was make for Testing whit thml and news bildings anwith of build a new branch into git
    // WARNING: ALL CODE HERE COULD BE DELETED

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('test');
    }

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

    public function findThreeClosestHouses($houses_distances, $wildcard_for_store_values)
    {
        if (($key = array_search(min($houses_distances), $houses_distances)) !== false) {
            array_push($wildcard_for_store_values, $key);
            unset($houses_distances[$key]);
        }

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

        $qualification_users = [];

        $reviews_house = DB::table('average_houses')
        ->where('house_id', '=', $house->id)
        ->get();
        $reviews_neighborhood = DB::table('average_neighborhoods')
        ->where('neighborhood_id', '=', $house->neighborhood_id)
        ->get();



        $generic_interest_points = $house->genericInterestPoints;
        $specific_interest_points = $house->specificInterestPoints;

        return view('test', [
            'house' => $house,
            'room' => $room,
            'today' => Carbon::now(),
            'today_30' => Carbon::now()->addWeeks(4),
            'neighborhood' => $neighborhood,
            'countries' => Country::all()->sortBy('name'),
            'reviews_house' => $reviews_house,
            'reviews_neighborhood' => $reviews_neighborhood,
            'qualification_users' => $qualification_users,
            'interestPoints' => $interestPoints,
            'schools' => $schools,
            'generic_interest_points' => $generic_interest_points,
            'specific_interest_points' => $specific_interest_points,
        ])->with(compact('neighborhood'));
    }

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    // WARNING: ALL CODE HERE COULD BE DELETED
    }

    // WARNING: ALL CODE HERE COULD BE DELETED

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($encrypted)
    {
    // WARNING: ALL CODE HERE COULD BE DELETED
        $decrypted = Crypt::decryptString($encrypted);
        return "unsuscribe:".$decrypted;
    }
    // WARNING: ALL CODE HERE COULD BE DELETED

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    // WARNING: ALL CODE HERE COULD BE DELETED
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // WARNING: ALL CODE HERE COULD BE DELETED
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     // WARNING: ALL CODE HERE COULD BE DELETED
    // }
    // // WARNING: ALL CODE HERE COULD BE DELETED


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    // WARNING: ALL CODE HERE COULD BE DELETED
    }

    // WARNING: ALL CODE HERE COULD BE DELETED

    public function userExists(string $mail){
        // WARNING: ALL CODE HERE COULD BE DELETED

        $user=DB::table('users')->where('email','=',$mail)->get();
        if(isset($user[0])){
            if($user[0]->externalAccount == 1){
                return 1;
            }
            else{
                return 2;
            }
        }
        else{
            return 0;
        }
    }

    public function getCoordinatesHouse($school_id){
        $coordinates=School::where('id','=',$school_id)->first();
        return [$coordinates];
    }

    public function updateNeigborhoods($school_id,$neighborhood,$city,$country){
        // dd($neighborhood);
        $school=InterestPoint::where('id','=',$school_id)->first();
        $country=Country::where('name','=',$country)->first();
        $tempcity=$city;
        $city=City::firstOrNew(['name' => $tempcity,'country_id' => $country->id])->save();
        $city=City::where('name','=',$tempcity)->first();
        $location=Location::firstOrNew(['name' => $neighborhood,'city_id' => $city->id])->save();
        $location=Location::where('name','=',$neighborhood)->first();
        $neighborhood=Neighborhood::firstOrNew(['name' => $location->name,'location_id' => $location->id])->save();
        $neighborhood=Neighborhood::where('name','=',$location->name)->first();
        $relations=DB::table('neighborhood_schools')->where('neighborhood_id','=',$neighborhood->id)->where('school_id','=',$school->id)->get();
        // return $relations;
        if (sizeof($relations) < 1) {
            DB::beginTransaction();
            DB::table('neighborhood_schools')->insert(
                ['neighborhood_id' => $neighborhood->id, 'school_id' => $school->id]
            );
            DB::commit();
        }
        return 'actualizado universidad '.$school->id;
    }
}
