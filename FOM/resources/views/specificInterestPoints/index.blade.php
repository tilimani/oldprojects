@extends('layouts.app')

@section('title', 'Ver Puntos de interes especificos')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12 mx-auto">
            <h1>Puntos de interés específicos</h1>
            @include('layouts.errors')
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Tiempo</th>
                        {{-- <th scope="col">Ciudad</th> --}}
                        <th scope="col"># casas asociadas</th>
                        <th scope="col">Creado el</th>
                        <th scope="col"><a href="{{route('specificInterestPoints.create')}}"><button class="btn btn-primary">Crear</button></a></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($interest_points as $interest_point)
                        <tr class="neighborhood-selectable">
                            <th scope="row">{{ $interest_point->id }}</th>
                            <form method="post" action="{{route('specificInterestPoints.update', $interest_point->id)}}"  class="updateneighborhood">
                                @csrf
                                @method('put')
                                <td>
                                    <input type="text" name="name" value="{{$interest_point->name}}" id="{{__('neighborhoodInput' . $interest_point->id)}}" class="form-control" autocomplete="off">
                                    <small id="neighborhoodInputHelpBlock" class="form-text text-muted">
                                        El nombre del punto de interes debe tener entre 5 y 50 caracteres.
                                    </small>
                                    <button type="submit" class="btn btn-success btn-small btnSave">Guardar</button>
                                </td>
                                <td>
                                    <input type="text" name="description" value="{{$interest_point->description}}" id="{{__('neighborhoodInput' . $interest_point->id)}}" class="form-control" autocomplete="off">
                                    <small id="neighborhoodInputHelpBlock" class="form-text text-muted">
                                        La descripción es el tiempo, en minutos.
                                    </small>
                                </td>
                                {{-- <td>
                                    <select name="city_id" id="{{__('cityInputSelect' . $interest_point->id)}}" class="form-control">
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}" @if($city->id === $interest_point->city_id) selected @endif>{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                    <small id="{{__('cityInputSelectHelpBlock' . $interest_point->id)}}" class="form-text text-muted">
                                        Elíge una ciudad.
                                    </small>
                                </td> --}}
                                <td>{{count($interest_point->houses)}}</td>
                                <td>{{$interest_point->created_at}}</td>
                            </form>
                            <td>
                                <form action="{{ route('specificInterestPoints.destroy', $interest_point->id)}}" method="POST">
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
