@extends('layouts.app')
@section('title', 'reservar una solicitud')

@section('content')
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
{{--end section:styles--}}


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container mt-4">
        <p class="text-right">{{date("D, d. M 'y", strtotime($booking->created_at))}}</p>
        <p class="h2 font-color-orange text-center">¡Felicitaciones {{$booking->manager_info->name}}! </br><small> Tienes una nueva solicitud.</small></p>

        <hr class="w-75 border-color-orange">


    </div>



{{-- Container under Foto --}}
<div class="container">

    <style type="text/css">
    /* Style the form */
#regForm {
  background-color: #ffffff;
  margin: 100px auto;
  padding: 40px;
  width: 70%;
  min-width: 300px;
}

/* Style the input fields */
input {
  padding: 10px;
  width: 100%;
  font-size: 17px;
  font-family: Raleway;
  border: 1px solid #aaaaaa;
}

/* Mark input boxes that gets an error on validation: */
input.invalid {
  background-color: #ffdddd;
}

/* Hide all steps by default: */
.tab {
  display: none;
}

/* Make circles that indicate the steps of the form: */
.step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbbbbb;
  border: none;
  border-radius: 50%;
  display: inline-block;
  opacity: 0.5;
}

/* Mark the active step: */
.step.active {
  opacity: 1;
}

/* Mark the steps that are finished and valid: */
.step.finish {
  background-color: #4CAF50;
}
</style>

<form id="regForm" action="">

<h1>Register:</h1>

{{-- ONE "TAB" FOR EACH STEP IN THE FORM: --}}
<div class="tab">Name:
        <div class="form-group center">
        <label for="name">¿Por quién esta ocupada?</label>
        <input type="text" name="name" class="form-control" required>
    </div>


</div>

<div class="tab">Contact Info:

    <div class="form-group center">
      <label for="dateto">¿Hasta cuando esta ocupada?</label>
      <input type="date"  class="form-control" name="dateto" id="dateto" min="" required>
    </div>

</div>

<div class="tab">Birthday:
  <div class="form-group center">
          <label for="country">¿De qué país es?</label>
          <select class="form-control" name="country" required>
              <option disabled selected>-- seleccione</option>
              @foreach ($countries as $country)
                  <option value="{{$country->id}}">{{$country->name}}</option>
              @endforeach
          </select>
      </div>


</div>

<div class="tab">Login Info:
  <div class="row justify-content-center mb-3">
            <div class="col-6 col-sm-3 form-check">
              <input type="radio" name="gender" id="create-male" value="1" required>
              <label for="create-male">
                  <span class=" display-4 icon-man"></span>
              </label>
            </div>
             <div class="col-6 col-sm-3 form-check">
              <input type="radio" name="gender" id="create-female" value="0">
              <label for="create-female">
                  <span class=" display-4 icon-woman"></span>
              </label>
            </div>
      </div>
</div>

<div style="overflow:auto;">
  <div style="float:right;">
    <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
    <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
  </div>
</div>

{{-- CIRCLES WHICH INDICATES THE STEPS OF THE FORM: --}}
<div style="text-align:center;margin-top:40px;">
  <span class="step"></span>
  <span class="step"></span>
  <span class="step"></span>
  <span class="step"></span>
</div>

</form>


<script type="text/javascript">
    var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form ...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  // ... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  // ... and run a function that displays the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form... :
  if (currentTab >= x.length) {
    //...the form gets submitted:
    document.getElementById("regForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false:
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class to the current step:
  x[n].className += " active";
}
</script>


    {{-- Row Content --}}
    <div class="row m-3 m-md-0">
        {{-- Col Left --}}
    <div class="col-12 col-lg-7 pr-0 pl-0">
        <div class="row">
            <div class="col">
                <p class="h4 mt-2 mb-sm-0">{{$booking->house_name}} </p>
                <p class="h4">Habitación {{$booking->number}} - {{$booking->price}}COP</p>
                <p class="d-none d-lg-block">Fecha de llegada: <span class="font-weight-bold"> {{date("D, d. M Y", strtotime($booking->date_from))}} </span></p>
                <p class="d-none d-lg-block">Fecha de salida <span class="font-weight-bold"> {{date("D, d. M Y", strtotime($booking->date_to))}}</span></p>
            </div>
        </div>
        {{-- DIV IMAGE --}}
        <div class="row m-lg-0 booking-show-image">
            <img src="http://fom.imgix.net/{{$image_room}}?w=750&h=500&fit=crop" class="w-100 h-100">


            {{-- Caption Foto --}}
            <div class="booking-show-caption">
                {{-- Start Row Dates and Calendar --}}
                <div class="row ml-md-4 mr-md-4 pl-md-4 pr-md-4 ml-lg-0 mr-lg-0 pl-lg-0 pr-lg-0">
                    {{-- COL Date left --}}
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
                    {{-- Col Middle Calendar --}}
                    <div class="col-4 text-center ">
                        <span class="icon-calendar-white" style="font-size: 2.9rem; text-align: right;"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span><span class="path11"></span><span class="path12"></span><span class="path13"></span><span class="path14"></span><span class="path15"></span><span class="path16"></span><span class="path17"></span><span class="path18"></span><span class="path19"></span><span class="path20"></span><span class="path21"></span><span class="path22"></span><span class="path23"></span><span class="path24"></span><span class="path25"></span><span class="path26"></span><span class="path27"></span></span>
                    </div>
                    {{-- Col Right Date --}}
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
                </div>
                {{-- End Row Dates and Calendar --}}
            </div>
            {{-- End Caption Foto --}}
        </div>
        {{-- DIV IMAGE END --}}


         <hr class="w-75">

        {{-- Row Heading --}}
        <div class="row mt-4 mb-0">
            <div class="col">
            <p class="font-weight-light">Datos del Inquilino:</p>
            </div>
        </div>

        {{-- Row Información del inquilino --}}
        <div class="row">
            <div class="col-3 d-flex justify-content-center">
                @if(isset($booking->image))
                    <img class="img-responsive rounded-circle" style="width: 4rem; height: 4rem;margin-left: 2rem" src="http://fom.imgix.net/{{$booking->image}}?w=500&h=500&fit=crop" alt="Administrador">
                @elseif($booking->gender== 2)
                    <img class="img-responsive rounded-circle" style="width: 4rem; height: 4rem;margin-left: 2rem" src="http://fom.imgix.net/manager_47.png?w=500&h=500&fit=crop" alt="Administrador">
                @else
                    <img class="img-responsive rounded-circle" style="width: 4rem; height: 4rem;margin-left: 2rem" src="http://fom.imgix.net/manager_7.png?w=500&h=500&fit=crop" alt="Administrador">
                @endif
                <img class="booking-show-flag rounded-circle" src="/images/flags/{{$booking->icon}}">
            </div>

            <div class="col-9">
                <div class="row">
                    <div class="col">
                        <p class="h3">{{$booking->name}} {{$booking->last_name}}</p>
                    </div>
                </div>
                <div class="row text-left ">
                    <div class="col">
                        <p>@if($booking->gender==2)Mujer @else Hombre @endif</p>
{{--                         <p>Cumpleaños, {{$booking->birthdate}}</p>
 --}}                    </div>
                </div>
            </div>
        </div>



        <hr class="w-75 mt-1">


        {{-- Row Mode  --}}
        <div class="row">
            <div class="col">
                <p> @if($booking->mode == 1)
                {{$booking->name}} no requiere visitar la casa, su solicitud es <span class="font-weight-bold"> online</span>
                @else
                {{$booking->name}} quiere visitar la casa
                @endif</p>
            </div>
        </div>

        {{-- Row Speechbubble --}}
        @if($booking->message == "") @else
        <div class="row pl-4">
            <div class="col-12">
               <div class="speech-bubble">
                    <p>@if($booking->message == "") - SIN MENSAJE - @else {{$booking->message}} @endif</p>
                </div>
            </div>
        </div>
        @endif

        <hr class="w-75 mt-1">

        @if($count===0) @else
        {{-- Row Cuantos rooms --}}
            <div class="row">
                <div class="col">
                    <p class="font-weight-light">{{$booking->name}} ha solicitado {{$count}} @if($count===1) habitación @else habitaciones @endif más. Respóndele rápido para que se decide por tu habitación.</p>
                </div>
            </div>
        @endif

        {{-- Row Buttons --}}
        @if ($errors->any())
            <div class="row mt-4 mb-4">
                <div class="col-12">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Acepted" disabled>Aceptar & reservar</button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Deny">Rechazar</button>
                </div>
            </div>
        @else
          <div class="row mt-4 mb-4">
              <div class="col-12">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Acepted">Aceptar & reservar</button>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Deny">Rechazar</button>
              </div>
          </div>
        @endif
        <div class="mt-4 mb-4 d-lg-block d-none"><br></br></div>
        {{-- Sticky Row Process --}}
        <div class="col mt-4 d-lg-none row booking-show-process-card-mobile ">
            <div class="col-12 pt-4">
                <a href="#" data-toggle="modal" data-target="#owner-process"><p><span class="icon-idea-orange"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span></span> ¿Cómo funciona el proceso?</p></a>            </div>
        </div>
    </div>
    {{-- End COL Left --}}


{{-- ==============START COL RIGHT: Process============== --}}
    <div class="col-lg-5 d-none d-lg-block">
        {{-- DIV STICKY START --}}
        <div class="sticky" style="top: 1rem">
                <!--row-process -->
                <div class="row mb-4">
                    <!-- process icon-->
                    <div class="col-3 text-center booking-show-process-icon">
                        <div class="booking-show-process-circle">
                            <span class="icon-choice" style="line-height: 1.4 !important;"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span></span>
                        </div>
                    </div>
                    <!-- process icon-end-->
                    <!-- process explanation-->
                    <div class="col-9 pr-0 pr-md-4">
                        <ul class="bullet-points-off">
                            <li><p class="h5 mb-0 mt-1">1. Aceptas o rechazas la solicitud</p>
                            </li>
                            <li><p class="font-weight-light">Antes de tomar la decisión deberías verificar que la habitación {{$booking->number}} en {{$booking->house_name}} realmente esta disponible. Después decides si quieres aceptar o rechazar la solicitud de {{$booking->name}}. </p>
                            </li>
                        </ul>
                         <hr class="w-75 mt-0 mb-0">
                    </div>
                    <!-- process explanation-end-->
                </div>
                <!--row-process -->

                <!--row-process -->
                <div class="row mb-4">
                    <!-- process icon-->
                    <div class="col-3 text-center booking-show-process-icon">
                        <div class="booking-show-process-circle">

                            <span class="icon-48horas" style="line-height: 1.4 !important;"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span></span>
                       </div>
                    </div>
                    <!-- process icon-end-->
                    <!-- process explanation-->
                    <div class="col-9 pr-0 pr-md-4">
                        <ul class="bullet-points-off">
                            <li><p class="h5 mb-0 mt-1">2. Relájate y bloquea la habitación 48 horas</p>
                            </li>
                            <li><p class="font-weight-light">Ya cuando acepaste la solicitud puedes reljáte, el estudiante ahora tiene 48 horas para pagar el depósito. En este tiempo la habitación no puede ser ofrecida a nigúna otra persona, el pago ya está en proceso. Te mantegamos al tanto.</p>
                            </li>
                        </ul>
                        <hr class="w-75 mt-0 mb-0">
                    </div>
                    <!-- process explanation-end-->

                </div>
                <!--row-process -->
                <!--row-process -->
                <div class="row mb-4">
                    <!-- process icon-->
                    <div class="col-3 text-center booking-show-process-icon">
                        <div class="booking-show-process-circle">
                            <span class="icon-deposit-orange" style="line-height: 1.4 !important;"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span><span class="path4"></span></span>
                        </div>
                    </div>
                    <!-- process icon-end-->
                    <!-- process explanation-->
                    <div class="col-9 pr-0 pr-md-4">
                        <ul class="bullet-points-off">
                            <li><p class="h5 mb-0 mt-1">3. Pago del depósito</p>
                            </li>
                            <li><p class="font-weight-light">Felicitaciones, el estudiante pagó el depósito (= 1 renta mensual). Tu habitación ya queda reservada.</p>
                            </li>
                        </ul>
                        <hr class="w-75 mt-0 mb-0">
                    </div>
                    <!-- process explanation-end-->

                </div>
                <!--row-process -->
                <!--row-process -->
                <div class="row mb-4">
                    <!-- process icon-->
                    <div class="col-3 text-center booking-show-process-icon">
                        <div class="booking-show-process-circle">
                            <span class="icon-ballon-orange"style="line-height: 1.4 !important;"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
                        </div>
                    </div>
                    <!-- process icon-end-->
                    <!-- process explanation-->
                    <div class="col-9 pr-0 pr-md-4">
                        <ul class="bullet-points-off">
                            <li><p class="h5 mb-0 mt-1">Vivir entre amigos.</p>
                            </li>
                            <li><p class="font-weight-light">Si la gente en tu VICO esta feliz, tu también lo eres, porque puedes estar tranquilo y seguro de que las personas te van a recomendar a otros.</p>
                            </li>
                        </ul>
                    </div>
                    <!-- process explanation-end-->
                </div>
                <!--row-process -->

            </div>
            {{-- DIV STICKY END --}}
          </div>
         {{-- COL RIGHT END --}}
    </div>
    {{-- ROW END --}}
</div>
{{-- END Container under Foto --}}
{{-- <div class="container mt-4">

    <ul>
        <li><b>numero de proceso:</b>{{$booking->id}}</li>
        <li><b>fecha de solicitud:</b>{{$booking->created_at}}</li>
        <li><b>nombre del estudiante:</b></li>
        <li><b>nacionalidad:</b>{{$booking->country}}</li>
        <li><b>casa:</b>{{$booking->house_name}}</li>
        <li><b>habitacion:</b></li>
        <li><b>solicitud desde:</b>{{$booking->date_from}}</li>
        <li><b>solicitud hasta:</b>{{$booking->date_to}}</li>
        <li><b>mensaje del estuidante:</b>{{$booking->message}}</li>
        @foreach ( $status as $state => $value)
            @if($state == $booking->status)
                <li><b>estado de la solicitud:</b>{{$value}}</li>
            @endif
        @endforeach
        @if($booking->mode == 1)
            <li><b>estudiante no requiere visitar la casa su solicitud es: </b>online</li>
        @else
            <li><b>el estudiante requeire visitar la casa su solicitud es: </b>visita personal</li>
        @endif
    </ul>
</div> --}}
</div>



<!-- Modal Accept -->
<div class="modal fade" style="overflow:scroll" id="Acepted" tabindex="-1" role="dialog" aria-labelledby="Accepted request" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Aceptar solicitud</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         x
        </button>
      </div>

      <form method="POST" action="{{ URL::to('/booking/reserved') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{$booking->id}}">
                    <input type="hidden" name="email" value="{{$booking->user_email}}">
                    <input type="hidden" name="created_at" value="{{$booking->created_at}}">
                    <input type="hidden" name="manager_name" value="{{$booking->manager_info->name}}">
                    <input type="hidden" name="room_number" value="{{$booking->number}}">
                    <input type="hidden" name="date_from" value="{{$booking->date_from}}">
                    <input type="hidden" name="date_to" value="{{$booking->date_to}}">
                    <input type="hidden" name="name" value="{{$booking->name}}">
                    <input type="hidden" name="last_name" value="{{$booking->last_name}}">

                    <!-- Modal body -->
      <div class="modal-body">
        <div class="text-center">
            <p>Si aceptas estas reservando esta habitacion para {{$booking->name}}. Ningun otro estudiante podrá hacer el pago durante 48h, es decir, los demás procesos que quieran esta habitación no podrán hacer el pago.</p> <br>
            <p>En caso de no darse el pago en 48h cualquier otro estudiante, incluso {{$booking->name}} podrá solicitar una reserva de 48h. </p>
        </div>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Confirmar reserva.</button>
      </div>
        </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" style="overflow:scroll" id="deny" tabindex="-1" role="dialog" aria-labelledby="Deny request" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Rechazar solicitud</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          x
        </button>
      </div>

      <div class="modal-body">
        <p>¿Porque rechazas esa solicitud?</p>

                        <label for="message_admin">Responde al solicitante con un pequeño mensaje:</label>
                        <textarea name="message_admin" placeholder="Hola {{$booking->name}}, ..."></textarea>      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Enviar y confirmar reserva.</button>
      </div>
    </div>
  </div>
</div>


    <div class="modal fade" style="overflow:scroll" id="Deny">
        <div class="modal-dialog">
            <div class="modal-content text-center">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h3 class="modal-title">¿Porque rechazas la solicitud?</h3>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                    <!-- Modal body -->
        <div class="modal-body">
            <div class="col">
                    <div class="panel-group" id="accordion">
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          <h4 class="panel-title">

                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                                La habitación esta ocupada <span class="icon-z-date"></span>
                            </a>
                          </h4>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <form method="POST" action="{{ URL::to('/booking/denied') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{$booking->id}}">
                                    <input type="hidden" name="flag" value="1">
                                    <input type="hidden" name="room_id" value="{{$booking->room_id}}">
                                    <input type="hidden" name="email" value="{{$booking->user_email}}">


                                    <div class="form-group center">
                                        <label for="dateto">¿Hasta cuando esta ocupada?</label>
                                        <input type="date"  class="form-control" name="dateto" id="dateto" min="" required>
                                    </div>


                                    <div class="form-group center">
                                        <label for="name">¿Por quién esta ocupada?</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>

                                     <div class="form-group center">
                                        <label for="country">¿De qué país es?</label>
                                        <select class="form-control" name="country" required>
                                            <option disabled selected>-- seleccione</option>
                                            @foreach ($countries as $country)
                                                <option value="{{$country->id}}">{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                     <div class="row justify-content-center mb-3">
                                          <div class="col-6 col-sm-3 form-check">
                                            <input type="radio" name="gender" id="create-male" value="1" required>
                                            <label for="create-male">
                                                <span class=" display-4 icon-man"></span>
                                            </label>
                                          </div>
                                           <div class="col-6 col-sm-3 form-check">
                                            <input type="radio" name="gender" id="create-female" value="0">
                                            <label for="create-female">
                                                <span class=" display-4 icon-woman"></span>
                                            </label>
                                          </div>
                                    </div>

                                </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-link" data-dismiss="modal">Volver</button>
                                        <button type="submit" class="btn btn-primary" >Enviar</button>
                                 </div>
                                </form>
                            </div>
                        </div>
                      </div>
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                            Por otra razón...
                            </a>
                          </h4>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse">
                          <form method="POST" action="{{ URL::to('/booking/denied') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{$booking->id}}">
                            <input type="hidden" name="flag" value="2">
                            <input type="hidden" name="email" value="{{$booking->user_email}}">

                            <div class="panel-body">
                                <label>¿Porqué no quieres recibir a {{$booking->name}}?</label>
                                <textarea  class="form-control" name="message" placeholder="Tu respuesta"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-link" data-dismiss="modal">Volver</button>
                                <button type="submit" class="btn btn-primary" >Enviar</button>
                            </div>
            </div>
        </div>

                          </form>
                        </div>
                      </div>
                    </div>

                   <!-- Modal footer -->
            </div>
        </div>
    </div>

    <!-- ========= Process Modal ========== -->
                            <div class="modal fade" style="overflow:scroll" id="owner-process" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                                <!--row-process -->
                <div class="row mb-4">
                    <!-- process icon-->
                    <div class="col-3 text-center booking-show-process-icon">
                        <div class="booking-show-process-circle">
                            <span class="icon-choice" style="line-height: 1.4 !important;"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span></span>
                        </div>
                    </div>
                    <!-- process icon-end-->
                    <!-- process explanation-->
                    <div class="col-9 pr-0 pr-md-4">
                        <ul class="bullet-points-off">
                            <li><p class="h5 mb-0 mt-1">1. Aceptas o rechazas la solicitud</p>
                            </li>
                            <li><p class="font-weight-light">Antes de tomar la decisión deberías verificar que la habitación {{$booking->number}} en {{$booking->house_name}} realmente esta disponible. Después decides si quieres aceptar o rechazar la solicitud de {{$booking->name}}. </p>
                            </li>
                        </ul>
                    </div>
                    <!-- process explanation-end-->
                </div>
                <!--row-process -->

                <!--row-process -->
                <div class="row mb-4">
                    <!-- process icon-->
                    <div class="col-3 text-center booking-show-process-icon">
                        <div class="booking-show-process-circle">

                            <span class="icon-48horas" style="line-height: 1.4 !important;"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span></span>
                       </div>
                    </div>
                    <!-- process icon-end-->
                    <!-- process explanation-->
                    <div class="col-9 pr-0 pr-md-4">
                        <ul class="bullet-points-off">
                            <li><p class="h5 mb-0 mt-1">2. Bloquea la habitación 48 horas y relajáte</p>
                            </li>
                            <li><p class="font-weight-light">Ya cuando acepaste la solicitud puedes reljáte, el estudiante ahora tiene 48 horas para pagar el depósito. En este tiempo la habitación no puede ser ofrecida a nigúna otra persona, el pago ya está en proceso. Te mantegamos al tanto.</p>
                            </li>
                        </ul>
                    </div>
                    <!-- process explanation-end-->
                </div>
                <!--row-process -->
                <!--row-process -->
                <div class="row mb-4">
                    <!-- process icon-->
                    <div class="col-3 text-center booking-show-process-icon">
                        <div class="booking-show-process-circle">
                            <span class="icon-deposit-orange" style="line-height: 1.4 !important;"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span><span class="path4"></span></span>
                        </div>
                    </div>
                    <!-- process icon-end-->
                    <!-- process explanation-->
                    <div class="col-9 pr-0 pr-md-4">
                        <ul class="bullet-points-off">
                            <li><p class="h5 mb-0 mt-1">3. Llegó el depósito.</p>
                            </li>
                            <li><p class="font-weight-light">Felicitaciones, el estudiante pagó el depósito (= 1 renta mensual). Tu habitación ya queda reservada.</p>
                            </li>
                        </ul>
                    </div>
                    <!-- process explanation-end-->
                </div>
                <!--row-process -->
                <!--row-process -->
                <div class="row mb-4">
                    <!-- process icon-->
                    <div class="col-3 text-center booking-show-process-icon">
                        <div class="booking-show-process-circle">
                            <span class="icon-ballon-orange"style="line-height: 1.4 !important;"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
                        </div>
                    </div>
                    <!-- process icon-end-->
                    <!-- process explanation-->
                    <div class="col-9 pr-0 pr-md-4">
                        <ul class="bullet-points-off">
                            <li><p class="h5 mb-0 mt-1">Vivir entre amigos.</p>
                            </li>
                            <li><p class="font-weight-light">Si la gente en tu VICO esta feliz, tu también lo eres, porque puedes estar tranquilo y seguro de que las personas te van a recomendar a otros.</p>
                            </li>
                        </ul>
                    </div>
                    <!-- process explanation-end-->
                </div>
                <!--row-process -->
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- ========= Modal Process End  ========== --}}

@endsection
