@extends('layouts.app')

@section('title', 'My historial de pagos')
@section('content')
    @if(Auth::check())
        <div id="react-payments" data-connection={{__($user->id.",".$user->role_id)}}></div>
    @else
        <div id="react-payments-test"></div>
    @endif
@endsection