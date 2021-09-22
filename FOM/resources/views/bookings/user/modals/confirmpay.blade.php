{{--CONFIRM PAY MODAL--}}
    <div class="modal fade" style="overflow:scroll" id="WantPayModal" tabindex="-1" role="dialog" aria-labelledby="Accepted request" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Quiero Pagar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        x
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col">
                        <p>Gracias por tu respuesta, cuando el dueño acepte el pago la habitacion quedará reservada.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <form class="d-inline time_form_{{$booking->status + 1}}" method="POST" action="{{  URL::to('/booking/time') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{$booking->id}}">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        <button type="Button" class="btn btn-primary AcceptButton" value-form="time_form_{{$booking->status + 1}}" data-dismiss="modal">Confirmo que quiero pagar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
{{--END CONFIRM PAY MODAL--}}
