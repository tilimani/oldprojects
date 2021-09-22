@extends('layouts.app')

@section('title', 'Crear un barrio')

@section('content')
    <div class="container mx-auto pt-5">
        @include('layouts.errors')
        <form action="{{ route('neighborhood.store')}}" method="post">
            @csrf
            <div class="form-group row">
                <label for="neighborhoodInput" class="col-sm-5 col-form-label col-form-label-lg">Nombre del barrio</label>
                <div class="col-sm-5">
                    <input type="text" name="name" class="form-control form-control-lg" id="neighborhoodInput" placeholder="" autocomplete="off">
                    <small id="neighborhoodInputHelpBlock" class="form-text text-muted">
                        El nombre del barrio debe ser único, este debe tener una longitud entre 5 y 50 caracteres.
                    </small>
                </div>
            </div>
            <div class="form-group row">
                <label for="confirmation_neighborhoodInput" class="col-sm-5 col-form-label col-form-label-lg">Confirmar el nombre del barrio</label>
                <div class="col-sm-5">
                    <input type="text" name="name_confirmation" class="form-control form-control-lg" id="confirmation_neighborhoodInput" placeholder="" autocomplete="off">
                    <small id="confirmation_neighborhoodInputHelpBlock" class="form-text text-muted">
                        Por seguridad, confirma el nombre del barrio.
                    </small>
                </div>
            </div>
            <div class="form-group row">
                <label for="neighborhoodCodeInput" class="col-sm-5 col-form-label col-form-label-lg">Locación</label>
                <div class="col-sm-5">
                    <select name="location_id" id="{{__('locationInputSelect')}}" class="form-control">
                        @foreach($locations as $location)
                            @if(count($location->neighborhoods()->get()) < 1 )
                                <option value="{{$location->id}}" selected>{{$location->name}}</option>
                            @else
                                <option value="{{$location->id}}">{{$location->name}}</option>
                            @endif
                        @endforeach
                    </select>
                    <small id="{{__('locationInputSelectHelpBlock')}}" class="form-text text-muted">
                        Elíge una locación.
                    </small>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <a href="{{route('neighborhood.index')}}" class="btn btn-link">Volver</a>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    @include('neighborhoods.sections.scripts')
@endsection
