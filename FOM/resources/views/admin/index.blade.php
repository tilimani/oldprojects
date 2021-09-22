@extends('layouts.app')
@section('title', 'Admin Panel')
@section('content')
	@if (Auth::user() && Auth::user()->email === 'friendsofmedellin@gmail.com')
	{{-- SWITCH STYLES --}}
	{{-- VICO RESULTS  --}}
		{{-- container  --}}
		<style type="text/css">

		/*new styles*/
		.image-rounded-width{
			width: 100%;
			border-radius: 1rem;
		}

		.vico-admin-figure-caption{
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

		.vico-admin-delete-button{
			display: inline-block;
			margin-left: 1rem;
			float: right;
		}

		.vico-admin-delete-label-right{
			float:right;
		}


	</style>
	<div class="container">
		{{-- row --}}
		<div class="row">
			<div class="col-sm-6" style="text-align: center; margin-bottom: 5rem; margin-top: 5rem;">
				<a href="/houses/create" class="btn btn-default">
					Crear Nueva VICO
				</a>
			</div>
			<div class="col-sm-6" style="text-align: center; margin-bottom: 5rem; margin-top: 5rem;">
				<a href="/booking" class="btn btn-default">
					Ver bookings
				</a>
			</div>
		</div>
		<form method="POST" action="{{URL::to('/admin/update')}}" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="row">
				@forelse($houses as $house)
					{{-- col --}}
					<div class="col-lg-4 col-sm-12 vico-result">
						{{-- VIEW VICO --}}
						<a href="houses/edit/{{ $house->id }}">
							<figure>
								<img src="http://fom.imgix.net/{{ $house->image->image }}?fit=fillmax&w=700&h=466.67&bg=ccc" class="img-responsive image-rounded-width" alt="Responsive image">
								<figcaption class="vico-admin-figure-caption" >
									<h4>{{ $house->name }}</h4>
									<p>Disponibles desde {{ date('d/m/Y', strtotime($house->min_date)) }}</p>
								</figcaption>
							</figure>
						</a>
						<div class="vico-info">
							<div class="row">
								<div class="col-5">
									<p><a id="editar-vico" class="simple-link" href="/houses/{{ $house->id }}">Ver anuncio<span class="icon-next-fom"></span></a></p>
								</div>
								<div class="col-7">
									<span class="vico-admin-delete-label-right">Borrar
										<div class="form-group vico-admin-delete-button">
											<input type="checkbox" name="eliminar_vico[]" value="{{$house->id}}" multiple>
											<span class="slider round"></span>
										</div>
									</span>
								</div>
							</div>
						</div>
						{{-- END VIEW VICO --}}
					</div>
					{{-- col end --}}
				@empty
					<h1 class="text-center">Consulta sin resultados</h1>
				@endforelse
			</div>
			{{-- row end --}}
			<div class="d-flex justify-content-center">
				<div class="row">
					<div class="col-sm-12">
						<button type="submit" class="btn btn-default">
							Guardar
						</button>
					</div>
				</div>
			</div>
		</form>
	</div>
	{{-- END VICO RESULTS --}}

</div>
{{-- END WRAP FOR STICKY FOOTER --}}



@else
	<p>You are not allowed to enter this page.</p>
@endif
@endsection
