@extends('layouts.app')

@section('content')

<h1>Lista de habitaciones por casa</h1>

<div class="row">
@foreach($rooms as $room)
	<div class="col-6">
		{{ $room->description }}
	</div>
@endforeach
</div>

@endsection