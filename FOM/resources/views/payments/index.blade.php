@extends('layouts.app')
@section('title', 'Proceso de pago') 
@section('content')
{{-- @if($data['booking_status'] == 4 && Auth::user()->id === $data['user_id'] || Auth::user()->role_id === 1) --}}
@if(true)
@section('styles')

    <style type="text/css">
        input, .StripeElement {
            height: 40px;
            padding: 10px 12px;
            color: #32325d;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }
        input:focus, .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }
        .StripeElement--invalid {
            border-color: #fa755a;
        }
        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
        .card-errors {
            color: #fefde5;
        }
        .container {
            display: grid;
            width: 100vw;
            height: 100vh;
            grid-template: auto 70% / 1fr 1fr;
            grid-template-areas: "info form";
        }
        .info {
            grid-area: info;
            padding: 0 50px 0 0;
            border-right: 1px solid #6c757d;
        }
        .total {
            text-align: right;
        }
        .form {
            grid-area: form;
            padding: 0 0 0 50px;
        }
        .vico-color {
            color: #ea960f;
        }
        .paragraph {
            display: grid;
            grid-template: auto auto auto / 60% 40%;
            padding: 5px;
            font-weight: 300;
        }
        .values {
            text-align: right;
            padding-bottom: 20px;
        }
        .btn_document_type {
            width: 100px;
        }
        @media (max-width: 768px) {
            .container {
                grid-template: 0% auto auto / 1fr;
                grid-template-areas:    
                    "head",
                    "info",
                    "form";
            }
            .info {
                border-right: 0;
                padding: 0;
            }
            .form {
                padding: 0;
            }
            .paragraph {
                padding: 0;
            }
        }
    </style>

@endsection

@section('scripts')

    <script src="//js.stripe.com/v3/"></script>

    <script type="text/javascript">

        // var COP_USD,COP_EUR, _{{ $data['name'] }} = '{{ $data['name'] }}';

        $(function()  {

            let inputs_use_data = document.querySelectorAll('input[name=use_data]');
            for (let i = 0; i < inputs_use_data.length; i++) {
                inputs_use_data[i].addEventListener('change', function(event) {
                    document.getElementById('use_data_card').value = (this.id == 'use_data_yes');
                    document.getElementById('use_data_sepa').value = (this.id == 'use_data_yes');
                    document.getElementById('use_data_paypal').value = (this.id == 'use_data_yes');
                    // if (this.id == 'use_data_yes') document.getElementById(`ctrl_name`).value = _{{ $data['name'] }};
                    if (this.id == 'use_data_yes') document.getElementById(`ctrl_name`).value = '';
                    else document.getElementById(`ctrl_name`).value = '';
                });
            }
            let vico_controls = document.querySelectorAll('.vico-payment-control');
            for (let i = 0; i < vico_controls.length; i++) {
                vico_controls[i].addEventListener('change', function(event) {
                    document.getElementById(`${this.attributes['vico'].value}_card`).value = this.value;
                    document.getElementById(`${this.attributes['vico'].value}_sepa`).value = this.value;
                    document.getElementById(`${this.attributes['vico'].value}_paypal`).value = this.value;
                });
            }
            document.getElementById('payment-form-card').style.display = 'none';
            document.getElementById('payment-form-sepa').style.display = 'none';
            document.getElementById('payment-form-paypal').style.display = 'none';
            document.getElementsByClassName('documentType').value = 'pasaporte';

        });
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
        function document_type_onclick(documentType) {
            if (documentType == 1) {
                document.getElementById(`document_type_card`).value = 'pasaporte';
                document.getElementById(`document_type_sepa`).value = 'pasaporte';
                document.getElementById(`document_type_paypal`).value = 'pasaporte';
                document.querySelector(`.btn_document_type`).innerHTML = 'Pasaporte';
            }
            else if (documentType == 2) {
                document.getElementById(`document_type_card`).value = 'cedula';
                document.getElementById(`document_type_sepa`).value = 'cedula';
                document.getElementById(`document_type_paypal`).value = 'cedula';
                document.querySelector(`.btn_document_type`).innerHTML = 'Cedula';
            }
        }
        var stripe = Stripe('{{ config('services.stripe.key') }}');
    </script>

    <script type="text/javascript" >
        var elementsCard = stripe.elements();
        var styleCard = {
            base: {
                color: '#32325d',
                lineHeight: '18px',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };
        var card = elementsCard.create('card', {style: styleCard});
        card.mount('#card-element');
        card.addEventListener('change', function(event) {
            var displayError = document.getElementsByClassName('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            }
            else {
                displayError.textContent = '';
            }
        });
        var form = document.getElementById('payment-form-card');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    var errorElement = document.getElementsByClassName('card-errors');
                    errorElement.textContent = result.error.message;
                }
                else {
                    stripeTokenHandler(result.token);
                }
            });
        });
        var options = {
            name: $('#name_card').val(),
            address_line1: $('#address_card').val(),
            address_city: $('#city_card').val(),
            address_country: $('#country_card').val()
        }
        function stripeTokenHandler(token, options) {
            var form = document.getElementById('payment-form-card');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        }
    </script>

    <script type="text/javascript">
        // CAMBIAR DE TRES FORMS A UNO
        // MIRAR PORQUE LA CUENTA NO DEJA CREAR SOURCE
        // adjuntar la fuente al cliente
        // luego de esto puede crear crear el cargo
        var stripeSepa = Stripe('{{ config('services.stripe.key') }}');
        var stripeSepa = Stripe('pk_test_6pRNASCoBOKtIshFeQd4XMUh');
        var elementsSepa = stripeSepa.elements();
        var styleSepa = {
            base: {
                color: '#32325d',
                fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                },
                ':-webkit-autofill': {
                    color: '#32325d',
                },
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a',
                ':-webkit-autofill': {
                    color: '#fa755a',
                },
            }
        };
        var iban = elementsSepa.create('iban', {
            style: styleSepa,
            supportedCountries: ['SEPA'],
        });
        iban.mount('#iban-element');
        //
        // var errorMessage = document.getElementById('error-message');
        // var bankName = document.getElementById('bank-name');
        //
        // iban.on('change', function(event) {
        //
        //     // Handle real-time validation errors from the iban Element.
        //     if (event.error) {
        //         errorMessage.textContent = event.error.message;
        //         errorMessage.classList.add('visible');
        //     }
        //     else {
        //         errorMessage.classList.remove('visible');
        //     }
        //
        //     // Display bank name corresponding to IBAN, if available.
        //     if (event.bankName) {
        //         bankName.textContent = event.bankName;
        //         bankName.classList.add('visible');
        //     }
        //     else {
        //         bankName.classList.remove('visible');
        //     }
        // });
        //
        // Handle form submission.
        // var form = document.getElementById('payment-form-sepa');
        //
        // form.addEventListener('submit', function(event) {
        //
        //     event.preventDefault();
        //
        //     var sourceData = {
        //         type: 'sepa_debit',
        //         currency: 'eur',
        //         owner: {
        //             name: document.querySelector('input[name="name_sepa"]').value,
        //             email: 'gabalfa@gmail.com',
        //         },
        //         mandate: {
        //             // Automatically send a mandate notification email to your customer
        //             // once the source is charged.
        //             notification_method: 'email',
        //         }
        //     };
        //
        //     // Call `stripe.createSource` with the iban Element and additional options.
        //     stripeSepa.createSource(iban, sourceData).then(function(result) {
        //
        //         if (result.error) {
        //             // Inform the customer that there was an error.
        //             // errorMessage.textContent = result.error.message;
        //             // errorMessage.classList.add('visible');
        //             // stopLoading();
        //         }
        //         else {
        //             // Send the Source to your server to create a charge.
        //             // errorMessage.classList.remove('visible');
        //             stripeSourceHandler(result.source, iban);
        //         }
        //
        //     });
        //
        // });
        //
        // function stripeSourceHandler(token, options) {
        //
        //     var form = document.getElementById('payment-form-sepa');
        //     var hiddenInput = document.createElement('input');
        //     hiddenInput.setAttribute('type', 'hidden');
        //     hiddenInput.setAttribute('name', 'stripeToken');
        //     hiddenInput.setAttribute('value', token.id);
        //     form.appendChild(hiddenInput);
        //
        //     form.submit();
        // }
    </script>

@endsection

<div class="container-fluid row">
    <img class="img-fluid mx-auto my-2 h-100 p-4" style="width: 300px" src="{{asset('images/vico_logo_transition/VICO_VIVIR_orange.png')}}" alt="Responsive image">
</div>
<div class="container mt-4 mb-4">
    @if(Session::get('msg'))

        <div class="alert-success">
            {{ Session::get('msg') }}
        </div>

    @endif

    <div class="info">

        <h2 class="vico-color"> <b>¡Genial, este es el último paso!</b> </h2>
        <h3 class="">Reserva de la Hab. {{ $data['room_number'] }} en la {{ $data['vico'] }}</h3>

        <hr>

        <div class="paragraph">

            <div class="text-secondary" >
                Primera renta mensual para reservar la habitación
                <br>
            </div>

            <div class="values text-secondary">
                {{ $data['total'] }} COP
            </div>

            <div class="text-secondary" >
                Costo de transacción internacional + 3%
            </div>

            <div class="values text-secondary">
                {{ ($data['total'] / 100) * 3 }} COP
            </div>

            <div class="text-secondary" >
                Pago único por servicio VICO + 5%
            </div>

            <div class="values text-secondary">
                {{ ($data['total'] / 100) * 5 }} COP
            </div>    
                    
            @if($data['discountCOP'] > 0)
                <div class="text-secondary text-danger font-weight-bold" >
                    Descuento por recomendación
                </div>

                <div class="values text-secondary text-danger font-weight-bold">
                    - {{ $data['discountCOP'] }} COP
                </div>
            @endif

        </div>

        <hr>

        <div class="total">

            <h4 class="vico-color">
                <b>
                    Total {{
                                $data['total']
                            + (($data['total'] / 100) * 5)
                            + (($data['total'] / 100) * 3)
                            - $data['discountCOP']
                            }} COP
                </b>
            </h4>

            <b><div id="totalUSD" class="text-secondary font-weight-light">{{ ($data['priceUSD'] * 1.08) - $data['discountUSD'] }}</div></b>
            <b><div id="totalEUR" class="text-secondary font-weight-light">{{ ($data['priceEUR'] * 1.08) - $data['discountEUR'] }}</div></b>
        </div>

        <hr>

    </div>

    <div class="form">

        <label class="text-secondary d-none" for="">Quiere usar los datos de la cuenta?</label>

        <div class="custom-control custom-radio d-none">
            <input checked type="radio" class="custom-control-input" id="use_data_yes" name="use_data">
            <label class="custom-control-label" for="use_data_yes">Si</label>
        </div>

        <div class="custom-control custom-radio d-none">
            <input type="radio" class="custom-control-input" id="use_data_No" name="use_data">
            <label class="custom-control-label" for="use_data_No">No</label>
        </div>

        <hr >

        <div class="form-group">

            <label class="text-secondary" for="">Nombre completo como en la tarjeta*</label>

            <input type="text" vico="name" id="ctrl_name" name="ctrl_name" class="form-control vico-payment-control" value="" >

        </div>

        <div class="form-group">

            <label class="text-secondary" for="">Número de cedula o pasaporte</label>

            <div class="input-group mb-3">

                <div class="input-group-prepend">

                    <button class="btn btn-outline-secondary dropdown-toggle btn_document_type" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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

            <input type="text" vico="address" id="ctrl_address" name="ctrl_address" class="form-control vico-payment-control" >

        </div>

        <div class="form-row">

            <div class="form-group col-md-4">

                <label class="text-secondary" for="">Codigo Postal</label>

                <input type="text" vico="postal" id="ctrl_postal" name="ctrl_postal" class="form-control" >

            </div>

            <div class="form-group col-md-8">

                <label class="text-secondary" for="">Ciudad</label>

                <input type="text" vico="city" id="ctrl_city" name="ctrl_city" class="form-control" >

            </div>

        </div>

        <div class="form-group">

            <label class="text-secondary" for="">País</label>

            <input type="text" vico="country" id="ctrl_country" name="ctrl_country" class="form-control" >

        </div>

        <form action="/payments/pay" method="post" id="payment-form-card">
        {{--         
            <script
                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                data-key="{{ config('services.stripe.key') }}"
                data-amount="{{ $data['total']}}"
                data-name="Renta VICO"
                data-description="{{ __('Habitación #'.$data['room_number']) }}"
                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                data-locale="auto">
            </script> --}}
        
            {{ csrf_field() }}

            <input type="hidden" id="use_data_card" name="use_data_card">
            <input type="hidden" id="name_card" name="name_card">
            <input type="hidden" id="document_card" name="document_card">
            <input type="hidden" id="document_type_card" name="document_type_card">
            <input type="hidden" id="address_card" name="address_card">
            <input type="hidden" id="postal_code_card" name="postal_code_card">
            <input type="hidden" id="city_card" name="city_card">
            <input type="hidden" id="country_card" name="country_card">
            <input type="hidden" id="booking_id_card" name="booking_id_card" value="{{ $data['booking_id'] }}">
            <input type="hidden" id="usd_card" name="usd_card" class="usd">
            <input type="hidden" id="eur_card" name="eur_card" class="eur">

            <div class="form-group" id="paymentCard">

                <label class="text-secondary" for="card-element">
                    Tarjeta de crédito
                </label>

                <div id="card-element">

                </div>

                <div class="card-errors" role="alert"></div>

            </div>

            <button type="submit" class="btn btn-primary">Pagar</button>

        </form>

        <form action="/payments/sepa" method="post" id="payment-form-sepa">

            {{ csrf_field() }}

            <input type="hidden" id="use_data_sepa" name="use_data_sepa">
            <input type="hidden" id="name_sepa" name="name_sepa">
            <input type="hidden" id="document_sepa" name="document_sepa">
            <input type="hidden" id="document_type_sepa" name="document_type_sepa">
            <input type="hidden" id="address_sepa" name="address_sepa">
            <input type="hidden" id="postal_code_sepa" name="postal_code_sepa">
            <input type="hidden" id="city_sepa" name="city_sepa">
            <input type="hidden" id="country_sepa" name="country_sepa">

            <input type="hidden" id="booking_id_sepa" name="booking_id_sepa" value="{{ $data['booking_id'] }}">
            <input type="hidden" id="usd_sepa" name="usd_sepa" >
            <input type="hidden" id="eur_sepa" name="eur_sepa" >

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

            <input type="hidden" id="booking_id_paypal" name="booking_id_paypal" value="{{ $data['booking_id'] }}">
            <input type="hidden" id="usd_paypal" name="usd_paypal" >
            <input type="hidden" id="eur_paypal" name="eur_paypal" >

            <div class="form-group" id="paymentPaypal">

                <label class="text-secondary" style="height: 65px">Paypal</label>

                <div class="paypal-errors" role="alert"></div>

            </div>

            <button type="submit" class="btn btn-primary">Pagar</button>

        </form>

        <hr>

        <div class="custom-control custom-radio" >
            <input onchange="onChangeRadioPayment(1)" type="radio" class="custom-control-input" id="paymentMethodCreditCard" name="paymentMethod">
            <label class="custom-control-label" for="paymentMethodCreditCard"> <b>Credit Card</b> +3% transfer fee</label>
        </div>

        <div class="custom-control custom-radio" >
            <input onchange="onChangeRadioPayment(2)" type="radio" class="custom-control-input" id="paymentMethodSepa" name="paymentMethod">
            <label class="custom-control-label" for="paymentMethodSepa"> <b>SEPA / European bank transfer</b> +1% transfer fee</label>
        </div>

        <div class="custom-control custom-radio" >
            <input onchange="onChangeRadioPayment(3)" type="radio" class="custom-control-input" id="paymentMethodPaypal" name="paymentMethod">
            <label class="custom-control-label" for="paymentMethodPaypal"> <b>Paypal</b> +3% transfer fee</label>
        </div>

    </div>

</div>
@else
You don't have permission to enter this page.
@endif
@endsection
