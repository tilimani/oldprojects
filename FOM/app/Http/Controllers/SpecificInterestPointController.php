<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use App\Http\Requests\SpecificInterestPoint\CreateSpecificInterestPointRequest;
use App\SpecificInterestPoint;
use App\Http\Requests\SpecificInterestPoint\UpdateSpecificInterestPointRequest;
use App\House;

class SpecificInterestPointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::all();
        $interest_points = SpecificInterestPoint::all();
        return view('specificInterestPoints.index',[
            'cities' => $cities,
            'interest_points' => $interest_points
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::all();
        return view('specificInterestPoints.create',[
            'cities' => $cities,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSpecificInterestPointRequest $request)
    {
        for ($i = 0; $i < 3; $i++) {
            $specific_interest_point = new SpecificInterestPoint;
            $specific_interest_point->name = $request->input('name');
            $specific_interest_point->description = 5 * ($i + 1);
            $specific_interest_point->save();
        }
        return redirect()->route('specificInterestPoints.index');
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
    public function update(UpdateSpecificInterestPointRequest $request, $id)
    {
        $specific_interest_point = SpecificInterestPoint::find($id);
        $specific_interest_point->name = $request->input('name');
        $specific_interest_point->description = $request->input('description');
        $specific_interest_point->save();

        return redirect()->route('specificInterestPoints.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $specific_interest_point = SpecificInterestPoint::find($id);
        $specific_interest_point->delete();

        return redirect()->route('specificInterestPoints.index');
    }

    public function getHouse(House $house)
    {
        $specificInterestPoints = SpecificInterestPoint::all();
        $houseSpecificInterestPoints = $house->specificInterestPoints()->get();

        $specificInterestPoints
            = $specificInterestPoints->diff($houseSpecificInterestPoints);

        return view(
            'specificInterestPoints.house', [
                'specificInterestPoints'  =>  $specificInterestPoints,
                'houseSpecificInterestPoints'  =>  $houseSpecificInterestPoints,
                'house' =>  $house
            ]
        );
    }

    public function storeHouse(Request $request, House $house)
    {
        if (null === $request->input('inputchecked')) {
            $house->specificInterestPoints()->detach();
        } else if (null !== $request->input('inputchecked')) {

            $houseSpecificInterestPoints
                = $house->specificInterestPoints()->select('interestable_id')->get();
            $houseSpecificInterestPointsArray = [];


            foreach ($houseSpecificInterestPoints as $interestPoint) {
                array_push(
                    $houseSpecificInterestPointsArray,
                    strval($interestPoint->interestable_id)
                );
            }
            $delete = array_diff(
                $houseSpecificInterestPointsArray,
                $request->input('inputchecked')
            );

            foreach ($delete as $id) {
                $specificInterestPoint = SpecificInterestPoint::find($id);
                $house->specificInterestPoints()->detach($specificInterestPoint);
            }
        }

        if (null !== $request->input('inputunchecked')) {

            $add = $request->input('inputunchecked');

            foreach ($add as $id) {
                $specificInterestPoint = SpecificInterestPoint::find($id);
                $house->specificInterestPoints()->attach($specificInterestPoint);
            }
        }

        return redirect()->route('specificInterestPoint.house.create', $house);
    }
    public function getCity(City $city)
    {
        $specificInterestPoints = SpecificInterestPoint::all();
        $citySpecificInterestPoints = $city->specificInterestPoints()->get();

        $specificInterestPoints
            = $specificInterestPoints->diff($citySpecificInterestPoints);

        return view(
            'specificInterestPoints.city', [
                'specificInterestPoints'  =>  $specificInterestPoints,
                'citySpecificInterestPoints'  =>  $citySpecificInterestPoints,
                'city' =>  $city
            ]
        );
    }

    public function storeCity(Request $request, City $city)
    {
        if (null === $request->input('inputchecked')) {
            $city->specificInterestPoints()->detach();
        } else if (null !== $request->input('inputchecked')) {

            $citySpecificInterestPoints
                = $city->specificInterestPoints()
                    ->select('specific_interest_point_id')
                    ->get();
            $citySpecificInterestPointsArray = [];


            foreach ($citySpecificInterestPoints as $interestPoint) {
                array_push(
                    $citySpecificInterestPointsArray,
                    strval($interestPoint->specific_interest_point_id)
                );
            }
            $delete = array_diff(
                $citySpecificInterestPointsArray,
                $request->input('inputchecked')
            );

            foreach ($delete as $id) {
                $specificInterestPoint = SpecificInterestPoint::find($id);
                $city->specificInterestPoints()->detach($specificInterestPoint);
            }
        }

        if (null !== $request->input('inputunchecked')) {

            $add = $request->input('inputunchecked');

            foreach ($add as $id) {
                $specificInterestPoint = SpecificInterestPoint::find($id);
                $city->specificInterestPoints()->attach($specificInterestPoint);
            }
        }

        return redirect()->route('specificInterestPoint.city.create', $city);
    }
}
