{{-- ========= PROCESS MODAL ==========  --}}
    <div class="modal fade" style="overflow:scroll;" id="owner-process" tabindex="-1" role="dialog" aria-labelledby="explicación del proceso" aria-hidden="true" >
      <div class="modal-dialog modal-lg modal-centered" role="document">
        <div class="modal-content">
          <div class="modal-header align-items-center">
            <p class="modal-title h4 text-center" id="modalProcessTittle">El proceso</p>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"><span class="icon-close"></span></span>
            </button>
          </div>
          <div class="modal-body">
            <div class="container-fluid">
              <div class="col-md-10 col-12 mx-auto">
              {{-- ROW-PROCESS --}}
              <div class="row mb-4">
                {{-- PROCESS ICON --}}
                <div class="col-3 text-center">
                  <div class="booking-show-process-circle">
                    <img style="height: 64px; width: 64px" src="{{asset('images/process/modal/request.png')}}" alt="independent" srcset="{{asset('images/process/modal/request@2x.png')}} 2x, {{asset('images/process/modal/request@3x.png')}} 3x" />
                  </div>
                </div>
                 {{-- END PROCESS ICON --}}
                {{-- PROCESS EXPLANATION --}}
                <div class="col-9 pr-0 pr-md-4">
                  <ul class="bullet-points-off">
                    <li><p class="h5 mb-0 mt-1">1. La solicitud</p>
                    </li>
                    <li><p class="font-weight-light text-justify">Primero solicitas la reserva de la habitación.</p>
                    </li>
                  </ul>
                </div>
                {{-- END PROCESS EXPLANATION --}}
              </div>
              {{-- END ROW-PROCESS --}}

              {{-- ROW-PROCESS --}}
              <div class="row mb-4">
                {{-- PROCESS ICON --}}
                <div class="col-3 text-center">
                  <div class="booking-show-process-circle">
                    <img style="height: 64px; width: 64px" src="{{asset('images/process/modal/chat.png')}}" alt="independent" srcset="{{asset('images/process/modal/chat@2x.png')}} 2x, {{asset('images/process/modal/chat@3x.png')}} 3x" />
                  </div>
                </div>
                {{-- END PROCESS ICON --}}
                {{-- PROCESS EXPLANATION --}}
                <div class="col-9 pr-0 pr-md-4">
                  <ul class="bullet-points-off">
                    <li><p class="h5 mb-0 mt-1">2. El chat</p>
                    </li>
                    <li><p class="font-weight-light text-justify">En nuestro chat seguro, pueden resolver todas las preguntas y dudas que tengan y conocerse mejor. </p>
                    </li>
                  </ul>
                </div>
                {{-- END PROCESS EXPLANATION --}}
              </div>
              {{-- END ROW-PROCESS --}}

              {{-- ROW-PROCESS --}}
              <div class="row mb-4">
                {{-- PROCESS ICON --}}
                <div class="col-3 text-center">
                  <div class="booking-show-process-circle">
                    <img style="height: 64px; width: 64px" src="{{asset('images/process/modal/accept.png')}}" alt="independent" srcset="{{asset('images/process/modal/accept@2x.png')}} 2x, {{asset('images/process/modal/accept@3x.png')}} 3x" />
                  </div>
                </div>
                {{-- END PROCESS ICON --}}
                {{-- PROCESS EXPLANATION --}}
                <div class="col-9 pr-0 pr-md-4">
                  <ul class="bullet-points-off">
                    <li><p class="h5 mb-0 mt-1">3. La aceptación.</p>
                    </li>
                    <li><p class="font-weight-light text-justify">Al aceptar, el dueño te brinda un plazo de 24 horas de exclusividad para realizar el pago de reserva (la primera renta mensual).</p>
                    </li>
                  </ul>
                </div>
                {{-- END PROCESS EXPLANATION --}}
              </div>
             {{-- END ROW-PROCESS --}}

             {{-- ROW-PROCESS --}}
              <div class="row mb-4">
                {{-- PROCESS ICON --}}
                <div class="col-3 text-center">
                  <div class="booking-show-process-circle">
                    <img style="height: 64px; width: 64px" src="{{asset('images/process/modal/creditcard.png')}}" alt="independent" srcset="{{asset('images/process/modal/creditcard@2x.png')}} 2x, {{asset('images/process/modal/creditcard@3x.png')}} 3x" />
                  </div>
                </div>
                {{-- END PROCESS ICON --}}
                {{-- PROCESS EXPLANATION --}}
                <div class="col-9 pr-0 pr-md-4">
                  <ul class="bullet-points-off">
                    <li><p class="h5 mb-0 mt-1">4. El pago de reserva.</p>
                    </li>
                    <li><p class="font-weight-light text-justify">Apenas realizas el pago de reserva, te llega una notificación con la confirmación de reserva. Apenas que llegas y nos confirmas que la habitación y la VICO se encuentren en las condiciones comunicadas en la plataforma pasamos la renta mensual al dueño de la VICO.</p>
                    </li>
                  </ul>
                </div>
                {{-- END PROCESS EXPLANATION --}}
              </div>
               {{-- END ROW-PROCESS --}}
             </div>
            </div>
            <p class="text-center font-weight-bold">Próximos pasos: Facilita los pagos online de las rentas mensuales.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
          </div>
        </div>
      </div>
    </div>
    {{-- ========= Modal Process End  ========== --}}