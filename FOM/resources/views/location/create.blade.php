@extends('layouts.app')

@section('title', 'Crear nueva location')

@section('content')
    <div class="container mt-5">
        @include('layouts.errors')
        <form action="{{ route('location.store')}}" method="post">
            @csrf
            <div class="form-group row">
                <label for="locationInput" class="col-sm-2 col-form-label col-form-label-lg">Nombre de la Location</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control form-control-lg" id="locationInput" placeholder="" autocomplete="off">
                    <small id="locationInputHelpBlock" class="form-text text-muted">
                        El nombre de la Location debe ser único, este debe tener una longitud entre 5 y 50 caracteres.
                    </small>
                </div>
            </div>
            <div class="form-group row">
                <label for="confirmation_locationInput" class="col-sm-2 col-form-label col-form-label-lg">Confirmar el nombre de la location</label>
                <div class="col-sm-10">
                    <input type="text" name="name_confirmation" class="form-control form-control-lg" id="confirmation_locationInput" placeholder="" autocomplete="off">
                    <small id="confirmation_locationInputHelpBlock" class="form-text text-muted">
                        Por seguridad, confirma el nombre de la location.
                    </small>
                </div>
            </div>
            <div class="form-group row">
                <label for="confirmation_locationInput" class="col-sm-2 col-form-label col-form-label-lg">Elegir la zona</label>
                <div class="col-sm-10">
                    <select name="zone_id" id="{{__('zoneInputSelect')}}" class="form-control">
                        @forelse($zones as $zone)
                            <option value="{{$zone->id}}">{{$zone->name}}</option>
                        @empty
                            <option value="" disabled>No disponible</option>
                        @endforelse
                    </select>
                    <small class="form-text text-muted">
                        Elíge la zona de la location
                    </small>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <a href="{{route('location.index')}}" class="btn btn-link">Volver</a>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')

@endsection
