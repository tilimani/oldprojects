{{-- THIS IS VIEW SHOWS IF THE USER IS ACTIVE FOR DISCOUNTS --}}

@extends('layouts.app')
{{-- SECTION: TITLE  --}}
@section('title', 'VICO Comunidad')
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
	.vico-body{
	    background: rgb(231,192,129);
	    background: -moz-linear-gradient(158deg, rgba(231,192,129,1) 0%, rgba(234,150,15,1) 50%, rgba(173,107,0,1) 100%);
	    background: -webkit-linear-gradient(158deg, rgba(231,192,129,1) 0%, rgba(234,150,15,1) 50%, rgba(173,107,0,1) 100%);
	    background: linear-gradient(158deg, rgba(231,192,129,1) 0%, rgba(234,150,15,1) 50%, rgba(173,107,0,1) 100%);
	    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#e7c081",endColorstr="#ad6b00",GradientType=1);
	    height: 100vh;
	}
	.card-avatar{
		display: block;
		width: 110px;
		height: 110px;
		position: relative;
		margin-top: 1rem;
		border-radius: 50% !important;
	}
	.card-avatar__check--active{
	    background: #04b23e;
	    color: white;
	    border-radius: 100%;
	    padding: .5rem;
	    position: relative;
       	bottom: 2.2rem;
	    left: 2.5rem;
	}	

	.card-avatar__check--inactive{
	    background: lightgrey;
	    color: white;
	    border-radius: 100%;
	    padding: .5rem;
	    position: relative;
       	bottom: 2.2rem;
	    left: 2.5rem;
	}
	.card-footer__active{
		margin: -1px;
		background: #04b23e;
		color: white;
		text-transform: uppercase;
	}
	.card-footer__inactive{
		margin: -1px;
		background: red;
		color: white;
		text-transform: uppercase;
	}
	.card-header-logo{
		width: 30%;
		align-self: center;
	}
</style>
@endsection
{{-- SECTION: CONTENT --}}
@section('content')

{{-- Check if User is active $activeUser === true --}}
@if($activeUser)
	<div class="container-fluid h-100">
		<div class="row mt-2">
			<div class="col-12 col-md-6 col-lg-4 mx-auto">
				<div class="card shadow">
					{{-- Close window --}}
					<a  onclick="window.close()"
					    data-scroll class="btn btn-link text-left" role="button">
					    <i class="fas fa-arrow-left"></i>{{trans('general.volver')}}</a>
				    {{-- Logo --}}
					<img class="card-header-logo" src="{{asset('images/vico_logo_transition/VICO_VIVIR_orange.png')}}">
					{{-- Card Body with text --}}
					<div class="card-body text-center">
						<p class="h4">{{trans('general.i_am_part')}}</p>
						<hr class="w-50">
						{{-- User Avatar with check --}}
						<img class="card-avatar mx-auto mb-2" src="https://fom.imgix.net/{{$user->image}}?w=500&h=500&fit=crop">
						<span class="icon-check card-avatar__check--active"></span>
						{{-- User Name and House Info --}}
						<h3 class="card-title mb-0">{{$user->name.' '.$user->last_name}}</h3>
						<p class="card-title text-muted mb-0">{{date("d. M 'y", strtotime($activeBooking->date_from))}} - {{date("d. M 'y", strtotime($activeBooking->date_to))}}</p>
						<p class="card-title text-muted">{{$activeBooking->room->house->name}}</p>
					</div>
					<div class="card-footer card-footer__active text-center">
						{{trans('general.active')}}
					</div>
				</div>
			</div>
		</div>
	</div>
@else
{{-- If User isnt active --}}
	<div class="container-fluid h-100">
		<div class="row mt-2">
			<div class="col-12 col-md-3 mx-auto">
				<div class="card shadow">
					{{-- Close window --}}
					<a  onclick="window.close()"
					    data-scroll class="btn btn-link text-left" role="button">
					    <i class="fas fa-arrow-left"></i>{{trans('general.volver')}}</a>
				    {{-- Logo --}}
					<img class="card-header-logo" src="{{asset('images/vico_logo_transition/VICO_VIVIR_orange.png')}}">
					{{-- Card Body with text --}}
					<div class="card-body text-center">
						<p class="h4">{{trans('general.sadly_not_part')}}</p>
						<hr class="w-50">
						{{-- User Avatar with check --}}
						<img class="card-avatar mx-auto mb-2" src="https://fom.imgix.net/{{$user->image}}?w=500&h=500&fit=crop">
						<span class="icon-check card-avatar__check--inactive"></span>
						
						{{-- User Name and House Info --}}
						<h3 class="card-title mb-0">{{$user->name.' '.$user->last_name}}</h3>
					</div>
					<div class="card-footer card-footer__inactive text-center">
						{{trans('general.inactive')}}
					</div>
				</div>
			</div>
		</div>
</div>

@endif


@endsection
{{-- SECTION: SCRIPTS --}}
@section('scripts')
@endsection




