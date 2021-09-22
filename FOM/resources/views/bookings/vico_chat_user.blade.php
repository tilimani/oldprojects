
{{-- FIRST STEP CHAT --}}
<div class="col-12 d-flex justify-content-center align-self-center">
    <p class="chat-item fom-chat"> <img alt="safety" height="20px" width="20px" src="{{asset("images/process/safety.png")}}" srcset="{{asset("images/process/safety@2x.png")}} 2x, {{asset("images/process/safety@3x.png")}} 3x"> Protege tu seguridad conversando dentro del chat y realizando todos los pagos con VICO. Con el fin de garantizar reservas seguras y rápidas no se permite enviar números telefónicos o correos electrónicos.
</p>
</div>
<div class="col-12">
    <p class="chat-item main-chat">@if($booking->message == "") Hola {{$booking->manager_info->name}}, me gusta tu VICO, ¿la habitación queda disponible? @else {!! nl2br($booking->message) !!}@endif <span class="time-chat mb-3">{{date("d/m/y", strtotime($booking->created_at))}} -  {{substr($today_time,0,5)}}</span></p>
</div>
@forelse($messages->where('status', '=', 1) as $message)
    @if($loop->first)
        @if($booking->status == 1)
            <div class="col-12 d-flex justify-content-center align-self-center">
                <p class="chat-item fom-chat">Hola {{$user->name}}. Estamos esperando que {{$booking->manager_info->name}} confirme la disponibilidad de la habitación y te invite a vivir en su VICO. Cuando responda, recibirás una notificación. Usa el Chat para resolver todas tus preguntas sobre la VICO.</p>
            </div>

        @endif
    @endif
    {{--MESSAGE FROM THE USER--}}
    @if($message->destination === '0')
        <div class="col-12">
            <p class="chat-item main-chat">{{$message->message}} <span class="time-chat mb-3">{{date("d/m/y - h:i a", strtotime($booking->created_at))}}</span></p>
        </div>
    @else
    {{--MESSAGE TO THE USER--}}
        <div class="col-12">
            <p class="chat-item">{{$message->message}} <span class="time-chat mb-3">{{date("d/m/y - h:i a", strtotime($booking->created_at))}}</span></p>
        </div>
    @endif

@empty
    @if($booking->status >= '1')
    {{--FOM FIRST STEP--}}
        @if($booking->status == 1)
            <div class="col-12 d-flex justify-content-center align-self-center">
                <p class="chat-item fom-chat">Hola {{$user->name}}. Estamos esperando que {{$booking->manager_info->name}} confirme la disponibilidad de la habitación y te invite a vivir en su VICO. Cuando responda, recibirás una notificación. Usa el Chat para resolver todas tus preguntas sobre la VICO.</p>
            </div>
        @endif
    @endif
@endforelse

{{-- Delete this part if there arent anymore bookings in status 2,3,50 --}}
    {{--SECOND STEP CHAT--}}
    @forelse($messages->where('status', '=', 2) as $message)
        @if($loop->first)
        {{--FOM SECOND STEP--}}
            <div class="col-12 d-flex justify-content-center align-self-center">
                <p class="chat-item fom-chat">
                    <em>&#10004; {{$booking->manager_info->name}} ha aceptado tu solicitud.</em>
                </p>
            </div>
            @if($booking->status == 2)
                <div class="col-12 d-flex justify-content-center align-self-center">
                    @if($booking->mode==1)
                        <p class="chat-item fom-chat ">
                            Felicitaciones, {{$booking->manager_info->name}} ha
                                                      confirmado la disponibilidad de la habitación. Confirma tu voluntad de pagar,
                                                      desde este momento no puedes
                                                      reseravar ningúna otra habitación. {{$booking->manager_info->name}} te va a dar 48 horas de garantia para pagar, en este tiempo ningúna persona más puede hacer una reserva.
                        </p>
                    @else
                        <p class="chat-item fom-chat ">
                            ¡Genial, {{$booking->manager_info->name}} está interesado en conocerte y presentarte la {{$house->name}}! Escribanos por WhatsApp al: 3175750056 para organizar una reunión.
                            <br><br> <a target="_blank" class="btn btn-primary" href="https://api.whatsapp.com/send?phone=5731757500056&text=Hola,%20mi%20nombre%20es%20{{$user->name}},%20quiero%20conocer%20la%20habitaci%C3%B3n%20{{$room->number}}%20en%20{{$house->name}}.%20El%20n%C3%BAmero%20de%20mi%20solicitud%20es%20{{$booking->id}}.">Abrir mi WhatsApp.</a>
                        </p>
                    @endif
                </div>
            @endif
        @endif
        {{--MESSAGE FROM THE USER--}}
        @if($message->destination === '0')
            <div class="col-12">
                <p class="chat-item main-chat">{{$message->message}} <span class="time-chat mb-3">{{date("d/m/y - h:i a", strtotime($booking->created_at))}}</span></p>
            </div>
        @else
        {{--MESSAGE TO THE USER--}}
            <div class="col-12">
                <p class="chat-item">{{$message->message}} <span class="time-chat mb-3">{{date("d/m/y - h:i a", strtotime($booking->created_at))}}</span></p>
            </div>
        @endif

    @empty
        @if($booking->status == '2')
            {{--FOM SECOND STEP--}}
            <div class="col-12 d-flex justify-content-center align-self-center">
                <p class="chat-item fom-chat">
                    <em>&#10004; {{$booking->manager_info->name}} ha aceptado tu solicitud.</em>
                </p>
            </div>
            @if($booking->status == 2)
                <div class="col-12 d-flex justify-content-center align-self-center">
                    @if($booking->mode==1)
                        <p class="chat-item fom-chat ">
                            Felicitaciones, {{$booking->manager_info->name}} ha
                                                      confirmado la disponibilidad de la habitación. Confirma tu voluntad de pagar,
                                                      desde este momento no puedes
                                                      reseravar ningúna otra habitación. {{$booking->manager_info->name}} te va a dar 48 horas de garantia para pagar, en este tiempo ningúna persona más puede hacer una reserva.
                        </p>
                    @else
                        <p class="chat-item fom-chat ">
                            ¡Genial, {{$booking->manager_info->name}} está interesado en conocerte y presentarte la {{$house->name}}! Escribanos por WhatsApp al: 31757500056 y pregunta por el número de {{$booking->manager_info->name}} para contactarlo y organizar una reunión.
                            <br><br> <a target="_blank" class="btn btn-primary" href="https://api.whatsapp.com/send?phone=5731757500056&text=Hola,%20mi%20nombre%20es%20{{$user->name}},%20quiero%20conocer%20la%20habitaci%C3%B3n%20{{$room->number}}%20en%20{{$house->name}}.%20El%20n%C3%BAmero%20de%20mi%20solicitud%20es%20{{$booking->id}}.">Abrir mi WhatsApp.</a>
                        </p>
                    @endif
                </div>
            @endif
        @endif
    @endforelse

    {{--THIRD STEP CHAT--}}
    @forelse($messages->where('status', '=', 3) as $message)
        @if($loop->first)
        {{--FOM THIRD STEP--}}
        <div class="col-12 d-flex justify-content-center align-self-center">
            <p class="chat-item fom-chat">
                <em>&#10004; Confirmaste que quieres pagar el deposito.</em>
            </p>
        </div>
            @if($booking->status == 3)
                <div class="col-12 d-flex justify-content-center align-self-center">
                    <p class="chat-item fom-chat ">
                        Estamos esperando que {{$booking->manager_info->name}} te de 48 horas
                        de garantía para pagar, en este tiempo ninguna persona más puede
                        hacer una reserva.
                    </p>
                </div>
            @endif
        @endif
        {{--MESSAGE FROM THE USER--}}
        @if($message->destination === '0')
            <div class="col-12">
                <p class="chat-item  main-chat">{{$message->message}} <span class="time-chat mb-3">{{date("d/m/y - h:i a", strtotime($booking->created_at))}}</span></p>
            </div>
        @else
            {{--MESSAGE TO THE USER--}}
            <div class="col-12">
                <p class="chat-item">{{$message->message}} <span class="time-chat mb-3">{{date("d/m/y - h:i a", strtotime($booking->created_at))}}</span></p>
            </div>
        @endif
    @empty
        @if($booking->status == '3')
        {{--FOM THIRD STEP--}}
            <div class="col-12 d-flex justify-content-center align-self-center">
                <p class="chat-item fom-chat">
                    <em>&#10004; Confirmaste que quieres pagar el deposito.</em>
                </p>
            </div>
            @if($booking->status == 3)
                <div class="col-12 d-flex justify-content-center align-self-center">
                    <p class="chat-item fom-chat ">
                        Estamos esperando que {{$booking->manager_info->name}} te de 48 horas
                        de garantía para pagar, en este tiempo ninguna persona más puede
                        hacer una reserva.
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
                <em>&#10004; {{$booking->manager_info->name}} te dio 24 horas de garantía para realizar el pago.</em>
            </p>
        </div>
        @if($booking->status == 4)
            <div class="col-12 mx-auto d-flex justify-content-center align-self-center">
                <p class="chat-item fom-chat ">
                    Felicitaciones {{$user->name}}. {{$booking->manager_info->name}} te ha invitado a vivir en su VICO. Ahora tienes 24 horas para realizar el pago de reserva. <br>Cómo son transferencias internacionales la llegada del dinero se tarda unos días. Cuando verificamos el recibo del dinero te mandamos una confirmación de pago.
                </p>
            </div>
        @endif
    @endif
    {{--MESSAGE FROM THE USER--}}
    @if($message->destination === '0')
        <div class="col-12">
            <p class="chat-item main-chat">{{$message->message}} <span class="time-chat mb-3">{{date("d/m/y - h:i a", strtotime($booking->created_at))}}</span></p>
        </div>
    @else
        {{--MESSAGE TO THE USER--}}
        <div class="col-12">
            <p class="chat-item">{{$message->message}} <span class="time-chat mb-3">{{date("d/m/y - h:i a", strtotime($booking->created_at))}}</span></p>
        </div>
    @endif
@empty
    @if($booking->status == '4')
        {{--FOM FOURTH MESSAGE--}}
        <div class="col-12 d-flex justify-content-center align-self-center">
            <p class="chat-item fom-chat">
                <em>&#10004; {{$booking->manager_info->name}} te dio 24 horas de garantía.</em>
            </p>
        </div>
        @if($booking->status == 4)
            <div class="col-12 mx-auto d-flex justify-content-center align-self-center">
                <p class="chat-item fom-chat ">
                    Ahora tienes 24 horas para pagar el deposito. El pago puedes realizar con tu tarjeta de crédito. 
                  <br><a class="" target="_blank" href="{{route('questions.user')}}" onclick="faqUser()">¿Qué es el deposito?</a>
                </p>
            </div>
        @endif
    @endif
@endforelse


{{--FOURTH STEP CHAT--}}
@forelse($messages->where('status', '=', 5) as $message)
    @if($loop->first)
        {{--FOM FIFTH MESAGE--}}
        <div class="col-12 d-flex justify-content-center align-self-center">
            <p class="chat-item fom-chat">
                <em>&#10004; Recibimos tu pago. La habitación queda reservada para ti</em>
            </p>
        </div>
    @endif
    {{--MESSAGE FROM THE USER--}}
    @if($message->destination === '0')
        <div class="col-12">
            <p class="chat-item main-chat">{{$message->message}} <span class="time-chat mb-3">{{date("d/m/y - h:i a", strtotime($booking->created_at))}}</span></p>
        </div>
    @else
        {{--MESSAGE TO THE USER--}}
        <div class="col-12">
            <p class="chat-item">{{$message->message}} <span class="time-chat mb-3">{{date("d/m/y - h:i a", strtotime($booking->created_at))}}</span></p>
        </div>
    @endif
@empty
    @if($booking->status === '5')
        {{--FOM FIFTH MESAGE--}}
        <div class="col-12 d-flex justify-content-center align-self-center">
            <p class="chat-item fom-chat">
                <em>&#10004; Recibimos tu pago. La habitación queda reservada para ti</em>
            </p>
        </div>
    @endif
@endforelse
@section('scripts')
<script>
function faqUser() {
    analytics.track('Enter user FAQ',{
        category: 'User knowlage'
    });
}
</script>
@endsection