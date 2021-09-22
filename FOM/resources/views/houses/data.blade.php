	@php
	$numberdata=0;
	$limsup=$limite;
	$liminf=$limsup-16;
	if($liminf<0){
		$liminf=0;
	}
@endphp
@forelse($houses as $house)
	@if ($numberdata<=$limsup)
		 {{-- COL-3  --}}
		<div class="col-lg-6 col-sm-12 col-md-6  p-md-2 p-0 vico-border-radius" id="house-container{{ $house->id }}">

			<figure class="">
				<div class="carousel vico-border-radius" data-flickity='{ "pageDots": false, "contain": true, "lazyLoad": true, "wrapAround": true, "imagesLoaded": true }' sstyle="width: 100%">
					@foreach($house->main_image as $img)
						<div class="carousel-cell" style="width: 100%">
							<a href="/houses/{{$house->id}}" target="_blank"><img data-flickity-lazyload="{{'http://fom.imgix.net/'.$img->image}}?w=450&h=300&fit=crop" alt="{{$img->image}}slide" class="carousel-cell-image dblock w-100 rounded"/></a>
						</div>
					@endforeach
				</div>
				<div class="vico-index-figure-caption">
{{-- 										<a href="/houses/{{$house->id}}" target="_blank" class="" style="color: white">
--}}											<p class="h4">{{$house->name}}
							<div class="vico-index-counter-rooms-icon" style="background: url('../images/user.png'); background-size: contain;">
								<div class="vico-index-counter-rooms-number"><span class="vico-index-counter-rooms-number-position">{{$house->rooms_quantity}}</span></div>
							</div>
						</p>
						<p class="vico-index-figure-caption-price">Desde {{ number_format($house->min_price,0,'','.') }} COP/Mes</p>
{{-- 										</a>
--}}									</div>
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
				<p class="vico-index-description"><span class="icon-z-date"></span>@if(strtotime($today) >= strtotime($house->min_date)) Disponibilidad ahora @else Disponibles desde {{ date('d/m/Y', strtotime($house->min_date)) }} @endif <a style="float: none" href="#/" data-toggle="tooltip" title="{{ $tooltip }}" data-placement="top"><span style="font-size: 12px" class="icon-{{$color}}"></span></a></p>
					<p class="vico-index-description"><span class="icon-location"></span> Barrio {{$house->neighborhood_name}}
						<span class="vico-index-ver-mas-right"><a class="simple-link" target="_blank" href="/houses/{{ $house->id }}"> Ver más <span class="icon-next-fom"></span></a></span>
					</p>
				</figure>
			</a>
		</div>
		 {{-- END-COL  --}}
	@endif
	<?php $numberdata++; ?>
@break($numberdata==$limsup)
@empty
<!--h1 class="text-center">Consulta sin resultados</h1-->
@endforelse
