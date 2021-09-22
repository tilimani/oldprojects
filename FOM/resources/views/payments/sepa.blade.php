@extends('layouts.app')

@section('content')

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

        #card-errors {
            color: #fefde5;
        }

        .container {
            display: grid;
            width: 100vw;
            height: 100vh;
            grid-template: auto 70% / 1fr 1fr;
            grid-template-areas:    "head head"
                                    "info form";
        }

        .head {
            grid-area: head;
            padding: 0 30%;
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
            grid-template: auto auto auto / 1fr 1fr;
            padding: 15px;
        }

        .values {
            text-align: right;
            font-weight: bold;
        }

        @media (max-width: 768px) {

            .container {
                grid-template: 20% auto auto / 1fr;
                grid-template-areas:    "head"
                                        "info"
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

    <script src="https://js.stripe.com/v3/"></script>

    <script type="text/javascript">

        // Create a Stripe client.
        // Note: this merchant has been set up for demo purposes.
        var stripe = Stripe('{{ config('services.stripe.key') }}');

        // Create an instance of Elements.
        var elements = stripe.elements();

        // Custom styling can be passed to options when creating an Element.
        // (Note that this demo uses a wider set of styles than the guide below.)
        var style = {
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
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a',
                ':-webkit-autofill': {
                    color: '#fa755a',
                }
            }
        };

        // Create an instance of the iban Element.
        var iban = elements.create('iban', {
            style: style,
            supportedCountries: ['SEPA'],
        });

        // Add an instance of the iban Element into the `iban-element` <div>.
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
        var form = document.getElementById('payment-form');

        form.addEventListener('submit', function(event) {

            event.preventDefault();
            showLoading();

            var sourceData = {
                type: 'sepa_debit',
                currency: 'eur',
                owner: {
                    name: document.querySelector('input[name="name"]').value,
                    email: document.querySelector('input[name="email"]').value,
                },
                mandate: {
                  // Automatically send a mandate notification email to your customer
                  // once the source is charged.
                  notification_method: 'email',
                }
            };

            // Call `stripe.createSource` with the iban Element and additional options.
            stripe.createSource(iban, sourceData).then(function(result) {
                if (result.error) {
                  // Inform the customer that there was an error.
                  errorMessage.textContent = result.error.message;
                  errorMessage.classList.add('visible');
                  stopLoading();
                } else {
                  // Send the Source to your server to create a charge.
                  errorMessage.classList.remove('visible');
                  stripeSourceHandler(result.source);
                }
            });
        });

    </script>

@endsection

<div class="container mt-4 mb-4">

    <div class="head">
        <img class="img-fluid" src="../../images/payments/VICO-logo-slogan.png" alt="Responsive image">
    </div>

    @if(Session::get('msg'))

        <div class="alert-success">
            {{ Session::get('msg') }}
        </div>

    @endif

    <div class="info">

        <h2 class="vico-color"> <b>¡Genial, este es el último paso!</b> </h2>
        <h3 class="vico-color">Reserva de la habitación {{ $data['room'] }}</h3>
        <h3 class="vico-color">En la VICO {{ $data['vico'] }}</h3>

        <hr>

        <div class="paragraph">

            <div class="text-secondary" >
                Primera renta mensual para reservar la habitación
            </div>

            <div class="values text-secondary">
                $ {{ $data['total'] }}
            </div>

            <div class="text-secondary" >
                Costo de transacción +3
            </div>

            <div class="values text-secondary">
                $ 3
            </div>

            <div class="text-secondary" >
                Pago único por servicio +5
            </div>

            <div class="values text-secondary">
                $ 8
            </div>

        </div>

        <hr>

        <div class="total">

            <h4 class="vico-color"> <b>Total $ {{ $data['total'] + 8 }}</b> </h4>

        </div>

    </div>

    <div class="form">

        <form action="/payments/pay" method="post" id="payment-form">

            {{ csrf_field() }}

            <input type="hidden" id="booking_id" name="booking_id" value="{{ $data['booking_id'] }}">
            <input type="hidden" id="total" name="total" value="{{ $data['total'] }}">

            <div class="form-group">

                <label class="text-secondary" for="">Nombre completo</label>

                <input type="text" id="name1" name="name1" class="form-control" value="{{ $data['name'] }}" readonly>

            </div>

            <div class="form-group">

                <label class="text-secondary" for="">Correo electronico</label>

                <input type="email" name="email" class="form-control" readonly value="{{ $data['email'] }}">

            </div>


            <div class="form-group">

                <label class="text-secondary" for="">Número de cedula o pasaporte</label>

                <div class="input-group mb-3">

                    <div class="input-group-prepend">

                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pasaporte
                        </button>

                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Pasaporte</a>
                            <a class="dropdown-item" href="#">Cedula</a>
                        </div>

                    </div>

                    <input value="{{ $data['document'] }}" type="text" class="form-control" aria-label="Text input with dropdown button" readonly>

                </div>

            </div>

            <div class="form-group">

                <label class="text-secondary" for="">Dirección</label>

                <input type="text" id="address" name="address" class="form-control" value="{{ $data['address'] }}">

            </div>

            <div class="form-row">

                <div class="form-group col-md-4">

                    <label class="text-secondary" for="">Codigo Postal</label>

                    <input type="text" id="postal" name="postal" class="form-control" value="{{ $data['postal_code'] }}">

                </div>

                <div class="form-group col-md-8">

                    <label class="text-secondary" for="">Ciudad</label>

                    <input type="text" id="city" name="city" class="form-control" value="{{ $data['city'] }}">

                </div>

            </div>

            <div class="form-group">

                <label class="text-secondary" for="">País</label>

                <input type="text" id="country" name="country" class="form-control" value="{{ $data['country'] }}">

            </div>


            <div class="form-row">

                <label for="iban-element">IBAN</label>

                <div id="iban-element">
                    <!-- A Stripe Element will be inserted here. -->
                </div>

            </div>

            <button class="btn btn-primary">Pagar</button>

        </form>

    </div>

</div>

@endsection
