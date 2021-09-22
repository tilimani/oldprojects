@extends('layouts.app')
@section('title', 'Solicitud'.' '.$booking->id.' '.'en'.' '.$house->name)
{{--SECTION: META--}}
  @section('meta')
    <meta name="description" content="Tu solicitud de {{$house->name}} esta en proceso.">
    <meta name="robot" content="noindex, nofollow">
    <meta property="og:title" content="Solicitud de {{$house->name}}"/>
    <meta property="og:image" content="https://fom.imgix.net/{{$image_room}}?w=1200&h=628&fit=crop" />
    <meta property="og:site_name" content="VICO"/>
    <meta property="og:description" content="¡Super {{$user->name}}! Tu solicitud de {{$house->name}} esta en proceso. Entra al link para ver el estado actual."/>
  @endsection
{{--END SECTION: META--}}
@section('content')
@section('styles')
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

  {{-- Process Modal --}}

    {{-- STICKY ROOM INFO --}}
        <div class="container-fluid ">
            {{-- CONFIRMATION OF SUBMIT --}}
                @if (\Session::has('accepted_success'))
                    <div class="row">
                        <div class="col-12 p-0">
                            <ul class="notification-bar mb-0 px-0 ">
                                <li class="active mt-0">
                                    <div class="card ml-0 w-100 position-static">
                                        <header class="card-header text-center">
                                            <a href="#" data-toggle="collapse" data-target="#state5" aria-expanded="true" class="">
                                                <span class="title"><span>&#10004;</span>Gracias por tu respuesta.</span>
                                            </a>
                                        </header>
                                    </div> <!-- card.// -->
                                </li>
                            </ul>
                        </div>
                    </div>
                @endif
            {{-- CONFIRMATION OF SUBMIT --}}

            {{-- STICKY CONFIRMATION --}}
                @if($booking->status >= 5)
                    <div class="row">
                        <div class="col-12 p-0">
                            <ul class="notification-bar mb-0 px-0 ">
                                <li class="active mt-0">
                                    <div class="card ml-0 w-100 position-static">
                                        <header class="card-header text-center">
                                            <a href="#" data-toggle="collapse" data-target="#state5" aria-expanded="true" class="">
                                                <span class="title">Pagado: Ver datos de contacto <span class="float-left">&#10004;</span></span>
                                                <span class="icon-next-fom"></span>
                                            </a>
                                        </header>
                                        <div class="collapse" id="state5" style="background-color: white; border: white;">
                                            <p class="card-body col-lg-6 col-12 mx-lg-auto " style="border: 0px white; background-color: white; color: #3a3a3a;">
                                                {{$manager->name}} {{$manager->last_name}}<br>
                                                Whatsapp/Mobile: {{$manager->phone}}<br>
                                                Mail: <a href="mailto:{{$manager->email}}">{{$manager->email}}</a><br>
                                                {{date('d/m/y', strtotime($booking->date_from))}} - {{date('d/m/y', strtotime($booking->date_to))}}<br>
                                                Hab {{$room->number}} - {{$room->price * $currency->value}} {{$currency->code}}<br>
                                                {{$house->name}}<br>
                                                Dirección: {{$house->address}}, Medellín, Colombia
                                            </p> <!-- card-body.// -->
                                        </div> <!-- collapse .// -->
                                    </div> <!-- card.// -->
                                </li>
                            </ul>
                        </div>
                    </div>
                @endif
            {{-- END STICKY CONFIRMATION --}}

            {{-- STICKY ROOM INFO --}}
                <div class="row p-1 justify-content-center">
                    <div class="col-4 col-lg-2 p-0">
                        <img src="http://fom.imgix.net/{{$image_room}}?w=750&h=500&fit=crop" style="max-width: 100%;max-height: 5rem">
                    </div>
                    <div class="col-8 col-lg-4">
                        <p class="m-0" style="line-height: 1.1">
                            Hab {{$room->number}} - {{$room->price * $currency->value}} {{$currency->code}}<br>
                            <a href="/houses/{{$house->id}}" target="_blank">{{$house->name}} ></a> <br>
                            {{date('d/m/y', strtotime($booking->date_from))}} - {{date('d/m/y', strtotime($booking->date_to))}}
                        </p>
                    </div>
                </div>
            {{-- END STICKY ROOM INFO --}}
        </div>
    {{-- END STICKY ROOM INFO --}}

    {{-- CONTAINER UNDER FOTO --}}
        <div class="container">
            {{-- ROW CONTENT --}}
                <div class="row ml-3 mr-3 m-md-0">
                    {{-- COL LEFT --}}
                        <div class="col-12 col-lg-8 pr-0 pl-0 mx-auto">
                            {{-- DIV IMAGE --}}
                                <div class="row m-lg-0 booking-show-image d-none">
                                    <img src="{{'http://fom.imgix.net/'.$image_room}}?w=450&h=300&fit=crop" class="w-100 h-100">
                                </div>
                            {{-- END DIV IMAGE --}}

                            {{-- CAPTION FOTO --}}
                                <div class="booking-show-caption">
                                    {{-- START ROW DATES AND CALENDAR --}}
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
                                            {{-- END COL Date left --}}

                                            {{-- COL MIDDLE CALENDAR --}}
                                                <div class="col-4 text-center ">
                                                    <img class="" style="height: 3rem; width: 3rem" src="{{asset('images/etc/calendar-white-plain.png') }}" alt="booking_mode" srcset="{{asset('images/etc/calendar-white-plain@2x.png') }} 2x, {{asset('images/etc/calendar-white-plain@3x.png') }} 3x" />
                                                </div>

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
                                            {{-- END COL MIDDLE CALENDAR --}}
                                        </div>
                                    {{-- END ROW DATES AND CALENDAR --}}
                                </div>
                            {{-- END CAPTION FOTO --}}
                        </div>
                    {{-- END COL LEFT --}}
                </div>
            {{-- END ROW CONTENT --}}
            <hr class="w-100 mt-1">
            {{-- ROW INFORMACIÓN DEL INQUILINO --}}
                <div class="row">
                    <div class="col-3 col-md-1 d-flex justify-content-center">
                        @if(isset($manager->image))
                            <img class="img-responsive rounded-circle" style="width: 3rem; height: 3rem;" src="http://fom.imgix.net/{{$manager->image}}?w=500&h=500&fit=crop" alt="Administrador">
                        @elseif($manager->gender== 2)
                            <img class="img-responsive rounded-circle" style="width: 3rem; height: 3rem;" src="http://fom.imgix.net/manager_47.png?w=500&h=500&fit=crop" alt="Administrador">
                        @else
                            <img class="img-responsive rounded-circle" style="width: 3rem; height: 3rem;" src="http://fom.imgix.net/manager_7.png?w=500&h=500&fit=crop" alt="Administrador">
                        @endif
                    </div>
                    <div class="col-9 pl-0 pl-md-3">
                        <div class="row">
                            <div class="col">
                                <p class="h4 mb-0">{{$manager->name}} {{$manager->last_name}}</p>
                            </div>
                        </div>
                        <div class="row text-left ">
                            <div class="col">
                                <p class="mb-0">
                                    @if($manager->gender==2)
                                        Mujer, {{$manager->country_name}}
                                    @else
                                        Hombre, {{$manager->country_name}}
                                    @endif<br>
                                </p>
                            </div>
                        </div>
                    </div>
                    {{-- Show WhatsAppNumber if Mode = 1 && manager view --}}
                        @if($booking->mode!==1 && Request::is('booking/show/*') && $booking->status==1)
                            <div class="card ml-0 w-100 position-static mt-3">
                                <header class="card-header text-center alert-info">
                                    <h4 class="alert-heading">Intercambio de números</h4>
                                    <hr>
                                    <p class="text-justify">
                                        ¡{{$user->name}} ya se encuentra en Medellín! Le gustaría conocerte a tí y tu VICO personalmente. Así te compartimos su WhatsApp para que puedan organizar una reunión.
                                        En el caso que le gusta la casa, pueden terminar el proceso de reserva con el pago de la primera renta mensual.
                                    </p>
                                    @if (!\Session::has('WhatsAppNumber'))
                                        <form method="POST"  action="{{ URL::to('/booking/showPhoneNumber') }}" enctype="multipart/form-data" class="d-flex justify-content-center text-center">
                                            @csrf
                                            <input name="booking_id" type="hidden" class="form-control" value="{{$booking->id}}">
                                            <input name="sender" type="hidden" class="form-control" value="Manager">
                                            <button type="submit" class="btn btn-process w-auto" style="display: inline-block">Entendido, mostrame el número!</button>
                                        </form>
                                    @endif
                                </header>
                                <div class="collapse @if (\Session::has('WhatsAppNumber')) show @endif" id="whatsappNumber" style="background-color: white; border: white;">
                                    <p class="card-body col-lg-6 col-12 mx-lg-auto " style="border: 0px white; background-color: white; color: #3a3a3a;">
                                        {{$user->name}} {{$user->last_name}}<br>
                                        Whatsapp/Mobile: + {{$whatsappnumberforlink}}
                                        <a href="https://api.whatsapp.com/send?phone={{$whatsappnumberforlink}}&text=Hola%20{{$user->name}}!%20Mi%20nombre%20es%20{{$manager->name}}%20de%20la%20{{$house->name}}.%20Cuando%20podr%C3%ADas%20ir%20a%20verla?" class="mt-2 d-block whatsappNumber-Button" target="_blank"><span class="icon-whatsapp-black" style="color:white;"></span> Abrir Whatsapp</a>
                                    </p> <!-- card-body.// -->
                                </div> <!-- collapse .// -->
                            </div> <!-- card.// -->
                        @endif
                    {{-- END Show WhatsAppNumber if Mode = 1 && manager view --}}

                    {{-- user view --}}
                        @if($booking->mode!==1 && Request::is('booking/user/*') && $booking->status==1)
                            <div class="card ml-0 w-100 position-static mt-3">
                                <header class="card-header text-center alert-info">
                                    <h4 class="alert-heading">Intercambio de números</h4>
                                    <hr>
                                    <p class="text-justify">Como quieres ver la casa personalmente te compartimos el número de WhatsApp de {{$manager->name}} para establecer contacto. En el caso que le gusta la casa, puedes terminar el proceso de reserva con el pago de la primera renta mensual.</p>
                                    @if (!\Session::has('WhatsAppNumber'))
                                        <form method="POST"  action="{{ URL::to('/booking/showPhoneNumber') }}" enctype="multipart/form-data" class="d-flex justify-content-center text-center">
                                            @csrf
                                            <input name="booking_id" type="hidden" class="form-control" value="{{$booking->id}}">
                                            <input name="sender" type="hidden" class="form-control" value="User">
                                            <button type="submit" class="btn btn-process w-auto" style="display: inline-block">Entendido, mostrame el número!</button>
                                        </form>
                                    @endif
                                </header>
                                <div class="collapse @if (\Session::has('WhatsAppNumber')) show @endif" id="whatsappNumber" style="background-color: white; border: white;">
                                    <p class="card-body col-lg-6 col-12 mx-lg-auto " style="border: 0px white; background-color: white; color: #3a3a3a;">
                                        {{$manager->name}} {{$manager->name}}<br>
                                        Whatsapp/Mobile: + {{$whatsappnumberforlink}}
                                        <a href="https://api.whatsapp.com/send?phone={{$whatsappnumberforlink}}&text=Hola%20{{$manager->name}}!%20Mi%20nombre%20es%20{{$user->name}}.%20Cuando%20podr%C3%ADa%20ir%20a%20ver%20la%20VICO?" class="mt-2 d-block whatsappNumber-Button" target="_blank"><span class="icon-whatsapp-black" style="color:white;"></span> Abrir Whatsapp</a>
                                    </p> <!-- card-body.// -->
                                </div> <!-- collapse .// -->
                            </div> <!-- card.// -->
                        @endif
                    {{-- END user view --}}
                    {{-- Verifications of users --}}
                    <div>
                        @if ($verification->document_verified == true)
                            <span class="badge badge-success">Identificación verificada</span>
                        @endif
                        @if ($verification->whatsapp_verified == true)
                            <span class="badge badge-success">Whatsapp verificado</span>
                        @endif
                        @if ($verification->phone_verified == true)
                            <span class="badge badge-success">Telefono verificado</span>
                        @endif
                    </div>
                </div>
            {{-- END ROW INFORMACIÓN DEL INQUILINO --}}

            {{-- SHOW BOOKING DETAILS IN STATUS 5 --}}
                @if($booking->status == 5)
                    <div class="row text-left ">
                        <div class="col-12 mt-1">
                            <p class="mb-0">
                                Whatsapp/Mobile: {{$manager->phone}}<br>
                                Mail: <a href="mailto:{{$manager->email}}">{{$manager->email}}</a><br>
                                {{$house->address}}, Medellín, Colombia
                            </p>
                        </div>
                    </div>
                @endif
            {{-- END SHOW BOOKING DETAILS IN STATUS 5 --}}
            <hr class="w-100 my-4">
            @if($booking->status < '0')
                {{-- IF CANCELED BOOKING --}}
                    <div class="row text-center d-flex justify-content-center">
                        <p><span class="icon-close" style="color: red;"></span> <br>Lo sentimos, la solicitud ha sido cancelada.</p>
                    </div>
                    <div class="row mb-4 d-flex justify-content-center">
                        <a href="/" class="btn btn-primary">Volver a buscar</a>
                    </div>
                {{-- END IF CANCELED BOOKING --}}
            @elseif($booking->status == 100)
                {{-- IF FAKE BOOKING --}}
                    <div class="row text-center d-flex justify-content-center">
                        <p><span class="icon-close" style="color: red;"></span> <br> Lo sentimos, no tienes permiso para entrar a esa soclicitud.</p>
                    </div>
                    <div class="row mb-4 d-flex justify-content-center">
                        <a href="/" class="btn btn-primary">Volver a buscar</a>
                    </div>
                {{-- IF FAKE BOOKING --}}
            @else
                {{-- 3 PART PROCESS --}}
                    <div class="row">
                        <div class="col-12 mx-auto">
                            <ul id="progressbar">
                                <li class="active text-center" style="z-index: 1003">Solicitud</li>
                                <li class="@if($booking->status >= 2 )active @endif text-center" style="z-index: 1002">Disponibilidad confirmada</li>
                                <li class="@if($booking->status >= 3 )active @endif text-center" style="z-index: 1001">Proceso de pago</li>
                            </ul>
                        </div>
                        {{-- Boton "Como funciona el proceso" --}}
                            <div class="col-12 mt-4 d-flex justify-content-center">
                                <a class="btn btn-outline-primary" target="_blank" href="{{route('questions.user')}}" onclick="faqUser()">¿Cómo funciona la reserva?</a>
                            </div>
                        {{-- Boton "Como funciona el proceso" --}}
                    </div>
                {{-- END 3 PART PROCESS --}}

                {{-- Separator --}}
                <hr class="w-100 my-4">

                                  @if ($booking->status == 8)
                                  <div class="col-6 col-lg-3 px-lg-4 px-0 pr-3">
                                    <span class="btn h-100 btn-process btn-lightk">Notificaste que quieres cancelar esta solicitud, estamos en ello.</span>
                                  </div>
                                  @endif
                                  @if ($booking->status == 9)
                                  <div class="col-6 col-lg-3 px-lg-4 px-0 pr-3">
                                    <span class="btn h-100 btn-process btn-lightk">El usuario ha notificado que quiere cancelar esta solicitud, estamos en ello. Ponte en contacto con nosotros para saber más</span>
                                  </div>
                                  @endif
                          </div>
                        </div>
                        {{-- END COL LEFT --}}
                    {{-- MODAL CANCEL--}}
                    <div class="modal fade" style="overflow:scroll" id="cancel" tabindex="-1" role="dialog" aria-labelledby="cancel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Cancelar solicitud</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>¿Estás seguro que quieres cancelar la solicitud de esa habitación?</p>
                                </div>
                                <div class="modal-footer">
                                    <form  class="d-inline cancel_form_{{$booking->status + 1}}"method="POST" action="{{ $booking->status == 5 ? route('cancel.request.user') : URL::to('/booking/cancel')  }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="id" value="{{$booking->id}}">
                                        <button type="button" class="btn btn-light w-100 btn-process CancelButton"  data-dismiss="modal" value-form="cancel_form_{{$booking->status + 1}}"><span class="icon-close" style="color: red"></span><br>Si, quiero cancelar la solicitud.</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                {{--VICO Chat--}}
                    <div class="row m-0 p-0">
                        <div class="col-12 m-0 p-0">
                            <div class="m-0 p-0" id="react-chat-static" style="height: 50%;"
                                data-connection={{__(Auth::user()->id.","."3".",".$booking->id.",".$booking->status)}}>
                            </div>
                        </div>
                    </div>
                {{--END VICO CHAT--}}
                {{-- ROW BUTTONS --}}
                @include('bookings.user.buttons')
                {{-- END ROW BUTTONS --}}
            @endif
        </div>
    {{-- CONTAINER UNDER FOTO --}}

    @include('bookings.user.modals')

@endsection
@section('scripts')
<script>
function faqUser() {
    analytics.track('Enter user FAQ',{
        category: 'User knowlage'
    });
}
</script>
    @include('bookings.user.scripts')
@endsection
