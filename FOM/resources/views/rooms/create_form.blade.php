<div id="create-second-form">
    {{-- FORM --}}
      {{ csrf_field() }}
      <input type="hidden" value="{{$id_house}}" id="houseId">
      {{-- <input type="hidden" id="numRooms" value="{{$count}}"> --}}
      {{-- CARD --}}
      <div class="card" style="margin-bottom: 90px">
        {{-- CARD HEADER --}}
        <div class="card-header" id="heading">
          <h5 class="mb-0">
            <a class="btn btn-link d-inline">
              Habitación <span id="numberRoom">1</span>
            </a>
            <div class="d-inline">
                <h6 class="d-inline" id="roomName"></h6>
            </div>
          </h5>
        </div>
        {{-- END CARD HEADER --}}
        {{-- COLLAPSE --}}
        <div id="roomForm">
          {{-- ROW --}}
          <div class="row justify-content-center">
            {{-- CARD BODY --}}
            <div class="card-body col-md-8 col-sm-12">
              {{-- STEP 0 --}}
              <div class="row steps" name="step0" id="step0">
                          {{-- <input type="hidden" name="number" value=""> --}}
                          {{-- STEP NUMBER AND NAME --}}

                            <div class="col-12">
                              <div class="row">
                                <div class="col-2 col-sm-1 num-icon">
                                  <span class="display-2 d-inline"><strong>0</strong></span>
                                </div>
                                <div class="col-10 col-sm-11">
                                    <h4 class="bold">¿COMO RECONOCES ESTA HABITACIÓN?</h4>
                                </div>
                              </div>
                            </div>
                          {{-- END STEP NUMBER AND NAME --}}
                          {{-- STEP BODY --}}
                          <div class="col-12">
                            <p class="nicknameDesc mb-0 mt-2 font-italic">
                              Ejemplo: "La que está detras de la cocina", "La que está debajo de las escaleras".
                            </p>
                            <div class="input-space">
                              <input type="text" class="form-control" id="nickname" >
                              <p class="mt-3 font-italic nicknameDesc">Solamente tu puedes ver esta descripción</p>
                            </div>

                          </div>
                          {{-- END STEP BODY --}}
              </div>
              {{-- END STEP 0 --}}
              {{-- STEP 1 --}}
               <div class="row steps" name="step1" id="step1">
                          {{-- STEP NUMBER AND NAME --}}

                            <div class="col-12">
                              <div class="row">
                                <div class="col-2 col-sm-1 num-icon">
                                  <span class="display-2 d-inline"><strong>1</strong></span>
                                </div>
                                <div class="col-10 col-sm-11">
                                    <h4 class="bold">¿SE PODRÁ ALQUILAR ESTA HABITACIÓN?</h4>
                                </div>
                              </div>
                            </div>
                          {{-- END STEP NUMBER AND NAME --}}
                          {{-- STEP BODY --}}
                          <div class="col-12">
                            <div class="select-equip">
                              <div class="row equip-selector justify-content-center">

                                <div class="col-6 col-sm-3 equip form-check">
                                <input class="bookeable" type="radio" id="isBookeable" name="bookable" value="1" checked>
                                  <label for="isBookeable">
                                      <span class="icon-check vico-room-equip"></span>
                                  </label>
                                  <p for="">Si</p>
                                </div>
                                 <div class="col-6 col-sm-3 equip form-check">
                                  <input class="bookeable" type="radio" id="isnotBookeable" name="bookable" value="0">
                                  <label for="isnotBookeable">
                                      <span class="icon-close vico-room-equip"></span>
                                  </label>
                                  <p for="">No</p>
                                </div>
                              </div>
                            </div>

                          </div>
                            {{-- END STEP BODY --}}
              </div>
              {{-- END STEP 1 --}}
              <div id="noRented">
                {{-- STEP 2 --}}
                <div class="row steps" name="step2" id="step2">
                              {{-- STEP NUMBER AND NAME --}}
                              <div class="col-12">
                                  <div class="row">
                                    <div class="col-2 col-sm-1 num-icon">
                                      <span class="display-2 d-inline"><strong>2</strong></span>
                                    </div>
                                    <div class="col-10 col-sm-11">
                                        <h4 class="bold">RENTA MENSUAL</h4>

                                    </div>
                                  </div>
                                </div>
                              {{-- END STEP NUMBER AND NAME --}}
                              {{-- STEP BODY --}}
                              <div class="col-12">

                                {{-- PRICE --}}
                                  <div class="mb-3 mt-3">
                                    <p class="mr-2 pl-0 d-inline"> Para una persona: </p>
                                    <div class="m-0 d-md-inline">
                                      <p class="d-inline">$</p>

                                      <input id="priceRoom" class='d-inline w-50 form-control form-control-sm verifiableRoom' maxlength="32" type='number' min='1' required>

                                      <p class="d-inline ">COP</p>

                                    </div>

                                  </div>
                                {{-- END PRICE --}}
                                {{-- EARNED --}}
                                <div class="mb-3 mt-3">
                                  <p class="mr-2 pl-0 d-inline">Tu recibes:</p>
                                  <p class="d-inline"><span id="totalEarned">0</span> COP/MES</p>
                                </div>
                                {{-- END EARNED --}}
                                {{-- COMMISSION --}}
                                <div class="mb-3 mt-3">
                                  <p class="mr-2 pl-0 d-inline">Comisión <strong>mensual</strong> (7%):</p>
                                  <p class="d-inline"><span name="commission">0</span> COP/MES</p>
                                </div>
                                {{-- END COMMISSION --}}
                                {{-- WARNING --}}
                                <div class="mb-3 mt-3 price-warning">
                                  <i class="fas fa-exclamation-triangle d-inline"></i>
                                  <p class="d-inline">"El valor de la comisión es de $<span name="commission">0</span> mensual (7% de la renta mensual), el cuál solo se cobrará cuando se complete una intermediación y su habitación sea alquilada a través de VICO."</p>   
                                </div>
                                {{-- END WARNING --}}
                                <p class="mt-2" ><strong>¿Esa habitación puede ser ocupada por una pareja o dos personas?</strong></p>
                                {{-- COUPLE PRICE SELECTOR --}}
                                <div class="select-equip">
                                  <div class="row equip-selector justify-content-center mt-0">

                                    <div class="col-6 col-sm-3 equip form-check">
                                      <input class="couple" type="radio" name="canCouple" id="coupleAff" value="1">
                                      <label for="coupleAff">
                                          <span class="icon-check vico-room-equip"></span>
                                      </label>
                                      <p for="coupleAff">Si</p>
                                    </div>
                                      <div class="col-6 col-sm-3 equip form-check">
                                      <input class="couple" type="radio" name="canCouple" id="coupleNeg" value="0" checked>
                                      <label for="coupleNeg">
                                          <span class="icon-close vico-room-equip"></span>
                                      </label>
                                      <p for="coupleNeg">No</p>
                                    </div>
                                  </div>
                                </div>
                                {{-- END COUPLE PRICE SELECTOR --}}
                                {{-- COUPLE PRICE --}}
                                <div id="couplePrice">
                                  <p class="mr-2 pl-0 d-inline"> Renta mensual para dos personas: </p>
                                    <div class="m-0 d-md-inline">
                                      <p class="d-inline">$</p>
                                      <input id="priceForTwo" class='d-inline w-50 form-control form-control-sm verifiableRoom' type='number' maxlength="32" min='1' required disabled>
                                      <p class="d-inline ">COP</p>
                                    </div>

                                </div>
                                {{-- END COUPLE PRICE --}}
                              </div>
                              {{-- END STEP BODY --}}
                </div>
                {{-- END STEP 2 --}}
                {{-- STEP 3 --}}
                <div class="row steps" name="step3" id="step3">
                              {{-- STEP NUMBER AND NAME --}}
                              <div class="col-12">
                                  <div class="row">
                                    <div class="col-2 col-sm-1 num-icon">
                                      <span class="display-2 d-inline"><strong>3</strong></span>
                                    </div>
                                    <div class="col-10 col-sm-11">
                                        <h4 class="bold">¿CON CUÁLES EQUIPOS CUENTA LA HABITACIÓN?</h4>

                                    </div>
                                  </div>
                                </div>
                              {{-- END STEP NUMBER AND NAME --}}
                              {{-- STEP BODY --}}
                              <div class="col-12">
                                {{-- EQUIP --}}
                                <div class="select-equip">
                                  <p class="bold  mt-3" ><strong>Marca los equipos que hay dentro de la habitación.</strong></p>
                                  <div class="equip-selector row justify-content-center">


                                      <div class="col-4 col-sm-3 equip">
                                          <input type="checkbox" name="has_tv" value="1" id="device_tv">
                                          <label for="device_tv">
                                              <span class="icon-tv vico-room-equip"></span>
                                          </label>
                                          <p for="device_tv">TV</p>
                                      </div>
                                      <div class="col-4 col-sm-3 equip">
                                          <input type="checkbox" name="has_closet" value="1" id="device_closet">
                                          <label for="device_closet">
                                              <span class="icon-closet vico-room-equip"></span>
                                          </label>
                                          <p for="device_closet">Closet</p>
                                      </div>
                                      <div class="col-4 col-sm-3 equip">
                                          <input type="checkbox" name="desk" value="1" id="device_desk">
                                          <label for="device_desk">
                                              <span class="icon-z--desk vico-room-equip"></span>
                                          </label>
                                          <p for="device_desk">Escritorio</p>
                                      </div>
                                    </div>
                                </div>
                                {{-- END EQUIP --}}
                                <hr>

                                {{-- WINDOW TYPE --}}

                                <div class="select-equip ">
                                    <p class="bold  mt-3" ><strong>¿Hacia donde apunta la ventana?</strong></p>


                                  <p id="infoStep2Room" class="mb-3 windowDesc mb-0 mt-2 text-center font-italic"></p>
                                  <div class="equip-selector row justify-content-center">


                                      <div class="col-6 col-sm-3 equip">
                                          <input type="radio" value='afuera' name="window_type"  class="form-check window" id="window1" >
                                          <label for="window1">
                                              <span class="icon-outside-black vico-room-equip"></span>
                                          </label>
                                          <p for="window1">Hacia afuera</p>
                                      </div>
                                      <div class="col-6 col-sm-3 equip">
                                          <input type="radio" value='patio' class="window" name="window_type" id="window2">
                                          <label for="window2">
                                              <span class="icon-plant-black vico-room-equip"></span>
                                          </label>
                                          <p for="window2">Hacia el patio</p>
                                      </div>
                                      <div class="col-6 col-sm-3 equip">
                                          <input type="radio" value='adentro' class="window" name="window_type" id="window3">
                                          <label for="window3">
                                              <span class="icon-lamp vico-room-equip"></span>
                                          </label>
                                          <p for="window3">Hacia adentro</p>
                                      </div>
                                      <div class="col-6 col-sm-3 equip">
                                          <input type="radio" value='sin_ventana' class="window" name="window_type" id="window4" checked >
                                          <label for="window4">
                                              <span class="icon-close vico-room-equip"></span>
                                          </label>
                                          <p for="window4">Sin Ventana</p>
                                      </div>


                                  </div>
                                </div>
                                {{-- END WINDOW TYPE --}}
                                <hr>
                                {{-- BED TYPE --}}
                                  <div class="row">
                                    <div class="col-12">
                                      <div class="select-equip ">
                                        <p class="bold "><strong>Tipo de cama:</strong></p>
                                        <div class="equip-selector row justify-content-center">


                                          <div class="col-4 col-sm-3 equip">
                                              <input type="radio" value='sencilla' name="bed_type"  class="form-check" id="typeBedRadio1" checked >
                                              <label for="typeBedRadio1">
                                                  <span class="icon-bed-single vico-room-equip"></span>
                                              </label>
                                              <p for="typeBedRadio1">Sencilla</p>
                                          </div>
                                          <div class="col-4 col-sm-3 equip">
                                              <input type="radio" value='semi-doble' name="bed_type" id="typeBedRadio2">
                                              <label for="typeBedRadio2">
                                                  <span class="icon-bed-semi-double vico-room-equip"></span>
                                              </label>
                                              <p for="typeBedRadio2">Semi-doble</p>
                                          </div>
                                          <div class="col-4 col-sm-3 equip">
                                              <input type="radio" value='doble' name="bed_type" id="typeBedRadio3">
                                              <label for="typeBedRadio3">
                                                  <span class="icon-bed-double vico-room-equip"></span>
                                              </label>
                                              <p for="typeBedRadio3">Doble</p>
                                          </div>


                                        </div>
                                      </div>
                                    </div>
                                  
                                </div>
                                {{-- END BED TYPE --}}
                                <hr>

                                {{-- BATH TYPE --}}
                                <div class="row mt-3">
                                  <div class="col-12">
                                  <div class="select-equip ">

                                    <p class=""><strong>Tipo de baño:</strong></p>
                                    <div class="equip-selector row justify-content-center">


                                          <div class="col-6 col-sm-3 equip">
                                              <input type="radio" value='Privado' name="bath_type"  class="form-check" id="typeBathRadio1" onclick="bath_shared.disabled=true"  >
                                              <label for="typeBathRadio1">
                                                  <span class="icon-private-bath-black vico-room-equip"></span>
                                              </label>
                                              <p for="typeBathRadio1">Privado</p>
                                          </div>
                                          <div class="col-6 col-sm-3 equip">

                                              <input type="radio" class="form-check" value='Compartido con:' name="bath_type" onclick="bath_shared.disabled = false; focusBathShared()" id="typeBathRadio2" checked>
                                              <label for="typeBathRadio2" >
                                                <span class="icon-bath-shared-3 vico-room-equip "><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span><span class="path11"></span><span class="path12"></span><span class="path13"></span><span class="path14"></span><span class="path15"></span><span class="path16"></span><span class="path17"></span><span class="path18"></span><span class="path19"></span><span class="path20"></span><span class="path21"></span><span class="path22"></span></span>
                                                  {{-- <span class="icon- vico-room-equip"></span> --}}
                                              </label>
                                              <p for="typeBathRadio2" class="mb-0">Compartido con: </p>
                                              <div class="">
                                                <input id="numBathShared" type="number" min="1" name="bath_shared" class="d-inline form-control form-control-sm col-4 ml-1 mr-1 verifiableRoom" required>
                                                <p class="form-check-label d-inline">
                                                  personas
                                                </p>
                                              </div>

                                          </div>



                                        </div>
                                      </div>
                                    </div>

                      
                                </div>
                                {{-- END BATH TYPE --}}

                              </div>
                              {{-- END STEP BODY --}}
                </div>
                {{-- END STEP 3 --}}
                {{-- STEP 4 --}}
                <div class="row steps" name="step4" id="step4">
                              {{-- STEP NUMBER AND NAME --}}

                              <div class="col-12">
                                  <div class="row">
                                    <div class="col-2 col-sm-1 num-icon">
                                      <span class="display-2 d-inline"><strong>4</strong></span>
                                    </div>
                                    <div class="col-10 col-sm-11">
                                        <h4 class="bold">AQUÍ PUEDES MENCIONAR COSAS EXTRAORDINARIAS</h4>

                                    </div>
                                  </div>
                                </div>
                              {{-- END STEP NUMBER AND NAME --}}
                              {{-- ROOM DESCRIPTION --}}

                              <div class="col-12 mt-3">
                              <p class="roomDesc mb-3 mb-0 mt-2 font-italic">Ejemplos: Balcon privado, un sofa, nevera privada etc.</p>

                                <textarea class="form-control" id="description" maxlength="766"></textarea>

                              </div>
                              {{-- END ROOM DESCRIPTION --}}
                </div>
                {{-- END STEP 4 --}}
                {{-- STEP 5 --}}
                <div class="row steps" name="step5" id="step5">
                              {{-- STEP NUMBER AND NAME --}}

                              <div class="col-12">
                                  <div class="row">
                                    <div class="col-2 col-sm-1 num-icon">
                                      <span class="display-2 d-inline"><strong>5</strong></span>
                                    </div>
                                    <div class="col-10 col-sm-11">
                                        <h4 class="bold">¿ESTA HABITACIÓN ESTÁ DISPONIBLE A PARTIR DE HOY?</h4>

                                    </div>
                                  </div>
                                </div>
                              {{-- END STEP NUMBER AND NAME --}}
                              {{-- STEP BODY --}}
                              <div class="col-12 mt-3">
                                {{-- DISPONIBILITY SELECTOR --}}
                                    <div class="col-12">

                                        <div class="select-equip ">

                                          <div class="equip-selector row justify-content-center">

                                            <div class="col-6 col-sm-3 equip">
                                                <input class="form-check availableInput" type="radio" name="isAvailable" id="dispoRadio1" value="1" checked>

                                                {{-- <input type="radio" value='Privado' name=""  class="form-check" id=""  > --}}
                                                <label for="dispoRadio1">
                                                    <span class="icon-check vico-room-equip"></span>
                                                </label>
                                                <p for="dispoRadio1">Si</p>
                                            </div>
                                            <div class="col-6 col-sm-3 equip">
                                                <input class="form-check mt-2 availableInput" type="radio" name="isAvailable" id="dispoRadio2" value="2" >

                                                <label for="dispoRadio2">
                                                  <span class="icon-close vico-room-equip ">
                                                </label>
                                              
                                                <div class="dispoRadio2">
                                                  <p for="dispoRadio2">No</p>                          
                                                <input class="form-control form-control-sm verifiableRoom d-block" min="{{$today_date}}" style="background-color: white" type="date" id="unavailable" autocomplete="off" placeholder="Date" readonly required disabled>
                                                </div>
                                              </div>
                                        </div>
                                      </div>

                                  
                                      <div class="form-check">
                                        <input class="form-check-input availableInput d-none" type="radio" name="isAvailable" id="dispoRadio3" value="3">
                                        <label class="form-check-label" for="dispoRadio3">
                                          {{-- Nunca (si es la tuya) --}}
                                        </label>
                                      </div>

                                  </div>
                                  {{-- END DISPONIBILITY SELECTOR --}}

                              </div>
                              {{-- END STEP BODY --}}
                </div>
                {{-- END STEP 5 --}}
              </div>
                {{-- STEP 6 --}}
                <div class="row steps unavailableRoom" id="unavailableRoom" name="step6">
                              {{-- STEP NUMBER AND NAME --}}

                              <div class="col-12">
                                  <div class="row">
                                    <div class="col-2 col-sm-1 num-icon">
                                      <span class="display-2 d-inline"><strong>6</strong></span>
                                    </div>
                                    <div class="col-10 col-sm-11">
                                        <h4 class="bold">¿QUIEN OCUPA LA HABITACIÓN POR EL MOMENTO?</h4>

                                    </div>
                                  </div>
                                </div>
                              {{-- END STEP NUMBER AND NAME --}}
                              {{-- STEP BODY --}}
                              <div class="col-12">


                                      <div class="select-equip ">
                                        <div class="row equip-selector justify-content-center mb-3">

                                          <div class="col-6 col-sm-3 equip form-check">
                                            <input type="radio" name="gender" value="1" id="create-male" checked>
                                            <label for="create-male">
                                                <span class="icon-man vico-room-equip"></span>
                                            </label>
                                          </div>
                                            <div class="col-6 col-sm-3 equip form-check">
                                            <input type="radio" name="gender" value="2" id="create-female">
                                            <label for="create-female">
                                                <span class="icon-woman vico-room-equip"></span>
                                            </label>
                                          </div>
                                        </div>
                                      </div>

                                <div class="mb-3 ">
                                  <p class=""> ¿De donde viene? </p>
                                  <select class="custom-select verifiableRoom" id="country" disabled required>
                                    <option value="" selected disabled>-- Seleccione --</option>
                                    @foreach($countries as $country)
                                      <option value='{{ $country->id}}'>{{ $country->name }}</option>
                                    @endforeach
                                  </select>
                                </div>
                                <div class="">
                                  <p > ¿Como se llama? </p>
                                  <input id="roomieName" type="text" class="form-control verifiableRoom" disabled required>
                                </div>
                              </div>
                              {{-- END STEP BODY --}}
                </div>
                {{-- END STEP 6 --}}
            </div>
            {{-- END CARD BODY --}}
          </div>
          {{-- END ROW --}}
          {{-- CONTINUE BUTTON --}}
          <div class="row justify-content-end m-3 ">
            <button type="button" class="btn btn-primary col-4 col-md-2" id="next">Siguiente</button>
          </div>
          {{-- END CONTINUE BUTTON --}}
        </div>
        {{-- END COLLAPSE --}}
      </div>
      {{-- END CARD --}}
      {{-- <input type="hidden" name="send" id="send"> --}}
    {{-- END FORM --}}     
  </div>