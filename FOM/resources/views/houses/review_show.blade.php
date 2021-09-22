
{{-- TITTLE --}}
<div class="row">
	<div class="col-12">
		<p class="h4 pt-4 pr-1 vico-color d-inline">
			{{$reviewCount}} reseñas de esta VICO 
		</p>
		@if($reviews_house->count() > 0)
			<p class="d-inline">
				<div class="star-rating">
					@for($i = 0; $i < 5; $i++)
						@if($i < $reviews_house[0]->global)
							<li class="star filled global-rating">
								<i class=""></i>
							</li>
						@else
							<li class="star-little star global-rating">
								<i class=""></i>
							</li>
						@endif

					@endfor
				</div>
			</p>
		@endif
	</div>
</div>
{{--END TITTLE--}}

{{--VALIDATE IF THERE'S MORE THAN ONE REVIEW --}}
@if(count($reviews_house) > 0)
	{{-- REVIEW'S MAIN ROW--}}
	<div class="row mb-4" justify-content-around>
		{{--REVIEW COL--}}
		<div class="col-md-6 col-sm-12">
			{{--EACH REVIEW COL--}}
			<div class="row form-inline my-2">
				{{--REVIEW TITTLE--}}
				<div class="col-6">
					VICO
					{{--POPOVER DESCRIPTION: VICO--}}
					<p class="d-none pr-1">
						<span tabindex="0" class="btn btn-primary popoverVico">?</span>
					</p>
					{{--END POPOVER DESCRIPTION: VICO--}}
				</div>
				{{--END REVIEW TITTLE--}}

				{{--REVIEW STARS--}}
				<div class="star-rating col-6">
					@for($i = 0.0; $i < 5.0; $i+=1.0)
						@if($i < floor($reviews_house[0]->global))
							<li class="star filled">
								<i class=""></i>
							</li>
						@else
							@if($reviews_house[0]->global/10 > 0.5)
								{{$reviews_house[0]->global/10}}
							@else
								<li class="star-little star">
									<i class=""></i>
								</li>
							@endif
						@endif
					@endfor
				</div>
				{{--END REVIEW STARS--}}
			</div>
			{{--END EACH REVIEW COL--}}
			{{--EACH REVIEW COL--}}
			<div class="row form-inline my-2">
				{{--REVIEW TITTLE--}}
				<div class="col col-6">
					Ubicación
					{{--POPOVER DESCRIPTION: UBICACION--}}
					<p class="d-none pr-1">
						<span tabindex="0" class="btn btn-primary popoverLocation">?</span>
					</p>
					{{--END POPOVER DESCRIPTION: UBICACION--}}
				</div>
				{{--END REVIEW TITTLE--}}

				{{--REVIEW STARS--}}
				<div class="star-rating col-6">
					@for($i = 0; $i < 5; $i++)
						@if($i <  $reviews_neighborhood[0]->global)
							<li class="star filled">
								<i class=""></i>
							</li>
						@else
							<li class="star-little star">
								<i class=""></i>
							</li>
						@endif

					@endfor
				</div>
				{{--END REVIEW STARS--}}
			</div>
			{{--END EACH REVIEW COL--}}
			{{--EACH REVIEW COL--}}
			<div class="row form-inline my-2">
				{{--REVIEW TITTLE--}}
				<div class="col-6">
					Relación con el dueño
					{{--POPOVER DESCRIPTION: RELACIÓN CON EL DUEÑO--}}
					<p class="d-none pr-1">
						<span tabindex="0" class="btn btn-primary popoverManager">?</span>
					</p>
					{{--END POPOVER DESCRIPTION: RELACIÓN CON EL DUEÑO--}}
				</div>
				{{--END REVIEW TITTLE--}}

				{{--REVIEW STARS--}}
				<div class="star-rating col-6">
					@for($i = 0; $i < 5; $i++)
						@if($i < $reviews_house[0]->manager_comunication)
							<li class="star filled">
								<i class=""></i>
							</li>
						@else
							<li class="star-little star">
								<i class=""></i>
							</li>
						@endif

					@endfor
				</div>
				{{--END REVIEW STARS--}}
			</div>
			{{--END EACH REVIEW COL--}}
		</div>
		{{--END REVIEW COL--}}

		{{--REVIEW COL--}}
		<div class="col-md-6 col-sm-12">

			{{--EACH REVIEW COL--}}
			<div class="row form-inline my-2">
				{{--REVIEW TITTLE--}}
				<div class="col-6">
					Relación entre roomies
				</div>
				{{--END REVIEW TITTLE--}}
				{{--REVIEW STARS--}}
				<div class="star-rating col-6">
					@for($i = 0; $i < 5; $i++)
						@if($i < $reviews_house[0]->roomies)
							<li class="star filled">
								<i class=""></i>
							</li>
						@else
							<li class="star-little star">
								<i class=""></i>
							</li>
						@endif

					@endfor
				</div>
				{{--END REVIEW STARS--}}
			</div>
			{{--END EACH REVIEW COL--}}

			{{--EACH REVIEW COL--}}
			<div class="row form-inline my-2">
				{{--REVIEW TITTLE--}}
				<div class="col-6">
					Limpieza
				</div>
				{{--END REVIEW TITTLE--}}
				{{--REVIEW STARS--}}
				<div class="star-rating col-6">
					@for($i = 0; $i < 5; $i++)
						@if($i < $reviews_house[0]->experience)
							<li class="star filled">
								<i class=""></i>
							</li>
						@else
							<li class="star-little star">
								<i class=""></i>
							</li>
						@endif

					@endfor
				</div>
				{{--END REVIEW STARS--}}
			</div>
			{{--END EACH REVIEW COL--}}

			{{--EACH REVIEW COL--}}
			<div class="row form-inline my-2">
				{{--REVIEW TITTLE--}}
				<div class="col-6">
					Datos exactos
				</div>
				{{--END REVIEW TITTLE--}}
				{{--REVIEW STARS--}}
				<div class="star-rating col-6">
					@for($i = 0; $i < 5; $i++)
						@if($i < $reviews_house[0]->data)
							<li class="star filled">
								<i class=""></i>
							</li>
						@else
							<li class="star-little star">
								<i class=""></i>
							</li>
						@endif

					@endfor
				</div>
				{{--END REVIEW STARS--}}
			</div>
			{{--END EACH REVIEW COL--}}
		</div>
		{{--END REVIEW COL--}}
	</div>
	{{-- END REVIEW'S MAIN ROW--}}

	{{--USER'S HOUSE COMMENT--}}

	@forelse($qualification_users as $review_user)
		<div class="pb-2 my-1">
			<div class="form-inline d-flex align-items-start">
				<div class="d-inline">
					<div class="" >
						@if($review_user[0]->image != null)
							<img class="img-responsive rounded-circle vico-show-admin-card-mobile-picture" src="https://fom.imgix.net/{{$review_user[0]->image}}?w=500&h=500&fit=crop" style="width: 3rem" alt="Administrador">
						@else
							@if($review_user[0]->gender === 2)
								<img style="height: 90px; width: 90px" src="../images/homemates/girl.png" alt="girl" srcset="../images/homemates/girl@2x.png 2x, ../images/homemates/girl@3x.png 3x" style="width: 3rem" />

							@else
								<img style="height: 90px; width: 90px" src="../images/homemates/boy.png" alt="boy" srcset="../images/homemates/boy@2x.png 2x, ../images/homemates/boy@3x.png 3x" style="width: 3rem" />
							@endif
						@endif
					</div>
				</div>
				<div class="col-8">
					<p style="line-height: 1;"><span class="font-weight-bold">{{$review_user[0]->name}}</span><br>
					<span class="font-weight-light small">Hace {{number_format($review_user[1], 0)}} meses</span> <br>
					<span class="font-weight-light small">{{$review_user[0]->country_name}}</span></p>
				</div>
				<div class="col-12 pl-0 reviewComment">
					{{--Funcionalidad del ver más--}}
					<p class="d-inline viewLessReview">{{str_limit($review_user[0]->house_comment, $limit = 1000, $end='...')}}</p>
					<p class="d-none viewMoreReview" >{{$review_user[0]->house_comment}}</p>
					{{-- <a href="" class="btn btn-link d-inline viewMoreButton" >Ver más</a> --}}

				</div>
			</div>
		</div>
		<hr @if($loop->last) class="d-none"@endif>
		

		{{--EMPTY COMMENTS?--}}
	@empty

	@endforelse
	{{-- END USERS HOUSE COMMENT--}}

	{{-- REVIEWS PAGINATION--}}
	@if(count($qualification_users) > 1)
		{{$qualification_users->links('pagination')}}
	@endif
	{{--IF THERES NOT AT LEAST ONE REVIEW--}}
@else
	{{-- </div> --}}
@endif
 {{-- ======== ROW REVIEWS END ========  --}}
<hr>

@if($reviews_house->count() > 0)
	 {{-- VICO  --}}
	<div class="container d-none" id="vicoQualification">
		<div class="row form-inline my-2">
			<div class="col">
				Limpieza
			</div>
			<div class="star-rating">
				@for($i = 0; $i < 5; $i++)
					@if($i < $reviews_house[0]->experience)
						<li class="star filled">
							<i class=""></i>
						</li>
					@else
						<li class="star-little star">
							<i class=""></i>
						</li>
					@endif
				@endfor
			</div>
		</div>
		<div class="row form-inline my-2">
			<div class="col">
				Datos
			</div>
			<div class="star-rating">
				@for($i = 0; $i < 5; $i++)
					@if($i < $reviews_house[0]->global)
						<li class="star filled">
							<i class=""></i>
						</li>
					@else
						<li class="star-little star">
							<i class=""></i>
						</li>
					@endif
				@endfor
			</div>
		</div>
		<div class="row form-inline my-2">
			<div class="col">
				Dispositivos
			</div>
			<div class="star-rating">
				@for($i = 0; $i < 5; $i++)
					@if($i < $reviews_house[0]->global)
						<li class="star filled">
							<i class=""></i>
						</li>
					@else
						<li class="star-little star">
							<i class=""></i>
						</li>
					@endif
				@endfor
			</div>
		</div>
		<div class="row form-inline my-2">
			<div class="col">
				wifi
			</div>
			<div class="star-rating">
				@for($i = 0; $i < 5; $i++)
					@if($i < $reviews_house[0]->global)
						<li class="star filled">
							<i class=""></i>
						</li>
					@else
						<li class="star-little star">
							<i class=""></i>
						</li>
					@endif
				@endfor
			</div>
		</div>
		<div class="row form-inline my-2">
			<div class="col">
				Baños
			</div>
			<div class="star-rating">
				@for($i = 0; $i < 5; $i++)
					@if($i < $reviews_house[0]->global)
						<li class="star filled">
							<i class=""></i>
						</li>
					@else
						<li class="star-little star">
							<i class=""></i>
						</li>
					@endif
				@endfor
			</div>
		</div>
		<div class="row form-inline my-2">
			<div class="col">
				Roomies
			</div>
			<div class="star-rating">
				@for($i = 0; $i < 5; $i++)
					@if($i < $reviews_house[0]->global)
						<li class="star filled">
							<i class=""></i>
						</li>
					@else
						<li class="star-little star">
							<i class=""></i>
						</li>
					@endif
				@endfor
			</div>
		</div>
		<div class="row form-inline my-2">
			<div class="col">
				Ambiente
			</div>
			<div class="star-rating">
				@for($i = 0; $i < 5; $i++)
					@if($i < $reviews_house[0]->global)
						<li class="star filled">
							<i class=""></i>
						</li>
					@else
						<li class="star-little star">
							<i class=""></i>
						</li>
					@endif
				@endfor
			</div>
		</div>
	</div>
	 {{-- LOCATION  --}}
	<div class="container d-none" id="locationQualification">
		<div class="row form-inline my-2">
			<div class="col">
				General
			</div>
			<div class="star-rating">
				@for($i = 0; $i < 5; $i++)
					@if($i < $reviews_neighborhood[0]->general)
						<li class="star filled">
							<i class=""></i>
						</li>
					@else
						<li class="star-little star">
							<i class=""></i>
						</li>
					@endif
				@endfor
			</div>
		</div>
		<div class="row form-inline my-2">
			<div class="col">
				Acceso
			</div>
			<div class="star-rating">
				@for($i = 0; $i < 5; $i++)
					@if($i < $reviews_neighborhood[0]->access)
						<li class="star filled">
							<i class=""></i>
						</li>
					@else
						<li class="star-little star">
							<i class=""></i>
						</li>
					@endif
				@endfor
			</div>
		</div>
		<div class="row form-inline my-2">
			<div class="col">
				Tiendas
			</div>
			<div class="star-rating">
				@for($i = 0; $i < 5; $i++)
					@if($i < $reviews_neighborhood[0]->shopping)
						<li class="star filled">
							<i class=""></i>
						</li>
					@else
						<li class="star-little star">
							<i class=""></i>
						</li>
					@endif
				@endfor
			</div>
		</div>
	</div>
	 {{-- MANAGER  --}}
	<div class="container d-none" id="managerQualification">
		<div class="row form-inline my-2">
			<div class="col">
				Compromiso
			</div>
			<div class="star-rating">
				@for($i = 0; $i < 5; $i++)
					@if($i < $reviews_house[0]->manager_compromise)
						<li class="star filled">
							<i class=""></i>
						</li>
					@else
						<li class="star-little star">
							<i class=""></i>
						</li>
					@endif
				@endfor
			</div>
		</div>
		<div class="row form-inline my-2">
			<div class="col">
				Comunicación
			</div>
			<div class="star-rating">
				@for($i = 0; $i < 5; $i++)
					@if($i < $reviews_house[0]->manager_comunication)
						<li class="star filled">
							<i class=""></i>
						</li>
					@else
						<li class="star-little star">
							<i class=""></i>
						</li>
					@endif
				@endfor
			</div>
		</div>
	</div>
@endif
<script type="text/javascript">
$('.popoverVico').popover({
	title:"<b>Detalles</b> - VICO",
	trigger: "focus" ,
	placement: 'bottom',
	html:true,
	content: function() {return $('#vicoQualification').html();}
});

$('.popoverLocation').popover({
	title:"<b>Detalles</b> - Ubicación",
	trigger: "focus" ,
	placement: 'bottom',
	html:true,
	content: function() {return $('#locationQualification').html();}
});

$('.popoverManager').popover({
	title:"<b>Detalles</b> - Manager",
	trigger: "focus" ,
	placement: 'bottom',
	html:true,
	content: function() {return $('#managerQualification').html();}
});
$('.star i').html("&#9733");

</script>
