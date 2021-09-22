<div class="row fixed-bottom bg-white d-flex justify-content-center delete-fixed-bottom">
    @if($booking->status >= 1 && $booking->status <= 5)
        <div class="col-6 col-lg-3 px-lg-4 px-0 pl-3">
            <button type="button" class="btn btn-light h-100 btn-process" data-toggle="modal" data-target="#cancel" ><span class="icon-close" style="color: red;" ></span><br>Cancelar reserva</button>
        </div>
    @endif
    @if($booking->status == 2)
        <div class="col-6 col-lg-3 px-lg-4 px-0 pr-3">
            <form class="d-inline" method="POST" action="{{  URL::to('/booking/time') }}">
                @csrf
                <input type="hidden" name="id" value="{{$booking->id}}">
                <button type="button" class="btn btn-light h-100 btn-process" data-toggle="modal" data-target="#WantPayModal" ><span class="icon-check" style="color:green;"></span><br>¡Quiero pagar!</button>
            </form>
        </div>
    @endif

    @if($booking->status == 4)
        <div class="col-6 col-lg-3 px-lg-4 px-0 pr-3">
            <a type="" class="btn h-100 btn-process btn-light" href="{{ route('payments_deposit',['id' => $booking->id]) }}" ><span class="icon-check" style="color:green;"></span><br>Proceder al pago del deposito para la reserva</a>
        </div>
    @endif

    @if ($booking->status == 8)
        <div class="col-6 col-lg-3 px-lg-4 px-0 pr-3">
            <span class="btn h-100 btn-process btn-lightk">Notificaste que quieres cancelar esta solicitud, estamos en ello.</span>
        </div>
    @endif
</div>
