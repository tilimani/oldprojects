@extends('layouts.app')

@section('title', 'Ver ciudades')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12 mx-auto">
            @include('layouts.errors')
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre de la ciudad</th>
                        <th scope="col">Código de la ciudad</th>
                        <th scope="col">País de la ciudad</th>
                        <th scope="col">Habilitada</th>
                        <th scope="col">Creado el</th>
                        <th scope="col"><a href="{{route('city.create')}}"><button class="btn btn-primary">Crear</button></a></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cities as $city)
                        <tr class="city-selectable">
                            <th scope="row">{{ $city->id }}</th>
                            <form method="post" action="{{route('city.update', $city)}}"  class="updatecity">
                                <td>
                                    @csrf
                                    @method('put')
                                    <input type="text" name="name" value="{{$city->name}}" id="{{__('cityInput' . $city->id)}}" class="form-control" autocomplete="off">
                                    <small id="cityInputHelpBlock" class="form-text text-muted">
                                        El nombre de la ciudad debe ser único, este debe tener una longitud entre 5 y 50 caracteres.
                                    </small>
                                    <button type="submit" class="btn btn-success btn-small btnSave">Guardar</button>
                                    <a href="{{route('specificInterestPoint.city.create', $city)}}" class="btn btn-link btn-small btnSave">Relación puntos de interés específicos</a>
                                </td>
                                <td>
                                    <input type="text" name="city_code" value="{{$city->city_code}}" id="{{__('city_code' . $city->id)}}" class="form-control" autocomplete="off">
                                    <small id="cityInputHelpBlock" class="form-text text-muted">
                                        El código de la ciudad, este debe tener una longitud máxima de 5 caracteres.
                                    </small>
                                </td>
                                <td>
                                    <select name="country_id" id="countryInputSelect" class="form-control">
                                        @foreach($countries as $country)
                                        <option value="{{$country->id}}" @if($country->id === $city->country_id) selected @endif>{{$country->name}}</option>
                                        {{-- <option value="{{$country->id}}">{{$country->name}}</option> --}}
                                        @endforeach
                                    </select>
                                    <small id="countryInputSelectHelpBlock" class="form-text text-muted">
                                        Elíge un país.
                                    </small>
                                </td>
                                <td>
                                    <select name="available" id="{{__('availableInputSelect' . $city->id)}}" class="form-control">
                                        <option value="1" @if($city->isAvailable()) selected @endif>Sí</option>
                                        <option value="0" @if(!$city->isAvailable()) selected @endif>No</option>
                                    </select>
                                    <small id="{{__('availableInputSelectHelpBlock' . $city->id)}}" class="form-text text-muted">
                                        Disponiblidad de la ciudad
                                    </small>
                                </td>
                            </form>
                            <td>{{$city->created_at}}</td>
                            <td>
                                <form action="{{ route('city.destroy', $city)}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-small">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <th scope=row>N/N</th>
                            <td coslpan="4">Sin datos registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
