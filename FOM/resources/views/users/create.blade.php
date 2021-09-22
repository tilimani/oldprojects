@extends('layouts.app')
@section('content')
@if (Auth::user() && Auth::user()->email === 'friendsofmedellin@gmail.com' || true)
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <br/>
    <br/>
    <br/>
    <br/>

<form  method="post" action="/users/newUser">
  {{ csrf_field() }}
  <div class="col-xs-12 without-padding">
    <h4>Crear cuenta</h4>
  </div>

  <div class="row">
    <div class="form-group col-sm-6">
      <label for="name">Nombre</label>
      <input type="text"  class="form-control" name="name">
    </div>
    <div class="form-group col-sm-6">
      <label for="lastname">Apellido</label>
      <input type="text"  class="form-control" name="lastname">
    </div>
  </div>

  <div class="row">
    <div class="form-group col-sm-6">
      <label for="email">E-Mail</label>
      <input type="mail"  class="form-control" name="email">
    </div>
    <div class="form-group col-sm-6">
      <label for="cellphone">Celular</label>
      <input type="text"  class="form-control" name="cellphone">
    </div>
  </div>

  <div class="row">
    <div class="form-group col-sm-6">
      <label for="photo">Foto</label>
      <input type="file"  class="form-control" name="photo">
    </div>
    <div class="form-group col-sm-6">
      <label for="Description">Descripcion</label>
      <textarea class="form-control" style="resize: none;" name="Description"></textarea >
    </div>
  </div>

  <div class="row">
    <div class="form-group col-sm-6">
      <label for="gender">Genero</label>
      <select class="form-control" name="gender">
        <option selected> --seleccione--</option>
        <option value=1>Hombre</option>
        <option value=2>Mujer</option>
        <option value=3>Otro</option>
      </select>
    </div>
    <div class="form-group col-sm-6">
      <label for="country">Pais</label>
      <select class="form-control" name="country">
        <option selectedccione--</option>
        @foreach($countries as $country)
        <option value={{$country->id}}>{{$country->name}}</option>
        @endforeach
      </select>
    </div>
  </div>

  <div class="row">
    <div class="form-group col-sm-6">
      <label for="rol">Rol</label>
      <select class="form-control" id="rol" name="rol">
        <option selected>--seleccione--</option>
        <option value=2>Manager</option>
        <option value=3>Estudiante</option>
      </select>
    </div>
    <div style="display: none;" id="vip" class="form-group col-sm-6">
      <label for="vip">VIP</label>
      <select class="form-control" name="vip">
        <option value=0 selected>--seleccione--</option>
        <option value=1>Si</option>
        <option value=0>No</option>
      </select>
    </div>
  </div>
  <div class="row">
    <div class="form-group col-sm-6">
      <input type="hidden" name="password" value="userfom">
    </div>
    <div class="form-group col-sm-6">
      <input type="hidden" name="flag" value=1>
    </div>
  </div>
  <div class="text-center ">
    <button type="submit" class="btn btn-default btn-reserv">Registrar</button>
  </div>

</form>

@else
<p>You are not allowed to enter this page.</p>
@endif

@endsection

@section('scripts')
<script type="text/javascript">
   var select = document.getElementById('rol');
   var vip=document.getElementById('vip');
   select.addEventListener('change',function(){
    console.log(select);
    if(select.value==2){
      vip.style="display: block;";
    }
    else{
      vip.style="display: none;";
    }
    });
</script>
@endsection
