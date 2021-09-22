@extends('layouts.app')

@section('title', 'Mensaje al equipo')

{{--STYLE SECTION--}}
@section('styles')

@endsection
{{--END STYLE SECTION--}}

{{--MAIN SECTION--}}
@section('content')
  {{--USER AUTHENTICATION--}}
  @if(true){{--@if(Auth::user())--}}
    @if(true) {{--Auth::user()->id === $booking->manager_id || Auth::user()->role_id === 1--}}
      <div class="container pt-5">
        <div class="row">
          <div class="col-12">
            <p class="text-center h1">
              Muchas Gracias {{--Auth::user()->name--}}, ya casi terminamos!
            </p>
            <p class="h4 p-2 m-3">
              Opcional: Queremos mejorar también nuestro servicio, por eso te quisieramos preguntar si tienes algunas recomendaciones, ideas,
              propuestas o, en general, cosas que te faltaron para mejorar nuestro servicio.
              ¿Qué te gustó? ¿Que no te gustó? Somos una empresa jóven y buscamos siempre la mejora continua ¡Te agradecemos por tu ayuda!
              <strong>(Este comentario es privado y llega al equipo FOM).</strong>
            </p>
          </div>
        </div>
        <form class="" action="{{route('post_fom_comment', $booking)}}" method="post">
          {{csrf_field()}}
          {{--<input type="hidden" name="role_id" value="{{Auth::user()->role_id}}">
          <input type="hidden" name="user_id" value="{{Auth::user()->id}}">--}}
          <input type="hidden" name="role_id" value="1">
          <input type="hidden" name="$user_id" value="{{$booking->user_id}}">
          <input type="hidden" name="$manager_id" value="{{$manager_id}}">
          {{--THE COMMENT ITSELF--}}
          <div class="col-12 form-inline">
            <div class="col-12">
              <textarea name="fom_comment" rows="8" cols="100" class="w-100"></textarea>
            </div>
          </div>

          {{--SUBMIT BUTTON--}}
          <p class="text-right pb-4">
            <button type="submit" class="btn btn-primary">Finalizar</button>
          </p>
        </div>
        </form>
      </div>
    @else

    @endif
  @else
  {{--TEMPORAL SOLUTION TO UNAUTHENTICATED USER, NEED TO USE MIDDLEWARE--}}
  <script type="text/javascript">
    window.location = "{{url('/')}}";
  </script>
  @endif

@endsection
{{--END MAIN SECTION--}}

{{--SCRIPT SECTION--}}
@section('scripts')

@endsection
{{--END SCRIPT SECTION--}}
