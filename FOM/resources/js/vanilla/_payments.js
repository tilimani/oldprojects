// const stripe = Stripe('pk_test_TBHf0YvdwdQx3aCuVWRJiUhC'),
//     styleCard = {
//         base: {
//             color: '#32325d',
//             lineHeight: '18px',
//             fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
//             fontSmoothing: 'antialiased',
//             fontSize: '16px',
//             '::placeholder': {
//                 color: '#aab7c4'
//             }
//         },
//         invalid: {
//             color: '#fa755a',
//             iconColor: '#fa755a'
//         }
//     },
//     elementsCard = stripe.elements(),
//     card = elementsCard.create('card', { style: styleCard });

// var formCard = document.querySelector('#payment-form-card'),
//     elementsSepa = stripe.elements(),
//     styleSepa = {
//         base: {
//             color: '#32325d',
//             fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif',
//             fontSmoothing: 'antialiased',
//             fontSize: '16px',
//             '::placeholder': {
//                 color: '#aab7c4'
//             },
//             ':-webkit-autofill': {
//                 color: '#32325d',
//             },
//         },
//         invalid: {
//             color: '#fa755a',
//             iconColor: '#fa755a',
//             ':-webkit-autofill': {
//                 color: '#fa755a',
//             },
//         }
//     },
//     iban = elementsSepa.create('iban', {
//         style: styleSepa,
//         supportedCountries: ['SEPA'],
//     }),
//     errorMessage = document.querySelector('#error-message'),
//     bankName = document.querySelector('#bank-name'),
//     formSepa = document.getElementById('payment-form-sepa'),
//     oldTotalPrice,
//     oldTotalEurPrice,
//     oldTotalUsdPrice,
//     oldPrices,
//     COP_USD,
//     COP_EU,
//     options = {
//         name: $('#name_card').val(),
//         address_line1: $('#address_card').val(),
//         address_city: $('#city_card').val(),
//         address_country: $('#country_card').val()
//     };

$(document).ready(function () {
    let inputs_use_data = document.querySelectorAll('input[name=use_data]'),
        i = 0,
        vico_controls = document.querySelectorAll('.vico-payment-control');

    for ( i = 0; i < inputs_use_data.length; i++) {

        inputs_use_data[i].addEventListener('change', function (event) {

            document.getElementById('use_data_card').value = (this.id == 'use_data_yes');
            document.getElementById('use_data_sepa').value = (this.id == 'use_data_yes');
            document.getElementById('use_data_paypal').value = (this.id == 'use_data_yes');

            if (this.id == 'use_data_yes') {
                document.getElementById(`ctrl_name`).value = '';
            } else {
                document.getElementById(`ctrl_name`).value = '';
            }
        });
    }
    i = 0;
    for (i = 0; i < vico_controls.length; i++) {
    
        vico_controls[i].addEventListener('change', function (event) {

            let nameIndex = this.name.split("_")[1];
            document.querySelector('#' + nameIndex + '_card').value = this.value;
            // document.querySelector('#' + nameIndex + '_sepa').value = this.value;
            // document.querySelector('#' + nameIndex + '_paypal').value = this.value;
            // document.getElementById(`${this.attributes['vico'].value}_card`).value = this.value;
            // document.getElementById(`${this.attributes['vico'].value}_sepa`).value = this.value;
            // document.getElementById(`${this.attributes['vico'].value}_paypal`).value = this.value;
        });

    }
    
    // document.getElementById('payment-form-card').style.display = 'none';
    // document.getElementById('payment-form-sepa').style.display = 'none';
    // document.getElementById('payment-form-paypal').style.display = 'none';
    
    document.getElementsByClassName('documentType').value = 'pasaporte';
    $('#paymentMethodCreditCard').on('click', function(e) {
        onChangeRadioPayment(1);
    });
    $('#paymentMethodSepa').on('click', function (e) {
        onChangeRadioPayment(2);
    });
    $('#paymentMethodPaypal').on('click', function (e) {
        onChangeRadioPayment(3);
    });
});


function onChangeRadioPayment(paymentMethod) {

    if(paymentMethod == 1) {
        document.getElementById('payment-form-card').style.display = 'block';
        document.getElementById('payment-form-sepa').style.display = 'none';
        document.getElementById('payment-form-paypal').style.display = 'none';
    } else if(paymentMethod == 2){
        document.getElementById('payment-form-card').style.display = 'none';
        document.getElementById('payment-form-sepa').style.display = 'block';
        document.getElementById('payment-form-paypal').style.display = 'none';
    } else if(paymentMethod == 3){
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
    } else if (documentType == 2) {
        document.getElementById(`document_type_card`).value = 'cedula';
        document.getElementById(`document_type_sepa`).value = 'cedula';
        document.getElementById(`document_type_paypal`).value = 'cedula';
        document.querySelector(`.btn_document_type`).innerHTML = 'Cedula';
    }

}

// function stripeTokenHandler(token, options) {

//         let form = document.querySelector('#payment-form-card');
//             hiddenInput = document.createElement('input');

//         hiddenInput.setAttribute('type', 'hidden');
//         hiddenInput.setAttribute('name', 'stripeToken');
//         hiddenInput.setAttribute('value', token.id);
//         form.appendChild(hiddenInput);

//         form.submit();
// }
// CAMBIAR DE TRES FORMS A UNO
// MIRAR PORQUE LA CUENTA NO DEJA CREAR SOURCE

// adjuntar la fuente al cliente
// luego de esto puede crear crear el cargo
let card_element = document.querySelector('#card-element');
let iban_element = document.querySelector('#iban-element');

if(card_element) {
    // card.mount(card_element);

    // card.on('change', function (event) {

    //     var displayError = document.getElementsByClassName('card-errors');

    //     if (event.error) {
    //         displayError.textContent = event.error.message;
    //     }
    //     else {
    //         displayError.textContent = '';
    //     }

    // });

    // formCard.addEventListener('submit', function (event) {

    //     event.preventDefault();

    //     stripe.createToken(card).then(function (result) {

    //         if (result.error) {
    //             let errorElement = document.getElementsByClassName('card-errors');
    //             $('#collapseTwo').collapse('show');                
    //             errorElement.textContent = result.error.message;
    //         } else {
    //             stripeTokenHandler(result.token);
    //         }
    //     });
    // });
}
if(iban_element) {
    iban.mount(iban_element);
    iban.on('change', function (event) {

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
}
// Handle form submission.
// if(formSepa) {
//     formSepa.addEventListener('submit', function(event) {
    
        
//         let sourceData = {
//                 type: 'sepa_debit',
//                 currency: 'eur',
//                 owner: {
//                     name: document.querySelector('input[name="name_sepa"]').value,
//                     email: 'gabalfa@gmail.com',
//                 },
//                 mandate: {
//                     // Automatically send a mandate notification email to your customer
//                     // once the source is charged.
//                     notification_method: 'email',
//                 }
//             };
    
//         event.preventDefault();
    
//         // Call `stripe.createSource` with the iban Element and additional options.
//         stripe.createSource(iban, sourceData).then(function(result) {
    
//             if (result.error) {
//                 // Inform the customer that there was an error.
//                 // errorMessage.textContent = result.error.message;
//                 // errorMessage.classList.add('visible');
//                 // stopLoading();
//             }
//             else {
//                 // Send the Source to your server to create a charge.
//                 // errorMessage.classList.remove('visible');
//                 stripeSourceHandler(result.source, iban);
//             }
    
//         });
    
//     });
// }

function stripeSourceHandler(token, options) {

    let form = document.querySelector('#payment-form-sepa');
        hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);

    form.submit();
}

function check(id, index) {
    paymentPeriod = document.querySelector('#' + id);
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

function lockOtherOptions(currentCheckedIndex) {
    let i = 0;
    for (i = currentCheckedIndex - 1; i >= 0; i--) {
        document.querySelector('#payment-period-' + i).checked = true;
        document.querySelector('#payment-period-' + i).disabled = true;
    }
}

function unlockOtherOptions(uncheckedIndex) {
    document.querySelector('#payment-period-' + (uncheckedIndex - 1)).disabled = false;
}
/**
 * 
 * @param {*} oldTotal 
 * @param {*} oldTotalEur 
 * @param {*} oldTotalUsd 
 */
// function updateToNewPrice(index,paymentPeriod) {
//     let oldTotal = document.getElementById('total-price').innerHTML,
//         oldTotalEur = document.getElementById('eurPrice').innerHTML,
//         oldTotalUsd = document.getElementById('usdPrice').innerHTML,

//         newTotal 
//         = (Number(paymentPeriod.value) 
//         + (Number(paymentPeriod.value) * 0.05) 
//         + (Number(paymentPeriod.value) * 0.03)),
//         newTotalEur 
//         = ((Number(paymentPeriod.value) + (Number(paymentPeriod.value) * 0.05) 
//         + (Number(paymentPeriod.value) * 0.03)) * {{$eur_cop}}),
//         newTotalUsd 
//         = ((Number(paymentPeriod.value) 
//         + (Number(paymentPeriod.value) * 0.05) 
//         + (Number(paymentPeriod.value) * 0.03)) * {{$usd_cop}});

//     document.getElementById('total-price').innerHTML = 'Total: ' + newTotal + ' COP';

//     document.getElementById('eurPrice').innerHTML = 'Valor en EUR: ' + '€' + newTotalEur;
//     // Importatn line: Setting new price to charge---------------------------------------------------
//     document.getElementById('ctrl_finalPrice').value = newTotalEur;
//     // ----------------------------------------------------------------------------------------------

//     document.getElementById('usdPrice').innerHTML = 'Valor en USD: ' + '$' + newTotalUsd;

//     return [oldTotal, oldTotalEur, oldTotalUsd];
// }

/**
 * 
 * @param {*} currentCheckedIndex 
 */
// function updateToOldPrice(oldTotal, oldTotalEur, oldTotalUsd) {
//     document.getElementById('total-price').innerHTML =  oldTotal;
//     document.getElementById('eurPrice').innerHTML = oldTotalEur;
//     document.getElementById('usdPrice').innerHTML = oldTotalUsd;
// }

