<?php

namespace App\Http\Controllers;

use App\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    public function show($invitation_id){
        if(Auth::check()){
            $user_id = Auth::user()->id;
        }else{
            $user_id = null;
        }
        return view('invitations.show',[
            'invitation_id' => $invitation_id,
            'user_id' => $user_id,
        ]);
    }

    public function create(){
        return view('invitations.send');
    }
}
