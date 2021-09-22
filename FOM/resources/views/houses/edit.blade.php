@extends('layouts.app')
@section('title', 'edit '.$house->name )
@section('content')
	@if (Auth::user() && Auth::user()->email === 'friendsofmedellin@gmail.com' || true)

		<style type="text/css">
		.entrada-texto{
			border-style: none;
		}

		@media (min-width: 1200px){
			.container{
				margin-right: 135px
				margin-left:135px;
				padding-left: 15px;
				padding-right: 15px;
				width: 1170px;

			}
		}
		.house-img{
			width: 100%;
		}
		.house-desc{
			font-size:18px;
			font-weight: 300;
			line-height: 1.618;
			color: #999999;
		}
		.carousel-control span{
			color: grey !important;
		}
		.house-rules a{
			color: #ea960f;
		}
		.img-room{
			min-width: 100%;
		}
		.room-disponibility{
			position: absolute;
			float: left;
			bottom: 1.9rem;
			margin-left: 2rem;
		}

		/*nuevos estilos*/
		.vico-edit-figure-caption{
			background-color: rgba(234, 150, 15, .6);
			color: #fff;
			padding: .4rem 1.4rem;
			border-radius: 1rem;
			border-top-left-radius: 0;
			border-top-right-radius: 0;
			position: relative;
			height: 4.5rem;
			width: 100%;
			margin-top: -4.5rem;
		}

		.vico-edit-gallery-button{
			z-index: 1000;
			margin-top: -4.5rem;
			color: white;
		}


		.image-rounded-width{
			border-radius: 1rem;
			width: 100%
		}

	</style>
	<div class="container">				
		<form method="POST" action="/houses/update" accept-charset="UTF-8" enctype="multipart/form-data">
			{{ csrf_field() }}
			<input type="number" name="house_id" class="d-none" value="{{$house->id}}">

			<div class="row">
				<div class="col">
					<figure>
						<input type="hidden" name="current_image" value="{{ $images[0]->image }}">

						<img src="http://fom.imgix.net/{{ $images[0]->image }}" class="img-responsive image-rounded-width " alt="Responsive image">

						<figcaption class="vico-edit-figure-caption">
							<div class="form-group">
								<input type="text" class="form-control" name="name" placeholder="Nombre Vico" required value="{{ $house->name }}" style="width: 30%">
								<label for="name">Nombre VICO</label>

							</div>
							<a href="#" class="vico-gallery-button vico-edit-gallery-button float-right" data-toggle="modal" data-target=".bs-example-modal-lg">Ver galería <span class="icon-gallery"></span></a>
						</figcaption>
					</figure>
				</div>
			</div>
			 {{-- ROW  --}}
			<div class="row">
				 {{-- COL  --}}
				<div class="col-12 vico-inside-info">
					<h3>Descripción de la VICO <span> - Vivienda compartida</span></h3>
					<div class="row">
						<div class="col-6">
							<div class="row">
								<span class="icon-z-bed"></span><p>{{$house->rooms_quantity }} hab, {{$availableCount}} @if($availableCount!=1) disponibles @else disponible @endif</p>
								</div>
								<div class="row">
									<span class="icon-z-date"></span><p>Disponibilidad: {{date('d/m/y', strtotime($house->Rooms->min('available_from')))}}</p>
								</div>
								<div class="row">
									<input type="file" name="main_image[]" >
									<label for="main_image">Foto principal</label>
								</div>
							</div>
							<div class="col-6">
								<div class="row">
									<div class="form-group col-3" style="width: 40%;">
										<input type="number" class="form-control" name="baths_quantity" placeholder="# Baños" maxlength="2" value="{{ $house->baths_quantity }}" required>
										<label for="baths"># de baños</label>
									</div>
									<div class="form-group col-3" style="width: 60%">
										<input id="address" type="text" class="form-control" name="address" placeholder="Dirección" value="{{ $house->address }}" required >
										<label for="baths">Dirección</label>
									</div>
								</div>
							</div>

							<div class="col-12">
								<div class="row">
									<div class="form-group col-3" style="width: 50%;">
										<select class="form-control" name="type" required>
											<option>-- seleccione --</option>
											@if($house->type === 'Casa')
												<option value="Casa" selected>Casa</option>
												<option value="Apartamento">Apartamento</option>
											@else
												<option value="Casa" >Casa</option>
												<option value="Apartamento" selected>Apartamento</option>
											@endif
										</select>
										<label>Tipo de vivienda</label>
									</div>
									<div class="form/form-group col-3" style="width: 50%;">
										<input type="number" name="rooms_quantity" class="form-control" placeholder="# Habitaciones" value="{{$house->rooms_quantity}}" required>
										<label for="rooms_quantity"># de habitaciones</label>
									</div>
									<div class="">
										<a href="#" data-toggle="modal" data-target="#modal-changes">&#x270E; ¿Quieres cambiar estos datos? Solicita el cambio.</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					 {{-- END COL  --}}
					<div class="row"> - <div class="col-12 text-center ver-habitaciones"><a data-scroll class="btn btn-primary" href="#rooms-section" role="button">Ir a las habitaciones <span class="icon-next-fom rooms-arrow"></span></a></div></div>
				</div>
				 {{-- ROW END  --}}

				 {{-- ROW  --}}
				<div class="row">
					 {{-- COL  --}}
					<div class="col-12">
						<h3>Acerca de esta VICO<span> - Vivienda compartida</span></h3>
						<div class="row">
							<div class="form-group col-6">
								<textarea class="form-control" name="description_house" rows="6" maxlength="766" required>{{  $house->description_house }}</textarea>
								<label for="description">Descripcion casa</label>
							</div>

							<div class="form-group col-6">
								<textarea class="form-control" name="description_zone" rows="6" maxlength="766" required>{{  $house->description_zone }}</textarea>
								<label for="description2">Descripcion zona</label>
							</div>
						</div>
					</div>
					 {{-- END COL  --}}
			</div>
				 {{-- END ROW  --}}
				 {{-- ROW  --}}
				<div class="row">
					<div class="col-12 col-md-6">
						<h3>Habitantes de la VICO <span> - Vivienda compartida</span></h3>
						 {{-- CAROUSEL  --}}
						<div class="row">
							@foreach($homemates as $homemate)
								<div class="col-6" style="margin-bottom: 2rem;">
									<div class="row">
										<div class="col-6" style="width: 50% !important;">
											<input type="hidden" class="form-control" name="id_homemate[]" multiple value="{{$homemate->id_homemate}}">
										</div>
									</div>
									<div class="row">
										<div class="col-6" style="width: 50% !important;">
											Nombre
										</div>
										<div class="col-6" style="width: 50% !important;">
											<input type="text" class="form-control" name="nombre_homemate[]" multiple value="{{$homemate->name}}">
										</div>
									</div>
									<div class="row">
										<div class="col-6" style="width: 50% !important;">
											Profesión
										</div>
										<div class="col-6" style="width: 50% !important;">
											<input type="text" class="form-control" name="profession_homemate[]" multiple value="{{$homemate->profession}}">
										</div>
									</div>
									<div class="row">
										<div class="col-6" style="width: 50% !important;">
											Género
										</div>
										<div class="col-6" style="width: 50% !important;">
											<select class="form-control" name="gender_homemate[]" required>
												@if($homemate->gender == '1')
													<option value='1' selected>Hombre</option>
													<option value='2'>Mujer</option>
													<option value="3">Otro</option>
												@else
													<option value='1'>Hombre</option>
													<option value='2' selected>Mujer</option>
													<option value="3">Otro</option>
												@endif
											</select>
										</div>
									</div>
									<div class="row">
										<div class="col-6" style="width: 50% !important;">
											Habitacion
										</div>
										<div class="col-6" style="width: 50% !important;">
											<select  class="form-control" name="room_id_homemate[]">
												@foreach($house->Rooms as $room)
													@if($homemate->room_id === $room->id)
														<option value="{{$room->number}}" selected>{{$room->number}}</option>
													@else
														<option value="{{$room->number}}">{{$room->number}}</option>
													@endif
												@endforeach
											</select>
										</div>
									</div>
									<div class="row">
										<div class="col-6" style="width: 50% !important;">
											Nationality
										</div>
										<div class="col-6" style="width: 50% !important;">
											<select class="form-control" name="country_id_homemate[]">
												@foreach($countries as $country)
													@if($homemate->country == $country->id)
														<option value="{{$country->id}}" selected>{{$country->name}}</option>
													@else
														<option value="{{$country->id}}">{{$country->name}}</option>
													@endif
												@endforeach
											</select>
										</div>
									</div>
									<div class="row float-right">
										<div class="col-6" style="width: 50% !important;">
											Eliminar
										</div>
										<div class="form-group col-6" style="width: 50% !important;">
											<div class="form-group" style="top: 1.5rem !important">
												<label class="switch">
													<input type="checkbox" name="delete_homemate[]" value="{{$homemate->id_homemate}}" multiple>
													<span class="slider round">
													</span>
												</label>
											</div>
										</div>
									</div>
								</div>
							@endforeach
							 {{-- END CAROUSEL  --}}
						</div>
						<div class="row">
							<div class="col-sm-12" style="text-align: center; margin-top: 2.5rem; margin-bottom: 2.5rem">
								<a class="btn btn-primary" href="{{URL::to('/homemate/create', $house->id)}}">Crear nuevo compañero</a>
							</div>
						</div>
					</div>
					 {{-- COL  --}}
					<div class="col-xs-12 col-sm-6">
						<h3>¿Quién administra esta casa?</h3>
						<div class="text-center">
							<figure class="administrator_picture">
								<img style="width: 200px" src="http://fom.imgix.net/{{$manager->image}}?w=200&h=200&fit=crop" class="img-responsive" alt="">
							</figure>
							<label for="manager_image">Foto encargado actual</label>
							<input type="file" name="manager_image[]" multiple>
						</div>
						<div class="administrator-info">
							<div class="row">
								<div class="form-group col-sm-3" style="width: 50% !important">
									<input type="hidden" name="manager_id" value="{{$manager->id}}">
									<input type="text" class="form-control" name="manager_name" placeholder="Nombre" value="{{ $manager->name }}" required>
									<label for="manager_name">Nombre del encargado</label>
								</div>
								<div class="form-group col-sm-3" style="width: 50% !important">
									<select class="form-control" name="manager_vip" required>
										@if($manager->vip==1)
											<option value="1" selected>Si</option>
											<option value="0">No</option>
										@else
											<option value="1">Si</option>
											<option value="0"  selected>No</option>
										@endif
									</select>
									<label for="manager_vip"> Encargado VIP</label>
								</div>
							</div>

						</div>
						<div class="form-group">
							<textarea class="form-control" name="manager_description" rows="3" maxlength="766" required>{{ $manager->description }}</textarea>
							<label for="manager_description">Descripcion encargado</label>
						</div>
					</div>
					 {{-- END COL  --}}
				</div>
				 {{-- ROW  --}}
				<div class="row">
					 {{-- COL  --}}
					<div class="col-12">
						<h3>Equipos</h3>
						<div class="row">
							@foreach($devices as $device)
								@php ($flag=false)
								<div class="col-2">
									<div class="form-group">
										@foreach($house_devices as $house_device)
											@if($device->id === $house_device->device_id)
												<input checked type="checkbox" name="devices[]" value="{{ $device->id }}"
												<label for="devices[]">
													{{ $device->name }}
												</label>
												@php ($flag=true)
											@endif
										@endforeach
										@if($flag===false)
											<input type="checkbox" name="devices[]" value="{{ $device->id }}"
											<label for="devices[]">
												{{ $device->name }}
											</label>
										@endif
									</div>
								</div>
							@endforeach
						</div>
					</div>
					 {{-- END COL  --}}
				</div>
				 {{-- END ROW  --}}
				<div class="row mt-2">
					<div class="col-12">
						<h3>Normas de la casa</h3>
						<div class="table-responsive">
							<table class="table">
								@foreach($rules as $rule)
									<tr>
										<td class="important-rule"><p class="rule-name">{{ $rule->name }}</p></td>
										<td class="important-rule">
											<input type="text" class="form-control" name="rules[]" id="rule_{{ $rule->rule_id }}" value="{{ $rule->description }}" >
										</td>
									</tr>
								@endforeach
							</table>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<h3>Fotos de la VICO</h3>
						<div class="row">
							@forelse($images as $image)
								<div class="col-6">
									<div class="">
										<figure>
											<img src="http://fom.imgix.net/{{ $image->image }}?fit=fillmax&w=700&h=466.67&bg=ccc" class="img-responsive w-100" alt="Responsive image">
										</figure>
									</div>
									<div class="row">
										<div class="col-6">
											<label for="priority_pic">Prioridad
												<input type="hidden" name="image_img[]" value="{{ $image->image }}">
												<input type="number" class="form-control" name="priority_pic[]" placeholder="Prioridad" required autofocus multiple value="{{ $image->priority }}">
											</label>
										</div>
										<div class="col-3" style="width: 50% !important;">
											Eliminar
										</div>
										<div class="form-group col-3" style="width: 50% !important;">
											<div class="form-group" style="top: 1.5rem !important">
												<label class="switch">
													<input type="checkbox" name="delete_houseimage[]" value="{{$image->id}}" multiple>
													<span class="slider round">
													</span>
												</label>
											</div>
										</div>
									</div>

								</div>
							@empty
								No hay fotos aún
							@endforelse
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<label for="second_image">Añadir más fotos</label>
						<input type="file" name="second_image[]" multiple>
					</div>
				</div>
				{{-- ROW  ROOM SECTION --}}
				{{-- PONER LONG/LAT A HOUSE --}}
				<div id="hidden"></div>
				{{-- END Poner Long/lat a House --}}

				<div class="row" id="rooms-section">
					 {{-- COL  --}}
					<div class="col-12 vico-carousels-container">
						<h3>Habitaciones ({{ count($house->Rooms) }})</h3>
						 {{-- ROW  --}}
						<div class="row">
							@foreach($house->Rooms as $room)
								 {{-- COL  --}}
								<div class="col-12 col-md-6">
									{{-- CAROUSEL CLASS --}}
									<div class="carousel slide vico-room-carousel ">
										{{-- PICTURE CON DESCRIPCIÓN --}}
										<figure>
											<img src="http://fom.imgix.net/{{ $room->main_image[0]->image }}?fit=fillmax&w=700&h=466.67&bg=ccc" class="img-responsive w-100" alt="Responsive image">

											<figcaption class="">
												<div class="row">
													<div class="col-6">
														<h4>Hab. {{ $room->number }}  ${{ $room->price }} COP</h4>
														<p> @if ($room->available === "Disponible") {{ $room->available }} actualmente @else Disponible a partir del {{ date('d/m/Y', strtotime($room->available_from)) }} @endif</p>
															<a href="#" class="vico-gallery-button" data-toggle="modal" data-target=".room-{{ $room->id }}">Ver galería <span class="icon-gallery"></span></a>
														</div>
														<div class="col-3">
															<a class="btn btn-primary" role="button" href="/rooms/edit/{{ $room->id }}" aria-expanded="false" target="_blank">Editar</a>
														</div>
														<div class="col-3">
															<input type="checkbox" name="delete_room[]" value="{{ $room->id }}" multiple>
															<label for="delete_room[]">
																Borrar
															</label>
														</div>
													</div>
												</figcaption>

											</figure>
										</div>
										{{-- END CAROUSEL CLASS --}}

										{{-- INFO CONTAINER --}}
										<div class="info-container">

										</div>
										{{-- END INFO-CONTAINER  --}}

										{{-- MODAL --}}
										<div class="modal fade room-{{ $room->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
											<div class="modal-dialog modal-lg" role="document">
												<div class="modal-content">
													<a type="button" class="close modal-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="icon-close"></span></a>

													@foreach($room->main_image as $image)
														<figure>
															<img src="http://fom.imgix.net/{{ $image->image }}?w=1280&h=853&fit=crop" class="img-responsive w-100" alt="Responsive image">
														</figure>
													@endforeach
													<div class="text-center modal-back-container">
														<a class="btn btn-primary" role="button" data-dismiss="modal" aria-label="Close"><span class="icon-prev-fom modal-back"></span> Volver</a>
													</div>
												</div>
											</div>
										</div>
										{{-- END MODAL --}}
									</div>
									{{-- END COL --}}
								@endforeach
							</div>

							<div class="col-sm-6" style="position: relative; text-align: center;">
								<a  class="btn btn-primary" target="_blank" href="{{URL::to('/rooms/create', $house->id)}}">Agregar Habitación</a>
							</div>
						</div>
						 {{-- END ROW  --}}
					</div>
					 {{-- END COL  --}}

				</div>
				 {{-- END ROW ROOM SECTION --}}
				<div class="row">
					<div class="col-sm-12" style="text-align: center; margin-bottom: 5rem;">
						<button type="submit" class="btn btn-primary">Guardar</button>
					</div>
				</div>
			</form>
			 {{-- ROW  --}}
			<div class="row">
				<div class="col-12">
					<div class="well map-container" style="height: 200px" id="map"></div>

				</div>
			</div>
			 {{-- END ROW --}}
			 {{-- MODAL GALLERY  --}}
			<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<a type="button" class="close modal-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="icon-close"></span></a>
						@foreach($images as $image)
							<figure>
								<img src="http://fom.imgix.net/{{ $image->image }}?w=1280&h=853&fit=crop" class="img-responsive" alt="Responsive image">
							</figure>
						@endforeach
						<div class="text-center modal-back-container">
							<a class="btn btn-primary" role="button" data-dismiss="modal" aria-label="Close"><span class="icon-prev-fom modal-back"></span> Volver</a>
						</div>
					</div>
				</div>
			</div>
			 {{-- END MODAL GALLERY  --}}
		</div>

		<div class="modal fade" style="overflow:scroll" id="modal-changes" tabindex="-1" role="dialog" aria-labelledby="modal_changes">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
						<h2>Actualizar datos</h2>
					</div>
					<div class="modal-body">
						<form accept-charset="UTF-8" enctype="multipart/form-data">
							<div class="form-group">
								<label for="#new-rooms">
									Número de Habitaciones
								</label>
								<input type="number" class="form-control" id="new-rooms" placeholder="{{ $house->rooms_quantity }}">
							</div>

							<div class="form-group">
								<label for="#new-baths">
									Número de baños
								</label>
								<input type="number" class="form-control" id="new-baths" placeholder="{{ $house->baths_quantity }}">
							</div>

							<div class="form-group">
								<label for="#new-type">
									Tipo de vivienda
								</label>
								<select class="form-control" id="new-type">
									@if($house->type === 'Casa')
										<option value="Casa" selected>Casa</option>
										<option value="Apartamento">Apartamento</option>
									@else
										<option value="Casa" >Casa</option>
										<option value="Apartamento" selected>Apartamento</option>
									@endif
								</select>
							</div>

							<div class="form-group">
								<label for="#new-address">
									Dirección
								</label>
								<input type="text" class="form-control" id="new-address" placeholder="{{ $house->address }}">
							</div>

							<div class="form-group">
            		<label for="why-message" class="col-form-label">
									Escribanos porque quieres cambiarlo:
								</label>
            		<textarea class="form-control" id="why-message"></textarea>
          		</div>

						</form>
					</div>
		      <div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        		<button type="button" class="btn btn-primary" id="send-changes">Enviar &#10148;</button>
		      </div>
		    </div>
		  </div>
		</div>
	@endsection

	@section('scripts')
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4_XvxW91t7uHIL6tzmacsoIX17gHUIgM" defer></script>

		<script>

		function initMap(){
			map = new google.maps.Map(document.getElementById('map'), {
				zoom: 10,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				center: new google.maps.LatLng(0, 0)
			})
			var address = document.getElementById('address').value;
			set_marker_house(address);
		}
		function set_marker_house(house_address) {

			map = new google.maps.Map(document.getElementById('map'), {
				zoom: 16,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				center: new google.maps.LatLng(0, 0),
				mapTypeControl: false
			})

			var geocoder = new google.maps.Geocoder
			var address = $("#address").val()
			//Recordar que la ciudad y el país no deben ser estáticos, no todas las VICO estarán en Medellín, Colombia
			var city = '{{$house->neighborhood->location->zone->city->name}}';			
			var country = '{{$house->neighborhood->location->zone->city->country->name}}';			
			geocoder.geocode({ 'address': `${house_address},${city},${country}` },
			function(results, status) {

				if (status === google.maps.GeocoderStatus.OK) {

					let latlng = {
						lat: results[0].geometry.location.lat(),
						lng: results[0].geometry.location.lng()
					}
					// cambio: aqui tomo el dato de lat y lng para escibirlo, esto pasa cuando se carga la pagina
					var hidden = '<input id="pos" type="text" name="lat" class="d-none" value="';
					hidden+=latlng.lat;
					hidden+='" >';
					$("#hidden").append(hidden);

					var hidden = '<input id="pos2" type="text" name="lng" class="d-none" value="';
					hidden+=latlng.lng;
					hidden+='" >';
					$("#hidden").append(hidden);

					//                                alert('luego del hidden')


					var contentString = `<div id="content">
					<h3 id="firstHeading" class="firstHeading">${house_address.name}</h3>
					<div id="bodyContent">
					<p>
					Precios desde: $ ${house_address.min_price}
					</p>
					</div>
					</div>`

					let infowindow = new google.maps.InfoWindow({
						content: contentString
					})

					let marker = new google.maps.Marker({
						map: map,
						position: latlng,
						draggable: false
					})

					map.setCenter(new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng()));

					marker.addListener('click', function() {
						infowindow.open(map, marker)
					});

				}
				else {

					let infowindow = new google.maps.InfoWindow({
						content: 'con errores :('
					})

				}

				google.maps.event.trigger(map, 'resize')

			})

		}

		document.getElementById("address").onchange = function () {
			//                    var form.getElementById("form");

			$("#pos").replaceWith("");
			$("#pos2").replaceWith("");
			initMap();
		};
		$(document).ready(function(){
      initMap();
    })
		/* Se comentó esta sección del código porque ya no existe el método: HouseController@indexjsonid
		function ajax_houses() {

			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: `/houses/json/{{$house->id}}`,
				datatType : 'json',
				type: 'GET',
				cache: false,
				contentType: false,
				processData: false,
				success: function(response) {
					//                            alert('en el ajax')
					house_address = response[0]
					set_marker_house(house_address)
				},
				error: function(err) {
					console.log(err)
				}
			});

		}
		*/
		</script>
		{{--
		<script type="text/javascript">
		$('.carousel[data-type="multi"] .item').each(function() {
			var next = $(this).next();
			if (!next.length) {
				next = $(this).siblings(':first');
			}
			next.children(':first-child').clone().appendTo($(this));

			for (var i = 0; i < 1; i++) {
				next = next.next();
				if (!next.length) {
					next = $(this).siblings(':first');
				}

				next.children(':first-child').clone().appendTo($(this));
			}
		});
		</script>
		--}}


		<script type="text/javascript">
			$(document).ready(function(){
				$('#send-changes').click(function(e){
					var newRooms = document.getElementById('new-rooms');
					var newBaths = document.getElementById('new-baths');
					var newType = document.getElementById('new-type');
					var newAddress = document.getElementById('new-address');
					var message = document.getElementById('why-message');

					if(newRooms.value=="" && newBaths.value=="" && newType.value=="{{ $house->type }}" && newAddress.value==""){
						alert("No se han realizado cambios.");
					}else {
						if (message.value=="") {
							alert("Necesitas agregar una razón para hacer los cambios.");
						}else {
							var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

							var houseInfo = {
								"house_id": "{{ $house->id }}",
								"house_owner_id": "{{ Auth::user()->id }}",
								"house_owner_name": "{{ Auth::user()->name }}"
							};

							var newInfo = {
									"newRooms": newRooms.value,
			            			"newBaths":	newBaths.value,
									"newType": newType.value,
									"newAddress": newAddress.value,
									"message": message.value
							};

							var oldInfo = {
								"OldRooms": "{{ $house->rooms_quantity }}",
								"OldBaths":	"{{ $house->baths_quantity }}",
								"OldType": "{{ $house->type }}",
								"OldAddress": "{{ $house->address }}"
							};

							$.ajax({
					          url: '/houses/edit/post',
					          type: 'POST',
					          data: {
					            _token: CSRF_TOKEN,
								houseInfo: houseInfo,
					           	newInfo: newInfo,
								oldInfo: oldInfo},
					            success: function (data) {
												if (data=='1') {
													$("#modal-changes").modal('hide');
													alert("Su petición ha sido enviada. Se le notificará si el cambio ha sido aceptado");
												}
												else {
													// console.log(data);
												}
					  					}
					        });
						}
					}
				});
			});
		</script>
	@endsection
@else
	<p>You are not allowed to enter this page.</p>
@endif
