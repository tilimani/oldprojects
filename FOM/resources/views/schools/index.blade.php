@extends('layouts.app')

@section('title', 'Ver escuelas/universidades')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12 mx-auto">
            @include('layouts.errors')
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre de la escuela/universidad</th>
                        <th scope="col">Prefijo</th>
                        <th scope="col">Latitud</th>
                        <th scope="col">Longitud</th>
                        <th scope="col">Creado el</th>
                        <th scope="col"><a href="{{route('school.create')}}"><button class="btn btn-primary">Crear nueva zona</button></a></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schools as $school)
                    <tr class="school-selectable">
                        <form method="post" action="{{route('school.update', $school)}}"  class="updateschool">
                            @csrf
                            @method('put')
                            <th scope="row">{{ $school->id }}</th>
                            <td>
                                <input type="text" name="name" value="{{$school->name}}" id="schoolInputName" class="form-control" autocomplete="off">
                                <small id="schoolInputNameHelpBlock" class="form-text text-muted">
                                    El nombre de la escuela/universdiad debe ser único, este debe tener una longitud entre 5 y 50 caracteres.
                                </small>
                                <button type="submit" class="btn btn-success btn-small btnSave">Guardar</button>
                                <a href="{{ route('neighborhood.school.create', $school)}}" class="btn btn-link btn-small">Relación barrios</a>
                            </td>
                            <td>
                                <input type="text" name="prefix" value="{{$school->prefix}}" id="schoolInputPrefix" class="form-control" autocomplete="off">
                                <small id="schoolInputPrefixHelpBlock" class="form-text text-muted">
                                    Prefijo: El, La.
                                </small>
                            </td>
                            <td>
                                <input type="text" name="lat" value="{{$school->lat}}" id="schoolInputLat" class="form-control" autocomplete="off">
                            </td>
                            <td>
                                <input type="text" name="lng" value="{{$school->lng}}" id="schoolInputLng" class="form-control" autocomplete="off">
                            </td>
                            <td>
                                {{$school->created_at}}
                            </td>
                        </form>
                        <form action="{{ route('school.destroy', $school)}}" method="POST">
                            @csrf
                            @method('delete')
                            <td>
                                <button type="submit" class="btn btn-danger btn-small">Eliminar</button>
                            </td>
                        </form>
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

