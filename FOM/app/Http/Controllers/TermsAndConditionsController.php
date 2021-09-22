<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\User;
use App\Country;
use App\Booking;
use App\Currency;
use App\Room;
use App\PaymentWithVICO as Payments; //delete later
use App\TermsAndConditionsVersion;
use App\UserTermsAndConditions;
use Session;
use Hash;
use Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SegmentController as Analytics;
class TermsAndConditionsController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        //Create a new terms and conditions accpeted hash in database
        //IMPORTANT: as well found in the RegisterController
        $current_version=TermsAndConditionsVersion::orderby('created_at', 'desc')->first();
        $user_tac=new UserTermsAndConditions();
        $user_tac->user_id=Auth::user()->id;
        $user_tac->tac_id=$current_version->id;
        $user_tac->date_acceptation=Carbon::now();
        $user_tac->differentiator=Session::get('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d');
        $user_tac->hash=Hash::make($user_tac->user_id.$user_tac->differentiator.$user_tac->date_acceptation);
        $user_tac->save();
        
        // termsandconditions: missing to ecreate a condition in the user itself to have him accepted the terms and conditions but in the user table to make it faster.
        $user=User::firstOrFail()->where('id','=',Auth::user()->id);
        $user->update([
            // 'provider' => Carbon::now(),
            // 'updated_at' => Carbon::now()
        ]);
        return 'done';
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createNewVersion(){
        return view('termsandconditions.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeNewVersion(Request $request)
    {
        $request->validate([
            'version'=>'required|unique:terms_and_conditions_versions',
          ]);

        $newVersion = new TermsAndConditionsVersion([
            'version'=> $request->get('version'),
          ]);

        $newVersion->save();
        return back()->with('message_sent', 'Version has been created');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showLastVersion($id)
    {
        $termsandconditions = TermsAndConditionsVersion::orderby('created_at', 'desc')->first();
        return view('termsandconditions.version'.$termsandconditions->version, [
              'termsandconditions' => $termsandconditions
                ]);
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

    public function updateTermsAndConditionsUser(){
       //Check if the user has already accepted the last terms and conditions
        $last_version=TermsAndConditionsVersion::orderby('created_at', 'desc')->firstOrFail();
        $user=Auth::user();
        $matchThese = ['tac_id' => $last_version->id, 'user_id' => $user->id];
        if(UserTermsAndConditions::where($matchThese)->first()){
            return '0';
        }
        return '1';
    }


    /**
     * This function generates a PDF download with all the payment's information
     *
     * @param [type] $id
     * @return void
     */
    public function downloadContractPDF($id)
    {
        $booking = Booking::find($id);
        $user = $booking->user()->first();
        $room = $booking->room()->first();
        $house = $room->house()->first();
        $manager = $booking->manager();
        $rules = $house->rules()->get();
        $currency = new Currency();
        $currency = $currency->getCurrentCurrency();
        $rules = DB::table('houses_rules')
            ->select('houses_rules.description','rules.name','rules.icon','rules.icon_span')
            ->join('rules', 'rules.id', '=', 'houses_rules.rule_id')
            ->where('houses_rules.house_id', '=', $house->id)->distinct()
            ->orderBy('rules.icon')
            ->get(); // Inicializar reglas de la casa

        // dd($rules);
        $data = [
            'house'=>$house,
            'rules'=>$rules,
            'location'=>$house->address,
            'booking'=>$booking,
            'room'      => $room,
            'room_count'      => $house->rooms()->count(),
            'bathroom_count'      => $house->baths_quantity,
            'user'      => $user,
            'manager'   => $manager,
            'currency' => $currency
        ];
        $pdf = \PDF::loadView(
            'termsandconditions.contract._contractPDF',
            [
                'data'=>$data
            ]
        )->save('confirmation.pdf');
        
        // SEGMENT TRACKING INIT-------------------
        if (env('APP_ENV')=='production' && Auth::user()->role_id!=1) {
        
            Analytics::contractDownloaded($booking, Auth::user());

        }
        // SEGMENT TRACKING END-------------------

        return $pdf->download($house->name.' #'.$room->number.' & '.$user->name.'.pdf');
    }
}
