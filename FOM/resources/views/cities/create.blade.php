@extends('layouts.app')

@section('title', 'Crear una ciudad')

@section('content')
    <div class="container mx-auto pt-5">
        @include('layouts.errors')
        <form action="{{ route('city.store')}}" method="post">
            @csrf
            <div class="form-group row">
                <label for="cityInput" class="col-sm-5 col-form-label col-form-label-lg">Nombre de la ciudad</label>
                <div class="col-sm-5">
                    <input type="text" name="name" class="form-control form-control-lg" id="cityInput" placeholder="" autocomplete="off">
                    <small id="cityInputHelpBlock" class="form-text text-muted">
                        El nombre de la zona debe ser único, este debe tener una longitud entre 5 y 50 caracteres.
                    </small>
                </div>
            </div>
            <div class="form-group row">
                <label for="confirmation_cityInput" class="col-sm-5 col-form-label col-form-label-lg">Confirmar el nombre de la ciudad</label>
                <div class="col-sm-5">
                    <input type="text" name="name_confirmation" class="form-control form-control-lg" id="confirmation_cityInput" placeholder="" autocomplete="off">
                    <small id="confirmation_cityInputHelpBlock" class="form-text text-muted">
                        Por seguridad, confirma el nombre de la zona.
                    </small>
                </div>
            </div>
            <div class="form-group row">
                <label for="cityCodeInput" class="col-sm-5 col-form-label col-form-label-lg">Código de la ciudad</label>
                <div class="col-sm-5">
                    <input type="text" name="city_code" class="form-control form-control-lg" id="cityCodeInput" placeholder="" autocomplete="off">
                    <small id="cityCodeInputHelpBlock" class="form-text text-muted">
                        El código debe ser único, este debe tener una longitud máxima de 5 caracteres.
                    </small>
                </div>
            </div>
            <div class="form-group row">
                <label for="countryInputSelect" class="col-sm-5 col-form-label col-form-label-lg">Elegir el país</label>
                <div class="col-sm-5">
                    <select name="country_id" id="countryInputSelect" class="form-control">
                        @foreach($countries as $country)
                            {{-- <option value="{{$country->id}}" @if($country->id === $city->country_id) selected @endif>{{$country->name}}</option> --}}
                            <option value="{{$country->id}}">{{$country->name}}</option>
                        @endforeach
                    </select>
                    <small id="countryInputSelectHelpBlock" class="form-text text-muted">
                        Elíge un país.
                    </small>
                </div>
            </div>
            <div class="form-group row">
                <label for="availableInputSelect" class="col-sm-5 col-form-label col-form-label-lg">Habilitar la ciudad</label>
                <div class="col-sm-5">
                    <select name="available" id="{{__('availableInputSelect')}}" class="form-control">
                        <option value="1">Sí</option>
                        <option value="0" selected>No</option>
                    </select>
                    <small id="{{__('availableInputSelectHelpBlock')}}" class="form-text text-muted">
                        Disponiblidad de la ciudad
                    </small>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <a href="{{route('city.index')}}" class="btn btn-link">Volver</a>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')

@endsection
