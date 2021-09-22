@extends('layouts.app')
@section('title', 'Gracias por crear tu VICO')
@section('content')

@if (Auth::user() && (Auth::user()->role_id === 1 || Auth::user()->role_id === 2))


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

  <div class="justify-content-center create">
      <div class="col-12 col-md-8 mx-md-auto create-vico">
        <div class="row justify-content-center m-3">
          <h2 class=" display-4 col-12 text-center font-weight-bold">¿Y ahora?</h2>
        </div>
        <div id="create-first-form">
          <div class="create-title">
            <h5 class="font-weight-normal">¡Felicitaciones! Solamente faltan muy pocos pasos para encontrar clientes para tu VICO. ¡Pronto nos vamos a poner en contacto contigo!</h5>
          </div>

          <div class="create-advantage mt-5">
            <div class="advantage">
              <div class="row">
                <div class="col-sm-2 col-3 advantage-icon">
                  <span class="icon-house-orange display-2 d-inline">
                    <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span>
                  </span>
                </div>
                <div class="col-sm-10 col-9 ">
                  <h4 class="bold">Verificación de información:</h4>
                  <p>Estamos revisando si la información sobre tu VICO esta completa.
                  </p>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-2 col-3 advantage-icon">
                  <span class="icon-smartphone-orange display-2 d-inline">
                    <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span>
                  </span>
                </div>
                <div class="col-sm-10 col-9 ">
                  <h4 class="bold">Sesión de fotos:</h4>
                  <p>Las fotos juegan un rol principal en la presentación de tu VICO. Por eso VICO te regala una sesión de fotos gratis para tu VICO.
                  </p>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-2 col-3 advantage-icon">
                  <span class="icon-guest-orange display-2 d-inline">
                    <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span>
                  </span>
                </div>
                <div class="col-sm-10 col-9 ">
                  <h4 class="bold">Nuevos amigos para tu VICO: </h4>
                  <p>¡Todo listo! Tu VICO está online. Nos comunicaremos contigo cuando un estudiante quiera reservar una habitación tuya.</p>
                </div>
              </div>
            </div>
          </div>
          <div class="create-info">
            <p class="bold"><strong>¡Recuerda!</strong></br>Para brindarte un mejor servicio, necesitamos que actualices la disponibilidad de las habitaciones. Apenas se ocupe o desocupe una habitación, debes actualizar la info de tu VICO en FOM.</p>
          </div>
          <div class="create-init ">
            <a class="btn-init mb-3" href="{{route('my_houses')}}" ><h4 class="mb-0">Ver mis VICO</h4></a>
            {{-- {{$id_house}} --}}
          </div>
        </div>

      </div>
    </div>


@else
<p>You are not allowed to enter this page.</p>
@endif

@endsection
@section('scripts')

      <script type="text/javascript">


    window.onload = function()
  {

    history.pushState(null, null, location.href);
      window.onpopstate = function () {
      history.go(1);
    };




  }
      </script>

      @endsection
