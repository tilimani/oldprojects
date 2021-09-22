import './_stars';
import {
    EMLINK
} from 'constants';
$('.star i').html("&#9733");
$('.star').html("&#9733");
let slider = document.querySelector("#sliderPrice"),
    output = document.querySelector("#sliderValue");
if (output && slider) {
    output.innerHTML = slider.value * 2; // Display the default slider value
    // Update the current slider value (each time you drag the slider handle)
    slider.oninput = function () {
        output.innerHTML = this.value * 2;
    }
}
$('.like').click(function (event) {
    let qualificationHouseRecommend = document.querySelector('input[name=qualificationHouseRecommend]'),
        qualificationManagerRecommend = document.querySelector('input[name=qualificationManagerRecommend]');
    if (qualificationHouseRecommend) {
        qualificationHouseRecommend.value = '1';
    }
    if (qualificationManagerRecommend) {
        qualificationManagerRecommend.value = '1';
    }
});
$('.dislike').click(function (event) {
    let qualificationHouseRecommend = document.querySelector('input[name=qualificationHouseRecommend]'),
        qualificationManagerRecommend = document.querySelector('input[name=qualificationManagerRecommend]');
    if (qualificationHouseRecommend) {
        qualificationHouseRecommend.value = '-1';
    }
    if (qualificationManagerRecommend) {
        qualificationManagerRecommend.value = '-1';
    }
});
$('.like, .dislike').on('click', function (event) {
    event.preventDefault();
    $('.active-review').removeClass('active-review');
    $(this).addClass('active-review');
});

$(function() {
    $("[data-toggle=popover]").popover();
});
if (window.location.pathname.indexOf('/review/')) {
    var btnSubmitReview = document.querySelector('.submit-review'),
        offset = 0,
        call,
        target;
    if (btnSubmitReview) {
        btnSubmitReview.addEventListener("click", validateInputs);
    }
}

function validateInputs(event) {
    event.preventDefault();
    let inputs = document.querySelectorAll('input[type=number]'),
        textInput = document.querySelector('textarea'),
        i = 0,
        length = inputs.length,
        validate = true,
        form = document.querySelector('.review_form');
    var elem = null;
    for (; i < length; i++) {
        elem = inputs[i];
        if (elem.value === '0') {
            elem.parentNode.classList.add('border');
            elem.parentNode.classList.add('border-red');
            validate = false;
            alert('Por favor, completa todos los campos antes de enviar tu reseña.');
            $('html, body').animate({
                scrollTop: $(elem.parentNode).offset().top - 100
            }, 700);
            break;
        } else {
            if (elem.parentNode.classList.contains('border')) {
                elem.parentNode.classList.remove('border');
                elem.parentNode.classList.remove('border-red');
            }
        }
    }
    if (validate) {
        if (textInput.value != '') {
            form.submit();
            if (textInput.classList.contains('border')) {
                textInput.classList.remove('border-red');
                textInput.classList.remove('border');

            }
        } else {
            alert('Por favor, completa todos los campos antes de enviar tu reseña.');
            textInput.classList.add('border-red');
            textInput.classList.add('border');
        }
    }
}

// Modal to verify user based on mobile number

let bookingPass = document.getElementById('bookingPass'),
    bookingPassBtn = document.getElementById('bookingPassBtn'),
    errorMsg = document.getElementById('errorMsg'),
    tabs = document.getElementsByClassName("tab"),
    currentTab = 0,
    localStorageTime = "modalTime";

window.onload = init;

function init() {
    let modal = document.querySelector('#authBookingsModal');
    if (localStorage.getItem(localStorageTime) === null) {
        modal.modal('show');
        console.log("no hay localstorage tonces abro modal")
    } else {
        let lastDate = new Date(Date.parse(localStorage.getItem(localStorageTime))),
            now = new Date();
        if (now <= lastDate) {
            modal.modal('hide');
        } else {
            modal.modal('show');
        }
    }
    events();
    $('input').keypress(function (e) {
        if (e.which == 13) {
            return false;
        }
    });
}

function validatePass() {
    let number = $('input[name=user_phone').val(),
        pass = number.slice(number.length - 4);
    $('input[name=password').val(pass);
    number = number.toString();
    if (number == "") {
        pass = "0000";
    }

    if (bookingPass.value == pass) {
        $('#authBookingsModal').modal('hide');
        let actualDate = new Date(),
            actualHour = actualDate.getHours()
        localStorage.setItem(localStorageTime, new Date(actualDate.setHours(actualHour + .1)));
    } else {
        bookingPass.classList.add('wrong');
        errorMsg.classList.add('errorMsg');
    }
}

function events() {
    bookingPassBtn.addEventListener('click', validatePass);
    bookingPass.addEventListener('focus', (e) => {
        bookingPass.classList.remove('wrong');
        errorMsg.classList.remove('errorMsg');
    });
}
