
{{-- This function was done by Martelo in order to show the process in the booking view. --}}


 {{-- HIDE PROCESS IN STATUS 5 --}}
     @if($booking->status == 5 ||true)
     @else
        <div class="row ml-1 d-block" id="procesoStatus">
          @if($booking->status == 50)
            <p class="h4 mb-0">En proceso (4/5)</p>
            <p class="h4 mb-0">Estamos verificando el pago.</p>
          @else
            <p class="h4 mb-0">En proceso ({{$booking->status}}/5)</p>
            @if($booking->status == 2 || $booking->status == 4 )
              <p class="h4 mb-0">Estamos esperando la respuesta de {{$user->name}}</p>
            @else
              <p class="h4 mb-0">Necesitamos una respuesta tuya.</p>
            @endif
          @endif
        </div>

        <div class="row">
          <div class="col-12 p-0">
            {{-- NEW PROGRESS --}}
            <ul class="notification-bar">
              <li>
                @if($booking->status == 1)
                  <li class="active">
                    <i>1</i>
                  @endif
                  @if($booking->status > 1)
                    <li class="completed">
                    @endif
                    @if($booking->status != 1)
                      <i>&#10004;</i>
                    @endif
                    <div class="card">
                      <header class="card-header">
                        <a href="#" data-toggle="collapse" data-target="#state1" aria-expanded="true" class="">
                          <span class="title">Disponible</span>
                          <span class="icon-next-fom"></span>
                        </a>
                      </header>
                      <div class="collapse" id="state1" style="">
                        <p class="card-body">
                          En el primer paso tu confirmas la disponibilidad de la habitación para la fecha de llegada de {{$user->name}}.
                        </p> <!-- card-body.// -->
                      </div> <!-- collapse .// -->
                    </div> <!-- card.// -->
                  </li>
                  <li>
                    @if($booking->status == 2)
                      <li class="active">
                        <i>2</i>
                      @endif
                      @if($booking->status > 2)
                        <li class="completed">
                        @endif
                        @if($booking->status != 2)
                          <i>&#10004;</i>
                        @endif
                        <div class="card">
                          <header class="card-header">
                            <a href="#" data-toggle="collapse" data-target="#state2" aria-expanded="true" class="">
                              <span class="title">Voluntad de pago</span>
                              <span class="icon-next-fom"></span>
                            </a>
                          </header>
                          <div class="collapse" id="state2" style="">
                            <p class="card-body">
                              {{$user->name}} confirma que va a pagar el deposito.
                            </p> <!-- card-body.// -->
                          </div> <!-- collapse .// -->
                        </div> <!-- card.// -->
                      </li>
                      <li>
                        @if($booking->status == 3)
                          <li class="active">
                            <i>3</i>
                          @endif
                          @if($booking->status > 3)
                            <li class="completed">
                            @endif
                            @if($booking->status != 3)
                              <i>&#10004;</i>
                            @endif
                            <div class="card">
                              <header class="card-header">
                                <a href="#" data-toggle="collapse" data-target="#state3" aria-expanded="true" class="">
                                  <span class="title">Plazo 48 Horas</span>
                                  <span class="icon-next-fom"></span>
                                </a>
                              </header>
                              <div class="collapse" id="state3" style="">
                                <p class="card-body">
                                  Debido a que las transferencias internacionales se pueden demora, tienes que confirma que la habitación esta bloqueada para los próximos 48h.
                                </p> <!-- card-body.// -->
                              </div> <!-- collapse .// -->
                            </div> <!-- card.// -->
                          </li>
                          <li>
                            @if($booking->status == 4  || $booking->status == 50)
                              <li class="active">
                                <i>4</i>
                              @elseif($booking->status > 4)
                                <li class="completed">
                                <i>&#10004;</i>
                                @elseif($booking->status != 4 and 50)
                                  <i>&#10004;</i>
                                @endif
                                <div class="card">
                                  <header class="card-header">
                                    <a href="#" data-toggle="collapse" data-target="#state4" aria-expanded="true" class="">
                                      <span class="title">Proceso de pago</span>
                                      <span class="icon-next-fom"></span>
                                    </a>
                                  </header>
                                  <div class="collapse" id="state4" style="">
                                    <p class="card-body">
                                      {{$user->name}} tiene 48h para realizar el pago, el sube un screenshot de la transferencia y la habitación queda bloqueda.
                                    </p> <!-- card-body.// -->
                                  </div> <!-- collapse .// -->
                                </div> <!-- card.// -->
                              </li>
                              <li>
                                @if($booking->status == 5)
                                  <li class="active">
                                    <i>5</i>
                                  @endif
                                  @if($booking->status > 5)
                                    <li class="completed">
                                    @endif
                                    @if($booking->status != 5)
                                      <i>&#10004;</i>
                                    @endif
                                    <div class="card">
                                      <header class="card-header">
                                        <a href="#" data-toggle="collapse" data-target="#state5" aria-expanded="true" class="">
                                          <span class="title">Confirmación</span>
                                          <span class="icon-next-fom"></span>
                                        </a>
                                      </header>
                                      <div class="collapse" id="state5" style="">
                                        <p class="card-body">
                                          Todo listo, ahora tienes que asegurar que la habitación realmente queda disponible para la llegada de {{$user->name}} .
                                        </p> <!-- card-body.// -->
                                      </div> <!-- collapse .// -->
                                    </div> <!-- card.// -->
                                  </li>
                                </ul>
                              </div>
                            </div>
    @endif
   {{-- END HIDE PROCESS IN STATUS 5 --}}



   {{-- From the user.request.view --}}
   {{-- HIDE PROCESS IN STATUS 5 --}}
                    @if($booking->status == 5||true)
                    @else
                    <div class="row ml-1 d-block" id="procesoStatus">
                        @if($booking->status == 50)
                        <p class="h4 mb-0">En proceso (4/5)</p>
                        <p class="h4 mb-0">Estamos verificando el pago.</p>
                        @else
                            <p class="h4 mb-0">En proceso ({{$booking->status}}/5)</p>
                            @if($booking->status == 1 || $booking->status == 3 )
                            <p class="h4 mb-0">Estamos esperando la respuesta de {{$booking->manager_info->name}}</p>
                            @else
                            <p class="h4 mb-0">Necesitamos una respuesta tuya.</p>
                            @endif
                        @endif
                    </div>

                    <div class="row">
                            <div class="col-12 p-0">
                                {{-- NEW PROGRESS --}}
                                <ul class="notification-bar">
                                    <li>
                                    @if($booking->status == 1)
                                        <li class="active">
                                        <i>1</i>
                                    @endif
                                    @if($booking->status > 1)
                                        <li class="completed">
                                    @endif
                                    @if($booking->status != 1)
                                        <i>&#10004;</i>
                                    @endif
                                        <div class="card">
                                            <header class="card-header">
                                                <a href="#" data-toggle="collapse" data-target="#state1" aria-expanded="true" class="">
                                                    <span class="title">Disponible</span>
                                                    <span class="icon-next-fom"></span>
                                                </a>
                                            </header>
                                            <div class="collapse" id="state1" style="">
                                                <p class="card-body">
                                                   En el primer paso el administrador de la VICO confirma la disponibilidad de la habitación para tu fecha de llegada.
                                                </p> <!-- card-body.// -->
                                            </div> <!-- collapse .// -->
                                        </div> <!-- card.// -->
                                    </li>
                                    <li>
                                    @if($booking->status == 2)
                                        <li class="active">
                                        <i>2</i>
                                    @endif
                                    @if($booking->status > 2)
                                        <li class="completed">
                                    @endif
                                    @if($booking->status != 2)
                                        <i>&#10004;</i>
                                    @endif
                                        <div class="card">
                                            <header class="card-header">
                                                <a href="#" data-toggle="collapse" data-target="#state2" aria-expanded="true" class="">
                                                    <span class="title">Voluntad de pago</span>
                                                    <span class="icon-next-fom"></span>
                                                </a>
                                            </header>
                                            <div class="collapse" id="state2" style="">
                                                <p class="card-body">
                                                    Tienes que confirmar que vas a pagar el deposito para esta habitación.
                                                </p> <!-- card-body.// -->
                                            </div> <!-- collapse .// -->
                                        </div> <!-- card.// -->
                                    </li>
                                    <li>
                                    @if($booking->status == 3)
                                        <li class="active">
                                        <i>3</i>
                                    @endif
                                    @if($booking->status > 3)
                                        <li class="completed">
                                    @endif
                                    @if($booking->status != 3)
                                        <i>&#10004;</i>
                                    @endif
                                        <div class="card">
                                            <header class="card-header">
                                                <a href="#" data-toggle="collapse" data-target="#state3" aria-expanded="true" class="">
                                                    <span class="title">Plazo 48 Horas</span>
                                                    <span class="icon-next-fom"></span>
                                                </a>
                                            </header>
                                            <div class="collapse" id="state3" style="">
                                                <p class="card-body">
                                                    Debido a que las transferencias internacionales se pueden demora {{$booking->manager_info->name}} confirma que la habitación esta bloqueada para los próximos 48h.
                                                </p> <!-- card-body.// -->
                                            </div> <!-- collapse .// -->
                                        </div> <!-- card.// -->
                                    </li>
                                    <li>
                                @if($booking->status == 4  || $booking->status == 50)
                                    <li class="active">
                                    <i>4</i>
                                @elseif($booking->status > 4)
                                    <li class="completed">
                                    <i>&#10004;</i>
                                @elseif($booking->status != 4 and 50)
                                    <i>&#10004;</i>
                                @endif
                                        <div class="card">
                                            <header class="card-header">
                                                <a href="#" data-toggle="collapse" data-target="#state4" aria-expanded="true" class="">
                                                    <span class="title">Proceso de pago</span>
                                                    <span class="icon-next-fom"></span>
                                                </a>
                                            </header>
                                            <div class="collapse" id="state4" style="">
                                                <p class="card-body">
                                                    Tienes 48h para realizar el pago, subas un screenshot de la transferencia y la habitación se queda bloqueda.
                                                </p> <!-- card-body.// -->
                                            </div> <!-- collapse .// -->
                                        </div> <!-- card.// -->
                                    </li>
                                    <li>
                                        @if($booking->status == 5)
                                            <li class="active">
                                            <i>5</i>
                                        @endif
                                        @if($booking->status > 5)
                                            <li class="completed">
                                        @endif
                                        @if($booking->status != 5)
                                            <i>&#10004;</i>
                                        @endif
                                        <div class="card">
                                            <header class="card-header">
                                                <a href="#" data-toggle="collapse" data-target="#state5" aria-expanded="true" class="">
                                                    <span class="title">Confirmación</span>
                                                    <span class="icon-next-fom"></span>
                                                </a>
                                            </header>
                                            <div class="collapse" id="state5" style="">
                                                <p class="card-body">
                                                    Todo listo, la habitación esta reservada para el día de tu llegada.
                                                </p> <!-- card-body.// -->
                                            </div> <!-- collapse .// -->
                                        </div> <!-- card.// -->
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @endif
                  {{-- END HIDE PROCESS IN STATUS 5 --}}