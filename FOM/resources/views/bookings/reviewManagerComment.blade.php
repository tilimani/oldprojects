@extends('layouts.app')

@section('title', 'Mensaje Privado')

{{--STYLE SECTION--}}
@section('styles')

@endsection
{{--END STYLE SECTION--}}

{{--MAIN SECTION--}}
@section('content')
  {{--USER AUTHENTICATION--}}
  @if(true){{--@if(Auth::user())--}}
    @if(true){{--Auth::user()->id === $booking->user_id || Auth::user()->role_id === 1--}}
      <div class="container pt-5">
        <div class="row">
          <div class="col-12">
            <p class="text-center h1">
             Opcional: Mensaje privado para {{$manager->name}}
              {{--Auth::user()->name--}}
            </p>
            <p class="h4 text-center">
              Muchas Gracias, tu opinión va a mejorar la experiencia para los próximos usuarios.
            </p>
            <hr class="w-100">
            <p class="h4 p-2 m-3">
              Opcional: Si quieres puedes dejar un mensaje privado para {{$manager->name}},
              con sugerencias o una retroalimentación de lo que podría hacer mejor. <strong>(Este comentario es privado
              y llega solamente a {{$manager->name}})</strong>
            </p>
          </div>
        </div>
        <form class="" action="{{route('post_manager_comment', $booking)}}" method="post">
          {{csrf_field()}}
          {{--<input type="hidden" name="role_id" value="{{Auth::user()->role_id}}">
          <input type="hidden" name="user_id" value="{{Auth::user()->id}}">--}}
          <input type="hidden" name="role_id" value="1">
          <input type="hidden" name="user_id" value="{{$booking->user_id}}">
          {{--THE COMMENT ITSELF--}}
          <div class="col-12 form-inline">
            <div class="col-12">
              <textarea name="manager_comment" rows="8" cols="100" class="w-100 form-control"></textarea>
            </div>
          </div>

          {{--SUBMIT BUTTON--}}
          <p class="text-right mt-4 pb-4">
            <button type="submit" class="btn btn-primary">Continuar</button>
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
