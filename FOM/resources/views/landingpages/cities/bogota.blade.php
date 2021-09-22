@extends('layouts.app')
<!-- SECTION: TITLE  -->
@section('title', 'Alojamiento para estudiantes en Bogotá')
<!--SECTION: META-->
@section('meta')
	<meta name="description" content="Buscas alojamiento o habitación en alquiler en Bogotá? Encuentra casas internacionales o apartamentos compartidos con estudiantes y jóvenes profesionales. ">
@endsection
<!-- SECTION: STYLES -->
@section('styles')
<style type="text/css">
	* {
		box-sizing: border-box;
	}

	html, body {
		margin: 0;
		padding: 0;
	}

	h1, h2, h3, h4, h5 {
		margin: 0;
	}

	#hero {
		background-image: url({{asset('images/landingpage/bogota/habitaciones_en_alquiler_bogota_vico_estudiantes.jpg')}});
		background-size: cover;
		background-position: center center;
		position: relative;
		min-height: 90vh;
		z-index: 900;
		flex-flow: row nowrap;
		justify-content: center;

	}	
	#mailchimp-form-col{
		z-index: 1050;
	}
	.hero-heading{
		align-items: center;
		color: white;
		text-shadow: #444 3px 3px 10px;
		letter-spacing: 0.04em;
	}
	h1 {
		/*margin-top: -8vh;*/
	}
	.sub-heading{
		font-family: nunitoregular;

	}
	.max-width-100{
		max-width: 100%;
	}
	.font-weight-regular{
		font-family: NunitoRegular !important;
		text-align: justify;
	}
	.form-control-round{
					border-radius: 25px;
	}
	.btn-primary-round{
		padding: 0 25px;
		max-height: 37px;
		min-height: 37px;
		line-height: 37px;
		border-radius: 25px;
	}
	.form-row{
		min-height: 100vh;
	}
		#hero:after {
			position: absolute;
			top: 0;
			bottom: 0;
			left: 0;
			right: 0;
			background: linear-gradient(45deg, #8e8e8e2b 0%, #3a3a3a 100%);
			opacity: 0.75;
			filter: brightness(1.2);
			content: '';
			z-index: -1;
		}
	}
	.landing-floating-button{
		z-index: 900 !important;
	}
</style>
@endsection
<!-- SECTION: CONTENT -->
@section('content')
	
	<!-- Hero Image -->
		<div class="p-4 d-flex align-content-center" id="hero">
			
		<!-- Row Heading -->
			<div class="row">

			<!-- Col Heading -->
				<div class="col-12 my-auto mx-2">

				<!-- Text Hero Image -->
					<h1 class="hero-heading mb-4">
						{{trans('main/bogota.look_for_room')}}
					</h1>
					<h2 class=" hero-heading sub-heading mb-4">
						{{trans('main/bogota.find_house')}}
					</h2>
				<!-- Text Hero Image -->

				</div>
			<!-- Col Heading -->


			<!-- Col Button -->
				<div class="col-12 text-center">
					<a href="#mailchimp-form" class="btn btn-primary">
						{{trans('main/bogota.lets_go')}}
					</a>
				</div>
			<!-- Col Button -->

			</div>
		<!-- Row Heading -->
			
		</div>
	<!-- Hero Image -->


	<!-- Container Content -->
		<div class="container">

			
		<!-- Row Summary City Row with video -->
			<div class="row">
				<div class="col-12 ">
					<a href="#mailchimp-form-col" class="mx-4 fixed-bottom btn btn-primary d-block d-md-none landing-floating-button" style="bottom: 1rem; z-index: 800!important">Contacto</a>
				</div>
				<!-- Summary COL -->
					<div class="col-12 col-lg-8 mx-auto my-4">
						<h2>
							{{trans('main/bogota.housing_in_rooms')}}
						</h2>
						<iframe class="my-4 d-md-block d-none mx-auto" width="560" height="315" src="https://www.youtube.com/embed/fsrpymfZTrs?autoplay=1&mute=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>						
						<iframe class="my-4 w-100 d-block d-md-none " width="560" height="315" src="https://www.youtube.com/embed/fsrpymfZTrs" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

						<p class="font-weight-regular">
							{{trans('main/bogota.it_the_capital')}}
							<br><br>
							{{trans('main/bogota.the_neighbourhoods')}}
							<br><br>
							{{trans('main/bogota.there_are_different')}}
						</p>
						<hr>
					<h2 class="my-4">
						{{trans('main/bogota.best_barrios')}}
					</h2>

					<h3 class="mt-4 mb-2">
						Chapinero 
					</h3>
					<p class="font-weight-regular">
						{{trans('main/bogota.chapinero')}}
						<br><br>
						{{trans('main/bogota.its_big_advantage')}}
						<br>
						<p class="text-center">
							<img alt="Chapinero, un barrio perfecto para alojamiento para estudiantes" class="w-50 shadow-sm my-2" src="https://thecitypaperbogota.com/wp-content/uploads/2016/03/Chapinero.jpg">
							<br><small>{{trans('main/bogota.photo')}}: <a href=" https://thecitypaperbogota.com/bogota/chapineros-second-renaissance/12333">City Paper Bogotá</a></small>
						</p>
						
						</p>
					<p class="font-weight-regular">
						{{trans('main/bogota.this_zone_is')}} 
						<br><br>
						{{trans('main/bogota.chapinero_is_found')}}
						<br><br>
						Estrato: 4-6.
					</p>



					<h3 class="my-3">
						La Zona Rosa (también Zona T) de Bogota
					</h3>
					<!-- Zona Rosa -->
					<span class="font-weight-regular">
						<p>
							{{trans('main/bogota.this_zone_is')}}
						</p>

						<p>
							{{trans('main/bogota.here_you_find')}}
						</p>

						<p>
							{{trans('main/bogota.if_you_search')}}
						</p>

						<p>
							Estrato: 5-6.
						</p>
						<iframe class="my-4 d-md-block d-none mx-auto" width="560" height="315" src="https://www.youtube.com/embed/dVQ4OBN1VCQ?autoplay=1&mute=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>						
						<iframe class="my-4 w-100 d-block d-md-none " width="560" height="315" src="https://www.youtube.com/embed/dVQ4OBN1VCQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

					</span>

					<h3 class="mt-4 mb-2">
						Chico
					</h3>
					<p class="font-weight-regular">
						{{trans('main/bogota.this_neighbourhood')}}
						{{trans('main/bogota.a_highlight')}}
					</p>
						<p class="text-center">
							<img alt="Chico uno de los barrios más populares entre estudiantes internacionales" class="w-50 shadow-sm my-2" src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7e/Bogot%C3%A1_barrio_Chic%C3%B3_carrera_8_entre_calles_93_y_94.JPG/1024px-Bogot%C3%A1_barrio_Chic%C3%B3_carrera_8_entre_calles_93_y_94.JPG">
							<br><small>{{trans('main/bogota.photo')}}: <a href="https://es.wikipedia.org/wiki/El_Chic%C3%B3">Wikipedia</a></small>
						</p>
					<p class="font-weight-regular">
						{{trans('main/bogota.note_on_chico')}}
						<br>
						Estrato: 5-6.
					</p>

					<h3 class="mt-4 mb-2">
						Barrio Usaquén
					</h3>
					<p class="font-weight-regular">
						{{trans('main/bogota.usaquen')}}
					</p>
						<br>
						<p class="text-center">
							<img alt="Iglesia de Usaquén, barrio donde hay habitaciones en alquiler para estudiantes" class="w-50 shadow-sm my-2" src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2e/Bogot%C3%A1_iglesia_de_Usaqu%C3%A9n.JPG/800px-Bogot%C3%A1_iglesia_de_Usaqu%C3%A9n.JPG">
							<br><small>Foto: <a href="https://es.wikipedia.org/wiki/Usaqu%C3%A9n">Wikipedia</a></small>
						</p>
					<p class="font-weight-regular">
						{{trans('main/bogota.parque_usaquen')}}
						<br><br>
						Estrato: 4-5.
					</p>

					<h2 class="my-4">
						{{trans('main/bogota.how_to_find')}}
					</h2>

					<h4>
						{{trans('main/bogota.one_you_have')}}
					</h4><br>

					<p class="font-weight-regular">
						{{trans('main/bogota.the_offer')}} <br>
						{{trans('main/bogota.if_you_like')}} <br>
						{{trans('main/bogota.when_you_know')}}
					</p>

					<h4>
						{{trans('main/bogota.housing_for_students')}}
					</h4><br>
					<p class="font-weight-regular">
						{{trans('main/bogota.do_you_like')}}
						<br>
						<br>
								<p class="text-center">
									<img class="w-50 my-2" class="max-width-100" src="{{ asset('images/landingpage/what-is-vico.png') }}" alt="What is a VICO? Shared flat for students">
								</p>
								<h4> {{trans('landing.vico_explanation')}}</h4>
								<p>
									VICO = {{trans('landing.shared_housing')}}
								</p>
					</p>
					<p class="font-weight-regular">
						{{trans('main/bogota.a_vico_is')}}
						<br><br>
						{{trans('main/bogota.go_to_search')}}
						<br> <br>
						{{trans('main/bogota.we_go_personal')}}
					</p>
					<h4>
						{{trans('main/bogota.ask_your_friends')}}
					</h4><br>
					<p class="font-weight-regular">
						{{trans('main/bogota.do_you_know_someone')}}
					</p>

					<h4>
						{{trans('main/bogota.facebook_groups')}}
					</h4><br>
					<p class="font-weight-regular">
						{{trans('main/bogota.ask_your_uni')}}
						<br><br>
						{{trans('main/bogota.take_your_time')}}
					</p>
				</div>
			<!-- Col Neighborhood Text -->
			<!-- Columna de mailchimp form -->
				<div class="col-12 col-lg-4 mx-auto" id="mailchimp-form-col">
					<!-- Begin Mailchimp Signup Form -->
					<div id="mc_embed_signup " class="sticky-top card px-4	mb-4 py-4 ml-2 shadow-sm" style="top: 15%">
					<form action="https://getvico.us20.list-manage.com/subscribe/post?u=1ea91b92eac6b98b2b4fdf27a&amp;id=e3eceba266" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
					    <div id="mc_embed_signup_scroll">
						<h3>{{trans('main/bogota.find_room')}}</h3>
						<p>{{trans('main/bogota.tell_us')}}</p>
					<div class="mc-field-group">
						<input type="email" placeholder="Email (required)" value="" name="EMAIL" class=" form-control form-control-round form-group required email" id="mce-EMAIL" required="">
					</div>
					<div class="mc-field-group">
						<input type="text" placeholder="Tu nombre" value="" name="FNAME" class="form-control form-control-round form-group" id="mce-FNAME">
					</div>
					<div class="mc-field-group">
						<input type="text" placeholder="Tu universidad" value="" name="MMERGE5" class="form-control form-control-round form-group" id="mce-MMERGE5">
					</div>
					<div class="mc-field-group">
						<input type="text" placeholder="Budget: 600-800.000 COP" value="" name="MMERGE6" class="form-control form-control-round form-group" id="mce-MMERGE6">
					</div>
						<div id="mce-responses" class="clear">
							<div class="response" id="mce-error-response" style="display:none"></div>
							<div class="response" id="mce-success-response" style="display:none"></div>
						</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
					    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_1ea91b92eac6b98b2b4fdf27a_e3eceba266" tabindex="-1" value=""></div>
					    <div class="clear"><input type="submit" value="Enviar" name="subscribe" id="mc-embedded-subscribe" class="btn btn-primary btn-primary-round"></div>
					    </div>
					</form>
					</div>

					<!--End mc_embed_signup-->
				</div>
			<!-- Columa de mailchimp form -->

			</div>
		<!-- Row Text about City -->

{{-- 		<!-- ROW VICO + MAILCHIMP FORM -->
			<div class="row form-row" id="mailchimp-form">

			<!-- Columna de mailchimp form -->
				<div class="col-12 col-lg-8 mx-auto my-auto">
					<!-- Begin Mailchimp Signup Form -->
					<div id="mc_embed_signup">
					<form action="https://getvico.us20.list-manage.com/subscribe/post?u=1ea91b92eac6b98b2b4fdf27a&amp;id=e3eceba266" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
					    <div id="mc_embed_signup_scroll">
						<h2>Cuéntanos dónde buscas y te mandamos más información.</h2>
						<p>Te ayudamos a encontrar una habitación cerca de tu universidad</p>
					<div class="mc-field-group">
						<input type="email" placeholder="Email Address" value="" name="EMAIL" class=" form-control form-control-round form-group required email" id="mce-EMAIL">
					</div>
					<div class="mc-field-group">
						<input type="text" placeholder="First Name" value="" name="FNAME" class="form-control form-control-round form-group" id="mce-FNAME">
					</div>
					<div class="mc-field-group">
						<input type="text" placeholder="Last Name" value="" name="LNAME" class="form-control form-control-round form-group" id="mce-LNAME">
					</div>
					<div class="mc-field-group">
						<input type="text" placeholder="Universidad" value="" name="MMERGE5" class="form-control form-control-round form-group" id="mce-MMERGE5">
					</div>
					<div class="mc-field-group">
						<input type="text" placeholder="Budget" value="" name="MMERGE6" class="form-control form-control-round form-group" id="mce-MMERGE6">
					</div>
						<div id="mce-responses" class="clear">
							<div class="response" id="mce-error-response" style="display:none"></div>
							<div class="response" id="mce-success-response" style="display:none"></div>
						</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
					    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_1ea91b92eac6b98b2b4fdf27a_e3eceba266" tabindex="-1" value=""></div>
					    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="btn btn-primary btn-primary-round"></div>
					    </div>
					</form>
					</div>

					<!--End mc_embed_signup-->
				</div>
			<!-- Columa de mailchimp form -->

			</div>
		<!-- Row VICO + MAILCHIMP FORM --> --}}



		</div>
	<!-- Container Content -->

@endsection
<!-- SECTION: SCRIPTS -->
@section('scripts')
<script>
	

	(function($) {
		fbq('trackCustom', 'Landingpage', {city: 'bogota'});
		$('#mc-embedded-subscribe').click(function() {
		  fbq('trackCustom', 'Landingpage', {city: 'bogota', action: 'subscribe'});
		});
	})(jQuery);
</script>	

@endsection




