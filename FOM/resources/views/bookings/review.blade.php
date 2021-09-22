@extends('layouts.app')

@section('title', 'Reseña')

@section('content')
  <input type="hidden" value="{{$usuario->phone}}" name="user_phone">
  {{-- CONDICIÓN NECESARIA PARA QUE EL USUARIO DEL BOOKING PUEDA INGRESAR A LA REVIEW ASOCIADA AL BOOKING, POR AHORA SE PONE EN TRUE PARA PRUEBAS --}}
  @if(true) {{--@if(Auth::user())--}}
    @if(true){{--Auth::user()->id === $booking->user_id || Auth::user()->role_id === 1--}}
      <div class="container pt-5 reviewApp">
        <div class="row">
          <div class="col-12">
            <p class="text-center h1">
              Hola {{$usuario->name}}!
            </p>
            <p class="mb-0 p-2 m-2">
              Muchas gracias por tu estancia en la habitación {{$habitacion->number}} en {{$casa->name}}. Esperamos que hayas tenido una experiencia
              excelente y que vuelvas pronto. <br/>
              Para que los próximos estudiantes puedan encontrar la VICO perfecta para su estancia sería muy bacano si nos compartes algo de tu experienica en la casa.
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
            <hr class="w-100">
            <p class="h1 pb-3">VICO en general: </p>
          </div>
          {{--MAIN FORM CONTAINER--}}
          <form class="review_form" action="{{ route('post_user_review', $booking)  }}" method="post">
            {{csrf_field()}}
            {{--<input type="hidden" name="role_id" value="{{Auth::user()->role_id}}">
            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">--}}
            <input type="hidden" name="role_id" value="1">
            <input type="hidden" name="user_id" value="{{$booking->user_id}}">
            <div class="container" ng-app="app" ng-controller="RatingController as rating">
              <div class="col-12 pb-2 form-inline">
                <div class="col-md-8 col-sm-12">
                  <p class="mb-0"><strong>Veracidad de la información: <span tabindex="0"
                         class="btn btn-primary"
                         role=""
                         data-html="true"
                         data-toggle="popover"
                         data-trigger="focus"
                         title="<b>¿Qué quiere decir esto?</b>"
                         data-content="
                          <div>
                            <b>¿La información de la página coinicide con lo que encontraste en la casa? Los equipos y las fotos han sido iguales a lo que viste antes en la página?
                          </div>">?</span></strong><br/>
                        ¿La información de la página coinicide con lo que encontraste en la casa?
                  </p>
                </div>
                <div class="col-md-4 col-sm-12">
                  <div star-rating ng-model="rating.qualificationHouseData" max="5" on-rating-select="rating.rateFunction(rating)" class=""></div>
                  <input type="number" name="qualificationHouseData" value="@{{ rating.qualificationHouseData }}" class="d-none">
                </div>
                <ul class="star-rating" ng-class="{readonly: readonly}">
                	<li ng-repeat="star in stars" class="star" ng-class="{filled: star.filled}" ng-click="toggle($index)">
                		<i class=""></i>
                	</li>
                </ul>

              </div>
              <div class="col-12 pb-2 form-inline">
                <div class="col-md-8 col-sm-12">
                  <p class="mb-0"><strong>Limpieza:</strong><br/>¿La casa estaba limpia?</p>
                </div>
                <div class="col-md-4 col-sm-12">
                  <div star-rating ng-model="rating.qualificationHouseExperience" max="5" on-rating-select="rating.rateFunction(rating)" class=""></div>
                  <input type="number" name="qualificationHouseExperience" value="@{{ rating.qualificationHouseExperience }}" class="d-none">
                </div>
              </div>
              <div class="col-12 pb-2 form-inline">
                <div class="col-md-8 col-sm-12">
                  <p class="mb-0"><strong>Cocina:</strong><br>Encontraste todos los equipos que necesitabas en la cocina?</p>
                </div>
                <div class="col-md-4 col-sm-12">
                  <div star-rating ng-model="rating.qualificationHouseDevices" max="5" on-rating-select="rating.rateFunction(rating)" class=""></div>
                  <input type="number" name="qualificationHouseDevices" value="@{{ rating.qualificationHouseDevices }}" class="d-none">
                </div>
              </div>
              <div class="col-12 pb-2 form-inline">
                <div class="col-md-8 col-sm-12">
                  <p class="mb-0"><strong>Baños:</strong><br/>¿Había baños suficientes para el número de personas?</p>
                </div>
                <div class="col-md-4 col-sm-12">
                  <div star-rating ng-model="rating.qualificationHouseBath" max="5" on-rating-select="rating.rateFunction(rating)" class=""></div>
                  <input type="number" name="qualificationHouseBath" value="@{{ rating.qualificationHouseBath }}" class="d-none">
                </div>
              </div>
              <div class="col-12 pb-2 form-inline">
                <div class="col-md-8 col-sm-12">
                  <p class="mb-0"><strong>Relaciones con el grupo:
                    <span tabindex="0"
                           class="btn btn-primary"
                           role=""
                           data-html="true"
                           data-toggle="popover"
                           data-trigger="focus"
                           title="<b>¿Qué quiere decir esto?</b>"
                           data-content="
                            <div>
                              Hay VICOs que son mejor para conocer nuevos amigos, si tu llegas solo aquí es un factor importante: ¿En esta casa es fácil conocer nuevos amigos? ¿Las zonas sociales y los espacios comunes promueven la integración con los otros compañeros de la VICO?
                            </div>">?</span></strong><br/>
                            ¿En esta casa es fácil conocer nuevos amigos?
                    </p>
                </div>
                <div class="col-md-4 col-sm-12">
                  <div star-rating ng-model="rating.qualificationHouseRoomies" max="5" on-rating-select="rating.rateFunction(rating)" class=""></div>
                  <input type="number" name="qualificationHouseRoomies" value="@{{ rating.qualificationHouseRoomies }}" class="d-none">
                </div>
              </div>
              <div class="col-12 pb-2 form-inline">
                <div class="col-md-8 col-sm-12">
                  <p class="mb-0"><strong>Wifi:</strong><br/>¿Cómo calificas el WIFI de la casa?</p>
                </div>
                <div class="col-md-4 col-sm-12">
                  <div star-rating ng-model="rating.qualificationHousewifi" max="5" on-rating-select="rating.rateFunction(rating)" class=""></div>
                  <input type="number" name="qualificationHousewifi" value="@{{ rating.qualificationHousewifi }}" class="d-none"> {{---CAMBIAR RATINGS--}}
                </div>
              </div>
              <div class="col-12 pb-2">
                <div class="col-12">
                  <p class="mb-0"><strong>Es una casa tranquila o de fiesta:</strong><br/>En una escala entre 0 (muy tranquilo) y 10 (mucha fiesta), ¿donde pondrías esa casa?</p>
                </div>
                <div class="row">
                  <div class="col-12 pt-2 form-inline">
                    <input type="range" id="sliderPrice" min="{{__('0')}}" max="{{__('5')}}" value="{{__('2.5')}}" step="0.5"  class="sliderCustom d-inline" autocomplete="off" name="qualificationHouseLoudparty"><br/>
                    <p class="pl-2 h1 d-inline" id="sliderValue"></p>
                  </div>
                </div>
              </div>
              {{--RUMBA Y FIESTA--}}

              <hr class="w-100">
              {{--TU HABITACIÓN:--}}
              <div class="col-12 pb-2">
                <p class="h1 pb-3">Tu habitación: </p>
              </div>
              <div class="col-12 pb-2 form-inline">
                <div class="col-md-8 col-sm-12">
                  <p class="mb-0"><strong>Veracidad de la información: </strong><br/>¿La información de la página coincide con lo que encontraste en la habitación?</p>
                </div>
                <div class="col-md-4 col-sm-12">
                  <div star-rating ng-model="rating.qualificationRoomsData" max="5" on-rating-select="rating.rateFunction(rating)" class=""></div>
                  <input type="number" name="qualificationRoomsData" value="@{{ rating.qualificationRoomsData }}"  class="d-none">
                </div>
              </div>
              <div class="col-12 pb-2 form-inline">
                <div class="col-md-8 col-sm-12">
                  <p class="mb-0"><strong>Percepción de la habitación:</strong><br/>¿Qué tal te sentiste en la habitación en general?</p>
                </div>
                <div class="col-md-4 col-sm-12">
                  <div star-rating ng-model="rating.qualificationRoomsGeneral" max="5" on-rating-select="rating.rateFunction(rating)" class=""></div>
                  <input type="number" name="qualificationRoomsGeneral" value="@{{ rating.qualificationRoomsGeneral }}"  class="d-none">
                </div>
              </div>
              <div class="col-12 pb-2 form-inline">
                <div class="col-md-8 col-sm-12">
                  <p class="mb-0"><strong>Ruido:
                    <span tabindex="0"
                           class="btn btn-primary"
                           role=""
                           data-html="true"
                           data-toggle="popover"
                           data-trigger="focus"
                           title="<b>¿Qué quiere decir esto?</b>"
                           data-content="
                            <div>
                             ¿Era posible para ti dormir bien? ¿Qué tan fuerte es el ruido que llega desde la calle? ¿Qué tal el ruido de la casa?
                            </div>">?</span></strong><br/>
                        ¿Qué tal el ruido de la habitación, era posible dormir bien?
                  </p>
                </div>
                <div class="col-md-4 col-sm-12">
                  <div star-rating ng-model="rating.qualificationRoomsLoud" max="5" on-rating-select="rating.rateFunction(rating)" class=""></div>
                  <input type="number" name="qualificationRoomsLoud" value="@{{ rating.qualificationRoomsLoud }}" class="d-none">
                </div>
              </div>
              <div class="col-12 pb-2 form-inline">
                <div class="col-md-8 col-sm-12">
                  <p class="mb-0"><strong>Wifi:</strong><br/>¿El WIFI llegaba hasta tu habitación?</p>
                </div>
                <div class="col-md-4 col-sm-12">
                  <div star-rating ng-model="rating.qualificationRoomswifi" max="5" on-rating-select="rating.rateFunction(rating)" class=""></div>
                  <input type="number" name="qualificationRoomswifi" value="@{{ rating.qualificationRoomswifi }}"   class="d-none"> {{---CAMBIAR RATINGS--}}
                </div>
              </div>
              <hr class="w-100">

              {{--LA UBICACIÓN--}}
              <div class="col-12 pb-2">
                <p class="h1 pb-3">La ubicación:</p>
              </div>
              <div class="col-12 pb-2 form-inline">
                <div class="col-md-8 col-sm-12">
                  <p class="mb-0"><strong>En general:</strong><br/>¿Qué tal te parece la zona para vivir?</p>
                </div>
                <div class="col-md-4 col-sm-12">
                  <div star-rating ng-model="rating.qualificationNeighborhoodsGeneral" max="5" on-rating-select="rating.rateFunction(rating)" class=""></div>
                  <input type="number" name="qualificationNeighborhoodsGeneral" value="@{{ rating.qualificationNeighborhoodsGeneral }}" class="d-none">
                </div>
              </div>
              <div class="col-12 pb-2 form-inline">
                <div class="col-md-8 col-sm-12">
                  <p class="mb-0"><strong>Transportes:</strong><br/>¿Que tal te parece el acceso a transportes públicos?</p>
                </div>
                <div class="col-md-4 col-sm-12">
                  <div star-rating ng-model="rating.qualificationNeighborhoodsAccess" max="5" on-rating-select="rating.rateFunction(rating)" class=""></div>
                  <input type="number" name="qualificationNeighborhoodsAccess" value="@{{ rating.qualificationNeighborhoodsAccess }}" class="d-none">
                </div>
              </div>
              <div class="col-12 pb-2 form-inline">
                <div class="col-md-8 col-sm-12">
                  <p class="mb-0"><strong>Hacer compras:</strong><br/>¿Tenías acceso a tiendas/supermercados cerca?</p>
                </div>
                <div class="col-md-4 col-sm-12">
                  <div star-rating ng-model="rating.qualificationNeighborhoodsShopping" max="5" on-rating-select="rating.rateFunction(rating)" class=""></div>
                  <input type="number" name="qualificationNeighborhoodsShopping" value="@{{ rating.qualificationNeighborhoodsShopping }}" class="d-none">
                </div>
              </div>
              <hr class="w-100">

              {{--EL DUEÑO--}}
              <div class="col-12 pb-2">
                <p class="h1 pb-3">El dueño: </p>
              </div>
              <div class="col-12 pb-2 form-inline">
                <div class="col-md-8 col-sm-12">
                  <p class="mb-0"><strong>Comunicación:</strong><br/>¿Que tal la comunicación con el dueño?</p>
                </div>
                <div class="col-md-4 col-sm-12">
                  <div star-rating ng-model="rating.qualificationUsersManagerCommunication" max="5" on-rating-select="rating.rateFunction(rating)" class=""></div>
                  <input type="number" name="qualificationUsersManagerCommunication" value="@{{ rating.qualificationUsersManagerCommunication }}" class="d-none">
                </div>
              </div>
              <div class="col-12 pb-2 form-inline">
                <div class="col-md-8 col-sm-12">
                  <p class="mb-0"><strong>Compromiso:</strong><br/>Si el dueño te dijo que iba a hacer algo, ¿cumplió con su palabra?</p>
                </div>
                <div class="col-md-4 col-sm-12">
                  <div star-rating ng-model="rating.qualificationUsersManagerComprise" max="5" on-rating-select="rating.rateFunction(rating)" class=""></div>
                  <input type="number" name="qualificationUsersManagerComprise" value="@{{ rating.qualificationUsersManagerComprise }}" class="d-none">
                </div>
              </div>

              <hr class="w-100">
              {{--RECOMENDARÍAS LA CASA? THUMBS UP/DOWN--}}
              <div class="col-12 pb-2">
                <p class="h2 pb-3">¿Recomendarías esta VICO a otras personas?</p>
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
                <input type="number" name="qualificationHouseRecommend" value="0" class="qualificationHouseRecommend d-none">
              </div>

              <hr class="w-100">
              {{--COMENTARIO PERSONAL + BOTÓN DE NEVIAR A LA DERECHA ABAJO--}}
              <div class="col-12 pb-2 form-inline">
                <p class="mb-0">
                  <strong>Comentario personal:</strong><br/>
                  Cuentanos algo sobre tu experiencia en la VICO y durante tu estancia. Qué dirías a otros estudiantes que piensan quedarse aquí. <strong>(Este comentario es público)</strong><br/>
                </p>
                <div class="col-12 pb-2">
                  <textarea name="qualificationHouseHouseComment" id="myTextArea" rows="4" cols="100" class="w-100 form-control fs-rem-10" required></textarea>
                </div>
              </div>

              {{--BOTÓN SUBMIT--}}
              <p class="text-right pb-4">
                <button type="submit" class="btn btn-primary submit-review">Continuar</button>
              </p>
            </div>
          </form>
          {{--END MAIN FORM--}}
        </div>
      </div>
    </div>
  @endif
@else
  {{--TEMPORAL SOLUTION TO UNAUTHENTICATED USER, NEED TO USE MIDDLEWARE--}}
  <script type="text/javascript">
    window.location = "{{url('/')}}";
  </script>
@endif
{{-- MODAL AUTHPASS TO CHECK USER  --}}
  <div class="modal fade" style="overflow:scroll" id="authBookingsModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          {{-- <h5 class="modal-title">holi</h5> --}}
          <a class="brand" href="/"><img  style="height: 50px; width: 122px" src="{{asset("images/Friends-of-Medellin-Logo.png")}}" srcset="{{asset("images/Friends-of-Medellin-Logo@2x.png")}} 2x, {{asset("images/Friends-of-Medellin-Logo@3x.png")}} 3x" alt="Friends of Medellín"></a>
        </div>
           {{-- MODAL BODY  --}}
          <div class="modal-body">
            <div class="col">
              <p>Por favor ingresa tu código de acceso para ingresar a la solicitud.</p>
              <input type="password" id="bookingPass" class="form-control" name="password">
              <label id="errorMsg" for="bookingPass">Código inválido</label>
              <button type="button" id="bookingPassBtn" class="btn btn-primary btn-block mt-2">¡Vamos!</button>

            </div>
          </div>
          <div class="modal-footer">
              <a href="https://wa.me/573054440424" target="_blank">¿No sabes cual es tu código? Pónte en contacto con nosotros.</a>
          </div>
      </div>
    </div>
  </div>
{{--END MODAL AUTHPASS TO CHECK USER  --}}

@endsection



