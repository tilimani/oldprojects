@extends('layouts.app')
@section('title', 'Completar Registro')
@section('content')

<style type="text/css">
.file-upload {
    position: relative;
    display: inline-block;
}

.file-upload__label {
  display: block;
  padding: 1em 2em;
  color: #3a3a3a;
  background: lightgrey !important;
  border-radius: .4em;
  transition: background .3s;
  }
   
   .file-upload__label:hover {
     cursor: pointer;
     background: grey !important;
     } 

.file-upload__input {
    position: absolute;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    font-size: 1;
    width:0;
    height: 100%;
    opacity: 0;
}

</style>
<div class="container">
    <div class="col-12 mx-auto mt-4">
        <h3>Por favor completa estos datos para poder seguir con el proceso de publicar una VICO.</h3>
        <form method="post" action="/users/completeRegisterManager" accept-charset="UTF-8" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <div class="form-group col-12">
                    <label for="description">Describe quien eres: Esa descripción es pública y es visible en el anuncio de tu VICO.</label>
                    <textarea class="form-control" name="description" rows="3" maxlength="766" placeholder="Habla un poco de ti: Cómo eres como persona, que haces en tu tiempo libre, en que trabajas?" required></textarea>
                </div>

                <div class="form-group col-12">
                    <p>Suba por favor una foto tuya de perfil, esa será visible en el anuncio de tu VICO.</p>
                    <div class="file-upload">
                    <label for="manager_image" class="file-upload__label"><span class="icon-next-fom"></span> Upload Foto en JPEG, PNG.</label>
                    <input id="manager_image" type="file" name="manager_image" class="file-upload__input">
                    </div>
                </div>
                
              </div>
            {{-- <button type="submit" class="btn btn-primary" value=0>Finalizar Registro</button> --}}
            <button type="submit" class="btn btn-primary" name="go_create" value=1>Guardar & crear VICO</button>
        </form>
    </div>
</div>
@endsection
