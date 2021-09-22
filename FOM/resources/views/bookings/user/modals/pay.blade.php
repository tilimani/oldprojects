<!-- MODAL -->
    <div class="modal fade" style="overflow:scroll" id="pay" tabindex="-1" role="dialog" aria-labelledby="pay" aria-hidden="true" style="overflow:scroll">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Enviar forma de pago</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" class="screenshot_load_form_{{$booking->status + 1}}" action="{{ URL::to('/booking/screenshot/load') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <label>Carga el comprobante de pago (screenshot o foto del tiket)</label>
                        <input type="hidden" name="booking_id" value="{{$booking->id}}">
                        <div class="col-sm-6">
                            <input type="file" name="image" multiple required>
                            <label for="image">Foto de comprobante</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary AcceptButton" value-form="screenshot_load_form_{{$booking->status + 1}}" data-dismiss="modal">Enviar</button>
                </div>
            </div>
        </div>
    </div>
{{-- END MODAL --}}
