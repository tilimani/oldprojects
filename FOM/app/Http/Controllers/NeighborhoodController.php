<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Neighborhood;
use App\Location;
use App\Zone;
use App\Http\Requests\Neighborhood\CreateNeighborhoodRequest;
use App\Http\Requests\Neighborhood\UpdateNeighborhoodRequest;

class NeighborhoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $neighborhoods = Neighborhood::all();
        $locations = Location::orderBy('name', 'asc')->get();
        return view(
            'neighborhoods.index',
            [
                'neighborhoods' =>  $neighborhoods,
                'locations' =>  $locations,
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
        $locations = Location::orderBy('name', 'asc')->get();
        return view(
            'neighborhoods.create',
            [
                'locations' =>  $locations,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateNeighborhoodRequest $request)
    {
        $neighborhood = new Neighborhood;
        $neighborhood->name = $request->input('name');
        $neighborhood->location_id = $request->input('location_id');        
        $neighborhood->save();

        return redirect()->route('neighborhood.index');



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(UpdateNeighborhoodRequest $request, Neighborhood $neighborhood)
    {
        $neighborhood->name = $request->input('name');
        $neighborhood->location_id = $request->input('location_id');
        $neighborhood->zone_id = $request->input('zone_id');
        $neighborhood->save();

        return redirect()->route('neighborhood.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Neighborhood $neighborhood)
    {
        $neighborhood->delete();

        return redirect()->route('neighborhood.index');
    }
}
