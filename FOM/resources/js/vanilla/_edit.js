let id_booking_editing = 0,
    id_room_editing_price = 0;

$(function() {
    $('.edit-item').on('click', function (event) {
        $(this).toggleClass('edit-item-selected');
    });

    $('.arrow-container').on('click', function (event) {
        $(this).find('i').toggleClass('arrow-container-selected');
    });
    $(".info_dates").each(function () {
        $(this).css("display", "block");
    });


    $(".edit_booking_btn").each(function () {
        $(this).on('click', function () {
            $("#description_room_" + $(this).val()).hide();
            $("#description_bookings_" + $(this).val()).show();
        });
    });

    $(".back_booking").each(function () {

        $(this).on('click', function () {
            $("#description_room_" + $(this).val()).show();
            $("#description_bookings_" + $(this).val()).hide();
        });
    });

    $("#newHomemateDateFrom").datepicker({
        beforeShow: function (input, inst) {
            setTimeout(function () {
                inst.dpDiv.css({
                    top: '155px',
                    left: '14%'
                });
            }, 0);
        },
        dateFormat: "yy-mm-dd",
        minDate: 0,
        showButtonPanel: true
    });

    $("#newHomemateDateTo").datepicker({
        beforeShow: function (input, inst) {
            setTimeout(function () {
                inst.dpDiv.css({
                    top: '155px',
                    left: '14%'
                });
            }, 0);
        },
        dateFormat: "yy-mm-dd",
        minDate: 0,
        showButtonPanel: true
    });

    $("#new_date_booking").datepicker({
        beforeShow: function (input, inst) {
            setTimeout(function () {
                inst.dpDiv.css({
                    top: '155px',
                    left: '14%'
                });
            }, 0);
        },
        dateFormat: "yy-mm-dd",
        showButtonPanel: true
    });
    $(".edit_booking_date").each(function () {
        $(this).on('click', function () {
            id_booking_editing = $(this).val();
            $("#new_date_booking").val($("#date_to_" + id_booking_editing).val());
            $("#edit_date_booking_modal").modal('show');
        });
    });

    $(".edit_price_room").each(function () {
        $(this).on('click', function () {
            $("#current_price_room").html("$" + $(this).attr('price') + " COP");
            id_room_editing_price = $(this).val();
            $("#new_price_room").val($(this).attr('price'));
            $("#edit_price_room_modal").modal('show');
        });
    });

    $("#upload_price_room").on('click', function () {
        $("#alert_upload_price").modal('show');
        $("#edit_price_room_modal").modal('hide');
    });


    $("#upload_date_booking").on('click', function () {
        $("#alert_upload_date").modal('show');
        $("#edit_date_booking_modal").modal('hide');
    });

    $("#confirm_upload_price").on('click', function () {
        let new_price = $("#new_price_room").val(),
            CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/rooms/updatePriceRoom',
            type: 'POST',
            data: {
                _token: CSRF_TOKEN,
                new_price: new_price,
                room_id: id_room_editing_price
            },
            success: function (data) {
                if (data) {
                    $("#edit_price_room_modal").modal('hide');
                    $("#price_room_" + id_room_editing_price).html(new_price + " COP");
                    $("#price_room_" + id_room_editing_price + "_2").html('<span id="price_room_{{$room->id}}">Cuesta <span class="">$' + new_price + '</span> COP</span>');
                    $("#title_room_price_" + id_room_editing_price).html(new_price);
                    $("#info_price_room_" + id_room_editing_price).attr('price', new_price);
                    alert('Precio guardado correctamente');
                }
            },
            error: function (err) {
                // console.log(err);
                alert('No se pudieron realizar los cambios.\nPor favor, actualice la página nuevamente.');

            }
        });
    });

    $("#confirm_upload").on('click', function () {
        let new_date = $("#new_date_booking").val(),
            CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $("#date_to_" + id_booking_editing).val(new_date);
        $.ajax({
            url: '/booking/updateDateTo',
            type: 'POST',
            data: {
                _token: CSRF_TOKEN,
                new_date: new_date,
                booking_id: id_booking_editing
            },
            success: function (data) {
                if (data) {
                    $("#edit_date_booking_modal").modal('hide');
                    $("#date_to_" + id_booking_editing).val(new_date);
                    alert('Fecha guardada correctamente');
                }
            },
            error: function (err) {
                // console.log(err);
                alert('No se pudieron realizar los cambios.\nPor favor, actualice la página nuevamente.');

            }
        });
    });

    $(".accordion_room").each(function () {
        $(this).collapse('hide');
    });

    $('.info_dates').each(function () {
        $(this).popover({
            title: "Disponibilidad",
            trigger: "click",
            placement: 'bottom',
            html: true,
            content: function () {
                return $("#" + $(this).attr('id') + '_popover').html();
            }
        });
    });


    function confirmDevices(element) {
        // if (confirm('¿Esta seguro de cambiar los equipos de la VICO?'))
        if (true) {

            let devices = $("input[id^='device_']"),
                jsonDevices = [],
                i = 0;
            for (; i < devices.length; i++) {

                jsonDevices.push({
                    'id': devices[i].id,
                    'checked': !(devices[i].value == 0)
                });
            }

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `/houses/editnew/devices/store`,
                datatType: 'json',
                type: 'POST',
                data: {
                    'house_id': $('input[name=house_id]').val(),
                    'devices': jsonDevices
                },
                success: function (response) {
                    // console.log(response);
                    alert("Dispositivos guardados correctamente.");

                },
                error: function (err) {
                    console.log(err);
                    alert('No se pudieron realizar los cambios.\nIntenta actualizar la página.');

                }
            });
        }
    }

    function confirmRules(element) {

        if (confirm('¿Esta seguro de cambiar las reglas de la VICO?')) {

            let rules = $("input[id^='rule_']"),
                jsonRules = [],
                i = 0;

            for (; i < rules.length; i++) {

                jsonRules.push({
                    'id': rules[i].id,
                    'checked': rules[i].checked
                });

            }

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `/houses/editnew/rules/store`,
                datatType: 'json',
                type: 'POST',
                data: {
                    'house_id': $('input[name=house_id]').val(),
                    'rules': jsonRules
                },
                success: function (response) {
                    // console.log(response);
                    alert('Reglas cambiadas correctamente.');

                },
                error: function (err) {
                    // console.log(err);
                    alert('No se pudieron realizar los cambios.\nPor favor, actualice la página nuevamente.');

                }
            });
        }
    }

    function confirmUpload(element) {
        $('.confirm-upload').css('display', 'block');
        $(element).parent().css('display', 'none');

    }

    function onclick_device(element) {
        element = $(this.parentNode);
        $(this).toggleClass('add-selected');
        if ($(this).hasClass('add-selected')) {
            $(element).prev().val('1');
        } else {
            $(element).prev().val('0');
        }
    }


    $('.saveDevices').on('click', function (event) {
        confirmDevices($(this));
        $('.editDevices').toggleClass('d-none');
        $(this).toggleClass('d-none');
        $('.vico-show-equipos').off('click', onclick_device);
        $('.vico-show-equipos').toggleClass('item-blocked');

    });

    $('.editDevices').on('click', function (event) {
        $('.saveDevices').toggleClass('d-none');
        $(this).toggleClass('d-none');
        $('.vico-show-equipos').on('click', onclick_device);
        $('.vico-show-equipos').toggleClass('item-blocked');
    });


    $('.saveHouseDesc').on('click', function (event) {
        event.preventDefault();
        $('.editHouseDesc').toggleClass('d-none');
        $('.txtHouseDesc').attr('contenteditable', 'false');
        $('.txtHouseDesc').toggleClass('item-blocked');
        $('input[name=description_house]').val($('.txtHouseDesc').text());
        $('input[name=description_zone]').val($('.txtNghbDesc').text());
        $(this).toggleClass('d-none');
        $('#postHouseDescription').submit();

    });

    $('.editHouseDesc').on('click', function (event) {
        $('.saveHouseDesc').toggleClass('d-none');
        $('.txtHouseDesc').attr('contenteditable', 'true');
        $('.txtHouseDesc').toggleClass('item-blocked');
        $(this).toggleClass('d-none');
    });

    $('.saveNghbDesc').on('click', function (event) {
        event.preventDefault();
        $('.editNghbDesc').toggleClass('d-none');
        $('.txtNghbDesc').attr('contenteditable', 'false');
        $('.txtNghbDesc').toggleClass('item-blocked');
        $('input[name=description_house]').val($('.txtHouseDesc').text());
        $('input[name=description_zone]').val($('.txtNghbDesc').text());
        $(this).toggleClass('d-none');
        $('#postHouseDescription').submit();
        alert('Descripción del barrio guardado correctamente');
    });

    $('.editNghbDesc').on('click', function (event) {
        $('.saveNghbDesc').toggleClass('d-none');
        $('.txtNghbDesc').attr('contenteditable', 'true');
        $('.txtNghbDesc').toggleClass('item-blocked');
        $(this).toggleClass('d-none');
    });

    $('#postHouseDescription').on('submit', function (event) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/houses/editnew/vico`,
            datatType: 'json',
            type: 'POST',
            data: {
                'description_house': $('input[name=description_house]').val(),
                'description_zone': $('input[name=description_zone]').val(),
                'house_id': $('input[name=house_id]').val()
            },
            success: function (response) {
                alert('Descripción de la casa guardada correctamente');

            },
            error: function (err) {
                alert('No se pudieron realizar los cambios.\nPor favor, actualice la página nuevamente.');

            }
        });
        event.preventDefault();
    });

    $('.edit-item').on('click', function (event) {

        let arrow = $(this).children('.arrow');
        arrow.children('.arrow-container').toggleClass('rotate-deg-90');
    });

    $('#postManagerDescription').on('submit', function (event) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/houses/editnew/manager`,
            datatType: 'json',
            type: 'POST',
            data: {
                'manager_id': $('input[name=manager_id]').val(),
                'manager_name': $('input[name=manager_name]').val(),
                'manager_description': $('#manager_description').val(),
                'house_id': $('input[name=house_id]').val()
            },
            success: function (response) {
                alert('Información guardad correctamente');

            },
            error: function (err) {
                console.error(err);
                alert('No se pudieron realizar los cambios.\nPor favor, actualice la página nuevamente.');

            }
        });
        event.preventDefault();
    });

    $('#send-changes').click(function (e) {
        let newRooms = document.getElementById('new-rooms'),
            newBaths = document.getElementById('new-baths'),
            newType = document.getElementById('new-type'),
            newAddress = document.getElementById('new-address'),
            message = document.getElementById('why-message'),
            $house_id = $('input[name=house_id]').val(),
            $house_name = $('input[name=house_name]').val(),
            $manager_id = $('input[name=manager_id').val(),
            $manager_name = $('input[name=manager_name').val(),
            $manaher_desc = $('input[name=manager_description]').val(),
            $oldRooms = $('input[name=oldRooms]').val(),
            $oldBaths = $('input[name=oldBaths]').val(),
            $oldType = $('input[name=oldType]').val(),
            $oldAddress = $('input[name=oldAddress]').val(),
            CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content'),
            houseInfo = {
                "house_id": $house_id,
                "house_name": $house_name,
                "house_owner_id": $manager_id,
                "house_owner_name": $manager_name
            },
            newInfo = {
                "newRooms": newRooms.value,
                "newBaths": newBaths.value,
                "newType": newType.value,
                "newAddress": newAddress.value,
                "message": message.value
            },
            oldInfo = {
                "OldRooms": $oldRooms, //"{{ $house->rooms_quantity }}",
                "OldBaths": $oldBaths, //"{{ $house->baths_quantity }}",
                "OldType": $oldType, //"{{ $house->type }}",
                "OldAddress": $oldAddress, //"{{ $house->address }}"
            };
        if (newRooms.value == "" && newBaths.value == "" && newType.value == $oldType && newAddress.value == "") {
            alert("No se han realizado cambios.");
        } else {
            if (message.value == "") {
                alert("Necesitas agregar una razón para hacer los cambios.");
            } else {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `/houses/edit/post`,
                    datatType: 'json',
                    type: 'POST',
                    data: {
                        houseInfo: houseInfo,
                        newInfo: newInfo,
                        oldInfo: oldInfo
                    },
                    success: function (response) {
                        if (response == 1) {
                            $("#modal-changes").modal('hide');
                            alert("Su petición ha sido enviada. Se le notificará si el cambio ha sido aceptado");
                        } else {
                            $("#modal-changes").modal('hide');
                            alert('No se pudieron realizar los cambios.\nPor favor, actualice la página nuevamente.');
                        }
                    },
                    error: function (err) {
                        console.error(err);
                        alert('No se pudieron realizar los cambios.\nPor favor, actualice la página nuevamente.');

                    }
                });
            }
        }
    });



    function cambiar() {
        let pdrs = document.querySelector('#file-upload-edit').files[0].name;
        document.getElementById('info-edit').innerHTML = pdrs;
    }

    $('#file-upload-edit').on('change', cambiar);

    function onclick_img(element) {

        $(element).toggleClass('selected-red');

        if ($(element).hasClass('selected-red')) {
            $(element).prev().val('1');
        } else {
            $(element).prev().val('0');
        }

    }

    function confirmDelete(element) {
        try {
            if (confirm('Está seguro de borrar las imagenes')) {
                $(element).next().click();
            }
            return true;
        } catch (e) {
            console.error(e);
            return false;

        }
    }

    $('.gender-male-roomie').each(function () {
        $(this).on('click', function () {

            if (!$(this).hasClass('add-selected') && !$('.gender-female-roomie').hasClass('add-selected')) {
                $(this).addClass('add-selected');
                $(this).parent().prev().val(1);
            } else {
                $('.gender-female-roomie').removeClass('add-selected');
                $(this).addClass('add-selected');
                $(this).parent().prev().val(1);
                $('.gender-female-roomie').parent().prev().val(0);
            }
            if ($(this).parent().prev().val() === 1 && !$(this).hasClass('add-selected')) {
                $(this).addClass('add-selected');
            }
        });
    })


    $('.gender-female-roomie').each(function () {
        $(this).on('click', function () {

            if (!$(this).hasClass('add-selected') && !$('.gender-male-roomie').hasClass('add-selected')) {
                $(this).addClass('add-selected');
                $(this).parent().prev().val(1);
            } else {
                $('.gender-male-roomie').removeClass('add-selected');
                $(this).addClass('add-selected');
                $(this).parent().prev().val(1);
                $('.gender-male-roomie').parent().prev().val(0);
            }
            if ($(this).parent().prev().val() === 1 && !$(this).hasClass('add-selected')) {
                $(this).addClass('add-selected');
            }
        });
    })



    $(".edit_booking_homemate").on('click', async function () {
        let bookingId = $(this).val();
        let infoBooking = await fetch('/houses/editnew/getBookingInfo', {
            method: 'post',
            credentials: "same-origin",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify({
                booking_id: bookingId,
                _token: $('meta[name="csrf-token"]').attr('content')
            })
        }).then((resp) => resp.json());
        $("#editRoomieUserID").val(infoBooking.user_id);
        $("#deleteUserID").val(infoBooking.user_id);
        $("#editRoomieBookingID").val(infoBooking.id);
        $("#deleteBookingId").val(infoBooking.id);
        $("#editRoomieName").val(infoBooking.name_user);
        $("#editRoomieCountry").val(infoBooking.country_id_user);
        $("#editRoomieDateFrom").each(function () {
            $(this).datepicker({
                beforeShow: function (input, inst) {
                    setTimeout(function () {
                        inst.dpDiv.css({
                            top: '155px',
                            left: '14%'
                        });
                    }, 0);
                },
                dateFormat: "yy-mm-dd",
                minDate: 0,
                showButtonPanel: true
            });
        });
        $("#editRoomieDateTo").each(function () {
            $(this).datepicker({
                beforeShow: function (input, inst) {
                    setTimeout(function () {
                        inst.dpDiv.css({
                            top: '155px',
                            left: '14%'
                        });
                    }, 0);
                },
                dateFormat: "yy-mm-dd",
                minDate: 0,
                showButtonPanel: true
            });
        });
        $("#editRoomieDateFrom").val(infoBooking.date_from);
        $("#editRoomieDateTo").val(infoBooking.date_to);
        $("#editRoomieRoom").val(infoBooking.room_id);
        if (infoBooking.gender_user === 1) {
            $("#editRoomieGenderMale").val(1);
        } else {
            $("#editRoomieGenderFemale").val(1);
        }
        if ($("#editUpdateRoomieModal").modal('show')) {
            console.log($('#editRoomieGenderMale').next().children()[0]);
            if ($('#editRoomieGenderMale').val() == 1) {
                $('#editRoomieGenderMale').next().children()[0].classList.add('add-selected');
            }

            if ($('#editRoomieGenderFemale').val() == 1) {
                $('#editRoomieGenderFemale').next().children()[0].classList.add('add-selected');
            }
        };
    });

    $(".edit-add-roomie-modal").on("click", function () {
        let roomId = $(this).attr('value-room');
        $("#addNewRommieSelect").val(roomId);
    });

    $('#btnConfirmDeleHomemate').click(function () {
        $('#editUpdateRoomieModal').modal('toggle');
    });

    $('#closeConfirmDeleteHomemate').click(function () {
        $('#editUpdateRoomieModal').modal('toggle');
    });

});
