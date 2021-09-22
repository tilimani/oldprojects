<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\City;
use App\Country;
use Illuminate\Support\Facades\Auth;
use App\VicoReferral;
use App\Jobs\GenerateReferralCode;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        
        $city_code = Session::has('city_code') ? Session::get('city_code') : 'MDE';
        $city = City::where('city_code',$city_code)->first();
        $countries = Country::with(['cities'=> function($query){
            $query->where('available',1);
        }])->whereHas('cities',function($query){
            $query->where('available',1);
        })->get();

        $user = Auth::user();

        $showNPSModal = false;
        
        // VICO Net Promoter Score Modal Trigger opens in the Landing Page
        // if user exists
        if ($user){
            // if they have an active booking and not manager
            if(!$user->isManager()){
                // Has bookings active
                if($user->bookingsActive()->exists()){
                    // Last rating not null
                    if (!is_null($user->UserRatings->last())){
                        $ratevico = $user->UserRatings->last()->updated_at;
                        // If asked in last month
                        if(strtotime($ratevico) > strtotime('-30 days')) {$showNPSModal = false;}
                        else {$showNPSModal = true;}
                    }
                    else {
                        $showNPSModal = true;
                    }
                }
                else {$showNPSModal = true;}
            }
            // if manager
            else {

                if ($user->managerActiveBookings()){
                    if (!is_null($user->UserRatings->last())){
                        $ratevico = $user->UserRatings->last()->updated_at;
                        if(strtotime($ratevico) > strtotime('-30 days')) {$showNPSModal = false;}
                        else {$showNPSModal = true;}
                    } 
                    else {
                        $showNPSModal = true;
                    }
                }
            }
        }
        
       
        return view('landingpage',[
            'city' => $city,
            'countries'=>$countries,
            'showNPSModal'=>$showNPSModal
        ]);
    }

    public function about()
    {
        return view('about.index');
    }

    public function bogota()
    {
        return view('landingpages.cities.bogota');
    }
}
