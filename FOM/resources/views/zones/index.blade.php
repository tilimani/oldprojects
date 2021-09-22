@extends('layouts.app')

@section('title', 'Ver zonas')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12 mx-auto">
            @include('layouts.errors')
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre de la zona</th>
                        <th scope="col">Ciudad de la zona</th>
                        <th scope="col">Creado el</th>
                        <th scope="col"><a href="{{route('zone.create')}}"><button class="btn btn-primary">Crear nueva zona</button></a></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($zones as $zone)
                        <tr class="zone-selectable">
                            <th scope="row">{{ $zone->id }}</th>
                            <td>
                                <form method="post" action="{{route('zone.update', $zone)}}"  class="updateZone">
                                    @csrf
                                    @method('put')
                                    <input type="text" name="name" value="{{$zone->name}}" id="zoneInput" class="form-control" autocomplete="off">
                                    <small id="zoneInputHelpBlock" class="form-text text-muted">
                                        El nombre de la zona debe ser único, este debe tener una longitud entre 5 y 50 caracteres.
                                    </small>
                                    <button type="submit" class="btn btn-success btn-small btnSave">Guardar</button>
                                </form>
                            </td>
                            <td>
                                <select name="city_id" id="{{__('cityInputSelect' . $zone->id)}}" class="form-control">
                                    @forelse($cities as $city)
                                        <option value="{{$city->id}}" @if($city->id === $zone->city) selected @endif>{{$city->name}}</option>
                                    @empty
                                        <option value="" disabled>No disponible</option>
                                    @endforelse
                                </select>
                                <small class="form-text text-muted">
                                    Elíge la zona de la location
                                </small>
                            </td>
                            <td>{{$zone->created_at}}</td>
                            <td>
                                <form action="{{ route('zone.destroy', $zone)}}" method="POST">
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

