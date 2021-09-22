@extends('layouts.app')

@section('title', 'Relación casa con zona')

@section('content')
    <div class="container mx-auto pt-5">
        @include('layouts.errors')
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Ciudad</th>
                    <th scope="col">Barrio</th>
                    <th scope="col">Locación</th>
                    <th scope="col">Zona</th>
                    <th scope="col">Creado en</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$house->name}}</td>
                    <td>{{$city->name}}</td>
                    <td>{{$neighborhood->name}}</td>
                    <td>{{$location->name}}</td>
                    <td>{{$houseZone->name}}</td>
                    <td>{{$house->created_at}}</td>
                </tr>
            </tbody>
        </table>
        <form action="{{route('zone.house.store', $house)}}" method="post">
            @csrf
            <div class="form-group row">
                <label for="zoneInputSelect" class="col-sm-2 col-form-label col-form-label-lg">Elegir la zona</label>
                <div class="col-sm-10">
                    <select name="zone_id" id="zoneInputSelect" class="form-control">{{$houseZone->name}}
                        @foreach($zones as $zone)
                            <option value="{{$zone->id}}" @if($zone->id === $house->zone_id) selected @endif>{{$zone->name}}</option>
                        @endforeach
                    </select>
                    <small id="zoneInputSelectHelpBlock" class="form-text text-muted">
                        El nombre de la zona es único.
                    </small>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <a href="{{ route('zone.index')}}" class="btn btn-link">Ver las zonas</a>
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')

@endsection
