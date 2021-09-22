@extends('layouts.app')

@section('styles')

<!--
    No se hace referencia a los archivos.
    Aun no se sabe como hacer debbuger a los *.js despues de "npm run dev"
    -->

<style type="text/css">

    .delete-image-gallery {
        width: 250px;
        margin: 0;
    }
</style>

@endsection

@section('content')

    <br>

    <div class="container">

        <!-- @if (Auth::user() && Auth::user()->email === 'friendsofmedellin@gmail.com' || true) -->

        <form method="POST" action="{{ URL::to('/houses/editnew/images/update') }}" accept-charset="UTF-8" enctype="multipart/form-data">

            {{ csrf_field() }}

            <div class="row edit-form-houses">
                
                <div>
                    <a  onclick="window.close()"
                        data-scroll class="btn btn-primary" role="button">
                        <i class="fas fa-arrow-left"></i>
                        Volver
                    </a>
                </div>

                <section id="deletePic" onclick="confirmDelete(this)">
                    <span>
                        <input type="hidden" name="house_id" value="{{ $house->id }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-trash-alt"></i>
                            Seleccionar y borrar
                        </button>
                    </span>
                </section>

                <div>
                    @if (\Session::has('success_change_image'))
                        <div class="alert-success">
                            <ul>
                                <li>{!! \Session::get('success_change_image') !!}</li>
                            </ul>
                        </div>
                        
                    <label for="file-upload-edit" class="subir btn btn-primary" >
                        <i class="fas fa-file-upload"></i>
                        Subir archivo
                    </label>
                    <input id="file-upload-edit" autofocus type="file" accept="image/*" multiple name="new_image_profile[]" style='display: none;'/>
                    <div id="info" style="display: inline-block"></div>

                    @else
                    <label for="file-upload-edit" class="subir btn btn-primary" >
                        <i class="fas fa-file-upload"></i>
                        Subir archivo
                    </label>
                    <input id="file-upload-edit" type="file" accept="image/*" multiple name="new_image_profile[]" style='display: none;'/>
                    <div id="info-edit" style="display: inline-block"></div>

                    @endif
                    <button type="submit" class="btn btn-primary" style="display: inline-block">
                        <i class="fas fa-save"></i>
                        Guardar Cambios
                    </button>
                </div>

            </div>

            <div class="row m-0 houses-gallery">

                @foreach($house->images as $image)
                    <div class="position-relative">
                        <label class="delete-checkbox" style="display:none">
                            <input type="checkbox" onclick="onclick_input(this)" class="option-input radio checkbox" />
                        </label>
                        <input type="hidden" accept="image/*" name="image_{{ $image->id }}" value="0">
                        <div class="m-2 swappable" id="{{$image->id}}" name="gallery">
    
                            <input type="hidden" accept="image/*" name="gallery[]" value="{{$image->id}}">
    
                            <img class="delete-image-gallery"
                                src="https://fom.imgix.net/{{ $image->image }}?w=750&h=500&fit=crop">
    
                        </div>
                    </div>

                @endforeach

            </div>

        </form>
        <!-- @else
            <p>You are not allowed to enter this page.</p>
        @endif -->

    </div>

    @section('scripts')
    
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

        // function confirmDelete(element) {

        //     if (confirm('Esta seguro de borrar las imagenes')) {
        //         $(element).next().click();
        //     }

        //     return false;

        // }
        

    </script>
    
    @endsection
    
@endsection
