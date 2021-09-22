@extends('layouts.app')

@section('title', 'Confirmacion')

@section('scripts')

@endsection
@section('content')

    <div class="confirmation">

        <div class="left">

            <div class="info">

                <ul>
                    <li class="media">
                    
                        <div class="media-body">
                            <p class="h1 font-weight-bold text-center">{{__('Confirmación de pago')}}</p>
                        </div>
                    
                    </li>
                    <li class="media my-4">

                        <img class="mr-3 icon-payments" src="../../images/payments/cohete-blanco.png" alt="">
                        
                        @if($payment->import === "Deposit")

                            <div class="media-body">
                                <h4 class="font-weight-light">{{trans('general.deposit_of')}}</h4>
                                <h4> <b> {{trans('general.room')}} {{ $room->number }}</b> </h4>
                                <h4> <b>{{ $house->name }}</b> </h4>
                            </div>

                        @else

                            <div class="media-body">
                                <h4 class="font-weight-light">{{trans('general.monthly_rent')}}</h4>
                                <h4> <b> {{trans('general.room')}} {{ $room->number }}</b> </h4>
                                <h4> <b>{{ $house->name }}</b> </h4>
                            </div>


                        @endif
                        
                    </li>

                    <li class="media my-4">

                        <img class="mr-3 icon-payments" src="../../images/payments/cohete-blanco.png" alt="">

                        <div class="media-body">
                            <h4 class="font-weight-light">{{trans('general.total_sum')}}</h4>
                            <h4> <b>{{ round($payment->amountCop * $currency->value, 2) }} {{$currency->code}}</b> </h4>
                        </div>

                    </li>

                    <li class="media my-4">

                        <img class="mr-3 icon-payments" src="../../images/payments/cohete-blanco.png" alt="">

                        <div class="media-body">
                            <h4 class="font-weight-light">{{trans('general.date')}}</h4>
                            <h4> <b>{{ $payment_date }}</b> </h4>
                        </div>

                    </li>

                    <li class="media my-4">

                        <img class="mr-3 icon-payments" src="../../images/payments/cohete-blanco.png" alt="">

                        <div class="media-body">
                            <h4 class="font-weight-light">{{trans('general.confirmation_number')}}</h4>
                            <h4 style="word-break: break-all;"> <b>{{ $payment->charge_id }}</b> </h4>
                            {{-- {{ $data['transaction_id'] }} --}}
                        </div>

                    </li>
                </ul>

            </div>

        </div>

        <div class="right">
            <img class="logo-vico " src="{{asset('images/vico_logo_transition/VICO_VIVIR_orange.png')}}" alt="Vico logo">
            @if($payment->import === "Deposit")

                <div class="text-secondary">

                    <p>
                        {{trans('general.hello_excited')}} {{ $user->name . ' ' . $user->last_name }}!
                    </p>
                    <p>
                        {{trans('general.we_received_payments')}} {{ round($payment->amountCop * $currency->value, 2) }} {{$currency->code}} {{trans('general.for_reservation_of_room')}} {{ $room->number }} {{trans('general.of_the')}} {{ $house->name }}. {{trans('general.everything_ready')}} {{ $booking->date_from }}
                    </p>
                    <p>
                        {{trans('general.dont_forget_contact')}} {{trans('general.the_owner_of_vico')}}
                       <br>
                       <br> Email: {{ $manager->email }}
                       <br> WhatsApp / Phone: {{ $manager->phone }}
                    </p>
                    <p>
                        <small>
                            {{trans('general.if_you_have_question')}}
                            {{trans('general.it_can_delay')}}
                        </small>
                    </p>

                </div>             

            @else

                <div class="text-secondary">

                    <p>
                        {{trans('general.hello_excited')}} {{ $user->name . ' ' . $user->last_name }}!
                    </p>
                    <p>
                        {{trans('general.we_received_payments')}} {{ round($payment->amountCop * $currency->value, 2) }} {{$currency->code}} {{trans('general.for_reservation_of_room')}} {{ $room->number }} {{trans('general.of_the')}} {{ $house->name }}. 
                    </p>
                    <p>
                        <small>
                        {{trans('general.if_you_have_question')}}
                        {{trans('general.it_can_delay')}}
                        </small>
                    </p>

                </div>

            @endif
            <a href="{{ route('payments_admin', $booking->id) }}" class="btn btn-primary my-1">{{trans('general.return_to_pagos')}}</a>

            <a href="{{ route('download_payment_pdf', $payment->id) }}" class="btn btn-primary my-1">{{trans('general.download_pdf')}}</a>
            <!-- <a class="btn btn-primary-close">Cerrar página</a> -->

        </div>

    </div>

    <script type="text/javascript">
    fbq('track', 'Purchase', {value: '{{ round($payment->amountCop * $currency->value, 2) }}', currency: '{{$currency->code}}', house: '{{ $house->name }}', room: '{{ $room->number }}', booking: '{{$booking->id}}', type: '{{$payment->import}}'  });
    </script>

@endsection
