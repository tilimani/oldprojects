<div class="modal fade" style="overflow:scroll" id="Acepted" tabindex="-1" role="dialog" aria-labelledby="Accepted request" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Aceptar solicitud</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              x
            </button>
          </div>
          @if($booking->status == 1)
            <form method="POST" class="reserved_form_{{$booking->status + 1}}" action="{{ URL::to('/booking/acepted') }}" enctype="multipart/form-data">
            @else
              <form method="POST" class="reserved_form_{{$booking->status + 1}}" action="{{ URL::to('/booking/reserved') }}" enctype="multipart/form-data">
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
                  {{-- <label for="message_admin">Respuesta al estudiante:</label> --}}
                  <textarea class="w-100 form-control d-none" name="message_admin" placeholder="Hola {{$user->name}}, con mucho gusto te recibo en mi VICO."></textarea>
                  <p>ATENCIÓN: Al aceptar la solicitud, le brindas un plazo de 24 horas de exclusividad a {{$user->name}}. En caso que no se realice el pago de la reserva en las próximas 24 horas, automáticamente se habilita la habitación nuevamente.</p>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary AcceptButton" value-form="reserved_form_{{$booking->status + 1}}" data-dismiss="modal">Confirmar disponibilidad.</button>
              </div>
            </form>
          </div>
        </div>
      </div>



      <div class="modal fade" style="overflow:scroll" id="Acepted" tabindex="-1" role="dialog" aria-labelledby="Accepted request" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Confirmar la disponibilidad y aceptar la solicitud</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              x
            </button>
          </div>
          @if($booking->status == 1)
            <form method="POST" class="acepted_form_{{$booking->status + 1}}" action="{{ URL::to('/booking/acepted') }}" enctype="multipart/form-data">
            @else
              <form method="POST" class="acepted_form_{{$booking->status + 1}}" action="{{ URL::to('/booking/reserved') }}" enctype="multipart/form-data">
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
                <div class="row">
                  <div class="col-12 col-md-2 d-flex justify-content-around align-items-center">
                    <img style="height: 64px; width: 64px" src="{{asset('images/process/warning.png')}}" alt="independent" srcset="{{asset('images/process/warning@2x.png')}} 2x, {{asset('images/process/warning@3x.png')}} 3x" />
                  </div>
                  <div class="col-12 col-md-10">
                  <p>ATENCIÓN: Al aceptar la solicitud, le <strong>brindas un plazo de 24 horas de exclusividad a {{$user->name}}</strong>. En caso que no se realice el pago de la reserva en las próximas 24 horas, automáticamente se habilita la habitación nuevamente.</p>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                <button type="Button" class="btn btn-primary AcceptButton" value-form="acepted_form_{{$booking->status + 1}}" data-dismiss="modal">Confirmar disponibilidad y esperar pago.</button>
              </div>
            </form>
          </div>
        </div>
      </div>
