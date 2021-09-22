<div class="pt-5 tuto-step1">
    <div class="row fixed-bottom delete-fixed-bottom bg-white d-flex justify-content-center">

        @if($booking->status == 1 && ($available == false))
            <div class="col-6 col-lg-3 px-lg-4 px-0 pl-3">
                <button type="button" class="h-100 btn btn-process" data-toggle="modal" id="denyBtn" data-target="#Deny"><span class="icon-close" style="color: red;" ></span><br>Rechazar</button>
            </div>
            <div class="col-6 col-lg-3 px-lg-4 px-0 pr-3">
                <button type="button" class="h-100 btn btn-process" data-toggle="modal" data-target="#Acepted"><span class="icon-check" style="color:green;"></span><br>Confirmar disponibilidad & aceptar solicitud.</button>
            </div>
        @endif

        @if($booking->status == 2)
            <div class="col-6 col-lg-3 px-lg-4 px-0 pl-3">
                <button type="button" class="h-100 btn btn-process" data-toggle="modal" id="denyBtn" data-target="#Deny"><span class="icon-close" style="color: red;" ></span><br>Rechazar</button>
            </div>
        @endif
        @if($booking->status == 3 && ($available == false))
            <div class="col-6 col-lg-3 px-lg-4 px-0 pl-3">
                <button type="button" class="h-100 btn btn-process" data-toggle="modal" id="denyBtn" data-target="#Deny"><span class="icon-close" style="color: red;" ></span><br>Rechazar</button>
            </div>
            <div class="col-6 col-lg-3 px-lg-4 px-0 pr-3">
                <button type="button" class="h-100 btn btn-process" data-toggle="modal" data-target="#acepted48" ><span class="icon-check" style="color:green;"></span><br>Doy 48 horas de exclusividad</button>
            </div>

        @elseif($booking->status == 3)
            <div class="col-6 col-lg-3 px-lg-4 px-0 pl-3">
                <button type="button" class="h-100 btn btn-process" data-toggle="modal" id="denyBtn" data-target="#Deny"><span class="icon-close" style="color: red;" ></span><br>Rechazar</button>
            </div>
            <div class="col-6 col-lg-3 px-lg-4 px-0 pr-3">
                <button type="button" class="h-100 btn btn-process" data-toggle="modal" data-target="#acepted48" disabled="true"><span class="icon-check" style="color:green;"></span><br>Doy 48 horas de exclusividad</button>
            </div>
        @endif
        @if($booking->status == 5)
          <div class="col-6 col-lg-3 px-lg-4 px-0 pl-3">
            <button type="button" class="btn btn-light h-100 btn-process" data-toggle="modal" data-target="#cancel" ><span class="icon-close" style="color: red;" ></span><br>Cancelar esta solicitud</button>
          </div>
        @endif
        @if ($booking->status == 9)
          <div class="col-6 col-lg-3 px-lg-4 px-0 pr-3">
            <span class="btn h-100 btn-process btn-lightk">Notificaste que quieres cancelar esta solicitud, estamos en ello.</span>
          </div>
        @endif
        @if ($booking->status == 8)
            <div class="col-6 col-lg-3 px-lg-4 px-0 pr-3">
            <span class="btn h-100 btn-process btn-lightk">El usuario ha notificado que quiere cancelar esta solicitud, estamos en ello. Ponte en contacto con nosotros para saber más.</span>
            </div>
        @endif 
    </div>
</div>
