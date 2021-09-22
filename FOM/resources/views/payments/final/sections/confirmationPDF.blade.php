<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link href="{{ public_path('\css\app.css?version=5') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Confirmation</title>
</head>
<body>
        <style>
            .confirmation {
                display: grid;
                width: 100%;
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
                padding: 5% 2%;
            }
            .vico-color {
                color: #ea960f;
            }
            .icon-payments {
                width: 60px
            }
            .logo-vico {
                max-width: 100%;     
                text-align: center;           
            }
            .logo{
                width: 50%;
                height: 50%;
                margin-bottom: 20px
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
                    margin: 0;
                }
                .info {
                    margin: 0;
                    padding-right: 3%;
                }
                .logo-vico {
                    max-width: 100%;
                    text-align: center;
                }

                .icon-payments {
                    width: 40px
                }
            }
        </style>
        <div class="confirmation">
                {{--  <div class="left">
                    <div class="info">
                        <ul>
                            <li class="media">
                                <div class="media-body">
                                    <p class="h1 font-weight-bold text-center">{{__('Confirmación de pago')}}</p>
                                </div>
                            </li>
                            <li class="media my-4">
                                <img class="mr-3 icon-payments" src="{{public_path('images/payments/cohete-blanco.png')}}" alt="">
                                <div class="media-body">
                                    <h4 class="font-weight-light">Reserva de</h4>
                                    <h4> <b> Hab. {{ $data['room']->number }}</b> </h4>
                                    <h4> <b>{{ $data['house']->name }}</b> </h4>
                                </div>
                            </li>
                            <li class="media my-4">
                                <img class="mr-3 icon-payments" src="{{public_path('images/payments/cohete-blanco.png')}}" alt="">
                                <div class="media-body">
                                    <h4 class="font-weight-light">Suma total</h4>
                                    <h4> <b>{{ round($data['payment']->amountCop, 0) }} COP</b> </h4>
                                </div>
                            </li>
                            <li class="media my-4">
                                <img class="mr-3 icon-payments" src="{{public_path('images/payments/cohete-blanco.png')}}" alt="">
                                <div class="media-body">
                                    <h4 class="font-weight-light">Fecha</h4>
                                    <h4> <b>{{ $data['payment_date'] }}</b> </h4>
                                </div>
                            </li>
                            <li class="media my-4">
                                <img class="mr-3 icon-payments" src="{{public_path('images/payments/cohete-blanco.png')}}" alt="">
                                <div class="media-body">
                                    <h4 class="font-weight-light">Número de confirmación</h4>
                                    <h4 style="word-break: break-all;"> <b>{{ $data['payment']->charge_id }}</b> </h4>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>  --}}
                
                @if($data['payment']->import==="Deposit")                
                  
                    <div class="right">
                            <div class="logo-vico">
                                <img class="logo" src="{{public_path('images/vico_logo_transition/VICO_VIVIR_orange.png')}}" alt="Vico logo">
                            </div>
                            <div class="text-secondary mb-2">
                                    <p>
                                        {{--  ¡Hola {{ $data['user']->name . ' ' . $data['user']->last_name }}!  --}}
                                        ¡{{trans('payments.hello')}} {{ $data['user']->name}}!
                                    </p>
                                    <p>
                                        {{trans('payments.we_received')}} <strong>{{ round($data['payment']->amountCop * $data['currency']->value, 2) }} {{$data['currency']->code}}</strong>, {{trans('payments.for_the_reservation')}} <strong> {{trans('payments.room')}} {{ $data['room']->number }} {{trans('payments.of_the')}} {{ $data['house']->name }}</strong>. {{trans('payments.all_ready')}} <strong>{{ $data['booking']->date_from }}.</strong>
                                    </p>
                                    <p>
                                       {{--  No te olvides de contactar a {{ $data['manager']->name . ' ' . $data['manager']->last_name }}, el responsable de la VICO para que organicen tu llegada y la entrega de llaves.  --}}
                                       {{trans('payments.dont_forget_to_contact')}} {{ $data['manager']->name }}, {{($data['manager']->gender === 1) ? 'el': 'la'}}
                                       {{trans('payments.responsible_for_the_vico')}}                                   
                                       <br> {{trans('payments.email')}}: {{ $data['manager']->email }}
                                       <br> {{trans('payments.whatsapp_phone')}}: {{ $data['manager']->phone }}
                                    </p>
                                    <p>
                                        <small>
                                            {{trans('payments.if_you_have_question')}}
                                            {{trans('payments.keep_in_mind')}}
                                        </small>
                                    </p>
                                </div>
                            <p class="text-secondary"><b>{{trans('payments.summary_of_order')}}</b></p>
                            <table class="table no-margin text-secondary">
                                <tbody>
                                    <tr>
                                        <td>
                                            {{trans('payments.item')}}
                                        </td>
                                        <td >                                                                                     
                                            
                                            {{__('Reserva de habitación '. $data['room']->number .', el '. $data['booking']->date_from)}}
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{trans('payments.house')}}
                                        </td>
                                        <td>
                                            {{__($data['house']->name)}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{trans('payments.owner')}}
                                        </td>
                                        <td>
                                            
                                                {{__($data['manager']->name . ' ' . $data['manager']->last_name)}}
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{trans('payments.total_value')}}
                                        </td>
                                        <td>
                                            
                                                {{__(round($data['payment']->amountCop * $data['currency']->value, 2)) . ' '.$data['currency']->code}}
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{trans('payments.payment_method')}}
                                        </td>
                                        <td>                                        
                                                {{ __('Tarjeta de crédito') }}
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{trans('payments.date_of_payment')}}
                                        </td>
                                        <td>
                                            
                                                {{$data['payment_date']}}
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                    </tr>
                                </tbody>
                            </table>
                    </div>
             
                @else
                   
                    <div class="right">
                            <div class="logo-vico">
                                <img class="logo" src="{{public_path('images/vico_logo_transition/VICO_VIVIR_orange.png')}}" alt="Vico logo">
                            </div>
                            <div class="text-secondary mb-2">
                                    <p>
                                        {{--  ¡Hola {{ $data['user']->name . ' ' . $data['user']->last_name }}!  --}}
                                        ¡Hola {{ $data['user']->name}}!
                                    </p>
                                    <p>
                                        {{trans('payments.we_received')}} <strong>{{ round($data['payment']->amountCop * $data['currency']->value, 2) }} {{$data['currency']->code}}</strong>, {{trans('payments.for_monthly_rent')}} <strong>{{trans('payments.room')}} {{ $data['room']->number }} {{trans('payments.of_the')}} {{ $data['house']->name }}</strong>.
                                    </p>
                                    <p>
                                        <small>
                                            {{trans('payments.if_you_have_question')}}
                                            {{trans('payments.keep_in_mind')}}
                                        </small>
                                    </p>
                                </div>
                            <p class="text-secondary"><b>{{trans('payments.payment_summary')}}</b></p>
                            <table class="table no-margin text-secondary">
                                <tbody>
                                    <tr>
                                        <td>
                                            {{trans('payments.item')}}
                                        </td>
                                        <td >                                                                                     
                                            
                                            {{__('Renta mensual de habitación '. $data['room']->number .', el '. $data['booking']->date_from)}}
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{trans('payments.house')}}
                                        </td>
                                        <td>
                                            
                                            {{__($data['house']->name)}}
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{trans('payments.owner')}}
                                        </td>
                                        <td>
                                            
                                                {{__($data['manager']->name . ' ' . $data['manager']->last_name)}}
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{trans('payments.total_value')}}
                                        </td>
                                        <td>
                                            
                                                {{__(round($data['payment']->amountCop * $data['currency']->value, 2)) . ' '.$data['currency']->code}}
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{trans('payments.payment_method')}}
                                        </td>
                                        <td>                                        
                                                {{ __('Tarjeta de crédito') }}
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{trans('payments.date_of_payment')}}
                                        </td>
                                        <td>
                                            
                                                {{$data['payment_date']}}
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                    
                @endif
            </div>
</body>
</html>
