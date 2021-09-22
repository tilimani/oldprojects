@extends('layouts.app')

@section('title', 'Crea una VICO')
@section('content')
    @section('styles')
    @endsection
    @include('layouts.errors')
    <div class="create justify-content-md-center">
        {{-- FORM COL --}}
        <div class="col-md-9 col-sm-12 mx-md-auto create-vico">
            {{-- NAVBAR --}}
            <nav class="navbar navCreate sticky-top row">
                <div>
                    <h1 class="navbar-text">Crea tu VICO</h1>
                </div>
            </nav>
            {{-- END NAVBAR --}}

            {{-- CREATE --}}
            <div id="create-first-form">
                {{-- FORM --}}
                <form method="POST" action="{{ URL::to('houses/store') }}" enctype="multipart/form-data" id="house-form">
                {{ csrf_field() }}
                {{-- STEPS --}}
                <div class="create-form">
                    <p>En los próximos minutos te vamos a ayudar a subir tu VICO a nuestra platforma. Puedes salir cuando quieres y continuar después</p>
                        @if(Auth::user()->isAdmin())
                            {{-- STEP 0 --}}
                            <div class="row steps" name="step0" id="step0">
                                {{-- STEP NUMBER AND NAME --}}
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-2 col-sm-1 num-icon">
                                            <span class="display-2 d-inline"><strong>0</strong></span>
                                        </div>
                                        <div class="col-10 col-sm-11">
                                            <h4 class="bold">SELECCIONA EL NOMBRE DEL MANAGER PARA ESTA VICO.</h4>
                                        </div>
                                    </div>
                                </div>
                                {{-- STEP NUMBER AND NAME --}}

                                {{-- STEP BODY --}}
                                <div class="col-12 ">
                                    <div class="pt-3 pb-3">
                                        <select type="text" class="form-control verifiable" name="manager_id" placeholder="Nombre del manager" required>
                                            @foreach($managers as $manager)
                                                <option value='{{ $manager->id }}'>{{ $manager->name }} {{ $manager->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- END STEP BODY --}}
                            </div>
                            {{-- END STEP 0 --}}
                        @endif

                        {{-- STEP 1 --}}
                        <div class="row steps" name="step1" id="step1">
                            {{-- STEP NUMBER AND NAME --}}
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-2 col-sm-1 num-icon">
                                        <span class="display-2 d-inline"><strong>1</strong></span>
                                    </div>
                                    <div class="col-10 col-sm-11">
                                        <h4 class="bold">¿CUAL NOMBRE TIENE TU VICO? <span class="required-asterisk">*</span></h4>
                                    </div>
                                </div>
                            </div>
                            {{-- END STEP NUMBER AND NAME --}}

                            {{-- STEP BODY--}}
                            <div class="col-12 ">
                                <p id="infoStep1" class="stepsInfo mb-0 mt-2 font-italic d-block">Dale un toque personalizado, e.g. VICO Tranquila, VICO Malibú, VICO Verde</p>
                                <div class="pt-3 pb-3">
                                    <input type="text" class="form-control verifiable" name="name" id="input-name" required>
                                </div>
                            </div>
                            <div class="row steps d-none">
                              {{-- STEP BODY --}}
                              <div class="col-12 ">                                
                                <div class="pt-3 pb-3">
                                  <input type="text" name="lat" value="" id="lat">
                                  <input type="text" name="lng" value="" id="lng">
                                  <input type="text" name="address" value="" id="address">
                                  <input type="text" name="aditionalAddress" value="" id="aditionalAddress">
                                  <input type="text" name="optionalAddress" value="" id="optionalAddress">
                                  <input type="text" name="newAddress" value="" id="newAddress">
                                  <input type="text" name="neighborhood" value="" id="neighborhood">
                                  <input type="text" name="country" value="" id="country">
                                  <input type="text" name="city" value="" id="city">
                                  <input type="text" name="type" value="" id="typeHouse">
                                </div>
                              </div>
                              {{-- END STEP BODY --}}
                            </div>
                            {{-- END STEP BODY --}}
                        </div>
                        {{-- END STEP 1 --}}

                        {{-- NEW STEP 3 --}}
                        <div class="row steps">
                            {{-- STEP NUMBER AND NAME --}}
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-2 col-sm-1 num-icon">
                                        <span class="display-2 d-inline"><strong>2</strong></span>
                                    </div>
                                    <div class="col-10 col-sm-11">
                                        <h4 class="bold">QUÉ TAL LA ZONA.<span class="required-asterisk">*</span></h4>
                                    </div>
                                </div>
                            </div>
                            {{-- END STEP NUMBER AND NAME --}}

                            {{-- STEP BODY --}}
                            <div class="col-12">
                                <p id="infoStep5" class="stepsInfo mb-0 mt-2 font-italic d-block">¿Hay un Museo cerca o una cancha de football? Describe si hay algun lugar de interes que no este listado.
                                </p>
                                <textarea required maxlength="350" name="description_zone" minlength="30" class="form-control verifiable" onkeyup="textCounter(this,'remainingC_zone',350);" id="more-info"></textarea>
                                <span class="btn-outline-info px-2 py-1 text-center border-rounded my-2" id='remainingC_zone'></span>

                                <div class="add-buttons-description" id="interestPoints"></div>
                                <div class="content-zone-description" id="cont-z-desc"></div>
                            </div>
                            {{-- END STEP BODY --}}
                        </div>

                        {{-- STEP 5 --}}
                        <div class="row steps" name="step5" id="step5">
                            {{-- STEP NUMBER AND NAME --}}
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-2 col-sm-1 num-icon">
                                        <span class="display-2 d-inline"><strong>3</strong></span>
                                    </div>
                                    <div class="col-10 col-sm-11">
                                        <h4 class="bold">DESCRIBE EL AMBIENTE DE LA VICO.<span class="required-asterisk">*</span></h4>
                                    </div>
                                </div>
                            </div>
                            {{-- STEP NUMBER AND NAME --}}

                            {{-- STEP BODY --}}
                            <div class="col-12 ">
                                <p id="infoStep5" class="stepsInfo mb-0 mt-2 font-italic d-block">¿Qué hace esta VICO especial? ¿Qué tal la convivencia? ¿Qué tipo de personas estás buscando?</p>
                                <div class="pt-3 pb-3">
                                    <textarea required maxlength="350" class="form-control verifiable" minlength="30" name="description_house" value="" id="descriptionHouse" onkeyup="textCounter(this,'remainingC_house',350);" ></textarea>

                                    <span class="btn-outline-info px-2 py-1 text-center border-rounded my-2" id='remainingC_house'></span>
                                </div>
                            </div>
                            {{-- END STEP BODY --}}
                        </div>
                        {{-- END STEP 5 --}}

                    {{-- STEP 6 --}}
                    <div class="row steps" name="step6" id="step6">
                        {{-- STEP NUMBER AND NAME --}}
                        <div class="col-12">
                            <div class="row">
                                <div class="col-2 col-sm-1 num-icon">
                                    <span class="display-2 d-inline"><strong>4</strong></span>
                                </div>

                                <div class="col-10 col-sm-11">
                                    <h4 class="bold">MENCIONA SI TIENES ALGO EXTRAORDINARIO (EN CASO DE TENERLO)</h4>
                                </div>
                            </div>
                        </div>
                        {{-- STEP NUMBER AND NAME --}}

                        {{-- STEP BODY --}}
                        <div class="col-12 ">
                            <p id="infoStep6" class="stepsInfo mb-0 mt-2 font-italic d-block">Ejemplo: menciona si hay mascotas, cámaras, o reglas extraordinarias en tu VICO.</p>
                            <div class="pt-3 pb-3">
                                <textarea class="form-control" name="rule_8" id="extraDescription" value="{{old('rule_8')}}"></textarea>
                            </div>
                        </div>
                        {{-- END STEP BODY --}}
                    </div>
                    {{-- END STEP 6 --}}

            {{-- STEP 7 --}}
            <div class="row steps" name="step6" id="step6">

              {{-- STEP NUMBER AND NAME --}}
              <div class="col-12">
                <div class="row">
                  <div class="col-2 col-sm-1 num-icon">
                    <span class="display-2 d-inline"><strong>5</strong></span>
                  </div>
                  <div class="col-10 col-sm-11">
                    <h4 class="bold">ACERCA DE LA VICO:</h4>
                  </div>
                </div>
              </div>
              {{-- END STEP NUMBER AND NAME --}}

              {{-- STEP BODY --}}
              <div class="col-12 ">
                <div class="create-rules">
                  {{-- RULE--}}
                  <div class="rule">
                    <p class="font-weight-bold">¿Cuáles servicios están inlcuidos en la renta mensual?<span class="required-asterisk">*</span></p>
                    <div class="equip-selector row justify-content-center">

                      <input type="hidden" value="30" name="rule_1">
                      <input type="hidden" value="0" name="rule_6">

                      <div class="col-4 col-md-2 equip">
                        <input id="1" type="checkbox" name="rule_9" class="vicoService">
                        <label for="1">
                          <span class="icon-wifi-black vico-room-equip"></span>
                        </label>
                        <p for="1">Internet</p>
                      </div>

                      <div class="col-4 col-md-2 equip">
                        <input id="2" type="checkbox" name="rule_10" class="vicoService">
                        <label for="2">
                          <span class="icon-gas-black vico-room-equip"></span>
                        </label>
                        <p for="2">Gas</p>
                      </div>

                      <div class="col-4 col-md-2 equip">
                        <input id="3" type="checkbox" name="rule_11" class="vicoService">
                        <label for="3">
                          <span class="icon-water-black vico-room-equip"></span>
                        </label>
                        <p for="3">Agua</p>
                      </div>

                      <div class="col-4 col-md-2 equip">
                        <input id="4" type="checkbox" name="rule_12" class="vicoService">
                        <label for="4">
                          <span class="icon-electricity-black vico-room-equip"></span>
                        </label>
                        <p for="4">Electricidad</p>
                      </div>

                      <div class="col-4 col-md-2 equip">
                        <input id="5" type="checkbox" name="rule_5" class="vicoService">
                        <label for="5">
                          <span class="icon-cleaning-black vico-room-equip"></span>
                        </label>
                        <p for="5">Aseo zona social</p>
                      </div>

                      <div class="col-4 col-md-2 equip d-none">
                        <input id="6" type="checkbox" name="rule_13" class="vicoService">
                        <label for="6">
                          <span class="icon-check vico-room-equip"></span>
                        </label>
                        <p for="6">¿Es una casa de familia?</p>
                      </div>

                      {{--  <div class="col-6 col-sm-4 service">
                      <input id='1' type='checkbox' value="Internet" name="rule_9">
                      <label for='1'>Internet</label>
                    </div> --}}
                    {{--     <div class="col-6 col-sm-4 service">
                    <input id='2' type='checkbox' value="Gas" name="rule_10">
                    <label for='2'>Gas</label>
                    <span class="icon-gas-black"></span>
                    <span class="icon-cleaning-black"></span>
                    <span class="icon-water-black"></span>
                    <span class="icon-wifi-black"></span>
                    <span class="icon-kitchen"></span>

                  </div>
                  <div class="col-6 col-sm-4 service">
                  <input id='3' type='checkbox' value="Agua" name="rule_11">
                  <label for='3'>Agua</label>
                </div>
                <div class="col-6 service">
                <input id='4' type='checkbox' value="Electricidad" name="rule_12">
                <label for='4'>Electricidad</label>
                <span class="icon-electricity-black"></span>
              </div>
              <div class="col-6 service">
              <input id='5' type='checkbox' name="rule_5" value="Aseo en zona social">
              <label for='5'>Aseo zona social</label>
            </div>
            <div class="col-6 service d-none">
            <input id='6' type='checkbox' name="rule_13" value="Alimentacion">
            <label for='6'>Alimentación</label>
          </div> --}}

        </div>
      </div>
      {{-- END RULE --}}
      {{-- RULE --}}
      <div class="rule">
        <p class="font-weight-bold">¿Es una casa de familia?<span class="required-asterisk">*</span></p>
        {{-- RADIOBUTTON CONTAINER --}}
        <div class="select-equip ">
          <div class="row equip-selector justify-content-center mb-3">
            {{-- RADIOBUTTON TYPE:HOUSE --}}
            <div class="col-4 col-sm-3 equip form-check">
              <input type="radio" name="rule_13" value="1" id="family" >
              <label for="family">
                <span class="icon-check vico-room-equip"></span>
              </label>
              <p for="house">Si</p>
            </div>
            {{-- END RADIOBUTTON TYPE:HOUSE --}}

            {{-- RADIOBUTTON TYPE:APARTMENT --}}
            <div class="col-4 col-sm-3 equip form-check">
              <input type="radio" name="rule_13" value="0" id="independent" checked>
              <label for="independent">
                <span class="icon-close vico-room-equip"></span>
              </label>
              <p for="apartment">No</p>
            </div>
            {{-- END RADIOBUTTON TYPE:APARTMENT --}}
          </div>
        </div>
        {{-- END RADIOBUTTON CONTAINER --}}
      </div>
      {{-- END RULE --}}
      {{-- RULE --}}
      <div class="rule">
        <p class="font-weight-bold">¿Cuál es el tiempo mínimo de estancia en tu VICO?<span class="required-asterisk">*</span></p>
        <p id="infoStep7-2" class=" mb-0 mt-2 mb-3 font-italic">
          <span class="font-weight-bold">Recomendación: 1 mes</span><br>
          La mayoría de nuestro clientes se quedan entre 4 y 12 meses. Sin embargo, recomendamos una estancia mínima de 1 mes para no crear barreras para la realización de reservas.
        </p>
        <select class="custom-select form-control-sm" name="rule_2" value="{{old('rule_2')}}" id="rule2">
          {{-- <option value="30">1 mes</option> --}}
          @for($i=1;$i<=12;$i++)
            <option value="{{30*$i}}" @if($i*30 == 90)selected @endif>{{$i}} meses</option>
          @endfor
          {{-- <option value="90">3 meses</option>
          <option value="120">4 meses</option>
          <option value="150">5 meses</option> --}}

        </select>
      </div>
      {{-- END RULE --}}
      {{-- RULE --}}
      <div class="rule">
        <p class="font-weight-bold">Tiempo de anticipo para salir de la VICO<span class="required-asterisk">*</span></p>
        <p id="infoStep7-3" class=" mb-0 mt-2 mb-3 font-italic">
          <span class="font-weight-bold">Recomendación: 1 mes</span><br>

          En VICO les queremos brindar seguridad a los dueños de las VICOs. Por eso el estudiante no tiene derecho a la devolución del depósito, cuando no avisa cierto tiempo antes de su salida. Recomendamos un tiempo de 1 mes.
        </p>
        <select class="custom-select form-control-sm" name="rule_4" value="{{old('rule_4')}}" id="rule4">
          <option value="14" >2 semanas</option>
          <option value="30" selected>1 mes</option>
          <option value="60">2 meses</option>
          <option value="90">3 meses</option>

        </select>
      </div>
      {{-- END RULE --}}
      {{-- RULE --}}
      <div class="rule">
        <p class="font-weight-bold">Tiempo de anticipo para reservar una habitación en tu VICO<span class="required-asterisk">*</span></p>
        <p id="infoStep7-5" class=" mb-0 mt-2 mb-3 font-italic">
          <span class="font-weight-bold">Recomendación: Tiempo indefinido</span><br>
          ¿Cuanto en adelante puede un estudiante reservar una habitación de tu VICO?.
        </p>

        <select class="custom-select form-control-sm" name="rule_7" value="{{old('rule_7')}}" id="rule7">
          <option value="14" >2 semanas</option>
          <option value="30">1 mes</option>
          <option value="360" selected>Tiempo indefinido</option>
        </select>
      </div>
      {{-- END RULE --}}
      {{-- RULE --}}
      <div class="rule">
        <p class="font-weight-bold">Costo adicional por huésped extra</p>


        <p id="infoStep7-4" class=" mb-0 mt-2 mb-3 font-italic">
          Algunos clientes reciben visitas de sus paises de origen, que en varios casos son alojados en las mismas habitaciones de los clientes. Algunos dueños de VICOs les cobran un valor adicional por persona y noche en estos casos.
        </p>
        {{--  ADITIONAL PRICE SELECTOR --}}

        <div class="select-equip">
          <div class="row equip-selector justify-content-center">
            <div class="col-6 col-sm-3 equip form-check">
              <input class="aditional" type="radio" name="aditional" id="aditionalPriceAff" value="1">
              <label for="aditionalPriceAff">
                <span class="icon-check vico-room-equip"></span>
              </label>
              <p for="aditionalPriceAff">Si</p>
            </div>
            <div class="col-6 col-sm-3 equip form-check">
              <input class="aditional" type="radio" name="aditional" id="aditionalPriceNeg" value="0" checked>
              <label for="aditionalPriceNeg">
                <span class="icon-close vico-room-equip"></span>
              </label>
              <p for="aditionalPriceNeg">No</p>
            </div>
          </div>
        </div>
        {{-- END ADITIONAL PRICE SELECTOR --}}
        {{-- ADITIONAL PRICE --}}
        <div id="aditionalPrice" class="aditionalPrice">
          <p class="mr-2 pl-0 d-inline "> Valor adicional por huésped por noche: </p>
          <div class="m-0 d-md-inline">
            <p class="d-inline">$</p>
            <input class='d-inline w-50 form-control form-control-sm verifiable' id="aditionalPriceField" name="rule_3" value='0' type='number' min='0' required disabled>
            <p class="d-inline ">COP</p>
          </div>
        </div>
        {{-- END ADITIONAL PRICE --}}

        {{--
        <div class="m-0">

        <p class="d-inline col-1 pl-0 pr-0">$</p>
        <input type="number" min="1" name="rule_3" class="form-control form-control-sm d-inline col-10 col-sm-11 w-50" required >
        <p class="d-inline col-1  pr-0 pl-0">COP</p>

      </div> --}}
    </div>
    {{-- END RULE --}}
    {{-- RULE --}}
    <div class="rule">
      <p class="font-weight-bold">¿Deseas añadir una regla especial a tu vico?</p>
      <input type="checkbox" class="add-rule" id="toogleRule" name="toogleRule">
      <ul class="rules-container" id="rulesContainer"></ul>
      <div class="add-rule-container">
        <label for="toogleRule" class="add-rule-btn">
          Añadir
          <span class="icon-close"></span>
        </label>
        <div class="add-rule-content">
          <textarea id="customRule" class="form-control" maxlength="160"></textarea>
          <button type="button" id="addCustomRule" class="btn btn-primary">Añadir</button>
        </div>
      </div>
    </div>
    {{-- END RULE --}}
    {{-- RULE --}}
    {{-- <div class="rule">
    <p>Reglas adicionales de visita</p>
    <textarea class="form-control" required name="rule_8"></textarea>
  </div> --}}
  {{-- END RULE --}}
</div>
{{-- END RULES --}}
</div>
{{-- END STEP BODY --}}
</div>
{{-- END STEP 7 --}}

{{-- STEP 8 --}}
<div class="row steps" name="step7" id="step7">

  {{-- STEP NUMBER AND NAME --}}

  <div class="col-12">
    <div class="row">
      <div class="col-2 col-sm-1 num-icon">
        <span class="display-2 d-inline"><strong>6</strong></span>
      </div>
      <div class="col-10 col-sm-11">
        <h4 class="bold">¿CON CUÁLES EQUIPOS CUENTA TU VICO?<span class="required-asterisk">*</span></h4>

      </div>
    </div>
  </div>
  {{-- END STEP NUMBER AND NAME --}}

  {{-- STEP BODY --}}
  <div class="col-12 ">
    {{-- DEVICES --}}
    <div class="select-equip">
      <div class="equip-selector row justify-content-center">
        @foreach($devices as $device)
          <div class="col-4 col-sm-3 equip">
            <input type="checkbox" name="device_{{ $device->id }}" id="device_{{ $device->id }}">
            <label for="device_{{ $device->id }}">
              <span class="{{ $device->icon }} vico-show-equipos"></span>
            </label>
            <p for="device_{{ $device->id }}">{{ $device->name }}</p>
          </div>
        @endforeach
      </div>
    </div>
    {{-- END DEVICES  --}}

  </div>
  {{-- END STEP BODY --}}
</div>
{{-- END STEP 8 --}}

{{-- STEP 9 --}}
<div class="row steps" name="step9" id="step9">
  {{-- STEP NUMBER AND NAME --}}
  <div class="col-12">
    <div class="row">
      <div class="col-2 col-sm-1 num-icon">
        <span class="display-2 d-inline"><strong>7</strong></span>
      </div>
      <div class="col-10 col-sm-11">
        <h4 class="bold">¿CUÁNTAS HABITACIONES TIENE LA VICO EN TOTAL?<span class="required-asterisk">*</span></h4>
      </div>
    </div>
  </div>
  {{-- END STEP NUMBER AND NAME --}}

  {{-- STEP BODY --}}
  <div class="col-12 ">
    <p id="infoStep9" class="stepsInfo font-italic d-block">Por favor cuenta TODAS las habitaciones. También las que no se alquilan o son ocupadas a largo plazo.
    </p>
    <div class="pt-3 pb-3">
      <input type="number" class="form-control verifiable" value="{{old('rooms')}}" name="rooms" id="num-rooms" min="1" required>

    </div>
  </div>
  {{-- END STEP BODY --}}
</div>
{{-- END STEP 9 --}}

{{-- STEP 10 --}}
<div class="row steps" name="step9" id="step9">
  {{-- STEP NUMBER AND NAME --}}
  <div class="col-12">
    <div class="row">
      <div class="col-2 col-sm-1 num-icon">
        <span class="display-2 d-inline"><strong>8</strong></span>
      </div>
      <div class="col-10 col-sm-11">
        <h4 class="bold">¿CUÁNTOS BAÑOS TIENE TU VICO?<span class="required-asterisk">*</span></h4>
      </div>
    </div>
  </div>
  {{-- END STEP NUMBER AND NAME --}}
  {{-- STEP BODY --}}
  <div class="col-12 ">
    <p id="infoStep8" class="stepsInfo font-italic d-block">Por favor cuenta TODOS los baños. También los privados.
    </p>
    <div class="pt-3 pb-3">
      <input type="number" class="form-control verifiable" value="{{old('baths')}}" id="num-baths" name="baths" min="1" required>

    </div>
  </div>
  {{-- END STEP BODY --}}
</div>
{{-- END STEP 10 --}}

{{-- SUBMIT BUTTONS --}}
{{--       <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
Launch demo modal
</button> --}}
<button type="button" id="validateCreateForm" class="btn btn-primary btn-block button-space mb-3" >Continuar</button>
<button type="button" id="btn-continue" class="d-none" ></button>

{{-- <button type="button" id="modalCreateConfirm" class="d-none" data-toggle="modal" data-target="#modalConfirm"></button> --}}

<button type="submit" id="createSubmit" class="btn btn-primary btn-block button-space d-none"></button>
{{-- END SUBMIT BUTTONS --}}



{{-- MODAL CONFIRM --}}

{{-- <div class="modal fade" style="overflow:scroll" id="modalConfirm" tabindex="-1" role="dialog" aria-labelledby="modalConfirmTitle" aria-hidden="true">
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
<div class="well map-container" id="mapModal" style="width:100%;height:200px;"></div>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary check" data-dismiss="modal">No, Quiero revisar</button>
<button type="button" class="btn btn-primary" id="btn-continue">Si, estoy seguro</button>
</div>
</div>
</div>
</div> --}}
{{-- END MODAL CONFIRM --}}
</div>
{{-- END STEPS --}}


</form>
{{-- END FORM --}}
<div class="d-none d-md-block">

</div>

</div>
{{-- END CREATE --}}


</div>
{{-- END FORM COL --}}

{{-- PROGRESS COL --}}
{{--
<div class="col-md-4 d-none d-md-block prog-panel">
  <ul class="steps-nav" id="steps-nav">
    <a href="#step1" data-ancla="step1">
      <li class="pt-2 stepname">
        <p>¿CUÁL NOMBRE TIENE TU VICO?</p>
      </li>
    </a>
    <a href="#step2" data-ancla="step2">
      <li class="pt-2 stepname">
        <p>¿QUE TIPO DE VIVIENDA ES TU VICO?</p>
      </li>
    </a>
    <a href="#step4" data-ancla="step3">
      <li class="pt-2 stepname">
        <p>¿QUÉ TAL LA ZONA?</p>
      </li>
    </a>
    <a href="#step5" data-ancla="step4">
      <li class="pt-2 stepname">
        <p>DESCRIBE EL AMBIENTE DE LA VICO</p>
      </li>
    </a>
    <a href="#step6" data-ancla="step5">
      <li class="pt-2 stepname">
        <p>¿ALGO EXTRAORDINARIO?</p>
      </li>
    </a>
    <a href="#step7" data-ancla="step6">
      <li class="pt-2 stepname">
        <p>ACERCA DE LA VICO</p>
      </li>
    </a>
    <a href="#step8" data-ancla="step7">
      <li class="pt-2 stepname">
        <p>¿CON CUÁLES EQUIPOS CUENTA TU VICO?</p>
      </li>
    </a>
    <a href="#step9" data-ancla="step8">
      <li class="pt-2 stepname">
        <p>¿CUÁNTAS HABITACIONES TIENE LA VICO EN TOTAL?</p>
      </li>
    </a>
    <a href="#step10" data-ancla="step9">
      <li class="pt-2 stepname border-left-0 ">
        <p>¿CUÁNTOS BAÑOS TIENE TU VICO?</p>
      </li>
    </a>
  </ul>
</div> --}}
{{-- END PROGRESS COL --}}
</div>
    @section('scripts')
        {{-- Include scripts section --}}
        @include('houses.sections.createScripts')
    @endsection
@endsection
