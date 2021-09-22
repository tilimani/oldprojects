<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="VICO helps you to find your perfect VICO in Medellín! You are searching for a shared flat together with other young people? Get in here!">
    <meta property="og:description" content="VICO helps you to find your perfect VICO in Medellín! You are searching for a shared flat together with other young people? Get in here!"
    /> {{-- BOOTSTRAP CORE CSS --}}
    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz"
        crossorigin="anonymous">
    <link href="{{asset('css/app.css?version=5') }}" rel="stylesheet"> @yield('styles')
    <title>Document</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card payment-method">
                    <div class="card-header">
                        <a data-toggle="collapse" href="#creditcardadd" role="button" aria-expanded="false" aria-controls="creditcardadd">
                            Credit card
                        </a>                        
                    </div>
                    
                    <div class="collapse card-body" id="creditcardadd">
                        <div class="form-group">

                            <label for="ctrl_name" class="text-secondary">Nombre completo</label>
                            {{-- {{ __($user->name . ' ' . $user->lastname)}} --}}
                            <input type="text" vico="name" class="form-control vico-payment-control" name="ctrl_name" id="ctrl_name" value="">

                        </div>                        

                        <div class="form-group">
                            <label class="text-secondary" for="ctrl_document">Número de cedula o pasaporte</label>

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

                            <label for="ctrl_address" class="text-secondary">Dirección</label>

                            <input type="text" vico="address" id="ctrl_address" name="ctrl_address" class="form-control vico-payment-control">

                        </div>                        

                        <div class="form-row">

                            <div class="form-group col-4">

                                <label class="text-secondary" for="ctrl_postal">Postal</label>

                                <input type="text" vico="postal" id="ctrl_postal" name="ctrl_postal" class="form-control">

                            </div>

                            <div class="form-group col-8">

                                <label class="text-secondary" for="ctrl_city">Ciudad</label>

                                <input type="text" vico="city" id="ctrl_city" name="ctrl_city" class="form-control">

                            </div>
                        </div>                        
                        <div class="form-group">

                            <label for="ctrl_country" class="text-secondary">País</label>
                            {{-- {{ $user->country()->first()->name }} --}}
                            <input type="text" vico="country" id="ctrl_country" name="ctrl_country" class="form-control" value="">
                        </div>     
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
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
                <div class="col-12 col-lg-12">

                <div class="card payment-method">
                    <a class="card-header" data-toggle="collapse" href="#addsepa" role="button" aria-expanded="false" aria-controls="addsepa">
                            Sepa / European bank transfer
                    </a>
                    <div class="collapse card-body" id="addsepa">
                            <div class="form-group">

                                    <label for="ctrl_name" class="text-secondary">Nombre completo</label>
                                    {{-- --}}
                                    <input type="text" vico="name" class="form-control vico-payment-control" name="ctrl_name" id="ctrl_name" value="{{ __($user->name . ' ' . $user->lastname)}} ">
        
                                </div>                        
        
                                <div class="form-group">
                                    <label class="text-secondary" for="ctrl_document">Número de cedula o pasaporte</label>
        
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
        
                                    <label for="ctrl_address" class="text-secondary">Dirección</label>
        
                                    <input type="text" vico="address" id="ctrl_address" name="ctrl_address" class="form-control vico-payment-control">
        
                                </div>                        
        
                                <div class="form-row">
        
                                    <div class="form-group col-4">
        
                                        <label class="text-secondary" for="ctrl_postal">Postal</label>
        
                                        <input type="text" vico="postal" id="ctrl_postal" name="ctrl_postal" class="form-control">
        
                                    </div>
        
                                    <div class="form-group col-8">
        
                                        <label class="text-secondary" for="ctrl_city">Ciudad</label>
        
                                        <input type="text" vico="city" id="ctrl_city" name="ctrl_city" class="form-control">
        
                                    </div>
                                </div>                        
                                <div class="form-group">
        
                                    <label for="ctrl_country" class="text-secondary">País</label>
                                    {{-- --}}
                                    <input type="text" vico="country" id="ctrl_country" name="ctrl_country" class="form-control" value="{{ $user->country()->first()->name }}">
                                </div> 
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
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
                <div class="col-12 col-lg-12">

                <div class="card payment-method">
                    <a class="card-header" data-toggle="collapse" href="#addpaypal" role="button" aria-expanded="false" aria-controls="addpaypal">
                            Paypal
                        </a>
                    <div class="collapse card-body" id="addpaypal">
                            <div class="form-group">

                                    <label for="ctrl_name" class="text-secondary">Nombre completo</label>
                                    {{--  --}}
                                    <input type="text" vico="name" class="form-control vico-payment-control" name="ctrl_name" id="ctrl_name" value="{{ __($user->name . ' ' . $user->lastname)}}">
        
                                </div>                        
        
                                <div class="form-group">
                                    <label class="text-secondary" for="ctrl_document">Número de cedula o pasaporte</label>
        
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
        
                                    <label for="ctrl_address" class="text-secondary">Dirección</label>
        
                                    <input type="text" vico="address" id="ctrl_address" name="ctrl_address" class="form-control vico-payment-control">
        
                                </div>                        
        
                                <div class="form-row">
        
                                    <div class="form-group col-4">
        
                                        <label class="text-secondary" for="ctrl_postal">Postal</label>
        
                                        <input type="text" vico="postal" id="ctrl_postal" name="ctrl_postal" class="form-control">
        
                                    </div>
        
                                    <div class="form-group col-8">
        
                                        <label class="text-secondary" for="ctrl_city">Ciudad</label>
        
                                        <input type="text" vico="city" id="ctrl_city" name="ctrl_city" class="form-control">
        
                                    </div>
                                </div>                        
                                <div class="form-group">
        
                                    <label for="ctrl_country" class="text-secondary">País</label>
                                    {{-- {{ $user->country()->first()->name }} --}}
                                    <input type="text" vico="country" id="ctrl_country" name="ctrl_country" class="form-control" value="">
                                </div> 
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="//code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" integrity="sha384-FzT3vTVGXqf7wRfy8k4BiyzvbNfeYjK+frTVqZeNDFl8woCbF0CYG6g2fMEFFo/i"
        crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script src='//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.4.0/js/intlTelInput.min.js'></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.0/jquery.waypoints.js"></script>
    {{-- @section('scripts') --}}
    <script src="//js.stripe.com/v3/"></script>

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
    let oldTotalPrice;
    let oldTotalEurPrice;
    let oldTotalUsdPrice;
    let oldPrices;

    function check(id, index) {
        paymentPeriod = document.getElementById(id);
        if (paymentPeriod.checked) {
            oldPrices = updateToNewPrice(index,paymentPeriod);
            oldTotalPrice = oldPrices[0];
            oldTotalEurPrice = oldPrices[1];
            oldTotalUsdPrice = oldPrices[2];

            lockOtherOptions(index);
        }
        else{
            updateToOldPrice(oldTotalPrice, oldTotalEurPrice, oldTotalUsdPrice);

            unlockOtherOptions(index);
        }
    }

    function updateToNewPrice(index,paymentPeriod) {
        var oldTotal = document.getElementById('total-price').innerHTML;
        var oldTotalEur = document.getElementById('eurPrice').innerHTML;
        var oldTotalUsd = document.getElementById('usdPrice').innerHTML;

        var newTotal = (Number(paymentPeriod.value) + (Number(paymentPeriod.value) * 0.05) + (Number(paymentPeriod.value) * 0.03));
        var newTotalEur = ((Number(paymentPeriod.value) + (Number(paymentPeriod.value) * 0.05) + (Number(paymentPeriod.value) * 0.03)) * {{$eur_cop}});
        var newTotalUsd = ((Number(paymentPeriod.value) + (Number(paymentPeriod.value) * 0.05) + (Number(paymentPeriod.value) * 0.03)) * {{$usd_cop}});

        document.getElementById('total-price').innerHTML = 'Total: ' + newTotal + ' COP';

        document.getElementById('eurPrice').innerHTML = 'Valor en EUR: ' + '€' + newTotalEur;
        // Importatn line: Setting new price to charge---------------------------------------------------
        document.getElementById('ctrl_finalPrice').value = newTotalEur;
        // ----------------------------------------------------------------------------------------------

        document.getElementById('usdPrice').innerHTML = 'Valor en USD: ' + '$' + newTotalUsd;

        return [oldTotal, oldTotalEur, oldTotalUsd];
    }

    function updateToOldPrice(oldTotal, oldTotalEur, oldTotalUsd) {
        document.getElementById('total-price').innerHTML =  oldTotal;
        document.getElementById('eurPrice').innerHTML = oldTotalEur;
        document.getElementById('usdPrice').innerHTML = oldTotalUsd;
    }

    function lockOtherOptions(currentCheckedIndex) {
        for (let i = currentCheckedIndex - 1; i >= 0; i--) {
            document.getElementById('payment-period-' + i).checked = true;
            document.getElementById('payment-period-' + i).disabled = true;
        }
    }

    function unlockOtherOptions(uncheckedIndex) {
        document.getElementById('payment-period-' + (uncheckedIndex - 1)).disabled = false;
    }
    </script>
{{-- @endsection --}}
</body>

</html>