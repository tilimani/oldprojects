@extends('layouts.app')
@section('title', 'Bienvenidos a VICO')

{{-- Meta Description --}}
@section('meta')
	<meta name="description" content="Buscas habitaciones o alojamiento para estudiantes en casas internacionales o apartamentos compartidos? Aquí encuentras un lugar seguro y con nuevos amigos.">
	<link rel="canonical" href="https://www.getvico.com" />
    <meta name="robots" content="index,follow" /> 
@endsection

@section('facebook_opengraph')
	<meta property="og:image" content="{{ asset('images/opengraph/facebook_opengraph_vicorooms.jpg') }}" />
	<meta property="og:image:alt" content="Viviendas compartidas para estancias medianas y largas." />
	<meta property="og:site_name" content="VICO"/>
	<meta property="og:description" content="Buscas habitaciones o alojamiento para estudiantes en casas internacionales o apartamentos compartidos? Encuentra un lugar seguro y con nuevos amigos."/>
	<meta property="og:url" content="https://www.getvico.com" />
@endsection

@section('styles')
	<style>
		/*html, body {
			width: 100%; 
			height: 100%; 
			margin: 0px; 
			padding: 0px; 
			overflow-x: hidden;
		}*/

		.vivcompat {
			font-size: 2.8em; 
		}

		@media (max-width: 400px) {
	        .vivcompat {
				font-size: 2.2em;
			}
	    }

		@media (max-width: 860px) {
	        .vivcompat {
				text-align: center !important;
			}
	    }    
	</style>
@endsection

@section('content')

{{-- RateVicoModal.js opens here in home controller --}}
@if($showNPSModal)
	<div id="react-rating" data-connection={{Lang::locale() .",". Auth::user()}}></div>
@endif
<body class="fairhaven-homepage">
	<!-- section 1 -->
	<section class="vico-section section-1">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="vico-flex-container">
						<div class="vico-flex-item">
							<img src="{{ asset('images/landingpage/logo-v.png') }}" alt="VICO landing logo">
							<h1 class="bold-words text-uppercase mb-1">
								VIVIR ENTRE AMIGOS
							</h1>
							<h1 class="" style="font-size: 1.3rem;">
								{{trans('landing.heading_1')}}
							</h1>
						</div>
					</div>
				</div>
			</div>
			<form class="form" id="fomSearch">
				@csrf
				<div class="row d-flex justify-content-center">
					<div class="col-lg-3 offset-lg-3 col-md-5 col-10 offset-1 col-sm-5 mx-auto mx-md-0 mb-2">
						<div class="input-group input-group-height w-100">
							<div class="select-container w-100">
								{{-- <select name="city_code" class="custom-select w-100" id="selected-city" required>
									<option label="{{trans('landing.select_city')}}"></option>
									<optgroup label="Colombia">
										<option value="MDE" {{Session::get('city_code') === 'MDE' ? 'selected':''}}>Medellín</option>
										<option value="BOG" {{Session::get('city_code') === 'BOG' ? 'selected':''}}>Bogotá</option>
									</optgroup>
									<optgroup label="Mexico">
										<option value="MEX" {{Session::get('city_code') === 'MEX' ? 'selected':''}}>Ciudad de México</option>
									</optgroup>
								</select> --}}
								<select name="city_code" class="custom-select w-100" id="selected-city" required>
									<option label="{{trans('landing.select_city')}}" disabled></option>
									@foreach ($countries as $country)
									<optgroup label={{$country->name}}>
										@foreach ($country->cities as $_city)																	
												<option value={{$_city->city_code}} {{Session::get('city_code') === $_city->city_code ? 'selected':''}}>{{$_city->name}}</option>											
										@endforeach									
									</optgroup>				
									@endforeach						
								</select>
							</div>
						</div>
						{{-- <div class="input-group input-group-height mb-2">
							<div class="input-group-append">
								<label class="input-group-text bg-white">
									<i class="icon-location"></i>
								</label>
							</div>
						</div>	 --}}
					</div>
					<div class="col-lg-3 offset-lg-3 col-md-5 col-10 offset-1 col-sm-5  mx-auto mx-md-0 d-none" >
						<div class="input-group input-group-height mb-2">
							<input class="form-control h-100" style="background-color: white" id="datepickersearch" name="date" placeholder="{{trans('houses/index.search_date')}}"
								autocomplete="off" readonly>
							<div class="input-group-append">
							<label data-input="datepickersearch" class="datepicker-button input-group-text bg-white">
								<i class="icon-z-date"></i>
							</label>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-5 col-sm-5 col-10 mx-auto mx-md-0">
						<div class="vico-flex-container">
							<div class="vico-flex-item">
								<button class="btn btn-primary" id="buscar" onclick="setUrl(); searchOnLandingPage();" type="submit">{{trans('houses/index.search')}}</button>            {{-- MAP TRIGGER --}}
							</div>
						</div>
					</div>
					{{-- <div class="col-lg-3 col-12">
						<div class="vico-flex-container">
							<div class="vico-flex-item">
								<div class="datepicker-wrapper">
									<input type="text" class="datepicker" placeholder="Desde...">
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-12">
						<div class="vico-flex-container">
							<div class="vico-flex-item">
								<div class="datepicker-wrapper">
									<input type="text" class="datepicker" placeholder="Hasta...">
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-12">
						<div class="vico-flex-container">
							<div class="vico-flex-item">
								<div class="keyword-wrapper">
									<input type="text" class="" placeholder="VICO...">
								</div>
							</div>
						</div>
					</div> --}}

				</div>
			</form>
			<div>
				<a class="mx-auto icon-next-fom arrow-down text-white add-bounce cursor-pointer" href="#section2" id="arrowLandingPage"></a>
			</div>
		</div>
	</section>
	<!-- section 1 -->

	<div id="react-landingpagecarousel-test"></div>
	<!-- section 2 -->
	<section class="vico-section section-2" id="section2">
		<div id="vico-particles"></div>
		<div class="container-fluid">
			<div class="row justify-content-center" style="margin: 15px;">
				<!-- First Row -->
				<div class="col-lg-4 col-7 text-center" style="padding-right: 0px;">
					<img style="width: 85%; " src="{{ asset('images/vico_logo_transition/VICO_VIVIR_orange@3x_without_text.png') }}" alt="VICO what is">
				</div>
				<div class="col-auto">
					<p class="text-left vivcompat bold-words" style="color: #ea960f; margin: 0;">VI<span style="color: #606060;">VIENDA</span></p> 
					<p class="text-left vivcompat bold-words" style="color: #ea960f;margin: 0;">CO<span style="color: #606060;">MPARTIDA</span></p> 
				</div>
			</div>
			
			<!-- Second Row -->
			<div class="row justify-content-center" style="margin-top: 25px;">
				<div class="independent col-md-4" style="margin: 15px;">
					<div>
						<img src="{{ asset('images/landingpage/icons/icon-independent.png') }}" alt="VICO independent">
						<h1 class="bold-words">{{trans('landing.independent')}}</h1>
					</div>
					<p>{{trans('landing.independent_roomies')}}</p>
				</div>
				<div class="family col-md-4" style="margin: 15px;">
					<div>
						<img src="{{ asset('images/landingpage/icons/icon-family.png') }}" alt="VICO family">
						<h1 class="bold-words">{{trans('landing.vico_family')}}</h1>
					</div>
					<p>{{trans('landing.familiar_ambient')}}</p>
				</div>
			</div>
		</div>
	</section>
	<!-- section 2 -->

	<!-- section 3 -->
	<section class="vico-section section-3">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="vico-flex-container">
						<div class="vico-flex-item">
						<h1 class="bold-words">{{trans('landing.why_search')}}</h1>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4 col-md-4 col-12">
					<div class="vico-flex-container">
						<div class="vico-flex-item">
							<img src="{{ asset('images/landingpage/icons/icon-safe.png') }}" alt="VICO safe">
							<h2 class="bold-words">{{trans('landing.puv_user_1')}}</h2>
							<p>
								{{trans('landing.puv_user_1_text')}}
							</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-12">
					<div class="vico-flex-container">
						<div class="vico-flex-item">
							<img src="{{ asset('images/landingpage/icons/icon-friend.png') }}" alt="VICO friend">
							<h2 class="bold-words">{{trans('landing.puv_user_2')}}</h2>
							<p>
								{{trans('landing.puv_user_2_text')}}
							</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-12">
					<div class="vico-flex-container">
						<div class="vico-flex-item">
							<img src="{{ asset('images/landingpage/icons/icon-flexibility.png') }}" alt="VICO flexibility">
							<h2 class="bold-words">{{trans('landing.puv_user_3')}}</h2>
							<p>
								{{trans('landing.puv_user_3_text')}}
							</p>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="vico-flex-container">
						<div class="vico-flex-item">
						<a id="pixel-search-secondary" class="btn btn-primary" href="{{route('houses.index',$city->name)}}">{{trans('landing.puv_user_search')}}
						</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- section 3 -->

	<!-- section 4 -->
		<section class="vico-section section-4">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<div class="vico-flex-container">
							<div class="vico-flex-item">
								{{-- <h1 class="bold-words">{{trans('landing.why_publish')}}</h1> --}}
								<h1 class="bold-words">{{trans('landing.manager_heading')}}</h1>
							</div>
						</div>
					</div>
					<div class="col-md-8 mx-auto col-12">
						<div class="vico-flex-container">
							<div class="vico-flex-item">
								<p class="">
									{{trans('landing.manager_subheading')}}
								</p>
							</div>
						</div>
					</div>
				</div>
{{-- 				<div class="row">
					<div class="col-lg-4 col-md-4 col-12">
						<div class="vico-flex-container">
							<div class="vico-flex-item">
								<img src="{{ asset('images/landingpage/icons/icon-risk.png') }}" alt="VICO risk">
								<h2 class="bold-words">{{trans('landing.puv_1')}}</h2>
								<p>
									{{trans('landing.puv_1_text')}}
								</p>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-12">
						<div class="vico-flex-container">
							<div class="vico-flex-item">
								<img src="{{ asset('images/landingpage/icons/icon-stay.png') }}" alt="VICO stay">
								<h2 class="bold-words">{{trans('landing.puv_2')}}</h2>
								<p>
									{{trans('landing.puv_2_text')}}
								</p>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-12">
						<div class="vico-flex-container">
							<div class="vico-flex-item">
								<img src="{{ asset('images/landingpage/icons/icon-earning.png') }}" alt="VICO earning">
								<h2 class="bold-words">{{trans('landing.puv_3')}}</h2>
								<p>
									{{trans('landing.puv_3_text')}}
								</p>
							</div>
						</div>
					</div>
				</div> --}}
				<div class="row">
					<div class="col-12">
						<div class="vico-flex-container">
							<div class="vico-flex-item">
								<a href="{{url('/addvico')}}" class="btn btn-primary">{{trans('landing.upload')}}</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- section 4 -->

	<!-- section 5 -->
	{{-- <section class="vico-section section-5">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="vico-flex-container">
						<div class="vico-flex-item vico-slider-title">
							<div>
								<img src="{{ asset('images/landingpage/icons/icon-independent.png') }}" alt="">
								<h4>
									Conoce nuestras <span class="orange">VICOS INDEPENDIENTES</span> en Medellín
								</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12"> --}}
                    {{-- <div class="carousel" data-flickity='{ "pageDots": false, "contain": true, "groupCells": true}'>
                        <div class="carousel-cell">
                            <div class="slide-content">
                                <div class="">
                                    <div>
                                        <img src="{{ asset('images/landingpage/slider-item-1.png') }}" alt="">
                                        <h6>VICO Laureles</h6>
                                    </div>
                                    <p>
                                        <span><i class="fa fa-map-marker"></i> Laureles</span>
                                        <span>Desde: $600.000</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-cell">
                            <div class="slide-content">
                                <div class="">
                                    <div>
                                        <img src="{{ asset('images/landingpage/slider-item-1.png') }}" alt="">
                                        <h6>VICO Laureles</h6>
                                    </div>
                                    <p>
                                        <span><i class="fa fa-map-marker"></i> Laureles</span>
                                        <span>Desde: $600.000</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-cell">
                            <div class="slide-content">
                                <div class="">
                                    <div>
                                        <img src="{{ asset('images/landingpage/slider-item-1.png') }}" alt="">
                                        <h6>VICO Laureles</h6>
                                    </div>
                                    <p>
                                        <span><i class="fa fa-map-marker"></i> Laureles</span>
                                        <span>Desde: $600.000</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-cell">
                            <div class="slide-content">
                                <div class="">
                                    <div>
                                        <img src="{{ asset('images/landingpage/slider-item-1.png') }}" alt="">
                                        <h6>VICO Laureles</h6>
                                    </div>
                                    <p>
                                        <span><i class="fa fa-map-marker"></i> Laureles</span>
                                        <span>Desde: $600.000</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-cell">
                            <div class="slide-content">
                                <div class="vico-slider-item">
                                    <div>
                                        <img src="{{ asset('images/landingpage/slider-item-1.png') }}" alt="">
                                        <h6>VICO Laureles</h6>
                                    </div>
                                    <p>
                                        <span><i class="fa fa-map-marker"></i> Laureles</span>
                                        <span>Desde: $600.000</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div> --}}
					{{-- <div class="vico-slider">
						<div class="slider-grid">
							<div class="slide-content">
								<div class="vico-slider-item">
									<div>
										<img src="{{ asset('images/landingpage/slider-item-1.png') }}" alt="">
										<h6>VICO Laureles</h6>
									</div>
									<p>
										<span><i class="fa fa-map-marker"></i> Laureles</span>
										<span>Desde: $600.000</span>
									</p>
								</div>
							</div>
						</div>
						<div class="slider-grid">
							<div class="slide-content">
								<div class="vico-slider-item">
									<div>
										<img src="{{ asset('images/landingpage/slider-item-1.png') }}" alt="">
										<h6>VICO Laureles</h6>
									</div>
									<p>
										<span><i class="fa fa-map-marker"></i> Laureles</span>
										<span>Desde: $600.000</span>
									</p>
								</div>
							</div>
						</div>
						<div class="slider-grid">
							<div class="slide-content">
								<div class="vico-slider-item">
									<div>
										<img src="{{ asset('images/landingpage/slider-item-1.png') }}" alt="">
										<h6>VICO Laureles</h6>
									</div>
									<p>
										<span><i class="fa fa-map-marker"></i> Laureles</span>
										<span>Desde: $600.000</span>
									</p>
								</div>
							</div>
						</div>
						<div class="slider-grid">
							<div class="slide-content">
								<div class="vico-slider-item">
									<div>
										<img src="{{ asset('images/landingpage/slider-item-1.png') }}" alt="">
										<h6>VICO Laureles</h6>
									</div>
									<p>
										<span><i class="fa fa-map-marker"></i> Laureles</span>
										<span>Desde: $600.000</span>
									</p>
								</div>
							</div>
						</div>
						<div class="slider-grid">
							<div class="slide-content">
								<div class="vico-slider-item">
									<div>
										<img src="{{ asset('images/landingpage/slider-item-1.png') }}" alt="">
										<h6>VICO Laureles</h6>
									</div>
									<p>
										<span><i class="fa fa-map-marker"></i> Laureles</span>
										<span>Desde: $600.000</span>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="vico-flex-container">
						<div class="vico-flex-item vico-slider-title">
							<div>
								<img src="{{ asset('images/landingpage/icons/icon-family.png') }}" alt="">
								<h4>
									Conoce nuestras <span class="orange">VICOS FAMILIARES</span> en Medellín
								</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="vico-slider">
						<div class="slider-grid">
							<div class="slide-content">
								<div class="vico-slider-item">
									<div>
										<img src="{{ asset('images/landingpage/slider-item-1.png') }}" alt="">
										<h6>VICO Laureles</h6>
									</div>
									<p>
										<span><i class="fa fa-map-marker"></i> Laureles</span>
										<span>Desde: $600.000</span>
									</p>
								</div>
							</div>
						</div>
						<div class="slider-grid">
							<div class="slide-content">
								<div class="vico-slider-item">
									<div>
										<img src="{{ asset('images/landingpage/slider-item-1.png') }}" alt="">
										<h6>VICO Laureles</h6>
									</div>
									<p>
										<span><i class="fa fa-map-marker"></i> Laureles</span>
										<span>Desde: $600.000</span>
									</p>
								</div>
							</div>
						</div>
						<div class="slider-grid">
							<div class="slide-content">
								<div class="vico-slider-item">
									<div>
										<img src="{{ asset('images/landingpage/slider-item-1.png') }}" alt="">
										<h6>VICO Laureles</h6>
									</div>
									<p>
										<span><i class="fa fa-map-marker"></i> Laureles</span>
										<span>Desde: $600.000</span>
									</p>
								</div>
							</div>
						</div>
						<div class="slider-grid">
							<div class="slide-content">
								<div class="vico-slider-item">
									<div>
										<img src="{{ asset('images/landingpage/slider-item-1.png') }}" alt="">
										<h6>VICO Laureles</h6>
									</div>
									<p>
										<span><i class="fa fa-map-marker"></i> Laureles</span>
										<span>Desde: $600.000</span>
									</p>
								</div>
							</div>
						</div>
						<div class="slider-grid">
							<div class="slide-content">
								<div class="vico-slider-item">
									<div>
										<img src="{{ asset('images/landingpage/slider-item-1.png') }}" alt="">
										<h6>VICO Laureles</h6>
									</div>
									<p>
										<span><i class="fa fa-map-marker"></i> Laureles</span>
										<span>Desde: $600.000</span>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> --}}
	<!-- section 5 -->

	<!-- section 6 -->
	<section class="vico-section section-6 d-none">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="vico-flex-container">
						<div class="vico-flex-item vico-slider-title">
							<div>
								<img src="{{ asset('images/landingpage/icons/icon-v-orange.png') }}" alt="">
								<h4>
									Nosotros <span class="orange">VICOS INDEPENDIENTES</span> en Medellín
								</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="vico-slider">
						<div class="slider-grid">
							<div class="slide-content">
								<div class="vico-slider-item orange">
									<div class="major">
										<div class="has-v-icon">
											<img src="{{ asset('images/landingpage/slider-item-2.png') }}" alt="">
										</div>
										<div>
											<h6>Samuel G.</h6>
											<p>
												Estudiante<br>
												Francés<br>
												23 AÑOS
											</p>
										</div>
									</div>
									<div class="desc">
										<p>
											Impresionante start up donde trabajan personas motivadas y serias, que sabrán responder a todas sus preguntas sobre su instalación en Medellín. Ideal para encontrar alojamiento en piso compartido

											Superbe start up où travaillent des personnes motivées et sérieuses, qui sauront répondre à toutes vos questions concernant votre installation à Medellín. Idéal pour trouver un logement en colocation
										</p>
									</div>
								</div>
							</div>
						</div>
						<div class="slider-grid">
							<div class="slide-content">
								<div class="vico-slider-item orange">
									<div class="major">
										<div class="has-v-icon">
											<img src="{{ asset('images/landingpage/testimonials/aranza_g.jpg') }}" alt="">
										</div>
										<div>
											<h6>Aranza</h6>
											<p>
												Estudiante<br>
												Mexico<br>
												25 AÑOS
											</p>
										</div>
									</div>
									<div class="desc">
										<p>
											Un gran proyecto para ayuda a extranjeros, comunicación constante, muy buena actitud y confianza antes lo que hacen. Éxito en este y más proyectos.
										</p>
									</div>
								</div>
							</div>
						</div>
						<div class="slider-grid">
							<div class="slide-content">
								<div class="vico-slider-item orange">
									<div class="major">
										<div class="has-v-icon">
											<img src="{{ asset('images/landingpage/testimonials/jonathan_b.jpeg') }}" alt="">
										</div>
										<div>
											<h6>Jonathan</h6>
											<p>
												Estudiante<br>
												Alemania<br>
												25 AÑOS
											</p>
										</div>
									</div>
									<div class="desc">
										<p>
											Friends of Medellin is a great project composed by a responsible and helpful team. 
											I was surprised by the detailed offers and the amount of apartments. They helped me with any type of problem and cleared any doubts during exchange. 
											Great work, great idea, great team and great time.

											Thank you very much!
										</p>
									</div>
								</div>
							</div>
						</div>
						<div class="slider-grid">
							<div class="slide-content">
								<div class="vico-slider-item orange">
									<div class="major">
										<div class="has-v-icon">
											<img src="{{ asset('images/landingpage/slider-item-2.png') }}" alt="">
										</div>
										<div>
											<h6>Mirja V.</h6>
											<p>
												Estudiante<br>
												Alemania<br>
												25 AÑOS
											</p>
										</div>
									</div>
									<div class="desc">
										<p>
											Medellín - definitiv immer eine Reise wert! Mit den Tipps von den Friends of Medellin wird eure Zeit hier auf jeden Fall unvergesslich! Tilman und Manu stehen Euch immer zur Seite, beantworten Eure Fragen & helfen immer gerne bei großen und kleinen Problemchen :) Auf gehts nach Medellín!
										</p>
									</div>
								</div>
							</div>
						</div>
						<div class="slider-grid">
							<div class="slide-content">
								<div class="vico-slider-item orange">
									<div class="major">
										<div class="has-v-icon">
											<img src="{{ asset('images/landingpage/slider-item-2.png') }}" alt="">
										</div>
										<div>
											<h6>Benjamin T.</h6>
											<p>
												Estudiante<br>
												Bolivia<br>
												25 AÑOS
											</p>
										</div>
									</div>
									<div class="desc">
										<p>
											Muy buena iniciativa! hace falta en Medellin una pagina ordenada y organizada para la búsqueda de VICOS para gente que llega desde el extranjero. Ya antes de la creación de FM ustedes me ayudaron a encontrar mi VICO, yo aun estando en Alemania y puedo decir que estoy satisfecho! Exito en todo y que la fuerza los acompañe.
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- section 6 -->

	<!-- section 7 -->
{{-- 	<section class="vico-section section-7">
		<div class="half-up">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<div class="vico-flex-container">
							<div class="vico-flex-item">
								<img src="{{ asset('images/vico_logo_transition/VICO_VIVIR_orange.png') }}" alt="VICO logo">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="half-down">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<div class="vico-flex-container">
							<div class="vico-flex-item">
								<div class="">
									<h2 class="text-uppercase">{{trans('landing.incubation')}}</h2>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="vico-flex-container">
							<div class="vico-flex-item">
								<ul>
									<li><img src="{{ asset('images/landingpage/com-01.png') }}" alt=""></li>
									<li><img src="{{ asset('images/landingpage/com-02.png') }}" alt=""></li>
									<li><img src="{{ asset('images/landingpage/com-03.png') }}" alt=""></li>
									<li><img src="{{ asset('images/landingpage/com-04.png') }}" alt=""></li>
									<li><img src="{{ asset('images/landingpage/com-05.png') }}" alt=""></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> --}}
	<!-- section 7 -->

	<!-- section 8 -->
	{{-- <section class="vico-section section-8">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="vico-flex-container">
						<div class="vico-flex-item vico-slider-title">
							<div>
								<img src="{{ asset('images/landingpage/icons/icon-independent.png') }}" alt="">
								<h4>
									Conoce nuestras <span class="orange">VICOS INDEPENDIENTES</span> en Medellín
								</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="vico-slider">
						<div class="slider-grid">
							<div class="slide-content">
								<div class="vico-slider-item">
									<div>
										<img src="{{ asset('images/landingpage/slider-item-4.png') }}" alt="">
										<div class="filter">
											<h6>VICO UPB</h6>
											<p>Desde: $600.000</p>
										</div>
									</div>
									<p>
										<span><i class="fa fa-calendar"></i> Disponible ahora</span>
										<span><i class="fa fa-map-marker"></i> Laureles</span>
									</p>
								</div>
							</div>
						</div>
						<div class="slider-grid">
							<div class="slide-content">
								<div class="vico-slider-item">
									<div>
										<img src="{{ asset('images/landingpage/slider-item-4.png') }}" alt="">
										<div class="filter">
											<h6>VICO UPB</h6>
											<p>Desde: $600.000</p>
										</div>
									</div>
									<p>
										<span><i class="fa fa-calendar"></i> Disponible ahora</span>
										<span><i class="fa fa-map-marker"></i> Laureles</span>
									</p>
								</div>
							</div>
						</div>
						<div class="slider-grid">
							<div class="slide-content">
								<div class="vico-slider-item">
									<div>
										<img src="{{ asset('images/landingpage/slider-item-4.png') }}" alt="">
										<div class="filter">
											<h6>VICO UPB</h6>
											<p>Desde: $600.000</p>
										</div>
									</div>
									<p>
										<span><i class="fa fa-calendar"></i> Disponible ahora</span>
										<span><i class="fa fa-map-marker"></i> Laureles</span>
									</p>
								</div>
							</div>
						</div>
						<div class="slider-grid">
							<div class="slide-content">
								<div class="vico-slider-item">
									<div>
										<img src="{{ asset('images/landingpage/slider-item-4.png') }}" alt="">
										<div class="filter">
											<h6>VICO UPB</h6>
											<p>Desde: $600.000</p>
										</div>
									</div>
									<p>
										<span><i class="fa fa-calendar"></i> Disponible ahora</span>
										<span><i class="fa fa-map-marker"></i> Laureles</span>
									</p>
								</div>
							</div>
						</div>
						<div class="slider-grid">
							<div class="slide-content">
								<div class="vico-slider-item">
									<div>
										<img src="{{ asset('images/landingpage/slider-item-4.png') }}" alt="">
										<div class="filter">
											<h6>VICO UPB</h6>
											<p>Desde: $600.000</p>
										</div>
									</div>
									<p>
										<span><i class="fa fa-calendar"></i> Disponible ahora</span>
										<span><i class="fa fa-map-marker"></i> Laureles</span>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="vico-flex-container">
						<div class="vico-flex-item vico-slider-title">
							<div>
								<img src="{{ asset('images/landingpage/icons/icon-family.png') }}" alt="">
								<h4>
									Conoce nuestras <span class="orange">VICOS INDEPENDIENTES</span> en Medellín
								</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="vico-slider">
						<div class="slider-grid">
							<div class="slide-content">
								<div class="vico-slider-item">
									<div>
										<img src="{{ asset('images/landingpage/slider-item-4.png') }}" alt="">
										<div class="filter">
											<h6>VICO UPB</h6>
											<p>Desde: $600.000</p>
										</div>
									</div>
									<p>
										<span><i class="fa fa-calendar"></i> Disponible ahora</span>
										<span><i class="fa fa-map-marker"></i> Laureles</span>
									</p>
								</div>
							</div>
						</div>
						<div class="slider-grid">
							<div class="slide-content">
								<div class="vico-slider-item">
									<div>
										<img src="{{ asset('images/landingpage/slider-item-4.png') }}" alt="">
										<div class="filter">
											<h6>VICO UPB</h6>
											<p>Desde: $600.000</p>
										</div>
									</div>
									<p>
										<span><i class="fa fa-calendar"></i> Disponible ahora</span>
										<span><i class="fa fa-map-marker"></i> Laureles</span>
									</p>
								</div>
							</div>
						</div>
						<div class="slider-grid">
							<div class="slide-content">
								<div class="vico-slider-item">
									<div>
										<img src="{{ asset('images/landingpage/slider-item-4.png') }}" alt="">
										<div class="filter">
											<h6>VICO UPB</h6>
											<p>Desde: $600.000</p>
										</div>
									</div>
									<p>
										<span><i class="fa fa-calendar"></i> Disponible ahora</span>
										<span><i class="fa fa-map-marker"></i> Laureles</span>
									</p>
								</div>
							</div>
						</div>
						<div class="slider-grid">
							<div class="slide-content">
								<div class="vico-slider-item">
									<div>
										<img src="{{ asset('images/landingpage/slider-item-4.png') }}" alt="">
										<div class="filter">
											<h6>VICO UPB</h6>
											<p>Desde: $600.000</p>
										</div>
									</div>
									<p>
										<span><i class="fa fa-calendar"></i> Disponible ahora</span>
										<span><i class="fa fa-map-marker"></i> Laureles</span>
									</p>
								</div>
							</div>
						</div>
						<div class="slider-grid">
							<div class="slide-content">
								<div class="vico-slider-item">
									<div>
										<img src="{{ asset('images/landingpage/slider-item-4.png') }}" alt="">
										<div class="filter">
											<h6>VICO UPB</h6>
											<p>Desde: $600.000</p>
										</div>
									</div>
									<p>
										<span><i class="fa fa-calendar"></i> Disponible ahora</span>
										<span><i class="fa fa-map-marker"></i> Laureles</span>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> --}}
	<!-- section 8 -->

	<!-- section 9 -->
	<section class="vico-section section-9">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="vico-flex-container">
						<div class="vico-flex-item">
							<img src="{{ asset('images/landingpage/logo-v.png') }}" alt="">
							<h1>{{trans('landing.waiting')}}</h1>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="vico-flex-container">
						<div class="vico-flex-item">
							<ul>
							<li><a id="pixel-search-last" href="{{route('houses.index',$city->name)}}" class="btn btn-primary search-vico">{{trans('landing.puv_user_search')}}</a></li>
							<li><a href="{{route('publish_intro')}}" class="btn btn-secondary">{{trans('landing.upload')}}</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- section 9 -->
	@section('scripts')
	<script>
	function searchOnLandingPage() {
		analytics.track('Search on landing page',{
        	category: 'Search'
    	});
	}
	</script>
	<script>
	(function($) {
		$.fn.goTo = function() {
			$('html, body').animate({
				scrollTop: $(this).offset().top + 'px'
			}, 'fast');
			return this;
		}
	})(jQuery);

	$("#arrowLandingPage").click( function(event) {
    	var target = $(this.getAttribute('href'));
		if( target.length ) {
			event.preventDefault();
			$('html, body').stop().animate({
				scrollTop: target.offset().top
			}, 1000);
		}
	});
	
	window.onload = ()=> {
		$('.vico-section.section-1').goTo();
		//PIXEL TRIGGERS
		// Primary Search
		$('#buscar').click(function() {
		  fbq('track', 'Search',  {search_string: "primary"});
		});

		// PUV Search
		$('#pixel-search-secondary').click(function() {
		  fbq('track', 'Search', {search_string: "puv_secondary"});
		});

		// Last Search
		$('#pixel-search-last').click(function() {
		  fbq('track', 'Search', {search_string: "last"});
		});

	}
	function setUrl() {
		let city = "",
		 	form = document.querySelector('#fomSearch'),
			selectedCity = document.querySelector('#selected-city');
		
		city = selectedCity.options[selectedCity.selectedIndex].text;
		form.action = "/vicos/"+city.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, "");
	}	
	
	</script>
	@include('layouts.sections._intercom')
	
	@endsection
</body>
@endsection
