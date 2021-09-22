@extends('layouts.app')

@section('title', 'Crear un escuela/universidad')

@section('content')
    <div class="container mx-auto pt-5">
        @include('layouts.errors')
        <form action="{{ route('school.store')}}" method="post">
            @csrf
            <div class="form-group row">
                <label for="schoolInput" class="col-sm-2 col-form-label col-form-label-lg">Nombre de la escuela/universidad</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control form-control-lg" id="schoolInput" placeholder="Nombre de la escuela" autocomplete="off">
                    <small id="schoolInputHelpBlock" class="form-text text-muted">
                        El nombre de la escuela/universidad debe ser único, este debe tener una longitud entre 5 y 50 caracteres.
                    </small>
                </div>
            </div>
            <div class="form-group row">
                <label for="confirmation_schoolInput" class="col-sm-2 col-form-label col-form-label-lg">Confirmar el nombre de la escuela/universidad</label>
                <div class="col-sm-10">
                    <input type="text" name="name_confirmation" class="form-control form-control-lg" id="confirmation_schoolInput" placeholder="Confirmar nombre de la escuela" autocomplete="off">
                    <small id="confirmation_schoolInputHelpBlock" class="form-text text-muted">
                        Por seguridad, confirma el nombre de la escuela/universidad.
                    </small>
                </div>
            </div>
            <div class="form-group row">
                <label for="prefix" class="col-sm-2 col-form-label col-form-label-lg">El prefijo de la escuela/universidad.</label>
                <div class="col-sm-10">
                    <input type="text" name="prefix" class="form-control form-control-lg" id="prefix" placeholder="El/La" autocomplete="off">
                    <small id="prefixHelpBlock" class="form-text text-muted">
                        Debe ser mayor a 2 caracteres y menor a 10, es el texto que aparecerá antes del nombr de la escuela/universidad.
                    </small>
                </div>
            </div>
            <div class="form-group row">
                <label for="lat" class="col-sm-2 col-form-label col-form-label-lg">Coordenada: latitud</label>
                <div class="col-sm-10">
                    <input type="text" name="lat" class="form-control form-control-lg" id="lat" placeholder="6.267747" autocomplete="off">
                    <small id="latHelpBlock" class="form-text text-muted">
                        Coordenada latitud
                    </small>
                </div>
            </div>
            <div class="form-group row">
                <label for="lng" class="col-sm-2 col-form-label col-form-label-lg">Coordenada: longitud</label>
                <div class="col-sm-10">
                    <input type="text" name="lng" class="form-control form-control-lg" id="lng" placeholder="-75.5688" autocomplete="off">
                    <small id="lngHelpBlock" class="form-text text-muted">
                        Coordenada longitud
                    </small>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <a href="{{route('zone.index')}}" class="btn btn-link">Volver</a>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')

@endsection
