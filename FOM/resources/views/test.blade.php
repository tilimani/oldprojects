@extends('layouts.app')

@section('styles')

@endsection

@section('content')
  {{-- <div id="react-reservation"></div> --}}
  <button class="openModalButton" data-id="278">Open Modal</button>
  <button class="openModalButton" data-id="24">Open Modal</button>
  <div id="react-rating" data-connection={{Lang::locale() .",". Auth::user()}}></div>
@endsection

