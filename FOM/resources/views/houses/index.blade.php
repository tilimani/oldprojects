@extends('layouts.app')
@section('title', 'Todas las VICOs')
@section('meta')
  <meta name="robot" content="noindex, nofollow">
  <meta name="description" content="Busca una habitación en alquiler en {{$city->name}} y filtrar a través de precio o ubicación con VICO.">
@stop

@section('facebook_opengraph')
  <meta property="og:image" content="{{ asset('images/opengraph/facebook_opengraph_vicorooms.jpg') }}" />
  <meta property="og:image:alt" content="Viviendas compartidas para estancias medianas y largas." />
  <meta property="og:site_name" content="VICO"/>
  <meta property="og:description" content="Busca una habitación en alquiler en {{$city->name}} y filtrar a través de precio o ubicación con VICO."/>
@endsection

@section('content')


{{-- INDEX.BLADE CONTAINER
--}} {{--VICO'S MAIN CONTAINER--}} {{--MAP CONTAINER--}}
<style>
  .not-bold {
    font-family: "Nunitoregular";
  }
</style>

<div class="container-fluid bg-white">
  <div class="row sticky mt-1  bg-white" style="top: 0px !important" id="vico-navbar">
    <div class="col-md-auto py-2 col-12 mx-lg-0 mx-md-auto">
    <form class="form-inline my-2 justify-content-center bg-white" method="GET" action="{{route('search',$city->name )}}" role="search" id="fomSearch">
        {{ csrf_field() }}
        <input type="hidden" name="maxRooms">
        <input type="hidden" name="availableRooms">
        <input type="hidden" name="privateBathroom">
        <input type="hidden" name="enviroment">
        <input type="hidden" name="houseType0">
        <input type="hidden" name="houseType1">
        <input type="hidden" name="houseType2">
        <input type="hidden" name="otherFilters0">
        <input type="hidden" name="otherFilters1">
        <input type="hidden" name="otherFilters2">
        <input type="hidden" name="neighborhoodsArray">
        {{-- COL-10 IN JS -> COL -AUTO + BACKGROUND WHITE + ADJUST MAP + HIDE
        MAP EN MD + Z INDEX APP BAR + MAP +5REM TOP --}}
        <div class="row input-filter-container">
          {{-- FILTRO: UBICACIÓN--}}
          <div class="input-group col-md-auto col-sm-auto d-none d-md-block pr-1">
            <img style="max-width: 36px" src="/icons/favicon-192x192.png">
          </div>
          <div class="searchByNeighborhood">
            <input class="d-none" type="checkbox" id="locationSearch" checked>
            <div class="input-group input-max-width input-group-height col-md-auto col-sm-auto pt-1-md-md pr-md-0 mb-2">
              <input id="search" class="form-control " type="text" placeholder="Universidad/Barrio">
              <div class="input-group-append">
                  <label for="locationSearch" class="input-group-text bg-white">
                      <i class="icon-location"></i>
                  </label>
              </div>
            </div>
            <ul class="dropdown">
              @foreach($schools as $school)
              <li>
                <input  value="{{$school->id}}" data-neighborhood='{{$school->neighborhoods}}' class="checkSchools d-none" type="checkbox" id="school{{$school->id}}" name="school{{$school->id}}" >
                <label class="item" for="school{{$school->id}}">{{$school->name}}</label>
              </li>
              @endforeach
              <hr>
              @foreach($zones as $zone)
                <li class="subdropdown">
                  <div>
                    <input value="{{$zone->id}}" class="checkZone d-none" type="checkbox" id="zone{{$zone->id}}" name="zone{{$zone->id}}" >
                    <label class="item" for="zone{{$zone->id}}">{{$zone->name}}</label>
                  </div>
                  <ul>
                    @foreach ($zone->neighborhoods as $zoneNeighborhood) 
                      <li>
                        <input type="checkbox" id="neighborhood{{$zoneNeighborhood->id}}" name="neighborhood[]" value="{{$zoneNeighborhood->id}}">
                        <label class="subitem" for="neighborhood{{$zoneNeighborhood->id}}">{{$zoneNeighborhood->name}}</label>
                      </li>
                    @endforeach   
                  </ul>
                </li>
              @endforeach
            </ul>
          </div>
          {{--FILTRO: {{trans('houses/index.search')}} POR DISPONIBILIDAD--}}
          <div class="input-group input-max-width input-group-height col-md-auto col-sm-auto pt-1-md-md pr-md-0 mb-2">
            <input class="form-control h-100" style="background-color: white" id="datepickersearch" name="date" placeholder="{{trans('houses/index.search_date')}}"
              autocomplete="off" readonly>
            <div class="input-group-append datepicker-button" data-input="datepickersearch">
              <label class="input-group-text bg-white">
                  <i class="icon-z-date"></i>
              </label>
            </div>
          </div>
          {{---FILTRO: PRECIO--}}
          <div class="input-group input-max-width input-group-height col-md-auto col-sm-auto pt-1-md-md pr-md-0 mb-2" style="">
            <div class="input-group-prepend">
              <span class="input-group-text bg-white">$</span>
            </div>
            <input type="text" class="form-control h-100 dropdown-toggle" aria-label="{{trans('houses/index.max_price')}}" name="maxPrice"
              data-toggle="dropdown" id="sliderPriceButton" placeholder="{{trans('houses/index.max_price')}}" autocomplete="off">
            <ul class="dropdown-menu w-300" style="min-width: 15rem !important">
              <p class="h4 text-center">{{trans('houses/index.filter_by_price')}}</p>
              <span id="sliderPriceValue" class="h5 text-center"></span> {{--VARIABLES PARA EL MÁXIMO PRECIO Y EL MÍNIMO
              PRECIO: $PRICE_LOWER->PRICE,$PRICE_UPPER->PRICE --}}
              <input type="range" id="sliderPrice" min="{{__(300000 * $currency->value)}}" max="{{__(2000000 * $currency->value)}}" value="{{__(2000000 * $currency->value)}}" step={{__(50000* $currency->value )}}
              class="sliderCustom ml-2" autocomplete="off"><br/>
            </ul>
            <div class="input-group-append">
            <label class="input-group-text bg-white price-label" for="">{{$currency->code}}</label>
            </div>
          </div>
          {{-- ESTOS FILTROS SON EXCLUSIVOS PARA LA VISTA DESKTOP EN MEDIA-QUERIES MD Y MAYORES--}} {{-- IMPORTANTE: HAY QUE QUITAR
          EL FIXED BOTTOM PARA VISTAS GRANDES --}}
          <div class="fixed-bottom row bg-white mx-0 justify-content-center" id="filters">
            {{-- FILTRO: LOCATION --}}
            <div class="col-lg-auto pt-1-md pr-md-0 col-2 col-md-2 px-0 pl-md-3 d-block d-md-block d-lg-none br-1b bl-1b bt-1b">
              <button class="btn select-button locationButton" type="button" data-toggle="dropdown" id="locationButton" onClick="document.body.scrollTop = 0;
                  document.documentElement.scrollTop = 0;">
                  <span class="icon icon-location h5"></span>
                </button>
            </div>
            {{-- FILTRO: DATE --}}
            <div class="col-lg-auto pt-1-md pr-md-0 col-2 col-md-2 px-0 pl-md-3 d-block d-md-block d-lg-none br-1b bt-1b">
              <button class="btn select-button dateButton" type="button" data-toggle="dropdown" id="dateButton" onClick="document.body.scrollTop = 0;
                  document.documentElement.scrollTop = 0;  document.getElementById('datepickersearch').focus(); document.getElementsByClassName('gj-icon')[0].click();">
                  <span class="icon icon-z-date h5"></span>
                </button>
            </div>
            {{-- FILTRO: PRICE --}}
            <div class="col-lg-auto pt-1-md pr-md-0 col-2 col-md-2 px-0 pl-md-3 d-block d-lg-none br-1b bt-1b">
              <button class="btn select-button priceButton" type="button" data-toggle="dropdown" id="priceButton" onClick="document.body.scrollTop = 0;
                  document.documentElement.scrollTop = 0;  document.getElementById('sliderPriceButton').click();">
                  <span class="icon pr-2 h5">$</span>
                </button>
            </div>

            {{-- FILTRO: GENERAL --}}
            <div class="col-lg-auto pt-1-md pr-md-0 col-2 col-md-2 px-0 pl-md-3 br-1b bt-1b">
              <button class="btn select-button maxRoomsButton" type="button" data-toggle="modal" data-target="#generalFilters" id="maxRoomsButton">
                  <span class="fas fa-filter"></span>
                </button>
            </div>

            {{--FILTRO: ORDENAR POR PRECIO/FECHA--}}
            <div class="col-lg-auto pt-1-md pr-md-0 dropdown col-2 col-md-2 px-0 pl-md-3 br-1b bt-1b">
                <button type="button" class="btn select-button dateSortButton" data-toggle="dropdown" id="dateSortButton">
                    <span class="icon icon icon-sorting-black h5"></span>
                </button>
                <ul class="dropdown-menu w-300" style="min-width: 15rem !important">
                    <p class="h4 text-center">{{trans('houses/index.order_by')}}</p>
                    <div class="col justify-content-center not-bold">
                        <div class="form-check ">
                            <label class="form-check-label pb-2" for="asceprice">
                                <input type="radio" class="form-check-input checkboxdateSort mr-2" name="sortBy" value="3" id="asceprice">{{trans('houses/index.asc_price')}}
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label pb-2" for="descprice">
                                <input type="radio" class="form-check-input checkboxdateSort mr-2" name="sortBy" value="4" id="descprice">{{trans('houses/index.desc_price')}}
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label pb-2" for="ascdate">
                                <input type="radio" class="form-check-input checkboxdateSort mr-2" name="sortBy" value="1" id="ascdate">{{trans('houses/index.asc_date')}}
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label pb-2" for="descdate">
                                <input type="radio" class="form-check-input checkboxdateSort mr-2" name="sortBy" value="2" id="descdate">{{trans('houses/index.desc_date')}}
                            </label>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="form-inline">
                        <div class="text-right p-1 m-auto">
                            <button type="button" name="button" class="btn btn-link deleteFilters">{{trans('houses/index.delete_filters')}}</button>
                        </div>
                        <div class="text-right p-1 m-auto">
                            <button type="button" name="button" class="btn btn-primary filter-button border-radius">{{trans('houses/index.search')}}</button>
                        </div>
                    </div>
                </ul>
            </div>
          </div>
          <div class="col-12 col-lg-auto pr-md-0 d-flex justify-content-center">

          {{-- Search Button --}}
            <button class="btn btn-primary mr-2 ml-2 border-radius" id="buscar" type="submit" onclick="searchOnIndex()">{{trans('houses/index.search')}}</button>

          {{-- MAP TRIGGER --}}

            <button class="btn btn-primary d-block d-md-block d-lg-none border-radius" type="button" data-toggle="collapse" data-target="#collapseMap" aria-expanded="false" aria-controls="collapseMap" id="pixel-show-map">
                {{trans('houses/index.see_map')}}
            </button>
          </div>
        </div>

      </form>
      {{-- END FORM --}}
    </div>
    <hr class="w-100 py-0 my-0">
  </div>
  {{--MAPA MÓVIL--}}
  <div class="row mb-3" id="mapa-movil">
    <div class="col map-container">
      <div class="collapse map-contaner display-sm display-md" id="collapseMap">
        <div class="map" id="map-mobile"></div>
      </div>
    </div>
    <hr>
  </div>
  {{--FIN MAPA MÓVIL--}} {{-- ROW --}}
  <div class="row mb-2">
    {{--MAPA DESKTOP--}}
    <div class="col map-container" id="mapa-desktop">
      <div class="collapse show fixed-top map-container d-lg-block d-none" style="top:4.8rem" id="collapseMap">
        <div class="map" id="map-desktop"></div>
      </div>
    </div>
    {{--END MAPA DESKTOP--}}
    <div class="col-lg-8 col-md-12 col-12 mt-1">
      <div class="container-fluid">
        {{--PER VICO VIEW--}}
        <div class="row" id="loaddata">
          @forelse($houses as $house) {{-- COL-3 --}}
          <div class="col-lg-4 col-sm-12 col-md-4  p-md-1 p-0 vico-border-radius" id="house-container{{ $house->id }}" onclick="clickOnHouse({{$house->id}}, {{$house->min_price}})" >
            <figure class="">
              {{-- {{$house->vip == 1? 'border-gold':''}} --}}
              <div class="carousel vico-border-radius" data-flickity='{ "pageDots": false, "contain": true, "lazyLoad": true, "wrapAround": true, "imagesLoaded": true }'
                sstyle="width: 100%">
                @foreach($house->main_image as $img)
                <div class="carousel-cell opacity-target" style="width: 100%; opacity: 0; min-height: 193px;">
                  <a href="/houses/{{$house->id}}" target="_blank"><img data-flickity-lazyload="{{'https://fom.imgix.net/'.$img->image}}?w=450&h=300&fit=crop" alt="{{$img->image}}slide" class="carousel-cell-image dblock w-100 rounded"/></a>
                </div>
                @endforeach
              </div>
              @if(Auth::check())
              <?php $flagFavorite = 0;  ?> @foreach ($favorites as $favorite) @if ($house->id == $favorite->id)
              <?php $flagFavorite = 1;  ?> @endif @endforeach
              <i class="ajaxSubmitLike btn-favorite opacity-target {{ ($flagFavorite==1) ? " favorite-house " : " "}} fas fa-heart"></i>              @else
              <button class="btn btn-link btn-favorite" data-toggle="modal" data-target="#Register"><i class="fas fa-heart"></i></button>              @endif
              <div class="vico-index-figure-caption">
                <p class="h5 bold-words">
                  {{$house->name}}
                  <div class="vico-index-counter-rooms-icon" style="background: url({{asset('images/user.png')}}); background-size: contain;">
                    <div class="vico-index-counter-rooms-number"><span class="vico-index-counter-rooms-number-position">{{$house->rooms_quantity}}</span></div>
                  </div>
                </p>
                <p class="vico-index-figure-caption-price">{{trans('houses/index.from')}}
                      {{ __($house->min_price * $currency->value . ' '.$currency->code)}} {{trans('houses/index.month')}}
                </p>
              </div>
              {{-- END TRAFFIC LIGHT FOR AVAILABILITY --}} @if(strtotime($today) >= strtotime($house->min_date)) @php ($color = 'circle-green')
              @php ($tooltip = trans('houses/index.available_now')) @elseif(strtotime($today_30) >= strtotime($house->min_date))
              @php ($color = 'circle-orange') @php ($tooltip = trans('houses/index.available_in_4')) @else @php ($color =
              'circle-red') @php ($tooltip = trans('houses/index.available_more_4')) @endif
              {{-- {{$house->average_house}} --}}
              <p class="vico-index-description"><span class="icon-z-date"></span>@if(strtotime($today) >= strtotime($house->min_date)) {{trans('houses/index.available_now')}}
                @else {{trans('houses/index.available_from')}} {{ date('d/m/Y', strtotime($house->min_date)) }} @endif
                <a
                  style="float: none" href="#/" data-toggle="tooltip" title="{{ $tooltip }}" data-placement="top"><span style="font-size: 12px" class="icon-{{$color}}"></span></a>
              </p>
              <p class="vico-index-description"><span class="icon-location"></span> {{$house->neighborhood_name}} @if (isset($hrefSeeMore))
                <span class="vico-index-ver-mas-right"><a class="simple-link" target="_blank" href="/houses/{{ $house->id }}{{$hrefSeeMore}}"> {{trans('houses/index.see_more')}} <span class="icon-next-fom"></span></a>
                </span>
                @else
                <span class="vico-index-ver-mas-right"><a class="simple-link" target="_blank" href="/houses/{{ $house->id }}"> {{trans('houses/index.see_more')}} <span class="icon-next-fom"></span></a>
                </span>
                @endif
              </p>
            </figure>
            {{-- </a> --}}
          </div>
          {{-- END-COL --}} @empty
          <div class="col-12">
            <h4>{{trans('houses/index.without_vico')}}<br>{{trans('houses/index.try_again')}}</h4>
          </div>
          <div class="m-auto col-12">
            <button type="button" name="button" class="btn btn-outline-primary deleteFilters">{{trans('houses/index.delete_filters')}}</button>
            <button type="button" name="button" class="btn btn-primary filter-button">{{trans('houses/index.search')}}</button>
          </div>
          @endforelse
        </div>
        {{ $houses->links('pagination') }}
        <hr>
      </div>
    </div>
  </div>
</div>

{{-- GENERAL FILTERS MODAL --}}
<div class="modal fade" id="generalFilters" tabindex="-1" role="dialog" aria-labelledby="generalFiltersTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
                <div class="row" style="margin: 15px 0 0 0;">   
                  <h5 class="col-2 text-left">{{trans('houses/index.filters')}}</h5>
                  <a class='col-4' href=""><h5 class="text-left deleteFilters" style="color: #EA9610" id="remove-filters">{{trans('houses/index.delete_filters')}}</h5>
                  </a>
                  <button type="button" style="margin-top: -8px;" class="close col-5 text-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                
      <div class="modal-body">

        {{-- FILTER: ROW 1 --}}
        <div class="row">
          <div class="col-6">
            <p class="text-center">{{trans('houses/index.num_disp_rooms')}}</p>
            <div class="select-room ">
              <div class="room-selector row justify-content-center" style="margin-right:0px; margin-top:-5px;">
                <div class="col-2 room">
                  <input type="radio" name="availableRoomsModal" id="availableRooms1" value="1" class="checkboxAvailableRooms">
                  <label for="availableRooms1">
                          <span class="">1</span>
                        </label>
                </div>
                <div class="col-2  room">
                  <input type="radio" name="availableRoomsModal" id="availableRooms2" value="2" class="checkboxAvailableRooms">
                  <label for="availableRooms2">
                          <span class="">2</span>
                        </label>
                </div>
                <div class="col-2  room">
                  <input type="radio" name="availableRoomsModal" id="availableRooms3" value="3" class="checkboxAvailableRooms">
                  <label for="availableRooms3">
                          <span class="">3</span>
                        </label>
                </div>
                <div class="col-2  room">
                  <input type="radio" name="availableRoomsModal" id="availableRooms4" value="4" class="checkboxAvailableRooms">
                  <label for="availableRooms4">
                          <span class="">4</span>
                        </label>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6">
            <p class="text-center">{{trans('houses/index.max_total_rooms')}}</p>
            <div class="select-room">
              <div class="room-selector row justify-content-center" style="margin-right:0px; margin-top:-5px;">
                <div class="col-2 room">
                  <input type="radio" name="maxRoomsModal" id="maxRooms1" value="1" class="checkboxmaxRooms">
                  <label for="maxRooms1">
                          <span class="">1</span>
                        </label>
                </div>
                <div class="col-2 room">
                  <input type="radio" name="maxRoomsModal" id="maxRooms2" value="6" class="checkboxmaxRooms">
                  <label for="maxRooms2">
                          <span class="">6</span>
                        </label>
                </div>
                <div class="col-2 room">
                  <input type="radio" name="maxRoomsModal" id="maxRooms3" value="12" class="checkboxmaxRooms">
                  <label for="maxRooms3">
                          <span class="">12</span>
                        </label>
                </div>
                <div class="col-2 room">
                  <input type="radio" name="maxRoomsModal" id="maxRooms4" value="18" class="checkboxmaxRooms">
                  <label for="maxRooms4">
                          <span class="">18</span>
                        </label>
                </div>
              </div>
            </div>
          </div>
        </div>
        {{-- END FILTER: ROW 1 --}}
        <div class="dropdown-divider"></div>
        {{-- FILTER: ROW 2 --}}
        <div class="row">
          <div class="col-6">
            <p class="h5 text-center"> {{trans('houses/index.enviroment')}}</p>
            <div class="col text-left not-bold">
              <div class="form-check">
                <label class="form-check-label pb-2" for="">
                        <input type="radio" class="form-check-input  mr-2"  name="enviromentModal" value="1" >{{trans('houses/index.fam_enviroment')}}
                      </label>
              </div>
              <div class="form-check">
                <label class="form-check-label pb-2" for="">
                        <input type="radio" class="form-check-input  mr-2"  name="enviromentModal" value="2">{{trans('houses/index.ind_enviroment')}}
                      </label>
              </div>
            </div>
          </div>
          <div class="col-6">
            <p class="h5 text-center">{{trans('houses/index.bath_type')}}</p>
            <div class="col text-left not-bold">
              <div class="form-check">
                <label class="form-check-label pb-2" for="privateBathroom0">
                        <input type="radio" class="form-check-input checkboxprivateBath mr-2" name="privateBathroomModal" value="0" id="privateBathroom0">{{trans('houses/index.shared_bathroom')}}
                      </label>
              </div>
              <div class="form-check">
                <label class="form-check-label pb-2" for="privateBathroom1">
                        <input type="radio" class="form-check-input checkboxprivateBath mr-2" name="privateBathroomModal" value="1" id="privateBathroom1">{{trans('houses/index.personal_bathroom')}}
                      </label>
              </div>
            </div>
          </div>
        </div>
        {{-- END FILTER: ROW 2 --}}
        <div class="dropdown-divider"></div>
        {{-- FILTER: ROW 3 --}}
        <div class="row">
          <div class="col-6">
            <p class="h5 text-center">{{trans('houses/index.house_type')}}</p>
            <div class="col text-left not-bold">
              <div class="form-check">
                <label class="form-check-label pb-2" for="">
                        <input type="checkbox" class="form-check-input  mr-2" name="houseType0Modal" value="1">{{trans('houses/index.type_house')}}
                      </label>
              </div>
              <div class="form-check">
                <label class="form-check-label pb-2" for="">
                        <input type="checkbox" class="form-check-input  mr-2" name="houseType1Modal" value="1">{{trans('houses/index.type_apartment')}}
                      </label>
              </div>
              <div class="form-check">
                <label class="form-check-label pb-2" for="">
                        <input type="checkbox" class="form-check-input  mr-2" name="houseType2Modal" value="1">{{trans('houses/index.type_study_apart')}}
                      </label>
              </div>
            </div>
          </div>
          <div class="col-6">
            <p class="h5 text-center">{{trans('houses/index.others')}}</p>
            <div class="col text-left not-bold">
              <div class="form-check">
                <label class="form-check-label pb-2" for="">
                        <input type="checkbox" class="form-check-input  mr-2" name="otherFilters0Modal" value="1">{{trans('houses/index.parking_lot')}}
                      </label>
              </div>
              <div class="form-check">
                <label class="form-check-label pb-2" for="">
                        <input type="checkbox" class="form-check-input  mr-2" name="otherFilters1Modal" value="1">{{trans('houses/index.balcony')}}
                      </label>
              </div>
              <div class="form-check">
                <label class="form-check-label pb-2" for="">
                        <input type="checkbox" class="form-check-input  mr-2" name="otherFilters2Modal" value="1">{{trans('houses/index.pool')}}
                      </label>
              </div>
            </div>
          </div>
        </div>
        {{-- END FILTER: ROW 3 --}}
        <div class="dropdown-divider"></div>
        <div class="text-right p-1 m-auto">
          <button type="button" name="button" class="btn btn-primary btn-block filter-button">{{trans('houses/index.search')}}</button>
        </div>
      </div>
    </div>
  </div>
</div>
{{-- END GENERAL FILTERS MODAL --}} {{-- INDEX.BLADE CONTAINER END --}}
@endsection
 {{--END SECCIÓN CONTENIDO--}} {{--Sección
scripts--}}
@section('scripts') {{--Script del mapa--}}
<script>
// SEGMENT-----------------------------------
function searchOnIndex() {
    analytics.track('Search on index view',{
        category: 'Search'
    });    
}
// function clickOnHouse(house_id, house_price) {
//     analytics.track('Click on house index',{
//         category: 'Houses',
//         label: house_id,
//         value: house_price
//     });
// }
// SEGMENT-----------------------------------
</script>
@include('layouts.sections._intercom')

<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<script src="{{ asset('js/markerclusterer.js') }}"></script>
<script>

  window.onload = init; 

  function init() {
    var target = $(".opacity-target");
    target.css({"opacity": "1"});
  }
  
</script>

@include('houses.sections.indexScripts')
// @if(!\Cache::get('first-time'))
//     {{\Cache::forever('first-time', 'true')}}
//     <script type="text/javascript">
//         $('#btnIssues').click();
//     </script>
// @endif

// @if(!\Cache::get('first-time'))
//     {{\Cache::forever('first-time', 'true')}}
//     <script>
//         $('#btnIssues').click();
//     </script>
// @endif

@endsection
 {{--Sección scripts--}}