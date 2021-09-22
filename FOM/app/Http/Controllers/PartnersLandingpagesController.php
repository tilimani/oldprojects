<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\House;
use App\School;

class PartnersLandingpagesController extends Controller
{
    public function landingUnal(){
        $school = School::with('neighborhoods')->where('id',32)->get();
        $favorite_houses = House::with('imageHouses','coordinates','neighborhood')->findMany([12, 12, 12]);
        $neighborhoods = $school[0]->neighborhoods->where('id','>',300);
        $neighborhood_ids = []; 
        foreach ($neighborhoods as $key => $neighborhood_id){
            $neighborhood_ids[$key] = $neighborhood_id->id;
        }
        $houses = House::whereIn('neighborhood_id',$neighborhood_ids)->where('status',1)->with('coordinates')->get();
        foreach ($houses as $key => $house) {
            $houses[$key]->min_price = $house->minPrice();
        }
        return view('landingunal',[
            'favorite_houses'=>$favorite_houses,
            'houses'=>$houses,
            'school'=>$school[0]
        ]);
    }
}
