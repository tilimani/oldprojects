@extends('layouts.app')
@section('title', 'screenshot')
@section('content')
<div class="container">
        {{-- DIV IMAGE --}}

        @if($image)
        <p class="h3">User Name: {{$verification->user->name}} {{$verification->user->last_name}}</p>
        <p class="h3">Fecha de nacimiento: {{date("d.m.y", strtotime($verification->user->birthdate))}}</p>
        <div class="row justify-content-center">
            {{-- <img src="{{$screenshot}}" class=""> --}}
        <img src="https://fom.imgix.net/{{$image}}" class="w-100 h-100">

            {{-- CAPTION FOTO --}}
                {{-- START ROW DATES AND CALENDAR --}}
                <div class="row ml-md-4 mr-md-4 pl-md-4 pr-md-4 ml-lg-0 mr-lg-0 pl-lg-0 pr-lg-0">
                    {{-- COL DATE LEFT --}}
                    <div class="col-4">
                        <div class="row">
                             <div class="col-6 mt-auto">
                                <ul class="bullet-points-off">
                                </ul>
                            </div>
                        </div>
                    </div>
            </div>
            {{-- END CAPTION FOTO --}}
        </div>
        @endif
        {{-- DIV IMAGE END --}}

        <p class="text-center">Screenshots por revisar {{$count}}</p>
        @if($verification)
        <div class="container d-flex justify-content-center">
        	<form method="POST" action="{{ URL::to('/verification/id/process')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{-- <input type="hidden" name="id" value="{{$booking->id}}"> --}}
                <input type="hidden" name="id" value="{{$verification->id}}">
                <input type="hidden" name="flag" value="0">
                <button type="submit" class="btn btn-light" style="margin: 10px">Rechazar</button>
            </form>
            <form method="POST" action="{{ URL::to('/verification/id/process')}}" enctype="multipart/form-data">
            	{{ csrf_field() }}
            	{{-- <input type="hidden" name="id" value="{{$booking->id}}"> --}}
            <input type="hidden" name="id" value="{{$verification->id}}">
            	<input type="hidden" name="flag" value="1">
        		<button type="submit" class="btn btn-primary" style="margin: 10px">Aceptar</button>
        	</form>
        </div>
        @endif
</div>
@endsection
