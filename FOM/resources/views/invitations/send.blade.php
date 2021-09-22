@extends('layouts.app')

@section('title', 'Invitar')

@section('content')
    <div id="react-sendInvitation" data-userId={{Auth::user()->id}}></div>
@endsection
