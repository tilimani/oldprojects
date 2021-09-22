@extends('layouts.app')
@section('title', 'Admin Panel')
@section('meta')
<meta name="description" content="">
{{-- PRIVATE SITE: NOINDEX NO FOLLOW IN ORDER TO PREVENT LOOKUP IN GOOLGE --}}
<meta name="robot" content="noindex, nofollow">
<meta property="og:title" content=""/>
<meta property="og:image" content="" />
<meta property="og:site_name" content="VICO"/>
<meta property="og:description" content=""/>
@endsection
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
</style>
@endsection
@section('content')
	@if (Auth::user() && Auth::user()->email === 'friendsofmedellin@gmail.com')
    {{-- SWITCH STYLES --}}
	{{-- VICO RESULTS  --}}
    <div class='container'>
    </div> 
    @endif
@endsection