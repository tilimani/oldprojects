@extends('layouts.app')
{{-- SECTION: TITLE  --}}
@section('title', 'Terminos y condiciones de VICO - Vivir entre amigos')
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
@endsection
{{-- SECTION: CONTENT --}}
@section('content')
<div class="container p-4" style="font-family: nunitoregular">
{{-- Start terms and conditions --}}
@if(Auth::check() and Auth::user()->isUser())
	@include('termsandconditions._terms_user')

<hr>
@elseif(Auth::check() and Auth::user()->isManager())
	@include('termsandconditions._terms_manager')
@else
	@include('termsandconditions._terms_user')
	@include('termsandconditions._terms_manager')
@endif
<hr>
<div class="row" id="privacyagreement">
	@include('termsandconditions._privacyagreement')
</div>
</div>
{{-- end terms and conditions --}}

@endsection
{{-- SECTION: SCRIPTS --}}
@section('scripts')
@endsection
