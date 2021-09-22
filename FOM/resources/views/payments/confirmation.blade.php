@extends('layouts.app')

@section('title', 'Confirmación de pago')

@section('styles')

    <style type="text/css">

        .confirmation {
            display: grid;
            width: 100%;
            height: 100vh;
            grid-template: 1fr / 1fr 1fr;
            grid-template-areas: "left right";
        }

        .left {
            color: white;
            grid-area: left;
            background: #ea960f;
            text-align: center;
        }

        .info {
            margin: 40px;
            padding: 15% 0;
        }

        .right {
            grid-area: right;
            padding: 15%;

        }

        .vico-color {
            color: #ea960f;
        }

        .icon-payments {
            width: 60px
        }

        .logo-vico {
            margin-bottom: 50px;
        }

        .media-body {
            text-align: left;
        }

        .btn-primary-close {
            border: 1px solid;
            color: #ea960f;
        }

        @media (max-width: 768px) {

            .confirmation {
                display: block;
            }

            .left {
                border-right: 0;
                margin: 0 ;
            }

            .info {
                margin: 0 ;
                padding-right: 3%;
            }

            .logo-vico {
                max-width: 100%;
            }

            .icon-payments {
                width: 40px
            }
        }

    </style>

@endsection

@section('content')
    <div class="confirmation">

        <div class="left">

            <div class="info">

                <ul>

                    <li class="media my-4">

                        <img class="mr-3 icon-payments" src="../../images/payments/cohete-blanco.png" alt="">

                        <div class="media-body">
                            <h4 class="font-weight-light">Reserva de</h4>
                            <h4> <b> Hab. {{ $data['room'] }}</b> </h4>
                            <h4> <b>{{ $data['vico'] }}</b> </h4>
                        </div>

                    </li>

                    <li class="media my-4">

                        <img class="mr-3 icon-payments" src="../../images/payments/cohete-blanco.png" alt="">

                        <div class="media-body">
                            <h4 class="font-weight-light">Suma total</h4>
                            <h4> <b>{{ $data['total'] }} COP</b> </h4>
                        </div>

                    </li>

                    <li class="media my-4">

                        <img class="mr-3 icon-payments" src="../../images/payments/cohete-blanco.png" alt="">

                        <div class="media-body">
                            <h4 class="font-weight-light">Fecha</h4>
                            <h4> <b>{{ $data['date'] }}</b> </h4>
                        </div>

                    </li>

                    <li class="media my-4">

                        <img class="mr-3 icon-payments" src="../../images/payments/cohete-blanco.png" alt="">

                        <div class="media-body">
                            <h4 class="font-weight-light">Número de confirmación</h4>
                            <h4 style="word-break: break-all;"> <b>{{ $data['confirmation_number'] }}</b> </h4>
                            {{-- {{ $data['transaction_id'] }} --}}
                        </div>

                    </li>

                </ul>

            </div>

        </div>

        <div class="right">
             <img class="logo-vico " src="{{asset('images/vico_logo_transition/VICO_VIVIR_orange.png')}}" alt="">
            <div class="text-secondary">

                <p>
                    ¡Hola {{ $data['name'] }}!
                </p>
                <p>
                    Recibimos tu pago de {{ $data['total'] }} COP para la reserva de la habitación {{ $data['room'] }} de la {{ $data['vico'] }}. Ya queda todo listo para tu llegada el {{ $data['date'] }}
                </p>
                <p>
                   No te olvides de contactar a {{ $data['manager_name'] }} {{ $data['manager_lastname'] }}, el dueño de la VICO para que organicen tu llegada y la entrega de llaves.
                   <br>
                   <br> Email: {{ $data['manager_email'] }}
                   <br> WhatsApp / Phone: {{ $data['manager_phone'] }}
                </p>
                <p>
                    <small>
                    Si tienes alguna pregunta o duda nos pudes escribir a hello@getvico.com.
                    Se puede tardar unos momentos hasta que la transacción aparezca en tu cuenta.
                    </small>
                </p>

            </div>

            <a href="/booking/user/{{ $data['booking_id'] }}" class="btn btn-primary">Volver a la solicitud</a>

            <!-- <a class="btn btn-primary-close">Cerrar página</a> -->

        </div>

    </div>
@endsection
