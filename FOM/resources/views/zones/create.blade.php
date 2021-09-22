@extends('layouts.app')

@section('title', 'Crear una zona')

@section('content')
    <div class="container mx-auto pt-5">
        @include('layouts.errors')
        <form action="{{ route('zone.store')}}" method="post">
            @csrf
            <div class="form-group row">
                <label for="zoneInput" class="col-sm-2 col-form-label col-form-label-lg">Nombre de la zona</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control form-control-lg" id="zoneInput" placeholder="" autocomplete="off">
                    <small id="zoneInputHelpBlock" class="form-text text-muted">
                        El nombre de la zona debe ser único, este debe tener una longitud entre 5 y 50 caracteres.
                    </small>
                </div>
            </div>
            <div class="form-group row">
                <label for="confirmation_zoneInput" class="col-sm-2 col-form-label col-form-label-lg">Confirmar el nombre de la zona</label>
                <div class="col-sm-10">
                    <input type="text" name="name_confirmation" class="form-control form-control-lg" id="confirmation_zoneInput" placeholder="" autocomplete="off">
                    <small id="confirmation_zoneInputHelpBlock" class="form-text text-muted">
                        Por seguridad, confirma el nombre de la zona.
                    </small>
                </div>
            </div>
            <div class="form-group row">
                <label for="confirmation_zoneInput" class="col-sm-2 col-form-label col-form-label-lg">Ciudad de la Zona</label>
                <div class="col-sm-10">
                    <select name="city_id" id="{{__('cityInputSelect')}}" class="form-control">
                        @foreach($cities as $city)
                            <option value="{{$city->id}}">{{$city->name}}</option>
                        @endforeach
                    </select>
                    <small id="{{__('zoneInputSelectHelpBlock')}}" class="form-text text-muted">
                        Elíge una ciudad.
                    </small>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-10">
                    <a href="{{route('zone.index')}}" class="btn btn-link">Volver<a>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')

@endsection
