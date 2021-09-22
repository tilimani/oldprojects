<script>
    @if (App::environment('production'))
        const stripe = Stripe('pk_live_274Xs5ImnCcaW0X3DOXiLfLd'),
    @else
        const stripe = Stripe('pk_test_TBHf0YvdwdQx3aCuVWRJiUhC'),
    @endif
    styleCard = {
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
    },
    elementsCard = stripe.elements(),
    card = elementsCard.create('card', { style: styleCard });

    $($(".collapse").on('show.bs.collapse', function(){
        $('.card-collapse').removeClass('card-collapse-active');
        $(this).prev('.card-collapse').addClass('card-collapse-active');
    }));

    var formCard = document.querySelector('#payment-form-card'),
    elementsSepa = stripe.elements(),
    styleSepa = {
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
    },
    iban = elementsSepa.create('iban', {
        style: styleSepa,
        supportedCountries: ['SEPA'],
    }),
    errorMessage = document.querySelector('#error-message'),
    bankName = document.querySelector('#bank-name'),
    formSepa = document.querySelector('#payment-form-sepa'),
    oldTotalPrice,
    oldTotalEurPrice,
    oldTotalUsdPrice,
    oldPrices,
    COP_USD,
    COP_EU,
    options = {
        name: $('#name_card').val(),
        address_line1: $('#address_card').val(),
        address_city: $('#city_card').val(),
        address_country: $('#country_card').val()
    };





    let card_element = document.querySelector("#card-element"),
    selectedPaymentMethod = $('#selected-payment-method'),
    card_form = document.querySelector('#card-form');

    $('.select-payment-method').click(()=>{
        let paymentMethod = $("input[name='payment-method-type']:checked").val();
        let paymentMethodId = $("input[name='payment_method']:checked");
        if(paymentMethodId){
            $('#card-brand').text(paymentMethodId.data("brand"));
            $('#card-last4').text(paymentMethodId.data("last4"));
        }
        switch (paymentMethod) {
            case "paymentCard":
                $('#method-cash').addClass("d-none");
                card_form.classList.remove("d-none");
                $('#method-'+paymentMethod).removeClass("d-none");
                mountCardInput();
                selectedPaymentMethod.text('Tarjeta de crédito');
                selectedPaymentMethod.text('Credit Card');

                break;
            case "cash":
                card.unmount();
                $('#method-paymentCard').addClass("d-none");
                $('#method-'+paymentMethod).removeClass("d-none");
                card_form.classList.add("d-none");
                selectedPaymentMethod.text('Efectivo');
                break;
            default:
                break;
        }
    });

    function mountCardInput(){
        card.mount(card_element);

        card.on('change', function (event) {
            var displayError = document.getElementsByClassName('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            }
            else {
                displayError.textContent = '';
            }

        });

        formCard.addEventListener('submit', function (event) {
            event.preventDefault();
            if (card) {
                stripe.createToken(card).then(function (result) {

                    if (result.error) {
                        let errorElement = document.getElementsByClassName('card-errors');
                        $('#collapseTwo').collapse('show');
                        errorElement.textContent = result.error.message;
                    } else {
                        stripeTokenHandler(result.token);
                    }
                });
            }
        });
    }

    function stripeTokenHandler(token, options) {

        let form = document.querySelector('#payment-form-card');
            hiddenInput = document.createElement('input');

        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);

        form.submit();
    }
    let newPrices;

    $('#submit-payment-data').on('click',(e)=>{
        e.preventDefault();

        let name = $('input[name=ctrl_name]').val(),
        documentNumber = $('input[name=ctrl_document]').val(),
        documentType = $('#document-type').children('option:selected').val(),
        address = $('input[name=ctrl_address]').val(),
        postal = $('input[name=ctrl_postal]').val(),
        city = $('input[name=ctrl_city]').val(),
        country = $('#manager-lista-usuarios').children('option:selected').val();

        let formData = {
            'ctrl_name':name,
            'ctrl_document':documentNumber,
            'ctrl_document_type':documentType,
            'ctrl_address':address,
            'ctrl_postal':postal,
            'ctrl_city':city,
            'ctrl_country':country,
        }

        Object.keys(formData).forEach((key)=>{
            $('#'+key).removeClass('is-invalid');
        })
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url:"{{url('/payments/verifyPayment')}}",
            headers:{
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify(formData),
            success:(data)=>{
                $('.is-invalid').removeClass('is-invalid');
                $('#collapseThree').collapse('show');
            },
            error:(data)=>{
                let errors = $.parseJSON(data.responseText).errors;
                $.each(errors, function (key, value) {
                    $('#' + key).addClass('is-invalid');
                });
            }
        });
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
    // let card_element = document.querySelector('#card-element');
// let iban_element = document.querySelector('#iban-element');

    function hideDeletePopup(source_id) {
        $(".popup-delete-method#"+source_id.dataset.source).hide();
    }

    function showConfirmationPopup(source_id) {
        $(".popup-delete-method#" + source_id.dataset.source).show();
    }

    function deletePaymentMethod(source_id){
        let showConfirmationPopup = document.querySelector('#deletePaymentMethod');
        let formData = {
            'source_id' : source_id.dataset.source,
        }
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url:"/payments/method/delete",
            headers:{
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                'X-CSRF-TOKEN': source_id.dataset.token,
            },
            data: JSON.stringify(formData),
            success:(data)=>{
                $(".popup-delete-method#"+source_id.dataset.source).hide();
                location.reload();
            },
            error:(data)=>{
                location.reload();
            }
        });
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
