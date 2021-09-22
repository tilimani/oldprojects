/**
Aquí irá todo el javascript de friends of medellín, si se considera necesario añadir otro archivo este deberá ser incluído en las dependencias de app.js.
*/
import './_swap';
import './_edit';
import './_review';
import ProfileModal from '../components/ProfileModal/ProfileModal';
import RateVicoModal from '../components/RateVicoModal/RateVicoModal';


const feedbackContent = document.querySelector('#feedbackSection');
const starContainer = document.querySelectorAll('i.star');

/**
 * It uses Array.filter to
 * return elements not matching a value.
 * @param {array} arr target array
 * @param {any} value target value
 */
function arrayRemove(arr, value) {
    let i = 0,
        length = arr.length;
    for (; i < length; i++) {
        if (arr[i] === value) {
            arr.splice(i, 1);
        }
    }
    return arr;
}

/**
 * Fill all the icons with the class star
 */
function fillStars() {
    let i = 0,
        length = starContainer.length;
    for (; i < length; i++) {
        starContainer[i].html = '&#9733';
    }
}

/**
 * Format a date to the aplication tour format, provided by the product owner.
 * @param {String} stringDate primitive string, base string
 * @param {Array} options Array holding String() objects containing the options.
 * @returns {String} String() object containing the tour information.
 */
function formatTour(stringDate, options) {
    let res,
        length = options.length,
        tem;
    switch (length) {
        case 1:
            tem = ' en la ' + options[0] + '.';
            return stringDate += tem;
        case 2:
            tem = ' en la ' + options[0] + ' y en la ' + options[1] + '.';
            return stringDate += tem;
        case 3:
            tem = ' en la ' + options[0] + ', en la ' + options[1] + ' o en la ' + options[2] + '.';
            return stringDate += tem;
        default:
            tem = '.';
            return stringDate += tem;
    }
}
/**
 * Fill an array with dates from 0 to index.
 * @param {Number} index Target index, 0 (today) by default.
 * @returns {Array} Array filled with Date() object.
 */
function getDates(index = 0) {
    let arr = [],
        i = 0,
        res;
    for (; i < index + 1; i++) {
        res = new Date();
        res.setDate(res.getDate() + (i + 1));
        arr.push(res);
    }
    return arr;
}

/**
 * Fill an array with dates formated to string dd mm yyyy
 * separated by separator, default format dd/mm/yyyy
 * @param {Array} input Target dates, filled with Date().
 * @param {String} separator Primitive string, separates the date values
 * @returns {Array} Array filled with each Date() custom formated.
 */
function getDateFormat(input, separator = '/') {
    let arr = [],
        i = 0,
        length = input.length;
    for (; i < length; i++) {
        arr.push(new String(input[i].getDate() + separator + (input[i].getMonth() + 1) + separator + input[i].getFullYear()))
    }
    return arr;

}

function definePopover(selector = '.feedback') {
    var btnFeedback = document.querySelector(selector);
    // $(selector).popover({
    //   trigger: 'focus',
    //   animation: true,
    //   html: true,
    //   placement: 'left',
    //   content: feedbackContent.innerHTML,
    //   container: 'body'
    // });
    btnFeedback.addEventListener('click', toggleBackground);
    btnFeedback.addEventListener('touchstart', function (event) {
        toggleBackground(btnFeedback);
    });
}


function togglePassword() {
    let passList = document.querySelectorAll('.pass'),
        elemClassList = this.classList,
        i = 0,
        pass = null;
    for (; i < passList.length; i++) {
        pass = passList[i];
        if (pass.getAttribute('type') === 'password') {
            pass.setAttribute('type', 'text');
        } else {
            pass.setAttribute('type', 'password');
        }
        if (elemClassList.contains('glyphicon-eye-close')) {
            this.classList.add('glyphicon-eye-open');
        }
        if (elemClassList.contains('glyphicon-eye-open')) {
            this.classList.add('glyphicon-eye-close');
        }
    }
    i = 0;
}

function days_between(date1, date2) {
    // The number of milliseconds in one day
    var ONE_DAY = 1000 * 60 * 60 * 24

    // Convert both dates to milliseconds
    var date1_ms = date1.getTime()
    var date2_ms = date2.getTime()

    // Calculate the difference in milliseconds
    var difference_ms = date1_ms - date2_ms

    // Convert back to days and return
    return Math.round(difference_ms / ONE_DAY)
}

var date_to_ask_for_date_picker;

function askForRoom(room_id) {
    $.ajax({
        type: 'GET',
        url: '/rooms/roomBookingData/' + room_id,
        success: function (data) {
            $("#ask_for_room").html("");
            $("#ask_for_room").html(data[1]);
            $("#ask_for_modal").modal("show");
            $("#loader_modal").modal("hide");
            $("#otherField").css('display', 'none');
            $("#referral").on('change', function () {
                if ($(this).val() == '¿Otro?') {
                    $("#otherField").css('display', 'block');
                } else {
                    $("#otherField").css('display', 'none');
                }
            });
            var min_days,
                max_days,
                days = getDates(6),
                daysFormated = getDateFormat(days);
            var otherDay = daysFormated[1],
                dayTomorrow = daysFormated[0],
                tourDate = 'Me gustaría ver la casa, tengo disponibilidad para verla la fecha: ' + otherDay,
                tourDateTomorrow = 'Me gustaría ver la casa, tengo disponibilidad para verla mañana: ' + dayTomorrow,
                optionsTomorrow = [],
                optionsOtherday = [],
                btnDays = [],
                tomorrowSelected = false,
                otherSelected = false;
            let i = 1,
                elem;
            for (; i <= 5; i++) {
                elem = document.querySelector('.btnDay' + i);
                elem.innerHTML = daysFormated[i - 1];
                btnDays.push(elem);
            }
            $('.lblOtherDay').html(daysFormated[1]);

            $('.cardTomorrow button').each(function (event) {
                $(this).on('click', function (event) {
                    if (!$(this).hasClass('btnSelected')) {
                        let sub;
                        tomorrowSelected = true;
                        if ($(this).hasClass('morning')) {
                            sub = 'mañana';
                            if (!optionsTomorrow.includes(sub)) {
                                optionsTomorrow.push(sub);
                            }
                        }
                        if ($(this).hasClass('afternoon')) {
                            sub = 'tarde';
                            if (!optionsTomorrow.includes(sub)) {
                                optionsTomorrow.push(sub);
                            }
                        }
                        if ($(this).hasClass('night')) {
                            sub = 'noche';
                            if (!optionsTomorrow.includes(sub)) {
                                optionsTomorrow.push(sub);
                            }
                        }
                    } else {
                        let sub;
                        if ($(this).hasClass('morning')) {
                            sub = 'mañana';
                            if (optionsTomorrow.includes(sub)) {
                                optionsTomorrow = arrayRemove(optionsTomorrow, sub);
                            }
                        }
                        if ($(this).hasClass('afternoon')) {
                            sub = 'tarde';
                            if (optionsTomorrow.includes(sub)) {
                                optionsTomorrow = arrayRemove(optionsTomorrow, sub);
                            }
                        }
                        if ($(this).hasClass('night')) {
                            sub = 'noche';
                            if (optionsTomorrow.includes(sub)) {
                                optionsTomorrow = arrayRemove(optionsTomorrow, sub);
                            }
                        }
                    }
                });
            });
            $('.cardOtherDay button').each(function (event) {
                $(this).on('click', function (event) {
                    if (!$(this).hasClass('btnSelected')) {
                        let sub;
                        if ($(this).hasClass('morning')) {
                            sub = 'mañana';
                            if (!optionsOtherday.includes(sub)) {
                                optionsOtherday.push(sub);
                            }
                        } else if ($(this).hasClass('afternoon')) {
                            sub = 'tarde';
                            if (!optionsOtherday.includes(sub)) {
                                optionsOtherday.push(sub);
                            }
                        } else if ($(this).hasClass('night')) {
                            sub = 'noche';
                            if (!optionsOtherday.includes(sub)) {
                                optionsOtherday.push(sub);
                            }
                        }
                    } else {
                        let sub;
                        if ($(this).hasClass('morning')) {
                            sub = 'mañana';
                            if (optionsOtherday.includes(sub)) {
                                optionsOtherday = arrayRemove(optionsOtherday, sub);
                            }
                        }
                        if ($(this).hasClass('afternoon')) {
                            sub = 'tarde';
                            if (optionsOtherday.includes(sub)) {
                                optionsOtherday = arrayRemove(optionsOtherday, sub);
                            }
                        }
                        if ($(this).hasClass('night')) {
                            sub = 'noche';
                            if (optionsOtherday.includes(sub)) {
                                optionsOtherday = arrayRemove(optionsOtherday, sub);
                            }
                        }
                    }
                });
            });
            $('.btnday0').html(daysFormated[0]);
            $(btnDays[0]).on('click', function (event) {
                otherDay = daysFormated[0];
                tourDate = 'Me gustaría ver la casa, tengo disponibilidad para verla la fecha: ' + otherDay;
                $('.cardOtherDay .btn').each(function (event) {
                    if ($(this).hasClass('btnSelected')) {
                        $(this).toggleClass('btnSelected');
                    }
                });
                $('.lblOtherDay').html(daysFormated[0]);
                $(this).toggleClass('btnSelected');
                if ($('.btnDay2').hasClass('btnSelected')) {
                    $('.btnDay2').toggleClass('btnSelected');
                }
                if ($('.btnDay3').hasClass('btnSelected')) {
                    $('.btnDay3').toggleClass('btnSelected');
                }
                if ($('.btnDay4').hasClass('btnSelected')) {
                    $('.btnDay4').toggleClass('btnSelected');
                }
                if ($('.btnDay5').hasClass('btnSelected')) {
                    $('.btnDay5').toggleClass('btnSelected');
                }
            });
            $(btnDays[1]).on('click', function (event) {
                otherDay = daysFormated[1];
                tourDate = 'Me gustaría ver la casa, tengo disponibilidad para verla la fecha: ' + otherDay;
                $('.cardOtherDay .btn').each(function (event) {
                    if ($(this).hasClass('btnSelected')) {
                        $(this).toggleClass('btnSelected');
                    }
                });
                $('.lblOtherDay').html(daysFormated[1]);
                $(this).toggleClass('btnSelected');
                if ($('.btnDay1').hasClass('btnSelected')) {
                    $('.btnDay1').toggleClass('btnSelected');
                }
                if ($('.btnDay3').hasClass('btnSelected')) {
                    $('.btnDay3').toggleClass('btnSelected');
                }
                if ($('.btnDay4').hasClass('btnSelected')) {
                    $('.btnDay4').toggleClass('btnSelected');
                }
                if ($('.btnDay5').hasClass('btnSelected')) {
                    $('.btnDay5').toggleClass('btnSelected');
                }
            });
            $(btnDays[2]).on('click', function (event) {
                otherDay = daysFormated[2];
                tourDate = 'Me gustaría ver la casa, tengo disponibilidad para verla la fecha: ' + otherDay;
                $('.cardOtherDay .btn').each(function (event) {
                    if ($(this).hasClass('btnSelected')) {
                        $(this).toggleClass('btnSelected');
                    }
                });
                $('.lblOtherDay').html(daysFormated[2]);
                $(this).toggleClass('btnSelected');
                if ($('.btnDay2').hasClass('btnSelected')) {
                    $('.btnDay2').toggleClass('btnSelected');
                }
                if ($('.btnDay1').hasClass('btnSelected')) {
                    $('.btnDay1').toggleClass('btnSelected');
                }
                if ($('.btnDay4').hasClass('btnSelected')) {
                    $('.btnDay4').toggleClass('btnSelected');
                }
                if ($('.btnDay5').hasClass('btnSelected')) {
                    $('.btnDay5').toggleClass('btnSelected');
                }
            });
            $(btnDays[3]).on('click', function (event) {
                otherDay = daysFormated[4];
                tourDate = 'Me gustaría ver la casa, tengo disponibilidad para verla la fecha: ' + otherDay;
                $('.cardOtherDay .btn').each(function (event) {
                    if ($(this).hasClass('btnSelected')) {
                        $(this).toggleClass('btnSelected');
                    }
                });
                $('.lblOtherDay').html(daysFormated[3]);
                $(this).toggleClass('btnSelected');
                if ($('.btnDay2').hasClass('btnSelected')) {
                    $('.btnDay2').toggleClass('btnSelected');
                }
                if ($('.btnDay3').hasClass('btnSelected')) {
                    $('.btnDay3').toggleClass('btnSelected');
                }
                if ($('.btnDay1').hasClass('btnSelected')) {
                    $('.btnDay1').toggleClass('btnSelected');
                }
                if ($('.btnDay5').hasClass('btnSelected')) {
                    $('.btnDay5').toggleClass('btnSelected');
                }
            });
            $(btnDays[4]).on('click', function (event) {
                otherDay = daysFormated[4];
                tourDate = 'Me gustaría ver la casa, tengo disponibilidad para verla la fecha: ' + otherDay;
                $('.cardOtherDay .btn').each(function (event) {
                    if ($(this).hasClass('btnSelected')) {
                        $(this).toggleClass('btnSelected');
                    }
                });
                $('.lblOtherDay').html(daysFormated[4]);
                $(this).toggleClass('btnSelected');
                if ($('.btnDay2').hasClass('btnSelected')) {
                    $('.btnDay2').toggleClass('btnSelected');
                }
                if ($('.btnDay3').hasClass('btnSelected')) {
                    $('.btnDay3').toggleClass('btnSelected');
                }
                if ($('.btnDay4').hasClass('btnSelected')) {
                    $('.btnDay4').toggleClass('btnSelected');
                }
                if ($('.btnDay1').hasClass('btnSelected')) {
                    $('.btnDay1').toggleClass('btnSelected');
                }
            });

            $('.buttonSelect > .btn').on('click', function (event) {
                $(this).toggleClass('btnSelected');
            });

            $("#make_booking").on('click', function (event) {
                event.preventDefault();
                if ($("#date_from_ask_for").val() == '' || $("#date_to_ask_for").val() == '') {
                    document.getElementById("date_error_booking").classList.remove("d-none");
                } else {
                    document.getElementById('make_booking_submit').click()
                }
            });
            if (data[2]) {
                if (days_between(new Date(data[2]), new Date()) > 0) {
                    min_days = new Date(data[2]);
                } else {
                    min_days = new Date();
                }
            } else {
                min_days = new Date();
            }
            max_days = min_days.addDays(parseInt(data[3]));
            $("#date_from_ask_for").datepicker({
                dateFormat: "yy-mm-dd",
                maxDate: max_days,
                minDate: min_days,
                showButtonPanel: true,
                beforeShowDay: function (date) {
                    let string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                    return [data[0].indexOf(string) == -1];
                }
            });
            $("#date_to_ask_for").datepicker({
                dateFormat: "yy-mm-dd",
                minDate: min_days,
                showButtonPanel: true,
                beforeShowDay: function (date) {
                    let string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                    return [data[0].indexOf(string) == -1];
                }
            });
            $(".datepickerTour").datepicker({
                dateFormat: "yy-mm-dd",
                minDate: days[0],
                showButtonPanel: true
            });

            $("#date_from_ask_for").on('focus', function () {
                $(".ui-datepicker-unselectable.ui-state-disabled.undefined").each(function () {
                    $(this).children().css("background-color", "white");
                    $(this).children().css("color", "#d4d4d48c");
                    $(this).removeClass('ui-state-disabled');
                    $(this).popover({
                        content: "Fuera del rango disponible para reservar",
                        placement: "bottom",
                    });
                    $(this).on('mouseenter', function () {
                        $(this).popover('show');
                    });
                    $(this).on('mouseleave', function () {
                        $(this).popover('hide');
                    });
                });
            });
            $("#date_from_ask_for").on('change', function (event) {
                let date_from = $("#date_from_ask_for").val();
                date_from = new Date(date_from);
                date_from = date_from.addDays(parseInt(data[4]));
                date_to_ask_for_date_picker = date_from;
                $("#date_to_ask_for").datepicker('option', 'minDate', date_to_ask_for_date_picker);
                $("#arrow_date_picker").data("toggle", "popover");
                $("#arrow_date_picker").data("placement", "bottom");
                $("#arrow_date_picker").data("content", "Puedes modificar la fecha limite de tu reserva");
                $("#arrow_date_picker").popover();
                $("#arrow_date_picker").popover('show');
            });
            $("#date_to_ask_for").on('click focus', function (event) {
                $("#arrow_date_picker").popover('hide');
                $(".ui-datepicker-unselectable.ui-state-disabled.undefined").each(function (event) {
                    $(this).children().css("background-color", "white");
                    $(this).children().css("color", "#d4d4d48c");
                    $(this).removeClass('ui-state-disabled');
                    $(this).popover({
                        content: "Fuera del rango disponible para reserva",
                        placement: "bottom",
                    });
                    $(this).on('mouseenter', function (event) {
                        $(this).popover('show');
                    });
                    $(this).on('mouseleave', function (event) {
                        $(this).popover('hide');
                    });
                });
            });

            $('#dropdownMenuButton').on('click', function (event) {
                $('.datepickerTour').show();
            });
            $(".datepickerTour").on('change', function (event) {
                $('.tomorrowPastDate').html($(this).val());
                $(this).hide();
            });
            /* Options to meet when user want to get a personal tour of the house*/
            /* activate options when option is selected */
            /* display: morning, afternoon, ealry night*/
            $('.optionChoose').each(function (event) {
                $(this).on('change', function (event) {
                    if ($(this).val() == 0) {
                        $('.dateButtons').toggleClass("d-none");
                    } else {
                        $('.dateButtons').toggleClass("d-none");
                    }
                });
            });
            $('#make_booking_submit').on('click', function (event) {
                let message = $('.contactMessage').val();

                // console.log(message);
                // message = filterMails(message, 3); //clear the emails on the message
                 // message = filterNumber(message, 1);
                if (optionsOtherday.length != 0 && optionsTomorrow.length != 0) {
                    $('input[name=message]').val(message + '\n' + formatTour(tourDateTomorrow, optionsTomorrow) + '\n' + formatTour(tourDate, optionsOtherday));
                } else if (optionsOtherday.length != 0) {
                    $('input[name=message]').val(message + '\n' + formatTour(tourDate, optionsOtherday));
                } else if (optionsTomorrow != 0) {
                    $('input[name=message]').val(message + '\n' + formatTour(tourDateTomorrow, optionsTomorrow));
                } else {
                    $('input[name=message]').val(message);
                }
            });
        }
    });
    Date.prototype.addDays = function (days) {
        var date = new Date(this.valueOf());
        date.setDate(date.getDate() + days);
        return date;
    }
}

function isShowView() {
    var url_path = window.location.pathname;
    url_path = url_path.split("/");
    url_path = url_path.slice(-1)[0];
    url_path = parseInt(url_path);

    if (!isNaN(url_path)) {
        $(".askForButton").each(function () {
            $(this).click(function () {
                var i = $(this).data("value");
                askForRoom(i);
            });
        });
    }
}

function register() {
    var dial = document.getElementsByClassName("selected-dial-code");
    var phone = document.getElementById("cellphone").value;
    $("#cellphone").value = dial[1].innerHTML + phone;
    $("#btnregister").click({
        utillsScript: "node_modules/intl-tel-input/build/js/utils.js"
    });
}

function registerManager() {
    var dial = document.getElementsByClassName("selected-dial-code");
    var phone = document.getElementById("manager-cellphone").value;
    $("#manager-cellphone").value = dial[1].innerHTML + phone;
    $("#manager-btnregister").click({
        utillsScript: "node_modules/intl-tel-input/build/js/utils.js"
    });
}
$(window).scroll(function (event) {
    var scroll = $(window).scrollTop();
    if (scroll <= 89) {
        $('#fomsearch').removeClass('col-12');
        $('#fomsearch').addClass('');
    } else if (scroll >= 89) {
        $('#fomsearch').removeClass('col-10');
        $('#fomsearch').addClass('');
    }
});

$(window).resize(function () {
    var $width = $(window).width();
    var $height = $(window).height();
    if ($width < 960) {
        var $map = $('#map-mobile');
        $('#mapa-desktop').hide();
        $('#mapa-movil').show();
        $('#vico-navbar').removeClass('sticky');
    } else {
        var $map = $('#map-desktop');
        $('#mapa-desktop').show();
        $('#mapa-movil').hide();
        $('#vico-navbar').addClass('sticky');
    }
    $map.height($height);
});
$(document).ready(function () {
    $('.checkboxmaxRooms').on('click', function () {
        if ($(this).is(':checked')) {
            $(this).parents().find('.maxRoomsButton').addClass('selected-button');
        }
    });
    $('.checkboxAvailableRooms').on('click', function () {
        if ($(this).is(':checked')) {
            $(this).parents().find('.maxRoomsButton').addClass('selected-button');
        }
    });
    $('.checkboxprivateBath').on('click', function () {
        if ($(this).is(':checked')) {
            $(this).parents().find('.privateBathButton').addClass('selected-button');
        }
    });
    $('.checkboxdateSort').on('click', function () {
        if ($(this).is(':checked')) {
            $(this).parents().find('.dateSortButton').addClass('selected-button');
        }
    });
    $('#alld').on('change', function () {
        $('.locationButton').addClass('selected-button');
    });
    $('#sliderPrice').on('change', function () {
        $('.priceButton').addClass('selected-button');
    });
    $('#datepickersearch').on('change', function () {
        $('.dateButton').addClass('selected-button');
    });
    $('.deleteFilters').click(function () {
        var checkboxes = $('input[type="radio"], input[type="checkbox"]');
        $.each(checkboxes, function (index, value) {
            value.checked = false;
            $(this).parents().find('.select-button').removeClass('selected-button');
        });
        $('#alld').val("");
        $('#sliderPriceButton').val("");
        $('#datepickersearch').val("");
    });
    $('.dropdown-menu').click(function (e) {
        e.stopPropagation();
    });
    var slider = document.querySelector("#sliderPrice");
    var output = document.querySelector("#sliderPriceValue");
    var outputButton = document.querySelector("#sliderPriceButton");
    if(slider && output && outputButton) {
        output.style.display = 'none';
        slider.oninput = function (e) {
            output.style.display = 'block';
            output.innerHTML = "$ " + (this.value).toLocaleString('de-DE');
            outputButton.value = (this.value).toLocaleString('de-DE');
        }
        slider.onmouseup = function () {
            output.style.display = 'none';
        }
    }
    var listaUsuarios = document.getElementById("lista-usuarios");
    var listaUsuariosHtml = '<option value="" selected disabled>-- Seleccione --</option>';
    $.ajax({
        url: '/countries.json',
        type: 'GET',
        async: "false"
    }).done(function (countries) {
        function SortByName(x, y) {
            return ((x.name == y.name) ? 0 : ((x.name > y.name) ? 1 : -1));
        }
        countries.sort(SortByName);
        for (var i = 0; i < countries.length; i++) {
            var element = countries[i];
            listaUsuariosHtml +=
                '<option value="' + element.id + '" data-icon="'+ element.icon+'">' + element.name + '</option>';
        }
        listaUsuarios.innerHTML = listaUsuariosHtml;
        document.getElementById("lista-usuariosCR").innerHTML = listaUsuarios.innerHTML;
        try {
            document.getElementById("manager-lista-usuarios").innerHTML = listaUsuarios.innerHTML;
        } catch (error) {
            //console.log("can't find manager lista usuarios")
        }
    });
    var showMore = 0;

    $('#showMoreButton').click(function () {
        if (showMore == 0) {
            $('#showMoreP').hide();
            showMore = 1;
        } else {
            $('#showMoreP').show();
            showMore = 0;
        }
    });
    $('#showMoreButton1').click(function () {
        if (showMore == 0) {
            $('#showMoreP1').hide();
            showMore = 1;
        } else {
            $('#showMoreP1').show();
            showMore = 0;
        }
    });
    $("#cellphone").intlTelInput({
        autoHideDialCode: false,
        autoPlaceholder: "off",
        dropdownContainer: "body",
        excludeCountries: ["us"],
        formatOnDisplay: false,
        geoIpLookup: function (callback) {
            $.get("//ipinfo.io", function () {}, "jsonp").always(function (resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        hiddenInput: "full_number",
        initialCountry: "auto",
        nationalMode: false,
        placeholderNumberType: "MOBILE",
        separateDialCode: true,
        utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.2/js/utils.js"
    });

    $("#cellphone-edit-profile").intlTelInput({
        autoHideDialCode: false,
        autoPlaceholder: "off",
        dropdownContainer: "body",
        excludeCountries: ["us"],
        formatOnDisplay: false,
        geoIpLookup: function (callback) {
            $.get("//ipinfo.io", function () {}, "jsonp").always(function (resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        hiddenInput: "full_number",
        initialCountry: "auto",
        nationalMode: false,
        placeholderNumberType: "MOBILE",
        separateDialCode: true,
        utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.2/js/utils.js"
    });

    $("#cellphoneCR").intlTelInput({
        autoHideDialCode: false,
        autoPlaceholder: "off",
        dropdownContainer: "body",
        excludeCountries: ["us"],
        formatOnDisplay: false,
        geoIpLookup: function (callback) {
            $.get("//ipinfo.io", function () {}, "jsonp").always(function (resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        hiddenInput: "full_number",
        initialCountry: "auto",
        nationalMode: false,
        placeholderNumberType: "MOBILE",
        separateDialCode: true,
        utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.2/js/utils.js"
    });

    $("#manager-cellphone").intlTelInput({
        autoHideDialCode: false,
        autoPlaceholder: "off",
        dropdownContainer: "body",
        excludeCountries: ["us"],
        formatOnDisplay: false,
        geoIpLookup: function (callback) {
            $.get("//ipinfo.io", function () {}, "jsonp").always(function (resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        hiddenInput: "full_number",
        initialCountry: "auto",
        nationalMode: false,
        placeholderNumberType: "MOBILE",
        separateDialCode: true,
        utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.2/js/utils.js"
    });

    var $width = $(window).width();
    var $height = $(window).height();
    if ($width < 960) {
        var $map = $('#map-mobile');
        $('#mapa-desktop').hide();
        $('#mapa-movil').show();
        $('#vico-navbar').removeClass('sticky');
    } else {
        var $map = $('#map-desktop');
        $('#mapa-desktop').show();
        $('#mapa-movil').hide();
    }
    $map.height($height);

    // $('.main-carousel').each(function(){
    //   $(this).flickity();
    // });
    // $('.datepicker').each(function(){
    //   $(this).datepicker({
    //     uiLibrary: 'bootstrap4',
    //     format: 'yyyy-mm-dd',
    //     keyboardNavigation: false
    //   });
    //   $(this).click(function(){
    //     $(this).parent().find("span button").click();
    //   });
    // });

    $("#datepickersearch").datepicker({
        dateFormat: "yy-mm-dd",
        minDate: new Date(),
        showButtonPanel: true
    });

    $('.dropdownStyled').each(function () {
        $(this).dropdown({
            uiLibrary: 'bootstrap4',
            width: 140
        })
    });
    $('.dropdownSoftStyled').each(function () {
        $(this).dropdown();
    });
    var width = $(document).width();
    var height = $(document).height();
    var length = width;
    var items = 3;
    var showMore = 0;
    if (length <= 540) items = 0;
    // Instantiate the Bootstrap carousel

    $('#showMoreButton').click(function () {
        if (showMore == 0) {
            $('#showMoreP').hide();
            showMore = 1;
        } else {
            $('#showMoreP').show();
            showMore = 0;
        }
    });
    $('.btn').each(function () {
        $(this).click(function () {
            $(document.body).css({
                'cursor': 'wait'
            });
            setTimeout("$(document.body).css({'cursor' : 'auto'})", 1000);
        });
    });

    //Open Datepicker by clicking the append
    $('.datepicker-button').click(function() {
        $('#' + $(this).data('input')).datepicker('show');
    })

});

const selectDefault = '<option value="" selected disabled>-- Seleccione --</option>';


async function refreshMessages() {
    let booking_id = $('input[name=bookings_id]').val();
    let show = '0'
    // if (window.location.href.includes("show")) {
    //     show = '1';
    // }
    try {
        let formData = {
            flag: show,
            id: booking_id,
            _token: $('meta[name="csrf-token"]').attr('content')
        };
        $.ajax({
                async: true,
                type: 'POST',
                url: '/booking/refresh_messages',
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: JSON.stringify(formData)
            })
            .done(function (data) {
                // console.log(data);
                $("#vico_chat").html(data);
                setTimeout(function () {
                    refreshMessages();
                    $("#sending_message").css("display", "none");
                }, 10000);
                // console.log('done');
            })
            .fail(function (data) {
                // console.log(data);
                // console.log('fail');
            });
    } catch (error) {
        // $("#sending_message").css("display", "block");
        // console.log(error);
    }
}

/* bookings show chat input functions */
/* this function evaluates the click on the send message button*/
/* bookings show chat input functions */
/* this function evaluates the click on the send message button*/

$('#btnMessage').on('focus', function (event) {
    $('#btnMessage').click();
});
$('#btnMessage').on('click', async function (event) {
    $("#sending_message").css("display", "block");
    var message = new String($('#chat-textarea').val());
    $('#chat-textarea').val(""); //clear the input chat
    //console.log("click"); //optional check
    // message = filterMails(message, 3); //clear the emails on the message
    // message = filterNumber(message, 1); //clear the bad words
    var formData = {
        'message': message,
        '_token': $('input[name=_token]').val(),
        'flag': $('input[name=flag').val(),
        'status': $('input[name=status]').val(),
        'booking_id': $('input[name=bookings_id]').val(),
        'read': $('input[name=read]').val()
    };
    $.ajax({
            async: true,
            type: 'POST',
            url: '/message/post',
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify(formData)
        })
        .done(function (data) {
            // console.log(data);
            // console.log('done');
        })
        .fail(function (data) {
            // console.log(data);
            // console.log('fail');
        });
    if (window.location.href.includes('booking/user') || window.location.href.includes('booking/show')) {
        refreshMessages();
    }
});

/* @param text: text to be email cleaned*/
function filterEmails(text) {
    let mytext = text.split(" ");
    //console.log(mytext);
    let myOutput = "";
    let re = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
    for (var i = 0; i < mytext.length; i++) {
        if (!re.test(mytext[i])) {
            myOutput += mytext[i] + "*";
        }
    }
    return myOutput;
}
/* @param text: text to be number cleaned*/ //Needs impkementationw
function filterNumbers(text) {
    let mytext = text.split(" ");
    let myOutput = "";
    let re = new RegExp(/^(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$/g);
    for (var i = 0; i < mytext.length; i++) {
        if (!re.test(mytext[i])) {
            myOutput += mytext[i] + "*";
        }
    }
    return myOutput;
}


if (window.File && window.FileReader && window.FileList && window.Blob) {
    // Great success! All the File APIs are supported.
} else {
    alert('The File APIs are not fully supported in this browser.');
}

let div_create = document.createElement("div");
div_create.setAttribute('class', 'loadersmall');

$("body").on("submit", "form", function () {
    let submited_button = $(this).find('button[type="submit"]');
    submited_button.attr('disabled', 'disabled');
    submited_button.replaceWith(div_create);
    $(this).submit(function () {
        return false;
    });
    return true;
});
/**
 * This function filters emails from the text, separates each token with
 * the regex that  matches a whitespace character (includes tabs and line breaks) and analize
 * it first the strictness level divided by 10 to get the input size and each token is tested
 * by match with the regex for emails.
 * Regular expression used by default is:
 * /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
 * @param {string} message Message that will be filtered
 * @param {number} level Strictness level.
 * @return {string} Message filtered, each matching is replaced with default '#!&%?' text
 */
function filterMails(message, level = 1, text = '#!&%?', regin = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/) {
    let input = new String(message),
        re = new RegExp(regin, 'g'),
        format = new RegExp(',', 'g'),
        split = input.split(new RegExp(/\s/)),
        i = 0,
        length = split.length,
        size = 0;
    output = new String();
    if (level === 3) {
        re = new RegExp(/[a-zA-Z\-0-9]+@+[a-zA-Z\-0-9]+/, 'g');
    }
    try {
        for (; i < length; i++) {
            size = split[i].length;
            if (size > 10 / level) {
                split[i] = split[i].replace(re, text);
            }
        }
    } catch (e) {
        console.error(e);
    } finally {
        input = new String(split);
        return new String(input.replace(format, ' '));
    }
}
/**
 * This functions filter numbers from a message, by default filters
 * numbers from 4 to 10 digits, thus are thinked as telephone numbers.
 * Yo can adjust the level of strictness to: 1 to 10 and 1 ahead.
 * Regular expression used by default is:/\+|\d{4,10}/
 * @param {string} message Message that will be filtered
 * @param {number} level Strictness level.
 * @return {string} Message filtered, each matching is replaced with default '#!&%?' text
 */
function filterNumber(message, level = false, text = '#!&%?', regin = /\+|\d{4,10}/) {
    let input = new String(message);
    let re = new RegExp(regin, 'g');
    if (level) {
        switch (level) {
            case 1:
                re = new RegExp(/\+|\d{3,10}/, 'g');
                break;
            case 2:
                re = new RegExp(/\+|\d{1,}/, 'g');
                break;
            default:
                console.error("El valor ingresado no corresponde a los parametros de entrada");
                return;
        }
    }
    return new String(input.replace(re, text));
}

function toggleContactUs() {
    let btnContact = document.querySelectorAll('#movilContacUs');
    let dropdownContact = document.querySelector('#dropdownNavContact');
    let dropdownClose = document.querySelector('.dropdown-nav-close');

    btnContact.forEach(btn => {
        btn.addEventListener('click', () => {
            dropdownContact.classList.add('open-dropdown');
            dropdownContact.scrollTop = 0;
        });

    });

    dropdownClose.addEventListener('click', () => {
        dropdownContact.classList.remove('open-dropdown');
    })
}

/**
 * Toggles background when the element, normally a button, fires a popover or a modal
 * Uses this as button context, if context is null it needs an input parametter to work.
 * Uses the aria-describedby value as id of the content that describes the context.
 * @param {*} $btnInput button input, used when no context defined or this === null
 * @param {*} $selector If provided, is used as the selector that fires the function
 * @param {*} $type class, id or tag. Id by default
 */
function toggleBackground($btnInput, $selector = false, $type = '#') {
    $('#btnIssues').click();
    var selector = false;
    if ($selector) {
        selector = $selector
    } else {
        if (this != null) {
            var length = this.attributes.length,
                attributes = this.attributes;
            if (attributes['aria-describedby'] != null) {
                selector = attributes['aria-describedby'].value;
            } else {
                var length = $btnInput.attributes.length,
                    attributes = $btnInput.attributes;
                if (attributes['aria-describedby'] != null) {
                    selector = attributes['aria-describedby'].value;
                }
            }
        }
    }
    if (selector) { //Element has aria-describedby
        let popover = document.querySelector($type + selector),
            elemHighlighter = document.createElement('div'),
            elemBack = document.createElement('div'),
            elemCover = document.createElement('div');

        elemHighlighter.classList.add('tuto-highlighter', 'active');
        elemBack.classList.add('tuto-background', 'active');
        elemCover.classList.add('tuto-cover', 'active');
        document.body.appendChild(elemBack);
        document.body.appendChild(elemCover);
        document.body.appendChild(elemHighlighter);
        popover.style.zIndex = '1110';
        this.style.zIndex = '1111';
        let observer = new MutationObserver(function (mutations) {
            if (!document.contains(popover)) {
                if (document.contains(elemBack)) {
                    document.body.removeChild(elemBack);
                    document.body.removeChild(elemCover);
                    document.body.removeChild(elemHighlighter);
                    observer.disconnect();
                }
            }
        });

        observer.observe(document, {
            attributes: true,
            childList: true,
            characterData: true,
            subtree: true
        });
    }
}


$(document).ready(function () {
    let btnShowPassList = document.querySelectorAll('.toggle-password'),
        i = 0,
        btnShowPass = null;
    var room;
    var roomid;
    var check;
    var modalDateFrom;
    var modalDateTo;
    //definePopover();
    room = document.getElementById("roomreserve");
    roomid = document.getElementById("room_id");
    modalDateFrom = document.getElementById("datefrom");
    modalDateTo = document.getElementById("dateto");
    var checkr = document.getElementsByClassName("askfor");
    check = '<?php echo $auth; ?>';
    for (; i < btnShowPassList.length; i++) {
        btnShowPass = btnShowPassList[i];
        btnShowPass.classList.add('glyphicon');
        btnShowPass.classList.add('glyphicon-eye-close');
        btnShowPass.addEventListener('click', togglePassword);
    }
    i = 0;
    if (check) {
        for (; i < checkr.length; i++) {
            checkr[i].setAttribute('data-target', '#AskFor');
            checkr[i].value = i + 1;
        }
        i = 0;
    } else {
        for (; i < checkr.length; i++) {
            checkr[i].setAttribute('data-target', '#Register');
            checkr[i].value = i + 1;
        }
        i = 0;
    }
    document.getElementById("CompleteRegister").addEventListener('click', function () {
        var dial = document.getElementsByClassName("selected-dial-code");
        var phone = document.getElementById("cellphoneCR").value;
        $("#cellphoneCR").value = dial[0].innerHTML + phone;
        $("#btnCR").click({
            utillsScript: "node_modules/intl-tel-input/build/js/utils.js"
        });
    });
    isShowView();
    if (window.location.href.includes('booking/user') || window.location.href.includes('booking/show')) {
        refreshMessages();
    }

    toggleContactUs();
});

$('#i18n').flagStrap({
    countries: {
        "CO": "",
        "US": "",
        "DE": "",
        "FR": ""
    }
});

$('#info-navbar .close-navbar').click(()=>{
    $('#info-navbar')
        .animate({height: 0}, 500,"linear",function()
                    {
                        $(this).remove();
                    }
                )
});

$('#send-phone-verification').click(()=>{
    $.ajax({
        type: 'GET',
        url: '/verification/phonecode',
        success:(data)=>{
            console.log(data);
            // Segment trancking
            verificatePhone();
        },
        error:(data)=>{
            console.log(data);

        }
    }).done(function (data){
        console.log(data);
    }).fail(function (data){
        console.log(data);
    });
});

$('#send-whatsapp-verification').click(()=>{
    $.ajax({
        type: 'GET',
        url: '/verification/whatsappcode',
        success:(data)=>{
            console.log(data);
            // Segment trancking
            verificateWpp();
        },
        error:(data)=>{
            console.log(data);

        }
    }).done(function (data){
        console.log(data);
    }).fail(function (data){
        console.log(data);
    });
});

$('#send-email-verification').click(()=>{
    $.ajax({
        type: 'GET',
        url: '/verification/email',
    });
    // SEGMENT tracking info
    verificateEmail();
    $('#email-sended').modal('toggle');

});

$('#phone_verify').on('submit',(event)=>{

    event.preventDefault();

    let input =$('input[name=phone_code]');
    let code = input.val();
    let type = 'phone_code';
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
            let verification = $('#verification-phone-response');
            if(data.success){
                verification.text(data.success);
                verification.css('color','green');
                input.removeClass('is-invalid');
                input.addClass('is-valid');

                $('#send-phone-verification').addClass('disabled');
                setTimeout(()=>{
                    $('#phone-verify').modal('toggle');
                },1500)

                // Segment trancking
                verificatePhone();
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

$('#whatsapp_verify').on('submit',(event)=>{
    event.preventDefault();
    let input =$('input[name=whatsapp_code]');
    let code = input.val();
    let type = 'whatsapp_code'

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
            let verification = $('#verification-whatsapp-response');
            if(data.success){
                verification.text(data.success);
                verification.css('color','green');
                input.removeClass('is-invalid');
                input.addClass('is-valid');
                $('#send-whatsapp-verification').addClass('disabled');
                setTimeout(()=>{
                    $('#whatsapp-verify').modal('toggle');
                },1500)
                // Segment trancking
                verificateWpp();
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

$('#sms-checkbox').click(function() {
    let whatsapp = $('#whatsapp-checkbox');
    if(whatsapp.prop('checked')){
        whatsapp.prop('checked',false);
    }
});

$('#whatsapp-checkbox').click(function() {
    let sms = $('#sms-checkbox');
    if(sms.prop('checked')){
        sms.prop('checked',false);
    }
});

if(window.location.hash === '#phone-card'){
    $('#phone-card').parent('.vico-card').addClass('add-highlight');
}
if(window.location.hash === '#email-card'){
    $('#email-card').parent('.vico-card').addClass('add-highlight');
}
if(window.location.hash === '#whatsapp-card'){
    $('#whatsapp-card').parent('.vico-card').addClass('add-highlight');
}
if(window.location.hash === '#id-card'){
    $('#id-card').parent('.vico-card').addClass('add-highlight');
}

$('#my-profile').click(()=>{
    let content = $('#profile-list');
    let arrow = $('#profile-arrow');
    arrow.toggleClass('add-rotateRightToDown',)

    content.slideToggle("slow",()=>{

    });

})

function initializeFlag() {
    setFlag($('#language').data('lang'));
}

function setFlag(lang) {
    let icon = '';

    switch (lang) {
    case 'en':
        icon = 'united-states-of-america.svg'
        break;
    case 'es':
        icon = 'colombia.svg';
        break;
    case 'de':
        icon = 'germany.svg';
        break;
    case 'fr':
        icon = 'france.svg';
        break;
    default:
        icon = "colombia.svg";
    }
    
    // set icon
    $('.btn-flag').attr("src","/images/flags/"+icon);
    }

setTimeout(() => {
    initializeFlag()
}, 1000);

//Function to show remaing caracters: 
//field = onkeyup, counter = span-id to show remainig chars, maxlimit, cuantos tienes todavía
function textCounter(field, counter, maxlimit) {
    var countfield = document.getElementById(counter);
    /* $(field2).html(text_remaining); */
    if (field.value.length > maxlimit) {
      field.value = field.value.substring(0, maxlimit);
      return false;
    } else {
      countfield.innerHTML ="Remaining characters : " + (maxlimit - field.value.length);
    }
  }

// SEGMENT---------------
function verificateWpp() {
    analytics.track('Verificate whastapp',{
        category: 'Verfications'
    });
}

function verificatePhone() {
    analytics.track('Verificate phone',{
        category: 'Verfications'
    });
}

function verificateEmail() {
    analytics.track('Verificate email',{
        category: 'Verfications'
    });    
}
  
$(document).ready(function () {
    let ReactDOM = require('react-dom');
    let React = require('react');
    let buttons = document.getElementsByClassName('openModalButton');
    let component;
    
    // function handleChange(roomId) {
    //     component.getComponentData(roomId);
    // }
    // (function loadModal() {
    //     let reservation = document.getElementById('react-rating'); 
        
        
    //     if(reservation){
    //         let modal = React.createElement(RateVicoModal, null,null);
    //         ReactDOM.render(modal,reservation);
    //     }
    // })();
})
//   $('.referralPaymentMethod').on('click',(event)=>{
//     event.preventDefault();    
//     $("#paymentModal").modal("hide"); 
//     let paymentType = event.target.dataset.name;
//     $.ajax({
//         type: 'POST',
//         dataType: 'json',
//         url: '/user/changePayment',
//         headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
//         data: {paymentType:paymentType},
//         cache: false,
//     });
//     document.getElementById('successful-change').classList.remove('d-none');
//     return false
//   });
