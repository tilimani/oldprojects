{{--FIRST STEP CHAT--}}
<div class="row">
  <div class="col-12 d-flex justify-content-center align-self-center">
      <p class="chat-item fom-chat"> <img alt="safety" height="20px" width="20px" src="{{asset("images/process/safety.png")}}" srcset="{{asset("images/process/safety@2x.png")}} 2x, {{asset("images/process/safety@3x.png")}} 3x"> Protege tu seguridad conversando dentro del chat y realizando todos los pagos con VICO. Con el fin de garantizar reservas seguras y rápidas no se permite enviar números telefónicos o correos electrónicos.</p>
  </div>
  <div class="col-12">
    <p class="chat-item">@if($booking->message == "") Hola {{$booking->manager_info->name}}, me gusta tu VICO, ¿la habitación queda disponible? @else {!! nl2br($booking->message) !!}<span class="time-chat mb-3">{{date("d/m/y - h:i a", strtotime($booking->created_at))}}</span> @endif </p>
  </div>
</div>
@forelse($messages->where('status', '=', 1) as $message)
  @if($loop->first)
    {{-- FOM FIRST STEP --}}
    @if($booking->status == 1)
    <div class="col-12 d-flex justify-content-center align-self-center">
      <p class="chat-item fom-chat">
        ¡Felicitaciones {{$booking->manager_info->name}}! Tienes una nueva solicitud. Puedes resolver todas las dudas que tu o {{$user->name}} tengan en el chat antes de aceptar o rechazar la solicitud.
      </p>
    </div>
    @endif
    {{-- FOM FIRST STEP --}}
  @endif
  {{--MESSAGE FROM THE USER--}}
  @if($message->destination === '0')
    <div class="col-12">
      <p class="chat-item">{{$message->message}} <span class="time-chat mb-3">{{date("d/m/y - h:i a", strtotime($message->created_at))}}</span></p>
    </div>
  @else
    {{--MESSAGE TO THE USER--}}
    <div class="col-12">
      <p class="chat-item main-chat">{{$message->message}} <span class="time-chat mb-3">{{date("d/m/y - h:i a", strtotime($message->created_at))}}</span></p>
    </div>
  @endif

@empty
  @if($booking->status >= '1')
    {{-- FOM FIRST STEP --}}
    @if($booking->status == 1)
      <div class="col-12 d-flex justify-content-center align-self-center">
        <p class="chat-item fom-chat">
          ¡Felicitaciones {{$booking->manager_info->name}}! Tienes una nueva solicitud. Puedes resolver todas las dudas que tu o {{$user->name}} tengan en el chat antes de aceptar o rechazar la solicitud.
        </p>
      </div>
    @endif

  @endif
@endforelse


{{-- Delete this part if there arent anymore bookings in status 2,3,
  {{--SECOND STEP CHAT--}}
@forelse($messages->where('status', '=', 2) as $message)

  @if($loop->first)
    {{--FOM SECOND STEP--}}
    <div class="col-12 d-flex justify-content-center align-self-center">
      <p class="chat-item fom-chat">
        <em>&#10004; Aceptaste la solicitud de {{$user->name}}</em>
      </p>
    </div>
    @if($booking->status == 1)
      <div class="col-12 d-flex justify-content-center align-self-center">
        <p class="chat-item fom-chat">Hola {{$booking->manager_info->name}}. Estamos esperando que {{$user->name}} confirme su voluntad de pago. Cuando se decida te dejamos saber.</p>
      </div>
    @endif
  @endif
  {{--MESSAGE FROM THE USER--}}
  @if($message->destination === '0')
    <div class="col-12">
      <p class="chat-item">{{$message->message}} <span class="time-chat mb-3">{{date("d/m/y - h:i a", strtotime($message->created_at))}}</span></p>
    </div>
  @else
    {{--MESSAGE TO THE USER--}}
      <div class="col-12">
        <p class="chat-item main-chat">{{$message->message}} <span class="time-chat mb-3">{{date("d/m/y - h:i a", strtotime($message->created_at))}}</span></p>
      </div>
  @endif

@empty
  @if($booking->status == '2')

    {{--FOM SECOND STEP--}}
    <div class="col-12 d-flex justify-content-center align-self-center">
      <p class="chat-item fom-chat">
        <em>&#10004; Aceptaste la solicitud de {{$user->name}}</em>
      </p>
    </div>
    @if($booking->status == 2)
      <div class="col-12 d-flex justify-content-center align-self-center">
        <p class="chat-item fom-chat">Hola {{$booking->manager_info->name}}. Estamos esperando que {{$user->name}} confirme su voluntad de pago. Cuando se decida te dejamos saber.</p>
      </div>
    @endif
  @endif
@endforelse

{{--THIRD STEP CHAT--}}
@forelse($messages->where('status', '=', 3) as $message)

  @if($loop->first)
    {{--FOM THIRD STEP--}}
    <div class="col-12 d-flex justify-content-center align-self-center">
      <p class="chat-item fom-chat ">
        <em>&#10004; {{$user->name}} quiere pagar el deposito</em>
      </p>
    </div>
    @if($booking->status == 3)
      <div class="col-12 mx-auto d-flex justify-content-center align-self-center">
        <p class="chat-item fom-chat ">
          Super {{$booking->manager_info->name}}! {{$user->name}} dice que va a pagar en 48 horas si le das la garantia de que la habitacion no será ocupado mientras tanto. Otras solicitudes para este tiempo se ponen en lista de espera. ¿Le das este tiempo?
        </p>
      </div>
    @endif
  @endif
  {{--MESSAGE FROM THE USER--}}
  @if($message->destination === '0')
    <div class="col-12">
      <p class="chat-item">{{$message->message}} <span class="time-chat mb-3">{{date("d/m/y - h:i a", strtotime($message->created_at))}}</span></p>
    </div>
  @else
    {{--MESSAGE TO THE USER--}}
    <div class="col-12">
      <p class="chat-item main-chat">{{$message->message}} <span class="time-chat mb-3">{{date("d/m/y - h:i a", strtotime($message->created_at))}}</span></p>
    </div>
  @endif
@empty
  @if($booking->status == '3')

    {{--FOM THIRD STEP--}}
    <div class="col-12 d-flex justify-content-center align-self-center">
      <p class="chat-item fom-chat ">
        <em>&#10004; {{$user->name}} quiere pagar el deposito</em>
      </p>
    </div>
    @if($booking->status == 3)
    <div class="col-12 mx-auto d-flex justify-content-center align-self-center">
      <p class="chat-item fom-chat ">
        Super {{$booking->manager_info->name}}! {{$user->name}} dice que va a pagar en 48 horas si le das la garantia de que la habitacion no será ocupado mientras tanto. Otras solicitudes para este tiempo se ponen en lista de espera. ¿Le das este tiempo?
      </p>
    </div>
    @endif
  @endif
@endforelse
{{-- Delete this part if there arent anymore bookings in status 2,3,50 --}}



{{--FOURTH STEP CHAT--}}
@forelse($messages->where('status', '=', 4) as $message)

  @if($loop->first)
    {{--FOM FOURTH MESSAGE--}}
    <div class="col-12 d-flex justify-content-center align-self-center">
      <p class="chat-item fom-chat">
        <em>&#10004; Diste 24 horas de garantía a {{$user->name}} para realizar el pago.</em>
      </p>
    </div>
    @if($booking->status == 4)
    <div class="col-12 d-flex justify-content-center align-self-center">
      <p class="chat-item fom-chat">
        Hola {{$booking->manager_info->name}}. Estamos esperando que {{$user->name}} realice el pago del deposito. Recuerda que le bloqueaste la habitación por 24 horas.  {{-- Tiene un plazo de pago hasta: {{date("d/m/y - h:i a", strtotime($deadline))}} --}}.
        <br><a class="" target="_blank" href="{{route('questions.host')}}" onclick="faqManager()">¿Qué es el deposito?</a>
      </p>
      
    </div>
    @endif
  @endif
  {{--MESSAGE FROM THE USER--}}
  @if($message->destination === '0')
    <div class="col-12">
      <p class="chat-item">{{$message->message}} <span class="time-chat mb-3">{{date("d/m/y - h:i a", strtotime($message->created_at))}}</span></p>
    </div>
  @else
    {{--MESSAGE TO THE USER--}}
    <div class="col-12">
      <p class="chat-item main-chat">{{$message->message}} <span class="time-chat mb-3">{{date("d/m/y - h:i a", strtotime($message->created_at))}}</span></p>
    </div>
  @endif
@empty
  @if($booking->status == '4')

    {{--FOM FOURTH MESSAGE--}}
    <div class="col-12 d-flex justify-content-center align-self-center">
      <p class="chat-item fom-chat">
        <em>&#10004; Diste 24 horas de garantía a {{$user->name}} para realizar el pago.</em>
      </p>
    </div>
    @if($booking->status == 4)
    <div class="col-12 d-flex justify-content-center align-self-center">
      <p class="chat-item fom-chat">
        Hola {{$booking->manager_info->name}}. Estamos esperando que {{$user->name}} realice el pago del deposito. Recuerda que le bloqueaste la habitación por 24 horas.  {{-- Tiene un plazo de pago hasta: {{date("d/m/y - h:i a", strtotime($deadline))}} --}}
        <br><a class="" target="_blank" href="{{route('questions.host')}}" onclick="faqManager()">¿Qué es el deposito?</a>
      </p>
      
    </div>
    @endif
  @endif
@endforelse


@forelse($messages->where('status', '=', 5) as $message)

  @if($loop->first)
    {{--FOM FIFTH MESAGE--}}
    <div class="col-12 d-flex justify-content-center align-self-center">
      <p class="chat-item fom-chat ">
        <em>&#10004; Confirmamos el pago de {{$user->name}}. Ponte en contacto con el para organizar su llegada el {{$booking->date_from}}.
          <br>Su número de teléfono es: {{$user->phone}} y su correo electrónico es: {{$user->email}}</em>
      </p>
    </div>
  @endif
  {{--MESSAGE FROM THE USER--}}
  @if($message->destination === '0')
    <div class="col-12">
      <p class="chat-item">{{$message->message}} <span class="time-chat mb-3">{{date("d/m/y - h:i a", strtotime($message->created_at))}}</span></p>
    </div>
  @else
    {{--MESSAGE TO THE USER--}}
    <div class="col-12">
      <p class="chat-item main-chat">{{$message->message}} <span class="time-chat mb-3">{{date("d/m/y - h:i a", strtotime($message->created_at))}}</span></p>
    </div>
  @endif
@empty
  @if($booking->status === '5')

    {{--FOM FIFTH MESAGE--}}
    <div class="col-12 d-flex justify-content-center align-self-center">
      <p class="chat-item fom-chat ">
        <em>&#10004; Confirmamos el pago de {{$user->name}}. Ponte en contacto con el para organizar su llegada el {{$booking->date_from}}.
          <br>Su número de teléfono es: {{$user->phone}} y su correo electrónico es: {{$user->email}}</em>
      </p>
    </div>
  @endif
@endforelse
@section('scripts')

<script>
  function faqManager() {
      analytics.track('Enter manager FAQ',{
          category: 'User knowlage'
      });
  }
</script>

@endsection
