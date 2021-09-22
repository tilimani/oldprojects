<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\House;


class SitemapController extends Controller
{
    public function index()
    {
      $house = House::where('status', '=', 1)->orderBy('updated_at', 'desc')->first();

      return response()->view('sitemap.index', [
          'house' => $house,
      ])->header('Content-Type', 'text/xml');
    }


    public function information()
    {
    	$house = House::where('status', '=', 1)->orderBy('updated_at', 'desc')->first();

    	return response()->view('sitemap.information', [
    	    'house' => $house,
    	])->header('Content-Type', 'text/xml');
    }

    public function houses()
    {
    	$houses = House::where('status', '=', 1)->get();

      return response()->view('sitemap.houses', [
          'houses' => $houses,
      ])->header('Content-Type', 'text/xml');
    }
}
