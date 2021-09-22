@extends('layouts.app')

@section('title', 'Administra tus pagos')



@section('styles')
    <style>
        @media (max-width: 425px) {
            .no-margin{
                margin: 0;
                padding: 0;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="mt-3 col-sm-12 col-md-8 col-lg-8 offset-md-2 offset-lg-2">
            <p class="h1 font-weight-bold mt-5">{{trans('general.manager_ur_payments')}}</p>
            <!-- rounded box -->
            <div class="borderme">
                <div class="row">
                    <div class="col-2 text-center m-0 p-0">
                        <img class="w-75 m-0 p-0" src="{{ asset('images/payments/icon-jan-2.png')}}">
                    </div>
                    <div class="col-10 m-0 p-0">
                        @if($nextBill)
                            @if($late)
                                @if ($days == 0)
                                    <p class="h5 text-primary py-0 my-0">{{__('¡Tu pago es hoy!') }}</p>                                    
                                @else
                                    <p class="h5 text-danger py-0 my-0">{{__('¡Te pasaste por ' . $days . ' días!') }}</p>
                                @endif
                            @elseif($nextBill['from'] === $date_now)
                                <p class="h5 text-primary py-0 my-0">{{__('¡Tu pago es hoy!') }}</p>
                            @else
                                <p class="h5 text-success py-0 my-0">{{__('Te quedan ' . $days . ' días!') }}</p>
                            @endif
                            @if(sizeof($depositPayment) == 0)
                                <p class="h3 font-weight-bold py-0 my-0">{{__('Realizar el pago de tu Deposito')}}</p>                                
                            @else
                                <p class="h3 font-weight-bold py-0 my-0">{{__('Realizar el pago de tu renta del '. $nextBill['from'])}}</p>   
                                <p class="h5 small text-secondary font-weight-light py-0 my-0">{{__('(La fecha límite para pagar esta renta es ' . $dateLimit) . ')'}}</p>
                            @endif
                            @if(sizeof($depositPayment) == 0)
                                <a href="{{__('/payments/deposit/'.$booking->id)}}" class="btn btn-primary btn-block hover-opc mt-2">{{__('Realizar pago del deposito ahora')}}</a>
                            @else
                                <a href="{{__('/payments/user/' . $booking->id)}}" class="btn btn-primary btn-block hover-opc mt-2">{{__('Realizar pago ahora')}}</a>
                            @endif
                        @else
                            {{trans('general.no_pending_payments')}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="mt-3 col-sm-8 col-md-8 col-lg-8 offset-md-2 offset-lg-2">
                <!-- rounded box -->
                <div class="borderme">
                    <div class="row py-2">
                        <div class="col-12">
                            <p class="h4 font-weight-bold py-0 my-0">{{__('Actualizar la información de tu cuenta')}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2 text-center m-0 p-0">
                            <img style="height: 32px; width: 32px" class=" m-0 p-0" src="{{asset('images/rules/minimum-stay.png')}}" alt="independent" srcset="{{asset('images/rules/minimum-stay@2x.png')}} 2x, {{asset('images/rules/minimum-stay@3x.png')}} 3x">
                        </div>
                        <div class="col-10 m-0 p-0">
                            <p class="">
                                <a href="{{ route('bookingdate.getUser', $booking->id) }}">{{__('Actualizar tu fecha de salida (' . $bookingTo   . ')')}}</a>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2 text-center m-0 p-0">
                            <img style="height: 32px; width: 32px" class=" m-0 p-0" src="{{asset('images/process/modal/creditcard.png')}}" alt="independent" srcset="{{asset('images/process/modal/creditcard@2x.png')}} 2x, {{asset('images/process/modal/creditcard@3x.png')}} 3x">
                        </div>
                        <div class="col-10 m-0 p-0">
                            <p class="">
                                <a href="{{ route('payments_change', $booking->id) }}">{{__('Actualizar tu método de pago')}}</a>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2 text-center m-0 p-0">
                             <img style="height: 32px; width: 32px" class=" m-0 p-0" src="{{asset('images/process/warning.png')}}" alt="independent" srcset="{{asset('images/process/warning@2x.png')}} 2x, {{asset('images/process/warning@3x.png')}} 3x" />
                        </div>
                        <div class="col-10 m-0 p-0">
                            <p class="">
                                <a href="">{{__('Reportar un problema con un pago')}}</a>
                            </p>
                        </div>
                    </div>
                    @if(isset($booking->deposit))
                    <div class="row">
                        <div class="col-2 text-center m-0 p-0">
                            <img style="height: 32px; width: 32px" class=" m-0 p-0" src="{{asset('images/rules/locker.png')}}" alt="independent" srcset="{{asset('images/rules/locker@2x.png')}} 2x, {{asset('images/rules/locker@3x.png')}} 3x">
                        </div>
                        <div class="col-10 m-0 p-0">
                                <p href="">{{__('Tu deposito en VICO es de '. $booking->deposit * $currency->value .' '. $currency->code)}}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div id="react-payments" data-connection={{__($user->id)}}></div>
    </div>
@endsection
@section('scripts')
@include('layouts.sections._intercom')
@endsection
