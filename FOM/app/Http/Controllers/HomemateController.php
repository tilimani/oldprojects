<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Homemate;
use App\Country;
use App\House;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HomemateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id_house)
    {
        $house = House::where('id', '=', $id_house)->firstOrFail();
        // $houses = DB::table('houses')->select('houses.name', 'houses.id')->get();
        // dd($house);

        return view('homemate.create', [
            'id' => $house->id,
            'name' => $house->name,
            'nationalities' => Country::all()->sortBy('name')
        ]);
        // return redirect('/houses/edit', $id_house);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);

        // $request->validate([
        //     'name' => 'required|max:128',
        //     'profession' => 'required|max:64',
        //     'house_id' => 'required',
        //     'nationality_id' => 'required',
        //     'genre' => 'required|max:1'
        // ]);

        $room = Room::where('house_id', '=', $request->house_id)->select('id')->firstOrFail(); 

        try {

            $homemate = new Homemate;
            $homemate->name = $request->name;
            $homemate->profession = $request->profession;
            $homemate->room_id = $room->id;
            $homemate->country_id = $request->nationality;
            $homemate->gender = $request->genre;
            $homemate->save();

        } 
        catch (\PDOException $e) {
            DB::rollBack();
            dd($e);
        }

        return back();
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
