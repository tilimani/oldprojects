@extends('layouts.app')

@section('title', 'Aceptar Invitacion')

@section('content')
    <div id="react-showInvitation" data-connection={{$invitation_id.','.Auth::check().','.$user_id}}></div>
@endsection
