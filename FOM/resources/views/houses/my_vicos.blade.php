@extends('layouts.app')
@section('title', "Mis Casas")
@section('content')
	@if (Auth::user() && Auth::user()->email === 'friendsofmedellin@gmail.com' || true)

<div class="col-12 container">
<div class="row m-lg-4 my-2">
		@forelse($houses as $house)
			<!-- col-3 -->
			<div class="col-lg-4 col-sm-12 col-md-6 vico-border-radius mt-1" id="house-container{{ $house->id }}">
				<figure class="">
					<div class="carousel vico-border-radius opacity-target" data-flickity='{ "pageDots": false, "contain": true, "lazyLoad": true, "wrapAround": true, "imagesLoaded": true }' style="opacity: 0; height: 283px;">
						@foreach($house->main_image as $img)
							<div class="carousel-cell" style="width: 100%">
								<a href="/houses/{{$house->id}}" target="_blank"><img data-flickity-lazyload="{{'https://fom.imgix.net/'.$img->image}}?w=450&h=300&fit=crop" alt="{{$img->image}}slide" class="carousel-cell-image dblock w-100 rounded"/></a>
							</div>
						@endforeach
					</div>
					<div class="vico-index-figure-caption">
						<p class="h5 bold-words">
							{{$house->name}}
							<div class="vico-index-counter-rooms-icon" style="background: url({{asset('images/user.png')}}); background-size: contain;">
								<div class="vico-index-counter-rooms-number"><span class="vico-index-counter-rooms-number-position">{{$house->rooms_quantity}}</span></div>
							</div>
						</p>
						<p class="vico-index-figure-caption-price">Desde {{ $house->min_price }} COP/Mes</p>
					</div>
					{{-- Traffic Light for availability END --}}
					@if(strtotime($today) >= strtotime($house->min_date))
						@php ($color = 'circle-green')
						@php ($tooltip = 'Disponibilidad ahora')
					@elseif(strtotime($today_30) >= strtotime($house->min_date))
						@php ($color = 'circle-orange')
						@php ($tooltip = 'Disponibilidad en 4 semanas')
					@else
						@php ($color = 'circle-red')
						@php ($tooltip = 'Disponibilidad en más de 4 semanas')
					@endif
					<p class="vico-index-description"><span class="icon-z-date"></span>@if(strtotime($today) >= strtotime($house->min_date)) Disponibilidad ahora @else Disponibles desde {{ date('d/m/Y', strtotime($house->min_date)) }} @endif <a style="float: none" href="#/" data-toggle="tooltip" title="{{ $tooltip }}" data-placement="top"><span style="font-size: 12px" class="icon-{{$color}}"></span></a>
						<span class="vico-index-ver-mas-right"><a class="simple-link" target="_blank" href="/houses/editnew/{{ $house->id }}"> Editar <span class="icon-next-fom"></span></a></span>
					</p>
						<p class="vico-index-description" style="display: inline-block;"><span class="icon-location"></span>
							Barrio {{$house->neighborhood_name}}
						</p>
						@if(Auth::user()->role_id === 1)
						<div class="inline-block m-lg-4">
							@if($house->status === "5")
								<form method="POST" action="/houses/updateStatusHouse" style="display: inline-block; padding-left: 28%;">
									{{csrf_field()}}
									<input type="hidden" name="house_id" value="{{$house->id}}">
									<input type="hidden" name="new_status" value="1">
									<button type="submit" class="btn btn-primary mr-2 ml-2">Habilitar</button>
								</form>
							@elseif($house->status === "1")
								<form method="POST" action="/houses/updateStatusHouse" style="display: inline-block; padding-left: 28%;">
									{{csrf_field()}}
									<input type="hidden" name="house_id" value="{{$house->id}}">
									<input type="hidden" name="new_status" value="5">
									<button type="submit" class="btn btn-primary mr-2 ml-2">Deshabilitar</button>
								</form>
							@endif
							<br>
							<form method="POST" action="{{route('notify.photoshoot')}}" style="display: inline-block; padding-left: 28%;">
								{{csrf_field()}}
								<input type="hidden" name="house_id" value="{{$house->id}}">
								<input type="hidden" name="manager_as_user_id" value="{{$house->manager->user->id}}">
								<button type="submit" class="btn btn-primary mr-2 ml-2">Notificar sesión de fotos</button>
							</form>
						</div>
						@endif
					</figure>
				</a>
			</div>
			<!-- end-col -->
		@empty
		<div class="col-12">
			<h4>No tienes VICO's</h4>
			</div>
		@endforelse
		</div>
		</div>

@else
  <p>You are not allowed to enter this page.</p>
@endif




@endsection

@section('scripts')

<script>		
	window.onload = init;

	function init() {
		var target = $(".opacity-target");
		target.css({"opacity": "1"});
	}		
</script>

@endsection

