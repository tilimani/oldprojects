import Drag from '@shopify/draggable';
var state = true;
var leerMas = document.getElementsByClassName('leer-mas');

var dimension1 = "?fit=crop&w=1000&h=500";
var dimension2 = "?fit=crop&w=325&h=165";
var mainimage;
var image1;
var image2;
var image3;
var mimage;
var img1;
var img2;
var img3;

mainimage = document.getElementById("main_image").src;
image1 = document.getElementById("image1").src;
image2 = document.getElementById("image2").src;
image3 = document.getElementById("image3").src;
mimage = document.getElementById("main_image");
img1 = document.getElementById("image1");
img2 = document.getElementById("image2");
img3 = document.getElementById("image3");

mimage.src += dimension1;
img1.src += dimension2;
img2.src += dimension2;
img3.src += dimension2;

var room;
var roomid;
var check;
var modalDateFrom;
var modalDateTo;

window.onload = function () {

    $('#image1').click(function () {
        mimage.src = image1 + dimension1;
        var temp = mainimage;
        mainimage = image1;
        image1 = temp;
        img1.src = image1 + dimension2;
    });
    $('#image2').click(function () {
        mimage.src = image2 + dimension1;
        var temp = mainimage;
        mainimage = image2;
        image2 = temp;
        img2.src = image2 + dimension2;
    });
    // $('#image3').click(function(){
    // 	mimage.src=image3+dimension1;
    // 	var temp=mainimage;
    // 	mainimage=image3;
    // 	image3=temp;
    // 	img3.src=image3+dimension2;
    // });
    room = document.getElementById("roomreserve");
    roomid = document.getElementById("room_id");
    modalDateFrom = document.getElementById("datefrom");
    modalDateTo = document.getElementById("dateto");
    var day = document.getElementById("day");
    var month = document.getElementById("month");
    var year = document.getElementById("year");
    var checkr = document.getElementsByClassName("askfor");
    day.innerHTML = "<option selected>Dia</option>";
    year.innerHTML = "<option selected>Año</option>";
    check = '<?php echo $auth; ?>';
    if (check) {
        for (var i = 0; i < checkr.length; i++) {
            checkr[i].setAttribute('data-target', '#AskFor');
            checkr[i].value = i + 1;
        }
    } else {
        for (var i = 0; i < checkr.length; i++) {
            checkr[i].setAttribute('data-target', '#Register');
            checkr[i].value = i + 1;
        }
    }
    for (var i = 1; i <= 31; i++) {
        day.innerHTML += "<option name='birthday_day' value='" + i + "'>" + i + "</option>"
    }
    for (var i = 0; i < months.length; i++) {
        months.innerHTML += '<option name="birthday_month" value="' + (i + 1) + '">' + months[i] + '</option>'
    }
    for (var i = 1970; i <= (new Date).getFullYear(); i++) {
        year.innerHTML += "<option name='birthday_year' value='" + i + "'>" + i + "</option>"
    }
}


$('.mobile-admin-card .desc').hide();

$('.leer-mas').click(function () {
    if (state) {
        $('.admin-card .desc').removeClass('text');
        $('.mobile-admin-card .desc').removeClass('text');
        state = false;
        leerMas[0].innerHTML = 'Ver menos';
        leerMas[1].innerHTML = 'Ocultar';
    } else {
        $('.admin-card .desc').addClass('text');
        $('.mobile-admin-card .desc').addClass('text');
        state = true;
        leerMas[0].innerHTML = 'Leer mas';
        leerMas[1].innerHTML = '¿Quién es?';
    }

});

$('.mobile-admin-card .leer-mas').click(function () {
    $('.mobile-admin-card .desc').toggle();
});

$(document).ready(function () {
    $('.roomCarousel').carousel({
        interval: 10000000000000
    })
});

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip({
        html: true
    });
});



$('.carousel[data-type="multi"] .item').each(function () {
    var next = $(this).next();
    if (!next.length) {
        next = $(this).siblings(':first');
    }
    next.children(':first-child').clone().appendTo($(this));
    for (var i = 0; i < 1; i++) {
        next = next.next();
        if (!next.length) {
            next = $(this).siblings(':first');
        }
        next.children(':first-child').clone().appendTo($(this));
    }
});

$('.toggle-password').addClass('glyphicon glyphicon-eye-close');
// show password
$('.toggle-password').mousedown(function () {
    $('.pass').attr('type', 'text');
    $('.toggle-password').removeClass('glyphicon-eye-close');
    $('.toggle-password').addClass('glyphicon-eye-open');
});
// hide password
$('.toggle-password').mouseup(function () {
    $('.pass').attr('type', 'password');
    $('.toggle-password').addClass('glyphicon-eye-close');
    $('.toggle-password').removeClass('glyphicon-eye-open');
});
$('.toggle-password').mouseleave(function () {
    $('.pass').attr('type', 'password');
    $('.toggle-password').addClass('glyphicon-eye-close');
    $('.toggle-password').removeClass('glyphicon-eye-open');
});
$('.dates').focusout(function () {
    if (modalDateFrom.value > modalDateTo.value) {
        $('.dates').css("border-color", "red");
        $('.btn-reserv').attr("disabled", "true");
    } else {
        $('.dates').css("border-color", "orange");
        $('.btn-reserv').removeAttr("disabled");
    }
});

$("#cellphone").intlTelInput({
    //allowDropdown: false,
    autoHideDialCode: false,
    autoPlaceholder: "off",
    dropdownContainer: "body",
    excludeCountries: ["us"],
    formatOnDisplay: false,
    geoIpLookup: function (callback) {
        $.get("http://ipinfo.io", function () {}, "jsonp").always(function (resp) {
            var countryCode = (resp && resp.country) ? resp.country : "";
            callback(countryCode);
        });
    },
    hiddenInput: "full_number",
    initialCountry: "auto",
    nationalMode: false,
    placeholderNumberType: "MOBILE",
    separateDialCode: true,
    utilsScript: "{{ asset('js/intlTelInput.js') }}"
});



function askfor(idRoom, date) {
    roomid.value = idRoom;
    room.innerHTML = document.getElementById("room" + idRoom).value;
    modalDateFrom.min = date;
    modalDateFrom.value = date;
    modalDateTo.min = date;
    modalDateTo.value = date;
}
//cellphone dial

function register() {
    var dial = document.getElementsByClassName("selected-dial-code");
    var phone = document.getElementById("cellphone").value;
    document.getElementById("cellphone").value = dial[0].innerHTML + phone;
    $("#btnregister").click();
}

//login with Google
function onSignIn(googleUser) {
    // Useful data for your client-side scripts:
    var profile = googleUser.getBasicProfile();
    $.ajax({
            url: '/user/' + profile.getEmail(),
            type: "get",
        })
        .done(function (data) {
            if (data != NULL) {
                if (data[0].externalAccount != 1) {
                    $("#emaillog").value = profile.getEmail();
                    $("#passwordlog").value = "friendsofmedellin" + data[0].id;
                    $("#mloginbtn").click();
                }
            } else {
                $("#externalname").value = profile.getName();
                $("#externalemail").value = profile.getEmail();
                $("#extregbtn").click();
            }
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            //alert('server not responding...');
        });
    /*document.getElementById("name").value=profile.getName();
		document.getElementById("email").value=profile.getEmail();
     		console.log("ID: " + profile.getId()); // Don't send this directly to your server!
        console.log('Full Name: ' + profile.getName());
        console.log('Given Name: ' + profile.getGivenName());
        console.log('Family Name: ' + profile.getFamilyName());
        console.log("Image URL: " + profile.getImageUrl());
		console.log("Email: " + profile.getEmail());*/
    // The ID token you need to pass to your backend:
    var id_token = googleUser.getAuthResponse().id_token;
    //	console.log("ID Token: " + id_token);
};
//login with facebook
window.fbAsyncInit = function () {
    FB.init({
        appId: '{your-app-id}',
        cookie: true,
        xfbml: true,
        version: '{latest-api-version}'
    });

    FB.AppEvents.logPageView();

};

function checkLoginState() {
    FB.getLoginStatus(function (response) {
        statusChangeCallback(response);
        console.log("-----datos facebook-----");
        console.log(response);
    });
}

// Load the SDK asynchronously
(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
// window.onload(){
// 	function renderButton() {
//     gapi.signin2.render('g-signin2', {
//       'scope': 'profile email',
//       'width': 240,
//       'height': 50,
//       'longtitle': true,
//       'theme': 'dark',
//       'onsuccess': onSuccess,
//       'onfailure': onFailure
//     });
//   }
// }

$(document).ready(function () {

    const containers = document.getElementsByName("gallery");

});