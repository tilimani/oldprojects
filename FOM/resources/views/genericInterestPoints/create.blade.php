@extends('layouts.app')

@section('title', 'Nuevo puntos de interés genérico')

@section('content')
<div class="container mx-auto pt-5">
    @include('layouts.errors')
    <form action="{{ route('genericInterestPoints.store')}}" method="post">
        @csrf
        <div class="form-group row">
            <label for="genericInterestPointInput" class="col-sm-5 col-form-label col-form-label-lg">Nombre del punto de interes</label>
            <div class="col-sm-5">
                <input type="text" name="name" class="form-control form-control-lg" id="genericInterestPointInput" placeholder="" autocomplete="off">
                <small id="genericInterestPointInputHelpBlock" class="form-text text-muted">
                    {{trans('general.name_of_interest_point')}}
                </small>
            </div>
        </div>
        {{-- <div class="form-group row">
            <label for="genericInterestPointInput" class="col-sm-5 col-form-label col-form-label-lg">Tiempo del punto de interes</label>
            <div class="col-sm-5">
                <input type="text" name="description" class="form-control form-control-lg" id="genericInterestPointInput" placeholder="" autocomplete="off">
                <small id="genericInterestPointInputHelpBlock" class="form-text text-muted">
                    La descripcion punto de interes debe tener entre 5 y 100 caracteres.
                </small>
            </div>
        </div> --}}
        <div class="form-group row">
            <div class="col-sm-10">
                <a href="{{route('genericInterestPoints.index')}}" class="btn btn-link">{{trans('general.volver')}}</a>
                <button type="submit" class="btn btn-primary">{{trans('general.create')}}</button>
            </div>
        </div>
    </form>
</div>
@endsection
