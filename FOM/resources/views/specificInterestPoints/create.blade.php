@extends('layouts.app')

@section('title', 'Nuevo puntos de interés específico')

@section('content')
<div class="container mx-auto pt-5">
    @include('layouts.errors')
    <form action="{{ route('specificInterestPoints.store')}}" method="post">
        @csrf
        <div class="form-group row">
            <label for="genericInterestPointInput" class="col-sm-5 col-form-label col-form-label-lg">Nombre del punto de interes</label>
            <div class="col-sm-5">
                <input type="text" name="name" class="form-control form-control-lg" id="genericInterestPointInput" placeholder="" autocomplete="off">
                <small id="genericInterestPointInputHelpBlock" class="form-text text-muted">
                    El nombre punto de interes debe ser unico y tener entre 5 y 50 caracteres.
                </small>
            </div>
        </div>
        {{-- <div class="form-group row">
            <label for="genericInterestPointInput" class="col-sm-5 col-form-label col-form-label-lg">Descripcion del punto de interes</label>
            <div class="col-sm-5">
                <input type="text" name="description" class="form-control form-control-lg" id="genericInterestPointInput" placeholder="" autocomplete="off">
                <small id="genericInterestPointInputHelpBlock" class="form-text text-muted">
                    La descripcion punto de interes debe tener entre 5 y 100 caracteres.
                </small>
            </div>
        </div> --}}
        {{-- <div class="form-group row">
            <label for="genericInterestPointCodeInput" class="col-sm-5 col-form-label col-form-label-lg">Ciudad</label>
            <div class="col-sm-5">
                <select name="city_id" id="{{__('locationInputSelect')}}" class="form-control">
                    @foreach($cities as $city)
                        <option value="{{$city->id}}">{{$city->name}}</option>
                    @endforeach
                </select>
                <small id="{{__('locationInputSelectHelpBlock')}}" class="form-text text-muted">
                    Elíge una ciudad.
                </small>
            </div>
        </div> --}}
        <div class="form-group row">
            <div class="col-sm-10">
                <a href="{{route('specificInterestPoints.index')}}" class="btn btn-link">Volver</a>
                <button type="submit" class="btn btn-primary">Crear</button>
            </div>
        </div>
    </form>
</div>
@endsection
