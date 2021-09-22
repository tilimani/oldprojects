@extends('layouts.app')
@section('title', 'Habitación'." ".$room->number )
@section('content')
@section('styles')
<style type="text/css">
@media (min-width: 350px){
        .container{     
            padding-top: 5rem;
            padding-left: 15px;
            padding-right: 15px;
        }
    }
    @media (min-width: 1200px)
.container {
}

@media (min-width: 992px)
.container {
    width: 970px;
}
@media (min-width: 768px)
.container {
    width: 750px;
}
    @media (min-width: 1200px){
        .container{     
            margin-right: 135px
            margin-left:135px;
            padding-left: 15px;
            padding-right: 15px;
                width: 1170px;
   
    }
    .tiempo-estancia{
        margin-top: 20px;
    }
    .tiempo-estancia label{
        display: block;
    }
    .vico-hero{
        margin-top:10px;
    }
    .vico-hero p{
        text-align: center;
    }
    .image-room{
        width:100%;
    }
    .room-info a{
        top: 5.5rem;
    }
    .mb-0 a{
        color:#ea960f;
    }
    .card-es{
        text-align: left;
        vertical-align: middle;
    }
    .card-en{
        text-align: left ;
        vertical-align: middle;
    }
    #Terms{
        color:#ea960f;
    }
    .crear-cuenta{
        margin: 5px 10px;
    }
    .entrar-cuenta{
        background-color: #lightgrey;
    }
</style>
@endsection
<div class="container">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <form method="POST" action="{{ URL::to('/rooms/reserve') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
        <div class="col-xs-12 text-center">
            <div class="room-inside-text">
                <p>Solicitud de Reserva:</p>
                <h2>Hab - {{ $room->number }}  | {{ $room->house->name }}</h2>
                <input id="room_id" name="room_id" type="hidden" value="{{ $room->id }}">
                <input id="room_num" name="room_num" type="hidden" value="{{ $room->number }}">
                <input id="house_name" name="house_name" type="hidden" value="{{ $room->house->name }}">
                <input id="room_price" name="room_price" type="hidden" value="{{ $room->price }}">
            </div>
        </div>
        <div class="row">
            <div class="col col-xs-12 vico-hero">
                <p><strong>Por favor lee toda la información que esta abajo antes de solicitar la reserva.</strong><br><br></p>
                <figure>
                    <img class="image-room" src="{{ $room->main_image }}" class="img-responsive" alt="Responsive image" style="width: 100%">
                    <figcaption class="room-info">
                        <h4>Hab. {{ $room->number }} | $ {{ $room->price }} COP.</h4>
                        <p>Disponible a partir del {{ date('d/m/Y', strtotime($room->available_from)) }}</p>
                        <a href="#" class="vico-gallery-button" data-toggle="modal" data-target=".room-{{ $room->id }}">Ver galería <span class="icon-gallery"></span></a>
                    </figcaption>
                </figure>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <h3>Acerca de esta habitación</h3>
                <p>{{ $room->description }}</p>
            </div>

            <div class="col-xs-12 col-sm-6">
                <h3>¿Quién administra esta casa?</h3>
                <figure class="administrator-picture">
                    <img class="img-responsive" src="{{ $room->house->manager_image }}" alt="">
                </figure>
                <div class="administrator-info">
                    <h4>{{ $room->house->manager_name }}</h4>
                    <p>{{ $room->house->manager_description }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <h3>Equipos</h3>
                <ul class="equipment-list">
                    @foreach($room->house->Devices as $device)
                        <li class="equipment">
                            <span class="{{ $device->icon }}"></span>
                            <p>{{ $device->name }}</p>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <h3>Normas de la casa</h3>
                <div class="table-responsive">
                    <table class="table">
                        @foreach($room->house->Rules as $rule)
                            <tr>
                                <td class="important-rule"><p class="rule-name">{{ $rule->name }}</p></td>
                                <td class="important-rule"><p>{{ $rule->description }}</p></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div id="accordion" role="tablist">
            <div class="card">
                <div class="card-header" role="tab" id="headingOne">
                    <h5 class="mb-0">
                    <a  data-toggle="collapse" href="#collapseOne" role="button" aria-expanded="true" aria-controls="collapseOne">Proceso:</a>
                    </h5>
                </div>
            </div>
            <div id="collapseOne" class="collapse in" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <p class="card-es">Nota: Antes de realizar la reserva tenemos que confirmar la disponibildad de la habitación con el dueño.
                    <br><br>
                    1. Solicitas la disponibilidad de la reserva con tu fecha de llegada.<br>2. El due&ntilde;o confirma la disponibilidad.<br>3. Si la habitaci&oacute;n queda disponible, puedes visitarla o puedes reservar en linea con el pago del dep&oacute;sito (una renta mensual = {{$room->price}} COP). Ese dinero recibe el due&ntilde;o y te lo devuelve al final de tu estancia.<br>4. Cuando lleg&oacute; tu dinero, recibes una confirmaci&oacute;n de reserva.<br>Falta solamente que llegues y la pases bien en tu nueva VICO.&nbsp; <br>
                    <br>
                    Las informaciones que facilitamos se basan en los datos de los dueños de las VICOs. Por la exactitud, acutalidad e integridad no podemos asumir ninguna garantía ni responsabilidad.
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="card-header" role="tab" id="headingTwo">
                    <h5 class="mb-0">
                        <a class="collapsed" data-toggle="collapse" href="#collapseTwo" role="button" aria-expanded="false" aria-controls="collapseTwo"> >>Read explication in English.<< </a>
                    </h5>
                </div>
                <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                        <p class="card-en">
                        Note:
                        Before we can realize the reservation, we have to confirm with owner the availability of the room for the requested date.
                        <br><br>
                        1. You request the availability of a room with you arrival date.<br>2. The owner confirms the availability of the room.<br>3. If the room is available, you can go to see it or make an online reservatio by paying the deposit (one rent). The owner receives this money, which is refundable at the end of you stay.<br>4. When your money has arrived, you will receive a confirmation of reservation<br> Now, you just have to arrive and have a awesome stay in your new VICO!<br>
                        <br>
                        All information is without guarantee and based exclusively on information which was made available to us by the owner; we do not accept any responsibility for the correctness, completeness and up-to-dateness of this information.
                        </p>
                    </div>
                </div>
            </div>
            @guest
            @else
                  <div class="form-group col-xs-12 col-sm-offset-4 col-sm-4 text-center tiempo-estancia">
                                <label for="date" class="text-center" >Tiempo de estancia estimado</label>

           <input type="text" name="date2" id="date2" class="form-control" required>
        </div> 
            <div class="form-group col-xs-12 col-sm-offset-4 col-sm-4 text-center">
                <div class="form-group">
                    <label for="comment">Contacta a {{ $room->house->manager_name }}<br><span style="font-weight: 200">Cuentale: ¿Quién eres? ¿Qué haces en Medellín? ¿Por qué te gusta esa VICO?</span></label>
                    <textarea class="form-control" rows="1" name="question" style=""></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 text-center">
                    <input type="checkbox" id="Terms" name="terms" value="terms" required>
                    <label for="terms">He leido y entendido los <a href="http://friendsofmedellin.com/terminosycondiciones/" target="_blank" style="color:#ea960f">terminos y condiciones</a>. - I read and understood the <a href="http://friendsofmedellin.com/en/terminosycondiciones/" target="_blank">terms and conditions</a>. </label>
                </div>
            </div>

             <div class="col-xs-12 text-center reservar">           
                <button type="submit" class="btn btn-default">Solicitar reserva</button>
            </div>
        </div>
        @endguest
        <div class="modal fade room-{{ $room->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <a type="button" class="close modal-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="icon-close"></span></a>
                    @foreach($room->Images as $image)
                        <figure>
                            <img src="{{ $image->path }}" class="img-responsive" alt="Responsive image">
                        </figure>
                    @endforeach
                    <div class="text-center modal-back-container">
                        <a class="btn btn-default" role="button" data-dismiss="modal" aria-label="Close"><span class="icon-prev-fom modal-back"></span> Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @guest
    <div class="col-xs-12 col-md-6 text-center reservar">           
        <a class="btn btn-primary crear-cuenta" role="button" href="/register" aria-expanded="false">Crear una cuenta</a>      
        <a class="btn btn-primary entrar-cuenta" role="button" href="/login" aria-expanded="false">Entra con tu cuenta</a>
    </div>
    @else
    @endguest
    
</div>
<!-- Include Required Prerequisites -->
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<!-- Include Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<script type="text/javascript">$('input[name="date2"]').daterangepicker({
    "startDate": "{{ date('d/m/Y', strtotime($room->available_from)) }}",
    "endDate": "{{ date('d/m/Y', strtotime($room->available_from)) }}",
    "minDate": "{{ date('d/m/Y', strtotime($room->available_from)) }}",
    "locale": {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "applyLabel": "Apply",
        "cancelLabel": "Cancel",
        "fromLabel": "From",
        "toLabel": "To",
        "customRangeLabel": "Custom",
        "weekLabel": "W",
        "daysOfWeek": [
            "Su",
            "Mo",
            "Tu",
            "We",
            "Th",
            "Fr",
            "Sa"
        ],
        "monthNames": [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ],
        "firstDay": 1
    },
        "autoApply": true
});
</script>
@endsection