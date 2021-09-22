@extends('layouts.app')
@section('title', 'FOM Admin')
@section('content')
@if (Auth::user() && Auth::user()->role_id === 1)

    <div class="jumbotron">
        <h1 class="display-4">Ultimas solicitudes.</h1>
        @foreach ($creation_history as $row)
            @if ($row -> booking_status = 1)
                <div class="lead">
                    {{ $row -> creation_date }} - <a target="_blank" href="/user/profile/{{ $row -> user_id }}"> {{ $row -> user_name }}</a>
                    solicitó la habitacion <a href="#">{{ $row -> room_number }}</a> de la casa <a target="_blank" href="/houses/{{ $row -> house_id }}" target="_blank">{{ $row -> house_name }}</a>
                    desde {{ $row -> booking_from }} hasta {{ $row -> booking_to }}. Booking id: <a target="_blank" href="/booking/show/{{ $row -> booking_id }}">{{ $row -> booking_id }}</a>
                </div>
            @endif
        @endforeach
    </div>

@else
<p>You are not allowed to enter this page.</p>
@endif

@endsection
