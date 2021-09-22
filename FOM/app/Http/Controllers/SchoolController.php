<?php

namespace App\Http\Controllers;

use App\School;
use Illuminate\Http\Request;
use App\Http\Requests\School\CreateSchoolRequest;
use App\Http\Requests\School\UpdateSchoolRequest;
use App\Neighborhood;
use App\Http\Requests\School\CreateNeighborhoodSchoolRequest;
use App\NeighborhoodSchool;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schools = School::all();

        return view('schools.index')->with(compact('schools'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('schools.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSchoolRequest $request)
    {
        $school = new School;
        $school->name = $request->input('name');
        $school->prefix = $request->input('prefix');
        $school->lat = $request->input('lat');
        $school->lng = $request->input('lng');
        $school->save();

        return redirect()->route('school.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
    public function update(UpdateSchoolRequest $request, School $school)
    {
        $school->name = $request->input('name');
        $school->prefix = $request->input('prefix');
        $school->lat = $request->input('lat');
        $school->lng = $request->input('lng');
        $school->save();

        return redirect()->route('school.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(School $school)
    {
        $school->delete();

        return redirect()->route('school.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexjson()
    {
        return response()->json(School::all()->sortBy('name'));
    }

    public function createNeighborhoodSchool(School $school)
    {
        $neighborhoods = Neighborhood::orderBy('name', 'asc')->get();
        $neighborhoodSchools = $school->neighborhoods()->get();

        $intersection = $neighborhoods->diff($neighborhoodSchools);

        return view(
            'schools.createNeighborhoodSchool',
            [
                'neighborhoods' => $intersection,
                'neighborhoodSchools'=> $neighborhoodSchools,
                'school'    =>  $school
            ]
        );
    }

    public function storeNeighborhoodSchool(Request $request, School $school)
    {
        if (null === $request->input('inputchecked')) {
            $school->neighborhoods()->detach();
        } else if (null !== $request->input('inputchecked')) {
            //Save many to many neighborhood_schools relation
            $neighborhoodsSchools
                = $school->neighborhoods()->select('neighborhood_id')->get();
            $neighborhoodsSchoolsArray = [];

            foreach ($neighborhoodsSchools as $neighborhood) {
                array_push(
                    $neighborhoodsSchoolsArray,
                    strval($neighborhood->neighborhood_id)
                );
            }
            //Delete old relations
            $delete = array_diff(
                $neighborhoodsSchoolsArray,
                $request->input('inputchecked')
            );

            foreach ($delete as $id) {
                $neighborhood = Neighborhood::find($id);
                $school->neighborhoods()->detach($neighborhood);
            }
        }

        if (null !== $request->input('inputunchecked')) {
            $add = $request->input('inputunchecked');

            foreach ($add as $id) {
                $neighborhood = Neighborhood::find($id);
                $school->neighborhoods()->attach($neighborhood);
            }
        }


        return redirect()->route('neighborhood.school.create', $school);
    }
}
