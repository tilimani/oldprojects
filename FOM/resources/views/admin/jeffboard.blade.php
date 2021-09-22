@extends('layouts.app')
{{-- SECTION: TITLE  --}}
@section('title', 'Jeffboard')
{{--SECTION: META--}}
@section('meta')
<meta name="description" content="">
{{-- PRIVATE SITE: NOINDEX NO FOLLOW IN ORDER TO PREVENT LOOKUP IN GOOLGE --}}
<meta name="robot" content="noindex, nofollow">
<meta property="og:title" content=""/>
<meta property="og:image" content="" />
<meta property="og:site_name" content="VICO"/>
<meta property="og:description" content=""/>
@endsection
{{-- SECTION: STYLES --}}
@section('styles')
<style type="text/css">

.btn-content{
	display: flex;
	justify-content: center;
}
.btn-state{
	margin-top: 1rem;
}
#js-searchbar-jeffboard, #js-searchbar-manager-jeffboard, #js-city-searchbar-jeffboard {
  width: 100%; /* Full-width */
  font-size: 16px; /* Increase font-size */
  padding: 12px 20px 12px 40px; /* Add some padding */
  border: 1px solid #ddd; /* Add a grey border */
  margin-bottom: 12px; /* Add some space below the input */
}

.nav-pills .nav-link.active, .nav-pills .show > .nav-link {
    border-bottom: 3px solid orange;
    color: #ef8e01;
    border-radius: 0;
    padding: 4px;
}

.js-search-card{
	width:300px;
}

</style>
@endsection
{{-- SECTION: CONTENT --}}
@section('content')

{{-- CONTAINER --}}
<div class="container">

	<input type="text" id="js-searchbar-jeffboard" onkeyup="searchNamesJeffboard()" placeholder="Search for names.." class="mx-md-4 m-0 mt-4">
	<input type="text" id="js-searchbar-manager-jeffboard" onkeyup="searchManagersNamesJeffboard()" placeholder="Search for manager names.." class="mx-md-4 m-0 mt-4">
	<input type="text" id="js-city-searchbar-jeffboard" onkeyup="searchCityName()" placeholder="Search for city.." class="mx-md-4 m-0 mt-4">
	{{-- Searchable list for JS --}}
		<ul id="myUL" class="pl-0">
				@if (\Session::has('success_change_role'))
				<div class="alert-success text-center ">
					<h2>👌 Melo mi pez.</h2>
				</div>
				@endif
				@if (\Session::has('notification-sended'))
				<div class="alert-success text-center ">
					<h2>{{Session('notification-sended')}}</h2>
				</div>
				@endif
			@forelse($houses as $house)
			{{-- HOUSE CARD selected in search by class js-search-card --}}
				<li class="card float-left m-md-4 my-4 js-search-card">
						{{-- CARD BODY --}}
					  	<div class="card-body">
					  		{{-- Card Title  --}}
					  		<div class="col-12 p-1">
								  <a class="card-title" href="/houses/{{$house->id}}">{{$house->name}}</a>
							  		<span class="js-city-searchbar-jeffboard badge badge-info">{{$house->neighborhood->location->zone->city->name}}</span>
					  			@if($house->manager->vip === 1)<span class="float-right icon-check"></span>@endif
					  		</div>

					  		{{-- Tab Navegation  --}}
						  		<ul class="nav nav-pills">
							  		{{-- General Tab --}}
							  		  <li class="nav-item">
							  		    <a class="nav-link active small bg-white" data-toggle="pill" href="#general{{$house->id}}">General</a>
							  		  </li>
							  		{{-- Manager Tab --}}
							  		  <li class="nav-item">
							  		    <a class="nav-link small bg-white" data-toggle="pill" href="#manager{{$house->id}}">Manager</a>
							  		  </li>
							  		{{-- VICO Tab --}}
							  		  <li class="nav-item">
							  		    <a class="nav-link small bg-white" data-toggle="pill" href="#vico{{$house->id}}">Ubicación</a>
							  		  </li>
						  		</ul>
						  		{{-- Tab panes --}}
						  		<div class="tab-content">

						  		{{-- General INFO --}}
						  		  <div class="tab-pane container active" id="general{{$house->id}}">
						  		  	<div class="row small">
						  		  		<div class="col-12 p-1">
						  		  			<p  class="js-search-manager-name">{{$house->manager->user->name}}  {{$house->manager->user->last_name}} </p>
						  		  			<p><span class="icon-rooms-black"></span> {{$house->rooms_quantity}} habitaciones</p>
						  		  			<p><span class="icon-z-bathroom-2"></span> {{$house->baths_quantity}} baños</p>
											<p><span class="icon-z-date"></span> {{$house->available_rooms}} disponibles</p>
						  		  		</div>
						  		  	</div>
						  		  </div>
						  		{{-- Manager INFO --}}
						  		  <div class="tab-pane container fade" id="manager{{$house->id}}">
						  		  	  	<div class="row small">
							  		  		<div class="col-12 p-1">
							  		  			<p>{{$house->manager->user->name}} {{$house->manager->user->last_name}} </p>
							  		  			<p><a class=" text-success" href="https://wa.me/{{ substr($house->manager->user->phone, 1)}}?text=Hola%20{{$house->manager->user->name}}!"><span class="text-success icon-whatsapp-black"></span>{{$house->manager->user->phone}}</a>
							  		  				</p>
												<p>{{$house->manager->user->email}}</p>
							  		  		</div>
										</div>
										<p class="text-muted small">Estos botones envian un Email al Manager</p>
											<form method="POST" action="{{route('notify.photoshoot')}}">
												{{csrf_field()}}
												<input type="hidden" name="house_id" value="{{$house->id}}">
												<input type="hidden" name="manager_as_user_id" value="{{$house->manager->user->id}}">
												<button type="submit" class="btn btn-primary mb-2 w-100"><h6>Correo Sesion de fotos MAÑANA</h6></button>
											</form>
											<form method="POST" action="{{route('notify.photoshoot.whatsapp')}}">
												{{csrf_field()}}
												<input type="hidden" name="manager_as_user_id" value="{{$house->manager->user->id}}">
												<button type="submit" class="btn btn-primary mb-2 w-100"><h6>Whatsapp Sesion de fotos HOY</h6></button>
											</form>
											<form method="POST" action="{{route('notify.postedfotos')}}">
												{{csrf_field()}}
												<input type="hidden" name="house_id" value="{{$house->id}}">
												<input type="hidden" name="manager_as_user_id" value="{{$house->manager->user->id}}">
												<button type="submit" class="btn btn-primary mb-2 w-100"><h6>Correo fotos publicadas</h6></button>
											</form>
									</div>
						  		{{-- Location INFO --}}
						  		  <div class="tab-pane container fade" id="vico{{$house->id}}">
						  		  	  	<div class="row small">
						  		  	  		<div class="col-12 p-1">
						  		  	  			<p>{{$house->address}}</p>
						  		  	  			<p>Barrio {{$house->neighborhood->name}}</p>
						  		  	  		</div>
						  		  		</div>
						  		  </div>

						  		</div>
					  		{{-- END TAB Navegation --}}

							{{-- BUTTON TO DISABLE--}}
							{{-- Status =1 1 -> Make Public --}}
								@if($house->status != "1")
								<form method="POST" action="/houses/updateStatusHouse" class="btn-state btn-content" >
									{{csrf_field()}}
									<input type="hidden" name="house_id" value="{{$house->id}}">
									<input type="hidden" name="new_status" value="1">
									<button type="submit" class="btn btn-primary mr-2 ml-2">Correo Hacer Publica</button>
								</form>
							{{-- Status = 1 -> Hide --}}
								@elseif($house->status === "1")
									<form method="POST" action="/houses/updateStatusHouse" class="btn-state btn-content">
										{{csrf_field()}}
										<input type="hidden" name="house_id" value="{{$house->id}}">
										<input type="hidden" name="new_status" value="5">
										<button type="submit" class="btn btn-primary mr-2 ml-2">Correo Hacer Privada</button>
									</form>
								@endif
							{{-- END BUTTON --}}
					  		
					  	</div>
					  {{-- END CARD BODY --}}
				</li>
			{{--END HOUSE CARD  --}}
			  @empty
				<div class="col-12">
					<h4>No tienes VICO's</h4>
					</div>
				@endforelse
		</ul>
	{{-- END Searchable List --}}
</div>
{{-- END CONTAINER --}}
@endsection
{{-- SECTION: SCRIPTS --}}
@section('scripts')
<script>
function searchNamesJeffboard() {
  // Declare variables
  var input, filter, ul, li, a, i, txtValue;
  input = document.getElementById('js-searchbar-jeffboard');
  filter = input.value.toUpperCase();
  ul = document.getElementById("myUL");
  //Get each card with class js-search-card
  li = ul.getElementsByClassName('js-search-card');


  // Loop through all list items, and hide those who don't match the search query
  for (i = 0; i < li.length; i++) {
    a = li[i].getElementsByTagName("a")[0];
    txtValue = a.textContent || a.innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      li[i].style.display = "";
    } else {
      li[i].style.display = "none";
    }
  }
}	

  function searchManagersNamesJeffboard() {
  // Declare variables
  var input, filter, ul, li, a, i, txtValue;
  input = document.getElementById('js-searchbar-manager-jeffboard');
  filter = input.value.toUpperCase();
  ul = document.getElementById("myUL");
  //Get each card with class js-search-card
  li = ul.getElementsByClassName('js-search-card');


  // Loop through all list items, and hide those who don't match the search query
  for (i = 0; i < li.length; i++) {
    a = li[i].getElementsByClassName("js-search-manager-name")[0];
    txtValue = a.textContent || a.innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      li[i].style.display = "";
    } else {
      li[i].style.display = "none";
    }
  }
}

function searchCityName(){
	var input, filter, ul, li, a, i, txtValue;
  	input = document.getElementById('js-city-searchbar-jeffboard');
	filter = input.value.toUpperCase();
  	ul = document.getElementById("myUL");
	li = ul.getElementsByClassName('js-search-card');

	for (i = 0; i < li.length; i++) {
		a = li[i].getElementsByClassName("js-city-searchbar-jeffboard")[0];
		txtValue = a.textContent || a.innerText;
		if (txtValue.toUpperCase().indexOf(filter) > -1) {
		li[i].style.display = "";
		} else {
		li[i].style.display = "none";
		}
  	}
}

</script>
@endsection
