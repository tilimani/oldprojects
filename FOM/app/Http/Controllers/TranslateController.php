<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Translate\TranslateClient;

class TranslateController extends Controller
{
    public function translateText(Request $request)
    {        
        $config = [
            'key' => 'AIzaSyBZ0XewfPCqZ_iqFZUtxdUortSkpuYY7ho',
            'target' => $request->targetInfo,    
            'source' => $request->sourceInfo        
        ];
        

        $translate = new TranslateClient($config);
        $textInfo = $request->textInfo;    

        if (isset($textInfo)) {
            $translation = $translate->translate($textInfo);        
                return response()->json([
                    'text' =>    $translation['text']
                ]);
        } else {
            return response()->json([
                'text'  =>  'not defined yet'
            ]);
        }
    }
}
