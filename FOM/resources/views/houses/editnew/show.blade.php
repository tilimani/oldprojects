@extends('layouts.app')

@section('title', $house->name)

@section('content')
	{{--start images--}}

		<div class="row vico-body" style="padding:0px; margin:0px">

			@if ($house->status == 5)

				<div class="xd-message w-100 mt-1 mb-1">

					<div class="xd-message-icon">
					  <p>!</p>
					</div>
					<div class="xd-message-content">
					  <p>Esta casa todavía no está aprobada, solamente tu la puedes ver. Una vez que tengamos las fotos y la información verificada será publicada. Si tienes dudas te puedes <a href="mailto:contacto@friendsofmedellin.com">poner en contacto con nosotros.</a></p>
					</div>
					<a class="xd-message-close">
					  <i class="close-icon ion-close-round"></i>
					</a>

				</div>

			@endif

			<div class="col-12 d-md-none" style="padding:0px; margin:0px">

				{{--Vico Carousel--}}

					<div class="vico-header-carousel" data-flickity='{ "pageDots": false, "contain": true, "lazyLoad": 2, "imagesLoaded": true}'>

						@foreach($house->main_image as $img)
							<div class="carousel-cell">
								<img style="border-radius: 0 !important;" class="dblock w-100" src="https://fom.imgix.net/{{ $img->image }}?w=750&h=500&fit=crop" alt="{{$img->image}}slide">
							</div>
						@endforeach

					</div>

				{{--End VicoCarousel--}}

			</div>

			{{-- Col-6 --}}

			<div class="col-md-6 col-12 d-none d-md-block" style="padding:0px; margin:0px">
				<img src="{{'https://fom.imgix.net/'.$house->main_image->first()->image }}?w=750&h=500&fit=crop" class="img-fluid" alt="Responsive image">
			</div>

			{{-- Col-6 --}}

			<div class="col-md-6 d-none d-md-block" style="padding:0px; margin:0px">
				@foreach ($house->main_image as $index => $image)
					@if ($index !== 0)
					<div class="col-md-6 float-left " style="padding:0px; margin:0px;">
						<img src="{{'https://fom.imgix.net/'.$image->image }}?w=750&h=500&fit=crop" class="img-fluid" alt="Responsive image"></a>
					</div>
					@endif
					@break($index>=4)
				@endforeach

			</div>

		</div>

		<div class="vico-image-func">

			<div class="row">


				<div class="col-12">
					<p>
						<b>Editar las imagenes de tu vico:</b>
						<a target="_blank" href="/houses/editnew/images/{{ $house->id }}"
							data-scroll class="btn btn-primary" role="button">
							Editar imagenes
						</a>
					</p>
					<p>
						<b>Editar los puntos de interés genéricos:</b>
						<a target="_blank" href="{{route('genericInterestPoint.house.create', $house)}}"
							data-scroll class="btn btn-primary" role="button">
							Editar
						</a>
					</p>
					<p>
						<b>Editar los puntos de interés específicos:</b>
						<a target="_blank" href="{{route('specificInterestPoint.house.create', $house)}}"
							data-scroll class="btn btn-primary" role="button">
							Editar
						</a>
					</p>

				</div>

				<!-- <div class="col-9">

					<form method="POST" action="{{ URL::to('/houses/editnew/images/store') }}" accept-charset="UTF-8" enctype="multipart/form-data">

						{{ csrf_field() }}

						<input type="hidden" id="house_id" name="house_id" value="{{ $house->id }}">

						<label class="fileContainer">

							Seleccionar imágenes
							<input onchange="confirmUpload(this)"
								type="file" name="second-image[]"
								accept="image/jpeg, image/png"
								multiple
								/>

						</label>

						<button type="submit" class="btn btn-primary confirm-upload" style="display: none">Guardar
						</button>

					</form>-->

				</div>



			</div>

		</div>

		<hr>

    {{--end images--}}

    {{--start container--}}

        <div class="vico-homemate-house">

        	{{--start main--}}

            	<div class="row m-0">

            		<div class="col-12 p-0">

            			{{--start container fluid--}}

                            <div class="container">

                				{{--start gallery--}}

								<div class="row">

									<div class="col-md-8 col-lg-12">

										<p class="h1 text-uppercase">
											{{$house->name}}
										</p>

										<p class="h4 mb-2">
											<span class="icon-location" style="font-size: 1.2rem"></span> Barrio {{$neighborhood->name}}
										</p>

										<div class="row justify-content-between">
											<div class="col-12">
												<span class="fs-rem-9 pr-md-3 pr-lg-4"><span class="icon-z-bed h6"></span> {{ $house->rooms_quantity}} habitaciones</span>
												<span class="fs-rem-9 pr-md-3 pr-lg-4"><span class="icon-z-bathroom-2 h6"></span> {{$house->baths_quantity}} Baños.</span>
												<span class="fs-rem-9 pr-md-3 pr-lg-4"><span class="icon-z-zbuilding h6"></span> {{$house->type}}</span>
											</div>
										</div>
										<p class="fs-rem-10">
											<b>
												@if( $house->rooms_quantity > 1)
													{{ $house->rooms_quantity }} habitaciones disponibles ahora
												@else
													{{ $house->rooms_quantity }} habitación disponible ahora
												@endif
											</b>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-12">
										<a href="#" data-toggle="modal" data-target="#modal-changes">
											<p class="vico-color fs-rem-9 text-right">
												¿Quieres cambiar estos datos? Solicita el cambio.
											</p>
										</a>
									</div>

								</div>

								<hr>

                				{{--end gallery--}}

                                {{--start bookings--}}

								<div class="row" id="rooms-section">
									<div class="col-12">
										<a href="/houses/editnew/bookings/{{ $house->id }}">
											<p class="h4 vico-color">
												Habitaciones <small>({{$house->rooms_quantity}})
											</p>
										</a>
									</div>
								</div>
								</div>
								{{-- Rooms section --}}
								<div class="container p-0">
									<table class="table table-sm homemate-table">
										<thead>
											<tr>
												<th scope="col" class="text-center fs-rem-9">#</th>
												<th scope="col" class="text-left fs-rem-9">Nombre y precio</th>
												<th scope="col" class="text-left fs-rem-9 d-none d-lg-block">Precio</th>
												<th scope="col" class="text-center fs-rem-9">Disponible</th>
												<th scope="col" class="text-center fs-rem-9 d-none d-md-block">Ocupado por</th>
												<th scope="col" class="text-center fs-rem-9"></th>
											</tr>
										</thead>
										<tbody>
											@foreach($house->Rooms as $room)
											<tr class="bl edit-item
														@if($room->price > 5000000 || \Carbon\Carbon::parse($room->available_from)->year >= 9990)
															border-left-grey
															denied
														@elseif(\Carbon\Carbon::now() >= $room->available_from)
															border-left-green
														@else
															border-left-red
														@endif"
												data-toggle="collapse" data-target=".room-details-{{$room->id}}">
												<th scope="row" class=" position-relative text-center pt-4 fs-rem-9 tableRoomNumber ">{{$room->number}}</th>
												<td class="pb-0 align-middle">
													<p class="text-left mb-0 fs-rem-9"><b>
															@if($room->nickname != null)
															{{$room->nickname}}
															@else
															Habitación #{{$room->number}}
															@endif
														</b></p>
													@if($room->price > 5000000 || \Carbon\Carbon::parse($room->available_from)->year >= 9990)
													<p class="text-left mb-0 fs-rem-9 d-lg-none">
														No se alquila.
													</p>
													@else
													<p class="text-left mb-0 fs-rem-9 d-lg-none" id="price_room_{{$room->id}}">
														{{$room->price}} COP
													</p>
													@endif
                        </td>
                        <td class="pb-0 align-middle d-none d-lg-block border-0">
                          @if($room->price > 5000000 || \Carbon\Carbon::parse($room->available_from)->year >= 9990)
													<p class="text-left mb-0 fs-rem-9">
														No se alquila.
													</p>
													@else
													<p class="text-left mb-0 fs-rem-9 " id="price_room_{{$room->id}}">
														{{$room->price}} COP
													</p>
													@endif
                        </td>
												<td class="pb-0 align-middle">
													@if($room->price > 5000000 || \Carbon\Carbon::parse($room->available_from)->year >= 9990)
													<p class="text-center mb-0 fs-rem-9">Editar</span></p>
													@else
														@if(\Carbon\Carbon::parse($room->available_from)->year === \Carbon\Carbon::now()->year && \Carbon\Carbon::parse($room->available_from)->day === \Carbon\Carbon::now()->day && \Carbon\Carbon::parse($room->available_from)->month === \Carbon\Carbon::now()->month)
														<p class="text-center mb-0 fs-rem-9"><b>
															Ahora
														</b></p>
														@else
													<p class="text-center mb-0 fs-rem-9"><b>
                              {{date('d/m/y', strtotime($room->available_from))}}
														</b></p>
														@endif
														@if($room->occupant !== '')
                            <p class="text-center mb-0 d-xs-block d-md-none fs-rem-9"><span class="icon-man"></span>
                              @foreach ($room->bookings as $booking)
                                @if(sizeof($room->bookings) >= 1)
                                  @if ($room->bookings->last()->id === $booking->id)
                                      {{$booking->name}}
                                  @else
                                    {{$booking->name}},
                                  @endif
                                @else
                                {{$room->occupant}}
                                @endif
                              @endforeach
                            </p>
														@else
														<p class="mb-0 text-center fs-rem-9 d-block d-md-none font-weight-light">+ Agregar habitante</p>
														@endif
													@endif
												</td>
												<td class="d-none d-md-block text-center">
													<p class="text-center">
														@if($room->occupant !== '')
                            <p class="text-center mb-0 fs-rem-9"><span class="icon-man"></span>
                              @foreach ($room->bookings as $booking)
                                @if(sizeof($room->bookings) >= 1)
                                  @if ($room->bookings->last()->id === $booking->id)
                                    {{$booking->name}}
                                  @else
                                    {{$booking->name}},
                                  @endif
                                @else
                                {{$room->occupant}}
                                @endif
                              @endforeach
                            </p>
														@else
														<p class="mb-0 text-center fs-rem-9 font-weight-light">+ Agregar habitante</p>
														@endif
													</p>
												</td>
												<td class="arrow">
													<p class="text-center mt-4 arrow-container">
														@if($room->price > 5000000 || \Carbon\Carbon::parse($room->available_from)->year >= 9990)
														<span class="icon-next-fom"></span> @else
														<span class="icon-next-fom"></span> @endif
													</p>
												</td>
											</tr>
											<tr class="bl
													@if($room->price > 5000000 || \Carbon\Carbon::parse($room->available_from)->year >= 9990)
														border-left-grey
														border-left-green
													@elseif(\Carbon\Carbon::now() >= $room->available_from)
														border-left-green
													@else
														border-left-red
													@endif">
												<td class="hiddenRow" colspan="5" id="collapse_{{$room->id}}">
                          <div class="collapse room-details-{{$room->id}} container" id="description_room_{{$room->id}}">

														<div class="row d-flex justify-content-center text-left align-items-center py-1">
                              <div class="col-2 text-center">
                                <span class="icon-z-date fs-rem-10"></span>
                              </div>
                              <div class="col-6">
                                <span class="fs-rem-8">
                                  @if ($room->occupant != '')
                                    @if(!$room->next)
                                    {{$room->occupant}} vive aquí hasta el {{$room->date}}
                                    @else
                                    {{$room->occupant}} llega el {{$room->date}}
                                    @endif
                                  @else
                                    No tiene proximos habitantes
                                  @endif
                                </span>
                              </div>
                              <div class="col-4">
                                @if (!sizeof($room->bookings) >= 1)
                                <button type="button" class="btn btn-primary edit_booking_btn edit-add-roomie-modal" data-toggle="modal" value-room="{{$room->id}}" data-target="#editAddRoomieModal">Agregar<i class="ml-2 fas fa-angle-right fs-rem-12"></i></button>
                                @else
                                <button type="button" value="{{$room->id}}" class="btn btn-outline-primary edit_booking_btn">Editar<i class="ml-2 fas fa-angle-right fs-rem-12"></i></button>
                                @endif

                              </div>
                            </div>
                        @if($room->description ==! '')
						<div class="row d-flex justify-content-center text-left align-items-center py-1">
                          	<div class="col-2 text-center">
                                <span class="icon-search-black fs-rem-11"></span>
                          	</div>
							<div class="col-6">
								<span class="fs-rem-8">
                                  {{$room->description}}
                                </span>
                          	</div>
							<div class="col-4">
								<a target="_blank" href="/rooms/edit/{{$room->id}}" class="btn btn-outline-primary rounded">Editar<i class="ml-2 fas fa-angle-right fs-rem-12"></i></a>
							</div>
                        </div>
                        @else
						<div class="row d-flex justify-content-center text-left align-items-center py-1">
                          	<div class="col-2 text-center">
                                <span class="icon-search-black fs-rem-11"></span>
                          	</div>
							<div class="col-6">
								<span class="fs-rem-8">
                                  Todavia no hay una descripción para la habitación.
                                </span>
                          	</div>
							<div class="col-4">
								<a target="_blank" href="/rooms/edit/{{$room->id}}" class="btn btn-outline-primary rounded">Editar<i class="ml-2 fas fa-angle-right fs-rem-12"></i></a>
							</div>
                        </div>
                        @endif

						<div class="row d-flex justify-content-center text-left align-items-center py-1">
                          	<div class="col-2 text-center">
                                <span class="icon-chest-of-drawers-5 fs-rem-14"></span>
                          	</div>
							<div class="col-6">
								@php
								$devices_room='Equipos: ';
								$devices_room=$devices_room.'Cama '.$room->devices->bed_type.', ';
								$devices_room=$devices_room.'Baño '.$room->devices->bath_type.', ';
								@endphp
								@if ($room->devices->desk === 1)
								@php
								$devices_room=$devices_room.'Escritorio, ';
								@endphp
								@endif
								@if ($room->devices->tv === 1)
								@php
								$devices_room=$devices_room.'Televisor, ';
								@endphp
								@endif
								@if ($room->devices->closet === 1)
								@php
								$devices_room=$devices_room.'Closet, ';
								@endphp
								@endif
								@if ($room->devices->windows_type === 'adentro')
								@php
								$devices_room=$devices_room.'Ventana hacia adentro';
								@endphp
								@elseif($room->devices->windows_type === 'afuera')
								@php
								$devices_room=$devices_room.'Ventana hacia afuera';
								@endphp
								@elseif($room->devices->windows_type === 'patio')
								@php
								$devices_room=$devices_room.'Ventana hacia un patio';
								@endphp
								@elseif($room->devices->windows_type === 'sin_ventana')
								@php
								$devices_room=$devices_room.'sin Ventana';
								@endphp
                                @endif
                                <span class="fs-rem-8">
                                  {{$devices_room}}
                                </span>
                          	</div>
							<div class="col-4">
								<a target="_blank" href="/rooms/edit/{{$room->id}}" class="btn btn-outline-primary rounded">Editar<i class="ml-2 fas fa-angle-right fs-rem-12"></i></a>
							</div>
                        </div>

														<div class="row d-flex justify-content-center text-left align-items-center py-1">
                              <div class="col-2 text-center">
                                  <i class="fas fa-dollar-sign fs-rem-10"></i>
                              </div>
															<div class="col-6">
																	<span  class="fs-rem-8" id="price_room_{{$room->id}}_2">Valor mensual <span class="">$</span>{{$room->price}} COP</span>
															</div>
															<div class="col-4">
																<a target="_blank" href="/rooms/edit/{{$room->id}}" class="btn btn-outline-primary rounded">Editar<i class="ml-2 fas fa-angle-right fs-rem-12"></i></a>
															</div>
                            </div>

														<div class="row d-flex justify-content-center text-left align-items-center py-1">
                              <div class="col-2 text-center">
                                <span class="icon-instagram-black fs-rem-10"></span>
                              </div>
															<div class="col-6">
																	<span class="fs-rem-8">
																		@if($room->count_images > 0)
																			Tiene {{$room->count_images}}
																			{{ $room->count_images > 1? 'fotos guardadas':'foto guardada'}}
																		@else
																			No tiene fotos guardadas
																		@endif
																	</span>
															</div>
															<div class="col-4">
																<a target="_blank" href="/rooms/edit/{{$room->id}}" class="btn btn-outline-primary rounded">Editar<i class="ml-2 fas fa-angle-right fs-rem-12"></i></a>
															</div>
														</div>
													</div>

													<div id="description_bookings_{{$room->id}}" class="room-details-{{$room->id}} collapse container houses-roomies" style="display:none">
                              @foreach ($room->bookings as $booking)
                                  <div class="row pt-2 px-2 houses-roomies-ext">
                                    <div class="thumb-roomie text-center">
                                      @if($booking->gender === 2)
                                      <img src="../../images/homemates/girl.png" alt="girl" srcset="../../images/homemates/girl@2x.png 2x, ../../images/homemates/girl@3x.png 3x" />
                                      <small><img class=" vico-show-habitant-flag" src="../../images/flags/{{$booking->icon}}"></small>
                                      @else
                                      <img src="../../images/homemates/boy.png" alt="boy" srcset="../../images/homemates/boy@2x.png 2x, ../../images/homemates/boy@3x.png 3x" />
                                      <small><img class=" vico-show-habitant-flag" src="../../images/flags/{{$booking->icon}}"></small>
                                      @endif
                                    </div>
                                    @if ($room->booking === $booking->id)
                                      @if (!$room->next)
                                        <div class="text-roomie">
                                          <p class="text-center">
                                          	@if ($booking->status === '100')
                                          	  <span class="badge badge-pill badge-secondary">externo</span>
                                          	@endif
                                            {{$room->occupant}} vive hasta
                                          </p>
                                        </div>
                                        <div class="calendar-roomie text-center">
                                          <p class="text-center">
                                              <input type="date" class="form-control" id="date_to_{{$room->date}}" value={{$room->date}}
                                            disabled>
                                          </p>
                                        </div>
                                      @else
                                        <div class="text-roomie">
                                          <p class="text-center">
                                          	@if ($booking->status === '100')
                                          	  <span class="badge badge-pill badge-secondary">externo</span>
                                          	@endif
                                            {{$room->occupant}} llega el
                                          </p>
                                        </div>
                                        <div class="calendar-roomie text-center">
                                          <p class="text-center">
                                              <input type="date" class="form-control" id="date_to_{{$room->date}}" value={{$room->date}}
                                            disabled>
                                          </p>
                                        </div>
                                      @endif
                                    @else
                                      <div class="text-roomie">
                                        <p class="text-center">
                                        	@if ($booking->status === '100')
                                        	  <span class="badge badge-pill badge-secondary">externo</span>
                                        	@endif
                                          {{$booking->name}} llega el
                                        </p>
                                      </div>
                                      <div class="calendar-roomie text-center">
                                        <p class="text-center">
                                            <input type="date" class="form-control" id="date_to_{{$booking->date_from}}" value={{$booking->date_from}}
                                          disabled>
                                        </p>
                                      </div>
                                    @endif
									<div class="request-roomie" style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
									  @if ($booking->status === '100')
									 	<a href="{{route('bookings.manager.show', $booking->id)}}">Ver Solicitud</a>
									 	<a href="{{route('bookingdate.getManager', $booking->id)}}">Cambiar Fecha de Salida</a>	
										<a href="{{route('manager.paymentmanual',$booking->id)}}">Registrar Pago</a>
										<a href="{{ route('download_payment_pdf', $booking->id) }}">Descargar Contrato</a>
                                        	{{-- <button type="button" value="{{$booking->id}}" class="btn btn-primary edit_booking_homemate">Editar </button> --}}
                                      @else
                                        <p class="text-center">
                                          <a href="/booking/show/{{$booking->id}}">Ver Solicitud</a>
                                        </p>
                                      @endif
                                    </div>
                                  </div>
                                @endforeach
															{{-- <div class="row py-2 px-2 text-center houses-roomies-add">
																<div class="request-roomie">
																</div>
															</div> --}}
															<div class="row text-center py-3 mx-auto">
																<div class="col-sm">
																	<a href=""
																	 data-toggle="modal" class="btn btn-outline-danger" data-target="#editAddRoomieModal" value-room="{{$room->id}}" >
																	   <span class="rounded mb-0 text-center fs-rem-9" style="font-size: 14px !important; color: red;"><i class="fas fa-plus-circle"></i> La habitación esta ocupada</span>
																	 </a>
																</div>
															</div>
															
															<div class="row text-center py-3 mx-auto">
																<div class="col-sm">
																	<form method="POST"  action="{{ URL::to('/houses/editnew/makeRoomAvailable') }}" enctype="multipart/form-data" class="d-flex justify-content-center text-center">

																	  <input name="booking_id_request" type="hidden" class="form-control" value="@foreach ($room->bookings as $booking) {{$booking->id}}, @endforeach">
																	  <input name="room_id_request" type="hidden" class="form-control" value="{{$room->id}}">
																	  {{ csrf_field() }}
																	</form>
																</div>
															</div>
															<div class="row text-center py-3 mx-auto">
																<div class="col-sm">
																	<button type="button" class="btn btn-primary back_booking" value="{{$room->id}}">Volver</button>
																</div>
															</div>
													</div>
												</td>
											</tr>
											@endforeach
											<div class="modal fade" id="edit_price_room_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
											aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title">Cambio de Precio</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															<div class="container-fluid">
																<div class="row">
																	<div class="col-12">
																		<p>
																			El precio actual de esta habitación es de: <b id="current_price_room"> y puede ser cambiado por:</b>
																		</p>
																	</div>
																	<div class="col-12 m-0 p-0">
																		<div class="input-group w-75 w-ms-100 w-mm-100 center-block">
																			<div class="input-group-prepend">
																				<span class="input-group-text " id="price-addon">Nuevo Precio</span>
																			</div>
																			<input type="text" class="form-control" style="text-align:right;" type="number" id="new_price_room" aria-describedby="price-addon">
																			<div class="input-group-append">
																				<span class="input-group-text" id="price-currency">COP</span>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
															<button type="button" class="btn btn-primary" id="confirm_upload_price">Guardar Precio</button>
														</div>
													</div>
												</div>
											</div>
											<div class="modal fade" id="edit_date_booking_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
											aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title">Cambio de Fecha</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															<label for="">Nueva Fecha</label>
															<input class="form-control" id="new_date_booking" autocomplete="off" readonly>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
															<button type="button" class="btn btn-primary" id="confirm_upload">Guardar Fecha</button>
														</div>
													</div>
												</div>
                      </div>
                      <div class="modal fade" id="editAddRoomieModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
											aria-hidden="true">
												<div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <form method="post" action="/houses/editnew/newHomemate" enctype="multipart/form-data">
                              {{ csrf_field() }}
                              <div class="modal-header">
                                <h5 class="modal-title">Agregar Roomie <span class="badge badge-pill badge-secondary">EXTERNO</span></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">

                                  <div class="row m-0 extern-roomie-add-1">
                                    <label for="" class="title-roomie m-0 flex-center">Habitación:</label>
                                    <select class="custom-select element-roomie" id="addNewRommieSelect" name="room_id">
                                        <option value="0" selected></option>
                                      @foreach($house->Rooms as $room)
                                        <option value='{{ $room->id}}'>{{ $room->number }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                  <div class="row m-0 mt-2 extern-roomie-add-2">
                                    <label for="" class="title-roomie">Nombre:</label>
                                    <input type="text" name="name" class="element-roomie form-control" required>
                                  </div>
                                  <div class="row m-0 mt-2 extern-roomie-add-3">
                                    <label for="" class="calendar-roomie">Género:</label>
                                    <div class="title-roomie">
                                      <input type="hidden" name="gender_female" value="0">
                                        <p class="text-center"><span class="icon-woman
                                          gender-female-roomie vico-show-equipos p-2"></span>
                                        </p>

                                    </div>
                                    <div class="element-roomie">
                                        <input type="hidden" name="gender_male" value="0">
                                        <p class="text-center"><span class="icon-man
                                          gender-male-roomie vico-show-equipos p-2"></span>
                                        </p>
                                    </div>
                                  </div>
                                  <div class="row m-0 mt-2 extern-roomie-add-4">
                                    <label for="" class="title-roomie">Nacionalidad:</label>
                                    <select class="custom-select element-roomie" name="country_id" required>
                                      <option value="" selected disabled>-- Seleccione --</option>
                                      @foreach($countries as $country)
                                        <option value='{{ $country->id}}'>{{ $country->name }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                  <div class="row m-0 mt-2 extern-roomie-add-5">
                                    <label for="" class="title-roomie m-0">Reside en esta</label>
                                    <label for="" class="calendar-roomie m-0 flex-center">Habitación desde:</label>
                                    <input type="text" name="date_from" class="element-roomie form-control bg-white" id="newHomemateDateFrom" autocomplete="off" readonly>
                                  </div>
                                  <div class="row m-0 mt-2 extern-roomie-add-6">
                                    <label for="" class="title-roomie m-0">Residirá en esta</label>
                                    <label for="" class="calendar-roomie m-0 flex-center">Habitación hasta:</label>
                                    <input type="text" name="date_to" class="element-roomie bg-white form-control" id="newHomemateDateTo" autocomplete="off" readonly required >
                                  </div>

                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                              </div>
                            </form>
													</div>
												</div>
                      </div>
                      <div class="modal fade" id="editUpdateRoomieModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
											aria-hidden="false">
												<div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <form method="post" action="/houses/editnew/updateHomemate" enctype="multipart/form-data">
                              {{ csrf_field() }}
                              <div class="modal-header">
                                <h5 class="modal-title">Editar Roomie <span class="badge badge-pill badge-secondary">EXTERNO</span></h5>
                                <button type="button" class="btn btn-link" data-toggle="modal" id="btnConfirmDeleHomemate" data-target="#confirmDeleteHomemate">BORRAR HOMEMATE</button>
                                <button type="button" class="close ml-1" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <input type="hidden" name="user_id" id="editRoomieUserID">
                                <input type="hidden" name="booking_id" id="editRoomieBookingID">
                                  <div class="row m-0 extern-roomie-add-1">
                                    <label for="" class="title-roomie m-0 flex-center">Habitación:</label>
                                    <select class="custom-select element-roomie" name="room_id" id="editRoomieRoom">
                                      <option value="0" selected></option>
                                      @foreach($house->Rooms as $room)
                                        <option value='{{ $room->id}}'>{{ $room->number }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                  <div class="row m-0 mt-2 extern-roomie-add-2">
                                    <label for="" class="title-roomie">Nombre:</label>
                                    <input type="text" name="name" id="editRoomieName" class="element-roomie form-control" required>
                                  </div>
                                  <div class="row m-0 mt-2 extern-roomie-add-3">
                                    <label for="" class="calendar-roomie">Género:</label>
                                    <div class="title-roomie">
                                      <input type="hidden" name="gender_female" id="editRoomieGenderFemale" value="0">
                                        <p class="text-center"><span class="icon-woman
                                          gender-female-roomie vico-show-equipos p-2"></span>
                                        </p>

                                    </div>
                                    <div class="element-roomie">
                                        <input type="hidden" name="gender_male" id="editRoomieGenderMale" value="0">
                                        <p class="text-center"><span class="icon-man
                                          gender-male-roomie vico-show-equipos p-2"></span>
                                        </p>
                                    </div>
                                  </div>
                                  <div class="row m-0 mt-2 extern-roomie-add-4">
                                    <label for="" class="title-roomie">Nacionalidad:</label>
                                    <select class="custom-select element-roomie" name="country_id" id="editRoomieCountry" required>
                                      <option value="" selected disabled>-- Seleccione --</option>
                                      @foreach($countries as $country)
                                        <option value='{{ $country->id}}'>{{ $country->name }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                  <div class="row m-0 mt-2 extern-roomie-add-5">
                                    <label for="" class="title-roomie m-0">Reside en esta</label>
                                    <label for="" class="calendar-roomie m-0 flex-center">Habitación desde:</label>
                                    <input type="text" name="date_from" id="editRoomieDateFrom" class="ele bg-whitement-roomie form-control"  autocomplete="off" readonly>
                                  </div>
                                  <div class="row m-0 mt-2 extern-roomie-add-6">
                                    <label for="" class="title-roomie m-0">Residirá en esta</label>
                                    <label for="" class="calendar-roomie m-0 flex-center">Habitación desde:</label>
                                    <input type="text" name="date_to" class="element-roomie bg-white form-control" id="editRoomieDateTo"  autocomplete="off" readonly required>
                                  </div>

                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                              </div>
                            </form>
													</div>
												</div>
                      </div>
                      <div class="modal fade" id="confirmDeleteHomemate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
											aria-hidden="true">
												<div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <form method="POST" action="/houses/editnew/eraseRoomie">
                              {{csrf_field()}}
                              <div class="modal-header">
                                <h5 class="modal-title">Confirmación</h5>
                                <button type="button" class="close ml-1" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <h6 class="modal-subtitle">¿Estás seguro que quieres borrarlo?</h6>
                              </div>
                              <div class="modal-footer">
                                <input type="hidden" id="deleteBookingId" name="booking_id">
                                <input type="hidden" id="deleteUserID" name="user_id">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeConfirmDeleteHomemate">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Borrar</button>
                              </div>
                            </form>
													</div>
												</div>
                      </div>
										</tbody>
									</table>
								</div>
								{{--end Rooms SECTION--}}


                                {{--end bookings--}}

								{{--start manager--}}
								<div class="container">
									<hr>
									<div class="row" id="rooms-section">
										<div class="col-12">
											<a href="/useredit/1#postUser" target="_blank">
												<p class="h4 vico-color">
													Mi información
												</p>
											</a>
										</div>
									</div>
									<div class="row">
										<div class="col-12">
											<img class="img-responsive rounded-circle img-shape-50" src="https://fom.imgix.net/{{$manager[0]->image}}?w=500&h=500&fit=crop" alt="Foto del Administrador">
											<p class="fs-rem-9 d-block d-sm-none item-blocked">
												{{str_limit($manager[0]->description, $limit = 110, $end='...')}}
												<a href="/useredit/1#postUser" target="_blank"><span class="vico-color fs-rem-9 text-right">Editar ></span></a>
											</p>
											<p class="fs-rem-9 d-none d-md-block d-lg-none item-blocked">
												{{str_limit($manager[0]->description, $limit = 400, $end='...')}}
												<a href="/useredit/1#postUser" target="_blank"><span class="vico-color fs-rem-9 text-right">Editar ></span></a>
											</p>
											<p class="fs-rem-9 d-none d-lg-block item-blocked">
												{{str_limit($manager[0]->description, $limit = 450, $end='...')}}
												<a href="/useredit/1#postUser" target="_blank"><span class="vico-color fs-rem-9 text-right">Editar ></span></a>
											</p>
										</div>
									</div>
									<hr>
								</div>
                                {{--end manager--}}

                                {{--start vico--}}
								<div class="container" id="houseDescription">
									<form class="d-none" id="postHouseDescription">
										{{csrf_field()}}
										<input type="hidden" name="house_id" value="{{ $house->id }}">
										<input type="hidden" name="description_house">
										<input type="hidden" name="description_zone">
									</form>
									<div class="row">
										<div class="col-12 my-2">
											<a href="/houses/editnew/vico/{{ $house->id }}" target="_self">
												<p class="h4 vico-color d-inline">
													Descripción VICO

													<a data-scroll class="btn btn-primary editHouseDesc btn-float-right" role="button">
														Editar
													</a>

													<a data-scroll class="btn btn-primary saveHouseDesc d-none btn-float-right" role="button">
														Confirmar
													</a>
												</p>
											</a>
										</div>
									</div>
									{{-- Vico description --}}
									<div class="row">
										<div class="col-12 border rounded mx-2 txtHouseDesc item-blocked" contenteditable="false">
											{!! nl2br($house->description_house) !!}<br>{!! nl2br($house->description) !!}
										</div>
									</div>
									<hr>
									<div class="row">
										<div class="col-12 my-2">
											<a href="/houses/editnew/vico/{{ $house->id }}" target="_self">
												<p class="h4 vico-color d-inline">
													Acerca del barrio
												</p>
												<a data-scroll class="btn btn-primary editNghbDesc btn-float-right" role="button">
													Editar
												</a>
												<a data-scroll class="btn btn-primary saveNghbDesc d-none btn-float-right" role="button">
													Confirmar
												</a>
											</a>
										</div>
									</div>
									{{-- Vico Neighborhood description --}}
									<div class="row">
										<div class="col-12 border rounded mx-2 txtNghbDesc item-blocked" contenteditable="false">
											{!! nl2br($house->description_zone) !!}
											<br>{!! nl2br($house->description2) !!}
										</div>
									</div>
								</div>
                                <hr>
                                {{--end vico--}}

								{{--start equipos --}}
								<div class="container">
									<div class="row" style="margin-bottom: 10px;">
										<div class="col-12">
											<p class="h4 vico-color d-inline">
												Equipos
												<a data-scroll class="btn btn-primary editDevices btn-float-right"  role="button">
													Editar
												</a>
												<a data-scroll class="btn btn-primary saveDevices d-none btn-float-right" role="button">
													Confirmar
												</a>
											</p>
										</div>
									</div>
									<div class="row text-center justify-content-center">
										@foreach($devices as $device)
											<div class="col col-sm-4 col-md-3 col-lg-2 editDevice">
												@if ($device->device_id !== null)
													<input type="hidden" id="device_{{ $device->id }}" value="{{ $device->id }}">
													<p class="text-center"><span class="{{ $device->icon }} add-selected vico-show-equipos item-blocked"></span></p>
													<p class="text-center">{{ $device->name }}</p>
												@else
													<input type="hidden" id="device_{{ $device->id }}" value="0">
													<p class="text-center"><span class="{{ $device->icon }} vico-show-equipos item-blocked"></span></p>
													<p class="text-center">{{ $device->name }}</p>
												@endif
											</div>
										@endforeach
									</div>
								</div>
								<hr>

                                {{--end equipos --}}

                                {{--row rule--}}
                <div class="row d-none">
                  <div class="col-12">
                    <div class="row">
											<div class="col-3">
												<a onclick="confirmRules()"
													data-scroll class="btn btn-primary" role="button">
													Guardar
												</a>
											</div>
											<p class="col-9 h4 mb-4 vico-color">Reglas</p>
										</div>
										<div class="row">
											@foreach($rules as $rule)
												<div class="col-2">
													<div class="form-group">
														@if ($rule->rule_id !== null)
															<label for="rule_{{ $rule->id }}">
																{{ $rule->description }}
																<input checked type="checkbox" id="rule_{{ $rule->id }}">
															</label>
														@else
															<label for="rule_{{ $rule->id }}">
																{{ $rule->description }}
																<input type="checkbox" id="rule_{{ $rule->id }}">
															</label>
														@endif
													</div>
												</div>
											@endforeach
										</div>
									</div>
                </div>

								{{--end rules--}}
                            </div>

            			{{--end container fluid--}}

                    </div>

                </div>

    		{{--end main--}}

        </div>

	{{--end container--}}

    {{--start modals--}}

        {{--start rooms gallery--}}

            <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Images_House">

                <div class="modal-dialog modal-lg">

                    <div class="modal-content modal-content-ajax">

                        <!-- Modal Header -->
                        <div class="modal-header align-items-center">
                            <p class="h4 modal-title">{{$house->name}}</p>
                            <button type="button" class="close" data-dismiss="modal"><span class="icon-close"></span></button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">

                            @foreach($house->main_image as $img)
                            <figure>
                                <img style="width: 100%;"src="https://fom.imgix.net/{{ $img->image }}?w=1280&h=853&fit=crop" class="img-responsive" alt="Responsive image">
                            </figure>
                            @endforeach

                        </div>
                        <!-- Modal footer -->

                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        </div>

                    </div>

                </div>

            </div>

        {{--end rooms gallery--}}

		{{--MODAL CHANGES--}}
			<div class="modal fade" style="overflow:scroll" id="modal-changes" tabindex="-1" role="dialog" aria-labelledby="modal_changes">
				<input type="hidden">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h2>Actualizar datos</h2>
							<input type="hidden" name="manager_id" value="{{ Auth::user()->id }}">
							<input type="hidden" name="manager_name" value="{{ Auth::user()->name }}">
							<input type="hidden" name="house_name" value="{{ $house->name }}">
						</div>
						<div class="modal-body">
							<form accept-charset="UTF-8" enctype="multipart/form-data">
								<div class="form-group">
									<label for="#new-rooms">
										Número de Habitaciones
									</label>
									<input type="number" class="form-control" id="new-rooms" placeholder="{{ $house->rooms_quantity }}">
									<input type="hidden" name="oldRooms" value="{{ $house->rooms_quantity }}">
								</div>

								<div class="form-group">
									<label for="#new-baths">
										Número de baños
									</label>
									<input type="number" class="form-control" id="new-baths" placeholder="{{ $house->baths_quantity }}">
									<input type="hidden" name="oldBaths" value="{{ $house->baths_quantity }}">
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
										<option value="Casa">Casa</option>
										<option value="Apartamento" selected>Apartamento</option>
										@endif
									</select>
									<input type="hidden" name="oldType" value="{{ $house->type }}">
								</div>

								<div class="form-group">
									<label for="#new-address">
										Dirección
									</label>
									<input type="text" class="form-control" id="new-address" placeholder="{{ $house->address }}">
									<input type="hidden" name="oldAddress" value="{{ $house->address }}">
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
		{{--MODAL CHANGES END--}}

		{{-- start ajax loader--}}
			{{-- <button style="display: none" type="button" id="ajaxShow" class="btn btn-primary" data-toggle="modal" data-target="#ajax-modal">
			</button>
			<div class="modal fade" id="ajax-modal" tabindex="-1" role="dialog" aria-labelledby="ajaxModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="ajaxModalLabel">Estamos procesado la petición</h5>
							<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button> -->
						</div>
						<div class="modal-body">
							<div id="wait">
								<img src='../../../ajax-loader.gif' /><br>
							</div>
						</div>
						<div class="modal-footer">
							<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary">Save changes</button> -->
						</div>
					</div>
				</div>
			</div> --}}
		{{--end ajax loader --}}

	{{--end modals--}}

@endsection
