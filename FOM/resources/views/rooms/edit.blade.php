@extends('layouts.app')

@section('title', 'editar habitación')

@section('content')
@if (Auth::user() && Auth::user()->email === 'friendsofmedellin@gmail.com' || true)

<style type="text/css">
    @media (min-width: 350px){
        .container{
            padding-top: 5rem;
            padding-left: 15px;
            padding-right: 15px;
            overflow-x: hidden;
        }
    }
    @media (min-width: 1200px){
        .container {
        }
    }

    @media (min-width: 992px){
        .container {
            width: 970px;
            overflow-x: hidden;

        }
    }
    @media (min-width: 768px){
        .container {
            width: 750px;
            overflow-x: hidden;

        }
    }
    @media (min-width: 1200px){
        .container{
            margin-right: 135px;
            margin-left:135px;
            padding-left: 15px;
            padding-right: 15px;
            width: 1170px;
            overflow-x: hidden;

        }
    }
    .house-img{
        width: 100%;
    }
    .house-desc{
        font-size:18px;
        font-weight: 300;
        line-height: 1.618;
        color: #999999;
    }
    .carousel-control span{
        color: grey !important;
    }
    .house-rules a{
        color: #ea960f;
    }
    .img-room{
        min-width: 100%;
    }
    .room-disponibility{
        position: absolute;
        float: left;
        bottom: 1.9rem;
        margin-left: 2rem;
    }



</style>

<div class="row">
    <div class="col-12 px-4 pt-4 pb-2">
        <a  onclick="window.close()"
        data-scroll class="btn btn-primary" role="button">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
    </div>
    <div class="col-12">
     <h2 id="editTitle">Editar Habitación {{ $data->number }}</h2>
    </div>
</div>


<hr class="w-57 mt-0">
@if ($errors->any())
<div class="container">
    <h2>Editar Habitación {{ $data->number }}</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
@endif
  
<form method="POST" action="{{ URL::to('/rooms/update') }}" accept-charset="UTF-8" enctype="multipart/form-data" class="editForm">
    {{ csrf_field() }}
    <section class="editRight">
        <div class="row form-title">
            <h3 class="d-flex justify-content-center white">Datos de Habitación</h3>
        </div>
        <input type="hidden" name="id" value="{{$data->id}}">
        <div class="row">
            <div class="form-group col-sm-6">
                <label for="number">Numero de habitación</label>
                <input type="number" class="form-control" name="number" placeholder="Numero de habitación" readonly required autofocus value="{{ $data->number }}">
            </div>
            <div class="form-group col-sm-6">
                <label for="price">Precio</label>
                <input type="number" class="form-control" name="price" placeholder="Precio" maxlength="32" required value="{{ $data->price}}">
            </div>
        </div>   
        <div class="row">
            <div class="form-group col-12">
                <label for="nickname">Tu nombre para la habitación (solamente visible para ti)</label>
                <input type="text" class="form-control" name="nickname" placeholder="Master Suite" autofocus value="{{ $data->nickname }}">
            </div>
        </div>   
        <div class="row">
            <div class="form-group col-sm-6">
                <label for="bed_type">Tipo de cama</label>
                <select class="form-control custom-select sources" name="bed_type" required>
                    @if($devices->bed_type === 'sencilla')
                    <option value='sencilla' selected>sencilla</option>
                    <option value='doble'>doble</option>
                    <option value='semi-doble'>semi-doble</option>
                    @elseif($devices->bed_type === 'doble')
                    <option value='sencilla'>sencilla</option>
                    <option value='doble' selected>doble</option>
                    <option value='semi-doble'>semi-doble</option>
                    @elseif($devices->bed_type === 'semi-doble')
                    <option value='sencilla' >sencilla</option>
                    <option value='doble'>doble</option>
                    <option value='semi-doble' selected>semi-doble</option>
                    @else
                    <option selected disabled>-- seleccione --</option>
                    <option value='sencilla' >sencilla</option>
                    <option value='doble'>doble</option>
                    <option value='semi-doble'>semi-doble</option>
                    @endif
                </select>
            </div>
    
            <div class="form-group col-sm-6">
                    <label for="bath_type">Baño</label>
                <select class="form-control" name="bath_type" required>
                    <option selected disabled>-- seleccione --</option>
                    @if($devices->bath_type === 'privado')
                    <option value='privado' selected>Privado</option>
                    <option value='compartido'>Compartido</option>
                    @else
                    <option value='privado'>Privado</option>
                    <option value='compartido' selected>Compartido</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6">
                <label for="desk">Tiene escritorio</label>
                <select class="form-control" name="desk" required>
                    <option selected disabled>-- seleccione --</option>
                    @if($devices->desk === 0)
                    <option value='0'  type="number" selected>No</option>
                    <option value='1' type="number" >Si</option>
                    @else
                    <option value='0' type="number" >No</option>
                    <option value='1' type="number" selected>Si</option>
                    @endif
                </select>
            </div>
    
            <div class="form-group col-sm-6">
                <label for="has_tv">Tiene TV</label>
                <select class="form-control" name="has_tv" required>
                    <option selected disabled>-- seleccione --</option>
                    @if($devices->tv === 1)
                    <option value='0' type="number" >No</option>
                    <option value='1' type="number" selected>Si</option>
                    @else
                    <option value='0'  type="number" selected>No</option>
                    <option value='1' type="number" >Si</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-3">
                    <label for="has_closet">Tiene Closet</label>
                <select class="form-control" name="has_closet" required>
                    <option selected disabled>-- seleccione --</option>
                    @if($devices->closet === 1)
                    <option value='0' type="number" >No</option>
                    <option value='1' type="number" selected>Si</option>
                    @else
                    <option value='0'  type="number" selected>No</option>
                    <option value='1' type="number" >Si</option>
                    @endif
                </select>
            </div>
            <div class="form-group col-sm-3">
                <label for="window_type">Ventana hacia</label>
                <select class="form-control" name="window_type" required>
                    <option selected disabled>-- seleccione --</option>
                    @if($devices->windows_type === 'adentro')
                    <option value='adentro' selected>adentro</option>
                    <option value='afuera'>afuera</option>
                    <option value='patio'>el patio</option>
                    <option value='sin_ventana'>Sin ventana</option>
                    @elseif($devices->windows_type === 'afuera')
                    <option value='adentro'>adentro</option>
                    <option value='afuera' selected>afuera</option>
                    <option value='patio'>el patio</option>
                    <option value='sin_ventana'>Sin ventana</option>
                    @elseif($devices->windows_type === 'patio')
                    <option value='adentro'>adentro</option>
                    <option value='afuera'>afuera</option>
                    <option value='patio' selected>el patio</option>
                    <option value='sin_ventana'>Sin ventana</option>
                    @else
                    <option value='adentro'>adentro</option>
                    <option value='afuera'>afuera</option>
                    <option value='patio'>el patio</option>
                    <option value='sin_ventana' selected="">Sin ventana</option>
                    @endif
                </select>
            </div>
    
           
            <div class="form-group col-sm-3">
                <label for="available_from">Disponibilidad desde:</label>
                <input type="text" class="form-control" id="date" name="available_from" placeholder="dd/mm/yyyy" required autocomplete="off"  value="{{ date_format(date_create($data->available_from), 'd/m/Y') }}">
            </div>
        </div>
        <div clas="row">
            <div class="form-group col-sm-12">
                <label for="description">Descripcion</label>
                <textarea class="form-control" name="description" rows="3" maxlength="766" required>
                {{ $data->description }}
                </textarea>
            </div>
        </div>
        <div class="row">
            <p style="font-size: 85%">Puedes subir una foto para generar más confianza para las otras personas en VICO.</p>
            <div>
                @if (\Session::has('success_change_image'))
                    <div class="alert-success">
                        <ul>
                            <li>{!! \Session::get('success_change_image') !!}</li>
                        </ul>
                    </div>
                    
                <label for="file-upload-edit" class="subir btn btn-primary" style="display: inline-block; margin-top: 2%">
                    <i class="fas fa-file-upload"></i>
                    Subir fotos
                </label>
                <input id="file-upload-edit" autofocus type="file" accept="image/*" multiple name="new_image_profile[]" style='display: none;'/>
                <div id="info" style="display: inline-block"></div>
                {{-- <input autofocus class="form-control form-group" type="file" name="new_image_profile" id="new_image_profile" style="display: inline; width: 50%" > --}}
                @else
                <label for="file-upload-edit" class="subir btn btn-primary" style="display: inline-block; margin-top: 2%">
                    <i class="fas fa-file-upload"></i>                
                    Subir fotos
                </label>
                <input id="file-upload-edit" type="file" accept="image/*" multiple name="new_image_profile[]" style='display: none;'/>
                <div id="info-edit" style="display: inline-block"></div>
                {{-- <input class="form-control form-group" type="file" name="new_image_profile" id="new_image_profile" style="display: inline; width: 50%" > --}}
                @endif
                <button type="submit" class="btn btn-primary" style="display: inline-block">
                    <i class="fas fa-save"></i>
                    Guardar Cambios
                </button>
            </div>
        </div>
    </section>


    <div class="editGallery">
            <section id="deletePic" onclick="confirmDelete(this)">
                <span>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-trash-alt"></i>
                        Seleccionar y borrar
                    </button>
                </span>
            </section>
            
            @forelse($images as $id => $image)
            <div>
                <label class="delete-checkbox" style="display:none">
                    <input type="checkbox" onclick="onclick_input(this)" class="option-input radio checkbox" />
                </label>
                <input type="hidden" name="image_{{ $image->id }}" value="0">
                <div class="m-0 swappable" onclick="onclick_img(this)" name="gallery" id="{{$id}}" data-priority="{{$image->priority}}">
                    <input type="hidden" name="gallery[]" value="{{$image->id}}">
                    <img id="{{$image->image}}" src="http://fom.imgix.net/{{ $image->image }}" class="img-responsive delete-image-gallery" alt="Responsive image">
                </div>
            </div>
            @empty
            @endforelse    
            
    </div>
</form>

@else
    <p>You are not allowed to enter this page.</p>
@endif
@endsection



<script src="//code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@shopify/draggable@1.0.0-beta.6/lib/draggable.bundle.js"></script>

<script type="text/javascript">

    function confirmDelete(e){
        $(e).toggleClass('deleteConfirm');
        if($(e).hasClass('deleteConfirm')){
            $('.delete-checkbox').show();
        }else{
            $('.delete-checkbox').hide();
        }
    }

    function onclick_input(element) {
        
        $(element.parentNode.nextElementSibling.nextElementSibling).toggleClass('selected-red');

        if ($(element.parentNode.nextElementSibling.nextElementSibling).hasClass('selected-red')) 
            $(element.parentNode.nextElementSibling.nextElementSibling).prev().val('1');
        else $(element.parentNode.nextElementSibling.nextElementSibling).prev().val('0');

    }

</script>