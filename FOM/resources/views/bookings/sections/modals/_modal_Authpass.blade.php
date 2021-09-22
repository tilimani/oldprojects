<div class="modal fade" style="overflow:scroll" id="authBookingsModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          {{-- <h5 class="modal-title">holi</h5> --}}
          <a class="brand" href="/"><img  style="height: 50px; width: 122px" src="{{asset("images/Friends-of-Medellin-Logo.png")}}" srcset="{{asset("images/Friends-of-Medellin-Logo@2x.png")}} 2x, {{asset("images/Friends-of-Medellin-Logo@3x.png")}} 3x" alt="Friends of Medellín"></a>

        </div>
          <!-- Modal body -->
          @if($manager->phone != "")
          <div class="modal-body">
            <div class="col">
              <p>Por favor ingresa tu código de acceso para ingresar a la solicitud.</p>
              <input type="password" id="bookingPass" class="form-control">
              <label id="errorMsg" for="bookingPass">Código inválido</label>
              <button type="button" id="bookingPassBtn" class="btn btn-primary btn-block mt-2">¡Vamos!</button>

            </div>
          </div>
          <div class="modal-footer">
              <a href="https://wa.me/573054440424" target="_blank">¿No sabes cual es tu código? Pónte en contacto con nosotros.</a>
          </div>
          @else
          <div class="modal-body">
              <div class="col">
                <a href="https://wa.me/573054440424" target="_blank">¿No tienes código? Pide uno.</a>
              </div>
            </div>
          @endif
      </div>
    </div>
  </div>
