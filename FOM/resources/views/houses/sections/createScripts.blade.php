<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4_XvxW91t7uHIL6tzmacsoIX17gHUIgM" async defer></script>

<script>

    let customRules = [];
    let $customRules = document.querySelector("#rulesContainer");

    $('#validateCreateForm').click(function(event) {
        var fields = $(".verifiable")
        var complete = true;
        var i = 0;
        houseData = {};
        for (; i < fields.length; i++) {
            if(fields[i].required==true){
                if (fields[i].disabled!= true) {
                    if (fields[i].value== "") {
                        complete=false;
                        $('html, body').animate({
                        scrollTop: $('#'+fields[i].id).offset().top -100
                        }, 'slow');

                        $('#'+fields[i].id).focus();
                        $('#'+fields[i].id).addClass('invalid');
                        break;
                    }
                }
            }
        }
        i = 0;

        if (complete) {
            $("#createSubmit").click();
        }
    });

    function addCustomRule() {
        let value = document.querySelector('#customRule').value
        let elem  = document.createElement('li')
        let input = document.createElement('input')
        let text  = document.createTextNode(value);
        let delBtn = document.createElement('span');
        input.setAttribute('name',`customRule[]`);
        input.setAttribute('type','hidden');
        input.value = value;
        delBtn.classList.add('icon-close')
        delBtn.addEventListener('click', (e) => { delCustomRule(e) });
        elem.appendChild(text);
        elem.appendChild(delBtn);
        elem.appendChild(input);
        customRules.push(value);
        $customRules.appendChild(elem);
        document.querySelector('#customRule').value = "";
        console.log(customRules);
        
    }
    
    function delCustomRule(event) {
        let elem = event.target.parentNode;
        $customRules.removeChild(elem);
        customRules.splice(customRules.indexOf(elem.innerText),1);
        console.log(customRules);
    }

    let addRulesBtn = document.querySelector("#addCustomRule");
    var inputName = document.querySelector("#input-name");
    var address = document.querySelector("#address");
    var numBaths = document.querySelector("#num-baths");
    var numRooms = document.querySelector("#num-rooms");
    var aditionalAddress = document.querySelector("#aditionalAddress");
    var descriptionHouse = document.querySelector("#descriptionHouse");
    var extraDescription = document.querySelector("#extraDescription");
    // var rule2 = document.getElementById("rule2");
    // var rule4 = document.getElementById("rule4");
    var nickname = $(".nickname");
    let form = document.querySelector("#house-form");

    if(inputName) {
        inputName.onfocus = function() {
            showMoreInfo("infoStep1");
        }
        inputName.onblur = function() {
            showMoreInfo("infoStep1");
        }
    }
    if (descriptionHouse) {
        descriptionHouse.onfocus = function() {
            showMoreInfo("infoStep5");
        }
        descriptionHouse.onblur = function(){
            showMoreInfo("infoStep5");
        }
    }
    if (extraDescription) {
        extraDescription.onfocus = function() {
            showMoreInfo("infoStep6");
        }
        extraDescription.onblur = function() {
            showMoreInfo("infoStep6");
        }
    }
    if (numRooms) {
        numRooms.onfocus = function() {
            showMoreInfo("infoStep7");
        }
        numRooms.onblur = function(){
            showMoreInfo("infoStep7");
        }
    }
    if (numBaths) {
        numBaths.onfocus = function() {
            showMoreInfo("infoStep8");
        }
        numBaths.onblur = function() {
            showMoreInfo("infoStep8");
        }
    }

    addRulesBtn.addEventListener('click', () => {
        addCustomRule()
    }); 
    $("#editButton").click(function(event) {
        $("#optionalAddress").removeAttr('disabled');
        $("#optionalAddress").removeClass('bg-transparent');
        $("#optionalAddress").focus();
    });
    $("#optionalAddress").blur(function(event) {
        $("#optionalAddress").attr('disabled','true');
        $("#optionalAddress").addClass('bg-transparent');
    });

    $('.steps').waypoint(
        function(direction) {
            if(direction ==='down') {
                var wayID = $(this.element).attr('id');
            } else {
                var previous = $(this.element).prev();
                var wayID = $(previous).attr('id');
            }
            $('.current').addClass('stepname');
            $('.current').removeClass('current');

            $('#steps-nav a[href="#'+wayID+'"] .stepname').addClass('current');
            $('#steps-nav a[href="#'+wayID+'"] .stepname').removeClass('stepname');

        }, {
            offset: '25%'
        }
    );

    //Scroll animation
    $('.steps-nav a').click(function(e){
        e.preventDefault();   //evitar el eventos del enlace normal
        var strAncla=$(this).attr('href'); //id del ancla
        $('body,html').stop(true,true).animate({
            scrollTop: $(strAncla).offset().top -140
        }, 1000);
    });
    /** Load data from localstorage , lat, lang and nbgh**/
    function cargarDatos(){
        var datos = JSON.parse(localStorage.getItem('data'));        
        if(datos != null){
            var lat = datos.lat;
            var lng = datos.lng;
            var address = datos.address;
            var aditionalAddress = datos.info;
            var optionalAddress = datos.address;
            var ngbhId = datos.ngbhId;
            var newAddress = address + " " + aditionalAddress;
            let city=datos.city;
            let country=datos.country;
            let type = datos.type;
            
            document.querySelector("#lat").value = lat;
            document.querySelector("#lng").value = lng;
            document.querySelector("#address").value = address;
            document.querySelector("#neighborhood").value = ngbhId;
            document.querySelector("#city").value = city;
            document.querySelector("#country").value = country;
            document.querySelector("#aditionalAddress").value = aditionalAddress;
            document.querySelector("#optionalAddress").value = optionalAddress;
            document.querySelector("#newAddress").value = newAddress;
            document.querySelector("#typeHouse").value = type;
        }
    }
    function getCity() {
        return $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/api/city`,
            datatType: 'json',
            type: 'GET',
            success: function (response) {
                return response;
            },
            error: function (err) {
                // console.log(err);
            }
        });
    }

    function getSpecificInterestPoints(id) {
        return $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/api/specificInterestPoints/${id}`,
            datatType: 'json',
            type: 'GET',
            success: function (response) {
                return response;
            },
            error: function (err) {
                // console.log(err);
            }
        });
    }

    function getGenericInterestPoints(id) {
        return $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/api/genericInterestPoints`,
            datatType: 'json',
            type: 'GET',
            success: function (response) {
                return response;
            },
            error: function (err) {
                // console.log(err);
            }
        });
    }

    function loadGenericInterestPoints() {
        var getSpecificInterestPoints = getGenericInterestPoints();
        getSpecificInterestPoints.done((entries) => {
            var container = document.querySelector('#interestPoints'),
                button,
                text;
            Object.entries(entries).forEach((entrie) => {
                var name = entrie[0];
                var values = entrie[1];
                var value = entries[name];
                text = document.createTextNode(`+ ${name}`);
                button = document.createElement('button');
                button.setAttribute('type', 'button');
                button.setAttribute('class', 'btn btn-primary add-opacity m-1');
                button.addEventListener('click', function(event){
                    event.preventDefault();
                    addInterestPoint(name, values, false, this);
                });
                button.setAttribute('id', `btn${name}`);
                button.appendChild(text);
                container.appendChild(button);
            });
        });
    }
    function loadSpecificInterestPoints() {
        var datos = JSON.parse(localStorage.getItem('data')),
            city;
        if (datos != null) {
            city = datos['city'];
        }
        getSpecificInterestPoints = getSpecificInterestPoints(city);
        getSpecificInterestPoints.done((entries) => {
            var container = document.querySelector('#interestPoints'),
                button,
                text;
            Object.entries(entries).forEach((entrie) => {
                var name = entrie[0];
                var values = entrie[1];
                var value = entries[name];
                text = document.createTextNode(`+ ${name}`);
                button = document.createElement('button');
                button.setAttribute('type', 'button');
                button.setAttribute('class', 'btn btn-primary m-1 add-opacity');
                button.setAttribute('id', `btn${name}`);
                button.addEventListener('click', function(event){
                    event.preventDefault();
                    addInterestPoint(name, values, true, this);
                });
                button.appendChild(text);
                container.appendChild(button);
            });
        });
    }
    window.onload = function(){
        loadGenericInterestPoints();
        loadSpecificInterestPoints();
        cargarDatos();
        setCookie('isCreatingHouse', '', -1);
        localStorage.removeItem('isCreatingHouse');

        if (screen.width<800) {
            $('.navCreate').removeClass('sticky-top');
        } else {
            $('.navCreate').addClass('sticky-top');
        }
        // document.getElementById("moreInfoDescription").style.display = "none";
        $(".aditionalPrice").hide();
        // initMap();
    }
    //define a function to set cookies
    function setCookie(name,value,days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
    }

    $(".aditional").click(function(e) {

        var content = $("#aditionalPrice");
        var input = $("input[name=rule_3]");

        if(e.target.value == "0"){
            content.hide(500);
            input.prop("disabled","disabled");
        } else{
            content.show(500);
            input.removeAttr('disabled');
        }
    });

    function showMoreInfo(type) {

        var info = document.getElementById(type);
        if(info.style.display=="block"){
            info.style.display="none";
        } else{
            info.style.display="block";
        }
    }

    function delDescription(desc, actual) {
        var element = "#btn"+actual.id;
        $(element).show();
        desc.parentNode.removeChild(desc);
    }

    function addInterestPoint(name, values, specificInterestPoint, context) {

        // interestPoints[interestPoint.id] = interestPoint;

        var div = document.createElement('div'),
            p1 = document.createElement('p'),
            p2 = document.createElement('p'),
            select = document.createElement('select'),
            strong = document.createElement('strong'),
            container = document.querySelector('#cont-z-desc'),
            delBtn = document.createElement('span'),
            option;
            
        delBtn.classList.add('icon-close');
        delBtn.addEventListener('click',(e) => {
            let parent = e.target.parentNode;
            container.removeChild(parent);
            context.classList.toggle('d-none');
        })
        div.setAttribute('class', 'form-group create-zone-description py-4 my-2');
        div.setAttribute('id', `txt${name}`);

        p1.setAttribute('class', 'd-inline');
        strong.appendChild(document.createTextNode(`${name}:`));

        p1.appendChild(document.createTextNode(`El próximo ${name} queda a `));
        div.appendChild(p1);

        select.setAttribute('class', 'custom-select col-4 d-inline form-control-sm');
        select.setAttribute('id', `select${name}`);

        values.forEach((value) => {
            option = document.createElement('option');
            option.appendChild(document.createTextNode(value));
            select.appendChild(option);
        });

        if (specificInterestPoint) {
            select.setAttribute('name',`specificInterestPoints[${name}]`)
        } else {
            select.setAttribute('name',`genericInterestPoints[${name}]`)
        }

        div.appendChild(select);

        p2.setAttribute('class', 'd-inline col-6');
        p2.appendChild(document.createTextNode('minutos a pie.'));

        div.appendChild(p2);
        div.appendChild(delBtn);
        container.appendChild(div);

        context.classList.toggle('d-none');
    }
    function addDescription(desc,button) {
        console.log(desc, button);
        $(button).hide();
        // var descZone = document.getElementById("cont-z-desc");
        var descZone = $('#cont-z-desc');
        var encicla = document.getElementById("encicla-desc");
        // var universidad = document.getElementById("uni-desc");
        var universidad = document.getElementsByName('university');
        var gym = document.getElementById("gym-desc");
        var metroplus = document.getElementById("metroplus-desc");
        var centroComercial = document.getElementsByName("centroComercial");
        var bus = document.getElementById("bus-desc");
        var tranvia = document.getElementById("tranvia-desc");
        var metrocable = document.getElementById("metrocable-desc");
        var temp;
        var counterU = universidad.length+1;
        var counterC = centroComercial.length+1;
        switch(desc){
            case "GYM":
                $('#btnGimnasio').hide();
                if(gym == null){
                    // temp="<div class='form-group create-zone-description' id='gym-desc'>";
                    // temp+="<button type='button' class='close' aria-label='Close' onclick='delDescription(this.parentNode, this)' id='Gimnasio'><span aria-hidden='true'>&times;</span></button>";
                    // temp+="<p class='d-inline '><strong>Gimnasio:</strong> El próximo gimnasio queda a </p>";
                    // temp+="<input class='d-inline col-4 form-control form-control-sm' value='1' type='number' min='1' id='gym-minutes'>";
                    // temp+="<p class='d-inline col-6 '>min</p><select class='custom-select col-4 d-inline form-control-sm' id='gym-way'><option>a pie</option><option>en carro</option><option>en bus</option><option>en metroplus</option><option>en metro</option><option>en bicicleta</option></select></div>";
                    // descZone.innerHTML += temp;
                    // descZone.append(temp);
                }
            break;
            case "universidad":
                // $('#btnUniversidad').hide();
                // if(universidad==null){
                temp="<div class='form-group create-zone-description' name='university' id='uni-desc"+counterU+"'>"
                temp+="<button type='button' class='close' aria-label='Close' onclick='delDescription(this.parentNode, this)' id='Universidad"+counterU+"'><span aria-hidden='true'>&times;</span></button>";
                temp+="<p class='d-inline '><strong>Universidad:</strong></p>";
                temp+="<select class='form-control form-control-sm d-inline' name='close_to' id='u-name"+counterU+"' required>@foreach($schools as $school)<option value='{{ $school->gender }} {{$school->name}}'>{{ $school->gender }} {{ $school->name }}</option>@endforeach</select>";
                temp+="<p class='d-inline col-6'> queda a </p>";
                temp+="<input class='d-inline col-4 custom-select form-control-sm' value='1' type='number' id='u-minutes"+counterU+"' min='1'>";
                temp+="<p class='d-inline col-6 '>min</p><select class='custom-select col-4 d-inline form-control-sm' id='u-way"+counterU+"'><option>a pie</option><option>en carro</option><option>en bus</option><option>en metroplus</option><option>en metro</option><option>en bicicleta</option></select></div>";
                // descZone.innerHTML += temp;
                descZone.append(temp);
                // counter++;
                // }
            break;
            case "encicla":
                $('#btnCicla').hide();
                if(encicla==null){
                    // let enciclaPoint=<?php print json_encode($interestPoints->where('type_interest_point_id','=',3)) ?>;
                    enciclaPoint=Object.entries(enciclaPoint);
                    temp="<div class='form-group create-zone-description' id='encicla-desc'>";
                    temp+="<button type='button' class='close' aria-label='Close' onclick='delDescription(this.parentNode, this)' id='Cicla'><span aria-hidden='true'>&times;</span></button>";
                    temp+="<p class='d-inline '><strong>Encicla:</strong> La próxima estación de encicla es </p>";
                    temp+="<select class='col-6 custom-select form-control-sm d-inline' name='encicla-station' id='encicla-station' required>";
                    for (let index = 0; index < enciclaPoint.length; index++) {
                    temp+="<option value='"+enciclaPoint[index][1].name+"'>"+enciclaPoint[index][1].name+"</option>";
                    }
                    temp+="</select><p class='d-inline col-1 '>a</p>";
                    temp+="<input class='d-inline col-4 form-control form-control-sm' value='1' type='number' id='encicla-minutes' min='1'>";
                    temp+="<p class='d-inline col-6 '>min</p><select class='custom-select col-4 d-inline form-control-sm' id='encicla-way'><option>a pie</option><option>en carro</option><option>en bus</option><option>en metroplus</option><option>en metro</option><option>en bicicleta</option></select></div>";
                    // descZone.innerHTML += temp;
                    descZone.append(temp);
                }
            break;
            case "metroplus":
                $('#btnMetroplus').hide();
                if(metroplus==null){
                    // let metroPlusPoint=<?php print json_encode($interestPoints->where('type_interest_point_id','=',2)) ?>;
                    metroPlusPoint=Object.entries(metroPlusPoint);
                    temp="<div class='form-group create-zone-description' id='metroplus-desc'>";
                    temp+="<button type='button' class='close' aria-label='Close' onclick='delDescription(this.parentNode, this)' id='Metroplus'><span aria-hidden='true'>&times;</span></button>";
                    temp+="<p class='d-inline '><strong>Metroplus:</strong> La próxima estación de Metroplus es </p>";
                    temp+="<select class='col-6 custom-select form-control-sm d-inline' name='metroplus-station' id='metroplus-station' required>";
                    for (let index = 0; index < metroPlusPoint.length; index++) {
                    temp+="<option value='"+metroPlusPoint[index][1].name+"'>"+metroPlusPoint[index][1].name+"</option>";
                    }
                    temp+="</select><p class='d-inline col-1 '>a</p>";
                    temp+="<input class='d-inline col-4 form-control form-control-sm' value='1' type='number' id='metroplus-minutes' min='1'>";
                    temp+="<p class='d-inline col-6 '>min</p><select class='custom-select col-4 d-inline form-control-sm' id='metroplus-way'><option>a pie</option><option>en carro</option><option>en bus</option><option>en metro</option><option>en bicicleta</option></select></div>";
                    // descZone.innerHTML += temp;
                    descZone.append(temp);
                }
            break;

            case "centroComercial":
            // $('#btnCentroComercial').hide();
            // if(centroComercial==null){
                temp="<div class='form-group create-zone-description' name='centroComercial' id='centroComercial-desc"+counterC+"'>";
                temp+="<button type='button' class='close' aria-label='Close' onclick='delDescription(this.parentNode, this)' id='CentroComercial"+counterC+"'><span aria-hidden='true'>&times;</span></button>";
                temp+="<p class='d-inline '><strong>Centro comercial:</strong></p>";
                temp+="<input class='col-12 form-control-sm form-control verifiable' id='centroComercial-name"+counterC+"' required></input><p class='d-inline col-1 '>queda a</p>"
                temp+="<input class='d-inline col-4 form-control form-control-sm' value='1' type='number' id='centroComercial-minutes"+counterC+"' min='1'>";
                temp+="<p class='d-inline col-6 '>min</p><select class='custom-select col-4 d-inline form-control-sm' id='centroComercial-way"+counterC+"'><option>a pie</option><option>en carro</option><option>en bus</option><option>en metroplus</option><option>en metro</option><option>en bicicleta</option></select></div>";

                // descZone.innerHTML += temp;
                descZone.append(temp);
                // counter++;

            // }
            break;

            case "bus":
                $('#btnBus').hide();
                if(bus==null){
                    temp="<div class='form-group create-zone-description' id='bus-desc'>";
                    temp+="<button type='button' class='close' aria-label='Close' onclick='delDescription(this.parentNode, this)' id='Bus'><span aria-hidden='true'>&times;</span></button>";
                    temp += "<p class='d-inline '><strong>Bus:</strong> El próximo paradero para un bus queda a </p>";
                    temp += "<input class='d-inline col-4 form-control form-control-sm verifiable' placeholder='...' type='number' id='bus-minutes' min='1' required>.";
                    temp += "<p class='d-inline col-6 '>min a pie. </p>"
                    // temp += "<input type='text' id='bus-destination' class='form-control verifiable' required>.</div>";
                    descZone.append(temp);
                }
            break;

            case "tranvia":
                $('#btnTranvia').hide();
                if(tranvia==null){
                    temp="<div class='form-group create-zone-description' id='tranvia-desc'>";
                    temp+="<button type='button' class='close' aria-label='Close' onclick='delDescription(this.parentNode, this)' id='Tranvia'><span aria-hidden='true'>&times;</span></button>";
                    temp += "<p class='d-inline '><strong>Tranvia:</strong> La próxima estación del tranvia es </p>";
                    temp+="<select class='col-6 custom-select form-control-sm d-inline' id='tranvia-station' required><option>Alejandro Echavarría</option> <option>Bicentenario</option> <option>Buenos Aires</option> <option>Loyola</option> <option>Miraflores</option> <option>Oriente</option> <option>Pabellón del agua EPM</option> <option>San Antonio</option> <option>San José</option></select><p class='d-inline col-1 '>y queda a</p>"
                    temp += "<input class='d-inline col-4 form-control form-control-sm verifiable' placeholder='...' type='number' id='tranvia-minutes' min='1' required>";
                    temp+="<p class='d-inline col-6 '>min</p><select class='custom-select col-4 d-inline form-control-sm' id='tranvia-way'><option>a pie</option><option>en carro</option><option>en bus</option><option>en metro</option><option>en bicicleta</option></select></div>";
                    descZone.append(temp);
                }
            break;

            case "metrocable":
                $('#btnMetrocable').hide();
                if(metrocable==null){
                    temp="<div class='form-group create-zone-description' id='metrocable-desc'>";
                    temp+="<button type='button' class='close' aria-label='Close' onclick='delDescription(this.parentNode, this)' id='Metrocable'><span aria-hidden='true'>&times;</span></button>";
                    temp += "<p class='d-inline '><strong>Metrocable:</strong> La próxima estación del metrocable es </p>";
                    temp+="<select class='col-6 custom-select form-control-sm d-inline' id='metrocable-station' required><option>Acevedo</option> <option>Andalucía</option> <option>Arvi</option> <option>El Pinal</option> <option>Juan XXIII</option> <option>La Aurora</option> <option>Las Torres</option> <option>Miraflores</option> <option>Oriente</option> <option>Popular</option> <option>San Javier</option> <option>Santo Domingo Savio</option> <option>Trece de Noviembre</option> <option>Vallejuelos</option> <option>Villa Sierra</option></select><p class='d-inline col-1 '>y queda a</p>"
                    temp += "<input class='d-inline col-4 form-control form-control-sm verifiable' placeholder='...' type='number' id='metrocable-minutes' min='1' required>";
                    temp+="<p class='d-inline col-6 '>min</p><select class='custom-select col-4 d-inline form-control-sm' id='metrocable-way'><option>a pie</option><option>en carro</option><option>en bus</option><option>en metro</option><option>en bicicleta</option></select></div>";
                    descZone.append(temp);
                }
            break;
        }
    }
    function createDescription(){
        // descripciones obligatorias
        var metroStation = document.querySelector("#metro-station");
        var metroMinutes = document.querySelector("#metro-minutes");
        var metroWay = document.querySelector("#metro-way");
        var busMinutes = document.querySelector("#bus-minutes");
        var busDestination = document.querySelector("#bus-destination");
        var marketMinutes = document.querySelector("#market-minutes");
        var marketWay = document.querySelector("#market-way");

        // descripciones opcionales
        var enciclaMinutes = document.querySelector("#encicla-minutes");
        var enciclaStation = document.querySelector("#encicla-station");
        var enciclaWay = document.querySelector("#encicla-way");

        var uMinutes = document.querySelector("#u-minutes");
        var uWay = document.querySelector("#u-way");

        var tranviaStation = document.querySelector("#tranvia-station");
        var tranviaMinutes = document.querySelector("#tranvia-minutes");
        var tranviaWay = document.querySelector("#tranvia-way");

        var metrocableStation = document.querySelector("#metrocable-station");
        var metrocableMinutes = document.querySelector("#metrocable-minutes");
        var metrocableWay = document.querySelector("#metrocable-way");

        var centroComercialName = document.querySelector("#centroComercial-name");
        var centroComercialMinutes = document.querySelector("#centroComercial-minutes");
        var centroComercialWay = document.querySelector("#centroComercial-way");

        var gymMinutes = document.querySelector("#gym-minutes");
        var gymWay = document.querySelector("#gym-way");

        var metroplusStation = document.querySelector("#metroplus-station");
        var metroplusMinutes = document.querySelector("#metroplus-minutes");
        var metroplusWay = document.querySelector("#metroplus-way");

        var metrocable = document.querySelector("#metrocable-desc");
        var tranvia = document.querySelector("#tranvia-desc");
        var encicla = document.querySelector("#encicla-desc");
        var metroplus = document.querySelector("#metroplus-desc");
        var universidades = document.getElementsByName('university');
        var bus = document.querySelector("#bus-desc");
        // var centroComercialName = document.getElementById("centroComercial-name");
        // var centroComercialMinutes = document.getElementById("centroComercial-minutes");
        // var centroComercialWay = document.getElementById("centroComercial-way");

        var moreInfo = document.querySelector("#more-info");
        // var universidad = document.querySelector("#uni-desc");
        var gym = document.querySelector("#gym-desc");
        // var centroComercial = document.querySelector("#centroComercial-desc");
        var centroComerciales = document.getElementsByName("centroComercial");

        var infoDescription = document.querySelector("#info-description");
        var encicla = document.querySelector("#encicla-desc");
        var metroplus = document.querySelector("#metroplus-desc");
        var universidades = document.getElementsByName('university');
        var bus = document.querySelector("#bus-desc");

        // var universidad = document.querySelector("#uni-desc");
        var gym = document.querySelector("#gym-desc");
        var centroComercial = document.querySelector("#centroComercial-desc");
        var infoDescription = document.querySelector("#info-description");

        // direccion de la vico
        var direction = document.querySelector("#optionalAddress");
        var aditionalDirection = document.querySelector("#aditionalAddress");
        // var newAddress = document.querySelector("#newAddress");

        var extraDescription = document.querySelector('#extraDescription');
        var aditionalPrice = document.querySelector('#aditionalPriceField');
        var aditionalPriceAff = document.querySelector('#aditionalPriceAff');

        //servicios de la vico
        var vicoService = $(".vicoService");
        var submit = document.querySelector("#createSubmit");
        var description ="";

        description+="La proxima estación de Metro es "+metroStation.value+" a "+metroMinutes.value;
        description+= metroMinutes.value == "1" ? " minuto " : " minutos ";
        description+= metroWay.value+"."+"\n";
        description+="El próximo supermercado queda a "+marketMinutes.value;
        description+= marketMinutes.value == "1" ? " minuto " : " minutos ";
        description+= marketWay.value+"."+"\n";


        if(encicla != null){
            description+="La próxima estación de Encicla es "+enciclaStation.value+" a "+enciclaMinutes.value;
            description+= enciclaMinutes.value == "1" ? " minuto " : " minutos ";
            description+= enciclaWay.value+"."+"\n";
        }

        if(universidades.length >0){
            var i = 0;
            for (; i < universidades.length; i++) {
            var uni = universidades[i];
            description+= uni.childNodes[2].value+" queda a "+uni.childNodes[4].value;
            description+= uni.childNodes[4].value == "1" ? " minuto " : " minutos ";
            description+= uni.childNodes[6].value+"."+"\n";
            }
            i = 0;
        }

        if(gym != null){
            description+="El próximo gimnasio queda a "+gymMinutes.value;
            description+= gymMinutes.value == "1" ? " minuto " : " minutos ";
            description+= gymWay.value+"."+"\n";
        }

        if(metroplus != null){
            description+="La próxima estación de metroplus es "+metroplusStation.value+" a "+metroplusMinutes.value;
            description+= metroplusMinutes.value == "1" ? " minuto " : " minutos ";
            description+= metroplusWay.value+"."+"\n";
        }
        if(centroComerciales.length> 0){
            for(var i =0;i<centroComerciales.length;i++){
            var centCom = centroComerciales[i]
            description+="El centro comercial "+centCom.childNodes[2].value+" queda a "+centCom.childNodes[4].value;
            description+= centCom.childNodes[4].value == "1" ? " minuto " : " minutos ";
            description+= centCom.childNodes[6].value+"."+"\n";
            }
        }
        if(bus != null){
            description+= "El próximo paradero de bus queda a "+busMinutes.value;
            description+= busMinutes.value == "1" ? " minuto " : " minutos ";
            description+= "a pie."+"\n";
        }
        if(tranvia != null){
            description+= "La próxima estación de tranvia es "+tranviaStation.value+" y queda a " +tranviaMinutes.value;
            description+= tranviaMinutes.value == "1" ? " minuto " : " minutos ";
            description+= tranviaWay.value+"."+"\n";
        }
        if(metrocable != null){
            description+= "La próxima estación de metrocable es "+metrocableStation.value+" y queda a "+ metrocableMinutes.value;
            description+= tranviaMinutes.value == "1" ? " minuto " : " minutos ";
            description+= metrocableWay.value+"."+"\n";
        }
        description+=moreInfo.value;
        infoDescription.value = description;

        if (extraDescription.value == "") {
            extraDescription.innerHTML = "0";
        }

        if(aditionalPrice.disabled){
            aditionalPrice.disabled= false;
            $(".aditionalPrice").show();
            aditionalPrice.value= "0";
        }

        for(var i=0;i<vicoService.length;i++){
            if(vicoService[i].disabled != true){
                if(vicoService[i].checked){
                    vicoService[i].value = "1";
                } else{
                    vicoService[i].checked = true;
                    vicoService[i].value = "0";
                }
            }
        }
        if(descriptionHouse.value==''){
            descriptionHouse.value="sin descripción."
        }
        submit.click();
    }

    function saveData(){
        var inputsText = $('input[type=text]');
        var datosCreate =[];
        datosCreate.push(datoCreate);
    }
</script>
