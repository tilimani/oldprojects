@extends('layouts.app')

@section('title', 'Admin Booking')

@section('content')
    @if (session('success-manual-payment'))
        <div class="alert alert-success" role="alert">
            {{ session('success-manual-payment') }}
        </div>
    @endif

    <div class="container mt-4 mb-4 px-0">

        <div class="content">

            <section>

                <h1 class="vico-color mt-4 mb-4 px-3 bold-words">Tus solicitudes abiertas</h1>

            </section>
            <section>

                <div class="">

                    <div class="nav-admin">

                        <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if (\Route::current()->getName() == 'bookings_admin') active @endif" 
                                id="noRespondidas-tab" data-toggle="tab" href="#tabNoRespondidas" role="tab" aria-controls="noRespondidas"
                                    aria-selected="true">No respondidas ({{ $sum1 }})
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="respondidas-tab" data-toggle="tab" href="#tabRespondidas" role="tab" aria-controls="respondidas" aria-selected="false">
                                    Respondidas ({{ $sum2 }})
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="aceptadas-tab" data-toggle="tab" href="#tabAceptadas" role="tab" aria-controls="aceptadas" aria-selected="false">
                                    Aceptadas ({{ $sum3 }})
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if (\Route::current()->getName() == 'admin_reviews') active @endif" id="reseñas-tab" data-toggle="tab" href="#tabReseñas" role="tab" aria-controls="reseñas" aria-selected="false">
                                    Reseñas ({{ $sum4 }})
                                </a>
                            </li>
                        </ul>

                    </div>

                </div>

                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade @if (\Route::current()->getName() == 'bookings_admin') show active @endif" id="tabNoRespondidas" role="tabpanel" aria-labelledby="noRespondidas-tab">

                        @forelse($rooms1 as $room)

                            <div class="card">

                                <div class="card-header">

                                    <div class="row">

                                        <div class="col-5">
                                            <b class="card-title">Hab. {{ $room->number }}</b>
                                            <br>
                                           {{ $room->vico->name }}
                                        </div>

                                        <div class="col-4">
                                            <b class="card-title">{{ date("d/m/y", strtotime($room->bookings1->min('date_from'))) }}</b>
                                            <br>
                                            <span class="font-weight-light small">A partir del</span>
                                        </div>

                                        <div class="col-1">
                                            <a class="btn btn-primary">{{ $room->bookings1->count() }}</a>
                                        </div>

                                        <div class="col-1">

                                            <button
                                                class="btn btn-link btn-link-arrow rotate-icon-90" type="button" data-toggle="collapse"
                                                data-target="#collapse1-{{ $room->id }}" aria-expanded="true" aria-controls="collapse1-{{ $room->id }}">
                                                <span class="icon-next-fom"></span>
                                            </button>

                                        </div>

                                    </div>

                                </div>

                                <div id="collapse1-{{ $room->id }}" class="collapse show" aria-labelledby="heading-{{ $room->id }}">

                                    @forelse($room->bookings1 as $booking)

                                        <div class="card-body">

                                            <div class="row">

                                                <div class="col-2 justify-content-center d-flex">
                                                    @if(isset($users->where('id', $booking->user_id)->first()->image))
                                                      <img class="img-responsive rounded-circle" style="width: 3rem; height: 3rem" src="http://fom.imgix.net/{{$users->where('id', $booking->user_id)->first()->image}}?w=500&h=500&fit=crop" alt="Administrador">
                                                    @elseif($users->where('id', $booking->user_id)->first()->gender== 2)
                                                      <img class="img-responsive rounded-circle" style="width: 3rem; height: 3rem" src="http://fom.imgix.net/manager_47.png?w=500&h=500&fit=crop" alt="Administrador">
                                                    @else
                                                      <img class="img-responsive rounded-circle" style="width: 3rem; height: 3rem" src="http://fom.imgix.net/manager_7.png?w=500&h=500&fit=crop" alt="Administrador">
                                                    @endif
                                                </div>

                                                <div class="col-7">

                                                    <b>
                                                       {{ $users->where('id', $booking->user_id)->first()->name
                                                       .' '.
                                                       $users->where('id', $booking->user_id)->first()->last_name }}
                                                    </b>

                                                    <div class="row">
                                                        <div class="col-6">
                                                            <span class="font-weight-bold small">{{ date("d/m/y", strtotime($booking->date_from)) }}</span>
                                                            <br><small>Llegada</small>
                                                        </div>
                                                        <div class="col-6">
                                                            <span class="font-weight-bold small">
                                                                {{
                                                                    (new Carbon\Carbon($booking->date_to))
                                                                        ->diff(new Carbon\Carbon($booking->date_from))
                                                                        ->format('%m')
                                                                }} meses
                                                            </span><br>
                                                            <small>Duración</small>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-2 justify-content-center d-flex">

                                                    @switch($booking->status)
                                                        @case(1)
                                                            <button type="button" href="/booking/show/{{$booking->id}}" onclick="window.open('/booking/show/{{$booking->id}}')" class="process-button btn-primary small btn">Responder solicitud</button>
                                                            @break
                                                        @case(3)
                                                                <button type="button" href="/booking/show/{{$booking->id}}" onclick="window.open('/booking/show/{{$booking->id}}')" class="process-button btn-primary small btn">Dar 48 horas de garantia </button>
                                                            @break
                                                        @default
                                                            <button type="button" href="/booking/show/{{$booking->id}}" onclick="window.open('/booking/show/{{$booking->id}}')" class="process-button btn-outline-primary small btn">Ver solicitud</button>
                                                    @endswitch

                                                </div>

                                            </div>

                                        </div>

                                        @empty

                                        <h4>Sin datos</h4>

                                    @endforelse

                                </div>

                            </div>

                        @empty <h2 class="vico-color-center mt-4 mb-4">No tienes solicitudes para responder</h2>

                        @endforelse

                    </div>

                    <div class="tab-pane fade" id="tabRespondidas" role="tabpanel" aria-labelledby="respondidas-tab">

                        @forelse($rooms2 as $room)

                            <div class="card">

                                <div class="card-header">

                                    <div class="row">

                                        <div class="col-5">
                                            <b class="card-title">Hab. {{ $room->number }}</b>
                                            <br>
                                           {{ $room->vico->name }}
                                        </div>

                                        <div class="col-4">
                                            <b class="card-title">{{ date("d/m/y", strtotime($room->bookings2->min('date_from'))) }}</b>
                                            <br>
                                            <span class="font-weight-light small">A partir del</span>
                                        </div>

                                        <div class="col-1">
                                            <a class="btn btn-primary">{{ $room->bookings2->count() }}</a>
                                        </div>

                                        <div class="col-1">

                                            <button
                                                class="btn btn-link btn-link-arrow  rotate-icon-90" type="button" data-toggle="collapse"
                                                data-target="#collapse2-{{ $room->id }}" aria-expanded="true" aria-controls="collapse2-{{ $room->id }}">
                                                 <span class="icon-next-fom"></span>
                                            </button>

                                        </div>

                                    </div>

                                </div>

                                <div id="collapse2-{{ $room->id }}" class="collapse show" aria-labelledby="heading-{{ $room->id }}">

                                    @forelse($room->bookings2 as $booking)

                                        <div class="card-body">

                                            <div class="row">

                                                <div class="col-2 justify-content-center d-flex">
                                                    @if(isset($users->where('id', $booking->user_id)->first()->image))
                                                      <img class="img-responsive rounded-circle" style="width: 3rem; height: 3rem" src="http://fom.imgix.net/{{$users->where('id', $booking->user_id)->first()->image}}?w=500&h=500&fit=crop" alt="Administrador">
                                                    @elseif($users->where('id', $booking->user_id)->first()->gender== 2)
                                                      <img class="img-responsive rounded-circle" style="width: 3rem; height: 3rem" src="http://fom.imgix.net/manager_47.png?w=500&h=500&fit=crop" alt="Administrador">
                                                    @else
                                                      <img class="img-responsive rounded-circle" style="width: 3rem; height: 3rem" src="http://fom.imgix.net/manager_7.png?w=500&h=500&fit=crop" alt="Administrador">
                                                    @endif
                                                </div>

                                                <div class="col-7">

                                                    <b>
                                                       {{ $users->where('id', $booking->user_id)->first()->name
                                                       .' '.
                                                       $users->where('id', $booking->user_id)->first()->last_name }}
                                                    </b>

                                                    <div class="row">
                                                        <div class="col-6">
                                                            <span class="font-weight-bold small">{{ date("d/m/y", strtotime($booking->date_from)) }}</span>
                                                            <br><small>Llegada</small>
                                                        </div>
                                                        <div class="col-6">
                                                            <span class="font-weight-bold small">
                                                                {{
                                                                    (new Carbon\Carbon($booking->date_to))
                                                                        ->diff(new Carbon\Carbon($booking->date_from))
                                                                        ->format('%m')
                                                                }} meses
                                                            </span>
                                                            <br><small>Duración</small>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-2 justify-content-center d-flex">
                                                    @switch($booking->status)
                                                        @case(2)
                                                                <button type="button" href="/booking/show/{{$booking->id}}" onclick="window.open('/booking/show/{{$booking->id}}')" class="process-button btn-accepted small btn">Ver solicitud aceptada</button>
                                                            @break
                                                        @case(4)
                                                        |   <a style="color: #E49212;" href="/booking/show/{{$booking->id}}" > En proceso de pago</a> <br>   
                                                            <a style="color: #E49212;" href="{{route('manager.paymentmanual',[$booking->id])}}" target="_blank">Pagar deposito</a> <br>
                                                            {{-- <a style="color: #E49212;" href="/bookingdate/manager/{{$booking->id}}">Cambiar Fecha</a>
                                                                <button type="button" href="/booking/show/{{$booking->id}}" onclick="window.open('/booking/show/{{$booking->id}}')" class="process-button btn-payment small btn">En proceso de pago</button>
                                                                <button type="button" href="/manager/paymentmanual/{{$booking->id}}" onclick="window.open('/manager/paymentmanual/{{$booking->id}}')" class="process-button btn-payment small btn">Pagar deposito</button> --}}
                                                            @break
                                                        @default
                                                            <button type="button" href="/booking/show/{{$booking->id}}" onclick="window.open('/booking/show/{{$booking->id}}')" class="process-button btn-outline-primary small btn">Ver solicitud</button>
                                                    @endswitch
                                                </div>

                                            </div>

                                        </div>

                                        @empty

                                        <h4>Sin datos</h4>

                                    @endforelse

                                </div>

                            </div>

                        @empty <h2 class="vico-color-center mt-4 mb-4">No tienes solicitudes para responder</h2>

                        @endforelse

                    </div>

                    <div class="tab-pane fade" id="tabAceptadas" role="tabpanel" aria-labelledby="aceptadas-tab">

                        @forelse($rooms3 as $room)

                            <div class="card">

                                <div class="card-header">

                                    <div class="row">

                                        <div class="col-5">
                                            <b class="card-title">Hab. {{ $room->number }}</b>
                                            <br>
                                           {{ $room->vico->name }}
                                        </div>

                                        <div class="col-4">
                                            <b class="card-title">{{ date("d/m/y", strtotime($room->bookings3->min('date_from'))) }}</b>                                            <br>
                                            <span class="font-weight-light small">A partir del</span>
                                        </div>

                                        <div class="col-1">
                                            <a class="btn btn-primary">{{ $room->bookings3->count() }}</a>
                                        </div>

                                        <div class="col-1">

                                            <button
                                                class="btn btn-link btn-link-arrow  rotate-icon-90" type="button" data-toggle="collapse"
                                                data-target="#collapse3-{{ $room->id }}" aria-expanded="true" aria-controls="collapse3-{{ $room->id }}">
                                                 <span class="icon-next-fom"></span>
                                            </button>

                                        </div>

                                    </div>

                                </div>

                                <div id="collapse3-{{ $room->id }}" class="collapse show" aria-labelledby="heading-{{ $room->id }}">

                                    @forelse($room->bookings3 as $booking)

                                        <div class="card-body">

                                            <div class="row">

                                                <div class="col-2 justify-content-center d-flex">
                                                    @if(isset($users->where('id', $booking->user_id)->first()->image))
                                                      <img class="img-responsive rounded-circle" style="width: 3rem; height: 3rem" src="http://fom.imgix.net/{{$users->where('id', $booking->user_id)->first()->image}}?w=500&h=500&fit=crop" alt="Administrador">
                                                    @elseif($users->where('id', $booking->user_id)->first()->gender== 2)
                                                      <img class="img-responsive rounded-circle" style="width: 3rem; height: 3rem" src="http://fom.imgix.net/manager_47.png?w=500&h=500&fit=crop" alt="Administrador">
                                                    @else
                                                      <img class="img-responsive rounded-circle" style="width: 3rem; height: 3rem" src="http://fom.imgix.net/manager_7.png?w=500&h=500&fit=crop" alt="Administrador">
                                                    @endif
                                                </div>

                                                <div class="col-7">

                                                    <b>
                                                       {{ $users->where('id', $booking->user_id)->first()->name
                                                       .' '.
                                                       $users->where('id', $booking->user_id)->first()->last_name }}
                                                    </b>

                                                    <div class="row">
                                                        <div class="col-6">
                                                            <span class="font-weight-bold small">{{ date("d/m/y", strtotime($booking->date_from)) }}</span>
                                                            <br><small>Llegada</small>
                                                        </div>
                                                        <div class="col-6">
                                                            <span class="font-weight-bold small">
                                                                {{
                                                                    (new Carbon\Carbon($booking->date_to))
                                                                        ->diff(new Carbon\Carbon($booking->date_from))
                                                                        ->format('%m')
                                                                }} meses
                                                            </span>
                                                            <br><small>Duración</small>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-sm-2 justify-content-center">

                                                    @switch($booking->status)
                                                        @case(5)
                                                            <a style="color: #E49212;" href="/booking/show/{{$booking->id}}"> Ver Solicitud</a> <br>   
                                                            <a style="color: #E49212;" href="{{route('manager.paymentmanual',[$booking->id])}}" target="_blank">Registrar un Pago</a> <br>
                                                            <a style="color: #E49212;" href="/bookingdate/manager/{{$booking->id}}">Cambiar Fecha</a>
                                                            @break
                                                        @case(50)
                                                                <button type="button" href="/booking/show/{{$booking->id}}" onclick="window.open('/booking/show/{{$booking->id}}')" class="process-button btn-accepted small btn">Proceso de pago</button>
                                                            @break
                                                        @default
                                                            <button type="button" href="/booking/show/{{$booking->id}}" onclick="window.open('/booking/show/{{$booking->id}}')" class="process-button btn-outline-primary small btn">Ver solicitud</button>
                                                    @endswitch

                                                </div>

                                            </div>

                                        </div>

                                        @empty

                                        <h4>Sin datos</h4>

                                    @endforelse

                                </div>

                            </div>

                        @empty <h2 class="vico-color-center mt-4 mb-4">No tienes solicitudes confirmadas</h2>

                        @endforelse

                    </div>

                    <div class="tab-pane fade @if (\Route::current()->getName() == 'admin_reviews') show active @endif" id="tabReseñas" role="tabpanel" aria-labelledby="reseñas-tab">

                        @forelse($rooms4 as $room)

                            <div class="card">

                                <div class="card-header">

                                    <div class="row">

                                        <div class="col-5">
                                            <b class="card-title">Hab. {{ $room->number }}</b>
                                            <br>
                                           {{ $room->vico->name }}
                                        </div>

                                        <div class="col-4">
                                            <b class="card-title">{{ date("d/m/y", strtotime($room->bookings4->min('date_from'))) }}</b>                                            <br>
                                            <span class="font-weight-light small">A partir del</span>
                                        </div>

                                        <div class="col-1">
                                            <a class="btn btn-primary">{{ $room->bookings4->count() }}</a>
                                        </div>

                                        <div class="col-1">

                                            <button
                                                class="btn btn-link btn-link-arrow  rotate-icon-90" type="button" data-toggle="collapse"
                                                data-target="#collapse3-{{ $room->id }}" aria-expanded="true" aria-controls="collapse3-{{ $room->id }}">
                                                 <span class="icon-next-fom"></span>
                                            </button>

                                        </div>

                                    </div>

                                </div>

                                <div id="collapse3-{{ $room->id }}" class="collapse show" aria-labelledby="heading-{{ $room->id }}">

                                    @forelse($room->bookings4 as $booking)

                                        <div class="card-body">
                                            <div class="row">

                                                <div class="col-2 justify-content-center d-flex">
                                                    @if(isset($users->where('id', $booking->user_id)->first()->image))
                                                      <img class="img-responsive rounded-circle" style="width: 3rem; height: 3rem" src="http://fom.imgix.net/{{$users->where('id', $booking->user_id)->first()->image}}?w=500&h=500&fit=crop" alt="Administrador">
                                                    @elseif($users->where('id', $booking->user_id)->first()->gender== 2)
                                                      <img class="img-responsive rounded-circle" style="width: 3rem; height: 3rem" src="http://fom.imgix.net/manager_47.png?w=500&h=500&fit=crop" alt="Administrador">
                                                    @else
                                                      <img class="img-responsive rounded-circle" style="width: 3rem; height: 3rem" src="http://fom.imgix.net/manager_7.png?w=500&h=500&fit=crop" alt="Administrador">
                                                    @endif
                                                </div>

                                                <div class="col-7">

                                                    <b>
                                                       {{ $users->where('id', $booking->user_id)->first()->name // <-----HORRIBLE
                                                       .' '.
                                                       $users->where('id', $booking->user_id)->first()->last_name }}
                                                    </b>

                                                    <div class="row">
                                                        <div class="col-6">
                                                            <span class="font-weight-bold small">{{ date("d/m/y", strtotime($booking->date_from)) }}</span>
                                                            <br><small>Llegada</small>
                                                        </div>
                                                        <div class="col-6">
                                                            <span class="font-weight-bold small">
                                                                {{
                                                                    (new Carbon\Carbon($booking->date_to))
                                                                        ->diff(new Carbon\Carbon($booking->date_from))
                                                                        ->format('%m')
                                                                }} meses
                                                            </span>
                                                            <br><small>Duración</small>
                                                        </div>
                                                    </div>

                                                    @if (in_array($booking->status,[70,71]))
                                                        {{$users->where('id', $booking->user_id)->first()->name}} ya hizo una reseña
                                                    @endif
                                                </div>

                                                <div class="col-2 justify-content-center d-flex">

                                                    @switch($booking->status)
                                                        @case(5)
                                                                <button type="button" href="/booking/show/{{$booking->id}}" onclick="window.open('/booking/show/{{$booking->id}}')" class="process-button btn-payment small btn">Ver solicitud confirmada</button>
                                                            @break
                                                        @case(50)
                                                                <button type="button" href="/booking/show/{{$booking->id}}" onclick="window.open('/booking/show/{{$booking->id}}')" class="process-button btn-accepted small btn">Proceso de pago</button>
                                                            @break
                                                        @case(6)
                                                        @case(71)
                                                                <button type="button" href="/booking/{{$booking->id}}/review/manager" onclick="window.open('/booking/{{$booking->id}}/review/manager')" class="process-button btn-accepted small btn">Haz tu reseña</button>
                                                            @break
                                                        @case(70)
                                                        @case(72)
                                                                {{--  <button type="button" href="" onclick="window.open('')" class="process-button btn-accepted small btn">Reseña hecha</button>  --}}
                                                                <span  class="process-button btn-accepted small btn" style="cursor: default" >Reseña hecha</span>

                                                            @break
                                                        @default
                                                            <button type="button" href="/booking/show/{{$booking->id}}" onclick="window.open('/booking/show/{{$booking->id}}')" class="process-button btn-outline-primary small btn">Ver solicitud</button>
                                                    @endswitch

                                                </div>

                                            </div>

                                        </div>

                                        @empty

                                        <h4>Sin datos</h4>

                                    @endforelse

                                </div>

                            </div>

                        @empty <h2 class="vico-color-center mt-4 mb-4">No tienes solicitudes confirmadas</h2>

                        @endforelse

                    </div>
                </div>

            </section>

        </div>

    </div>
    @include('layouts.sections._intercom')
 
@endsection
