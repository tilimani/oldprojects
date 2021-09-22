<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
  <head>
    <title>@yield('title') | Habitaciones en alquiler</title>
    {{-- GOOGLE META DATA --}}
    @include('layouts.sections._googlemeta')
    {{-- END GOOGLE META DATA --}}
    <meta charset="utf-8">
    {{-- <meta http-equiv="Content-Security-Policy" content="default-src https:"> --}}
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content ="width=device-width,initial-scale=1,user-scalable=no, shrink-to-fit=no" >
    {{-- CSRF TOKEN  --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="_token" content="{!! csrf_token() !!}" />
    
    {{-- SOCIAL APIS --}}
      @yield('facebook_opengraph')
      @yield('twitter_cards')
      @section('meta')
        @yield('meta')
        {{-- <meta name="description" content="Looking for student accommodation and rooms in international houses or shared flats? Here you find easily a safe place! Live with friends in your new VICO."> --}}
      @stop
      @section('facebook_opengraph')
        <!-- Facebook Opengraph integration: https://developers.facebook.com/docs/sharing/opengraph -->
        <meta property="og:title"       content="@yield('title') | Habitaciones para estudiantes y profesionales en alquiler">
        {{-- The recommended resolution for the OG image is 1200x627 pixels, the size — up to 5MB. --}}
        <meta property="og:url"         content="https://www.getvico.com">
        <meta property="og:site_name"   content="www.getvico.com">
        <meta property="og:description" content="Looking for student accommodation and rooms in international houses or shared flats? Here you find easily a safe place! Live with friends in your new VICO."/>
      @stop
      @section('twitter_cards')
        <!-- Twitter Cards integration: https://dev.twitter.com/cards/  -->
        <meta name="twitter:card"         content="summary">
        <meta name="twitter:site"         content="">
        <meta name="twitter:title"        content="@yield('title') | Habitaciones para estudiantes y profesionales en alquiler">
        <meta name="twitter:description"  content="Looking for student accommodation and rooms in international houses or shared flats? Here you find easily a safe place! Live with friends in your new VICO.">
        <meta name="twitter:image"        content="">
      @stop
    {{-- END SOCIAL APIS --}}
    {{-- ICON SECTION --}}
      @include('layouts.sections._icons')
    {{-- END ICON SECTION --}}



    
    {{-- BOOTSTRAP CORE CSS  --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    {{-- Slick css --}}
    {{-- <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" /> --}}

    <link href="{{asset('css/app.css?version=5') }}" rel="stylesheet">

    @yield('styles')
  </head>
  <body class="vico-body">
    @include('layouts.sections._info-alert')
    {{-- <div id="example-react"></div> --}}
    {{-- NAVBAR SECTION --}}
      @include('layouts.sections._navbar')
    {{-- END NAVBAR SECTION --}}

    {{-- MAIN CONTENT --}}
      @yield('content')
    {{-- END MAIN CONTENT --}}    

    {{-- CONTACT MODAL --}}
      @include('layouts.sections._contact')
    {{-- END CONTACT MODAL --}}

    {{-- FEEDBACK SECTION --}}
      {{-- @include('layouts.sections._feedback') --}}
    {{-- END FEEDBACK --}}

  </body>
  
  {{-- MODAL REGISTER START --}}
    @include('layouts.sections._register')
  {{-- END MODAL REGISTER --}}

  {{-- MODAL COMPLETEREGISTER  --}}
    @include('layouts.sections._completeregister')
  {{-- END MODAL COMPLETEREGISTER --}}

  {{-- MODAL LOGIN--}}
    @include('layouts.sections._login')
  {{-- END MODAL LOGIN --}}

  {{-- ISSUES MODAL --}}
    {{-- @include('layouts.sections._issues') --}}
  {{-- END ISSUES MODAL --}}

  {{-- TAC --}}
    @include('layouts.sections._tac')
  {{-- END TAC --}}

  {{-- MODAL LOADER --}}
    @include('layouts.sections._modal-loader')
  {{-- END MODAL LOADER --}}

  <form action="/multilanguage/change" method="post" class="d-none" id="changeLanguageForm">
    {{csrf_field()}}
    <input type="text" name="language" id="languageInput">
  </form>

    <script src="//code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script> --}}
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" integrity="sha384-FzT3vTVGXqf7wRfy8k4BiyzvbNfeYjK+frTVqZeNDFl8woCbF0CYG6g2fMEFFo/i" crossorigin="anonymous"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src='//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.4.0/js/intlTelInput.min.js'></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.0/jquery.waypoints.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script src="{{ asset('vanilla/app.js?version=5') }}"></script>

    {{-- REACT.JS --}}
    <script src="{{ asset('js/app.js?version=5') }}"></script>

    {{-- APP BLADE SCRIPTS --}}
        @include('layouts.sections._scripts')
    {{-- END APP BLADE SCRIPTS --}}

    {{-- MAIN SCRIPTS --}}
        @yield('scripts')
    {{-- END MAIN SCRIPTS --}}

</html>
