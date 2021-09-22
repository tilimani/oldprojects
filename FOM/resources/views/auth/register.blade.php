@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-md-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Register</div>
                <div class="card-body">
                    <form role="form" method="POST" action="{{ url('/register') }}">
                        {{csrf_field()}}
                        <div class="row">
                        <div class="col-6">
                            <input type="text" name="name" id="manager-name" class="form-control form-group" placeholder="Nombre"  required>
                        </div>
                        <div class="col-6">
                            <input type="text" name="lastname" id="manager-lastname" class="form-control form-group" placeholder="Apellido"  required>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-6">
                            <input type="email" name="email" id="manager-email" class="form-control form-group" placeholder="Email"  required>
                        </div>
                        <div class="col-6">
                            <input type="password" name="password" id="manager-password" class="form-control pass form-group" placeholder="Contraseña"  required autocomplete="off">
                            <span toggle="#password-field-reg" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-12">
                            <input type="tel" name="cellphone" id="manager-cellphone" class="form-control  form-group" placeholder="Número de WhatsApp"  required>
                        </div>
                        </div>

                        <div class="row my-3">
                        <div class="col-12">
                            <label for="country">¿De dónde eres?</label>
                            <select class="form-control " name="country" id="manager-lista-usuarios" required>
                        </select>
                        </div>
                        </div>
                        <div class="row justify-content-center my-3">
                        <div class="col-6 col-sm-3 form-check">
                            <input type="radio" name="gender" id="manager-create-male" value="1" required>
                            <label for="create-male">
                            <span class=" display-4 icon-man"></span>
                            </label>
                        </div>
                        <div class="col-6 col-sm-3 form-check">
                            <input type="radio" name="gender" id="manager-create-female" value="2">
                            <label for="create-female">
                            <span class=" display-4 icon-woman"></span>
                            </label>
                        </div>
                        </div>
                        <label for="is_manager"><input type="checkbox" name="is_manager" checked=true> Soy dueño de una VICO.</label>
                        <button type="submit" style="display: none;" id="manager-btnregister"></button>
                        <button class="btn btn-primary btn-block" onclick="registerManager()">Registrarme</button>
                        <div class="col-12 d-flex justify-content-center">

                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function registerManager(){
  var dial=document.getElementsByClassName("selected-dial-code");
  var phone=document.getElementById("manager-cellphone").value;
  $("#manager-cellphone").value=dial[1].innerHTML+phone;
  $("#manager-btnregister").click({
    utillsScript: "node_modules/intl-tel-input/build/js/utils.js"
  });
}
</script>
@endsection
