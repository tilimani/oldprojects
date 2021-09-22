<div class="modal fade" style="overflow:scroll" id="cancel" tabindex="-1" role="dialog" aria-labelledby="cancel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cancelar solicitud</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <p>¿Estás seguro que quieres cancelar esta solicitud?</p>
            <p>Ten en cuenta que esta solicitud ya está pagada.</p>
            </div>
            <div class="modal-footer">
            <form  class="d-inline cancel_form_{{$booking->status + 1}}" method="POST" action="{{ route('cancel.request.manager') }}">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{$booking->id}}">
                <button type="button" class="btn btn-light w-100 btn-process CancelButton"  data-dismiss="modal" value-form="cancel_form_{{$booking->status + 1}}"><span class="icon-close" style="color: red"></span><br>Si, quiero cancelar la solicitud.</button>
            </form>
            </div>
        </div>
    </div>
</div>