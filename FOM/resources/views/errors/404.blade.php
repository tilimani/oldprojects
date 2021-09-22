@extends('layouts.app')
@section('title', 'Sorry, our fault!')
@section('content')

<div class="row" style="height: 100vh;background-repeat: no-repeat;background-size: contain; background-image: url(http://friendsofmedellin.com/wp-content/uploads/2018/01/404errornew.png)";>

		<div class="col-12 text-center" style="margin-top: 30%; background: radial-gradient(#ffffffc9, #ffffff42)">
			<p class="h1">Uuupsii...</p>
			<p class="h4">There went something wrong on our end.</p>
			<button class="btn btn-primary" style="margin:10px;" onclick="window.location.href='https://www.getvico.com{{
                            Session::has('city_code') ? 
                                __("/vicos/". str_replace(' ','%20',mb_strtolower(\Illuminate\Support\Str::ascii(\App\City::where('city_code', Session::get('city_code'))->first()->name)))) : 
                                '/vicos/medellín'
                        }}'">Volver a página de búsqueda</button>

			<button class="btn btn-primary" onclick="window.location.href='mailto:contacto@friendsofmedellin.com'">Cuenta nos que pasó</button>
		</div>
</div>


@endsection
