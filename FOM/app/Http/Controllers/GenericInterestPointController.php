<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GenericInterestPoint;
use App\Http\Requests\GenericInterestPoint\CreateGenericInterestPointRequest;
use App\Http\Requests\GenericInterestPoint\UpdateGenericInterestPointRequest;
use App\House;

class GenericInterestPointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $interest_points = GenericInterestPoint::all();
        return view(
            'genericInterestPoints.index',
            [
                'interest_points' =>  $interest_points
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
        return view('genericInterestPoints.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateGenericInterestPointRequest $request)
    {
        for ($i = 0; $i < 3; $i++){
            $genericInterestPoint = new GenericInterestPoint();
            $genericInterestPoint->name = $request->input('name');
            $genericInterestPoint->description = 5 * ($i + 1);

            $genericInterestPoint->save();
        }

        return redirect()->route('genericInterestPoints.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //NO SE USA
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //NO SE USA
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGenericInterestPointRequest $request,GenericInterestPoint $genericInterestPoint)
    {
        $genericInterestPoint->name = $request->input('name');
        $genericInterestPoint->description = $request->input('description');
        $genericInterestPoint->save();

        return redirect()->route('genericInterestPoints.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(GenericInterestPoint $genericInterestPoint)
    {
        $genericInterestPoint->delete();

        return redirect()->route('genericInterestPoints.index');
    }

    public function getHouse(House $house)
    {
        $genericInterestPoints = GenericInterestPoint::all();
        $houseGenericInterestPoints = $house->genericInterestPoints()->get();
        $genericInterestPoints
            = $genericInterestPoints->diff($houseGenericInterestPoints);

        return view(
            'genericInterestPoints.house', [
                'genericInterestPoints'  =>  $genericInterestPoints,
                'houseGenericInterestPoints'  =>  $houseGenericInterestPoints,
                'house' =>  $house
            ]
        );
    }

    public function storeHouse(Request $request, House $house)
    {
        if (null === $request->input('inputchecked')) {
            $house->genericInterestPoints()->detach();
        } else if (null !== $request->input('inputchecked')) {

            $houseGenericInterestPoints
                = $house->genericInterestPoints()->select('interestable_id')->get();
            $houseGenericInterestPointsArray = [];


            foreach ($houseGenericInterestPoints as $interestPoint) {
                array_push(
                    $houseGenericInterestPointsArray,
                    strval($interestPoint->interestable_id)
                );
            }
            $delete = array_diff(
                $houseGenericInterestPointsArray,
                $request->input('inputchecked')
            );

            foreach ($delete as $id) {
                $genericInterestPoint = GenericInterestPoint::find($id);
                $house->genericInterestPoints()->detach($genericInterestPoint);
            }
        }

        if (null !== $request->input('inputunchecked')) {

            $add = $request->input('inputunchecked');

            foreach ($add as $id) {
                $genericInterestPoint = GenericInterestPoint::find($id);
                $house->genericInterestPoints()->attach($genericInterestPoint);
            }
        }

        return redirect()->route('genericInterestPoint.house.create', $house);
    }
}
