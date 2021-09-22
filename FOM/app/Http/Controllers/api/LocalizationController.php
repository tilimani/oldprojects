<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class LocalizationController extends Controller
{
    public function getLocalization(Request $request)
    {
        $data = trans(strval($request->fileName),[],$request->lang);
        return response()->json($data,200);
    }
    
}
