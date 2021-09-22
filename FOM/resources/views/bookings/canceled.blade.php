@extends('layouts.app')
@section('title', 'Cancelar mi solicitud')
@section('content')
  <div class="container">
    <h1 class="display-4">Hola {{ $user->name }}!</h1>
    @if ($user->role_id == 3)
    <p class="lead">
      Nos preocupa que canceles tu solicitud despues de haber realizado un pago, por tal motivo queremos que
      hables directamente con nosotros y nos cuentes que pasó.
    </p>    
    @elseif($user->role_id == 2)
    <p class="lead">
      Nos preocupa que canceles una solicitud en tu VICO que está pagada, por tal motivo queremos que
      hables directamente con nosotros y nos cuentes que pasó.
    </p> 
    @endif
    
    <p class="lead">
    Antes de enviar la solicitud, ten en cuenta nuestros <a href="{{ route('termsandconditions.showlastversion',['kha']) }}" target="_blank">terminos y condiciones.</a>
    </p>
    <p>
      Danos un pequeño resumen de lo que pasó y agilizar el proceso
    </p>

    <form method="POST" action="{{ route($user->role_id == 3 ? 'cancel.notify.user':'cancel.notify.manager') }}" id="cancel_petition" enctype="multipart/form-data">
      {{csrf_field()}}
      <input type="hidden" name="booking_id" id="booking_id" value="{{ $booking->id }}">
      <div class="form-group">
        <label for="problem">Posibles problemas</label>
        @if ($user->role_id == 3)
        <select class="form-control" name="problem" id="problem" required>
          <option>Selecciona</option>
          <option value="La VICO no encaja con lo visto en el sitio web">La VICO no encaja con lo visto en el sitio web</option>
          <option value="Tengo problemas con el arrendatario">Tengo problemas con el arrendatario</option>
          <option value="Tengo problemas con otro habitante de la VICO">Tengo problemas con otro habitante de la VICO</option>
          <option value="Tengo problemas personales">Tengo problemas personales</option>
          <option value="Mi problema no aparece acá">Mi problema no aparece acá</option>
        </select>
        @elseif($user->role_id == 2)
        <select class="form-control" name="problem" id="problem" required>
          <option>Selecciona</option>
          <option value="El arrendador está generando problemas dentro de mi VICO">El arrendador está generando problemas dentro de mi VICO</option>
          <option value="El arrendador no era quien decía">El arrendador no era quien decía</option>
          <option value="Asuntos internos de mi VICO">Asuntos internos de mi VICO</option>
          <option value="Mi problema no aparece acá">Mi problema no aparece acá</option>
        </select>
        @endif
        
      </div>
      <div class="form-group">
        <label for="explanation_details">¿Quieres describirlo más?</label>
        <textarea class="form-control" name="explanation_details" id="explanation_details" rows="3"></textarea>
      </div>
      <button type="submit" class="btn-outline-dark btn">Enviar</button>
    </form>
  </div>
@endsection
