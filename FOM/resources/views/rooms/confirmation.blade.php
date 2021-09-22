@extends('layouts.app')
@section('title', 'Confirmación')
@section('content')

<head><meta name="viewport" content="width=device-width, initial-scale=1.0" /></head>

<style>
    #header-image {
        color: white;
        background: url('/images/reservationConfirmation/smilingBanner.jpg') top right/cover no-repeat;
        height: 400px;
        display: flex;
        background-position: center;
        justify-content: center;
        flex-direction: column;
        align-items: center;
        text-transform: uppercase;
        border-radius: 50px 50px 0 0;
    }

    #header-image-2 {
        color: white;
        background: url('/images/reservationConfirmation/devices.jpg') top right/cover no-repeat;
        height: 400px;
        display: flex;
        background-color: #3d3d3d;
        background-blend-mode: overlay;
        background-position: center;
        justify-content: center;
        flex-direction: column;
        align-items: center;
        text-transform: uppercase;
        border-radius: 50px 50px 0 0;
    }

    #header-text {
        color: white;
        margin: 0 5% 0 5%;
        text-align: center;

    }

    #vico-icon {
        opacity: 0.8;
        height: 50px;
        width: 50px;
        margin-bottom: 50px;
    }

    #progress-bar {
        height: 300px;
    }

    #progress-bar-mobile {
        height: 535px;
        margin-top: 30px;
        margin-left: 30px;
    }

    #transparent-btn {
        background: transparent;
        margin-right: 50px;
        border: 0;
        margin: 0;
    }

    .container, #header-image {
        border-bottom: 0;
    }

    .container {
        margin-top: 50px;
        margin-bottom: 50px;
        border-radius: 50px 50px 50px 50px;
        box-shadow: 3px 3px 9px 0px rgba(153,153,153,1);
        border: white solid 1px;
    }

    #resumen {
        padding: 25px 0 50px 0;
    }

    .topic-words {
        color: #7f7f7f;
    }

    #resumen-words {
        padding-bottom: 30px;
    }

    #code-holder {
        border: 2px lightgrey dashed;
        padding: 7px;
        display: flex;
        min-width: 300px;
        max-width: 60%;
        border-radius: 30px;
        margin: auto;
        margin-bottom: 40px;
    }

    #social-media {
        display: flex;
        min-width: 300px;
        max-width: 60%;
    }

    .icono {
        width: 50px;
        margin-bottom: 5px;
        margin-top: 5px;
    }

    .text-overflow-center {
        margin-left: -100%;
        margin-right: -100%;
        text-align: center;
    }

    .small-grey-text {
        font-size: 15px;
        color: #7f7f7f;
        margin-bottom: 0;
        padding: 0 30px 0 30px;
        text-align: justify;

    }

    .linea-gris {
        max-width: 100%;
        padding-top: 20px;
    }

    .icono-social {
        width: 60px;
    }

    .rotated {
        transform: rotate(90deg);
        margin-bottom: 30px;
        margin-top: 30px;
        width: 72px;
    }

    .mobile-progress {
        padding-top: 8px;
        padding-left: 0;
        min-height: 140px;
    }   

    .mobile-title {
        margin-bottom: 0px;
    }

    .mobile-title-1 {
        margin-top: 0;
    }

    #warning {
        padding: 30px 30px 0 30px;
    }

    html, body {
        width: 100%; 
        height: 100%; 
        margin: 0px; 
        padding: 0px; 
        overflow-x: hidden;
    }

    /* ------- ANIMACIONES ------------ */

    .icono-under {position: absolute;}

    .fade-out {animation: fade 1s forwards;}

    .fade-in {animation: fade-in 1s forwards;}

    @keyframes fade {
        0% {opacity: 1;}
        100% {opacity: 0;}
    }

    @keyframes fade-in {
        0% {opacity: 0;}
        100% {opacity: 1;}
    }

    /* ----------- PROBLEMS IN MOBILE ---------- */

    @media (max-width: 400px) {
        #progress-bar-mobile {
            margin-left: 0;
        }

        #header-text {
            font-size: 25px;
            padding: 0 15px 0 15px;
        }

        .rotated {
            margin-left: 8px;
        }
    }

    @media (max-width: 992px) {
        .small-grey-text {
            padding-left: 0;
        }
    }
    
    /* --------- REMOVE BOXES IN MOBILE ------- */ 

    @media (max-width: 425px){
        .container {
            margin: 0;
            border: 0;
            border-radius: 0;
            box-shadow: none;

        }

        #header-image {
            border-radius: 0;
        }

        #header-image-2 {
            border-radius: 0;
        }
        .small-grey-text{
            padding: 0 10px 0 0px;
            text-align: justify;
        }
    }

</style>

<!-- First Container -->
<div class="container">
    <!-- Header Start -->
    <div class="row" id="header-image">
        <div class="row">
            <img src="/images/vico_logo/vico_v@2x_white.png" id="vico-icon">
        </div>
        <div class="row justify-content-center" style="width: 100%;">
        <h1 id="header-text">{{$booking->user->name}}{{trans('rooms/confirmation.thanks_reserve')}}</h1>
        </div>
    </div>
    <!-- Desktop View --> 
    <div class="row justify-content-center align-center text-center mt-5 mb-4 d-lg-flex d-none">
        <p>{{trans('rooms/confirmation.we_waiting_for')}} {{$booking->room->house->manager->user->name}} {{trans('rooms/confirmation.to_accept_request')}}</p>
    </div>
    <div class="row justify-content-center align-center text-center mb-5 d-lg-flex d-none">
        <div class="col-1 p-0">
            <img class="icono text-overflow-center top-1" src="/svg/campana-icono.svg">
            <img class="icono text-overflow-center d-none checkmark-1" src="/svg/checkmark-icono.svg">
            <p class="text-overflow-center">{{trans('rooms/confirmation.request')}}</p>
            <p class="text-overflow-center small-grey-text"> {{$booking->room->house->name}} / {{trans('rooms/confirmation.room')}} #{{$booking->room->number}}</p>
            <p class="text-overflow-center small-grey-text">{{trans('rooms/confirmation.room_available')}}</p>
        </div>
        <div class="col-2"> <img class="linea-gris" src="/images/reservationConfirmation/linea-gris.png" alt=""> </div>
        <div class="col-1 p-0">
            <img class="icono text-overflow-center top-2" src="/svg/calendario-icono-gris.svg" alt="">
            <img class="icono text-overflow-center d-none middle-2" src="/svg/calendario-icono-naranja.svg">
            <img class="icono text-overflow-center d-none checkmark-2" src="/svg/checkmark-icono.svg">
            <p class="text-overflow-center">{{trans('rooms/confirmation.reserve_online')}}</p>
            <p class="text-overflow-center small-grey-text">{{trans('rooms/confirmation.available_confirmation')}}</p>
            <p class="text-overflow-center small-grey-text">{{trans('rooms/confirmation.waiting_for')}}</p>  
            </div>
        <div class="col-2"> <img class="linea-gris" src="/images/reservationConfirmation/linea-gris.png" alt=""> </div>
        <div class="col-1 p-0">
            <img class="icono text-overflow-center top-3" src="/svg/recibo-icono-gris.svg" alt="">
            <img class="icono text-overflow-center d-none middle-3" src="/svg/recibo-icono-naranja.svg">
            <img class="icono text-overflow-center d-none checkmark-3" src="/svg/checkmark-icono.svg">
            <p class="text-overflow-center">{{trans('rooms/confirmation.deposit_payment')}}</p>
            <p class="text-overflow-center small-grey-text">{{trans('rooms/confirmation.you_have_48')}}</p>
        </div>        
        <div class="col-2"> <img class="linea-gris" src="/images/reservationConfirmation/linea-gris.png" alt=""> </div>
        <div class="col-1 p-0">
            <img class="icono text-overflow-center top-4" src="/svg/vico-icono.svg" alt="">
            <img class="icono text-overflow-center d-none middle-4" src="/svg/vico-icono-naranja.svg" alt=""><br>
            <p class="text-overflow-center">Vivir entre amigos</p>
            <p class="text-overflow-center small-grey-text">{{trans('rooms/confirmation.reservation_paid')}}</p>
        </div>
    </div>
    <!-- Mobile View --> 
    <div class="row d-lg-none justify-content-center mobile-icon-view mx-auto text-center" id="warning">
        <p>Estamos esperando que {{$booking->room->house->manager->user->name}} acepte tu solicitud para poder proceder con el pago.</p>
    </div>
    <div class="row d-lg-none justify-content-center mobile-icon-view" id="progress-bar-mobile">
        <div class="col-3">
                <img class="icono top-1" src="/svg/campana-icono.svg">
                <img class="icono d-none checkmark-1" src="/svg/checkmark-icono.svg">
                <br>
                <img class="linea-gris rotated" src="/images/reservationConfirmation/linea-gris.png" alt=""> 
                <br>
                <img class="icono top-2" src="/svg/calendario-icono-gris.svg" alt="">
                <img class="icono d-none middle-2" src="/svg/calendario-icono-naranja.svg">
                <img class="icono d-none checkmark-2" src="/svg/checkmark-icono.svg">
                <br>
                <img class="linea-gris rotated" src="/images/reservationConfirmation/linea-gris.png" alt="">
                <br> 
                <img class="icono top-3" src="/svg/recibo-icono-gris.svg" alt="">
                <img class="icono d-none middle-3" src="/svg/recibo-icono-naranja.svg">
                <img class="icono d-none checkmark-3" src="/svg/checkmark-icono.svg">
                <br>
                <img class="linea-gris rotated" src="/images/reservationConfirmation/linea-gris.png" alt="">
                <br>
                <img class="icono top-4" src="/svg/vico-icono.svg" alt="">
                <img class="icono d-none middle-4" src="/svg/vico-icono-naranja.svg" alt="">
        </div>
        <div class="col-9" style="padding: 0 3px 0 3px;">
            <div class="mobile-progress">
                <p class="mobile-title mobile-title-1">{{trans('rooms/confirmation.request')}}</p>
                <p class="small-grey-text">{{$booking->room->house->name}} / {{trans('rooms/confirmation.room')}} {{$booking->room->number}}</p>
                <p class="small-grey-text">{{trans('rooms/confirmation.room_available')}}</p>
            </div>
            <div class="mobile-progress">
                <p class="mobile-title">{{trans('rooms/confirmation.available_confirmation')}}</p>
                <p class="small-grey-text">{{trans('rooms/confirmation.waiting_for')}}</p>        
            </div>
            <div class="mobile-progress">
                <p class="mobile-title mobile-title-3">{{trans('rooms/confirmation.deposit_payment')}}</p>
                <p class="small-grey-text">{{trans('rooms/confirmation.you_have_48')}}</p>
            </div>
            <div  class="mobile-progress">
                <p class="mobile-title mobile-title-3">Vivir entre amigos</p>
                <p class="small-grey-text">{{trans('rooms/confirmation.reservation_paid')}}</p>       
            </div>

        </div>
    </div>
    <!-- Resumen Start -->
    <div id="resumen">
        <div id="resumen-words">
            <div class="row justify-content-center">
                <div class="col-5"><p class="bold-words">{{trans('rooms/confirmation.summary')}}</p></div>
                <div class="col-5 text-right"><p></p></div>
            </div>
            <div class="row justify-content-center">
                <div class="col-5 topic-words"><p>{{trans('rooms/confirmation.monthly_rent')}}</p></div>
                <div class="col-5 text-right"><p>{{date("d.m.y", strtotime($booking->date_from))}} - {{date("d.m.y", strtotime($booking->date_to))}}</p></div>
            </div>
            <div class="row justify-content-center">
                <div class="col-2 topic-words"><p>{{trans('rooms/confirmation.for')}}</p></div>
                <div class="col-8 text-right"><p>{{$booking->room->house->name}} / {{trans('rooms/confirmation.room')}} {{$booking->room->number}}</p></div>
            </div>
            <div class="row justify-content-center">
                <div class="col-3 topic-words"><p>{{trans('rooms/confirmation.owner')}}</p></div>
                <div class="col-7 text-right"><p>{{$booking->room->house->manager->user->name}}</p></div>
            </div>
            <div class="row justify-content-center">
                <div class="col-4 topic-words"><p>{{trans('rooms/confirmation.total_value')}}</p></div>
                <div class="col-6 text-right"><p>{{$booking->room->price}} COP</p></div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 text-right">
                <a class="btn" id="transparent-btn" href="{{url('/houses/'.$booking->room->house->id)}}">{{trans('rooms/confirmation.keep_looking')}}</a>
                <a class="btn btn-primary" id="buscar" href="{{route('vico.process')}}">{{trans('rooms/confirmation.see_requests')}}</a></div>
            </div>
    </div>
</div>
<!-- Second Container --> 
<div class="container">
    <!-- Header Start -->
    <div class="row" id="header-image-2">
            <div class="row">
                <img src="/images/vico_logo/vico_v@2x_white.png" id="vico-icon">
            </div>
            <div class="row">
                <h1 id="header-text">{{trans('rooms/confirmation.remember_share_code')}}</h1>
            </div>
        </div>
    <!-- Code Information -->
    <div class="row justify-content-center p-3">
            <p class="small-grey-text pt-3 pb-3 pl-3 pr-3">{{trans('rooms/confirmation.for_each_friend')}}</p>        
    </div>
    
    {{-- No esta funcionando
    <div class="row justify-content-center" id="code-holder">
            <div class="col-5 text-left ml-0" style="margin: auto;"><p class="m-0 text-uppercase">{{ Auth::user()->vicoReferrals->first()->code}}</p></div>
            <div class="col-7 text-right"><a target="_blank" class="btn btn-primary" href="https://wa.me/?text=Hola!!%20Te%20recomiendo%20usar%20www.getvico.com%20para%20encontrar%20tu%20habitaci%C3%B3n,%20puedes%20ganar%2010%20USD%20si%20utlizas%20mi%20codigo:%20%22{{ Auth::user()->vicoReferrals->first()->code}}%22%20!"><span class=" pr-1 icon-whatsapp-black" class="col-6 text-center btn btn-primary" style="min-width: 115px; color: white !important"></span> {{trans('rooms/confirmation.share')}}</a></div>
    </div>
    --}}
    
    <!-- Social Media Logos --> 
    <div class="row justify-content-center mx-auto" id="social-media">
        <div class="col-3 text-center d-none"><img class="icono-social" src="/svg/whatsapp-icono.svg" alt=""></div>
        <div class="col-3 text-center d-none"><img class="icono-social" src="/svg/mensaje-icono.svg" alt=""></div>
        <div class="col-3 text-center d-none"><img class="icono-social" src="/svg/compartir-icono.svg" alt=""></div>
        <div class="col-3 text-center d-none"><img class="icono-social" src="/svg/enlace-icono.svg" alt=""></div>
    </div>
    <div class="row justify-content-center p-3">
        <p class="text-center small-grey-text">{{trans('rooms/confirmation.only_valid')}}</p>
    </div>
 </div>

 <script>

    function uniqueinit(){
        // get top targets
        var top1 = Object.values(document.getElementsByClassName('top-1')),
            top2 = Object.values(document.getElementsByClassName('top-2')),
            top3 = Object.values(document.getElementsByClassName('top-3')),
            top4 = Object.values(document.getElementsByClassName('top-4'))

        // get middle targets
        var middle2 = Object.values(document.getElementsByClassName('middle-2')),
            middle3 = Object.values(document.getElementsByClassName('middle-3')),
            middle4 = Object.values(document.getElementsByClassName('middle-4'))

        // get checkmarks
        var checkmark1 = Object.values(document.getElementsByClassName('checkmark-1')),
            checkmark2 = Object.values(document.getElementsByClassName('checkmark-2')),
            checkmark3 = Object.values(document.getElementsByClassName('checkmark-3'))

        function trans(togo, tocome){
            togo.forEach(element => {element.classList.add('fade-out');}); 
            setTimeout(function(){disp(togo, tocome)}, 1000);
        }

        function disp(togo, tocome){
            togo.forEach(element => {element.classList.add('d-none')});
            tocome.forEach(element => {setTimeout(element.classList.remove('d-none'), 50);});
            tocome.forEach(element => {setTimeout(element.classList.add('fade-in'), 51);});
        }

        if ({{$booking->mode}} == 5){
            trans(top1, checkmark1);
            setTimeout(function(){trans(top2, checkmark2)}, 400);
            setTimeout(function(){trans(top3, checkmark3)}, 800);
            setTimeout(function(){trans(top4, middle4)}, 1000);
        }

        else if ({{$booking->mode}} == 4){
            trans(top1, checkmark1);
            setTimeout(function(){trans(top2, checkmark2)}, 300);
            setTimeout(function(){trans(top3, middle3)}, 600);
        }

        else {
            trans(top1, checkmark1);
            setTimeout(function(){trans(top2, middle2)}, 300)
        }
    }

    
        
 </script>

@endsection

@section('scripts')
@if (Auth::check())
    <script>
        window.onload = uniqueinit 
        fbq('trackCustom', 'Request', {room: {{$booking->room->id}}, booking: {{$booking->id}}});
    </script>
@endif
@endsection