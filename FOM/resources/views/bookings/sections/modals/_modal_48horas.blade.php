<!-- Modal 48horas -->
      <div class="modal fade" style="overflow:scroll" id="acepted48" tabindex="-1" role="dialog" aria-labelledby="Accepted request" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Plazo de 48horas</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="icon-close"></span>
              </button>
            </div>
            @if($booking->status == 1)
              <form method="POST"class="acept_form_{{$booking->status + 1}}" action="{{ URL::to('/booking/acepted') }}" enctype="multipart/form-data">
              @else
                <form method="POST" class="acept_form_{{$booking->status + 1}}" action="{{ URL::to('/booking/reserved') }}" enctype="multipart/form-data">
                @endif
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{$booking->id}}">
                <input type="hidden" name="email" value="{{$user->email}}">
                <input type="hidden" name="created_at" value="{{$booking->created_at}}">
                <input type="hidden" name="manager_name" value="{{$manager->name}}">
                <input type="hidden" name="room_number" value="{{$room->number}}">
                <input type="hidden" name="date_from" value="{{$booking->date_from}}">
                <input type="hidden" name="date_to" value="{{$booking->date_to}}">
                <input type="hidden" name="name" value="{{$user->name}}">
                <input type="hidden" name="last_name" value="{{$user->last_name}}">

                <!-- Modal body -->
                <div class="modal-body">
                  <div class="col">
                    <p>Debido a que las transferencias internacionales se demoran hasta 48 horas, tenemos que esperar este tiempo para que el estudiante pueda pagar el depósito. Una vez recibimos este pago, te notificamos.</p>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary AcceptButton" value-form="acept_form_{{$booking->status + 1}}" data-dismiss="modal">Doy 48 horas de plazo para pagar.</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" style="overflow:scroll" id="deny" tabindex="-1" role="dialog" aria-labelledby="Deny request" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Rechazar solicitud</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  x
                </button>
              </div>
              <div class="modal-body">
                <p>¿Porque rechazas esa solicitud?</p>
                <label for="message_admin">Responde al solicitante con un pequeño mensaje:</label>
                <textarea name="message_admin" placeholder="Hola {{$user->name}}, ..."></textarea>      </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Enviar y confirmar reserva.</button>
                </div>
              </div>
            </div>
          </div>


          <div class="modal fade" style="overflow:scroll" id="Deny">
            <div class="modal-dialog">
              <div class="modal-content text-center">
                <!-- Modal Header -->
                <div class="modal-header">
                  <h3 class="modal-title">¿Porque rechazas la solicitud?</h3>
                  <button type="button" class="close" data-dismiss="modal"><span class="icon-close"></span></button>
                </div>
                <div class="row justify-content-center denyOptions">
                  <div class="col-6 col-sm-3 option p-3" id="unavailableCollapseBtn">
                    <div>
                      <p>La habitación ya está ocupada.</p>
                      <img class="" style="height: 3rem; width: 3rem" src="{{asset('images/mode/1.png') }}" alt="booking_mode" srcset="{{asset('images/mode/1@2x.png') }} 2x, {{asset('images/mode/1@3x.png') }} 3x" />
                    </div>
                  </div>
                  <div class="col-6 col-sm-3 option p-3" id="profileCollapseBtn">
                    <div >
                      <p>Por otras razones.</p>
                      <span class="icon-no-user optionIcon"></span>
                    </div>
                  </div>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                  <div class="col">
                    <div class="card card-body border-0">
                      {{-- COLLAPSE --}}
                      <div class="collapse multi-collapse" id="profileCollapse">
                        {{-- DENY FORM: PROFILE --}}
                        <form method="POST" class="denied_form_{{$booking->status + 1}}" action="{{ URL::to('/booking/denied') }}">
                          {{ csrf_field() }}
                          <input type="hidden" name="id" value="{{$booking->id}}">
                          <input type="hidden" name="flag" value="0">
                          <div class="col-12">
                            <div class="panel-body col-12">
                              <p>Si quieres, puedes mandar un mensaje a {{$user->name}} explicando porque no lo puedes recibir.
                              <textarea  class="form-control col-12" name="message"></textarea>
                            </div>
                            <div class="mt-2 mb-2" >
                              <button type="button" class="btn btn-link" data-dismiss="modal">Volver</button>
                              <button type="button" class="btn btn-primary CancelButton" value-form="denied_form_{{$booking->status + 1}}" data-dismiss="modal">Enviar</button>
                            </div>
                          </div>
                        </form>
                        {{-- END DENY FORM: PROFILE --}}
                      </div>
                      {{-- END COLLAPSE --}}
                      {{-- COLLAPSE --}}
                      <div class="collapse multi-collapse" id="unavailableCollapse">
                        {{-- DENY FORM: UNAVAILABLE --}}
                        <form id="formInputs" class="denied_2_form_{{$booking->status + 1}}" method="POST" action="{{ URL::to('/booking/denied') }}" enctype="multipart/form-data">
                          {{ csrf_field() }}
                          <input type="hidden" name="id" value="{{$booking->id}}">
                          <input type="hidden" name="flag" value="1">
                          <input type="hidden" name="room_id" value="{{$booking->room_id}}">
                          <input type="hidden" name="email" value="{{$user->email}}">
                          {{-- INIT TAB --}}
                          <div class="tab">
                            <h5>La habitación esta ocupada por:</h5>
                            <p><input type="text" id="nameInput" name="name" placeholder="ej: Manuel" class="form-control requiredInput"/></p>
                          </div>
                          {{-- END INIT TAB --}}
                          {{-- TAB --}}
                          <div class="tab show">
                            <h5 class="currentHomemate d-inline-block"></h5><h5 class="d-inline"> ocupa esta habitación</h5>
                            <div class="mb-4">
                              <div>
                                <h5 class="d-inline-block mr-3">desde</h5>
                                <input name="date_from" type="date" value="{{$today_date}}" oninput="this.className = 'form-control form-control-sm d-inline-block w-50'" class="form-control form-control-sm w-50 d-inline-block " max="{{$today_date}}" />
                              </div>
                              <div>
                                <h5 class="d-inline-block">hasta el </h5>
                                <input name="dateto" id="dateto" min="{{$today_date}}" type="date" class="form-control form-control-sm requiredInput d-inline-block w-50"/>
                              </div>
                            </div>
                          </div>
                          {{-- END TAB --}}
                          {{-- TAB --}}
                          <div class="tab show">
                            <h5 class="d-inline-block">¿ </h5><h5 class="currentHomemate d-inline-block"></h5><h5 class="d-inline"> es hombre o mujer?</h5>
                            <div class="create">
                              <div class="create-vico">
                                <div class="select-equip ">
                                  <div class="equip-selector row justify-content-center">

                                    {{-- RADIOBUTTON TYPE:MALE --}}
                                    <div class="col-4 col-sm-3 equip">
                                      <input type="radio" name="gender" value="1" id="denyMale">
                                      <label for="denyMale">
                                        <span class="icon-man vico-room-equip"></span>
                                      </label>
                                    </div>
                                    {{-- END RADIOBUTTON TYPE:MALE --}}

                                    {{-- RADIOBUTTON TYPE:FEMALE --}}
                                    <div class="col-4 col-sm-3 equip">
                                      <input type="radio" name="gender" value="0" id="denyFemale">
                                      <label for="denyFemale">
                                        <span class="icon-woman vico-room-equip"></span>
                                      </label>
                                    </div>
                                    {{-- END RADIOBUTTON TYPE:FEMALE --}}

                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          {{-- END TAB --}}
                          {{-- INIT TAB --}}
                          <div class="tab show">
                            <h5 class="d-inline">¿De dónde viene </h5><h5 class="currentHomemate d-inline-block"></h5><h5 class="d-inline-block"> ?</h5>
                            <p>
                              <select class="form-control requiredInput" id="country" name="country" required>
                                <option disabled selected value="0">-- seleccione --</option>
                                @foreach ($countries as $country)
                                  <option value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                              </select>
                            </p>
                          </div>
                          {{-- END INIT TAB --}}
                          {{-- INIT TAB --}}
                          {{-- <div class="tab show">
                          <h5 class="d-inline">Muchas gracias por tu respuesta</h5>
                          <div class="finalTab">
                          <label>
                          <span class="icon-check vico-room-equip"></span>
                        </label>
                      </div>
                      <h5 class="d-inline"></h5>
                    </div> --}}
                    {{-- END INIT TAB --}}
                    {{-- TAB BUTTONS --}}
                    <div>
                      <div style="float:right;">
                        <a type="" class="btn btn-light" id="prevBtn" >Atras</a>
                        <a type="" class="btn btn-primary" id="nextBtn" >Continuar</a>
                      </div>
                    </div>
                    {{-- END TAB BUTTONS --}}
                    {{-- TAB STEPS --}}
                    <div style="margin-top:5rem;" class="d-none">
                      <span class="step"></span>
                      <span class="step"></span>
                      <span class="step"></span>
                      <span class="step"></span>
                      {{-- <span class="step"></span>                                           --}}
                    </div>
                    {{-- END TAB STEPS --}}
                    {{-- SUBMIT BUTTON --}}
                    <button type="button" id="stepsSubmit" class="d-none CancelButton" value-form="denied_2_form_{{$booking->status + 1}}" data-dismiss="modal"></button>
                    {{-- END SUBMIT BUTTON --}}
                  </form>
                  {{-- END DENY FORM: UNAVAILABLE --}}

                </div>
                {{-- END COLLAPSE --}}
              </div>
            </div>
          </div>

          <div id="collapse2" class="panel-collapse collapse">
            <form method="POST" action="{{ URL::to('/booking/denied') }}" class="denied_3_form_{{$booking->status + 1}}" enctype="multipart/form-data">
              {{ csrf_field() }}
              <input type="hidden" name="id" value="{{$booking->id}}">
              <input type="hidden" name="flag" value="2">
              <input type="hidden" name="email" value="{{$user->email}}">
              <div class="col-12">
                <div class="panel-body col-12">
                  <label>¿Porqué no quieres recibir a {{$user->name}}?</label>
                  <textarea  class="form-control col-12" name="message" placeholder="Tu respuesta"></textarea>
                </div>
                <div class="mt-2 mb-2" >
                  <button type="button" class="btn btn-link" data-dismiss="modal">Volver</button>
                  <button type="button" class="btn btn-primary CancelButton" value-form="denied_3_form_{{$booking->status + 1}}" data-dismiss="modal">Enviar</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
