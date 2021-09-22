@extends('layouts.app')
@section('title', $house->name)

{{-- SOCIAL APIS --}}
{{--SECTION: META--}}
@section('meta')
	<meta name="description" content="This VICO is located in {{$neighborhood->name}} and has {{ $house->rooms_quantity}} bedrooms starting from {{$house->min_price}} COP/month. {{$house->description_house}}">
	@if($house->status==5)<meta name="robot" content="noindex, nofollow">@endif
	<link rel="canonical" href="https://www.getvico.com/houses/{{$house->id}}" />
@endsection
{{--END SECTION: META--}}

@section('facebook_opengraph')
  <!-- Facebook Opengraph integration: https://developers.facebook.com/docs/sharing/opengraph -->
  <meta property="og:description" content="This VICO is located in {{$neighborhood->name}} and has {{ $house->rooms_quantity}} bedrooms starting from {{$house->min_price}} COP/month. {{$house->description_house}}"/>
  <meta property="og:image" itemprop="image" content="https://fom.imgix.net/{{$house->main_image[0]->image }}?w=1200&h=628&fit=crop" />
  <meta property="og:url" content="https://www.getvico.com/houses/{{$house->id}}" />
  <meta property="og:site_name" content="">
  <meta property="og:description" content="">
@stop
{{-- END SOCIAL APIS --}}

{{--SECTION: CONTENT--}}
@section('content')
	{{--SECTION: STYLES--}}
	@section('styles')

		<style type="text/css">
			.popover{
				width: 100%;
				z-index: auto;
			}

			. {
				font-family: Nunitoregular;
			}

		/* NOTE: The styles were added inline because Prefixfree needs access to your styles and they must be inlined if they are on local disk! */
		i{
			font-style: normal;
		}
		.star-rating {
			/*margin: 0; Comentado porque hace que el div aparezca más abajo
			padding: 0;*/
			display: inline-block;
			padding-left: 0px;
		}

		.global-rating{
			font-size: 1.3rem !important;
		}
		@media screen and (min-width: 375px){
	    .star-rating .star {
	      /* padding: 3px 3px 3px 0px; */
	      color: #ddd;
	      text-shadow: .05em .05em #aaa;
	      list-style-type: none;
	      display: inline-block;
	      cursor: pointer;
	      font-size: 1rem;
	    }
	  }
	  @media screen and (max-width: 375px){
	    .star-rating .star {
	      /* padding: 3px 3px 3px 0px; */
	      color: #ddd;
	      text-shadow: .05em .05em #aaa;
	      list-style-type: none;
	      display: inline-block;
	      cursor: pointer;
	      font-size: 1rem;
	    }
	  }
		.star-rating .star.filled {
			color: #fd0;
		}
		.star-rating.readonly .star.filled {
			color: #666;
		}
		/*! Flickity v2.1.2
		https://flickity.metafizzy.co
		---------------------------------------------- */
		.carousel-cell {
			width: 20%; /* full width */
			margin-right: 10px;
		}
		.vico-header-carousel .carousel-cell {
			width: 100%; /* full width */
			margin-right: 0px;
		}
		.room-carousel .carousel-cell {
			width: 100%; /* full width */
			margin-right: 0px;
		}
		@media screen and ( max-width: 768px ) {
			/* half-width cells for larger devices */
			.carousel-cell { width: 33%; }
		}
		.flickity-button {
			background: transparent;
		}
		.main-carousel .flickity-button {
			background: #ea960f;
		}
		.flickity-button-icon {
			fill: white;
		}
		.flickity-button:hover {
			background: #ea960f;
		}
		#map{
			height: 30em;
			width: 100%;
		}
		.vico-body{
			padding-top: 56.77px;
		}
		.vico-show-carousel-gallery-mobile{
			margin-top: -5rem;
			right: 8px;
			z-index: 1000;
			position: absolute;
			opacity: 1;
		}
		.vico-show-carousel-gallery-mobile-button{
			color:white;
			margin-top: 30%;
		}
		.xd-message {
			display: flex;
			flex-wrap: nowrap;
			width: 100%;
			height: 100%;
			min-height: 60px;
			background: #FFF;
			border: 1px solid #455870;
			margin-bottom: 2rem;
			box-shadow: 2px 4px 10px rgba(0,0,0,0.1);
		}
		.xd-message-icon {
			background: #455870;
			display: flex;
			flex: 1;
			justify-content: center;
			align-items: center;
			color: #FFF;
			font-size: 1.6rem;
			margin: 0;
			margin-left: -1px;
		}
		.xd-message-content {
			flex: 6;
			padding-left: 1.5rem;
			margin: 0;
			display: flex;
			align-items: center;
		}
		.xd-message-close {
			color: #455870;
			display: flex;
			flex: 1;
			justify-content: center;
			align-items: center;
			font-size: 1.2rem;
			transition: color .4s ease;
		}
		.xd-message-close-icon {
			transition: color .4s ease;
		}

		.popover{
			z-index:1151 !important;
		}
		.loader {
		border: 16px solid #f3f3f3;
		border-radius: 50%;
		border-top: 16px solid orange;
		width: 120px;
		height: 120px;
		-webkit-animation: spin 0.6s linear infinite; /* Safari */
		animation: spin 0.5s linear infinite;
		}

		/* Safari */
		@-webkit-keyframes spin {
		0% { -webkit-transform: rotate(0deg); }
		100% { -webkit-transform: rotate(360deg); }
		}

		@keyframes spin {
		0% { transform: rotate(0deg); }
		100% { transform: rotate(360deg); }
		}
		.vico-show-admin-card-picture{
			width: 7rem;
			height: 7rem;
		}
		.share-button{
			margin: 2rem 0;
			position: relative;
		}
		.share-button::after{
			content: '¡Comparte la VICO con tus amigos!';
			position: absolute;
			left: 0;
			top: -25px;
		}
		.share-button .whatsapp,
		.share-button .facebook{
			margin-right: 1rem;
		}
		.share-button .whatsapp .fa-whatsapp{
			color: white;
			background-color: lightgreen;
			height: 40px;
			width: 40px;
			border-radius: 50%;
			text-align: center;
			line-height: 40px;
			font-size: 1.8rem;
		}
		.share-button .facebook .fa-facebook-f{
			color: white;
			background-color: lightskyblue;
			text-align: center;
			height: 40px;
			width: 40px;
			border-radius: 50%;
			text-align: center;
			line-height: 40px;
			font-size: 1.8rem;
		}
		.share-button .email .fa-envelope{
			color: white;
			background-color: lightcoral;
			text-align: center;
			height: 40px;
			width: 40px;
			border-radius: 50%;
			text-align: center;
			line-height: 40px;
			font-size: 1.8rem;
		}

		.fix-bg::after,
		.fix-bg::before{
			content: '';
    		background: unset;
		}

		.suggested-houses{
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .suggested-house{
            width: 30%;
            box-sizing: border-box;
            position: relative;
            margin-bottom: 10px;
        }
		@media screen and (max-width: 425px) {
			.suggested-house{
				width:100%;
			}
		}
        
        .suggested-house .image{
            border-radius: 25px;
            width: 100%;
        }
		.suggested-house .location-icon{
			width: 0.8rem;
		}
        .suggested-house .name_price{
            position: absolute;
            color: white;
            bottom: 0;
            left: 50%;
            right: 0;
            transform: translateX(-50%);
            background: #ffa50069;
            width: 100%;
            border-radius: 0 0 25px 25px;
            height: 55px;
            padding: 10px;
        }
        .suggested-house .suggested-house-info{
            position: relative;
        }
		</style>
@endsection
	{{--END SECTION:STYLES--}}

	{{--PICTURE CONTAINER--}}
	 {{-- ROW  --}}

	{{-- ======== START FOTO SECTION ======= --}}
	{{-- ROW START --}}
	<div class="row vico-body" style="padding:0px; margin:0px">
@if($house->status==5)
<div class="xd-message w-100 mt-1 mb-1">
    <div class="xd-message-icon">
      <p>!</p>
    </div>
    <div class="xd-message-content">
      <p>{{trans('houses/show.not_approved')}} <a href="mailto:contacto@friendsofmedellin.com">{{trans('houses/show.contact_us')}}.</a></p>
    </div>
    <a class="xd-message-close">
      <i class="close-icon ion-close-round"></i>
    </a>
 </div>
 @endif
 <div class="col-12 d-md-none" style="padding:0px; margin:0px">
	{{--VICO CAROUSEL--}}
	<div class="vico-header-carousel" data-flickity='{ "pageDots": false, "contain": true, "lazyLoad": true, "wrapAround": true, "imagesLoaded": true}'>
		@forelse($house->main_image as $img)
		<div class="carousel-cell">
			<a data-toggle="modal" data-target=".house-gallery" ><img style="border-radius: 0 !important;" class="dblock w-100" src="https://fom.imgix.net/{{ $img->image }}?w=750&h=500&fit=crop" alt="{{$img->image}}slide"></a>
		</div>
		@empty
		@endforelse
	</div>
	<a style="margin-top: -5rem" class="vico-show-carousel-gallery-mobile" data-toggle="modal" data-target=".house-gallery"><h4 class="vico-show-carousel-gallery-mobile-button">{{trans('houses/show.see_gallery')}} <span class="icon-gallery" style="color: white;"></span></h4>
	</a>
	{{--END VICOCAROUSEL--}}
</div>
{{-- COL-6 --}}
<div class="col-md-6 col-12 d-none d-md-block" style="padding:0px; margin:0px">
	<a data-toggle="modal" data-target=".house-gallery" >
		<img src="{{'https://fom.imgix.net/'.$house->main_image[0]->image }}?w=750&h=500&fit=crop" class="img-fluid" alt="Responsive image"></a>
	</div>
	{{-- COL-6 --}}
	<div class="col-md-6 d-none d-md-block" style="padding:0px; margin:0px">
		@for($i=1;$i<=4;$i++)
		<div class="col-md-6 float-left " style="padding:0px; margin:0px;">
			<a data-toggle="modal" data-target=".house-gallery" >
				<img src="{{'https://fom.imgix.net/'.$house->main_image[$i]->image }}?w=750&h=500&fit=crop" class="img-fluid" alt="Responsive image"></a>
				{{-- OVERLAY GALLERY --}}
				@if($i==4)
				<a  class="vico-show-overlay-second-gallery" data-toggle="modal" data-target=".house-gallery"><h4 class="vico-show-overlay-second-gallery-header">{{trans('houses/show.see_gallery')}} <span class="icon-gallery" style="color: white;"></span></h4>
				</a>
				@endif
				{{-- END OVERLAY GALLERY --}}
		</div>
		@endfor
	</div>
</div>
 {{-- END ROW --}}
{{-- ======== END FOTO SECTION======== --}}
{{-- ======== START CONTAINER======== --}}
<div class="p-lg-5">
	{{-- ======== START MAIN ROW======== --}}
	<div class="row mr-1">
		{{-- ======== START COL-9======== --}}
		<div class="col-md-9 col-12 mx-auto">
			{{-- ======== START CONTAINER FLUID======== --}}
			<div class="container-fluid">


			{{-- ======== ROW DESCRIPCTION VICO START ======== --}}

				<div class="row">
					<!-- col-8 -->
					<div class="col-lg-8 col-12 mt-4">

					{{-- VICO Name --}}
					<p class="h1 bold-words text-uppercase">
						{{$house->name}}
							@if (Auth::user())
								<i class=" fas fa-heart ajaxSubmitLike btn-favorite-on-house-view {{ ($favorite_house) ? "favorite-house-on-view" : ""}}"></i>
							@else
								<button class="btn btn-link btn-favorite-on-house-view" data-toggle="modal" data-target="#Register"><i class="fas fa-heart"></i></button>
							@endif
					</p>
					<div class="share-button">
						<a class="whatsapp" href="https://api.whatsapp.com/send?text=https://getvico.com/houses/{{$house->id}}" target="_blank">
							<i class="fab fa-whatsapp"></i>
						</a>
						{{-- <div id="fb-root"></div>
						<div class="fb-share-button" data-href="https://getvico.com/houses/{{$house->id}}" data-layout="button_count"></div> --}}
						<a class="facebook" href="http://www.facebook.com/sharer.php?u=https://getvico.com/houses/{{$house->id}}" target="_blank">
							<i class="fab fa-facebook-f"></i>
						</a>
						<a class="email" href="mailto:?Subject=Simple Share Buttons&amp;Body=Look%20at%20this%20house%20at%20VICO https://getvico.com/houses/{{$house->id}}">
							<i class="far fa-envelope"></i>
						</a>
					</div>

					{{-- Neighborhood --}}
						<a href="#map" style="color: #3a3a3a">
							<p class="h4 mb-2">
								<span class="icon-map-black" style="font-size: 1.2rem"></span> {{trans('houses/show.neighborhood')}} {{$neighborhood->name}} / {{$city->name}} <span class="icon-next-fom" style="font-size: 1.2rem;"></span>
							</p>
						</a>

					{{-- VICO Descriptions --}}
						<p class="h4 mb-4 vico-color bold-words">{{trans('houses/show.vico_description')}}  </p>
						{{-- ROW START --}}
						<div class="row justify-content-between">
							{{-- COL-6 --}}
							<div class="col-7 col-md-6 pr-0">
								<ul class="list-group bullet-points-off">

								{{-- Room Number --}}
									<li>
										@if ($house->rooms_quantity > 1)
										<p><span class="icon-z-bed"></span> {{ $house->rooms_quantity}} {{trans('houses/show.rooms')}}</p>
										@else
										<p><span class="icon-z-bed"></span> {{ $house->rooms_quantity}} {{trans('houses/show.room')}}</p>
										@endif
									</li>
									<li><p><span class="icon-z-date"></span>
										@if(strtotime($today) >= strtotime($house->min_date))
										{{trans('houses/show.availability_now')}}
										@else
										{{trans('houses/show.availability')}}: {{date('d/m/y', strotime($house->Rooms->min('available_from')))}}
										@endif
									</p></li>
								</ul>
							</div>
							{{-- END COL-6 --}}
							{{-- COL-6 --}}
							<div class="col-5 col-md-6 pl-0">
								<ul class="list-group bullet-points-off">
									<li><p><span class="icon-z-bathroom-2"></span>
										@if ($house->baths_quantity > 1)
										{{$house->baths_quantity}} {{trans('houses/show.bathrooms')}}
										@else 
										{{$house->baths_quantity}} {{trans('houses/show.bathroom')}}
										@endif
									</p></li>
									<li><p><span class="icon-z-zbuilding"></span>
										 @if ($house->type == "Aparta-estudio") {{trans('houses/show.ht_studio')}}
										 @elseif ($house->type == "Apartamento") {{trans('houses/show.ht_apartment')}}
										 @elseif ($house->type == "Casa") {{trans('houses/show.ht_house')}}
										 @endif
										</p></li>
								</ul>
							</div>
							{{-- COL-6 END --}}
						</div>
						{{-- ROW END --}}
					</div>
					 {{-- COL-8 END --}}
				</div>

			{{-- ======== END ROW DESCRIPTION VICO ======== --}}


			{{-- ADMIN MOBILE START --}}

				<hr class="d-lg-none d-block">
				<div class="row justify-content-center d-lg-none d-block">
					{{-- COL Start --}}
					
					{{-- Heading --}}
						<div class="col-12" style="">
							<p class="h4 mb-4 vico-color">
								{{trans('houses/show.who_admin')}}
							</p>
						</div>

						<div class="col-12">
						{{-- IMAGE --}}
							<div class="">
								<div class="d-flex justify-content-center" >
									@if ($manager->image)
										<img class="img-responsive rounded-circle vico-show-admin-card-picture mb-2" src="https://fom.imgix.net/{{$manager->image}}?w=500&h=500&fit=crop" alt="Administrador">
									@else
										<img class="img-responsive rounded-circle vico-show-admin-card-picture mb-2" src="https://fom.imgix.net/user_image_1_2019_05_31_20_21_56.png?w=500&h=500&fit=crop">
									@endif									
								</div>
							</div>
						</div>

					{{-- Desscription Name + Member --}}
						<div class="col-12">
							<p class="h4 m-0 pt-1 text-center">{{ $manager->name }}</p>
							{{-- @if($manager->vip)<p class="small m-0 pt-1"><span class="icon-check"></span> Verificado</p>@endif --}}
						</div>

					{{-- Description --}}
						<div class="col-12 mt-2">
							<p class="d-inline viewLessReview d-md-none">{{str_limit($manager->description, $limit = 160, $end='...')}}</p>
							<p class="d-none viewMoreReview" >{{$manager->description}}</p>
							<p class="d-md-block d-none" >{{$manager->description}}</p>
							<a href="" class="pl-2 d-inline viewMoreButton d-md-none" >{{trans('houses/show.watch_more')}}</a>
						</div>
				</div>

			{{-- ADMIN MOBILE --}}

				<hr>
				 {{-- ======== ROW ACERCA VICO START ========  --}}
				<div class="row separator">
					 {{-- COL  --}}
					<div class="col-12">
						<p class="h4 mb-4 vico-color bold-words">{{trans('houses/show.about_vico')}}
							
							@if (Lang::locale() !== 'es')
							 <div class="switch-translator">
								<div class="inputGroup">
										<input class="switch-translate" id="option0" id-text="0" name="option0" type="checkbox"/>
										<label class="small" for="option0">{{trans('houses/show.translate_to_language')}}</label>
									</div>
								</div>
							@endif
						</p>
						<p class="text-to-translate " id-text="0">{!! nl2br($house->description_house) !!}<br>{!! nl2br($house->description) !!}</p>
						<p class="translated-text" id-text="0"></p>
					</div>
					 {{-- END COL --}}
				</div>
				 {{-- ======== ROW ACERCA VICO START ========  --}}
				<hr>
				 {{-- ======== ROW ACERCA DEL {{trans('houses/show.neighborhood')}} START ========   --}}
				<div class="row separator">
					 {{-- COL  --}}
					<div class="col-12">
						<p class="h4 mb-4 vico-color bold-words">{{trans('houses/show.about_neighborhood')}} - <small><a href="#map">{{trans('houses/show.watch_map')}} <span class="vico-color icon-map-black"></span>   <span class="vico-color icon-next-fom"></span></a></small></p>
						<p class="text-to-translate " id-text="0">{!! nl2br($house->description_zone) !!}<br>{!! nl2br($house->description2) !!}</p>
						<p class="translated-text" id-text="0"></p>
					</div>
					 {{-- END COL --}}
				</div>
				 {{-- ======== END ROW ACERCA DEL {{trans('houses/show.neighborhood')}} ========  --}}

				<hr>

			<!-- ======== Row HABITANTS START ======== -->
					<div class="row">
						 {{-- COL-12  --}}
						<div class="col-12">
							<p class="h4 mb-4 vico-color bold-words">
								{{trans('houses/show.who_live')}}
								<select name="filter2" id="filter2" class="filter sources" placeholder="{{trans('houses/show.now')}}">
									<option value="1">{{trans('houses/show.on')}} {{ $months_name['1'] }}</option>
									<option value="2">{{trans('houses/show.on')}} {{ $months_name['2'] }}</option>
									<option value="3">{{trans('houses/show.on')}} {{ $months_name['3'] }}</option>
									<option value="4">{{trans('houses/show.on')}} {{ $months_name['4'] }}</option>
									<option value="5">{{trans('houses/show.on')}} {{ $months_name['5'] }}</option>
									<option value="6">{{trans('houses/show.on')}} {{ $months_name['6'] }}</option>
									<option value="0" selected hidden>{{trans('houses/show.now')}}</option>
								</select>
							</p>
							<div style="text-align:center;">
								<div class="center" style="display:inline-block;">
									<select name="filter1" id="filter1" class="filter sources" placeholder="{{trans('houses/show.who_lived')}}">
										<option value="-6">{{trans('houses/show.on')}} {{ $months_name['-6'] }}</option>
										<option value="-5">{{trans('houses/show.on')}} {{ $months_name['-5'] }}</option>
										<option value="-4">{{trans('houses/show.on')}} {{ $months_name['-4'] }}</option>
										<option value="-3">{{trans('houses/show.on')}} {{ $months_name['-3'] }}</option>
										<option value="-2">{{trans('houses/show.on')}} {{ $months_name['-2'] }}</option>
										<option value="-1">{{trans('houses/show.on')}} {{ $months_name['-1'] }}</option>
										<option value="-0" selected hidden>{{trans('houses/show.who_lived')}}</option>
									</select>
								</div>
							</div>
							{{--
							<br>
							<button type="button" name="select_hider" id="select_hider" class="more-options d-none">Más opciones</button>
							<br>
							<br>--}}
							{{-- ROW START --}}
							<div class="row">
								{{-- COL-AUTO START --}}
								<div class="col-12">
									@forelse($homemates as $homemate)
	                                        @if($loop->first)
	                                            <div class="main-carousel" data-flickity='{ "pageDots": false, "contain": true, "groupCells": true}' id="caroulseFather">
											@endif
											@if (count($homemates)<=0)
												<div class="row">
													<div class="col-auto">
														<span class="icon-no-user display-2" style="color: #3a3a3a"></span>
													</div>
													<div class="col-auto">
														<p>{{trans('houses/show.not_information')}}</p>
													</div>
												</div>
											@elseif ( (date('Y-m-d',strtotime($homemate->date_from)) <= date('Y-m-d',strtotime($today))) && (date('Y-m-d',strtotime($homemate->date_to)) >= date('Y-m-d',strtotime($today))) )
												<div class="carousel-cell" style="height: ">
	                                                @if($homemate->gender === 2)
	                                                    <img style="height: 90px; width: 90px" src="../images/homemates/girl.png" alt="girl" srcset="../images/homemates/girl@2x.png 2x, ../images/homemates/girl@3x.png 3x" />
	                                                    <small ><img class=" vico-show-habitant-flag" style="top: 3.7rem !important" src="../images/flags/{{$homemate->icon}}"></small>
	                                                @else
	                                                    <img style="height: 90px; width: 90px" src="../images/homemates/boy.png" alt="boy" srcset="../images/homemates/boy@2x.png 2x, ../images/homemates/boy@3x.png 3x" />
	                                                    <small ><img class=" vico-show-habitant-flag" style="top: 3.7rem !important" src="../images/flags/{{$homemate->icon}}"></small>
	                                                @endif
	                                                    <p class="h6 my-2 text-center" style="width: 90px">@if($homemate->name === "") - @else {{$homemate->name}} @endif</p>
												</div>
											@endif
											@empty
												<div class="row">
													<div class="col-auto">
														<span class="icon-no-user display-2" style="color: #3a3a3a"></span>
													</div>
													<div class="col-auto">
														<p>{{trans('houses/show.not_information')}}</p>
													</div>
									@endforelse
								</div>
							</div>
							{{-- END COL-12 --}}
						</div>
						 {{-- END ROW --}}
					</div>
				</div>
			{{-- ======== END ROW HABITANTS ========  --}}
				<hr>
			 {{-- ======== ROOM SECTION START ROW ========  --}}
					<div class="row" id="rooms-section">
						 {{-- COL-12  --}}
						<div class="col-12">
							{{-- TITLE --}}

							<p class="h4 mb-4 vico-color bold-words">{{trans('houses/show.rooms_vico')}} <small >({{$house->rooms_quantity}})</small></p>
							@if ($house->filteredRooms)
							<p class="h4 mb-3"><small >Se organizaron las habitaciones segun tu criterio de busqueda.</small></p>
							@endif
							{{-- ROW --}}
							<div class="row justify-content-between">
								{{--EACH HOUSES ROOM--}}
								@foreach($house->Rooms as $room)
									{{-- TRAFFIC LIGHT FOR AVAILABILITY START --}}
									@if(strtotime($today) >= strtotime($room->available_from))
										@php ($color = 'circle-green')

										@php ($tooltip = trans('houses/show.availability').' ahora')
									@elseif(strtotime($today_30) >= strtotime($room->available_from))
										@php ($color = 'circle-orange')
										@php ($tooltip = trans('houses/show.availability').' en 4 '.trans('houses/show.weeks'))
									@else
										@php ($color = 'circle-red')
										@php ($tooltip = trans('houses/show.availability').' en más de 4 '.trans('houses/show.weeks'))
									@endif
									{{-- END TRAFFIC LIGHT --}}
									 {{-- COL-MD-6 COL-SM-12 --}}
									<div class="col-md-6 col-12 pr-0 pr-md-3">
										<figure class="">

											{{-- ROOM CAROUSEL--}}
											<div class="carousel room-carousel" data-flickity='{ "pageDots": false, "lazyLoad": 2, "imagesLoaded": true, "wrapAround": true }' style="width: 100%">
												@foreach($room->main_image as $img)
												<div class="carousel-cell">
													<a href="#" data-toggle="modal" data-target=".room-{{ $room->id }}">
														<img src="{{'https://fom.imgix.net/'.$img->image}}?w=450&h=300&fit=crop" alt="{{$img->image}}slide" class="dblock w-100 rounded"/>
													</a>
													<a class="show-gallery" href="#" data-toggle="modal" data-target=".room-{{ $room->id }}">
														<p class="h5 d-lg-block d-none">{{trans('houses/show.see_gallery')}} <span style="color:white" class="icon-gallery"></span>
														</p>
													</a>
													<a class="show-gallery" href="#" data-toggle="modal" data-target=".room-{{ $room->id }}">
														<p class="h5 d-lg-none">
															{{trans('houses/show.see_gallery')}}
															<span style="color: white;" class="icon-gallery"></span>
														</p>
													</a>
												</div>
												@endforeach
											</div>
											{{-- END ROOM CAROUSEL--}}

											{{--ROOM DESCRIPTION--}}
											{{-- IF FOR DUMMY ROOM DESCRIPTION --}}
											@if($room->price==99999999 OR date('d/m/Y', strtotime($room->available_from)) == "30/12/9999" )
											<figcaption>
												{{-- ROW START  --}}
												<div class="row">
													{{-- COL 12 START --}}
													<div class="col-12">
														{{-- INNER ROW START --}}
														<div class="row pt-2">
															{{-- INNER COL 8 START --}}
															<div class="col-12">
																<p class="h5 m-0">{{trans('houses/show.Room')}} #{{$room->number}}</h4> </p>
																<p class="h6 m-0 pt-1 font-weight-light mb-3"><a href="#/" data-toggle="tooltip" title="{{ $tooltip }}" data-placement="top">
																	<span style="font-size: 12px;color: " class="icon-circle-red"></span></a> {{trans('houses/show.not_rented')}}</p>
															</div>
															{{-- END INNER COL 8 --}}
														</div>
														{{-- END INNER ROW --}}
													</div>
													{{-- END COL 12 --}}
												</div>
												{{--END ROW --}}
											</figcaption>
											{{-- END DUMMY ROOM DESCRIPTION --}}
											@else
											<figcaption>
												{{-- ROW START  --}}
												<div class="row">
													{{-- BUTTON MODAL GALLERY DESKTOP --}}
													{{-- style="position: absolute;bottom: 9rem;color: white !important;right: 1.5rem" --}}
													<a class="show-gallery" href="#" data-toggle="modal" data-target=".room-{{ $room->id }}">
														<p class="h5 d-lg-block d-none">{{trans('houses/show.see_gallery')}} <span style="color:white" class="icon-gallery"></span>
														</p>
													</a>
													{{-- BUTTON MODAL GALLERY DESKTOP END --}}

													{{-- COL 12 START --}}
													<div class="col-12">
														{{-- INNER ROW START --}}
														<div class="row pt-2">
															{{-- INNER COL 8 START --}}
															<div class="col-8">
																{!! $room->info_dates !!}
																<p class="h5 m-0">
																	<span>{{trans('houses/show.Room')}} #{{$room->number}}</span>
																	<br>
																	<span class="text-orange">{{$room->price * $currency->value }} {{__($currency->code.'/'. trans('houses/show.month'))}}</span>
																</h4>
																</p>
																<p class="h6 m-0 pt-1 font-weight-light"><a href="#/" data-toggle="tooltip" title="{{ $tooltip }}" data-placement="top">
																	<span style="font-size: 12px" class="icon-{{$color}}"></span></a>
																	{{trans('houses/show.available')}}: {{date('d/m/Y', strtotime($room->available_from))}}
																	<a href="javascript:void(0);" class="open_dates d-none" value_room={{$room->id}}> {{trans('houses/show.see_availability')}}</a></p>
																	<input type="hidden" id="info_date_datepicker_{{$room->id}}" class="info_date_datepicker pixel-see-room-availability" value_room={{$room->id}}>
																	{{-- <p class="h6 m-0 pt-1 font-weight-light">$ {{ number_format($room->price,0,'','.') }} COP/{{trans('houses/show.month')}}</p> --}}
																	<p class="h6 m-0 pt-1 font-weight-light">
																		@if(strpos($room->devices->bath_type, 'priv')!==false)
																			{{trans('houses/show.bathroom_private')}}
																		@else
																			{{trans('houses/show.bathroom_shared')}}
																		@endif
																	</p>

																</div>
																{{-- END INNER COL 8 --}}

																{{-- INNER COL 4 BUTTON CONTACTAR DUEÑO PARA MODAL --}}
																<div class="col-4 ">
																	<div class="col-4 ">
																		{{-- GALLERY BUTTON FOR MOBILE --}}
																		{{-- style="position: absolute;bottom: 5rem;color: white;left: -1.5rem" --}}
																		{{-- CONTACT BUTTON --}}
																		<a href="#" class="btn float-right btn-primary
																		 @if(Auth::check())
																			askForButton 
																		 @else 
																			pixel-contact-to-register 
																		@endif 
																		@if($house->status==5) 
																			disabled @endif" 
																		data-value="{{$room->id}}" role="button" 
																		@if(!Auth::check()) 
																			data-toggle="modal" data-target="#Register" 
																		@endif 
																		onclick="contactButtonAB({{$room->house_id}}, 
																			{{$room->price}},
																			{{$room->id}},
																			{{$room->House->Neighborhood->Location->Zone->City->name}},
																			{{$room->House->Manager->first()->User->id}}
																			)">{{trans('houses/show.contact')}}</a>
																	</div>
																</div>
																		{{-- <div id="react-reservation" data-connection={{Lang::locale()}}></div> --}}
																		{{-- END INNER COL 4 BUTTON CONTACTAR --}}
																	</div>
																	{{-- END INNER ROW --}}

																	{{--MORE INFORMATION COLLAPSIBLE--}}
																	<div id="accordion-{{$room->id}}" role="tablist" aria-multiselectable="true">
																		{{--COLLAPSIBLE PANEL/TITEL--}}
																		<div class="panel panel-default">
																			<div class="panel-heading" role="tab" id="headingOne">
																				<p class="panel-title">
																					<a data-toggle="collapse" data-parent="#accordion-{{$room->id}}" href="#collapse{{$room->id}}" aria-expanded="true" aria-controls="collapseOne" class="h6 font-weight-light pixel-see-room-info">
																						{{trans('houses/show.more_info')}} <span class="icon-next-fom arrow-down"></span>
																					</a>
																				</p>
																			</div>
																			{{-- END COLLAPSIBLE PANEL --}}

																			{{--COLLAPSIBLE ITEM--}}
																			<div id="collapse{{$room->id}}" class="panel-collapse collapse in h6 font-weight-light" role="tabpanel" aria-labelledby="headingOne">
																				{{-- START ROW --}}
																				<div class="row justify-content-around">
																					{{--FIRST LIST COL-6 --}}
																					<div class="col-6">
																						<ul class="list-group bullet-points-off">
																							<li><p><span class="icon-z-window-1"></span>
																								@if($room->devices->windows_type === "sin_ventana")
																									{{trans('houses/show.without_window')}}
																								@else
																									<span class="auto-text-translate">{{trans('houses/show.window_to')}}
																										@if($room->devices->windows_type == 'adentro' || 'dentro')
																										{{trans('houses/show.inside')}}
																										@elseif($room->devices->windows_type == 'afuera') 
																										{{trans('houses/show.outside')}}
																										@elseif($room->devices->windows_type == 'el patio' || 'patio') 
																										{{trans('houses/show.patio')}}
																										@endif
																									</span>
																								@endif
																							</p></li>
																							<li><p><span class="icon-z--desk"></span>
																								@if($room->devices->desk === 1)
																									{{trans('houses/show.have_desktop')}}
																								@else
																									{{trans('houses/show.havent_desktop')}}
																								@endif
																							</p></li>
																							<li><p><span class="icon-closet"></span>
																								@if($room->devices->closet === 1)
																									{{trans('houses/show.have_closet')}}
																								@else
																									{{trans('houses/show.havent_closet')}}
																								@endif
																							</p></li>
																						</ul>
																					</div>
																					{{--SECOND LIST COL-6 --}}
																					<div class="col-6">
																						<ul class="list-group bullet-points-off">
																							<li><p><span class="icon-z-bathroom-2"></span>
																								@if(strpos($room->devices->bath_type, 'priv')!==false)
																									{{trans('houses/show.bathroom_private')}}
																								@else
																									{{trans('houses/show.bathroom_shared')}}
																								@endif
																							</p> </li>
																							<li><p><span class="icon-z-bed"></span>
																								@if ($room->devices->bed_type == 'doble')
																								{{trans('houses/show.double_bed')}}
																								@elseif ($room->devices->bed_type == 'semi-doble')
																								{{trans('houses/show.semi_double_bed')}}
																								@elseif ($room->devices->bed_type == 'sencilla')
																								{{trans('houses/show.simple_bed')}}
																								@endif
																							</p> </li>
																							@if($room->devices->tv === 1)
																								<li><p><span class="icon-tv"></span>
																									{{trans('houses/show.have_tv')}}
																								</p> </li>
																							@endif
																						</ul>
																					</div>
																					{{--END LISTS --}}
																				</div>
																				{{-- END ROW --}}
																				<p>{!! nl2br($room->description) !!}  @if($room->price_for_two==0) @else <br>{{trans('houses/show.can_live_two')}} {{ number_format($room->price_for_two,0,'','.') }} COP/{{trans('houses/show.month')}}.@endif</p>
																			</div>
																			{{--END COLLAPSIBLE ITEM--}}
																		</div>
																		{{--END COLLAPSIBLE PANEL --}}
																	</div>
																	{{--END MORE DESCRIPTION COLLAPSIBLE--}}
																</div>
																{{-- END COL 12 --}}
															</div>
															{{-- END ROW --}}
														</figcaption>
														@endif
														{{-- ENDIF FOR DUMMY ROOM --}}
														{{-- END FIGCAPTIO END DESCRIPTION  --}}
													</figure>
													{{-- END IMAGE ROOMS --}}

												</div>
												{{-- END ROOM COL 6 COL-SM-12  --}}
												 {{-- MODAL ROOMS START --}}
												<div class="modal fade room-{{ $room->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
													<div class="modal-dialog modal-lg">
														<div class="modal-content">
															 {{-- MODAL HEADER  --}}
															<div class="modal-header align-items-center">
																<p class="h4 modal-title text-center">{{trans('houses/show.room')}} #{{ $room->number }}</p>
																<button type="button" class="close" data-dismiss="modal"><span class="icon-close"></span></button>
															</div>
															 {{-- MODAL BODY  --}}
															<div class="modal-body">
																@foreach($room->main_image as $img)
																	<figure>
																		<img style="width: 100%;"src="https://fom.imgix.net/{{ $img->image }}?w=1280&h=853&fit=crop" class="img-responsive" alt="Responsive image">
																	</figure>
																@endforeach
															</div>
															 {{-- MODAL FOOTER  --}}
															<div class="modal-footer">
																<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
															</div>
														</div>
													</div>
												</div>
												 {{-- END MODAL ROOMS --}}
											@endforeach
											{{--END FOR EACH--}}
										</div>
										{{-- END ROW --}}
									</div>
									 {{-- END COL-12 --}}
								</div>
			{{-- ======== END ROOM SECTION ======== --}}

			<hr>

			{{-- ======== ROW EQUIPOS START ========  --}}
				<div class="row">
					 {{-- COL-8  --}}
					<div class="col-12">
						{{-- ROW --}}
						<p class="h4 mb-4 vico-color bold-words">{{trans('houses/show.devices')}}
						</p>
						{{-- END ROW --}}
						<div class="row">
							 {{-- COL  --}}
							<div class="col-12 text-center p-0">
								<ul class="pl-2">
									@foreach($devices as $device)
									<li class="d-inline-block vico-show-equipment-list m-md-3">
										<span class="{{ $device->icon }} show-equipos"></span>
										@if ($device->id_devices === 1) <br><p class="auto-text-translate">{{trans('houses/show.device_1')}}</p>
										@elseif ($device->id_devices === 2) <br><p class="auto-text-translate">{{trans('houses/show.device_2')}}</p>
										@elseif ($device->id_devices === 3) <br><p class="auto-text-translate">{{trans('houses/show.device_3')}}</p>
										@elseif ($device->id_devices === 4) <br><p class="auto-text-translate">{{trans('houses/show.device_4')}}</p>
										@elseif ($device->id_devices === 5) <br><p class="auto-text-translate">{{trans('houses/show.device_5')}}</p>
										@elseif ($device->id_devices === 6) <br><p class="auto-text-translate">{{trans('houses/show.device_6')}}</p>
										@elseif ($device->id_devices === 7) <br><p class="auto-text-translate">{{trans('houses/show.device_7')}}</p>
										@elseif ($device->id_devices === 8) <br><p class="auto-text-translate">{{trans('houses/show.device_8')}}</p>
										@elseif ($device->id_devices === 9) <br><p class="auto-text-translate">{{trans('houses/show.device_9')}}</p>
										@elseif ($device->id_devices === 10) <br><p class="auto-text-translate">{{trans('houses/show.device_10')}}</p>
										@elseif ($device->id_devices === 11) <br><p class="auto-text-translate">{{trans('houses/show.device_11')}}</p>
										@elseif ($device->id_devices === 12) <br><p class="auto-text-translate">{{trans('houses/show.device_12')}}</p>	
										@elseif ($device->id_devices === 13) <br><p class="auto-text-translate">{{trans('houses/show.device_13')}}</p>						
										@elseif ($device->id_devices === 14) <br><p class="auto-text-translate">{{trans('houses/show.device_14')}}</p>						
										@elseif ($device->id_devices === 15) <br><p class="auto-text-translate">{{trans('houses/show.device_15')}}</p>						
										@elseif ($device->id_devices === 16) <br><p class="auto-text-translate">{{trans('houses/show.device_16')}}</p>						
										@elseif ($device->id_devices === 17) <br><p class="auto-text-translate">{{trans('houses/show.device_17')}}</p>						
										@elseif ($device->id_devices === 18) <br><p class="auto-text-translate">{{trans('houses/show.device_18')}}</p>						
										@endif	
									</li>
									@endforeach
								</ul>
							</div>
							 {{-- END COL --}}
						</div>
						{{-- END ROW --}}
					</div>
					 {{-- END COL-8 --}}
				</div>
			{{-- ======== END ROW EQUIPOS ========  --}}

				<hr>

			{{-- ======== ROW RULES START ========  --}}
				<div class="row">
					<div class="col-12">
						<p class="h4 mb-4 vico-color bold-words">{{trans('houses/show.vico_rules')}}  
							 {{-- <div class="switch-translator">
								<div class="inputGroup">
								  <input class="switch-translate" id="option2" id-text="2" name="option2" type="checkbox"/>
								  <label class="small" for="option2">{{trans('houses/show.translate_to_language')}}</label>
								</div>
							</div>  --}}
						</p>
						<div class="row">

							@foreach ($rules as $rule)
							@if($loop->index>7)
									@break
							@endif
							<div class="col-12 col-lg-4 col-md-6 card vico-show-rule-card @if($rule->icon === 1) d-none @elseif($rule->icon === 2) order-2 @elseif($rule->icon === 3) order-4 @elseif($rule->icon === 4) order-5 @elseif($rule->icon === 5) order-5 @elseif($rule->icon === 6)order-1 @elseif($rule->icon === 7)order-7 @elseif($rule->icon === 8) order-3 @endif">
								<div class="row">
									<div class="col-3" style="text-align: right;">
										@if($rule->icon === 6)
											@if($rule->description==0)
												<img style="height: 64px; width: 64px" src="../images/rules/independent.png" alt="independent" srcset="../images/rules/independent@2x.png 2x, ../images/rules/independent@3x.png 3x" />
											@else
												<img style="height: 64px; width: 64px" src="../images/rules/family.png" alt="family" srcset="../images/rules/family@2x.png 2x, ../images/rules/family@3x.png 3x" />
											@endif
										 @else
											<img style="height: 64px; width: 64px" src="../images/rules/{{$rule->icon_span}}.png" alt="{{$rule->icon_span}}" srcset="../images/rules/{{$rule->icon_span}}@2x.png 2x, ../images/rules/{{$rule->icon_span}}@3x.png 3x" />
										@endif
									</div>
									<div class="col-9">
										<ul class="bullet-points-off align-middle ">
										<li class="text-uppercase font-weight-bold">
											{{-- PREAVISO  PARA RESERVAR  --}}
											@if($rule->icon === 1 )
												@if($rule->description == 0) {{trans('houses/show.n_a')}}
												@elseif($rule->description==14) 2 {{trans('houses/show.weeks')}}
												@elseif($rule->description==30) 1 {{trans('houses/show.month')}}
												@elseif($rule->description == 360) {{trans('houses/show.n_a')}}
												@else {{$rule->description}}
												@endif
												{{-- DEPOSITO --}}
											@elseif($rule->icon === 2)
												1 {{trans('houses/show.monthly_rent')}}
												{{-- TIEMPO MINIMO DE ESTANCIA  || TIEMPO PARA SALIR --}}
											@elseif($rule->icon === 3 || $rule->icon === 8 )
												@if($rule->description == 30) 1 {{trans('houses/show.month')}}
												@elseif($rule->description==14) 2 {{trans('houses/show.weeks')}}
												@elseif($rule->description == 60) 2 {{trans('houses/show.months')}}
												@elseif($rule->description == 90) 3 {{trans('houses/show.months')}}
												@elseif($rule->description == 120) 4 {{trans('houses/show.months')}}
												@elseif($rule->description == 150) 5 {{trans('houses/show.months')}}
												@elseif($rule->description == 180) 6 {{trans('houses/show.months')}}
												@elseif($rule->description == 210) 7 {{trans('houses/show.months')}}
												@elseif($rule->description == 240) 8 {{trans('houses/show.months')}}
												@elseif($rule->description == 270) 9 {{trans('houses/show.months')}}
												@elseif($rule->description == 300) 10 {{trans('houses/show.months')}}
												@elseif($rule->description == 330) 11 {{trans('houses/show.months')}}
												@elseif($rule->description == 360) 12 {{trans('houses/show.months')}}
												@else {{$rule->description}}
												@endif
												{{-- ASEO EN ZONA SOCIALES || ALIMENTACIÓN--}}
											@elseif($rule->icon === 4)
												@if($rule->description==0) {{trans('houses/show.not_include')}}
												@else {{trans('houses/show.include')}}
												@endif
													{{-- SERVICIOS INCLUIDOS --}}
											@elseif($rule->icon===5)
												@if($rules[8]->description == 1) {{trans('houses/show.internet')}},
												@endif
												@if($rules[9]->description == 1) {{trans('houses/show.Gas')}},
												@endif
												@if($rules[10]->description == 1) {{trans('houses/show.water')}},
												@endif
												@if($rules[11]->description == 1) {{trans('houses/show.light')}}
												@endif
												@if($rules[8]->description == 0 &&  $rules[9]->description == 0 && $rules[10]->description == 0 && $rules[11]->description == 0 ) {{trans('houses/show.not_include')}}
												@endif

												{{-- Independet / Family --}}
											@elseif($rule->icon === 6 )
												@if($rule->description==0) {{trans('houses/show.independient_vico')}}
												@else {{trans('houses/show.familiar_vico')}}
												@endif
												{{-- VALOR ADICIONAL POR HUESPED --}}
											@elseif($rule->icon===7)
												@if($rule->description == 0) {{trans('houses/show.free')}} @else {{$rule->description}} @endif
											@else
												{{$rule->description}}
											@endif
										</li>
										<li class="font-weight-light" style="word-wrap: break-word; line-height: 1.2">
											<small class="auto-text-translate" id-text="2">
											@if($rule->icon === 6 )
												@if($rule->description==0){{trans('houses/show.student_ambient')}}
												@else {{trans('houses/show.familiar_ambient')}}
												@endif
											@elseif ($rule->icon === 1) {{trans('houses/show.rule_icon_1')}}
											@elseif ($rule->icon === 2) {{trans('houses/show.rule_icon_2')}}
											@elseif ($rule->icon === 3) {{trans('houses/show.rule_icon_3')}}
											@elseif ($rule->icon === 4) {{trans('houses/show.rule_icon_4')}}
											@elseif ($rule->icon === 5) {{trans('houses/show.rule_icon_5')}}
											@elseif ($rule->icon === 6) {{trans('houses/show.rule_icon_6')}}
											@elseif ($rule->icon === 6) {{trans('houses/show.rule_icon_6')}}
											@elseif ($rule->icon === 7) {{trans('houses/show.rule_icon_7')}}
											@elseif ($rule->icon === 8) {{trans('houses/show.rule_icon_8')}}
											@elseif ($rule->icon === 9) {{trans('houses/show.rule_icon_9')}}
											@elseif ($rule->icon === 10) {{trans('houses/show.rule_icon_10')}}
											@elseif ($rule->icon === 11) {{trans('houses/show.rule_icon_11')}}
											@elseif ($rule->icon === 12) {{trans('houses/show.rule_icon_12')}}
											@elseif ($rule->icon === 13) {{trans('houses/show.rule_icon_99')}}
											@endif
											</small>
										</li>
									</ul>
								</div>
							</div>
						</div>
							@endforeach
								</div>
							</div>
                        </div>
                        @if(count($generic_interest_points) > 0 || count($specific_interest_points) > 0)
                            <div class="row">
                                <div class="col-12">
                                    <p class="h4 mb-4 bold-words vico-color">Puntos de interes cerca de la VICO  
                                        {{-- <div class="switch-translator">
                                        <div class="inputGroup">
                                            <input class="switch-translate" id="option2" id-text="2" name="option2" type="checkbox"/>
                                            <label class="small" for="option2">{{trans('houses/show.translate_to_language')}}</label>
                                        </div>
                                    </div>  --}}
                                </p>
                                    <div class="row">
                                            <p class="text-to-translate" id-text="0">
                                                @foreach ($generic_interest_points as $generic_interest_point)
                                                    - {{$generic_interest_point->name}} a {{$generic_interest_point->description}} minutos.<br>
                                                @endforeach
                                                @foreach ($specific_interest_points as $specific_interest_point)
                                                    - {{$specific_interest_point->name}} a {{$specific_interest_point->description}} minutos.<br>
                                                @endforeach
                                            </p>
                                            <p class="translated-text" id-text="0"></p>
                                    </div>
                                </div>
                            </div>
                        @endif
				{{-- END ROW RULES --}}
				{{-- CUSTOM RULES --}}
				<div class="row">
					<ul>
						@foreach ($custom_rules as $custom_rule)
							<li class="font-weight-bold">{{$custom_rule->description}}</li>
						@endforeach
					</ul>
				</div>
				{{-- END CUSTOM RULES --}}
				<!-- ======== ROW EXTRA RULES START ======== -->
                    @if($rules[12]->description === "0") @else
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <p class="h4 mb-4 vico-color bold-words">{{trans('houses/show.things_to_knows')}}
                                <div class="switch-translator">
                                    <div class="inputGroup">
                                            <input class="switch-translate" id="option3" id-text="3" name="option3" type="checkbox"/>
                                            <label class="small" for="option3">{{trans('houses/show.translate_to_language')}}</label>
                                    </div>
                                </div>
                            </p>
                            <p class="text-to-translate" id-text="3">{!! nl2br($rules[count($rules) - 1]->description) !!}</p>
                            <p class="translated-text" id-text="3"></p>
                        </div>
                    </div>
                    @endif
                {{-- END ROW EXTRA RULES --}}
				<hr>
				<p class="h4 mb-4 vico-color bold-words">VICOs Cercanas</p>
				<div class="suggested-houses">
					@forelse ($suggested_houses as $suggested_house)
					<div class="suggested-house">
						<a href="/houses/{{$suggested_house->id}}" target="_blank">
							<div class="suggested-house-info">
								<img class="image" src="{{'https://fom.imgix.net/'.$suggested_house->imageHouses->first()->image}}?w=450&h=300&fit=crop"/>
								<span class="name_price">
									{{$suggested_house->name}}
								</span>
							</div>
						</a>
						{{-- @if($suggested_house->isAvailable())
							<p>Disponible</p>
						@endif --}}
						<div class="d-flex mt-2 justify-content-between">
							<p>
								<img class="location-icon" src={{asset('images/map_icon.svg')}} /> 
								{{$suggested_house->neighborhood->name}} 
							</p>
							<a href="/houses/{{$suggested_house->id}}">Mas <i class="fas fa-chevron-right"></i></a>
						</div>
					</div>
					@empty
						<p class="text-muted">No hay VICOs cercanas</p>
					@endforelse
				</div>
				<hr>
                {{--Reviews--}}
                @if($reviewCount > 2)
                	@include('houses.review_show')
                @endif

				{{-- SPACE --}}
				<div class="d-lg-none p-2"></div>
				{{-- ======== MOBILE ADMIN CARD MOBILE START ======== --}}

				{{-- END ROW --}}
				{{-- ======== MOBILE ADMIN CARD MOBILE END ======== --}}
			
							<p class="h4 vico-color bold-words">{{trans('houses/show.vico_ubication')}}  </p>
						</div>
						{{-- ======== END CONTAINER FLUID  ======== --}}
		</div>
{{--======================= ANDRES: DIV PARA CERRAR COL ==============================--}}
				{{--</div>--}}
				{{----}}
					{{--CONTAINER FLUID END--}}
					<!-- ======== COL-9 END ======== -->
	{{-- ======== ADMIN CARD DESKTOP ======== --}}
		<div class="col d-none d-lg-block fix-bg">
			<div style="position: sticky; top:200px;">
				<div class="col-lg-12 vico-show-admin-card admin-card fixed-top">
					<div class="p-3"></div>
					 {{-- ROW  --}}
					<div class="row">
						<div class="col-12 text-center">
							<p class="bold-words h5">{{trans('houses/show.who_admin')}}</p>
						</div>
					</div>
					<div class="row">
						<div class="col-12 text-center">
							@if ($manager->image)
								<img class="img-responsive rounded-circle vico-show-admin-card-picture mb-2" src="https://fom.imgix.net/{{$manager->image}}?w=500&h=500&fit=crop" alt="Administrador">
							@elseif ($manager->gender == 1)
								<img class="img-responsive rounded-circle vico-show-admin-card-picture mb-2" src="https://fom.imgix.net/manager_7.png?w=500&h=500&fit=crop">
							@elseif ($manager->gender == 2)
								<img class="img-responsive rounded-circle vico-show-admin-card-picture mb-2" src="https://fom.imgix.net/manager_47.png?w=500&h=500&fit=crop">
							@else
								<img class="img-responsive rounded-circle vico-show-admin-card-picture mb-2" src="https://fom.imgix.net/user_image_1_2019_05_31_20_21_56.png?w=500&h=500&fit=crop">
							@endif
						</div>
						<div class="col-12 text-center">
							<p class="h5">{{$manager->name}}</p>
						</div>
					</div>
					<div class="row d-flex justify-content-center">

							<div class="col-12 text-center">
								{{--FUNCIONALIDAD DEL VER MÁS--}}
								<p class="d-inline viewLessReview">{{str_limit($manager->description, $limit = 45, $end='...')}}</p>
								<p class="d-none viewMoreReview" >{{$manager->description}}</p>
								<a href="" class="pl-2 d-inline viewMoreButton" >{{trans('houses/show.watch_more')}}</a>
							</div>
					</div>
					@if (Auth::check())
						@if (Auth::user()->id === $manager->id || Auth::user()->role_id === 1)
							<div class="col-12 text-center">
								<p class="h5">
									<a href="{{route('edit_show', ['house' => $house])}}" role="button" class="btn btn-outline-primary d-inline-block">{{__('Edit VICO')}}</a>
								</p>
							</div>
						@endif
					@endif
					<div class="row mb-2">
						<div class="col-sm-12 text-center">
							<a data-scroll class="btn btn-primary" href="#rooms-section" role="button">{{trans('houses/show.watch_rooms')}}</a>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 text-center">
							<a data-scroll class="btn btn-outline-primary" href="#map" role="button">{{trans('houses/show.watch_map')}}</a>
						</div>
					</div>
					<div class="p-3"></div>
				</div>
				 {{-- COL-12  --}}
				{{-- MODAL PROCESS BUTTON START --}}
				<div class="row pt-1">
					<div class="col-sm-12 text-center">
						<a data-toggle="modal" data-target=".process"><p><span class="icon-idea-orange"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span></span> {{trans('houses/show.how_works_process')}}</p></a>
					</div>
				</div>
				{{-- END MODAL PROCESS BUTTON --}}
			</div>
		</div>
	{{-- ======== END ADMIN CARD DESKTOP ========  --}}
	</div>
				{{-- ======== END MAIN ROW======== --}}
			</div>
			{{-- ======== END MAIN CONTAINER ======== --}}
			{{-- BUTTON TRIGGER MODAL  --}}
		</div>
	</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="" id="map"></div>
 {{-- ========= PROCESS MODAL ==========  --}}
<div class="modal fade process" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-centered" role="document">
		<div class="modal-content">
			<div class="modal-header align-items-center">
				<p class="modal-title h2 text-center" id="modalProcessTittle">{{trans('houses/show.reserve_process')}}</p>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><span class="icon-close"></span></span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					{{-- ROW-PROCESS  --}}
					<div class="row mb-4">
						 {{-- PROCESS ICON --}}
						<div class="col-3 text-center process-icon">
							<div class="process-circle">
								<span class="icon-message-orange" style="top: 10px; right: 3px; position: relative;"><span class="path1"></span><span class="path2"></span></span>
							</div>
						</div>
						 {{-- END PROCESS ICON --}}
						 {{-- PROCESS EXPLANATION --}}
						<div class="col-9 pr-0 pr-md-4">
							<ul class="bullet-points-off">
								<li><p class="h5 mb-0 mt-1">1. {{trans('houses/show.availability_request')}}</p>
								</li>
								<li><p class="font-weight-light">{{trans('houses/show.process_part_one')}}</p>
								</li>
							</ul>
						</div>
						 {{-- END PROCESS EXPLANATION --}}
					</div>
					{{-- END ROW-PROCESS  --}}
					{{-- ROW-PROCESS  --}}
					<div class="row mb-4">
						 {{-- PROCESS ICON --}}
						<div class="col-3 text-center process-icon">
							<div class="process-circle">
								<span class="icon-house-orange" style="line-height: 1.4 !important;"><span class="path1"></span><span class="path2"></span></span>
							</div>
						</div>
						 {{-- END PROCESS ICON --}}
						 {{-- PROCESS EXPLANATION --}}
						<div class="col-9 pr-0 pr-md-4">
							<ul class="bullet-points-off">
								<li><p class="h5 mb-0 mt-1">2. {{trans('houses/show.process_part_two')}}</p>
								</li>
								<li><p class="font-weight-light">{{trans('houses/show.process_part_three')}}</p>
								</li>
							</ul>
						</div>
						 {{-- END PROCESS EXPLANATION --}}
					</div>
					{{-- END ROW-PROCESS  --}}
					{{-- ROW-PROCESS  --}}
					<div class="row mb-4">
						 {{-- PROCESS ICON --}}
						<div class="col-3 text-center process-icon">
							<div class="process-circle">
								<span class="icon-deposit-orange" style="line-height: 1.4 !important;"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span><span class="path4"></span></span>
							</div>
						</div>
						 {{-- END PROCESS ICON --}}
						 {{-- PROCESS EXPLANATION --}}
						<div class="col-9 pr-0 pr-md-4">
							<ul class="bullet-points-off">
								<li><p class="h5 mb-0 mt-1">3. {{trans('houses/show.process_part_four')}}</p>
								</li>
								<li><p class="font-weight-light">{{trans('houses/show.process_part_five')}} </p>
								</li>
							</ul>
						</div>
						 {{-- END PROCESS EXPLANATION --}}
					</div>
					{{-- END ROW-PROCESS  --}}
					{{-- ROW-PROCESS  --}}
					<div class="row mb-4">
						 {{-- PROCESS ICON --}}
						<div class="col-3 text-center process-icon">
							<div class="process-circle">
								<span class="icon-ballon-orange"style="line-height: 1.4 !important;"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
							</div>
						</div>
						 {{-- END PROCESS ICON --}}
						 {{-- PROCESS EXPLANATION --}}
						<div class="col-9 pr-0 pr-md-4">
							<ul class="bullet-points-off">
								<li><p class="h5 mb-0 mt-1">{{trans('houses/show.live_with_friends')}}</p>
								</li>
								<li><p class="font-weight-light">{{trans('houses/show.find_friends_vico')}}</p>
								</li>
							</ul>
						</div>
						 {{-- END PROCESS EXPLANATION --}}
					</div>
					{{-- END ROW-PROCESS  --}}
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">{{trans('houses/show.back')}}</button>
			</div>
		</div>
	</div>
</div>
{{-- ========= MODAL PROCESS END  ========== --}}
 {{-- ========= MODAL ROOMS GALLERY START ==========  --}}
<div class="modal fade house-gallery" tabindex="-1" role="dialog" aria-labelledby="Images_House">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			 {{-- MODAL HEADER  --}}
			<div class="modal-header align-items-center">
				<p class="h4 modal-title">{{$house->name}}</p>
				<button type="button" class="close" data-dismiss="modal"><span class="icon-close"></span></button>
			</div>
			 {{-- MODAL BODY  --}}
			<div class="modal-body">
				@foreach($house->main_image as $img)
				<figure>
					<img style="width: 100%;"src="https://fom.imgix.net/{{ $img->image }}?w=1280&h=853&fit=crop" class="img-responsive" alt="Responsive image">
				</figure>
				@endforeach
			</div>
			 {{-- MODAL FOOTER  --}}
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
 {{-- ========= END MODAL ROOMS GALLERY ==========  --}}
 {{-- ========= MODAL ROOMS GALLERY START ==========  --}}
<div class="modal fade" style="overflow:scroll" tabindex="-1" role="dialog" aria-labelledby="Images_House">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			 {{-- MODAL HEADER  --}}
			<div class="modal-header align-items-center">
				<p class="h4 modal-title">{{$house->name}}</p>
				<button type="button" class="close" data-dismiss="modal"><span class="icon-close"></span></button>
			</div>
			 {{-- MODAL BODY  --}}
			<div class="modal-body">
				@foreach($house->main_image as $img)
				<figure>
					<img style="width: 100%;"src="https://fom.imgix.net/{{ $img->image }}?w=1280&h=853&fit=crop" class="img-responsive" alt="Responsive image">
				</figure>
				@endforeach
			</div>
			 {{-- MODAL FOOTER  --}}
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
 {{-- ========= END MODAL ROOMS GALLERY ==========  --}}
<div id="loader_modal" class="modal fade" style="overflow:scroll" role="dialog">
	<div class="modal-dialog">
		 {{-- MODAL CONTENT --}}
		<div class="modal-content">
			<div class="modal-header"></div>
			<div class="modal-body" style="padding-left:36%">
				<div class="loader"></div>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>
 {{-- =========== MODAL ASK FOR ROOM =============  --}}
<div id="ask_for_room">
</div>
<div id="react-reservation"></div>

<button type="button" class="btn btn-primary d-none" id="openModalAskFor" data-toggle="modal" data-target="#ask_for_modal"></button>

 {{-- ========= END MODAL ASK FOR ROOM ===========  --}}

 {{-- =================== MODAL HOMEMATES START =======================  --}}
<div class="modal fade" style="overflow:scroll" id="modal_homemates" tabindex="-1" role="dialog" aria-labelledby="modal_homemates">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      	<p class="h5">{{trans('houses/show.current_homemates')}}</p>
      	<button type="button" class="close" data-dismiss="modal"><span class="icon-close"></span></button>
      </div>
      <div class="modal-body">
      	<div class="row" style="margin:auto">
      		<div class="center col-12" style="display:inline-block;">
      			<p class="mb-4">
							{{trans('houses/show.homemates_who_lived')}}
					<select name="filter1_modal" id="" class="filter sources" placeholder="{{trans('houses/show.choose_month')}}">
	      				<option value="-6">{{trans('houses/show.on')}} {{ $months_name['-6'] }}</option>
	      				<option value="-5">{{trans('houses/show.on')}} {{ $months_name['-5'] }}</option>
	      				<option value="-4">{{trans('houses/show.on')}} {{ $months_name['-4'] }}</option>
	      				<option value="-3">{{trans('houses/show.on')}} {{ $months_name['-3'] }}</option>
	      				<option value="-2">{{trans('houses/show.on')}} {{ $months_name['-2'] }}</option>
	      				<option value="-1">{{trans('houses/show.on')}} {{ $months_name['-1'] }}</option>
	      			</select>
				</p>
      		</div>
      		<div class="center col-12" style="display:inline-block" >
      			<p class="mb-4">
							{{trans('houses/show.homemates')}}
      				<select name="filter2_modal" id="filter2_modal" class="filter sources" placeholder="{{trans('houses/show.choose_month')}}">
      					<option value="1">{{trans('houses/show.on')}} {{ $months_name['1'] }}</option>
      					<option value="2">{{trans('houses/show.on')}} {{ $months_name['2'] }}</option>
      					<option value="3">{{trans('houses/show.on')}} {{ $months_name['3'] }}</option>
      					<option value="4">{{trans('houses/show.on')}} {{ $months_name['4'] }}</option>
      					<option value="5">{{trans('houses/show.on')}} {{ $months_name['5'] }}</option>
      					<option value="6">{{trans('houses/show.on')}} {{ $months_name['6'] }}</option>
      					<option value="0" selected hidden>{{trans('houses/show.choose_month')}}</option>
      				</select>
      			</p>
      		</div>
      		{{--<button type="button" name="select_hider_modal" id="select_hider_modal" class="more-options">¿Quíen vivió aquí?</button>--}}
      	</div>
				<div class="row">
					<div class="col-12 form-inline d-flex justify-content-center" id="modal_homemates_body">

					</div>
				</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="closeHomematesModal()">{{trans('houses/show.close')}}</button>
      </div>
    </div>
  </div>
</div>
 {{-- =================== END MODAL HOMEMATES =======================  --}}
<!-- Reviews popover-->

@section('scripts')
@include('layouts.sections._intercom')
{{--section:scripts--}}
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4_XvxW91t7uHIL6tzmacsoIX17gHUIgM" defer></script>
<script src="{{ asset('js/angular.min.js') }}" charset="utf-8"></script>
<script src="{{ asset('js/prefixfree.min.js') }}" charset="utf-8"></script>
<script>
	// SEGMENT---------------------------------------
	function contactButtonAB(house_id, room_price, room_id, room_city, manager_id) {
		analytics.track('Button contact experiment',{
			category: 'Main stream',
			houseId: house_id,
			roomId: room_id,
			roomPrice: room_price,
			roomCity: room_city,
			managerId: manager_id
		});
	}
	function contactButton(house_id, room_price, room_id, room_city, manager_id) {
    analytics.track('Button contact/reserve',{
        category: 'Main stream',
        houseId: house_id,
        roomId: room_id,
        roomPrice: room_price,
        roomCity: room_city,
        managerId: manager_id
    });
}
	// SEGMENT----------------------------------------
</script>
<script>
	// (function(d, s, id) {
    // var js, fjs = d.getElementsByTagName(s)[0];
    // if (d.getElementById(id)) return;
    // js = d.createElement(s); js.id = id;
    // js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
    // fjs.parentNode.insertBefore(js, fjs);
  (document, 'script', 'facebook-jssdk'));
	$('.open_dates').each(function(){
		$(this).on('click',async function(){
			let value_room=$(this).attr('value_room');
			let response = await fetch('/roomDatesBooking/'+value_room);
			let dates = await response.text();
			$("#info_date_datepicker_"+value_room).datepicker({
				minDate: 0,
  				showButtonPanel: true,
				beforeShowDay: function(date){
					var string = $.datepicker.formatDate('yy-mm-dd', date);
					if(dates.indexOf(string) == -1){
						return [false, 'free_day'];
					}
					return [false, 'occuped_day'];
				}
			});
			$('#info_date_datepicker_'+value_room).datepicker('show');
			updateDatepicker();
			document.getElementById("ui-datepicker-div").addEventListener("DOMNodeInserted", updateDatepicker, true);
		});
	});
	function updateDatepicker(){
		$(".ui-datepicker-unselectable.ui-state-disabled.free_day").each(function(){
          $(this).children().css("background-color", "#f6f6f6");
          $(this).children().css("color", "#454545");
          $(this).removeClass('ui-state-disabled');
          $(this).popover({
            content:"Dia disponible para reservar",
            placement:"bottom",
          });
          $(this).on('mouseenter',function(){
                $(this).popover('show');
          });
          $(this).on('mouseleave',function(){
            $(this).popover('hide');
          });
		});
		$(".ui-datepicker-unselectable.ui-state-disabled.occuped_day").each(function(){
          $(this).children().css("background-color", "#fcfcfc");
          $(this).children().css("color", "#d4d4d48c");
          $(this).removeClass('ui-state-disabled');
          $(this).popover({
            content:"En esta fecha esta ocupado",
            placement:"bottom",
          });
          $(this).on('mouseenter',function(){
                $(this).popover('show');
          });
          $(this).on('mouseleave',function(){
            $(this).popover('hide');
          });
        });
	}
</script>
<script type="text/javascript">
	var map;
	let interestPoints;
	let schools;
	$(document).ready(function(){
		$('.navbar').addClass('fixed-top');
		ajax_houses();
	});
	function changeOther(value, id){
		var itemName = "otherDiv" + id;
		var item = document.getElementById(itemName);
		if(value == "{{trans('houses/show.an_other')}}"){
			item.style.display = "block";
		}
		else{
			item.style.display = "none";
		}
	}
	function ajax_houses() {
		houses_address = <?php print json_encode($housescoordinates) ?>;
		if (houses_address.original.length > 0) {
			myMap();
		}
	}
	function myMap() {
		var myCenter = new google.maps.LatLng(houses_address.original[0].lat, houses_address.original[0].lng);
		var mapCanvas = document.getElementById("map");
		var mapOptions = {center: myCenter, zoom: 15};
		var map = new google.maps.Map(mapCanvas, mapOptions);
		var bounds = new google.maps.LatLngBounds();
		interestPoints=<?php print json_encode($interestPoints) ?>;
		schools=<?php print json_encode($schools) ?>;
		for (let index = 0; index < houses_address.original.length; index++) {
			let latlng = {
				lat: Number(houses_address.original[index].lat),
				lng: Number(houses_address.original[index].lng)
			}
			var price_min_room = Number(houses_address.original[index].min_price).toLocaleString('de-DE');
			var contentString = `
			<div id="content">
				<a href="/houses/${houses_address.original[index].id}" target="_blank">
					<h4 id="firstHeading" class="firstHeading">${houses_address.original[index].name}</h3>
					<div id="bodyContent">
						<p>Precios desde: $  ${price_min_room} COP<br>
							<a target="_blank" href="/houses/${houses_address.original[index].id}">Click para ver más...</a>
						</p>
					</div>
				</a>
			</div>`
			let infowindow = new google.maps.InfoWindow({
				content: contentString
			})
			let iconBase = '/images/vico_marker.png'
			let marker = new google.maps.Marker({
				map: map,
				position: latlng,
				draggable: false,
				icon: iconBase
			})
			bounds.extend(marker.position);
			marker.addListener('click', function() {
				infowindow.open(map, marker)
			});
			var idcarousel=houses_address.original[index].id;
			try{
				document.getElementById("house-container"+idcarousel).addEventListener('mouseover',function(){
					infowindow.open(map, marker)
					//marker.setAnimation(google.maps.Animation.BOUNCE);
				});
				document.getElementById("house-container"+idcarousel).addEventListener('mouseout',function(){
					infowindow.close(map, marker)
					//marker.setAnimation(null)
				});
			}
			catch(err){
				//alert(server error)
			}
		}
		for(let i=0;i<interestPoints.length;i++){
			let iconBase='/images/vico_marker.png';
			switch(interestPoints[i].type_interest_point_id){
				case 1:
				iconBase='/images/point_of_interests/poi_metro.png';
				break;
				case 2:
				iconBase='/images/point_of_interests/poi_metro.png';
				break;
				case 3:
				iconBase='/images/point_of_interests/poi_bike.png';
				break;
			}
			let contentStringInterestPoint = `
				<div id="content">
					<h4 id="firstHeading" class="firstHeading">${interestPoints[i].name}</h3>
					<div id="bodyContent">
					</div>
				</div>`;
			let infowindowInterestPoint = new google.maps.InfoWindow({
				content: contentStringInterestPoint
			});
			latlng = {
				lat: +interestPoints[i].lat,
				lng:  +interestPoints[i].lng
			}
			let interestPointMarker=	new google.maps.Marker({
				map: map,
				position: latlng,
				draggable: false,
				icon: iconBase
			});
			bounds.extend(interestPointMarker.position);
			interestPointMarker.addListener('click', function() {
				infowindowInterestPoint.open(map, interestPointMarker)
			});
		}
		for(let i=0;i<schools.length;i++){
			let iconBase='/images/point_of_interests/poi_university.png';
			let contentStringSchool = `
				<div id="content">
					<h4 id="firstHeading" class="firstHeading">${schools[i].name}</h3>
					<div id="bodyContent">
					</div>
				</div>`;
			let infowindowSchool = new google.maps.InfoWindow({
				content: contentStringSchool
			});
			latlng = {
				lat: +schools[i].lat,
				lng:  +schools[i].lng
			}
			let schoolMaker=new google.maps.Marker({
				map: map,
				position: latlng,
				draggable: false,
				icon: iconBase
			});
			bounds.extend(schoolMaker.position);
			schoolMaker.addListener('click', function() {
				infowindowSchool.open(map, schoolMaker)
			});
		}
	}
	// -------------------------Cunstom select animation script--------------------------------
	$(".filter").each(function() {
		var classes = $(this).attr("class"),
		id      = $(this).attr("id"),
		name    = $(this).attr("name");
		var template =  '<div class="' + classes + '">';
		template += '<span class="filter-trigger" id="span_' + $(this).attr("name") + '">' + $(this).attr("placeholder") + '</span>';
		template += '<div class="custom-options">';
		$(this).find("option").each(function() {
			template += '<span class="custom-option ' + $(this).attr("class") + '" data-value="' + $(this).attr("value") + '" onclick="filterSelected(' + $(this).attr("value") + ')" id="span_option_' + name + '_'+$(this).attr("value")+'">' + $(this).html() + '</span>';
		});
		template += '</div></div>';
		$(this).wrap('<div class="filter-wrapper"></div>');
		$(this).hide();
		$(this).after(template);
	});
	$(".custom-option:first-of-type").hover(function() {
		$(this).parents(".custom-options").addClass("option-hover");
	}, function() {
		$(this).parents(".custom-options").removeClass("option-hover");
	});
	$(".filter-trigger").on("click", function() {
		$('html').one('click',function() {
			$(".filter").removeClass("opened");
		});
		$(this).parents(".filter").toggleClass("opened");
			event.stopPropagation();
	});
	$(".custom-option").on("click", function() {
		$(this).parents(".filter-wrapper").find("select").val($(this).data("value"));
		$(this).parents(".custom-options").find(".custom-option").removeClass("selection");
		$(this).addClass("selection");
		$(this).parents(".filter").removeClass("opened");
		$(this).parents(".filter").find(".filter-trigger").text($(this).text());
	});
	//-----------------------------------Cunstom select animation script end-----------------------------------------

	//---------------------------------Filter function------------------------------------------------
	function filterSelected(info){
		var filter1 = document.getElementById('filter1');
		var filter2 = document.getElementById('filter2');

		var filter1_modal = document.getElementById('filter1_modal');
		var filter2_modal = document.getElementById('filter2_modal');

		var modal_homemates_body = document.getElementById('modal_homemates_body');

		var id_spam="";

		if(parseInt(info)<0){
		document.getElementById('span_option_filter2_0').click();
		document.getElementById('span_option_filter2_modal_0').click();
		id_spam = "span_option_filter1_modal_" + info;
		document.getElementById(id_spam).click();
		if (info=='-6') {
			modal_homemates_body.innerHTML = "@forelse($month_homemates_correct[-6] as $homemate)"+
						"<div class='carousell-cell'>"+
							"@if($homemate->gender === 2)"+
							"<img style='height: 90px; width: 90px' src='../images/homemates/girl.png' alt='girl' srcset='../images/homemates/girl@2x.png 2x, ../images/homemates/girl@3x.png 3x' />"+
							"<small class='position-absolute'><img class='vico-show-habitant-flag' style='bottom: -5em; position: relative; left: -2em !important' src='../images/flags/{{$homemate->icon}}'></small>"+
							"@else"+
							"<img style='height: 90px; width: 90px' src='../images/homemates/boy.png' alt='boy' srcset='../images/homemates/boy@2x.png 2x, ../images/homemates/boy@3x.png 3x' />"+
							"<small class='position-absolute'><img class=' vico-show-habitant-flag' style='bottom: -5em; position: relative; left: -2em !important' src='../images/flags/{{$homemate->icon}}'></small>"+
						"@endif"+
							"<p class='h6 my-2 text-center' style='width: 90px'>{{$homemate->name}}</p>"+
						"</div>"+
			"@empty"+
					"<div class='row'>"+
						"<div class='col-12 d-flex justify-content-center'>"+
							"<span class='icon-no-user display-2' style='color: #3a3a3a'></span>"+
						"</div>"+
						"<div class='col-12 d-flex justify-content-center'>"+
							"<p>{{trans('houses/show.not_information')}}</p>"+
						"</div>"+
					"</div>"+
			"@endforelse";
		} else if (info == '-5') {
			modal_homemates_body.innerHTML = "@forelse($month_homemates_correct[-5] as $homemate)"+
						"<div class='carousell-cell'>"+
							"@if($homemate->gender === 2)"+
							"<img style='height: 90px; width: 90px' src='../images/homemates/girl.png' alt='girl' srcset='../images/homemates/girl@2x.png 2x, ../images/homemates/girl@3x.png 3x' />"+
							"<small class='position-absolute'><img class='vico-show-habitant-flag' style='bottom: -5em; position: relative; left: -2em !important' src='../images/flags/{{$homemate->icon}}'></small>"+
							"@else"+
							"<img style='height: 90px; width: 90px' src='../images/homemates/boy.png' alt='boy' srcset='../images/homemates/boy@2x.png 2x, ../images/homemates/boy@3x.png 3x' />"+
							"<small class='position-absolute'><img class=' vico-show-habitant-flag' style='bottom: -5em; position: relative; left: -2em !important' src='../images/flags/{{$homemate->icon}}'></small>"+
						"@endif"+
							"<p class='h6 my-2 text-center' style='width: 90px'>{{$homemate->name}}</p>"+
						"</div>"+
			"@empty"+
					"<div class='row'>"+
						"<div class='col-12 d-flex justify-content-center'>"+
							"<span class='icon-no-user display-2' style='color: #3a3a3a'></span>"+
						"</div>"+
						"<div class='col-12 d-flex justify-content-center'>"+
							"<p>{{trans('houses/show.not_information')}}</p>"+
						"</div>"+
					"</div>"+
			"@endforelse";
		}else if (info == '-4') {
			modal_homemates_body.innerHTML = "@forelse($month_homemates_correct[-4] as $homemate)"+
						"<div class='carousell-cell'>"+
							"@if($homemate->gender === 2)"+
							"<img style='height: 90px; width: 90px' src='../images/homemates/girl.png' alt='girl' srcset='../images/homemates/girl@2x.png 2x, ../images/homemates/girl@3x.png 3x' />"+
							"<small class='position-absolute'><img class='vico-show-habitant-flag' style='bottom: -5em; position: relative; left: -2em !important' src='../images/flags/{{$homemate->icon}}'></small>"+
							"@else"+
							"<img style='height: 90px; width: 90px' src='../images/homemates/boy.png' alt='boy' srcset='../images/homemates/boy@2x.png 2x, ../images/homemates/boy@3x.png 3x' />"+
							"<small class='position-absolute'><img class=' vico-show-habitant-flag' style='bottom: -5em; position: relative; left: -2em !important' src='../images/flags/{{$homemate->icon}}'></small>"+
						"@endif"+
							"<p class='h6 my-2 text-center' style='width: 90px'>{{$homemate->name}}</p>"+
						"</div>"+
			"@empty"+
					"<div class='row'>"+
						"<div class='col-12 d-flex justify-content-center'>"+
							"<span class='icon-no-user display-2' style='color: #3a3a3a'></span>"+
						"</div>"+
						"<div class='col-12 d-flex justify-content-center'>"+
							"<p>{{trans('houses/show.not_information')}}</p>"+
						"</div>"+
					"</div>"+
			"@endforelse";
		}else if (info == '-3') {
			modal_homemates_body.innerHTML = "@forelse($month_homemates_correct[-3] as $homemate)"+
						"<div class='carousell-cell'>"+
							"@if($homemate->gender === 2)"+
							"<img style='height: 90px; width: 90px' src='../images/homemates/girl.png' alt='girl' srcset='../images/homemates/girl@2x.png 2x, ../images/homemates/girl@3x.png 3x' />"+
							"<small class='position-absolute'><img class='vico-show-habitant-flag' style='bottom: -5em; position: relative; left: -2em !important' src='../images/flags/{{$homemate->icon}}'></small>"+
							"@else"+
							"<img style='height: 90px; width: 90px' src='../images/homemates/boy.png' alt='boy' srcset='../images/homemates/boy@2x.png 2x, ../images/homemates/boy@3x.png 3x' />"+
							"<small class='position-absolute'><img class=' vico-show-habitant-flag' style='bottom: -5em; position: relative; left: -2em !important' src='../images/flags/{{$homemate->icon}}'></small>"+
						"@endif"+
							"<p class='h6 my-2 text-center' style='width: 90px'>{{$homemate->name}}</p>"+
						"</div>"+
			"@empty"+
					"<div class='row'>"+
						"<div class='col-12 d-flex justify-content-center'>"+
							"<span class='icon-no-user display-2' style='color: #3a3a3a'></span>"+
						"</div>"+
						"<div class='col-12 d-flex justify-content-center'>"+
							"<p>{{trans('houses/show.not_information')}}</p>"+
						"</div>"+
					"</div>"+
			"@endforelse";
		}else if (info == '-2') {
			modal_homemates_body.innerHTML = "@forelse($month_homemates_correct[-2] as $homemate)"+
						"<div class='carousell-cell'>"+
							"@if($homemate->gender === 2)"+
							"<img style='height: 90px; width: 90px' src='../images/homemates/girl.png' alt='girl' srcset='../images/homemates/girl@2x.png 2x, ../images/homemates/girl@3x.png 3x' />"+
							"<small class='position-absolute'><img class='vico-show-habitant-flag' style='bottom: -5em; position: relative; left: -2em !important' src='../images/flags/{{$homemate->icon}}'></small>"+
							"@else"+
							"<img style='height: 90px; width: 90px' src='../images/homemates/boy.png' alt='boy' srcset='../images/homemates/boy@2x.png 2x, ../images/homemates/boy@3x.png 3x' />"+
							"<small class='position-absolute'><img class=' vico-show-habitant-flag' style='bottom: -5em; position: relative; left: -2em !important' src='../images/flags/{{$homemate->icon}}'></small>"+
						"@endif"+
							"<p class='h6 my-2 text-center' style='width: 90px'>{{$homemate->name}}</p>"+
						"</div>"+
			"@empty"+
					"<div class='row'>"+
						"<div class='col-12 d-flex justify-content-center'>"+
							"<span class='icon-no-user display-2' style='color: #3a3a3a'></span>"+
						"</div>"+
						"<div class='col-12 d-flex justify-content-center'>"+
							"<p>{{trans('houses/show.not_information')}}</p>"+
						"</div>"+
					"</div>"+
			"@endforelse";
		}else if (info == '-1') {
			modal_homemates_body.innerHTML = "@forelse($month_homemates_correct[-1] as $homemate)"+
						"<div class='carousell-cell'>"+
							"@if($homemate->gender === 2)"+
							"<img style='height: 90px; width: 90px' src='../images/homemates/girl.png' alt='girl' srcset='../images/homemates/girl@2x.png 2x, ../images/homemates/girl@3x.png 3x' />"+
							"<small class='position-absolute'><img class='vico-show-habitant-flag' style='bottom: -5em; position: relative; left: -2em !important' src='../images/flags/{{$homemate->icon}}'></small>"+
							"@else"+
							"<img style='height: 90px; width: 90px' src='../images/homemates/boy.png' alt='boy' srcset='../images/homemates/boy@2x.png 2x, ../images/homemates/boy@3x.png 3x' />"+
							"<small class='position-absolute'><img class=' vico-show-habitant-flag' style='bottom: -5em; position: relative; left: -2em !important' src='../images/flags/{{$homemate->icon}}'></small>"+
						"@endif"+
							"<p class='h6 my-2 text-center' style='width: 90px'>{{$homemate->name}}</p>"+
						"</div>"+
			"@empty"+
					"<div class='row'>"+
						"<div class='col-12 d-flex justify-content-center'>"+
							"<span class='icon-no-user display-2' style='color: #3a3a3a'></span>"+
						"</div>"+
						"<div class='col-12 d-flex justify-content-center'>"+
							"<p>{{trans('houses/show.not_information')}}</p>"+
						"</div>"+
					"</div>"+
			"@endforelse";
			}
		}

			else if(info>0){

			id_spam = "span_option_filter2_modal_" + info;
			document.getElementById(id_spam).click();

			if (info=='6') {
				modal_homemates_body.innerHTML = "@forelse($month_homemates_correct[6] as $homemate)"+
							"<div class='carousell-cell'>"+
								"@if($homemate->gender === 2)"+
								"<img style='height: 90px; width: 90px' src='../images/homemates/girl.png' alt='girl' srcset='../images/homemates/girl@2x.png 2x, ../images/homemates/girl@3x.png 3x' />"+
								"<small class='position-absolute'><img class='vico-show-habitant-flag' style='bottom: -5em; position: relative; left: -2em !important' src='../images/flags/{{$homemate->icon}}'></small>"+
								"@else"+
								"<img style='height: 90px; width: 90px' src='../images/homemates/boy.png' alt='boy' srcset='../images/homemates/boy@2x.png 2x, ../images/homemates/boy@3x.png 3x' />"+
								"<small class='position-absolute'><img class=' vico-show-habitant-flag' style='bottom: -5em; position: relative; left: -2em !important' src='../images/flags/{{$homemate->icon}}'></small>"+
							"@endif"+
								"<p class='h6 my-2 text-center' style='width: 90px'>{{$homemate->name}}</p>"+
							"</div>"+
				"@empty"+
						"<div class='row'>"+
							"<div class='col-12 d-flex justify-content-center'>"+
								"<span class='icon-no-user display-2' style='color: #3a3a3a'></span>"+
							"</div>"+
							"<div class='col-12 d-flex justify-content-center'>"+
								"<p>{{trans('houses/show.not_information')}}</p>"+
							"</div>"+
						"</div>"+
				"@endforelse";
			} else if (info == '5') {
				modal_homemates_body.innerHTML = "@forelse($month_homemates_correct[5] as $homemate)"+
							"<div class='carousell-cell'>"+
								"@if($homemate->gender === 2)"+
								"<img style='height: 90px; width: 90px' src='../images/homemates/girl.png' alt='girl' srcset='../images/homemates/girl@2x.png 2x, ../images/homemates/girl@3x.png 3x' />"+
								"<small class='position-absolute'><img class='vico-show-habitant-flag' style='bottom: -5em; position: relative; left: -2em !important' src='../images/flags/{{$homemate->icon}}'></small>"+
								"@else"+
								"<img style='height: 90px; width: 90px' src='../images/homemates/boy.png' alt='boy' srcset='../images/homemates/boy@2x.png 2x, ../images/homemates/boy@3x.png 3x' />"+
								"<small class='position-absolute'><img class=' vico-show-habitant-flag' style='bottom: -5em; position: relative; left: -2em !important' src='../images/flags/{{$homemate->icon}}'></small>"+
							"@endif"+
								"<p class='h6 my-2 text-center' style='width: 90px'>{{$homemate->name}}</p>"+
							"</div>"+
				"@empty"+
						"<div class='row'>"+
							"<div class='col-12 d-flex justify-content-center'>"+
								"<span class='icon-no-user display-2' style='color: #3a3a3a'></span>"+
							"</div>"+
							"<div class='col-12 d-flex justify-content-center'>"+
								"<p>{{trans('houses/show.not_information')}}</p>"+
							"</div>"+
						"</div>"+
				"@endforelse";
			}else if (info == '4') {
				modal_homemates_body.innerHTML = "@forelse($month_homemates_correct[4] as $homemate)"+
							"<div class='carousell-cell'>"+
								"@if($homemate->gender === 2)"+
								"<img style='height: 90px; width: 90px' src='../images/homemates/girl.png' alt='girl' srcset='../images/homemates/girl@2x.png 2x, ../images/homemates/girl@3x.png 3x' />"+
								"<small class='position-absolute'><img class='vico-show-habitant-flag' style='bottom: -5em; position: relative; left: -2em !important' src='../images/flags/{{$homemate->icon}}'></small>"+
								"@else"+
								"<img style='height: 90px; width: 90px' src='../images/homemates/boy.png' alt='boy' srcset='../images/homemates/boy@2x.png 2x, ../images/homemates/boy@3x.png 3x' />"+
								"<small class='position-absolute'><img class=' vico-show-habitant-flag' style='bottom: -5em; position: relative; left: -2em !important' src='../images/flags/{{$homemate->icon}}'></small>"+
							"@endif"+
								"<p class='h6 my-2 text-center' style='width: 90px'>{{$homemate->name}}</p>"+
							"</div>"+
				"@empty"+
						"<div class='row'>"+
							"<div class='col-12 d-flex justify-content-center'>"+
								"<span class='icon-no-user display-2' style='color: #3a3a3a'></span>"+
							"</div>"+
							"<div class='col-12 d-flex justify-content-center'>"+
								"<p>{{trans('houses/show.not_information')}}</p>"+
							"</div>"+
						"</div>"+
				"@endforelse";
			}else if (info == '3') {
				modal_homemates_body.innerHTML = "@forelse($month_homemates_correct[3] as $homemate)"+
							"<div class='carousell-cell'>"+
								"@if($homemate->gender === 2)"+
								"<img style='height: 90px; width: 90px' src='../images/homemates/girl.png' alt='girl' srcset='../images/homemates/girl@2x.png 2x, ../images/homemates/girl@3x.png 3x' />"+
								"<small class='position-absolute'><img class='vico-show-habitant-flag' style='bottom: -5em; position: relative; left: -2em !important' src='../images/flags/{{$homemate->icon}}'></small>"+
								"@else"+
								"<img style='height: 90px; width: 90px' src='../images/homemates/boy.png' alt='boy' srcset='../images/homemates/boy@2x.png 2x, ../images/homemates/boy@3x.png 3x' />"+
								"<small class='position-absolute'><img class=' vico-show-habitant-flag' style='bottom: -5em; position: relative; left: -2em !important' src='../images/flags/{{$homemate->icon}}'></small>"+
							"@endif"+
								"<p class='h6 my-2 text-center' style='width: 90px'>{{$homemate->name}}</p>"+
							"</div>"+
				"@empty"+
						"<div class='row'>"+
							"<div class='col-12 d-flex justify-content-center'>"+
								"<span class='icon-no-user display-2' style='color: #3a3a3a'></span>"+
							"</div>"+
							"<div class='col-12 d-flex justify-content-center'>"+
								"<p>{{trans('houses/show.not_information')}}</p>"+
							"</div>"+
						"</div>"+
				"@endforelse";
			}else if (info == '2') {
				modal_homemates_body.innerHTML = "@forelse($month_homemates_correct[2] as $homemate)"+
							"<div class='carousell-cell'>"+
								"@if($homemate->gender === 2)"+
								"<img style='height: 90px; width: 90px' src='../images/homemates/girl.png' alt='girl' srcset='../images/homemates/girl@2x.png 2x, ../images/homemates/girl@3x.png 3x' />"+
								"<small class='position-absolute'><img class='vico-show-habitant-flag' style='bottom: -5em; position: relative; left: -2em !important' src='../images/flags/{{$homemate->icon}}'></small>"+
								"@else"+
								"<img style='height: 90px; width: 90px' src='../images/homemates/boy.png' alt='boy' srcset='../images/homemates/boy@2x.png 2x, ../images/homemates/boy@3x.png 3x' />"+
								"<small class='position-absolute'><img class=' vico-show-habitant-flag' style='bottom: -5em; position: relative; left: -2em !important' src='../images/flags/{{$homemate->icon}}'></small>"+
							"@endif"+
								"<p class='h6 my-2 text-center' style='width: 90px'>{{$homemate->name}}</p>"+
							"</div>"+
				"@empty"+
						"<div class='row'>"+
							"<div class='col-12 d-flex justify-content-center'>"+
								"<span class='icon-no-user display-2' style='color: #3a3a3a'></span>"+
							"</div>"+
							"<div class='col-12 d-flex justify-content-center'>"+
								"<p>{{trans('houses/show.not_information')}}</p>"+
							"</div>"+
						"</div>"+
				"@endforelse";
			}else if (info == '1') {
				modal_homemates_body.innerHTML = "@forelse($month_homemates_correct[1] as $homemate)"+
							"<div class='carousell-cell'>"+
								"@if($homemate->gender === 2)"+
								"<img style='height: 90px; width: 90px' src='../images/homemates/girl.png' alt='girl' srcset='../images/homemates/girl@2x.png 2x, ../images/homemates/girl@3x.png 3x' />"+
								"<small class='position-absolute'><img class='vico-show-habitant-flag' style='bottom: -5em; position: relative; left: -2em !important' src='../images/flags/{{$homemate->icon}}'></small>"+
								"@else"+
								"<img style='height: 90px; width: 90px' src='../images/homemates/boy.png' alt='boy' srcset='../images/homemates/boy@2x.png 2x, ../images/homemates/boy@3x.png 3x' />"+
								"<small class='position-absolute'><img class=' vico-show-habitant-flag' style='bottom: -5em; position: relative; left: -2em !important' src='../images/flags/{{$homemate->icon}}'></small>"+
							"@endif"+
								"<p class='h6 my-2 text-center' style='width: 90px'>{{$homemate->name}}</p>"+
							"</div>"+
				"@empty"+
						"<div class='row'>"+
							"<div class='col-12 d-flex justify-content-center'>"+
								"<span class='icon-no-user display-2' style='color: #3a3a3a'></span>"+
							"</div>"+
							"<div class='col-12 d-flex justify-content-center'>"+
								"<p>{{trans('houses/show.not_information')}}</p>"+
							"</div>"+
						"</div>"+
				"@endforelse";
			}
		}
		$("#modal_homemates").addClass("showing");

		if($("#modal_homemates").hasClass("showing")){
			$("#modal_homemates").modal('show');
		}
		// ---------------------------------Filter function end------------------------------------------------

	}
	//----------------------------------Hide and show the filter1 button----------------------------------


	$(document).ready(function(){

	});

	$('#span_filter1').toggle();

	$(document).ready(function(){
		$('#select_hider').click(function() {
			$('#span_filter1').toggle(350);
		});
	});
	//--------------------------------end hider ------------------------------------------------------

</script>

<script type="text/javascript">
function closeHomematesModal() {
	$('#modal_homemates').removeClass('showing');
	$("#modal_homemates").modal('hide');
	modal_homemates_body.innerHTML = "";
	document.getElementById('span_option_filter2_0').click();
	document.getElementById('span_option_filter2_modal_0').click();
	document.getElementById('span_option_filter1_-0').click();
	// document.getElementById('span_option_filter1_modal_-0').click();
}
</script>
<script>
$('.info_dates').each(function(){
	$(this).popover({
	title:"{{trans('houses/show.availability')}}",
	trigger: "click" ,
  	placement: 'bottom',
  	html:true,
  	content: function() {return $("#"+$(this).attr('id')+'_popover').html();}
 	});
});

//Pixel Events for Rooms 
//Open register if not logged in when clicking on "contact"
$(".pixel-contact-to-register").each(function () {
    $(this).click(function () {
        // console.log('tst');
        fbq('trackCustom', 'RoomModalForRegister');
    });
});

//See room information
$(".pixel-see-room-info").each(function () {
    $(this).click(function () {
        // console.log('tst');
        fbq('trackCustom', 'RoomInformation');
    });
});

//See room availability
$(".pixel-see-room-availability").each(function () {
    $(this).click(function () {
        // console.log('tst');
        fbq('trackCustom', 'RoomAvailability');
    });
});

</script>
{{--view more/less functionallity--}}
<script type="text/javascript">

	//JQuery's way to stop the loading
	$('.viewMoreButton').click(function(event){
		event.stopPropagation();
		event.preventDefault();
	});
    $(function() {
        $("[data-toggle=popover]").popover();
    });


	$('.info_dates').each(function(){
		$(this).popover({
		title:"{{trans('houses/show.availability')}}",
		trigger: "click" ,
	  	placement: 'bottom',
	  	html:true,
	  	content: function() {return $("#"+$(this).attr('id')+'_popover').html();}
	 	});
	});
	/* View more code*/
	var viewMoreButtons = document.getElementsByClassName('viewMoreButton');
	for(let i = 0; i < viewMoreButtons.length; i++){
		viewMoreButtons[i].addEventListener("click", function(){
			let parent = this.parentNode;
			let childs = parent.childNodes;

			if(childs.length > 0){ //verify if there's info

				let viewMorelbl = childs[3];
				let viewLesslbl = childs[1];
				if(viewLesslbl.classList.contains('d-inline')){
					viewLesslbl.classList.remove('d-inline');
					viewLesslbl.classList.add('d-none');

					viewMorelbl.classList.remove('d-none');
					viewMorelbl.classList.add('d-inline');

					this.textContent = "Ver menos."

				}//end if
				else{
					viewLesslbl.classList.remove('d-none');
					viewLesslbl.classList.add('d-inline');

					viewMorelbl.classList.remove('d-inline');
					viewMorelbl.classList.add('d-none');

					this.textContent = "Ver más."
				}//end else
			}//end if
		} );
	}//end for
</script>
<script type="text/javascript">
@if (Auth::check())
$(document).ready(function(){
  $('.ajaxSubmitLike').click(function(e){
	var submit = e.target;
	house_id = {{ $house->id }};
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

	if (submit.className.indexOf("favorite-house-on-view") > -1) {
	  submit.className = "fas fa-heart ajaxSubmitLike btn-favorite-on-house-view";
	  $.ajax({
		url: '/houses/favorites/delete',
		type: 'DELETE',
		data: {
		  _token: CSRF_TOKEN,
		  user_id: {{ Auth::user()->id }},
		  house_id:	house_id},
		  success: function (data) {
					  if (data != 1) {
			  submit.className += " favorite-house-on-view";
					  }
		  }
		});
	}else {
	  submit.className += " favorite-house-on-view";
	  $.ajax({
		url: '/houses/favorites/post',
		type: 'POST',
		data: {
		  _token: CSRF_TOKEN,
		  user_id: {{Auth::user()->id}},
		  house_id:	house_id},
		  success: function (data) {
			if (data!=1) {
			  submit.className = "fas fa-heart ajaxSubmitLike btn-favorite-on-house-view";
			}
		  }
		});
	}
  });
});
@endif
  </script>
<script type="text/javascript">
	  function toggleHide(){
	  var hide
	  hide = document.getElementById('js-coupon-code-hide');
	  hide.classList.toggle("d-none");
	}
</script>
<script type="text/javascript">

	function validateCoupon(){
	  var input, filter, couponCodes, check, answer, feedback, user_id;
	  	user_id = {{ $user_id }};
	  	//get input
	    input = document.getElementById('js-validate-coupon');
	    //make case unsensentive
	    filter = input.value.toUpperCase();
	    //answer
	    feedback = document.getElementById("js-feedback-msg");
	    //check against these codes
	    //3/3 Here goes the column of the discount codes
	    couponCodes = @json($referralcodes);
	    //check against each code
	    for (var i = 0; i < couponCodes.length; i++) {

	      check = couponCodes[i].code.toUpperCase();
	      // If actual code is equal to filtered code and not from this user
	      if (check == filter && couponCodes[i].user_id != user_id) {
	        // set hidden input
	        answer = document.getElementById('js-coupon-code');
	        answer.value = couponCodes[i].id;

	        // Give visual feedback
	        feedback.innerHTML = '{{trans('houses/show.code_msg_success')}}';
	        feedback.classList.remove("invalid-feedback");
	        feedback.classList.add("valid-feedback");
	        input.classList.add("is-valid");
	        input.classList.remove("is-invalid");

	        //break loop
	        break;
	          }
	       else{
	    	input.classList.remove("is-valid");
	        input.classList.add("is-invalid");
	        feedback.classList.remove("valid-feedback");
	        feedback.classList.add("invalid-feedback");
	        feedback.innerHTML = "{{trans('houses/show.code_msg_invalid')}}";
	       }
	    }
	}

	function validateLength(){
	  var input, feedback;
	  feedback = document.getElementById("js-feedback-msg");
	  input = document.getElementById('js-validate-coupon');
	  // If input has less than 6 digits give feedback
	  if(input.value.length < 6){
	    input.classList.add("is-invalid");
	    feedback.innerHTML = ' The code has to have at least 6 digits.';
	    feedback.classList.add("invalid-feedback");

	  }
	  // when 6 digits enter into function to validate
	  else{
	    input.classList.remove("is-invalid");
	    validateCoupon();
	  }
	}

	</script>
</script>

@endsection
@endsection
