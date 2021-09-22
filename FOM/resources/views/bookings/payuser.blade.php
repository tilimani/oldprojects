@extends('layouts.app')
@section('title', 'pago de vico')

@section('styles')

  <style type="text/css">

  .booking-show-process-circle{
    width: 6rem;
    height: 6rem;
    position: absolute;
    right: -0.4rem;
    background-color: transparent;
    border-radius: 50%;
    display: inline-block;
    border: 0px solid #9a9a9a;
    float: right;
    line-height: 1.4 !important;
    top: -.5rem;
  }

  .booking-show-process-icon{
    font-size: 4rem;
    margin-bottom: 2rem;
    line-height: 1.4rem !important;
  }

  .booking-show-process-card-mobile{
    position: -webkit-sticky;
    position: sticky;
    bottom: 0;
    z-index: 1020;
    width: 100vw;
    position: sticky;
    background-color: white;
    border-top: 0.25px solid rgba(0, 0, 0, 0.2);
    border-bottom: 0.25px solid rgba(0, 0, 0, 0.2);
    z-index: 11;
    bottom: -3px;
  }

}

.font-color-orange{
  color: #ea960f;
}

.border-color-orange{
  border-color: #ea960f;
}


.speech-bubble {
  position: relative;
  background: #ea960f;
  border-radius: .4em;
  color: white;
  padding: 10px;
}



.speech-bubble:after {
  content: '';
  position: absolute;
  left: 0;
  top: 50%;
  width: 0;
  height: 0;
  border: 1.438em solid transparent;
  border-right-color: #ea960f;
  border-left: 0;
  border-bottom: 0;
  margin-top: -0.719em;
  margin-left: -1.437em;
}

.booking-show-caption{
  background-color: rgba(234, 150, 15, 0.6);
  color: #fff;
  padding: .4rem 1.4rem;
  position: relative;
  height: 4rem;
  width: 100%;
  margin-top: -4rem;
}
.booking-show-flag{
  position: relative;
  right: 1.3rem;
  top: 2.5rem;
  width: 1.5rem;
  height: 1.5rem;
}
.booking-show-date-day{
  font-size: 3.3rem;
  line-height: 1;
}
.booking-show-date-month{
  line-height: 1rem;
  font-size: 1.5rem;
}
.booking-show-date-year{
  font-size: 1.2rem;
}
.booking-show-image{
  margin-left:-30px;
  margin-right:-30px;
}


</style>
@endsection
{{--END SECTION:STYLES--}}
@section('content')



  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- dd($booking) --}}
  {{--  Esta información era utilizada para ver que salía de base de datos.
  <ul class="text-center">
  <li>nombre: {{$booking->name}}</i><br>
  <li>nombre casa: {{$booking->house_name}}</i><br>
  <li>numero habitacion:  {{$booking->room_id}}</i><br>
  <li>precio: {{$booking->price}}</i><br>
  <li>imagen: {{$image_room}}</i><br>
  <li>desde: {{$booking->date_from}}</i><br>
  <li>hasta: {{$booking->date_to}}</i><br>
  <li>admin name: {{$booking->manager_info->name}}</i><br>
  <li>admin description: {{$booking->manager_info->description}}</i><br>
  <li>admin image: {{$booking->manager_info->image}}</i><br>
  <li>admin email: {{$booking->manager_info->email}}</i><br>
  <li>admin flag: {{$booking->manager_info->icon}}</i><br>
  <li>message: {{$booking->message}}</i><br>
  <li>fecha limite: {{$date_limit}}</i><br>
</ul>
--}}
{{--PAGE HEADER CONTAINER--}}
<div class="container mt-4">
  <p class="text-right"></p>
  <p class="h2 font-color-orange text-center">¡Lo lograste, {{$booking->name}}!</br><small>{{$booking->manager_info->name}} aceptó tu solicitud de reservarte la vico: {{$booking->house_name}}</small></p>
  <hr class="w-75 border-color-orange">
</div>
{{--END PAGE HEADER CONTAINER--}}
{{-- CONTAINER UNDER FOTO --}}
<div class="container">
  {{-- ROW CONTENT --}}
  <div class="row ml-3 mr-3 m-md-0">
      {{-- COL LEFT --}}
      <div class="col-12 col-lg-7 pr-0 pl-0">
          <div class="row">
              <div class="col">
                  <p class="d-none d-lg-block">Fecha de llegada: <span class="font-weight-bold"> {{date("D, d. M Y", strtotime($booking->date_from))}} </span></p>
                  <p class="d-none d-lg-block">Fecha de salida <span class="font-weight-bold"> {{date("D, d. M Y", strtotime($booking->date_to))}}</span></p>
              </div>
          </div>
          {{-- DIV IMAGE --}}
          <div class="row m-lg-0 booking-show-image">
              <img src="http://fom.imgix.net/{{$image_room}}?w=750&h=500&fit=crop" class="w-100 h-100">
              <div class="row m-0 booking-show-request">
                      <p class="d-lg-none d-flex justofy-content-center">< Ver mis solicitudes</p>
              </div>
              {{-- CAPTION FOTO --}}
              <div class="booking-show-caption">
                  {{-- START ROW DATES AND CALENDAR --}}
                  <div class="row ml-md-4 mr-md-4 pl-md-4 pr-md-4 ml-lg-0 mr-lg-0 pl-lg-0 pr-lg-0">
                      {{-- COL DATE LEFT --}}
                      <div class="col-4">
                          <div class="row">
                              <div class="col-6 mt-auto">
                                  <ul class="bullet-points-off">
                                      <li class="booking-show-date-month">{{date('M', strtotime($booking->date_from))}}</li>
                                      <li class="booking-show-date-year">{{date('Y', strtotime($booking->date_from))}}</li>
                                  </ul>
                              </div>
                              <div class="col-6 pl-1">
                                  <span class="booking-show-date-day">{{date('d', strtotime($booking->date_from))}}</span>
                              </div>

                          </div>
                      </div>
                      {{-- END COL DATE LEFT --}}
                      {{-- COL MIDDLE CALENDAR --}}
                      <div class="col-4 text-center ">
                          <span class="icon-calendar-white" style="font-size: 2.9rem; text-align: right;"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span><span class="path11"></span><span class="path12"></span><span class="path13"></span><span class="path14"></span><span class="path15"></span><span class="path16"></span><span class="path17"></span><span class="path18"></span><span class="path19"></span><span class="path20"></span><span class="path21"></span><span class="path22"></span><span class="path23"></span><span class="path24"></span><span class="path25"></span><span class="path26"></span><span class="path27"></span></span>
                      </div>
                      {{-- END COL MIDDLE CALENDAR --}}
                      {{-- COL RIGHT DATE --}}
                      <div class="col-4">
                          <div class="row">
                              <div class="col-6 pl-1">
                                  <span class="booking-show-date-day">{{date('d', strtotime($booking->date_to))}}</span>
                              </div>
                              <div class="col-6  mt-auto">
                                  <ul class="bullet-points-off">
                                      <li class="booking-show-date-month">{{date('M', strtotime($booking->date_to))}}</li>
                                      <li class="booking-show-date-year">{{date('Y', strtotime($booking->date_to))}}</li>
                                  </ul>
                              </div>
                          </div>
                      </div>
                      {{-- END COL RIGHT DATE --}}
                  </div>
                  {{-- END ROW DATES AND CALENDAR --}}
              </div>
              {{-- END CAPTION FOTO --}}
          </div>
          {{-- END DIV IMAGE --}}

          <div class="hab-description">
              <p class="h4 mb-0"><strong>HAB {{$room->number}} - {{$room->price}} COP</strong></p>
              <p class="h4 mb-0"><strong>Nickname de la habitación</strong></p>
              <p class="h4 mb-0 mb-sm-0 vico-color">{{$house->name}} ></p>
              <p class="h4 mb-0 mb-sm-0">{{date('d/m/y', strtotime($booking->date_from))}} - {{date('d/m/y', strtotime($booking->date_to))}}</p>
          </div>
          <hr class="w-75">

          <hr class="w-75">

          <div class="row">
              <div class="col-12">
                  <ul class="nocenter progress-indicator stepped stacked bubble">
                      <li class="">
                      @if($booking->status == 1)
                          <li class="active">
                      @endif
                      @if($booking->status > 1)
                          <li class="completed">
                      @endif
                          <span class="bubble"></span>
                          <span class="stacked-text">
                              <span><h5><strong>disponibilidad</strong></h5></span>
                              <span class="subdued"></span>
                          </span>
                      </li>
                      <li class="">
                          @if($booking->status == 2)
                              <li class="active">
                          @endif
                          @if($booking->status > 2)
                              <li class="completed">
                          @endif
                          <span class="bubble"></span>
                          <span class="stacked-text">
                              <span><h5>Voluntad de pago</h5></span>
                              <span class="subdued"></span>
                          </span>
                      </li>
                      <li class="">
                          @if($booking->status == 3)
                              <li class="active">
                          @endif
                          @if($booking->status > 3)
                              <li class="completed">
                          @endif
                          <span class="bubble"></span>
                          <span class="stacked-text">
                              <span><h5>plazo 48 horas</h5></span>
                              <span class="subdued"></span>
                          </span>
                      </li>
                      <li class="">
                          @if($booking->status == 4)
                              <li class="active">
                          @endif
                          @if($booking->status > 4)
                              <li class="completed">
                          @endif
                          <span class="bubble"></span>
                          <span class="stacked-text">
                              <span><h5>Proceso de pago</h5></span>
                              <span class="subdued"></span>
                          </span>
                      </li>
                      <li class="">
                          @if($booking->status == 5)
                              <li class="active">
                          @endif
                          @if($booking->status > 5)
                              <li class="completed">
                          @endif
                          <span class="bubble"></span>
                          <span class="stacked-text">
                              <span><h5>Confirmación</h5></span>
                              <span class="subdued"></span>
                          </span>
                      </li>
                  </ul>
              </div>
          </div>


          <hr class="w-75">
          {{-- Row Heading
          <div class="row mt-4 mb-0">
              <div class="col">
              <p class="font-weight-light">Datos del Inquilino:</p>
              </div>
          </div> --}}


          {{-- Row Mode  --}}

          <div class="row">
              <div class="col-3 d-flex justify-content-center">
                  @if(isset($booking->image))
                      <img class="img-responsive rounded-circle" style="width: 4rem; height: 4rem;margin-left: 2rem" src="http://fom.imgix.net/{{$booking->image}}?w=500&h=500&fit=crop" alt="Administrador">
                  @elseif($booking->manager_info->gender== 2)
                      <img class="img-responsive rounded-circle" style="width: 4rem; height: 4rem;margin-left: 2rem" src="http://fom.imgix.net/manager_47.png?w=500&h=500&fit=crop" alt="Administrador">
                  @else
                      <img class="img-responsive rounded-circle" style="width: 4rem; height: 4rem;margin-left: 2rem" src="http://fom.imgix.net/manager_7.png?w=500&h=500&fit=crop" alt="Administrador">
                  @endif
                  {{-- <img class="booking-show-flag rounded-circle" src="/images/flags/{{$booking->icon}}"> --}}
              </div>

              <div class="col-9">
                  <div class="row">
                      <div class="col">
                          <p> @if($booking->mode == 1)
                              <span class="h4 font-weight-bold">Solicitud online:</span>
                              @else
                              <span class="h4 font-weight-bold">Solicitud offline:</span>
                          @endif</p>
                      </div>
                  </div>
                  <div class="row text-left ">
                      <div class="col">
                          <p>@if($booking->mode==1)Quiere reservar online.
                              @else Quiere visitar la casa.
                          @endif</p>
                      </div>
                  </div>
              </div>
          </div>

          <hr class="w-75 mt-1">

          {{-- ROW INFORMACIÓN DEL INQUILINO --}}
          <div class="row">
              <div class="col-3 d-flex justify-content-center">
                  @if(isset($booking->image))
                      <img class="img-responsive rounded-circle" style="width: 4rem; height: 4rem;margin-left: 2rem" src="http://fom.imgix.net/{{$booking->image}}?w=500&h=500&fit=crop" alt="Administrador">
                  @elseif($booking->manager_info->gender== 2)
                      <img class="img-responsive rounded-circle" style="width: 4rem; height: 4rem;margin-left: 2rem" src="http://fom.imgix.net/manager_47.png?w=500&h=500&fit=crop" alt="Administrador">
                  @else
                      <img class="img-responsive rounded-circle" style="width: 4rem; height: 4rem;margin-left: 2rem" src="http://fom.imgix.net/manager_7.png?w=500&h=500&fit=crop" alt="Administrador">
                  @endif
                  {{-- <img class="booking-show-flag rounded-circle" src="/images/flags/{{$booking->icon}}"> --}}
              </div>

              <div class="col-9">
                  <div class="row">
                      <div class="col">
                          <p class="h3">{{$booking->manager_info->name}} {{$booking->manager_info->last_name}}</p>
                      </div>
                  </div>
                  <div class="row text-left ">
                      <div class="col">
                          <p>@if($booking->manager_info->gender==2)Mujer, {{$countries[1]->name}}
                              @else Hombre, {{$countries[1]->name}} @endif</p>
                      </div>
                  </div>
              </div>
          </div>
          {{-- END ROW INFORMACIÓN DEL INQUILINO --}}

          <hr class="w-75 mt-1">

          {{-- ROW SPEECHBUBBLE --}}
          @if($booking->message == "") @else
          <div class="row">
              <div class="col-12">
                  <p class="chat-item">@if($booking->message == "") - SIN MENSAJE - @else {{$booking->message}} <span class="time-chat">{{substr($today_time,0,5)}}</span> @endif </p>
              </div>
              <div class="col-12">
                <p class="chat-item">@if($booking->message == "") - SIN MENSAJE - @else {{$booking->message}} <span class="time-chat">{{substr($today_time,0,5)}}</span> @endif </p>
            </div>
          </div>
          @endif
          {{-- END ROW SPEECHBUBBLE --}}

          <hr class="w-75 mt-1">

          {{-- Row Cuantos rooms --}}
          {{-- @if($count===0) @else

              <div class="row">
                  <div class="col">
                      <p class="font-weight-light">{{$user->name}} ha solicitado {{$count}} @if($count===1) habitación @else habitaciones @endif más. Respóndele rápido para que se decide por tu habitación.</p>
                  </div>
              </div>
          @endif --}}

          {{-- Row Buttons --}}
          <div class="row mt-4 mb-4 right">
              <div class="col-12">
                  <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#Deny">Rechazar</button>
                  <button type="button" href="/booking/time/{{$booking->id}}" class="btn btn-primary" >Aceptar & responder</button>
              </div>
          </div>
          <div class="mt-4 mb-4 d-lg-block d-none"><br></br></div>
          {{-- Sticky Row Process --}}
          <div class="col mt-4 d-lg-none row booking-show-process-card-mobile ">
              <div class="col-12 pt-4">
                  <a href="#" data-toggle="modal" data-target="#owner-process"><p><span class="icon-idea-orange"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span></span> ¿Cómo funciona el proceso?</p></a>            </div>
          </div>
      </div>
      {{-- END COL LEFT --}}
      {{-- ==============START COL RIGHT: Process============== --}}
      <div class="col-lg-5 d-none d-lg-block">
          {{-- DIV STICKY START --}}
          <div class="sticky" style="top: 1rem">
                  {{-- ROW-PROCESS --}}
                  <div class="row mb-4">
                      {{-- PROCESS ICON --}}
                      <div class="col-3 text-center booking-show-process-icon">
                          <div class="booking-show-process-circle">
                              <span class="icon-choice" style="line-height: 1.4 !important;"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span></span>
                          </div>
                      </div>
                      {{-- END PROCESS ICON --}}
                      {{-- PROCESS EXPLANATION --}}
                      <div class="col-9 pr-0 pr-md-4">
                          <ul class="bullet-points-off">
                              <li><p class="h5 mb-0 mt-1">1. Aceptas o rechazas la solicitud</p>
                              </li>
                              <li><p class="font-weight-light">Antes de tomar la decisión deberías verificar que la habitación {{$room->number}} en {{$house->name}} realmente esta disponible. Después decides si quieres aceptar o rechazar la solicitud de {{$user->name}}. </p>
                              </li>
                          </ul>
                          <hr class="w-75 mt-0 mb-0">
                      </div>
                      {{-- END PROCESS EXPLANATION --}}
                  </div>
                  {{-- END ROW-PROCESS --}}

                  {{-- ROW-PROCES --}}
                  <div class="row mb-4">
                      {{-- PROCESS ICON --}}
                      <div class="col-3 text-center booking-show-process-icon">
                          <div class="booking-show-process-circle">

                              <span class="icon-48horas" style="line-height: 1.4 !important;"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span></span>
                      </div>
                      </div>
                      {{-- END PROCESS ICON --}}
                      {{-- PROCESS EXPLANATION --}}
                      <div class="col-9 pr-0 pr-md-4">
                          <ul class="bullet-points-off">
                              <li><p class="h5 mb-0 mt-1">2. Relájate y bloquea la habitación 48 horas</p>
                              </li>
                              <li><p class="font-weight-light">Ya cuando acepaste la solicitud puedes reljáte, el estudiante ahora tiene 48 horas para pagar el depósito. En este tiempo la habitación no puede ser ofrecida a nigúna otra persona, el pago ya está en proceso. Te mantegamos al tanto.</p>
                              </li>
                          </ul>
                          <hr class="w-75 mt-0 mb-0">
                      </div>
                      {{-- END PROCESS EXPLANATION --}}

                  </div>
                  {{-- END ROW-PROCESS --}}

                  {{-- ROW-PROCESS --}}
                  <div class="row mb-4">
                      {{-- PROCESS ICON --}}
                      <div class="col-3 text-center booking-show-process-icon">
                          <div class="booking-show-process-circle">
                              <span class="icon-deposit-orange" style="line-height: 1.4 !important;"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span><span class="path4"></span></span>
                          </div>
                      </div>
                      {{-- END PROCESS ICON --}}
                      {{-- PROCESS EXPLANATION --}}
                      <div class="col-9 pr-0 pr-md-4">
                          <ul class="bullet-points-off">
                              <li><p class="h5 mb-0 mt-1">3. Pago del depósito</p>
                              </li>
                              <li><p class="font-weight-light">Felicitaciones, el estudiante pagó el depósito (= 1 renta mensual). Tu habitación ya queda reservada.</p>
                              </li>
                          </ul>
                          <hr class="w-75 mt-0 mb-0">
                      </div>
                      {{-- END PROCESS EXPLANATION --}}

                  </div>
                  {{-- END ROW-PROCESS --}}

                  {{-- ROW-PROCESS --}}
                  <div class="row mb-4">
                      {{-- PROCESS ICON --}}
                      <div class="col-3 text-center booking-show-process-icon">
                          <div class="booking-show-process-circle">
                              <span class="icon-ballon-orange"style="line-height: 1.4 !important;"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
                          </div>
                      </div>
                      {{-- END PROCESS ICON --}}
                      {{-- PROCESS EXPLANATION --}}
                      <div class="col-9 pr-0 pr-md-4">
                          <ul class="bullet-points-off">
                              <li><p class="h5 mb-0 mt-1">Vivir entre amigos.</p>
                              </li>
                              <li><p class="font-weight-light">Si la gente en tu VICO esta feliz, tu también lo eres, porque puedes estar tranquilo y seguro de que las personas te van a recomendar a otros.</p>
                              </li>
                          </ul>
                      </div>
                      {{-- END PROCESS EXPLANATION --}}
                  </div>
                  {{-- END ROW-PROCESS --}}

              </div>
              {{-- END DIV STICKY --}}
          </div>
          {{-- ==============END COL RIGHT: Process============== --}}
  </div>
  {{-- END ROW CONTENT --}}
</div>
{{-- END CONTAINER UNDER FOTO --}}

{{-- MODAL ACCEPT --}}
<div class="modal fade" id="Acepted" tabindex="-1" role="dialog" aria-labelledby="Accepted request" aria-hidden="true"  style="overflow:scroll">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Aceptar solicitud</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="Deny" tabindex="-1" role="dialog" aria-labelledby="Accepted request" aria-hidden="true" style="overflow:scroll">
  <div class="modal-dialog">
    <div class="modal-content text-center">
      {{-- MODAL HEADER --}}
      <div class="modal-header">
        <h3 class="modal-title p-auto">¿Por qué rechazas la solicitud?</h3>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      {{-- MODAL BODY --}}
      <div class="modal-body">
        {{--AQUÍ IRÁ EL CONTENIDO DE:"CANCELAR LA SOLICITUD"--}}
        <div class="row text-center p-2">
          <div class="col-12">
            <button type="button" name="nolike" class="btn btn-primary">No me gustó</button><br/>
          </div>
        </div>
        <div class="row text-center p-2">
          <div class="col-12">
            <button type="button" name="otheroom" class="btn btn-primary">Tengo otra habitación</button><br/>
          </div>
        </div>
        <div class="row text-center p-2">
          <div class="col-12">
            <button type="button" name="othereason" class="btn btn-primary" data-toggle="collapse" data-target="#other">¿Otra razón?</button>
            <div id="other" class="collapse m-2">
              <input type="text" name="otherReasonCancel" value="" placeholder="Este campo es opcional" class="form-control">
              <button type="submit" class="btn btn-primary m-2">Enviar</button>
            </div>
          </div>
        </div>
      </div>
      {{-- MODAL FOOTER --}}
      <div class="modal-footer text-center">
        <button type="button" class="btn btn-link" data-dismiss="modal">Volver</button>
      </div>
    </div>
  </div>
</div>
{{-- ========= PROCESS MODAL ==========  --}}
<div class="modal fade" id="owner-process" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-centered" role="document">
    <div class="modal-content">
      <div class="modal-header align-items-center">
        <p class="modal-title h2 text-center" id="modalProcessTittle">Proceso de reserva</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><span class="icon-close"></span></span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          {{-- ROW-PROCESS --}}
          <div class="row mb-4">
            {{-- PROCESS ICON --}}
            <div class="col-3 text-center booking-show-process-icon">
              <div class="booking-show-process-circle">
                <span class="icon-choice" style="line-height: 1.4 !important;"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span></span>
              </div>
            </div>
            {{-- END PROCESS ICON --}}
            {{-- PROCESS EXPLANATION --}}
            <div class="col-9 pr-0 pr-md-4">
              <ul class="bullet-points-off">
                <li><p class="h5 mb-0 mt-1">1. Aceptas o rechazas la solicitud</p>
                </li>
                <li><p class="font-weight-light">Antes de tomar la decisión deberías verificar que la habitación {{$booking->room_id}} en {{$booking->house_name}} realmente esta disponible. Después decides si quieres aceptar o rechazar la solicitud de {{$booking->name}}. </p>
                </li>
              </ul>
            </div>
            {{-- END PROCESS EXPLANATION --}}
          </div>
          {{-- END ROW-PROCESS --}}

          {{-- ROW-PROCESS --}}
          <div class="row mb-4">
            {{-- PROCESS ICON --}}
            <div class="col-3 text-center booking-show-process-icon">
              <div class="booking-show-process-circle">
                <span class="icon-48horas" style="line-height: 1.4 !important;"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span></span>
              </div>
            </div>
            {{-- END PROCESS ICON --}}
            {{-- PROCESS EXPLANATION --}}
            <div class="col-9 pr-0 pr-md-4">
              <ul class="bullet-points-off">
                <li><p class="h5 mb-0 mt-1">2. Tienes 48 horas para pagar el deposito</p>
                </li>
                <li><p class="font-weight-light">Ya cuando acepaste la solicitud puedes reljáte, el estudiante ahora tiene 48 horas para pagar el depósito. En este tiempo la habitación no puede ser ofrecida a nigúna otra persona, el pago ya está en proceso. Te mantegamos al tanto.</p>
                </li>
              </ul>
            </div>
            {{-- END PROCESS EXPLANATION --}}
          </div>
          {{-- END ROW-PROCESS --}}

          {{-- ROW-PROCESS --}}
          <div class="row mb-4">
            {{-- PROCESS ICON --}}
            <div class="col-3 text-center booking-show-process-icon">
              <div class="booking-show-process-circle">
                <span class="icon-deposit-orange" style="line-height: 1.4 !important;"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span><span class="path4"></span></span>
              </div>
            </div>
            {{-- END PROCESS ICON --}}
            {{-- PROCESS EXPLANATION --}}
            <div class="col-9 pr-0 pr-md-4">
              <ul class="bullet-points-off">
                <li><p class="h5 mb-0 mt-1">3. Llegó el depósito.</p>
                </li>
                <li><p class="font-weight-light">Felicitaciones, el estudiante pagó el depósito (= 1 renta mensual). Tu habitación ya queda reservada.</p>
                </li>
              </ul>
            </div>
            {{-- END PROCESS EXPLANATION --}}
          </div>
          {{-- END ROW-PROCESS --}}

          {{-- ROW-PROCESS --}}
          <div class="row mb-4">
            {{-- PROCESS ICON --}}
            <div class="col-3 text-center booking-show-process-icon">
              <div class="booking-show-process-circle">
                <span class="icon-ballon-orange"style="line-height: 1.4 !important;"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
              </div>
            </div>
            {{-- END PROCESS ICON --}}
            {{-- PROCESS EXPLANATION --}}
            <div class="col-9 pr-0 pr-md-4">
              <ul class="bullet-points-off">
                <li><p class="h5 mb-0 mt-1">Vivir entre amigos.</p>
                </li>
                <li><p class="font-weight-light">Si la gente en tu VICO esta feliz, tu también lo eres, porque puedes estar tranquilo y seguro de que las personas te van a recomendar a otros.</p>
                </li>
              </ul>
            </div>
            {{-- END PROCESS EXPLANATION --}}
          </div>
          {{-- END ROW-PROCESS --}}
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
      </div>
    </div>
  </div>
</div>
{{-- ========= END MODAL PROCESS  ========== --}}
@endsection
@section('scripts')
  <script type="text/javascript">
  //payuserScreenshot btnScreenshot
  document.getElementById('btnScreenshot').addEventListener('click', openDialog);
  var target_date = new Date().getTime() + ({{$milliseconds}}); // set the countdown date, there valor is gotten of data base
  var days, hours, minutes, seconds; // variables for time units
  var contDays, contHours, contMinutes, contSeconds; //Container of each variables
  contDays = document.getElementById("counterDay"); //get tag of each element
  contHours = document.getElementById("counterHour");
  contMinutes = document.getElementById("counterMinute");
  contSeconds = document.getElementById("counterSecond");

  getCountdown();

  setInterval(function () { getCountdown(); }, 1000);
  function openDialog(){
    document.getElementById('payuserScreenshot').click();
  }
  function getCountdown(){

    // find the amount of "seconds" between now and target
    var current_date = new Date().getTime();
    var seconds_left = (target_date - current_date) / 1000;

    days = pad( parseInt(seconds_left / 86400) );
    seconds_left = seconds_left % 86400;

    hours = pad( parseInt(seconds_left / 3600) );
    seconds_left = seconds_left % 3600;

    minutes = pad( parseInt(seconds_left / 60) );
    seconds = pad( parseInt( seconds_left % 60 ) );

    // format countdown string + set tag value
    contDays.innerHTML = days;
    contHours.innerHTML = hours;
    contMinutes.innerHTML = minutes;
    contSeconds.innerHTML = seconds ;
  }

  function pad(n) {
    return (n < 10 ? '0' : '') + n;
  }

  </script>
@endsection
