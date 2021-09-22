<?php

namespace App\Http\Controllers;

use App\Zone;
use Illuminate\Http\Request;
use App\Http\Requests\Zone\CreateZoneRequest;
use App\Http\Requests\Zone\UpdateZoneRequest;
use App\Http\Requests\Zone\CreateHouseZoneRequest;
use App\Http\Requests\Zone\CreateNeighborhoodZoneRequest;
use App\House;
use App\Neighborhood;
use App\City;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $zones = Zone::all();
        $cities = City::all();
        return view('zones.index',
            [
                'zones' =>  $zones,
                'cities'    =>  $cities
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
        $cities = City::orderBy('name', 'asc')->get();
        return view(
            'zones.create',
            [
                'cities' => $cities
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Zone\CreateHouseZoneRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateZoneRequest $request)
    {
        $zone = new Zone;
        $zone->name = $request->input('name');
        $zone->city_id = $request->input('city_id');
        $zone->save();

        return redirect()->route('zone.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function show(Zone $zone)
    {
        return redirect('back');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function edit(Zone $zone)
    {
        return redirect('back');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateZoneRequest $request, Zone $zone)
    {
        $zone->name = $request->input('name');
        $zone->save();
        return redirect()->route('zone.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zone $zone)
    {
        $zone->delete();
        return redirect()->route('zone.index');
    }

}
