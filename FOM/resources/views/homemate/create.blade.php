@extends('layouts.app')
@section('content')
@if (Auth::user() && Auth::user()->email === 'friendsofmedellin@gmail.com')
<h2>{{trans('general.create_roomie')}}</h2>
<form method="POST" action="{{ URL::to('/homemate/store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}


    <input type="number" name="house_id"  class="hidden" value="{{$id}}">
    <div class="row">
        <div class="form-group col-sm-6">
            <input type="text" class="form-control" name="name" placeholder="Nombre" required>
            <label for="name">{{trans('general.name')}}</label>
        </div>

        <div class="form-group col-sm-6">
            <input type="text" class="form-control" name="profession" placeholder="Profesión" required>
            <label for="profession">{{trans('general.profession')}}</label>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-6">
            <select class="form-control" name="genre" required="">
                <option>-- {{trans('general.selection')}} --</option>
                <option value='1'>{{trans('general.man')}}</option>
                <option value='2'>{{trans('general.woman')}}</option>
            </select>
            <label for="genre">{{trans('general.gender')}}</label>
        </div>

        <div class="form-group col-sm-6">
            <input type="text"  class="form-control" name="house_name" placeholder="Nombre Casa" required readonly value="{{$name}}">
            <label for="house_name">{{trans('general.house')}}</label>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-12" style="position: relative; text-align: center;">
            <select class="form-control" name="nationality" required>
                <option>-- {{trans('general.select')}} --</option>
                @foreach($nationalities as $nationality)
                    <option value='{{ $nationality->id }}'>{{ $nationality->name }}</option>
                @endforeach
            </select>
            <label for="nationality">{{trans('general.nacionality')}}</label>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12" style="text-align: center; margin-bottom: 5rem;">
            <button type="submit" class="btn btn-default">
                {{trans('general.save')}}
            </button>
        </div>
    </div>
</form>

<!--div class="row">
    <div class="col-xs-12">
    <p style="font-family: raleway; font-size: 50px; margin-top: 20px; text-align: center;">Uuupsii...</p>
    <p style="font-family: raleway; font-size: 30px; margin-top: 20px; text-align: center;">There went something wrong on our end.</p></div>
    <div class="form-group col-xs-12 text-center">
        <button class="btn btn-default" style="margin:10px;" onclick="window.location.href='http://vico.friendsofmedellin.com/houses'">Volver a página de búsqueda</button>
        <button class="btn btn-default" onclick="window.location.href='mailto:contacto@friendsofmedellin.com'">Cuenta nos que pasó</button>
    </div>.
</div>
<div class="row">
    <img style="/*margin-left:-135px;*/ max-width:100%" src="http://friendsofmedellin.com/wp-content/uploads/2018/01/404errornew.png">
</div-->

@else
<p>{{trans('general.cant_enter')}}</p>
@endif
@endsection
