{{-- <script type="text/javascript">
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

</script> --}}

<script>
    let newPrices;        
    $(function() {
        $('#currency-selector').change(function(){
            $('.currencies.cop').addClass('d-none');
            $('.currencies.eur').addClass('d-none');
            $('.currencies.usd').addClass('d-none');
            $('.currencies.'+$(this).val()).removeClass('d-none');
        });
    });
      $('#payment_verify').on('submit',(event)=>{
        event.preventDefault();
        let input =$('input[name=payment_code]'); 
        let code = input.val();
        let type = 'payment_code'

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/verification/verify-code',
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                code: code,
                type: type,
            },
            success: function(data)
            {
                let verification = $('#verification-payment-response');
                if(data.success){                
                    verification.text(data.success);
                    verification.css('color','green');
                    input.removeClass('is-invalid');
                    input.addClass('is-valid');                    
                    setTimeout(()=>{
                        $('#confirm-payment').modal('toggle');
                    },1500)
                }else{
                    input.removeClass('is-valid');
                    input.addClass('is-invalid');   
                    verification.text(data.failure);
                    verification.css('color','red');
                }
            }
          });
        return false;  

    });
    function selectRow(element){
      let checkbox = element.getElementsByTagName('input')[0];
      checkbox.click();
      if(checkbox.checked){
        element.classList.add("selected-row");
      }else{
        element.classList.remove("selected-row");
      }      
    }
    function check(id, index) {

        paymentPeriod = document.querySelector(`#${id}`); 

        if (paymentPeriod.checked) {
            newPrices = updatePrices(paymentPeriod, 'add');
        }
        else{
            newPrices = updatePrices(paymentPeriod, 'substract');
        }

        // updateInputPrices(newPrices[0], newPrices[1], newPrices[2]);

    }

        function updatePrices(paymentePeriod, action) {

        // let messagePrice = document.querySelector('#total-price').innerHTML;
        // let totalPriceCOP = parseFloat(messagePrice.substring(messagePrice.indexOf(':') + 2, messagePrice.indexOf('COP') - 1));
          
        // switch (action) {
        //     case 'add':
        //         totalPriceCOP += parseFloat(paymentPeriod.value);                
        //         break;
        //     case 'substract':
        //         totalPriceCOP -= parseFloat(paymentPeriod.value);                

        //     default:
        //         break;
        // }

        // let totalPriceUSD = parseFloat((totalPriceCOP* {{ $usd_cop }}).toFixed(2));
        // let totalPriceEUR = parseFloat((totalPriceCOP* {{ $eur_cop }}).toFixed(2));

        // document.getElementById('total-price').innerHTML = 'TOTAL: ' + totalPriceCOP + ' COP';
        // document.getElementById('usdPrice').innerHTML = 'Valor en USD: ' + '$' + totalPriceUSD;
        // document.getElementById('eurPrice').innerHTML = 'Valor en EUR: ' + '€' + totalPriceEUR;

        // return [totalPriceCOP, totalPriceUSD, totalPriceEUR];

        }

        // function updateInputPrices(priceCOP, priceUSD, priceEUR) {
        // document.getElementById('ctrl_finalPrice').value = priceEUR;
        // document.getElementById('ctrl_finalPriceCOP').value = priceCOP;
        // }

</script>