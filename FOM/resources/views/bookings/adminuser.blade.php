@extends('layouts.app')
@section('title', 'Mis solicitudes')
@section('content')
<style type="text/css">
    #progressbar {
    margin-bottom: 0;
    overflow: hidden;
    /*CSS counters to number the steps*/
    counter-reset: step;
    padding: 0;
    }
    #progressbar .active{
   color:#3a3a3a;
    }
    #progressbar li {
      list-style-type: none;
      color: #dadada;
      /*text-transform: uppercase;*/
      font-size: 12px;
      width: 33.33%;
      float: left;
      position: relative;
      z-index: 10000;
    }
    #progressbar li:before {
      content: counter(step);
      counter-increment: step;
      width: 20px;
      line-height: 20px;
      display: block;
      font-size: 10px;
      color: white;
      background: #dadada;
      border-radius: 3px;
      margin: 0 auto 5px auto;
    }
    /*progressbar connectors*/
    #progressbar li:after {
      content: '';
      width: 100%;
      height: 2px;
      background: #dadada;
      position: absolute;
      left: -50%;
      top: 9px;
      z-index: -1; /*put it behind the numbers*/
    }
    #progressbar li:first-child:after {
      /*connector not needed before the first step*/
      content: none;
    }
    /*marking active/completed steps green*/
    /*The number of the step and the connector before it = green*/
    #progressbar li.active:before,  #progressbar li.active:after{
      background: #27AE60;
      color: white;
    }

</style>
  <div class="container mt-2">
  @forelse($bookings as $booking)


        {{-- CONTAINER BOOKING + CONFIRMATION --}}
          <div class="container-fluid mb-4">
            {{-- STICKY CONFIRMATION --}}
              @if($booking->status == 5)
                <div class="row">
                  <div class="col-12 p-0">
                    <ul class="notification-bar mb-0 px-0 ">
                       <li class="active mt-0">
                           {{-- CARD --}}
                          <div class="card ml-0 w-100 position-static">
                              <header class="card-header text-center">
                                  <a href="#" data-toggle="collapse" data-target="#state5" aria-expanded="true" class="">
                                      <span class="title">Confirmado<span class="float-left">&#10004;</span></span>
                                  </a>
                              </header>
                              {{-- COLLAPSE --}}
                              <div class="collapse" id="state5" style="background-color: white; border: white;">
                                  {{-- <p class="card-body col-lg-6 col-12 mx-lg-auto " style="border: 0px white; background-color: white; color: #3a3a3a;">
                                      {{$booking->manager_info->name}} {{$booking->manager_info->last_name}}<br>
                                      Whatsapp/Mobile: {{$booking->manager_info->phone}}<br>
                                      Mail: <a href="mailto:{{$booking->manager_info->email}}">{{$booking->manager_info->email}}</a><br>
                                      {{date('d/m/y', strtotime($booking->date_from))}} - {{date('d/m/y', strtotime($booking->date_to))}}<br>
                                      Hab {{$room->number}} - {{$room->price}} COP<br>
                                      {{$house->name}}<br>
                                      Dirección: {{$house->address}}, Medellín, Colombia
                                  </p> --}} {{--card-body.//--}}
                              </div>
                              {{--COLLAPSE .//--}}
                          </div>
                          {{--CARD.//--}}
                      </li>
                    </ul>
                  </div>
                </div>
              @endif
            {{-- END STICKY CONFIRMATION --}}
            {{-- STICKY CANCELD --}}
              @if($booking->status < 0)
                <div class="row">
                  <div class="col-12 p-0">
                    <ul class="notification-bar mb-0 px-0 ">
                       <li class="active mt-0">
                           {{-- CARD --}}
                          <div class="card ml-0 w-100 position-static" style="background-color: red; border-color: red">
                              <header class="card-header text-center">
                                  <a href="#" data-toggle="collapse" data-target="#state5" aria-expanded="true" class="">
                                      <span class="title">Cancelado</span>
                                  </a>
                              </header>
                              <div class="collapse" id="state5" style="background-color: white; border: white;">
                                  {{-- <p class="card-body col-lg-6 col-12 mx-lg-auto " style="border: 0px white; background-color: white; color: #3a3a3a;">
                                      {{$booking->manager_info->name}} {{$booking->manager_info->last_name}}<br>
                                      Whatsapp/Mobile: {{$booking->manager_info->phone}}<br>
                                      Mail: <a href="mailto:{{$booking->manager_info->email}}">{{$booking->manager_info->email}}</a><br>
                                      {{date('d/m/y', strtotime($booking->date_from))}} - {{date('d/m/y', strtotime($booking->date_to))}}<br>
                                      Hab {{$room->number}} - {{$room->price}} COP<br>
                                      {{$house->name}}<br>
                                      Dirección: {{$house->address}}, Medellín, Colombia
                                  </p> --}} <!-- card-body.// -->
                              </div>
                              {{-- COLLAPSE .// --}}
                          </div>
                          {{-- CARD.// --}}
                      </li>
                    </ul>
                  </div>
                </div>
              @endif
            {{-- END STICKY CANCELD --}}
            {{-- STICKY CONFIRMATION --}}

            {{-- ROW FOR EACH BOOKING --}}
              <div class="row  shadow justify-content-center">
                <div class="col-lg-3 col-12 p-0">
                  <img src="http://fom.imgix.net/{{$booking->image}}?w=750&h=500&fit=crop" style="max-width: 100%">
                </div>
                <div class="col-lg-9 col-12 pt-2">
                  <p class="">
                    Hab {{$booking->number}} - {{$booking->price}} COP
                    @if($booking->status==4 )<span class=" icon-circle-green float-right" style="padding: .3rem"></span><span class="small float-right" style="color:#dadada">Proceso de pago</span>
                    @elseif($booking->status==3) <span class="small float-right" style="color:#dadada">Disponibilidad confirmada</span>
                    @elseif($booking->status==1) <span class="small float-right" style="color:#dadada">Esperando respuesta del dueño</span>
                    @endif <br>
                    <a href="/houses/{{$booking->house_id}}" target="_blank">{{$booking->house_name}} ></a><br>
                    {{date('d/m/y', strtotime($booking->date_from))}} - {{date('d/m/y', strtotime($booking->date_to))}}
                  </p>
                  
                    {{-- 3 PART PROCESS --}}
                      @if($booking->status > 0 AND $booking->status < 5)
                       <ul id="progressbar">
                           <li class="active text-center" style="z-index: 1003">Solicitud</li>
                           <li class="@if($booking->status >= 3 )active @endif text-center" style="z-index: 1002">Disponibilidad confirmada</li>
                           <li class="@if($booking->status >= 4 )active @endif text-center" style="z-index: 1001">Proceso de pago</li>
                        </ul>
                      @endif
                 
                    {{-- To review --}}

                      @if(in_array($booking->status, [6,72]))
                        <a href="{{route('get_user_review', $booking->id)}}" class="float-right" target="_blank">Crear reseña</a>

                    {{-- Already Reviewed --}}

                      @elseif(in_array($booking->status, [70,71]))
                        <span  class="float-right" target="_blank">Ya dejaste una reseña</span>
                     
                    {{-- Status 5 --}}

                      @elseif($booking->status == 5)
                        <a href="{{route('payments_admin', $booking->id)}}" class="float-right" target="_blank">Déposito y pagos de tu estancia</a>
                        <br>
                        <a href="{{route('download.contract.pdf', $booking->id)}}" class="float-right" target="_blank">Descarga contrato de arrendamiento de la VICO</a>
                        <br>
                        <a href="{{route('vico.process')}}" class="float-right" target="_blank">Ver solicitud</a>
                      
                    {{-- Others --}}

                      @else
                        <a href="{{route('vico.manager.process', $booking->id)}}" class="float-right" target="_blank">Ver solicitud</a>
                      @endif
                  {{-- END 3 PART PROCESS --}}
                </div>
              </div>
            {{-- END ROW FOR EACH BOOKING --}}
          </div>
          {{-- CONTAINER BOOKING + STICKY CONFIRMATION --}}
  @empty
    <p>Todavía no tienes solicitudes abiertas, ¡empieza a buscar!</p>
  @endforelse
</div>
@endsection
