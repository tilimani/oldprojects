@extends('layouts.app')
@section('title', 'Solicitud'.' '.$booking->id.' '.'de'.' '.$user->name)
{{--SECTION: META--}}
@section('meta')
    <meta name="description" content="¡Felicitaciones {{$manager->name}}, tienes una nueva solicitud! Entra al link para aceptar o rechazar la solicitud de {{$user->name}}.">
    <meta name="robot" content="noindex, nofollow">
    <meta property="og:title" content="Solicitud de {{$user->name}}"/>
    <meta property="og:image" content="https://fom.imgix.net/{{$image_room}}?w=1200&h=628&fit=crop" />
    <meta property="og:site_name" content="VICO"/>
    <meta property="og:description" content="Felicitaciones {{$manager->name}}, tienes una nueva solicitud! Entra al link para aceptar o rechazar la solicitud de {{$user->name}}."/>
@endsection
{{--END SECTION: META--}}
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

{{-- STICKY ROOM INFO --}}
    <div class="container-fluid tuto-step4 bg-white ">
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
        {{-- STICKY CONFIRMATION --}}
            @if($booking->status == 5)
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
                                            {{$user->name}} {{$user->last_name}}<br>
                                            Whatsapp/Mobile: {{$user->phone}}<br>
                                            Mail: <a href="mailto:{{$user->email}}">{{$user->email}}</a><br>
                                            {{date('d/m/y', strtotime($booking->date_from))}} - {{date('d/m/y', strtotime($booking->date_to))}}<br>
                                            Hab {{$room->number}} - {{$room->price}} COP<br>
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
                        Hab {{$room->number}} - {{$room->price}} COP<br>
                        @if ($room->nickname == "")@else{{$room->nickname}}<br>@endif
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
                                <img src="http://fom.imgix.net/{{$image_room}}?w=750&h=500&fit=crop" class="w-100 h-100">
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
                                                        <img class="" style="height: 3rem; width: 3rem" src="{{asset('images/etc/calendar-white-plain.png') }}" alt="booking_mode" srcset="{{asset('images/etc/calendar-white-plain@2x.png') }} 2x, {{asset('images/etc/calendar-white-plain@3x.png') }} 3x" />
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
                        {{-- DIV IMAGE END --}}

                        {{-- ROW STICKY --}}
                            <div class="row pt-2 sticky-top bg-white d-none">
                                <div class="col-3 col-md-1 d-flex justify-content-center align-items-center">
                                    <img class="" style="height: 3rem; width: 3rem" src="{{asset('images/etc/house.png') }}" alt="booking_mode" srcset="{{asset('images/etc/house@2x.png') }} 2x, {{asset('images/etc/house@3x.png') }} 3x" />
                                </div>

                                <div class="col-9 pl-0 pl-md-3">
                                    <div class="row">
                                        <div class="col">
                                            <p class="m-0 h4">Hab {{$room->number}} - {{$room->price}} COP</p>
                                        </div>
                                    </div>
                                    <div class="row text-left ">
                                        <div class="col">
                                            @if($room->nickname === ""){{$room->nickname}}@endif
                                            <p class="m-0 mb-sm-0 vico-color"><a href="/houses/{{$house->id}}" target="_blank">{{$house->name}} ></a></p>
                                            <p class="m-0 mb-sm-0">{{date('d/m/y', strtotime($booking->date_from))}} - {{date('d/m/y', strtotime($booking->date_to))}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {{-- END ROW STICKY --}}

                        <hr class="w-100 mt-1">

                        {{-- ROW INFORMACIÓN DEL INQUILINO --}}
                            <div class="row">
                                <div class="col-3 col-md-1 d-flex justify-content-center">
                                    @if(isset($user->image))
                                        <img class="img-responsive rounded-circle" style="width: 3rem; height: 3rem" src="http://fom.imgix.net/{{$user->image}}?w=500&h=500&fit=crop" alt="Administrador">
                                    @elseif($user->gender== 2)
                                        <img class="img-responsive rounded-circle" style="width: 3rem; height: 3rem" src="http://fom.imgix.net/manager_47.png?w=500&h=500&fit=crop" alt="Administrador">
                                    @else
                                        <img class="img-responsive rounded-circle" style="width: 3rem; height: 3rem" src="http://fom.imgix.net/manager_7.png?w=500&h=500&fit=crop" alt="Administrador">
                                    @endif
                                </div>
                                <div class="col-9 pl-0 pl-md-3 tuto-step3">
                                    <div class="row">
                                        <div class="col">
                                            <p class="mb-0" style="line-height: 1.1">{{$user->name}} {{$user->last_name}}<br>
                                                @if($user->gender==2)
                                                    Mujer, {{$user_country->name}}
                                                @else
                                                    Hombre, {{$user_country->name}}
                                                @endif
                                                <br>
                                                <span class="font-weight-bold">
                                                    @if($booking->mode==1)
                                                        Quiere reservar online.
                                                    @else
                                                        Quiere visitar la casa.
                                                    @endif
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row text-left ">
                                        <div class="col">
                                            <p class="mb-0"></p>
                                        </div>
                                    </div>
                                </div>
                                {{-- SHOW BOOKING DETAILS IN STATUS 5 --}}
                                    @if($booking->status == 5)
                                        <div class="row text-left ">
                                            <div class="col-12 mt-1">
                                                <p class="mb-0">
                                                    Whatsapp/Mobile: {{$user->phone}}<br>
                                                    Mail: <a href="mailto:{{$user->email}}">{{$user->email}}</a><br>
                                                    {{$house->address}}, Medellín, Colombia
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                {{-- END SHOW BOOKING DETAILS IN STATUS 5 --}}

                                {{-- Show WhatsAppNumber if Mode = 1 && manager view --}}
                                    @if($booking->mode!==1 && Request::is('booking/show/*') && $booking->status==1)
                                        <div class="card ml-0 w-100 position-static mt-3">
                                            <header class="card-header text-center alert-info">
                                                    <h4 class="alert-heading">Intercambio de números</h4><hr>
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
                                                <p class="text-justify">Como quieres ver la casa personalmente te compartimos el número de WhatsApp de {{$manager->phone}} para establecer contacto. En el caso que le gusta la casa, puedes terminar el proceso de reserva con el pago de la primera renta mensual.</p>
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
                                {{-- END Verifications of users --}}
                            </div>
                        {{-- END ROW INFORMACIÓN DEL INQUILINO --}}
                        <hr class="w-100">

                        {{-- IF CANCELED BOOKING --}}
                            @if($booking->status > '0')

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
                                                <a class="btn btn-outline-primary" target="_blank" href="{{route('questions.host')}}" onclick="faqManager()">¿Cómo funciona la reserva?</a>
                                            </div>
                                        {{-- END Boton "Como funciona el proceso" --}}
                                    </div>
                                {{-- END 3 PART PROCESS --}}

                                {{-- Separator --}}
                                <hr class="w-100 my-4">

                                {{--VICO Chat--}}
                                    <div class="row m-0 p-0">
                                        <div class="col-12 m-0 p-0">
                                            <div class="m-0 p-0" id="react-chat-static" style="height: 50%;"
                                                data-connection={{__(Auth::user()->id.","."1".",".$booking->id.",".$booking->status)}}>
                                            </div>
                                        </div>
                                    </div>
                                {{--END VICO CHAT--}}

                                {{-- ROW BUTTONS --}}
                                    @include('bookings.sections.buttons')
                                {{-- END ROW BUTTONS --}}
                            @else
                                <div class="row text-center d-flex justify-content-center">
                                    <p><span class="icon-close" style="color: red;"></span> <br> Lo sentimos, la solicitud ha sido cancelada.</p>
                                </div>
                            @endif
                        {{-- END IF CANCELED BOOKING --}}
                    </div>
                {{-- COL LEFT --}}
            </div>
        {{-- ROW CONTENT --}}
    </div>
{{-- END CONTAINER UNDER FOTO --}}

@include('bookings.sections.modals')

@section('scripts')
    @include('bookings.sections.scripts')
    <script>
    function faqManager() {
        analytics.track('Enter manager FAQ',{
            category: 'User knowlage'
        });
    }
    </script>
    
@endsection
@endsection
