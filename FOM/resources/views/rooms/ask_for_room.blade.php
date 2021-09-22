<div id="ask_for_modal" class="modal fade modalAskfor scroll" role="dialog" aria-labelledby="Reservation"  data-backdrop="static" data-keyboard=false>
  <div class="modal-dialog modal-lg">
      <form method="POST" action="{{ URL::to('/rooms/reserve') }}">
          {{csrf_field()}}
          <div class="modal-content scroll">
               {{-- MODAL HEADER  --}}
              <div class="modal-header align-items-center">
                  <p class="h5 mb-0">{{trans('houses/show.Room')}} #{{$room->number}}
                          <br>
                          @if(!$date)
                          <label class="small mb-0" for="datechoose">{{trans('houses/show.availability_now')}} </label><br>
                          @else
                          <label class="small mb-0" for="datechoose">{{trans('houses/show.availability')}} {{date('d/m/Y', strtotime($date))}} </label><br>
                          @endif
                          <label class="small mb-0" for="datechoose">Tiempo minimo de estancia {{$min_stay}} dias</label></p>
                  <button type="button" class="close" data-dismiss="modal"><span class="icon-close"></span></button>
              </div>
               {{-- MODAL CONTACTAR BODY  --}}
              <div class="modal-body">
                  <div class="row">
                      <div class="col-md-6 col-12">
                          <p class="h4">{{trans('houses/show.contact_to')}} {{ $manager->name}}</p>
                          <p class="p">
                            {{trans('houses/show.once_that')}} {{ $manager->name }} {{trans('houses/show.get_message')}}. <br>
                            {{trans('houses/show.about_you')}}:</p>
                          <div class="col-12">
                              <div class=""><p class="p" style="padding-bottom: 0px; margin-top: 0px; font-weight: 300;">{{trans('houses/show.what_do_medellin')}}</p></div>
                              <div class=""><p class="p" style="padding-bottom: 0px; margin-top: 0px; font-weight: 300;">{{trans('houses/show.where_study')}}</p></div>
                              <div class=""><p class="p" style="padding-bottom: 0px; margin-top: 0px; font-weight: 300;">{{trans('houses/show.come_alone')}}</p></div>
                              <div class=""><p class="p mb-0" style="padding-bottom: 0px; margin-top: 0px; font-weight: 300;">{{trans('houses/show.why_vico')}}</p></div>
                          </div>
                      </div>
                      <hr class="w-100 my-4 d-md-none d-block">
                      <div class="col-md-6 col-12 form-reserve">
                          <div class="row">
                              <div class="col-12 ">
                                  <input name="room_id" type="hidden" value="{{$room->id}}">
                                  <label for="datechoose">{{trans('houses/show.when_want')}}</label>
                                  <label for="datechoose" class="d-none" id="date_error_booking" style="font-size: 80%;color: #dc3545;">Seleccione valores de fecha validos</label>
                                  <div class="dates" name="datechoose">
                                      <div role="row" class=" form-control pt-0 pr-0" id="datepicker-box">
                                          <input class="form-control d-inline-block mr-1" style="border-width:0; width:44%; background-color:transparent;" id="date_from_ask_for" name="datefrom" required min="" focusOnShow="false"  autocomplete="off" placeholder="{{trans('houses/show.from_placeholder')}}" readonly>
                                          <span class="text-center d-inline-block mr-1" id="arrow_date_picker">→</span>
                                          <input class='form-control d-inline-block' style="border-width:0; width:44%; background-color:transparent;" id='date_to_ask_for' name='dateto' required min='' focusOnShow='false'  autocomplete="off" placeholder="{{trans('houses/show.to_placeholder')}}" readonly>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-12">
                                  <label for="optionchoose">{{trans('houses/show.what_want')}}</label>
                                  <div name="optionchoose">
                                      <select class="form-control search-bar optionChoose" name="options" >
                                          <option value="1">{{trans('houses/show.wanna_reserve')}}</option>
                                          <option value="0">{{trans('houses/show.wanna_see')}}</option>
                                      </select>
                                  </div>
                              </div>
                              {{--STRUCTURE OF DATE BUTTONS--}}
                              <div class="col-12 my-2 dateButtons scroll d-none">
                                <div class="card my-2 cardTomorrow">
                                  <div class="card-body px-0">
                                    <p class="card-tittle text-center p-2">{{trans('houses/show.tour_description')}}</p>
                                    <p class="card-subtittle text-center">{{trans('houses/show.tour_tomorrow')}} <b class="btnday0"></p></b>
                                    <p class="card-text text-center buttonSelect">
                                      <button type="button" name="btnMorning" class="btn btn-outline-primary mx-2 morning">
                                          {{trans('houses/show.tour_morning')}}
                                      </button>
                                      <button type="button" name="btnAfternoon" class="btn btn-outline-primary mx-2 afternoon">
                                          {{trans('houses/show.tour_afternoon')}}
                                      </button>
                                      <button type="button" name="btnNight" class="btn btn-outline-primary mx-2 night">
                                          {{trans('houses/show.tour_night')}}
                                      </button>
                                    </p>
                                  </div>
                                </div>
                                <div class="card my-2 cardOtherDay">
                                  <div class="card-body px-0">
                                    <div class="card-tittle text-center dropdown">
                                      <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{trans('houses/show.tour_otherday')}}
                                      </button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                         {{-- FULLY FUNCTIONAL DATEPICKER  --}}
                                        {{--<div class="datepickerTour"></div>--}}
                                        <div class="container justify-content-center buttonSelect">
                                          <div class="row mx-auto my-1">
                                            <button type="button" name="btnDay1" class="btn btn-outline-primary mx-2 btnDay1 btnSelected"></button>
                                          </div>
                                          <div class="row mx-auto my-1">
                                            <button type="button" name="btnDay2" class="btn btn-outline-primary mx-2 btnDay2"></button>
                                          </div>
                                          <div class="row mx-auto my-1">
                                            <button type="button" name="btnDay3" class="btn btn-outline-primary mx-2 btnDay3"></button>
                                          </div>
                                          <div class="row mx-auto my-1">
                                            <button type="button" name="btnDay4" class="btn btn-outline-primary mx-2 btnDay4"></button>
                                          </div>
                                          <div class="row mx-auto my-1">
                                            <button type="button" name="btnDay5" class="btn btn-outline-primary mx-2 btnDay5"></button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <p class="card-subtittle text-center">{{trans('houses/show.tour_selected')}} <b class="lblOtherDay"></p></b>
                                    <p class="card-text text-center buttonSelect">
                                      <button type="button" name="button" class="btn btn-outline-primary mx-2 morning">{{trans('houses/show.tour_morning')}}</button>
                                      <button type="button" name="button" class="btn btn-outline-primary mx-2 afternoon">{{trans('houses/show.tour_afternoon')}}</button>
                                      <button type="button" name="button" class="btn btn-outline-primary mx-2 night">{{trans('houses/show.tour_night')}}</button>
                                    </p>
                                    {{--
                                    <p class="card-tittle text-center">Disponibilidad</p>
                                    <p class="card-subtittle text-center">PasadoMañana <b class="tomorrowPastDate"></p></b>
                                    <p class="card-text text-center">
                                      <button type="button" name="button" class="btn btn-primary mx-2 morning">Mañana</button>
                                      <button type="button" name="button" class="btn btn-primary mx-2 afternoon">Tarde</button>
                                      <button type="button" name="button" class="btn btn-primary mx-2 night">Noche</button>
                                    </p>
                                    --}}
                                  </div>
                                </div>
                              </div>
                              <div class="col-12">
                                  <label for="message">{{trans('houses/show.send_message')}} {{ $manager->name }}</label><br>
                                  <textarea class="form-control textarea contactMessage" name="" rows="8" cols="3" style="resize: none;" maxlength=350 placeholder="{{trans('houses/show.message_placeholder')}}"></textarea>
                                  <input type="hidden" name="message" value="">
                              </div>
                              <div class="col-12">
                                <p class="pt-2 mb-1">
                                  <span class="font-weight-bold">
                                    {{trans('houses/show.code_earnUSD')}}
                                  </span>
                                  <a class="float-right" style="color: #ea960f; text-decoration: underline;" onclick="toggleHide()">{{trans('houses/show.code_enter_code')}}</a>
                                </p>
                                <div id='js-coupon-code-hide' class="d-none">
                                  <input type="text" id="js-validate-coupon" onkeyup="validateLength()"
                                      placeholder="{{($discount != null) ? $discount: 'You receive $10 USD after moving in to your new room.'}}"
                                      value="{{ ($discount != null) ? $discount:''}}"
                                      class="form-control">
                                  <div class="invalid-feedback" id='js-feedback-msg'>
                                    {{trans('houses/code_msg_digits')}}
                                  </div>
                                  <input type="text" id="js-coupon-code" placeholder="here goes the code if right" class="form-control" name="referral" hidden>
                                </div>
                                <p class="small">
                                  {{trans('houses/show.code_promotion')}}
                                </p>
                              </div>
                              <div class="col-12 referral d-none">
                                  <label for="referral">{{trans('houses/show.how_know_vico')}}</label><br>
                                  <select  name="" class="form-control search-bar"  id="referral">
                                      <option>{{trans('houses/show.choose_placeholder')}}</option>
                                      <option>{{trans('houses/show.a_friend')}}</option>
                                      <option>{{trans('houses/show.medellin_university')}}</option>
                                      <option>{{trans('houses/show.origin_university')}}</option>
                                      <option>MIEO</option>
                                      <option>LILO - Life local</option>
                                      <option>Facebook/Instagram</option>
                                      <option>{{trans('houses/show.blog')}}</option>
                                      <option>{{trans('houses/show.an_other')}}</option>
                                  </select>
                                  <div class="search-bar" id="otherField">
                                      <input name="referral_comments" placeholder="¿Cúal?" type="text"class="form-control referral_comments" autocomplete="off">
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
               {{-- MODAL FOOTER  --}}
              <div class="modal-footer text-center">
                  <button type="button" class="btn btn-link" data-dismiss="modal">{{trans('houses/show.back')}}</button>
                  <button type="button" class="btn btn-primary btn-reserv" id="make_booking">{{trans('houses/show.ask_for')}}</button>
                  <button type="submit" class="btn btn-primary btn-reserv d-none" id="make_booking_submit">{{trans('houses/show.ask_for')}}</button>
              </div>
          </form>
      </div>
  </div>
</div>