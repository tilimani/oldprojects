@extends('layouts.app')
@section('title', 'Proceso de pago')
@section('styles')
    <style type="text/css">
        input,
        .StripeElement {
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

        input:focus,
        .StripeElement--focus {
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

        .info {
            grid-area: info;
            padding: 0 50px 0 0;
            border-right: 1px solid #6c757d;
        }

        .total {
            text-align: right;
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

            .info {
                border-right: 0;
                padding: 0;
            }

            .paragraph {
                padding: 0;
            }
        }
    </style>
@stop

@section('content')

<!-- wrap box -->
    <section id="services-1" class="section-padding-ash">
        <div class="container">
            <div class="row">
                <!-- full wrap -->
                <div class="col-lg-12">
                    <!-- top title -->
                    {{-- <div class="col-md-12">
                        <div class="titiz3">You can change the method of payment every month.</div>
                    </div> --}}
                    <div class="row">
                        <img class="img-fluid mx-auto my-2 h-100 p-4" style="width: 300px" src="{{asset('images/vico_logo_transition/VICO_VIVIR_orange.png')}}"  alt="Responsive image">
                    </div>
                    <!-- item -->
                    <div class="card card-danger card-pricing text-center m-4 p-4">
                        <div class="row">
                            <!-- left area -->
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <h3 class="pui">
                                    <img class="Profilimgsml" src="{{ asset('images/payments/icon-jan-2.png')}}">
                                    Tarjeta de Crédito
                                    <span>
                                        + 3% Transaction fee
                                    </span>
                                </h3>
                                <br clear="all">
                                <img class="tiktok oxs" src="{{ asset('images/payments/tik.png')}}">
                                <p class="tui">
                                    Easy going payment of rent, no<br> looking for ATM, no carrying a<br>
                                    lot of money
                                </p>
                                <br clear="all">
                                <p class="rui">
                                    {{ __('Renta de Habitación '.$room->number . ' en ' .$house->name)}}
                                </p>
                                <br clear="all">
                                <p class="jn-tui">
                                    Primera renta mensual
                                </p>
                                <p class="jn-tui">
                                    para reservar habitación
                                    <span class="nodaag">{{ __($room->price . 'COP')}}</span>
                                </p>
                                <br clear="all">
                                <p class="jn-tui">
                                    Pago único por el servicio VICO
                                    <span class="nodaag">{{ __($room->price * 0.05 . 'COP')}}</span>
                                </p>
                                <br clear="all">
                                @if($bill->payments[0]['from'] === $nextBill['from'])
                                    <p class="jn-tui">
                                        <span>
                                            Costo de transacción + 3%
                                        </span>
                                        <span class="nodaagyes">
                                            {{ __($room->price * 0.03 . 'COP')}}
                                        </span>
                                    </p>
                                    <p class="arrow_box">
                                        <font>First month - no transaction fee!</font>
                                    </p>
                                    <p class="katla" id="total-price">
                                        {{ __('Total: ' . $price  . ' COP')}}
                                        <p class="aha" id="usdPrice">{{ __('Valor en USD: ' . '$' . $priceUSD)}}</p>
                                        <p class="aha" id="eurPrice">{{ __('Valor en EUR: ' . '€' . $priceEUR)}}</p>
                                    </p>
                                @else
                                    <p class="jn-tui">
                                        <span>
                                            Costo de transacción + 3%
                                        </span>
                                        <span class="nodaag">
                                            {{ __($room->price * 0.03 . 'COP')}}
                                        </span>
                                    </p>
                                    <p class="katla" id="total-price">
                                        {{ __('Total: ' . $price . ' COP')}}
                                        <p class="aha" id="usdPrice">{{ __('Valor en USD: ' . '$' . $priceUSD)}}</p>
                                        <p class="aha" id="eurPrice">{{ __('Valor en EUR: ' . '€' . $priceEUR)}}</p>
                                    </p>
                                @endif
                                <div class="clear50"></div>
                                {{-- PAYMENTS PERIODS START --}}
                                <div class="form-check">
                                @php
                                    $flag = 0;
                                @endphp
                                @for ($i = 0; $i < sizeof($bill->payments); $i++)
                                    <div class="form-check">
                                      <label class="form-check-label">
                                        <input type="checkbox" class="payment-periods"
                                            name="payment-period-{{ $i }}"
                                            id="payment-period-{{ $i }}"
                                            value="{{$bill->payments[$i]['price']}}"
                                            {{ $bill->payments[$i]['status'] ? 'checked disabled' : '' }}
                                            <?php
                                                if (!$bill->payments[$i]['status']) {
                                                    $flag ++;
                                                }
                                            ?>
                                            {{ $flag == 1 ? 'checked' : '' }}
                                            onclick="check('payment-period-{{ $i }}', {{$i}})"
                                        >
                                        {{ __('Payment day: ' . $bill->payments[$i]['from']->format('m/d/Y'))}}
                                      </label>
                                    </div>
                                @endfor
                                </div>
                                {{-- PAYMENTS PERIODS END --}}
                                <div class="clear50"></div>
                                <p class="pka">You can change the date of you exit in your profile.</p>
                            </div>
                            <!-- right area -->
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">

                                    <label for="ctrl_name" class="text-secondary">Nombre completo</label>

                                    <input type="text" vico="name" class="form-control vico-payment-control" name="ctrl_name" id="ctrl_name" value="{{ __($user->name . ' ' . $user->lastname)}}">

                                </div>
                                <br clear="all">

                                <div class="form-group">
                                    <label class="text-secondary" for="ctrl_document">Número de cedula o pasaporte</label>

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
                                <br clear="all">

                                <div class="form-group">

                                    <label for="ctrl_address" class="text-secondary">Dirección</label>

                                    <input type="text" vico="address" id="ctrl_address" name="ctrl_address" class="form-control vico-payment-control">

                                </div>
                                <br clear="all">

                                <div class="form-row">

                                    <div class="form-group col-4">

                                        <label class="text-secondary" for="ctrl_postal">Postal</label>

                                        <input type="text" vico="postal" id="ctrl_postal" name="ctrl_postal" class="form-control" >

                                    </div>

                                    <div class="form-group col-8">

                                        <label class="text-secondary" for="ctrl_city">Ciudad</label>

                                        <input type="text" vico="city" id="ctrl_city" name="ctrl_city" class="form-control">

                                    </div>
                                </div>
                                <br clear="all">

                                <div class="form-group">

                                    <label for="ctrl_country" class="text-secondary">País</label>

                                    <input type="text" vico="country" id="ctrl_country" name="ctrl_country" class="form-control" value="{{ $user->country()->first()->name }}">
                                </div>
                                <br clear="all">

                                <form action="/vico/payments/card" method="post" id="payment-form-card">
                                    {{-- <script
                                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                        data-key="{{ config('services.stripe.key') }}"
                                        data-amount="{{ $priceUSD * 100}}"
                                        data-name="Renta VICO"
                                        data-description="{{ __('Habitación #'.$room->number) }}"
                                        data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                        data-locale="auto">
                                    </script> --}}
                                    {{ csrf_field() }}
                                    {{-- <input type="hidden" id="use_data_card"     name="use_data_card"> --}}
                                    <input type="hidden" id="name_card"         name="name_card">
                                    <input type="hidden" id="document_card"     name="document_card">
                                    {{-- <input type="hidden" id="document_type_card"name="document_type_card"> --}}
                                    <input type="hidden" id="address_card"      name="address_card">
                                    {{-- <input type="hidden" id="postal_code_card"  name="postal_code_card"> --}}
                                    {{-- <input type="hidden" id="city_card"         name="city_card"> --}}
                                    {{-- <input type="hidden" id="country_card"      name="country_card"> --}}
                                    <input type="hidden" id="booking_id_card"   name="booking_id_card"  value="{{ $booking->id }}">
                                    {{-- <input type="hidden" id="usd_card"          name="usd_card" class="usd"> --}}
                                    <input type="hidden" id="stripeEmail"       name="stripeEmail"      value=" {{ $user->email }}">
                                    <input type="hidden" id="ctrl_finalPrice"   name="ctrl_finalPrice"  value="{{ $priceEUR }}">
                                    <input type="hidden" id="ctrl_finalPriceCOP"   name="ctrl_finalPriceCOP"  value="{{ $price }}">

                                    <div class="form-group" id="paymentCard">
                                        <label class="text-secondary" for="card-element">
                                            Tarjeta de crédito
                                        </label>
                                        @if(is_null($card))
                                            <div id="card-element"></div>
                                        @else
                                            Terminada en {{ $card->last4 }}
                                        @endif
                                        <div class="card-errors" role="alert"></div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Pagar</button>
                                </form>
                                <br clear="all">

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

                                    <input type="hidden" id="booking_id_sepa" name="booking_id_sepa" value="{{ $booking->id }}">
                                    <input type="hidden" id="usd_sepa" name="usd_sepa" >
                                    <input type="hidden" id="eur_sepa" name="eur_sepa" >

                                    <div class="form-group" id="paymentSepa">

                                        <label for="iban-element" class="text-secondary">IBAN</label>

                                        <!-- <input type="text" name="iban_element"> -->

                                        <div id="iban-element" name="iban_element"></div>

                                        <div class="sepa-errors text-secondary" role="alert"></div>

                                        <div class="bank-name text-secondary" role="alert"></div>

                                        <div id="mandate-acceptance">
                                            By providing your IBAN and confirming this payment, you are
                                            authorizing Rocketship Inc. and Stripe, our payment service
                                            provider, to send instructions to your bank to debit your account and
                                            your bank to debit your account in accordance with those instructions.
                                            You are entitled to a refund from your bank under the terms and
                                            conditions of your agreement with your bank. A refund must be claimed
                                            within 8 weeks starting from the date on which your account was debited.
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Pagar</button>

                                </form>
                                <br clear="all">

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
                                    <input type="hidden" id="usd_paypal" name="usd_paypal" >
                                    <input type="hidden" id="eur_paypal" name="eur_paypal" >

                                    <div class="form-group" id="paymentPaypal">

                                        <label class="text-secondary" style="height: 65px">Paypal</label>

                                        <div class="paypal-errors" role="alert"></div>

                                    </div>

                                    <button type="submit" class="btn btn-primary">Pagar</button>

                                </form>
                                <br clear="all">

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
                                </div>

                                <!-- buttons -->
                                <button class="btn-col-1 ml10 hover-opc">Start paying</button>
                                <button class="btn-col-1 hover-opc">Volver</button>
                            </div>
                            <br clear="all">
                        </div>
                    </div>
                    <!-- /item -->
                </div>
                <!-- </div> -->

            </div>
        </div>
    </section>
<!-- wrap box end-->
<script src="//js.stripe.com/v3/"></script>
@endsection

@section('scripts')
    <script type="text/javascript">

        var COP_USD,COP_EUR;

        $(function()  {

            let inputs_use_data = document.querySelectorAll('input[name=use_data]');
            for (let i = 0; i < inputs_use_data.length; i++) {

                inputs_use_data[i].addEventListener('change', function(event) {

                    document.getElementById('use_data_card').value = (this.id == 'use_data_yes');
                    document.getElementById('use_data_sepa').value = (this.id == 'use_data_yes');
                    document.getElementById('use_data_paypal').value = (this.id == 'use_data_yes');

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
    <script type="text/javascript">
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
        var errorMessage = document.getElementById('error-message');
        var bankName = document.getElementById('bank-name');

        iban.on('change', function(event) {

            // Handle real-time validation errors from the iban Element.
            if (event.error) {
                errorMessage.textContent = event.error.message;
                errorMessage.classList.add('visible');
            }
            else {
                errorMessage.classList.remove('visible');
            }

            // Display bank name corresponding to IBAN, if available.
            if (event.bankName) {
                bankName.textContent = event.bankName;
                bankName.classList.add('visible');
            }
            else {
                bankName.classList.remove('visible');
            }
        });

        // Handle form submission.
        var form = document.getElementById('payment-form-sepa');

        form.addEventListener('submit', function(event) {

            event.preventDefault();

            var sourceData = {
                type: 'sepa_debit',
                currency: 'eur',
                owner: {
                    name: document.querySelector('input[name="name_sepa"]').value,
                    email: 'gabalfa@gmail.com',
                },
                mandate: {
                    // Automatically send a mandate notification email to your customer
                    // once the source is charged.
                    notification_method: 'email',
                }
            };

            // Call `stripe.createSource` with the iban Element and additional options.
            stripeSepa.createSource(iban, sourceData).then(function(result) {

                if (result.error) {
                    // Inform the customer that there was an error.
                    // errorMessage.textContent = result.error.message;
                    // errorMessage.classList.add('visible');
                    // stopLoading();
                }
                else {
                    // Send the Source to your server to create a charge.
                    // errorMessage.classList.remove('visible');
                    stripeSourceHandler(result.source, iban);
                }

            });

        });

        function stripeSourceHandler(token, options) {

            var form = document.getElementById('payment-form-sepa');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            form.submit();
        }

    </script>

    <script type="text/javascript">
        let newPrices;
        function check(id, index) {

            paymentPeriod = document.getElementById(id);

            if (paymentPeriod.checked) {
                newPrices = updatePrices(paymentPeriod, 'add');
            }
            else{
                newPrices = updatePrices(paymentPeriod, 'substract');
            }

            updateInputPrices(newPrices[0], newPrices[1], newPrices[2]);

        }

        function updatePrices(paymentePeriod, action) {

            let messagePrice = document.getElementById('total-price').innerHTML;
            let totalPriceCOP = parseFloat(messagePrice.substring(messagePrice.indexOf(':') + 2, messagePrice.indexOf('COP') - 1));

            switch (action) {
                case 'add':
                    totalPriceCOP += parseFloat(paymentPeriod.value);
                    break;
                case 'substract':
                    totalPriceCOP -= parseFloat(paymentPeriod.value);
                default:
                    break;
            }

            let totalPriceUSD = parseFloat((totalPriceCOP* {{ $usd_cop }}).toFixed(2));
            let totalPriceEUR = parseFloat((totalPriceCOP* {{ $eur_cop }}).toFixed(2));

            document.getElementById('total-price').innerHTML = 'TOTAL: ' + totalPriceCOP + ' COP';
            document.getElementById('usdPrice').innerHTML = 'Valor en USD: ' + '$' + totalPriceUSD;
            document.getElementById('eurPrice').innerHTML = 'Valor en EUR: ' + '€' + totalPriceEUR;

            return [totalPriceCOP, totalPriceUSD, totalPriceEUR];

        }

        function updateInputPrices(priceCOP, priceUSD, priceEUR) {
            document.getElementById('ctrl_finalPrice').value = priceEUR;
            document.getElementById('ctrl_finalPriceCOP').value = priceCOP;
        }

    </script>
@endsection
