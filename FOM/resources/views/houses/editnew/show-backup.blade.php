@extends('layouts.app')

@section('title', $house->name)

@section('content')

	@section('meta')

		<meta property="og:image" content="https://fom.imgix.net/{{$house->main_image[0]->image }}?w=1200&h=628&fit=crop" />

	@endsection

	@section('styles')

		<style type="text/css">

			.popover{
    			width: 100%;
    			z-index: auto;
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
    		@media screen and (min-width: 375px){
    	    .star-rating .star {
    	      /* padding: 3px 3px 3px 0px; */
    	      color: #ddd;
    	      text-shadow: .05em .05em #aaa;
    	      list-style-type: none;
    	      display: inline-block;
    	      cursor: pointer;
    	      font-size: 1.75em;
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
    	      font-size: 1.5em;
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
    			padding-top: 75px;
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

    		.popover{
        			z-index:1151 !important;
        		}
		</style>

	@endsection

	{{--start foto--}}

    	<div class="row vico-body" style="padding:0px; margin:0px">

            @if($house->status==5)

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
            		@forelse($house->main_image as $img)
            		<div class="carousel-cell">
            			<a data-toggle="modal" data-target=".house-gallery" ><img style="border-radius: 0 !important;" class="dblock w-100" src="https://fom.imgix.net/{{ $img->image }}?w=750&h=500&fit=crop" alt="{{$img->image}}slide"></a>
            		</div>
            		@empty
            		@endforelse
            	</div>

            	<a style="margin-top: -5rem" class="vico-show-carousel-gallery-mobile" data-toggle="modal" data-target=".house-gallery">
                    <h4 class="vico-show-carousel-gallery-mobile-button">
                        Editar fotos
                        <span class="icon-gallery" style="color: white;"></span>
                    </h4>
            	</a>

            	{{--End VicoCarousel--}}

            </div>

            {{-- Col-6 --}}

                <div class="col-md-6 col-12 d-none d-md-block" style="padding:0px; margin:0px">
                	<a data-toggle="modal" data-target=".house-gallery" >
                		<img src="{{'https://fom.imgix.net/'.$house->main_image[0]->image }}?w=750&h=500&fit=crop" class="img-fluid" alt="Responsive image">
                    </a>
            	</div>

            {{-- Col-6 --}}

            <div class="col-md-6 d-none d-md-block" style="padding:0px; margin:0px">

        		@for($i=1;$i<=4;$i++)

        		    <div class="col-md-6 float-left " style="padding:0px; margin:0px;">

        			    <a data-toggle="modal" data-target=".house-gallery" >

        				<img src="{{'https://fom.imgix.net/'.$house->main_image[$i]->image }}?w=750&h=500&fit=crop" class="img-fluid" alt="Responsive image"></a>

                        {{-- Overlay Gallery --}}

        				@if($i==4)

            				<a  class="vico-show-overlay-second-gallery" data-toggle="modal" data-target=".house-gallery">
                                <h4 class="vico-show-overlay-second-gallery-header">
                                    Editar fotos
                                    <span class="icon-gallery" style="color: white;"></span>
                                </h4>
            				</a>

        				@endif

        				{{-- Overlay Gallery END --}}

        		    </div>

        		@endfor

        	</div>

        </div>

    {{--end foto--}}

    {{--start container--}}

        <div class="p-lg-5">

        	{{--start main--}}

            	<div class="row mr-1">

            		<div class="col-12">

            			{{--start container fluid--}}

                            <div class="container-fluid">

                				{{--start ROW Descripction VICO--}}

                    				<div class="row">

                    					<div class="col-md-8 col-12 mt-4">

                    						<p class="h1 text-uppercase">
                    							{{$house->name}}
                    						</p>

                    						<p class="h4 mb-2">
                                                <span class="icon-location" style="font-size: 1.2rem"></span> Barrio {{$neighborhood->name}}
                                            </p>

                    						<div class="row justify-content-between">

												<div class="col-4 pr-0">
													<ul class="list-group bullet-points-off">
														<li>
															<p>
																<span class="icon-z-bed"></span> {{ $house->rooms_quantity}} habitaciones
															</p>
														</li>
													</ul>
												</div>

												<div class="col-4 pr-0">
													<ul class="list-group bullet-points-off">
														<li>
															<p>
																<span class="icon-z-bathroom-2"></span>
																{{$house->baths_quantity}} Baños.
															</p>
														</li>
													</ul>
												</div>

												<div class="col-4 pr-0">
													<ul class="list-group bullet-points-off">
														<li>
															<p>
																<span class="icon-z-zbuilding"></span> {{$house->type}}
															</p>
														</li>
													</ul>
												</div>

                    						</div>

											<p class="h4 mb-4">
												<span class="icon-z-date"></span>

												@if(strtotime($today) >= strtotime($house->min_date))
												Disponiblidad ahora
												@else
												Disponibilidad: {{date('d/m/y', strotime($house->Rooms->min('available_from')))}}
												@endif

											</p>

                                            <p class="h4 mb-4 vico-color">¿Quieres cambiar estos datos? Solicita el cambio.</p>

                    					</div>

                    				</div>

                                    <hr>

                				{{--end ROW Descripction VICO --}}

                                {{--start ROOM SECTION--}}

                                    <div class="row" id="rooms-section">

                                        <div class="col-12">

                                            <div class="row">
												<div class="col-9  mb-4">
													<p class="h4 vico-color">Habitaciones <small >({{$house->rooms_quantity}})</small></p>
													<div class="card">
														<div class="card-header">
															<a class="card-link" data-toggle="collapse" href="javascript:void(0);">
																<div class="container">
																	<div class="row">
																		<div class="col-sm">
																			#
																		</div>
																		<div class="col-sm">
																			Nombre
																		</div>
																		<div class="col-sm">
																			Precio
																		</div>
																		<div class="col-sm">
																			Disponible
																		</div>
																		<div class="col-sm">
																			Ocupado
																		</div>
																	</div>
																</div>
															</a>
														</div>
													</div>
													@foreach ($house->Rooms as $room)
													<div class="card">
														<div class="card-header">
														<a class="card-link" data-toggle="collapse" href="#collapse_{{$room->id}}">
															<div class="container">
																<div class="row">
																	<div class="col-sm">
																		{{$room->number}}
																	</div>
																	<div class="col-sm">
																		@if ($room->nickname != null)
																		{{$room->nickname}}
																		@else
																		Habitacion #{{$room->number}}
																		@endif
																	</div>
																	<div class="col-sm">
																		{{$room->price}}
																	</div>
																	<div class="col-sm">
																		{{$room->available_from}}
																	</div>
																	<div class="col-sm">
																		@if(isset($room->occupant))
																		{{$room->occupant}}
																		@else
																		No hay nadie
																		@endif
																	</div>
																</div>
															</div>
														  </a>
														</div>
														<div id="collapse_{{$room->id}}" class="collapse show accordion_room" data-parent="#accordion">
															<div class="card-body">
																<div id="description_room_{{$room->id}}" class="container">
																	<div class="row">
																		<div class="col-sm">
																			@if (isset($room->occupant))
																				{{$room->occupant}} vive aqui hasta {{$room->occupant_date}}
																			@elseif(isset($room->next_occupant))
																				{{$room->next_occupant}} llega el {{$room->next_occupant_date}}
																			@else
																				@if (sizeof($room->bookings) >= 1)
																					@php
																						$next_occupant_exist=false;
																					@endphp
																					@foreach ($room->bookings as $booking)
																						@if(\Carbon\Carbon::now()->toDateTimeString() <= $booking->date_from)
																							{{$booking->name}} llega el {{$booking->date_from}}
																							@php
																								$next_occupant_exist=true;
																							@endphp
																							@break
																						@endif
																					@endforeach
																					@if (!$next_occupant_exist)
																						No tiene proximos habitantes
																					@endif
																				@else
																				No tiene proximos habitantes
																				@endif
																			@endif
																		</div>
																		<div class="col-sm">
																			<button type="button" value="{{$room->id}}" class="btn btn-primary edit_booking_btn">Editar ></button>
																		</div>
																	</div>
																	<div class="row">
																		@php
																			$devices_room='Cuenta con ';
																			$devices_room=$devices_room.'cama '.$room->devices->bed_type.',';
																			$devices_room=$devices_room.'baño '.$room->devices->bath_type.',';
																		@endphp
																		@if ($room->devices->desk === 1)
																			@php
																				$devices_room=$devices_room.'escritorio,';
																			@endphp
																		@endif
																		@if ($room->devices->tv === 1)
																			@php
																				$devices_room=$devices_room.'televisor,';
																			@endphp
																		@endif
																		@if ($room->devices->closet === 1)
																			@php
																				$devices_room=$devices_room.'closet,';
																			@endphp
																		@endif
																		@if ($room->devices->windows_type === 'adentro')
																			@php
																			$devices_room=$devices_room.'ventana hacia adentro';
																			@endphp
																		@elseif($room->devices->windows_type === 'afuera')
																			@php
																			$devices_room=$devices_room.'ventana hacia afuera';
																			@endphp
																		@elseif($room->devices->windows_type === 'patio')
																			@php
																			$devices_room=$devices_room.'ventana hacia un patio';
																			@endphp
																		@elseif($room->devices->windows_type === 'sin_ventana')
																			@php
																			$devices_room=$devices_room.'sin ventana';
																			@endphp
																		@endif

																		<div class="col-sm">{{$devices_room}}</div>

																		<div class="col-sm">
																			<a href="/rooms/edit/{{$room->id}}" class="btn btn-primary">Editar ></a>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-sm">
																			Vale {{$room->price}} COP
																		</div>
																		<div class="col-sm">
																			<a href="/rooms/edit/{{$room->id}}" class="btn btn-primary">Editar ></a>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-sm">
																			Cuenta con {{$room->count_images}} imagenes
																		</div>
																		<div class="col-sm">
																			<a href="/rooms/edit/{{$room->id}}" class="btn btn-primary">Editar ></a>
																		</div>
																	</div>
																</div>
																<div id="description_bookings_{{$room->id}}" class="container" style="display:none">
																	<div class="row">
																		<div class="col-sm">
																			<button type="button" class="btn btn-primary back_booking" value="{{$room->id}}">< Atras</button>
																		</div>
																	</div>
																	<div class="row">
																		@if (isset($room->occupant))
																			<div class="col-sm">
																				@if($room->occupant_gender === 2)
																					<img style="height: 90px; width: 90px" src="../../images/homemates/girl.png" alt="girl" srcset="../../images/homemates/girl@2x.png 2x, ../images/homemates/girl@3x.png 3x" />
																					<small ><img class=" vico-show-habitant-flag" style="bottom: 2rem !important" src="../../images/flags/{{$room->occupant_icon}}"></small>
																				@else
																					<img style="height: 90px; width: 90px" src="../../images/homemates/boy.png" alt="boy" srcset="../../images/homemates/boy@2x.png 2x, ../images/homemates/boy@3x.png 3x" />
																					<small ><img class=" vico-show-habitant-flag" style="bottom: 2rem !important" src="../../images/flags/{{$room->occupant_icon}}"></small>
																				@endif
																			</div>
																			<div class="col-sm">
																				{{$room->occupant}} vive aqui hasta el
																			</div>
																			<div class="col-sm">
																				<input type="date" class="form-control" id="date_to_{{$room->occupant_booking}}" value={{$room->occupant_date}} disabled>
																			</div>
																			<div class="col-sm">
																				<button type="submit" value="{{$room->occupant_booking}}" class="btn btn-primary edit_booking_date">Editar Fecha</button>
																				@if ($room->occupant_status != 100)
																				<a href="/booking/show/{{$room->occupant_booking}}"><br class="d-block"> Ver Solicitud ></a>
																				@endif
																			</div>
																		@elseif(isset($room->next_occupant))
																			<div class="col-sm">
																				@if($room->next_occupant_gender === 2)
																					<img style="height: 90px; width: 90px" src="../../images/homemates/girl.png" alt="girl" srcset="../../images/homemates/girl@2x.png 2x, ../../images/homemates/girl@3x.png 3x" />
																					<small ><img class=" vico-show-habitant-flag" style="bottom: 2rem !important" src="../../images/flags/{{$room->next_occupant_icon}}"></small>
																				@else
																					<img style="height: 90px; width: 90px" src="../../images/homemates/boy.png" alt="boy" srcset="../../images/homemates/boy@2x.png 2x, ../../images/homemates/boy@3x.png 3x" />
																					<small ><img class=" vico-show-habitant-flag" style="bottom: 2rem !important" src="../../images/flags/{{$room->next_occupant_icon}}"></small>
																				@endif
																			</div>
																			<div class="col-sm">
																				{{$room->next_occupant}} llega el {{$room->next_occupant_date}}
																				@if ($room->next_occupant_status != 100)
																				<a href="/booking/show/{{$room->next_occupant_booking}}"><br class="d-block"> Ver Solicitud ></a>
																				@endif
																			</div>
																		@endif
																	</div>

																	@if (sizeof($room->bookings) >= 1)
																		@foreach ($room->bookings as $booking)
																			@if(\Carbon\Carbon::now()->toDateTimeString() <= $booking->date_from)
																			<div class="row">
																				<div class="col-sm">
																					@if($booking->gender === 2)
																						<img style="height: 90px; width: 90px" src="../../images/homemates/girl.png" alt="girl" srcset="../../images/homemates/girl@2x.png 2x, ../../images/homemates/girl@3x.png 3x" />
																						<small ><img class=" vico-show-habitant-flag" style="bottom: 2rem !important" src="../../images/flags/{{$booking->icon}}"></small>
																					@else
																						<img style="height: 90px; width: 90px" src="../../images/homemates/boy.png" alt="boy" srcset="../../images/homemates/boy@2x.png 2x, ../../images/homemates/boy@3x.png 3x" />
																						<small ><img class=" vico-show-habitant-flag" style="bottom: 2rem !important" src="../../images/flags/{{$booking->icon}}"></small>
																					@endif
																				</div>
																				<div class="col-sm">
																					{{$booking->name}} llega el {{$booking->date_from}}
																					@if ($booking->status != 100)
																					<a href="/booking/show/{{$booking->id}}"><br class="d-block"> Ver Solicitud ></a>
																					@endif
																				</div>
																			</div>
																			@endif
																		@endforeach
																	@endif
																	<div class="row">
																		<div class="col-slm" style="width: 350px">
																		{!! $room->info_dates !!}
																		</div>
																	</div>

																</div>
															</div>
														</div>
													</div>
													@endforeach
												</div>
                                                <div class="col-3">
                                                    <a data-scroll class="btn btn-primary  text-center p-0" style="width: 45%" href="#" role="button">
                                                        Editar
                                                    </a>
                                                </div>
                                            </div>
											<div class="modal fade" id="edit_date_booking_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
															<input class="form-control"  id="new_date_booking" autocomplete="off" readonly>
														</div>
														<div class="modal-footer">
														  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
														  <button type="button" class="btn btn-primary" id="upload_date_booking">Guardar Fecha</button>
														</div>
													</div>
												</div>
											</div>

											<div class="modal fade" id="alert_upload_date" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog" role="document">
														<div class="modal-content">
															<div class="modal-header">
															</div>
															<div class="modal-body">
																<label for="">¿Esta seguro que quiere cambiar esta fecha?</label><br>
														  		<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
														  		<button type="button" class="btn btn-primary" id="confirm_upload">Si</button>
															</div>
															<div class="modal-footer">
															</div>
														</div>
													</div>
											</div>



                                            {{-- ROW START --}}
                                            <div class="row justify-content-between">

                                                <!-- codigo Josue -->

                                            </div>
                                            {{-- ROW END --}}

                                        </div>

                                    </div>

                                    <hr>

                                {{--end ROOM SECTION--}}

                                {{--start Admin Card--}}

                                    <div class="row">

                                        <div class="col-lg-12">

											<div class="row">

                                                <p class="col-9 h4 mb-4 vico-color">Más información</p>

                                                <div class="col-3">
                                                    <a data-scroll class="btn btn-primary  text-center p-0" style="width: 45%" href="#" role="button">
                                                        Editar
                                                    </a>
                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-3 text-center">
                                                    <img class="img-responsive rounded-circle vico-show-admin-card-picture mb-2" src="https://fom.imgix.net/{{$manager[0]->image}}?w=500&h=500&fit=crop" alt="Administrador">
                                                </div>

												<div class="col-9 text-center">

													<p class="h5">{{$manager[0]->name}}</p>

													<div class="col-12 reviewComment">
														{{--Funcionalidad del ver más--}}
														<p class="d-inline viewLessReview">{{str_limit($manager[0]->description, $limit = 250, $end='...')}}</p>
														<p class="d-none viewMoreReview" >{{$manager[0]->description}}</p>
													</div>

												</div>

                                            </div>

                                        </div>

                                    </div>

									<hr>

                                {{--end Admin Card--}}

                                {{--start mas informacion--}}

                    				<div class="row">

                    					<div class="col-12">

                                            <div class="row">
                                                <p class="col-9 h4 mb-4 vico-color">Descripción de la VICO</p>

                                                <div class="col-3">
                                                    <a data-scroll class="btn btn-primary  text-center p-0" style="width: 45%" href="#" role="button">
                                                        Editar
                                                    </a>
                                                </div>
                                            </div>


                    						<p>{!! nl2br($house->description_house) !!}<br>{!! nl2br($house->description) !!}</p>

                    					</div>

                    				</div>

                                    <hr>

                                {{--end mas informacion--}}

                                {{--start ROW Acerca del Barrio--}}

                    				<div class="row">

                    					<div class="col-12">

                                            <div class="row">

                                                <p class="col-9 h4 mb-4 vico-color">Acerca del barrio</p>

                                                <div class="col-3">
                                                    <a data-scroll class="btn btn-primary  text-center p-0" style="width: 45%" href="#" role="button">
                                                        Editar
                                                    </a>
                                                </div>

                                            </div>

                    						<p>{!! nl2br($house->description_zone) !!}<br>{!! nl2br($house->description2) !!}</p>

                    					</div>

                    				</div>

                                    <hr>

                                {{--end row Acerca del Barrio--}}

                                {{--start row equipos --}}

                    				<div class="row">

                    					<div class="col-12">

                                            <div class="row">

                                                <p class="col-9 h4 mb-4 vico-color">Equipos</p>

                                                <div class="col-3">
                                                    <a data-scroll class="btn btn-primary  text-center p-0" style="width: 45%" href="#" role="button">
                                                        Editar
                                                    </a>
                                                </div>

                                            </div>

                    						<div class="row">

                    							<div class="col-12 text-center p-0">
                    								<ul class="pl-2">
                    									@foreach($devices as $device)
                    									<li class="d-inline-block vico-show-equipment-list m-md-3">
                    										<span class="{{ $device->icon }} vico-show-equipos"></span>
                    										<br><p>{{ $device->name }}</p>
                    									</li>
                    									@endforeach
                    								</ul>
                    							</div>

                    						</div>

                    					</div>

                    				</div>

                                    <hr>

                                {{--end row equipos --}}

                                {{--row Rules start --}}

                                    <div class="row">

                		                <div class="col-12">

                                            <div class="row">

                                                <p class="col-9 h3 mb-4 vico-color">Reglas</p>

                                                <div class="col-3 text-justify">
                                                    <a data-scroll class="btn btn-primary  text-center p-0" style="width: 45%" href="#" role="button">
                                                        Editar
                                                    </a>
                                                </div>

                                            </div>

                    						<div class="row">

                								@for($i = 0; $i < count($rules) && $rule = $rules[$i]; $i+=2)

                									@if($i>14)
                										@break
                									@endif

                									<div class="col-12 col-lg-4 col-md-6 card vico-show-rule-card">
                										<div class="row">

                											<div class="col-3" style="text-align: right;">
                												@if($rule->icon === 6)
        															@if($rule->description==0)
        																<img style="height: 64px; width: 64px" src="../../images/rules/independent.png" alt="independent" srcset="../../images/rules/independent@2x.png 2x, ../../images/rules/independent@3x.png 3x" />
        															@else
        																<img style="height: 64px; width: 64px" src="../../images/rules/family.png" alt="family" srcset="../../images/rules/family@2x.png 2x, ../../images/rules/family@3x.png 3x" />
        															@endif
                												 @else
                													<img style="height: 64px; width: 64px" src="../../images/rules/{!! $rule->icon_span !!}.png" alt="{!! $rule->icon_span !!}" srcset="../../images/rules/{!! $rule->icon_span !!}@2x.png 2x, ../../images/rules/{!! $rule->icon_span !!}@3x.png 3x" />
                												@endif
                											</div>

                											<div class="col-9">
                												<ul class="bullet-points-off align-middle ">
                    												<li class="text-uppercase font-weight-bold">

                    													@if($rule->icon === 1 )

                															@if($rule->description == 0) No aplica @elseif($rule->description==14) 2 Semanas @elseif($rule->description==30) 1 mes @elseif($rule->description == 360) No aplica @else {{$rule->description}}
																			@endif

                    														{{-- Deposito --}}
                    														@elseif($rule->icon === 2)
                    																1 Renta mensual
                    														{{-- Tiempo minimo de estancia  || Tiempo para salir --}}
                    															@elseif($rule->icon === 3 || $rule->icon === 8 )
                    																	@if($rule->description == 30) 1 mes @elseif($rule->description==14) 2 Semanas  @elseif($rule->description == 60) 2 meses @elseif($rule->description == 90) 3 meses @elseif($rule->description == 120) 4 meses  @elseif($rule->description == 150) 5 meses @elseif($rule->description == 180) 6 meses    @elseif($rule->description == 210) 7 meses  @elseif($rule->description == 240) 8 meses  @elseif($rule->description == 270) 9 meses  @elseif($rule->description == 300) 10 meses  @elseif($rule->description == 330) 11 meses  @elseif($rule->description == 360) 12 meses @else {{$rule->description}} @endif
                    																{{-- Aseo en zona sociales || Alimentación--}}
                    																@elseif($rule->icon === 4)
                    																		@if($rule->description==0) No incluye @else Incluye @endif
                    																	{{-- Servicios incluidos --}}
                    																	@elseif($rule->icon===5)
                    																			@if($rules[8]->description == 1) Internet, @else @endif
                    																				@if($rules[9]->description == 1) Gas, @else @endif
                    																					@if($rules[10]->description == 1) Agua, @else @endif
                    																						@if($rules[11]->description == 1) Electricidad @else @endif
                    																							@if($rules[8]->description == 0 &&  $rules[9]->description == 0 && $rules[10]->description == 0 && $rules[11]->description == 0 ) No incluye @else @endif
                    																		@elseif($rule->icon === 6 )
                    																				@if($rule->description==0) VICO independiente @else VICO de familia @endif
                    																			{{-- Valor adicional por huesped --}}
                    																			@elseif($rule->icon===7)
                    																				@if($rule->description == 0) Gratis @else {{$rule->description}} @endif
                    													@else
                    														{{$rule->description}}
                    													@endif

                    												</li>

                    												<li class="font-weight-light" style="word-wrap: break-word; line-height: 1.2">
                													<small>
                													@if($rule->icon === 6 )
                														@if($rule->description==0)Aquí exclusivamente viven estudiantes y jóvenes profesionales.
                														@else En esta VICO vive una familia colombiana, que comparte sus espacios con estudiantes y jóvenes profesionales.
                														@endif
                													@else
                														{{$rule->name}}
                													@endif
                													</small>
                												</li>
    															</ul>
    														</div>
    													</div>
    												</div>

                								@endfor

                							</div>

                						</div>

                					</div>

            					{{--end row rules--}}

                            </div>

            			{{--end container fluid--}}

                    </div>

                </div>

    		{{--end main--}}

        </div>

	{{--end container--}}

    {{--start map--}}

        <div class="" id="map"></div>

    {{--end map--}}

    {{--start modals--}}

        {{--start house gallery--}}

            <div class="modal fade house-gallery" tabindex="-1" role="dialog" aria-labelledby="Images_House">

                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
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

        {{--end house gallery--}}

        {{--start modal rooms gallery--}}

            <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Images_House">

                <div class="modal-dialog modal-lg">

                    <div class="modal-content">

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

        {{--end modal rooms gallery--}}

    {{--end modals--}}

    @section('scripts')

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4_XvxW91t7uHIL6tzmacsoIX17gHUIgM" defer></script>
        <script src="{{ asset('js/angular.min.js') }}" charset="utf-8"></script>
        <script src="{{ asset('js/prefixfree.min.js') }}" charset="utf-8"></script>

		<script type="text/javascript">
			var id_booking_editing;
			$(".info_dates").each(function(){
				$(this).css("display", "block");
			});

			$(".create-vico").each(function(){
				$(this).html('');
			});

			$(".edit_booking_btn").each(function(){
				$(this).on('click',function(){
					$("#description_room_"+$(this).val()).css("display",'none');
					$("#description_bookings_"+$(this).val()).css("display",'block');
				});
			});

			$(".back_booking").each(function(){
				$(this).on('click',function(){
					$("#description_room_"+$(this).val()).css("display",'block');
					$("#description_bookings_"+$(this).val()).css("display",'none');
				});
			});

			$("#new_date_booking").datepicker({
				dateFormat: "yy-mm-dd",
				showButtonPanel: true
      		});

			$(".edit_booking_date").each(function(){
				$(this).on('click',function(){
					id_booking_editing=$(this).val();
					$("#new_date_booking").val($("#date_to_"+id_booking_editing).val());
					$("#edit_date_booking_modal").modal('show');
				});
			});

			// $("#new_date_booking").on('focus',function(){
			// 	$("#ui-datepicker-div").css('position','absolute');
			// 	$("#ui-datepicker-div").css('top','795px');
			// });

			$("#upload_date_booking").on('click',function(){
				$("#alert_upload_date").modal('show');
				$("#edit_date_booking_modal").modal('hide');
			});

			$("#confirm_upload").on('click',function(){
				var new_date=$("#new_date_booking").val();
				$("#date_to_"+id_booking_editing).val(new_date);
				var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
				$.ajax({
			        url: '/booking/updateDateTo',
			        type: 'POST',
			        data: {
						_token: CSRF_TOKEN,
						new_date: new_date,
						booking_id: id_booking_editing
					},
			        success: function (data) {
						if(data){
							$("#alert_upload_date").modal('hide');
							$("#date_to_"+id_booking_editing).val(new_date);
							alert('Fecha cambiada');
						}
			  		}
			    });
			});

			$(".accordion_room").each(function(){
				$(this).collapse('hide');
			});

        	var map;
        	$(document).ready(function(){
        		$('.navbar').addClass('fixed-top');
        		ajax_houses();
        	});
        	function changeOther(value, id){
        		var itemName = "otherDiv" + id;
        		var item = document.getElementById(itemName);
        		if(value == "¿Otro?"){
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

        <script type="text/javascript">

            $('.info_dates').each(function(){
            	$(this).popover({
            	title:"Disponibilidad",
            	trigger: "click" ,
              	placement: 'bottom',
              	html:true,
              	content: function() {return $("#"+$(this).attr('id')+'_popover').html();}
             	});
            });

        </script>

        {{-- view more / less functionallity --}}
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
        		title:"Disponibilidad",
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
            	  submit.className = "btn btn-link ajaxSubmitLike btn-favorite-on-house-view";
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
            			  submit.className = "btn btn-link ajaxSubmitLike btn-favorite-on-house-view";
            			}
            		  }
            		});
            	}
              });
            });

            @endif

        </script>

    @endsection

@endsection
