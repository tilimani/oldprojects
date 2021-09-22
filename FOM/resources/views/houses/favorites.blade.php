@extends('layouts.app')
@section('title', 'Mis favoritos')
@section('content')
	@if (Auth::user() && Auth::user()->email === 'friendsofmedellin@gmail.com' || true)

<div class="col-12 container">
<div class="row m-lg-4 my-2">
		@forelse($users_favorites as $house_favorite)
			<!-- col-3 -->
			<div class="col-lg-4 col-sm-12 col-md-6 vico-border-radius mt-1" id="house-container{{ $house_favorite->id }}">
				<figure class="">
					<div class="carousel vico-border-radius" data-flickity='{ "pageDots": false, "contain": true, "lazyLoad": true, "wrapAround": true, "imagesLoaded": true }' sstyle="width: 100%">
						@foreach($house_favorite->main_image as $img)
							<div class="carousel-cell" style="width: 100%">
								<a href="/houses/{{$house_favorite->id}}" target="_blank"><img data-flickity-lazyload="{{'https://fom.imgix.net/'.$img->image}}?w=450&h=300&fit=crop" alt="{{$img->image}}slide" class="carousel-cell-image dblock w-100 rounded"/></a>
							</div>
						@endforeach
					</div>
					<div class="vico-index-figure-caption">
						<p class="h5">
							{{$house_favorite->name}}
							<div class="vico-index-counter-rooms-icon" style="background: url({{asset('images/user.png')}}); background-size: contain;">
								<div class="vico-index-counter-rooms-number"><span class="vico-index-counter-rooms-number-position">{{$house_favorite->rooms_quantity}}</span></div>
							</div>
						</p>
						<p class="vico-index-figure-caption-price">Desde {{ number_format($house_favorite->min_price,0,'','.') }} COP/Mes</p>
					</div>
					{{-- Traffic Light for availability END --}}
					@if(strtotime($today) >= strtotime($house_favorite->min_date))
						@php ($color = 'circle-green')
						@php ($tooltip = 'Disponibilidad ahora')
					@elseif(strtotime($today_30) >= strtotime($house_favorite->min_date))
						@php ($color = 'circle-orange')
						@php ($tooltip = 'Disponibilidad en 4 semanas')
					@else
						@php ($color = 'circle-red')
						@php ($tooltip = 'Disponibilidad en más de 4 semanas')
					@endif
					<p class="vico-index-description"><span class="icon-z-date"></span>@if(strtotime($today) >= strtotime($house_favorite->min_date)) Disponibilidad ahora @else Disponibles desde {{ date('d/m/Y', strtotime($house_favorite->min_date)) }} @endif <a style="float: none" href="#/" data-toggle="tooltip" title="{{ $tooltip }}" data-placement="top"><span style="font-size: 12px" class="icon-{{$color}}"></span></a><span class="vico-index-ver-mas-right"><button class="btn btn-light btn-delete-favorite ajaxDeleteLike">Eliminar</button></span></p>
						<p class="vico-index-description"><span class="icon-location"></span> Barrio {{$house_favorite->neighborhood_name}}
						</p>
					</figure>
				</a>
			</div>
			<!-- end-col -->
		@empty
		<div class="col-12">
			<h4>No tienes VICO's en tu lista de favoritos</h4>
			</div>
		@endforelse
		</div>
		</div>

@else
  <p>You are not allowed to enter this page.</p>
@endif
@endsection

@section('scripts')
	<script type="text/javascript">
	$(document).ready(function(){
    $('.ajaxDeleteLike').click(function(e){
			var deleteSubmit = e.target;
			var house_instance = deleteSubmit.parentNode.parentNode.parentNode.parentNode;
      var house_id = house_instance.id;
      house_id = house_id.substr(15,house_id.length-1);
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
			house_instance.style.display = "none";
      $.ajax({
        url: '/houses/favorites/delete',
        type: 'DELETE',
        data: {
          _token: CSRF_TOKEN,
          user_id: {{ Auth::user()->id }},
          house_id:	house_id},
          success: function (data) {
						if (data != 1) {
							house_instance.style.display = "block";
						}
          }
        });
    });
  });
	</script>

@endsection
