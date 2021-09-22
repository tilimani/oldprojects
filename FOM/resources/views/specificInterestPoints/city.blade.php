@extends('layouts.app')

@section('title', 'Relación ciudad punto de interés específico')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12 mx-auto">
            <h1>Puntos de interés específicos de la ciudad</h1>
            @include('layouts.errors')
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">País</th>
                        <th scope="col">Código</th>
                        <th scope="col">Habilitado</th>
                        <th scope="col">Creado el</th>
                        <th scope="col"><a href="{{route('city.index')}}"><button class="btn btn-success btn-small">Ver ciudades</button></a></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$city->id}}</td>
                        <td>{{$city->name}}</td>
                        <td>{{$city->country->name}}</td>
                        <td>{{$city->city_code}}</td>
                        <td>{{$city->available}}</td>
                        <td>{{$city->created_at}}</td>
                    </tr>
                </tbody>
        </table>
        <form action="{{route('specificInterestPoint.city.create', $city)}}" method="post">
            @csrf
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label col-form-label-lg">Agregar nuevos puntos de interés</label>
                <div class="col-sm-10">
                    @foreach($specificInterestPoints as $specificInterestPoint)
                        <div class="form-check form-check">
                            <input class="form-check-input" name="inputunchecked[]" type="checkbox" id="{{__('inlineCheckbox'.$specificInterestPoint->id)}}" value="{{$specificInterestPoint->id}}">
                            <label class="form-check-label" for="{{__('inlineCheckbox'.$specificInterestPoint->id)}}">{{$specificInterestPoint->name . '/' . $specificInterestPoint->description}}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label col-form-label-lg">Borrar antiguos puntos de interés</label>
                <div class="col-sm-10">
                   @foreach($citySpecificInterestPoints as $citySpecificInterestPoint)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="inputchecked[]" type="checkbox" id="{{__('inlineCheckbox'.$citySpecificInterestPoint->id)}}" value="{{$citySpecificInterestPoint->id}}" checked>
                            <label class="form-check-label" for="{{__('inlineCheckbox'.$citySpecificInterestPoint->id)}}">{{$citySpecificInterestPoint->name . ' ' . $citySpecificInterestPoint->description}}</label>
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
    </div>
</div>
@endsection
