@extends('layouts.app')

@section('title', 'Añadir ubicación')

@section('styles')

@endsection

@section('content')

  <div class="create">
    <div class="col-md-8 col-12 mx-md-auto create-vico">
      {{--MAP COLUMN--}}
      <div class="row steps">

        {{-- STEP NUMBER AND NAME --}}

        <div class="col-12 ">
          <div class="row">
            <div class="col-2 col-sm-1 num-icon">
              <span class="display-2 d-inline"><strong>1</strong></span>
            </div>

            <div class="col-10 col-sm-11">
              <h4 class="bold">¿CÚAL ES LA DIRECCIÓN DE TU VICO?</h4>
            </div>
          </div>
        </div>
        {{-- STEP NUMBER AND NAME --}}



        <div class="col-12">
          <form class="form" action="{{route('create_house', 1)}}" method="get">
            {{csrf_field()}}
            {{-- <input type="hidden" name="house_id" value="{{$house->id}}"> --}}
            
            {{-- ADDRESS INPUT--}}
            <div class="input-group pt-3 pb-3 ">
              <input type="text" class="form-control verifiable" placeholder="Calle 34 # 45b - 72" id="address" required >
              <div class="input-group-append">
                  <button type="button" class="btn btn-outline-primary form-control ">Buscar</button>
                </div>
            </div>
            {{-- END ADDRESS INPUT--}}

            {{--CHEK COMPLETE DIRECTION--}}
            <div class="pb-3">
                <p id="infoStep3-1" class="mb-0 mt-2 font-italic">
                    Agrega información adicional (Nombre de la urbanización, Número del apto) en el segundo campo:
                  </p>
              {{--ADITIONAL ADDRESS BOX--}}
              <div class="input-group pt-3 pb-3 ">
                <input type="text" class="form-control verifiable" placeholder="Edificio Los Colores, Apto 22 interior 3b" id="aditionalAddress" autofocus>
                <div class="input-group-append">
                    <button type="button" class="btn btn-outline-primary form-control ">Guardar</button>
                  </div>
              </div>

{{--               <div class="input-group">
                <input type="text" placeholder="Edificio Los Colores, Apto 22 interior 3b" id="aditionalAddress" class="verifiable form-control mt-2" required autofocus>
              </div> --}}
              {{-- END ADITIONAL ADDRESS BOX--}}

            </div>
            {{--CHEK COMPLETE DIRECTION END--}}

            {{-- MAP --}}
            <div class="form-group row">
              <div class="well map-container" id="map" style="width:100%;height:20em;"></div>
            </div>
            {{-- END MAP --}}



            {{--VICO ZONE BOX--}}
                   {{-- STEP NUMBER AND NAME --}}
        <div id="step2" class="row">
          <div class="col-12 ">
            <div class="row">
              <div class="col-2 col-sm-1 num-icon">
                <span class="display-2 d-inline"><strong>2</strong></span>
              </div>

              <div class="col-10 col-sm-11">
                <h4 class="bold">¿DONDE ESTA UBICADA TU VICO?</h4>
              </div>
            </div>
          </div>
        </div>
        {{-- STEP NUMBER AND NAME --}}

          <div class="col-12">
              <div class="input-group mt-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="country">País</label>
                  </div>
                  <select id="country" class="custom-select verifiable" required>
                      <option value="" selected disabled>-- Seleccione --</option>
                      @foreach($countries as $country)
                        <option value='{{ $country->id }}'@if($loop->first) @endif>{{ $country->name }}</option>
                      @endforeach
                  </select>
              </div>
              <div class="input-group mt-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="country">Ciudad</label>
                  </div>
                  <select id="city" class="custom-select verifiable" required>
                    <option value="" selected disabled>-- Seleccione --</option>
                    @foreach($countries as $country)
                      @foreach ($country->cities as $city)
                        <option value='{{ $city->id }}'@if($loop->first) @endif>{{ $city->name }}</option>                          
                      @endforeach
                    @endforeach
                  </select>
              </div>
              <div class="input-group mt-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="country">Barrio</label>
                  </div>
                  <select id="neighborhoodSelect" class="custom-select verifiable" required>
                    <option value="" selected disabled>-- Seleccione --</option>
                    {{-- @foreach($neighborhoods as $neighborhood)
                      <option value='{{ $neighborhood->id }}'@if($loop->first) @endif>{{ $neighborhood->name }}</option>
                    @endforeach --}}
                  </select>
                 
              </div>
           
          </div>
            {{--VICO ZONE BOX--}}

            {{-- SUBMIT BUTTONS --}}
            <button type="button" id="validateCreateForm" class="btn btn-primary btn-block button-space my-3 " >Continuar</button>

            <button type="button" id="modalCreateConfirm" class="d-none" data-toggle="modal" data-target="#modalConfirm"></button>

            <button type="submit" id="createSubmit" class="btn btn-primary btn-block button-space d-none"></button>
            {{-- END SUBMIT BUTTONS --}}
          </form>
        </div>
      </div>
      {{--END MAP COLUMN--}}
    </div>
    {{-- END STEP 3 --}}

    {{-- MODAL CONFIRM --}}

    <div class="modal fade" style="overflow:scroll" id="modalConfirm" tabindex="-1" role="dialog" aria-labelledby="modalConfirmTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">¡Muchas gracias!</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>¿Estas seguro que la ubicación está correcta? Por favor revisa si la posición que aparece en el mapa concuerda con la ubicacíon de tu VICO.</p>
            <div class="well map-container" id="mapModal" style="width:100%;height:25em;"></div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary check" data-dismiss="modal">No, Quiero revisar</button>
            <button type="button" class="btn btn-primary" id="btn-continue">Si, estoy seguro</button>
          </div>
        </div>
      </div>
    </div>
    {{-- END MODAL CONFIRM --}}


  @endsection

  @section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4_XvxW91t7uHIL6tzmacsoIX17gHUIgM" async defer></script>

    <script>

    var btnContinue = document.getElementById("btn-continue");
    var address = document.getElementById('address');
    var lat;
    var lng;
    var address;
    var info;
    var ngbhId=document.getElementById('neighborhoodSelect');    
    let country=document.getElementById('country');
    let city=document.getElementById('city');
    let stepTwo=document.getElementById('step2');
    let labelNeighborhood=document.getElementById('labelNeighborhood');
    let labelCity=document.getElementById('labelCity');
    let labelCountry=document.getElementById('labelCountry');
    var map,map2;

    window.onload = function(){
      getUserPosition();
      events();
    }

    function events(){

      address.addEventListener('blur',setGeocode);
      btnContinue.addEventListener('click', createData);
      city.addEventListener('change',cityChanged);
    }

    /** Save data to localstorage, inputs= lat, lang and ngbh**/
    function guardarDatos(){

      ngbhId = document.getElementById('neighborhoodSelect').value;
      city=document.getElementById('city').value;
      country=document.getElementById('country').value;
      info = document.getElementById('aditionalAddress').value;
      address = document.getElementById('address').value;

      let datos = {};

      datos.lat = lat;
      datos.lng = lng;
      datos.address = address;
      datos.ngbhId = ngbhId;
      datos.city = city;
      datos.country = country;
      datos.info = info;
      
      console.log(datos);
      localStorage.clear();
      localStorage.setItem("data", JSON.stringify(datos));
    }

    /** Load data from localstorage , lat, lang and nbgh**/
    // function cargarDatos(){
    //   var datos = JSON.parse(localStorage.getItem('data'));
    //   if(datos != null){
    //     for (var i = 0; i < datos.length; i++){
    //       var option = document.createElement("option");
    //       option.text = datos[i];
    //       lista.add(option);
    //     }

    //   }
    // }    

    function getUserPosition(){
      var startPos;
      var geoOptions = {
        maximumAge: 5 * 60 * 1000,
      }
      var geoError = function(error) {
        console.log('Error occurred. Error code: ' + error.code);
        switch (error.code) {
          case 1:
            startPos = {coords:{latitude:0,longitude:0}};
            initMap(startPos,13);
            let city = getCity();
            city.done((data) => {              
              getCoordsByCityName(data[0].name);
            });
            break;
        
          default:
            break;
        }
        // error.code can be:
        //   0: unknown error
        //   1: permission denied
        //   2: position unavailable (error response from location provider)
        //   3: timed out
      };
      navigator.geolocation.getCurrentPosition(initMap, geoError, geoOptions);
    }

    function cityChanged(){      
      getCoordsByCityName(city.options[city.selectedIndex].text);
    }

    function getCoordsByCityName(cityName) {      
      var geocoder = new google.maps.Geocoder();
      geocoder.geocode({'address': cityName}, function(results, status) {
      if (status === 'OK') {
        map.setCenter(results[0].geometry.location);
        map2.setCenter(results[0].geometry.location);
        getLocation(results[0].geometry.location.lat(),results[0].geometry.location.lng());
      } else {
        console.log('Geocode was not successful for the following reason: ' + status);
      }
      });
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

    function initMap(startPos,zoom = 16) {
      map = new google.maps.Map(document.getElementById('map'), {
        zoom: zoom,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        center: new google.maps.LatLng(startPos.coords.latitude,startPos.coords.longitude),
        mapTypeControl: false,
        streetViewControl:false,
        fullscreenControl:false
      });

      map2 = new google.maps.Map(document.getElementById('mapModal'),{
        zoom: zoom+1,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        center: new google.maps.LatLng(startPos.coords.latitude,startPos.coords.longitude),
        gestureHandling: 'none',
        mapTypeControl: false,
        zoomControl: false,
        streetViewControl:false,
        fullscreenControl:false

      });

      getLocation(startPos.coords.latitude,startPos.coords.longitude);


      latLng = setMarker(map);      
      setMarker(map2);
    }

    

    function setMarker(map){    
        google.maps.event.addListener(map, "dragend", function() {
          let latLng = map.getCenter();          
          lat = latLng.lat();
          lng = latLng.lng();
          getLocation(lat,lng);

          map2.setCenter(latLng);        
        });
    }

    function setGeocode() {
      let geocoder = new google.maps.Geocoder;      
      geocoder.geocode({ 'address': `${address.value},`+city.options[city.selectedIndex].text+`,`+country.options[country.selectedIndex].text+`` },
        function(results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
              latlng = {
                lat: results[0].geometry.location.lat(),
                lng: results[0].geometry.location.lng()
              }
              
              this.lat = latlng.lat;
              this.lng = latlng.lng;
              
              map.setCenter(new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng()));
              map2.setCenter(new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng()));
              getLocation(this.lat,this.lng);
            }
            else {
              let infowindow = new google.maps.InfoWindow({
                content: 'ocurrió algun error. Intenta mas tarde'
              })
            }        
        })
    }

    $('input').blur((e)=>{
      $('#'+e.target.id).removeClass('invalid');
    });

    $('#validateCreateForm').click(function(event) {

      var fields = $(".verifiable")
      var complete = true;

      for (var i = 0; i < fields.length; i++) {
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
            }//end if
          }//end if
        }//end if
      }//end for

      if (complete) {
        $("#modalCreateConfirm").click();        
        if(lat == undefined || lng == undefined){          
          setGeocode();
        }
      }
      else{
        console.log("aun falta mi niño")
      }



    });

    function createData(){      
      var submit = document.getElementById("createSubmit");      
      guardarDatos();
      submit.click();

    }

    async function getLocation(lat,lng){      
      let geocoder = new google.maps.Geocoder;
      let latLng={
        lat:lat,
        lng:lng
      };
      geocoder.geocode({
        'location':latLng
      },
      function(results,status){
        if(status == 'OK'){
          let currentData=JSON.parse(JSON.stringify(results[0].address_components));
          let data={};          
          for(let j=0;j<currentData.length;j++){
            if(currentData[j].types[0] == "neighborhood"){
              data.neigbothood=currentData[j].long_name;
            }
            if(currentData[j].types[0] == "locality"){
              data.city=currentData[j].long_name;
            }
            if(currentData[j].types[0] == "country"){
              data.country=currentData[j].long_name;
            }
          }
          verifyCountry(data);
        }
        else{
          console.log('error en la optencion del barrio');
        }
      });     
    }

    function verifyCountry(data){
      let countryIndice=0;
      if(data.country != undefined){
        for(let i=0;i<country.length;i++){
          if(country[i].innerText === data.country)
            countryIndice=i;
        }
        country[countryIndice].selected=true;
        // stepTwo.style.display='none';
        // country.style.display='none';
        // city.style.display='none';
        // ngbhId.style.display='none';
        // labelCountry.style.display='none';
        // labelCity.style.display='none';
        // labelNeighborhood.style.display='none';
        verifyCity(data);
      }
      
      else{
        country[0].selected=true;
        city[0].selected=true;
        ngbhId[0].selected=true;
        // stepTwo.style.display='block';
        // country.style.display='block';
        // city.style.display='block';
        // ngbhId.style.display='block';
        // labelCountry.style.display='block';
        // labelCity.style.display='block';
        // labelNeighborhood.style.display='block';
      }
    }

    async function verifyCity(data){
      let cityIndice=0;      
      if(data.city != undefined){
        for(let i=0;i<city.length;i++){
          if(city[i].innerText === data.city)
            cityIndice=i;
        }        
        if(cityIndice === 0){
          // let response=await fetch('/addCity',{
          //   method: 'post',
          //   credentials: "same-origin",
          //   headers: {
          //     "Content-Type": "application/json",
          //     "Accept": "application/json",
          //     "X-Requested-With": "XMLHttpRequest",
          //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          //   },
          //   body: JSON.stringify({
          //     name: data.city,
          //     country_id:country.value,
          //     _token:$('meta[name="csrf-token"]').attr('content')
          //   })
          // })
          // let json = await response.json();

          // let newOption = document.createElement("option");
          // newOption.text=json.name;
          // newOption.value=json.id;      
          // city.add(newOption);
          // city[city.length - 1].selected=true;
        }
        else{
          city[cityIndice].selected=true;
        }
        
        // stepTwo.style.display='none';
        // city.style.display='none';
        // ngbhId.style.display='none';
        // labelCity.style.display='none';
        // labelNeighborhood.style.display='none';
        verifyNeighborhood(data);
      }
      else{
        city[0].selected=true;
        ngbhId[0].selected=true;
        // stepTwo.style.display='block';
        // city.style.display='block';
        // ngbhId.style.display='block';
        // labelCity.style.display='block';
        // labelNeighborhood.style.display='block';
      }
    }

    async function verifyNeighborhood(data){
      let neighIndice=0;
      let json = [];      
      let requestNeighborhoods = $.ajax({                
                type: 'GET',
                dataType: 'json',
                url: '/api/neighborhoods/'+data.city,
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
      }).done(function (neighborhoods) {        
              json = neighborhoods;
              while (ngbhId.hasChildNodes()){
                ngbhId.removeChild(ngbhId.lastChild);
              }
              let selectOption = document.createElement("option");
                  selectOption.text = "-- Seleccione --"
                  selectOption.disabled = true;
                  selectOption.selected = true;
              if(json){
                json.neighborhoods.forEach(element => {
                    let newOption = document.createElement("option");
                    newOption.text = element.name;
                    if(element.name === data.neigbothood){
                      newOption.selected = true;
                    }
                    newOption.value = element.id;
                    ngbhId.add(newOption);
                  });
              }
              if(data.neigbothood == undefined) {
                      ngbhId[0].selected=true; 
              }                    
            }).fail(function (data) {
                console.log("Failed to load neighborhoods");
            });
      }

    </script>
  @endsection
