@extends('layouts.app')

@section('title', 'Relación casa con punto de interés específico')

@section('content')
    <div class="container mx-auto pt-5">
        @include('layouts.errors')
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Dirección</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Status</th>
                    <th scope="col">Creado en</th>
                    <th scope="col"><a href="{{route('show_house', $house)}}"><button class="btn btn-primary">Ver</button></a></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$house->name}}</td>
                    <td>{{$house->address}}</td>
                    <td>{{$house->type}}</td>
                    <td>{{$house->status}}</td>
                    <td>{{$house->created_at}}</td>
                    <td><a href="{{route('edit_show', $house)}}"><button class="btn btn-success btn-small">Editar</button></a></th></td>
                </tr>
            </tbody>
        </table>
        <form action="{{route('specificInterestPoint.house.create', $house)}}" method="post">
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
                   @foreach($houseSpecificInterestPoints as $houseSpecificInterestPoint)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="inputchecked[]" type="checkbox" id="{{__('inlineCheckbox'.$houseSpecificInterestPoint->id)}}" value="{{$houseSpecificInterestPoint->id}}" checked>
                            <label class="form-check-label" for="{{__('inlineCheckbox'.$houseSpecificInterestPoint->id)}}">{{$houseSpecificInterestPoint->name . ' ' . $houseSpecificInterestPoint->description}}</label>
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
