<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Country;

class CityController extends Controller
{

    public function getAvailableCities(){
        $countries = Country::with(['cities'=> function($query){    
                        $query->where('available',1);
                    }])->whereHas('cities',function($query){
                        $query->where('available',1);
                    })->get();

        return response()->json($countries, 200);
    }

}