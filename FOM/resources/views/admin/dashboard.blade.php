@extends('layouts.app')
{{-- SECTION: TITLE  --}}
@section('title', 'Dashboard for Admins')
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
	.card{
		background: #fff;
		border-radius: 2px;
		display: inline-block;
		margin: 1rem;
		position: relative;
		width: 300px;
		box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
    }
    
    .dashboard-score {
        border: 5px #ea960f solid;
        box-shadow: none !important;
    }
</style>
@endsection
{{-- SECTION: CONTENT --}}
@section('content')
<div class="container">
    <div class="row text-center mx-auto">

        <div class="card d-flex justify-content-center" style="">
            <div class="card-body dashboard-score">
                <h4 class="card-title bold-words">Active Bookings</h4>
                <h4 class="card-title m-0">{{$active_bookings}}</h4>
            </div>
        </div>
        <div class="card d-flex justify-content-center" style="">
            <div class="card-body dashboard-score">
                <h4 class="card-title bold-words">Net Promoter Score</h4>
                <h4 class="card-title m-0">{{$net_promoter_score}}</h4>
            </div>
        </div>
        <div class="card d-flex justify-content-center" style="">
            <div class="card-body dashboard-score">
                <h4 class="card-title bold-words">Solicitudes Abiertas</h4>
                <h4 class="card-title m-0">{{$open_requests}}</h4>
            </div>
        </div>
    </div>
	<div class="row mx-auto">
		<div class="card d-flex justify-content-center" style="">
			<img class="card-img-top mx-auto" style="width: 64px" src="{{asset('images/process/modal/request.png') }}" alt="Card image">
			<div class="card-body">
				<h4 class="card-title">Jeffboard</h4>
				<a href="/admin/jeffboard">Entrar</a>
			</div>
		</div>
		<div class="card d-flex justify-content-center" style="">
			<img class="card-img-top mx-auto" style="width: 64px" src="{{asset('images/process/modal/request.png') }}" alt="Card image">
			<div class="card-body">
				<h4 class="card-title">Search Users, edit them and get their bookings</h4>
				<a href="/users/">Entrar</a>
			</div>
		</div>
		<div class="card d-flex justify-content-center" style="">
			<img class="card-img-top mx-auto" style="width: 64px" src="{{asset('images/process/modal/request.png') }}" alt="Card image">
			<div class="card-body">
				<h4 class="card-title">See all bookings</h4>
				<a href="/booking/">Entrar</a>
			</div>
		</div>
        <div class="card d-flex justify-content-center" style="">
            <img class="card-img-top mx-auto" style="width: 64px" src="{{asset('images/process/modal/request.png') }}" alt="Card image">
            <div class="card-body">
                <h4 class="card-title">Print Confirmation Manager (cambiar Booking-ID)</h4>
                <a href="{{route('print.confirmation.manager','3')}}">Entrar</a>
            </div>
        </div>
        <div class="card d-flex justify-content-center" style="">
            <img class="card-img-top mx-auto" style="width: 64px" src="{{asset('images/process/modal/request.png') }}" alt="Card image">
            <div class="card-body">
                <h4 class="card-title">Print Confirmation User (cambiar Booking-ID)</h4>
                <a href="{{route('print.confirmation.user','3')}}">Entrar</a>
            </div>
        </div>
		<div class="card d-flex justify-content-center" style="">
			<img class="card-img-top mx-auto" style="width: 64px" src="{{asset('images/process/modal/request.png') }}" alt="Card image">
			<div class="card-body">
				<h4 class="card-title">See all VICOs</h4>
				<a href="{{route('my_houses')}}">Entrar</a>
			</div>
		</div>
		<div class="card d-flex justify-content-center" style="">
			<img class="card-img-top mx-auto" style="width: 64px" src="{{asset('images/process/modal/request.png') }}" alt="Card image">
			<div class="card-body">
				<h4 class="card-title">Referral Dashboard</h4>
				<a href="/vicoReferrals/">Entrar</a>
			</div>
		</div>
		<div class="card d-flex justify-content-center" style="">
			<img class="card-img-top mx-auto" style="width: 64px" src="{{asset('images/process/modal/request.png') }}" alt="Card image">
			<div class="card-body">
				<h4 class="card-title">Ver solicitudes en notifications</h4>
				<a href="/notifications/">Entrar</a>
			</div>
        </div>
        <div class="card d-flex justify-content-center" style="">
            <img class="card-img-top mx-auto" style="width: 64px" src="{{asset('images/process/modal/request.png') }}" alt="Card image">
            <div class="card-body">
                <h4 class="card-title">CRUD escuelas/universidades</h4>
                <a href="{{route('school.index')}}">Entrar</a>
            </div>
        </div>
        <div class="card d-flex justify-content-center" style="">
            <img class="card-img-top mx-auto" style="width: 64px" src="{{asset('images/process/modal/request.png') }}" alt="Card image">
            <div class="card-body">
                <h4 class="card-title">CRUD zonas</h4>
                <a href="{{route('zone.index')}}">Entrar</a>
            </div>
		</div>
		<div class="card d-flex justify-content-center" style="">
            <img class="card-img-top mx-auto" style="width: 64px" src="{{asset('images/process/modal/request.png') }}" alt="Card image">
            <div class="card-body">
                <h4 class="card-title">CRUD locations(Comunas)</h4>
                <a href="{{route('location.index')}}">Entrar</a>
            </div>
        </div>
        <div class="card d-flex justify-content-center" style="">
            <img class="card-img-top mx-auto" style="width: 64px" src="{{asset('images/process/modal/request.png') }}" alt="Card image">
            <div class="card-body">
                <h4 class="card-title">CRUD barrios</h4>
                <a href="{{route('neighborhood.index')}}">Entrar</a>
            </div>
        </div>
        <div class="card d-flex justify-content-center" style="">
            <img class="card-img-top mx-auto" style="width: 64px" src="{{asset('images/process/modal/request.png') }}" alt="Card image">
            <div class="card-body">
                <h4 class="card-title">CRUD puntos de interés <b>genéricos</b></h4>
                <a href="{{route('genericInterestPoints.index')}}">Entrar</a>
            </div>
        </div>
        <div class="card d-flex justify-content-center" style="">
            <img class="card-img-top mx-auto" style="width: 64px" src="{{asset('images/process/modal/request.png') }}" alt="Card image">
            <div class="card-body">
                <h4 class="card-title">CRUD puntos de interés <b>específicos</b></h4>
                <a href="{{route('specificInterestPoints.index')}}">Entrar</a>
            </div>
        </div>
        <div class="card d-flex justify-content-center" style="">
            <img class="card-img-top mx-auto" style="width: 64px" src="{{asset('images/process/modal/request.png') }}" alt="Card image">
            <div class="card-body">
                <h4 class="card-title">CRUD ciudades</h4>
                <a href="{{route('city.index')}}">Entrar</a>
            </div>
        </div>
        <div class="card d-flex justify-content-center" style="">
            <img class="card-img-top mx-auto" style="width: 64px" src="{{asset('images/process/modal/request.png') }}" alt="Card image">
            <div class="card-body">
                <h4 class="card-title">CRUD Referrals usados</h4>
                <a href="{{route('referrals.uses')}}">Entrar</a>
            </div>
        </div>

        <div class="card d-flex justify-content-center" style="">
            <img class="card-img-top mx-auto" style="width: 64px" src="{{asset('images/process/modal/request.png') }}" alt="Card image">
            <div class="card-body">
                <h4 class="card-title">Whatsapp entrantes</h4>
                <a href="{{route('dashboard.whatsapp')}}">Entrar</a>
            </div>
        </div>
	</div>
</div>
@endsection
{{-- SECTION: SCRIPTS --}}
@section('scripts')
@endsection



