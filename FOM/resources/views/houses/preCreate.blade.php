@extends('layouts.app')

@section('title', 'Crea tu Vico')

@section('content')

    <div
    id="react-create"
    @if(Auth::user())
        data-connection={{__(Auth::check().",".Auth::user()->role_id)}}
    @else
        data-connection={{__("0".","."0")}}
    @endif
    >
    </div>
@endsection