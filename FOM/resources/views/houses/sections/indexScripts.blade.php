<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4_XvxW91t7uHIL6tzmacsoIX17gHUIgM" defer></script>
<script type="text/javascript">
  /** Variables globales **/
    var BOTON_ENTER = 13;
    var schools = [];
    var houses_address = [];
    var markers = [];
    var map;
    var isSafari;
    var isIphone;
    let maps_test;
    let currency;
    // let schoolsPoints;
    // let interestPoints;
    let zones = document.querySelectorAll('.checkZone');
    let schoolsNeighborhood = document.querySelectorAll('.checkSchools');
    let checkLocation = document.querySelector('#locationButton');
    let search = document.querySelector('#search');

    search.addEventListener('focus',(e)=>{
      let elem = document.querySelector('#locationSearch');
      elem.checked = false;
    });

    search.addEventListener('keyup',(e)=>{
      filterSchoolsNeighborhood(e.target.value);
    });

    checkLocation.addEventListener('click',(e)=>{
      
      let elem = document.querySelector('#locationSearch');
      elem.checked = !elem.checked;
    });

    zones.forEach((item)=>{
      item.addEventListener('click', (event)=>{
        selectSubCheckboxes(event);
        checkLocation.click();
      });
    });

    schoolsNeighborhood.forEach((item)=>{
      item.addEventListener('click', (event)=>{
        selectSchoolCheckboxes(event);
        checkLocation.click();
      });
    });
    $(document).ready(function(){
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
        var $width = $(window).width();
        var $height = $(window).height();
        var city = window.location.href.split('/')[4];
        if ($width < 1100) {
            var $map = $('#map-mobile');
            $('#mapa-desktop').hide();
            $('#mapa-movil').show();
            ajax_houses($width,city);
            $('#vico-navbar').removeClass('sticky');
            $('#filters').addClass('fixed-bottom');
        } else {
            var $map = $('#map-desktop');
            $(this).on('scroll',()=>{
                if($(this).scrollTop() >= $('#vico-navbar').offset().top ){
                    $map.height($height - $('#vico-navbar').height())
                } else {
                    $map.height($height - $('#mapa-desktop').offset().top)
                }
            });
            $('#filters').removeClass('fixed-bottom');
            $('#mapa-desktop').show();
            $('#mapa-movil').hide();
            ajax_houses($width,city);
        }
        $map.height($height);
        isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));
        isIphone =!!navigator.platform && /iPad|iPhone|iPod/.test(navigator.platform);
        if (isSafari || isIphone) {
            document.getElementById("alldSafari").classList.remove("d-none");
            // document.getElementById("alld").outerHTML = "";
        } else {
            // document.getElementById("alldSafari").outerHTML = "";
        }
        getFilters();
    });
    $(window).resize(function(){
      var $width = $(window).width();
      var $height = $(window).height();
      var city = window.location.href.split('/')[4];
      if($width < 1100){
        var $map = $('#map-mobile');
        $('#mapa-desktop').hide();
        $('#mapa-movil').show();
        ajax_houses($width,city);
        $('#vico-navbar').removeClass('sticky');
        $('#filters').addClass('fixed-bottom');
      } else {
        $('#filters').removeClass('fixed-bottom');
        var $map = $('#map-desktop');
        $('#mapa-desktop').show();
        $('#mapa-movil').hide();
        ajax_houses($width,city);
        $('#vico-navbar').addClass('sticky');
      }
      $map.height($height);
    });

    /**
    **  Función para guardar la búsqueda al hacer click en el botón con id=buscar
    **/
    $('#buscar').on('click',function(){
      saveSearch();
      fbq('track', 'Search',  {search_string: "index"});
      // event.preventDefault();
      // $( this ).off( event );
    });

    /**
    **  Función para hacer click al botón con id=buscar y guardar la búsqueda.
    **/
    $(".filter-button").on('click',function(){

      let filterNames = ['maxRoomsModal','availableRoomsModal','privateBathroomModal','enviromentModal',
      'houseType0Modal','houseType1Modal','houseType2Modal','otherFilters0Modal','otherFilters1Modal','otherFilters2Modal'];


      filterNames.forEach(element => {
        let filterOptions = document.querySelectorAll(`input[name='${element}']`);
        filterOptions.forEach(e=>{
          let name = e.name.replace('Modal','');
          let filter = document.querySelector(`input[name='${name}']`);
          if(e.checked){
            filter.value = e.value;
          } else {
            if(e.type === 'checkbox'){
              filter.removeAttribute('value');
            }
          }
        })
      });

      $('#buscar').click();
      saveSearch();
    });

    /**
    **  Función para realizar la búsqueda y guardar los filtros al hacer enter
    **/
    $(document.body).on('keypress',function(event){
      if(event.keyCode == BOTON_ENTER){ // Se escucha el botón enter del teclado, su código es 13
        $('#buscar').click();
        saveSearch();
      }//fin if
    });//fin función

    function getHouses(city) {
        return $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/api/houses/city/'+city,
            datatType: 'json',
            type: 'GET',
            success: function (response) {
                // console.log(response);
                // alert('Reglas cambiadas correctamente.');

            },
            error: function (err) {
                // console.log(err);
                // alert('No se pudieron realizar los cambios.\nPor favor, actualice la página nuevamente.');

            }
        });
    }

    function getHouse(id) {

        return $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/api/houses/${id}`,
            datatType: 'json',
            type: 'GET',
            success: function (response) {
                // console.log(response);
                // alert('Reglas cambiadas correctamente.');

            },
            error: function (err) {
                // console.log(err);
                // alert('No se pudieron realizar los cambios.\nPor favor, actualice la página nuevamente.');

            }
        });
    }



    function getCurrency(){

        return $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/api/currency`,
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

    /**
    **  Función que carga el Mapa
    ** @param width: longitud de la pantalla
    **/
    function ajax_houses($width,city) {
        houses = getHouses(city);
        try {
          houses.done((data)=> {
            currency = getCurrency();
            currency.done((data1) => {
                myMap($width, data, data1[0],city);
            });
          });
        } catch(e) {
          houses.done((data)=> {
            currency = getCurrency();
            currency.done((data1) => {
                myMap($width, data, data1[0],city);
            });
          });
        }
    }//fin ajax_houses

    /**
    *  Función que inicializa el Mapa
    *  @param width: Longitud de la pantalla
    *   @author Andrés Felipe Cano <andresfe98@gmail.com>
    **/
    function myMap($width, data_entry, currency,city) {
        //Context variables
        var iconBase,
            currency,
            myCenter,
            mapOptions,
            bounds,
            $map,
            mapCanvas,
            map;
        iconBase = '/images/vico_marker.png';
        // currency = {!!json_encode($currency)!!};
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': city}, function(results, status) {
        if (status === 'OK') {
            map.setCenter(results[0].geometry.location);
            map.setZoom(12)
             //Opciones que tendrá el mapa, según api de google maps
        } else {
            console.log('Geocode was not successful for the following reason: ' + status);
        }
        });
        bounds = new google.maps.LatLngBounds(); //Límites que tendrá el mapa
        if($width < 767){ //Mapa para resoluciones más pequeñas
            $map = document.getElementById('map-mobile'); //Elemento en el que será cargado el mapa
            mapCanvas = $map;
        }//fin if
        else{ //Para resoluciones de pantalla más grandes
            $map = document.getElementById('map-desktop'); //Elemento en el que será cargado el mapa
            mapCanvas = $map;
        }//fin else

        map = new google.maps.Map(mapCanvas, mapOptions); //Se carga el mapa con su elemento y sus opciones
        maps_test=map;        
        data_entry.forEach(function(entry){          
            //Out of context variables
            let house,
                idCarousel,
                latlng,
                priceMin,
                contentString,
                infoWindow,
                marker,
                houseContainer;
            house = entry.house;
            idCarousel = house.id;
            latlng = {
                lat: Number(entry.coordinates.lat), //Se obtiene la latitud
                lng: Number(entry.coordinates.lng) //Se obtiene la longitud
            };            
            if( currency) {
                priceMin = Number(entry.min_price * currency.value).toLocaleString('de-DE'); //Precio de la casa que irá en el mapa, representado por punto;
                contentString = `
                <div id="marker_content_${house.id}">
                    <a href="/houses/${house.id}" target="_blank">
                        <h3 id="firstHeading" class="firstHeading">${house.name}</h3>
                        <div id="bodyContent">
                            <p style="font-color: #3a3a3a">{{trans('houses/index.from')}}: $ ${entry.minPrice} ${currency.code}{{trans('houses/index.month')}}<br>
                                <a target="_blank" href="/houses/${house.id}">{{trans('houses/index.click_see_more')}} ...</a>
                            </p>
                        </div>
                    </a>
                </div>`; //Contenido html que se mostrará en cada marcador (infowindow)
            } else {
                priceMin = Number(entry.min_price).toLocaleString('de-DE'); //Precio de la casa que irá en el mapa, representado por punto;
                contentString = `
                <div id="marker_content_${house.id}">
                    <a href="/houses/${house.id}" target="_blank">
                        <h3 id="firstHeading" class="firstHeading">${house.name}</h3>
                        <div id="bodyContent">
                            <p style="font-color: #3a3a3a">{{trans('houses/index.from')}}: $ ${entry.minPrice} COP{{trans('houses/index.month')}}<br>
                                <a target="_blank" href="/houses/${house.id}">{{trans('houses/index.click_see_more')}} ...</a>
                            </p>
                        </div>
                    </a>
                </div>`; //Contenido html que se mostrará en cada marcador (infowindow)
            }
            infoWindow = new google.maps.InfoWindow({
                content: contentString
            });// Google infowindow instance with custom content
            marker = new google.maps.Marker({
                map: map,
                position: latlng,
                draggable: false,
                icon: iconBase
            });//Google marker instance with custom content

            bounds.extend(marker.position); //Extends google bounds

            marker.addListener('click', function(event){
                infoWindow.open(map, marker);
            }); //Add event lsitener to marker to open infoWindow on map

            infoWindow.addListener('mouseout', function(event){
                infoWindow.close(map, marker);
            }); //Add event lsitener to marker to open infoWindow on map

            markers.push(marker);

            houseContainer = document.querySelector('#house-container' + idCarousel);
            if (houseContainer) {
                houseContainer.addEventListener('mouseover', function(event){
                    infoWindow.open(map, marker);// Open infowindow when mouse over on map
                });
                houseContainer.addEventListener('mouseout', function(event){
                    infoWindow.close(map, marker);// Open infowindow when mouse over on map
                });
            }
        });

        /**
         * Function when widht < 570
         **/
        if($width > 570){
            map.fitBounds(bounds); //Tell map to fit on new bounds
        }//fin if
    }//Fin MyMap

    /**
    **  Función que guarda los filtros al hacer la búsqueda
    **/
    function saveSearch(){

      let schools = [];
      let zones = [];
      document.querySelectorAll('input[id^="school"]').forEach((elem)=>{
        if(elem.checked){ schools.push(elem.value) }
      });

      document.querySelectorAll('input[id^="zone"]').forEach((elem)=>{
        if(elem.checked){ zones.push(elem.value) }
      });

      var dateSearch = document.getElementById('datepickersearch').value; // Valor de la fecha
      var maxPrice = document.getElementById('sliderPriceButton').value; // Valor del precio
      var available_rooms = document.getElementsByName('availableRoomsModal'); // Filtro de habitaciones disponibles
      var max_rooms = document.getElementsByName('maxRoomsModal'); // Filtro del máximo de habitaciones
      var private_bathroom = document.getElementsByName("privateBathroomModal"); // Filtro del baño privado

      let enviroment_filter = document.querySelector('input[name="enviroment"]').value;
      let houseType0 = document.querySelector('input[name="houseType0"]').value;
      let houseType1 = document.querySelector('input[name="houseType1"]').value;
      let houseType2 = document.querySelector('input[name="houseType2"]').value;

      let otherFilters0 = document.querySelector('input[name="otherFilters0"]').value;
      let otherFilters1 = document.querySelector('input[name="otherFilters1"]').value;
      let otherFilters2 = document.querySelector('input[name="otherFilters2"]').value;

      var sort_by = document.getElementsByName('sortBy'); // Filtro ordenar por clasificación
      var maxRooms = 0; // Valores por defecto
      var availableRooms = 0;
      var privateBathroom = -1;
      var sortBy = 0;
      var filterData;

      for(var i = 0;i < available_rooms.length; i++){ // Se recorre el filtro de habitaciones disponibles
        if((available_rooms[i].checked) && (available_rooms[i].value >= availableRooms)){
          availableRooms = available_rooms[i].value;
        }//fin if
      }//fin for

      for(var i = 0; i < max_rooms.length; i++){ // Se recorre el filtro de máximo de habitaciones
        if((max_rooms[i].checked) && (max_rooms[i].value >= maxRooms)){
          maxRooms = max_rooms[i].value;
        }//fin if
      }//fin for

      for(var i = 0; i <sort_by.length; i++){ // Se recorren los elementos de {{trans('houses/index.order_by')}} clasificación
        if((sort_by[i].checked) && (sort_by[i].value >= sortBy)){
          sortBy = sort_by[i].value;
        }//fin if
      }//fin for

      for(var i=0;i<private_bathroom.length;i++){ // Se recorren los elementos del filtro del baño
        if(private_bathroom[i].checked && private_bathroom[i].value >= privateBathroom){
          privateBathroom=private_bathroom[i].value;
        }//fin if
      }//fin for
      filterData = {
        'schools':schools,
        'zones':zones,
        'dateSearch': dateSearch,
        'maxPrice':maxPrice,
        'availableRooms':availableRooms,
        'maxRooms':maxRooms,
        'privateBathroom':privateBathroom,
        'enviroment':enviroment_filter,
        'houseType0':houseType0,
        'houseType1':houseType1,
        'houseType2':houseType2,
        'otherFilters0':otherFilters0,
        'otherFilters1':otherFilters1,
        'otherFilters2':otherFilters2,
        'sortBy':sortBy
      }; //Se guardan los elementos seleccionados en la variable filterData

      localStorage.setItem("filterData",JSON.stringify(filterData)); //Se guarda la variable, en formato json, en el localstorage del navegador
    }//fin savesearch

    /** Función para obtener los filtros guardados
    **  Esta función nos modifica los filtros guardados en local storage y guarda estos datos en los inputs correspondientes, y cambia los
    **  estilos de los botones correspondientes.
    **/
    function getFilters(){

      var filterData = localStorage.getItem("filterData"); //Obtener item desde localstorage
      var available_rooms = document.getElementsByName('availableRoomsModal'); //Habitaciones disponibles
      var private_bathroom = document.getElementsByName('privateBathroomModal'); //Opciones de baño privado
      var enviroment = document.getElementsByName('enviromentModal'); //Opciones de ambiente
      var sort_by = document.getElementsByName('sortBy'); //Opciones de ordenamiento por criterio
      var checkedButton = 0; //Bandera para los filtros de habitaciones disponibles
      var max_rooms = document.getElementsByName('maxRoomsModal'); // Filtro del máximo de habitaciones

      let houseType0 = document.querySelector('input[name="houseType0Modal"]');
      let houseType1 = document.querySelector('input[name="houseType1Modal"]');
      let houseType2 = document.querySelector('input[name="houseType2Modal"]');

      let otherFilters0 = document.querySelector('input[name="otherFilters0Modal"]');
      let otherFilters1 = document.querySelector('input[name="otherFilters1Modal"]');
      let otherFilters2 = document.querySelector('input[name="otherFilters2Modal"]');



      filterData= JSON.parse(filterData); //Se hace el casting a json
      // if(filterData.schoolOrNeighborhood != "" && filterData.schoolOrNeighborhood != undefined){  //Filtro: Ubicación
      //   if(isSafari || isIphone){
      //     var schoolOrNeighborhood = document.getElementById('alldSafari');
      //     for(var i=0;i<schoolOrNeighborhood.length;i++){
      //       if(schoolOrNeighborhood[i].value == filterData.schoolOrNeighborhood){
      //         schoolOrNeighborhood[i].selected=true;
      //       }
      //     }
      //   }
      //   else{
      //     document.getElementById('alld').value=filterData.schoolOrNeighborhood;                    //Actualización del valor
      //   }
      //   document.getElementById('locationButton').classList.add('selected-button');               //Modificación del estilo del botón
      // }//fin if

      filterData.zones.forEach((zoneNumber)=>{
        document.querySelector(`input[name=zone${zoneNumber}]`).click();
      });

      filterData.schools.forEach((schoolNumber)=>{
        document.querySelector(`input[name=school${schoolNumber}]`).click();
      });

      if(filterData.dateSearch != "" && filterData.dateSearch != undefined){                      //Filtro: Fecha
        document.getElementById('datepickersearch').value=filterData.dateSearch;                  //Actualización del valor
        document.getElementById('dateButton').classList.add('selected-button');                   //Modificación del estilo
      }//fin if

      if(filterData.maxPrice != "" && filterData.maxPrice != undefined){                          //Filtro: Precio
      document.getElementById('sliderPriceButton').value=filterData.maxPrice;                     //Actualización del valor
        document.getElementById('priceButton').classList.add('selected-button');                  //Modificación del estilo del botón
      }//fin if

      if(filterData.privateBathroom != -1 && filterData.privateBathroom != undefined){            //Filtro: Baño
        // document.getElementById('privateBathButton').classList.add('selected-button');         //Modificación del estilo del botón
        for(var i=0;i<private_bathroom.length;i++){ //Se recorren las opciones
          private_bathroom[i].checked=false;
          if(filterData.privateBathroom == private_bathroom[i].value){ //Se accede si la opción está guarada
            private_bathroom[i].checked=true;
          }//fin if
        }//fin for
      }//fin if

      if(filterData.enviroment != -1 && filterData.enviroment != undefined){
        for(let i=0;i<enviroment.length;i++) {
          enviroment[i].checked=false;
          if(filterData.enviroment == enviroment[i].value){
            enviroment[i].checked=true;
          }
        }
      }

      if(filterData.sortBy != "" && filterData.sortBy != undefined){                              //Filtro: Ordenamiento por criterio
        document.getElementById('dateSortButton').classList.add('selected-button');               //Modificación del estilo del botón
        for(var i=0;i<sort_by.length;i++){  //Se recorren todas las opciones
          sort_by[i].checked=false;
          if(filterData.sortBy == sort_by[i].value){  //Marca la opción guardada
            sort_by[i].checked=true;
          }//fin if
        }//fin for
      }//fin if
      if(filterData.availableRooms != "" && filterData.availableRooms != undefined){
        for(var i=0;i<available_rooms.length;i++){  //Filtro: Habitaciones disponibles
          available_rooms[i].checked=false;
            if(filterData.availableRooms == available_rooms[i].value){ //La condición se cumple cuando el valor obtenido es el mismo
            available_rooms[i].checked=true;
            if(checkedButton == 0){ //Se verifica la bandera para hacer el proceso solo una vez
              document.getElementById('maxRoomsButton').classList.add('selected-button');           //Modificación del estilo del botón
              checkedButton = 1; //Cambia el valor de la bandera
            }//fin if
          }//fin if
        }//fin for
      }

      if (filterData.houseType0 !== "") {
        houseType0.checked = true;
      }
      if (filterData.houseType1 !== "") {
        houseType1.checked = true;
      }
      if (filterData.houseType2 !== "") {
        houseType2.checked = true;
      }
      if (filterData.otherFilters0 !== "") {
        otherFilters0.checked = true;
      }
      if (filterData.otherFilters1 !== "") {
        otherFilters1.checked = true;
      }
      if (filterData.otherFilters2 !== "") {
        otherFilters2.checked = true;
      }

      for(var i=0;i<max_rooms.length;i++){ //Filtro: Número de habitaciones en total
        max_rooms[i].checked=false;
        if(filterData.maxRooms === max_rooms[i].value){ //La condición se cumple cuando el valor obtenido es el mismo
          max_rooms[i].checked=true;
          if(checkedButton == 0){ //Se verifica la bandera para hacer el proceso solo una vez
            document.getElementById('maxRoomsButton').classList.add('selected-button');           //Modificación del estilo del botón
            checkedButton = 1; //Cambia el valor de la bandera
          }//fin if
        }//fin if
      }//fin for
    }//fin getFilters

    /**
     * Funcion que selecciona los barrios asociados a una zona
     * @param {event} - Evento click asociado al checkbox de una zona
     */
    function selectSubCheckboxes(event){
      
      let item = event.target.parentNode.parentNode;
      let list = item.querySelectorAll('li');
      let isCheked = item.querySelector('div').querySelector('input').checked;
         
      for (let item of list) {
        item.querySelector('input').checked = isCheked;
      }
    }

    /**
     * Funcion que selecciona los barrios asociados a una universidad
     * @param {event} - Evento click asociado al checkbox de una universidad
     */
    function selectSchoolCheckboxes(event){
      let neighborhoods = JSON.parse(event.target.dataset.neighborhood);
      let isChecked = event.target.checked;

      neighborhoods.forEach((elem)=>{
        document.querySelector(`#neighborhood${elem}`).checked = isChecked;
      });
    }

    /**
     * Funcion para filtar los barrios y las universidades de acuerdo al criterio de busqueda
     * @param {str} - String que representa el criterio de busqueda
     */
    function filterSchoolsNeighborhood(str){
      let cadena = str.toLowerCase();
      let schools = document.querySelectorAll('label[for^=school]');
      let neighborhoods = document.querySelectorAll('label[for^=neighborhood]');

      schools.forEach((e)=>{e.parentNode.classList.add('d-none')});
      neighborhoods.forEach((e)=>{e.parentNode.classList.add('d-none')});

      neighborhoods.forEach((e)=>{
        if(e.innerText.toLowerCase().indexOf(cadena) != -1){
          e.parentNode.classList.remove('d-none');
        }
      });

      schools.forEach((e)=>{
        if(e.innerText.toLowerCase().indexOf(cadena) != -1){
          let myNeighborhoods = document.querySelector(`#${e.getAttribute('for')}`).dataset.neighborhood;
          e.parentNode.classList.remove('d-none');

          // JSON.parse(myNeighborhoods).forEach((e)=>{            
          //   document.querySelector(`#neighborhood${e}`).parentNode.classList.remove('d-none');
          // })
        }
      });  
    }
</script>

@if (Auth::check())
    <script type="text/javascript">
        $(document).ready(function(){
            $('.ajaxSubmitLike').click(function(e){
            var submit = e.target;
            var house_id = submit.parentNode.parentNode.id;
            house_id = house_id.substr(15,house_id.length-1);
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            if (submit.className.indexOf("favorite-house") > -1) {
                submit.className = "fas fa-heart ajaxSubmitLike btn-favorite";
                $.ajax({
                url: '/houses/favorites/delete',
                type: 'DELETE',
                data: {
                    _token: CSRF_TOKEN,
                    user_id: {{ Auth::user()->id }},
                    house_id:	house_id},
                    success: function (data) {
                        if (data != 1) {
                            submit.className += " favorite-house";
                        }
                    }
                });    
            } else {
                submit.className += " favorite-house";
                $.ajax({
                url: '/houses/favorites/post',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    user_id: {{Auth::user()->id}},
                    house_id:	house_id},
                    success: function (data) {
                        if (data!=1) {
                            submit.className = "fas fa-heart ajaxSubmitLike btn-favorite";
                        }
                    }
                });
            }
            });
        });
    </script>
@endif
