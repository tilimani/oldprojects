<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\City;
use App\Neighborhood;

class NeighborhoodController extends Controller
{
    public function indexCity($city_name)
    {
        $city = City::where('name', $city_name)->first();
        $neighborhoods = Neighborhood::whereHas('location.zone.city', function($query) use ($city) {
            $query->where('id',$city->id);
        })->orderBy('name', 'asc')->get();

        return response()->json([
            'neighborhoods'=> $neighborhoods
        ], 200);
    }
}
