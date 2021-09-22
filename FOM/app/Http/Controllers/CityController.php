<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\City\CreateCityRequest;
use App\Http\Requests\City\UpdateCityRequest;
use App\City;
use App\Country;
use \Session;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::all();
        $countries = Country::orderBy('name', 'asc')->get();
        return view('cities.index',
            [
                'cities' => $cities,
                'countries' =>  $countries
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::orderBy('name', 'asc')->get();
        return view('cities.create',
            [
                'countries' =>  $countries
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCityRequest $request)
    {
        $city = new City;
        $city->name = $request->input('name');
        $city->city_code = $request->input('city_code');
        $city->country_id = $request->input('country_id');
        $city->available = $request->input('available');
        $city->save();

        return redirect()->route('city.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $city = City::find($id);
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
    public function update( UpdateCityRequest $request, City $city)
    {
        $city->name = $request->input('name');
        $city->city_code = $request->input('city_code');
        $city->country_id = $request->input('country_id');
        $city->available = $request->input('available');
        $city->save();

        return redirect()->route('city.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $city->delete();

        return redirect()->route('city.index');
    }

    public function getCity()
    {
        if (Session::has('city_code')) {
            $city_code = Session::get('city_code');
            $city = City::where('city_code', $city_code)->get();

        } else {
            $city = City::where('city_code', 'MDE')->get();
        }
        return response()->json($city, 201);
    }
}
