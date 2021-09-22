@extends('layouts.app')

@section('title', 'Ver barrios')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12 mx-auto">
            @include('layouts.errors')
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre del barrio</th>
                        <th scope="col">Locación</th>
                        <th scope="col">Creado el</th>
                        <th scope="col"><a href="{{route('neighborhood.create')}}"><button class="btn btn-primary">Crear</button></a></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($neighborhoods as $neighborhood)
                        <tr class="neighborhood-selectable">
                            <th scope="row">{{ $neighborhood->id }}</th>
                            <form method="post" action="{{route('neighborhood.update', $neighborhood)}}"  class="updateneighborhood">
                                <td>
                                    @csrf
                                    @method('put')
                                    <input type="text" name="name" value="{{$neighborhood->name}}" id="{{__('neighborhoodInput' . $neighborhood->id)}}" class="form-control" autocomplete="off">
                                    <small id="neighborhoodInputHelpBlock" class="form-text text-muted">
                                        El nombre de la zona debe ser único, este debe tener una longitud entre 5 y 50 caracteres.
                                    </small>
                                    <button type="submit" class="btn btn-success btn-small btnSave">Guardar</button>
                                </td>
                                <td>
                                    <select name="location_id" id="{{__('locationInputSelect' . $neighborhood->id)}}" class="form-control">
                                        @foreach($locations as $location)
                                            <option value="{{$location->id}}" @if($location->id === $neighborhood->location_id) selected @endif>{{$location->name}}</option>
                                        @endforeach
                                    </select>
                                    <small id="{{__('locationInputSelectHelpBlock' . $neighborhood->id)}}" class="form-text text-muted">
                                        Elíge una location.
                                    </small>
                                </td>
                            </form>
                            <td>{{$neighborhood->created_at}}</td>
                            <td>
                                <form action="{{ route('neighborhood.destroy', $neighborhood)}}" method="POST">
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
