@extends('layouts.app')

@section('title', 'Ver locations')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 mx-auto">
                @include('layouts.errors')
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Zona</th>
                            <th scope="col">Creado el</th>
                            <th scope="col"><a href="{{route('location.create')}}"><button class="btn btn-primary">Crear</button></a></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($locations as $location)
                            <tr class="location-selectable">
                                <th scope="row">{{$location->id}}</th>
                                <form action="{{route('location.update', $location)}}" method="post">
                                    @csrf
                                    @method('put')
                                    <td>
                                        <input type="text" name="name" value="{{$location->name}}" class="form-control" autocomplete="off">
                                        <small class="form-text text-muted">
                                            El nombre de la Location debe ser único, este debe tener una longitud entre 5 y 50 caracteres.
                                        </small>
                                        <button type="submit" class="btn btn-success btn-small">Guardar</button>
                                    </td>
                                    <td>
                                        <select name="zone_id" id="{{__('zoneInputSelect' . $location->id)}}" class="form-control">
                                            @forelse($zones as $zone)
                                                <option value="{{$zone->id}}" @if($zone->id === $location->zone_id) selected @endif>{{$zone->name}}</option>
                                            @empty
                                                <option value="" disabled>No disponible</option>
                                            @endforelse
                                        </select>
                                        <small class="form-text text-muted">
                                            Elíge la zona de la location
                                        </small>
                                    </td>
                                </form>
                                <td>{{$location->created_at}}</td>
                                <td>
                                    <form action="{{ route('location.destroy', $location)}}" method="POST">
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

@section('scripts')

@endsection
