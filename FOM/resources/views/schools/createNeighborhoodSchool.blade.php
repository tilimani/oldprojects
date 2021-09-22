@extends('layouts.app')

@section('title', 'Relación barrio escuela/universidad')

@section('content')
    <div class="container mx-auto pt-5">
        @include('layouts.errors')
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Prefijo</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">#barrios</th>
                    <th scope="col">Creado en</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$school->prefix}}</td>
                    <td>{{$school->name}}</td>
                    <td>{{count($school->neighborhoods()->get() )}}</td>
                    <td>{{$school->created_at}}</td>
                </tr>
            </tbody>
        </table>
        <form action="{{route('neighborhood.school.store', $school)}}" method="post">
            @csrf
            <div class="form-group row">
                <label for="zoneInputSelect" class="col-sm-2 col-form-label col-form-label-lg">Agregar nuevos barrios cercanos</label>
                <div class="col-sm-10">
                    <div class="container-fluid">
                        <div class="row">
                            @foreach($neighborhoods as $neighborhood)
                                <div class="col-3">
                                    <div class="form-check form-check">
                                        <input class="form-check-input" name="inputunchecked[]" type="checkbox" id="{{__('inlineCheckbox'.$neighborhood->id)}}" value="{{$neighborhood->id}}">
                                        <label class="form-check-label" for="{{__('inlineCheckbox'.$neighborhood->id)}}">{{$neighborhood->name}}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="zoneInputSelect" class="col-sm-2 col-form-label col-form-label-lg">Borrar antiguos barrios cercanos</label>
                <div class="col-sm-10">
                   @foreach($neighborhoodSchools as $neighborhood)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="inputchecked[]" type="checkbox" id="{{__('inlineCheckbox'.$neighborhood->id)}}" value="{{$neighborhood->id}}" checked>
                            <label class="form-check-label" for="{{__('inlineCheckbox'.$neighborhood->id)}}">{{$neighborhood->name}}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <a href="{{ route('school.index')}}" class="btn btn-link">Volver a las escuelas</a>
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')

@endsection
