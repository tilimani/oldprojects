
@extends('layouts.app')
@section('content')

@if (Auth::user() && Auth::user()->email === 'friendsofmedellin@gmail.com'||true)
    

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<div class="container">
    <form method="POST" action="{{ URL::to('/rooms/store') }}" accept-charset="UTF-8" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-10 col-md-3">
                <h2>Crear Habitacion</h2>
            </div>
            <div class="form-group col-2 col-md-1">
                <input type="number" class="form-control" name="number" placeholder="Numero de habitacion" required readonly value="{{$count + 1}}">
                {{-- <label for="number">Numero de habitacion</label> --}}
            </div>
        </div>
        <div class="row">
            <div class="col-6 col-md-3">
                 <input type="number" name="house" class="hidden" id="id_casa" placeholder="casa" required readonly value="{{$id_house}}">
                <input type="text" class="form-control" placeholder="casa" required readonly value="@foreach($houses->where('id', '=', $id_house) as $house) {{$nombre_casa = $house->name}} @endforeach">
                <label for="house">Casa</label>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-6">
                <input type="number" class="form-control" name="price" placeholder="Precio" maxlength="32" required> 
                <label for="price">Precio</label>
            </div>

             <div class="form-group col-6">
             <input type="number" class="form-control" name="price_for_two" placeholder="Precio para dos" maxlength="32">
                <label for="price_for_two">Precio para dos</label>
            </div>
        </div>


        <div class="row">
            <div class="form-group col-6">
                <select class="form-control" name="bed_type" required>
                    <option>-- seleccione --</option>
                    <option value='sencilla'>sencilla</option>
                    <option value='semi-doble'>semi-doble</option>
                    <option value='doble'>doble</option>
                </select>
                <label for="bed_type">Tipo de cama</label>
            </div>
            <div class="form-group col-6">
                 <select class="form-control" name="desk" required>
                    <option>-- seleccione --</option>
                    <option value='0' type="number" >No</option>
                    <option value='1' type="number" >Si</option>
                </select>
                <label for="desk">Tiene escritorio</label>
            </div> 
        </div>

        <div class="row">
            <div class="form-group col-sm-6">
               <select class="form-control" name="bath_type" required>
                    <option>-- seleccione --</option>
                    <option value='privado'>Privado</option>
                    <option value='compartido'>Compartido con 1</option>
                    <option value='compartido con 2'>Compartido con 2</option>
                    <option value='compartido con 3'>Compartido con 3</option>
                    <option value='compartido con 4'>Compartido con 4</option>
                    <option value='compartido con 5'>Compartido con 5</option>
                </select>
                <label for="bath_type">Baño</label>
            </div>

            <div class="form-group col-sm-6">
                <select class="form-control" name="window_type" required>
                    <option>-- seleccione --</option>
                    <option value='adentro'>adentro</option>
                    <option value='afuera'>afuera</option>
                    <option value='patio'>el patio</option>
                    <option value='sin_ventana'>Sin ventana</option>
                </select>
                <label for="window_type">Ventana hacia</label>
            </div>            
        </div>

         <div class="row">
            <div class="form-group col-6">   
                <select class="form-control" name="has_tv" required>
                    <option value='0' type="number" >No</option>
                    <option value='1' type="number" >Si</option>
                </select>
            <label for="has_tv">Tiene TV</label>
            </div>
            <div class="form-group col-6">
                <select class="form-control" name="has_closet" required>
                    <option value='1' type="number" >Si</option>
                    <option value='0' type="number" >No</option>
                </select>
            <label for="has_tv">Tiene Closet</label>
            </div>
        </div>


        <div class="row">
            
            <div class="form-group col-6">
                <input type="text" class="form-control" id="date" name="available_from" placeholder="dd/mm/yyyy" required autocomplete="off">
                <label for="available_from">Disponibilidad desde:</label>
            </div>            
        </div>
       
        <div class="row">
            <div class="form-group col-12">
                <textarea class="form-control" name="description" rows="3" maxlength="766" ></textarea>
                <label for="description">Descripcion</label>
            </div>
        </div>
        <div class="row">
            
            <div class="col-6">
                <label for="second-image">Fotos</label>
                <input type="file" name="second-image[]" multiple required>
                
            </div>
        </div>
        <div class="row" style="text-align: center;">
            <button type="submit" class="btn btn-default" style="margin-bottom: 5rem;">
                Guardar
            </button>
        </div>
    </form>
    </div>

@else
<p>You are not allowed to enter this page.</p>
@endif
@endsection
