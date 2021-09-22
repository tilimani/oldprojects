@extends('layouts.app')

@section('title', 'Reseña')

@section('content')
  {{--Condición necesaria para que el usuario del booking pueda ingresar a la review asociada al booking, por ahora se pone en true para pruebas--}}
  @if(true){{--@if(Auth::user())--}}
    @if(true) {{--Auth::user()->id === $manager->user_id || Auth::user()->role_id === 1--}}
      <div class="container pt-5 reviewApp">
        <div class="row">
          <div class="col-12">
            <p class="text-center h1">
              Hola! {{$manager->name}}
            </p>
            <p class="h4 p-2 m-2">
              Muchas gracias por brindar {{$usuario->name}} la habitación {{$habitacion->number}} en {{$casa->name}}. Esperamos que hayas tenido una experiencia excelente.<br/>
              Para mejorar nuestra comunidad y destactar tanto buenos ejemplos como malos ejemplos de huespedes sería muy bacano si dejas tu opinión sobre {{$usuario->name}}.
            </p>
            <p class="h1 p-2 m-2">
              <p class="d-inline mb-0 p-2 m-2">Malo</p>
              <div class="star-rating d-inline">
                <li class="star filled" style="font-size: 30px">
                  <i class=""></i>
                </li>
                <li class="star" style="font-size: 30px">
                  <i class=""></i>
                </li>
                <li class="star" style="font-size: 30px">
                  <i class=""></i>
                </li>
                <li class="star" style="font-size: 30px">
                  <i class=""></i>
                </li>
                <li class="star" style="font-size: 30px">
                  <i class=""></i>
                </li>
              </div>
            </p>
            <p class ="h1 p-2 m-2">
              <p class="d-inline mb-0 p-2 m-2">Excelente</p>
              <div class="star-rating d-inline">
                <li class="star filled" style="font-size: 30px">
                  <i class=""></i>
                </li>
                <li class="star filled" style="font-size: 30px">
                  <i class=""></i>
                </li>
                <li class="star filled" style="font-size: 30px">
                  <i class=""></i>
                </li>
                <li class="star filled" style="font-size: 30px">
                  <i class=""></i>
                </li>
                <li class="star filled" style="font-size: 30px">
                  <i class=""></i>
                </li>
              </div>
            </p>
          </div>
        </div>
        <div class="row">
          {{--ENCUENSTA GENERAL--}}
          <div class="col-12">
            <hr class="w-25">
            <p class="h1 pb-3">General: </p>
          </div>
          {{--MAIN FORM CONTAINER--}}
          <form class="review_form" action="{{ route('post_manager_review', $booking)  }}" method="post">
            {{csrf_field()}}
            {{--<input type="hidden" name="role_id" value="{{Auth::user()->role_id}}">
            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">--}}
            <input type="hidden" name="role_id" value="1">
            <input type="hidden" name="user_id" value="{{$booking->user_id}}">
            <input type="hidden" name="manager_id" value="{{$manager->id}}">
            <div class="container" ng-app="app" ng-controller="RatingController as rating">
              <div class="col-12 form-inline">
                <div class="col-md-8 col-sm-12">
                  <p class="h4"><strong>Limpieza:</strong><br/>¿El habitante se comportó bien y dejó la casa y las zonas sociales en buen estado?</p>
                </div>
                <div class="col-md-4 col-sm-12">
                  <div star-rating ng-model="rating.qualificationManagerClean" max="5" on-rating-select="rating.rateFunction(rating)" class=""></div>
                  <input type="number" name="qualificationManagerClean" value="@{{ rating.qualificationManagerClean }}" class="d-none">
                </div>
              </div>
              <div class="col-12 form-inline">
                <div class="col-md-8 col-sm-12">
                  <p class="h4"><strong>Comunicación:</strong><br/>¿Que tal funcionó la comunicación con el inquilino?</p>
                </div>
                <div class="col-md-4 col-sm-12">
                  <div star-rating ng-model="rating.qualificationManagerComunication" max="5" on-rating-select="rating.rateFunction(rating)" class=""></div>
                  <input type="number" name="qualificationManagerComunication" value="@{{ rating.qualificationManagerComunication }}" class="d-none" required>
                </div>
              </div>
              <div class="col-12 form-inline">
                <div class="col-md-8 col-sm-12">
                  <p class="h4"><strong>Seguir reglas de la casa:</strong><br/>¿El huesped cumplió con las reglas de la casa?</p>
                </div>
                <div class="col-md-4 col-sm-12">
                  <div star-rating ng-model="rating.qualificationManagerRules" max="5" on-rating-select="rating.rateFunction(rating)" class=""></div>
                  <input type="number" name="qualificationManagerRules" value="@{{ rating.qualificationManagerRules }}" class="d-none">
                </div>
              </div>



            <hr class="w-25">
            {{--RECOMENDARÍAS LA CASA? THUMBS UP/DOWN--}}
            <div class="col-12">
              <p class="h2 pb-3">¿Recomendarías este habitante?</p>
            </div>
            <div class="rating">
              {{-- THUMBS UP --}}
              <div class="like grow">
                <i class="fa fa-thumbs-up fa-3x" aria-hidden="true"></i>
              </div>
              {{-- THUMBS DOWN --}}
              <div class="dislike grow">
                <i class="fa fa-thumbs-down fa-3x" aria-hidden="true"></i>
              </div>
              <input type="number" name="qualificationManagerRecommend" value='0' class="qualificationManagerRecommend d-none">
            </div>

            <hr class="w-25">
            {{--Comentario personal + botón de neviar a la derecha abajo--}}
            <div class="col-12 form-inline">
              <p class="h4">
                <strong>Comentario personal:</strong><br/>
                Cuentanos algo sobre tu experiencia con el habitante en la VICO durante su estancia. ¿Cómo te fue con el?<small><strong>(Este comentario es público)</strong></small><br/>
              </p>
              <div class="col-12">
                <textarea name="qualificationManagerPublicComment" rows="8" cols="100" class="form-control w-100" required></textarea>
              </div>
            </div>

            {{--BOTÓN SUBMIT--}}
            <p class="text-right pb-4">
              <button type="submit" class="btn btn-primary submit-review">Enviar</button>
            </p>
          </div>
        </form>
        {{--END MAIN FORM--}}
      </div>
    </div>
  @endif
@else
  {{--SOLUCIÓN TEMPORAL PARA REDIRECCCIONAR LOS USUARIOS QUE NO TIENEN ACCESO PERMITO A ESTA SECCIÓN, LO IDEAL SERÍA HACERLO EN MIDDLEWARE--}}
  <script type="text/javascript">
    window.location = "{{url('/')}}";
  </script>
@endif

@endsection

