@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
    
    <div class="container-fluid row">
        <img class="img-fluid mx-auto my-2 h-100 p-4" 
            style="width: 300px" 
            src="{{asset('images/vico_logo_transition/VICO_VIVIR_orange.png')}}"
            alt="Responsive image">
    </div>
    <div class="container mt-4 mb-4">
        @if(Session::get('msg'))
    
            <div class="alert-success">
                {{ Session::get('msg') }}
            </div>
    
        @endif
    
        <div class="info">
    
            <h2 class="vico-color"> 
                <b>¡Genial, este es el último paso!</b> 
            </h2>
            <h3 class="">
                Reserva de la Hab. {{ $room->number }} en la {{ $house->name }}
            </h3>
    
            <hr>
    
            <div class="paragraph">
    
                <div class="text-secondary">
                    Primera renta mensual para reservar la habitación
                    <br>
                </div>
    
                <div class="values text-secondary">
                    {{ $room->price }} COP
                </div>
    
                <div class="text-secondary">
                    Costo de transacción internacional + 3%
                </div>
    
                <div class="values text-secondary">
                    {{ ($room->price / 100) * 3 }} COP
                </div>
    
                <div class="text-secondary">
                    Pago único por servicio VICO + 5%
                </div>
    
                <div class="values text-secondary">
                    {{ ($room->price / 100) * 5 }} COP
                </div>
    
            </div>
    
            <hr>
    
            <div class="total">
    
                <h4 class="vico-color">
                    <b>
                        Total {{
                                    $room->price
                                + (($room->price / 100) * 5)
                                + (($room->price / 100) * 3)
                                }} COP
                    </b>
                </h4>
    
                <b><div id="totalUSD" class="text-secondary font-weight-light">$ {{ $priceUSD }}</div></b>
                <b><div id="totalEUR" class="text-secondary font-weight-light">&euro; {{ $priceEUR }}</div></b>
            </div>
    
            <hr>
    
        </div>
    
        <div class="form">

            {{-- <form action="/payments/pay" method="post" id="payment-form-card"> --}}
            <form action="{{ route('post_card_payment')}}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="ctrl_finalPrice" value="{{ $priceUSD * 100 }}">
                <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="{{ config('services.stripe.key') }}"
                    data-amount="{{ $priceUSD * 100 }}"
                    data-name="Renta VICO"
                    data-description="{{ __('Habitación #'.$room->number) }}"
                    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                    data-locale="EUR">
                </script>
                
    
                <label class="text-secondary d-none" for="">Quiere usar los datos de la cuenta?</label>
        
                <div class="custom-control custom-radio d-none">
                    <input checked type="radio" class="custom-control-input" id="use_data_yes" name="use_data">
                    <label class="custom-control-label" for="use_data_yes">Si</label>
                </div>
        
                <div class="custom-control custom-radio d-none">
                    <input type="radio" class="custom-control-input" id="use_data_No" name="use_data">
                    <label class="custom-control-label" for="use_data_No">No</label>
                </div>
        
                <hr>
        
                <div class="form-group">
        
                    <label class="text-secondary" for="">Nombre completo como en la tarjeta*</label>
        
                    <input type="text" vico="name" id="ctrl_name" name="ctrl_name" class="form-control vico-payment-control" value="">
        
                </div>
        
                <div class="form-group">
        
                    <label class="text-secondary" for="">Número de cedula o pasaporte</label>
        
                    <div class="input-group mb-3">
        
                        <div class="input-group-prepend">
        
                            <button class="btn btn-outline-secondary dropdown-toggle btn_document_type" type="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                Pasaporte
                            </button>
        
                            <div class="dropdown-menu">
                                <a class="dropdown-item" onclick="document_type_onclick(1)">Pasaporte</a>
                                <a class="dropdown-item" onclick="document_type_onclick(2)">Cedula</a>
                            </div>
        
                        </div>
        
                        <input type="text" class="form-control vico-payment-control" aria-label="" vico="document" id="ctrl_document" name="ctrl_document">
        
                    </div>
        
                </div>
        
                <div class="form-group">
        
                    <label class="text-secondary" for="">Dirección</label>
        
                    <input type="text" vico="address" id="ctrl_address" name="ctrl_address" class="form-control vico-payment-control">
        
                </div>
        
                <div class="form-row">
        
                    <div class="form-group col-md-4">
        
                        <label class="text-secondary" for="">Codigo Postal</label>
        
                        <input type="text" vico="postal" id="ctrl_postal" name="ctrl_postal" class="form-control">
        
                    </div>
        
                    <div class="form-group col-md-8">
        
                        <label class="text-secondary" for="">Ciudad</label>
        
                        <input type="text" vico="city" id="ctrl_city" name="ctrl_city" class="form-control">
        
                    </div>
        
                </div>
        
                <div class="form-group">
        
                    <label class="text-secondary" for="">País</label>
        
                    <input type="text" vico="country" id="ctrl_country" name="ctrl_country" class="form-control">
        
                </div>

                <input type="hidden" id="use_data_card" name="use_data_card">
                <input type="hidden" id="name_card" name="name_card">
                <input type="hidden" id="document_card" name="document_card">
                <input type="hidden" id="document_type_card" name="document_type_card">
                <input type="hidden" id="address_card" name="address_card">
                <input type="hidden" id="postal_code_card" name="postal_code_card">
                <input type="hidden" id="city_card" name="city_card">
                <input type="hidden" id="country_card" name="country_card">
    
                <input type="hidden" id="booking_id_card" name="booking_id_card" value="{{ $booking->id }}">
                <input type="hidden" id="usd_card" name="usd_card" class="usd">
                <input type="hidden" id="eur_card" name="eur_card" class="eur">
    
                {{-- <div class="form-group" id="paymentCard">
    
                    <label class="text-secondary" for="card-element">
                        Tarjeta de crédito
                    </label>
    
                    <div id="card-element">
    
                    </div>
    
                    <div class="card-errors" role="alert"></div>
    
                </div>
    
                <button type="submit" class="btn btn-primary">Pagar</button> --}}
    
            </form>
    
            {{-- <form action="/payments/sepa" method="post" id="payment-form-sepa">
    
                {{ csrf_field() }}
    
                <input type="hidden" id="use_data_sepa" name="use_data_sepa">
                <input type="hidden" id="name_sepa" name="name_sepa">
                <input type="hidden" id="document_sepa" name="document_sepa">
                <input type="hidden" id="document_type_sepa" name="document_type_sepa">
                <input type="hidden" id="address_sepa" name="address_sepa">
                <input type="hidden" id="postal_code_sepa" name="postal_code_sepa">
                <input type="hidden" id="city_sepa" name="city_sepa">
                <input type="hidden" id="country_sepa" name="country_sepa">
                <input type="hidden" id="booking_id_sepa" name="booking_id_sepa" value="{{ $booking->id }}">
                <input type="hidden" id="usd_sepa" name="usd_sepa">
                <input type="hidden" id="eur_sepa" name="eur_sepa">
    
                <div class="form-group" id="paymentSepa">
    
                    <label for="iban-element" class="text-secondary">IBAN</label>
    
                    <!-- <input type="text" name="iban_element"> -->
    
                    <div id="iban-element" name="iban_element"></div>
    
                    <div class="sepa-errors text-secondary" role="alert"></div>
    
                    <div class="bank-name text-secondary" role="alert"></div>
    
                    <!-- <div id="mandate-acceptance">
                        By providing your IBAN and confirming this payment, you are
                        authorizing Rocketship Inc. and Stripe, our payment service
                        provider, to send instructions to your bank to debit your account and
                        your bank to debit your account in accordance with those instructions.
                        You are entitled to a refund from your bank under the terms and
                        conditions of your agreement with your bank. A refund must be claimed
                        within 8 weeks starting from the date on which your account was debited.
                    </div> -->
    
                </div>
    
                <button type="submit" class="btn btn-primary">Pagar</button>
    
            </form>
    
            <form action="/payments/paypal" method="post" id="payment-form-paypal">
    
                {{ csrf_field() }}
    
                <input type="hidden" id="use_data_paypal" name="use_data_paypal">
                <input type="hidden" id="name_paypal" name="name_paypal">
                <input type="hidden" id="document_paypal" name="document_paypal">
                <input type="hidden" id="document_type_paypal" name="document_type_paypal">
                <input type="hidden" id="address_paypal" name="address_paypal">
                <input type="hidden" id="postal_code_paypal" name="postal_code_paypal">
                <input type="hidden" id="city_paypal" name="city_paypal">
                <input type="hidden" id="country_paypal" name="country_paypal">
                <input type="hidden" id="booking_id_paypal" name="booking_id_paypal" value="{{ $booking->id }}">
                <input type="hidden" id="usd_paypal" name="usd_paypal">
                <input type="hidden" id="eur_paypal" name="eur_paypal">
    
                <div class="form-group" id="paymentPaypal">
                    <label class="text-secondary" style="height: 65px">Paypal</label>
                    <div class="paypal-errors" role="alert"></div>
                </div>
                <button type="submit" class="btn btn-primary">Pagar</button>
            </form>
            <hr>
            <div class="custom-control custom-radio">
                <input onchange="onChangeRadioPayment(1)" type="radio" class="custom-control-input" id="paymentMethodCreditCard" name="paymentMethod">
                <label class="custom-control-label" for="paymentMethodCreditCard"> <b>Credit Card</b> +3% transfer fee</label>
            </div>
            <div class="custom-control custom-radio">
                <input onchange="onChangeRadioPayment(2)" type="radio" class="custom-control-input" id="paymentMethodSepa" name="paymentMethod">
                <label class="custom-control-label" for="paymentMethodSepa"> <b>SEPA / European bank transfer</b> +1% transfer fee</label>
            </div>
            <div class="custom-control custom-radio">
                <input onchange="onChangeRadioPayment(3)" type="radio" class="custom-control-input" id="paymentMethodPaypal" name="paymentMethod">
                <label class="custom-control-label" for="paymentMethodPaypal"> <b>Paypal</b> +3% transfer fee</label>
            </div> --}}
        </div>
    </div>
@endsection

@section('scripts')

    <script type="text/javascript">
        function onChangeRadioPayment(paymentMethod) {

            if(paymentMethod == 1) {
                document.getElementById('payment-form-card').style.display = 'block';
                document.getElementById('payment-form-sepa').style.display = 'none';
                document.getElementById('payment-form-paypal').style.display = 'none';
            }
            else if(paymentMethod == 2){
                document.getElementById('payment-form-card').style.display = 'none';
                document.getElementById('payment-form-sepa').style.display = 'block';
                document.getElementById('payment-form-paypal').style.display = 'none';
            }
            else if(paymentMethod == 3){
                document.getElementById('payment-form-card').style.display = 'none';
                document.getElementById('payment-form-sepa').style.display = 'none';
                document.getElementById('payment-form-paypal').style.display = 'block';
            }

        }
    </script>
@endsection