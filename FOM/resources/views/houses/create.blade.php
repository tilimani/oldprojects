@extends('layouts.app')
@section('content')
  @if (Auth::user() && Auth::user()->email === 'friendsofmedellin@gmail.com' || true)
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <h2>Crear VICO</h2>

    <form method="POST" action="{{ URL::to('/houses/store') }}" enctype="multipart/form-data">

      {{ csrf_field() }}
      <div class="row">
        <div class="form-group col-sm-6">
          <input type="text" class="form-control" name="name" placeholder="Nombre VICO" required>
          <label for="name">Nombre VICO</label>
        </div>
        <div class="form-group col-sm-6">
          <select class="form-control" name="neighborhood" required>
            <option>-- seleccione --</option>
            @foreach($neighborhoods as $neighborhood)
              <option value='{{ $neighborhood->id }}'>{{ $neighborhood->name }}</option>
            @endforeach
          </select>
          <label for="neighborhood">Barrio</label>
        </div>
      </div>
      <div class="row">
        <div class="form-group col-sm-6">
          <input id="address" type="text" class="form-control" name="address" placeholder="Direccion" required>
          <label for="address">Direccion</label>
          <div class="well map-container" id="map" style="width:100%;height:200px;">
          </div>


        </div>
        <div class="row">
          <div class="form-group col-sm-6">
            <textarea class="form-control" name="description_house" rows="3" maxlength="766" required></textarea>
            <label for="description_house">Descripcion Casa</label>
          </div>
          <div class="form-group col-sm-6">
            <textarea class="form-control" name="description_zone" rows="3" maxlength="766" required></textarea>
            <label for="description_zone">Descripcion zona</label>
          </div>
          <div class="form-group col-sm-6">
            <select class="form-control" name="close_to" required>
              <option>-- seleccione --</option>
              @foreach($schools as $school)
                <option value='{{ $school->id }}'>{{ $school->name }}</option>
              @endforeach
            </select>
            <label for="close_to">Cerca de la universidad</label>
          </div>
        </div>
        <div class="row">
          <h3>Encargado</h3>
          <div class="form-group col-sm-6">
            <select type="text" class="form-control" name="manager_id" placeholder="Nombre" required>
              <option>--seleccione</option>
              @foreach($managers as $manager)
                <option value='{{ $manager->id }}'>{{ $manager->name }}</option>
              @endforeach
            </select>
            <label for="manager_id">Nombre del encargado</label>
          </div>
        </div>

        <div class="row">
          <h3>Reglas:</h3>
          @foreach($rules as $rule)
            <div class="form-group col-sm-6">
              <input type="text" class="form-control" name="rule_{{ $rule->id }}" id="rule_{{ $rule->id }}">
              <label for="rule_{{ $rule->id }}">
                {{ $rule->name }}
              </label>
            </div>
          @endforeach
        </div>
        <div class="row">
          <h3>Dispositivos</h3>

          @foreach($devices as $device)
            <div class="form-group col-sm-2">
              <input type="checkbox" name="device_{{ $device->id }}" id="device_{{ $device->id }}">
              <label for="device_{{ $device->id }}">
                {{ $device->name }}
              </label>
            </div>
          @endforeach
        </div>
        <div class="row">
          <div class="col-sm-6">
            <input type="file" name="second_image[]" multiple required>
            <label for="second_image">Fotos zonas comunes</label>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-sm-6">
            <input type="text" class="form-control" name="video" placeholder="Video">
            <label for="video">Video</label>
          </div>

          <div class="form-group col-sm-6">
            <select class="form-control" name="type" required>
              <option>-- seleccione --</option>
              <option value='Casa'>Casa</option>
              <option value='Apartamento'>Apartamento</option>
            </select>
            <label for="type">Tipo de vivienda</label>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-sm-6">
            <input type="number" class="form-control" name="rooms" placeholder="# Habitaciones" maxlength="2" required>
            <label for="rooms"># de habitaciones</label>
          </div>

          <div class="form-group col-sm-6">
            <input type="number" class="form-control" name="baths" placeholder="# Baños" maxlength="2" required>
            <label for="baths"># de baños</label>
          </div>
        </div>
        <div id="hidden"></div>
        <div class="row" style="text-align: center; margin-bottom: 5rem;">
          <button type="submit" class="btn btn-default">
            Guardar
          </button>
        </div>

      </form>
    @else
      <p>You are not allowed to enter this page.</p>
    @endif

  @endsection

  @section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4_XvxW91t7uHIL6tzmacsoIX17gHUIgM" async defer></script>

    <script>

    // cambio: manda a solicitar otra vez cuando se envia el submit, esto falta por comprobarlo

    function initMap() {

      map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        center: new google.maps.LatLng(0, 0)
      })
      var address = document.getElementById('address').value;
      set_marker_house(address);
    }

    function set_marker_house(house_address) {

      map = new google.maps.Map(document.getElementById('map'), {
        zoom: 16,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        center: new google.maps.LatLng(0, 0),
        mapTypeControl: false
      })

      var geocoder = new google.maps.Geocoder
      //Recordar que la ciudad y el país no deben ser estáticos, no todas las VICO estarán en Medellín, Colombia
      geocoder.geocode({ 'address': `${house_address},medellin,CO` },
      function(results, status) {

        if (status === google.maps.GeocoderStatus.OK) {

          let latlng = {
            lat: results[0].geometry.location.lat(),
            lng: results[0].geometry.location.lng()
          }
          // cambio: aqui tomo el dato de lay y lng para escibirlo, esto pasa cuando se carga la pagina
          var hidden = '<input id="pos" type="text" name="lat" class="d-none" value="';
          hidden+=latlng.lat;
          hidden+='" >';
          $("#hidden").append(hidden);

          var hidden = '<input id="pos" type="text" name="lng" class="d-none" value="';
          hidden+=latlng.lng;
          hidden+='" >';
          $("#hidden").append(hidden);

          //                                alert('luego del hidden')



          let marker = new google.maps.Marker({
            map: map,
            position: latlng,
            draggable: false
          });

          map.setCenter(new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng()));

          marker.addListener('click', function() {
            infowindow.open(map, marker)
          });

        }
        else {

          let infowindow = new google.maps.InfoWindow({
            content: 'con errores :('
          })

        }

        google.maps.event.trigger(map, 'resize')

      })

    }

    document.getElementById("address").onchange = function () {
      //                    var form.getElementById("form");

      $("#pos").replaceWith("");
      $("#pos2").replaceWith("");
      initMap();
    };

    </script>
  @endsection
