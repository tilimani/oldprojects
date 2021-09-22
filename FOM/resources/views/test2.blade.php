<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
  <head>
  {{-- Meta Section --}}
    {{-- Meta --}}
      {{-- Title as seen in goolge search or on the tab --}}
        <title>@yield('title') | Habitaciones en alquiler</title>
      {{-- Meta tags derrived from the views --}}
        @yield('meta')
        {{-- El titulo de Facebook se obtiene arriba desde el yield de Title. Los valores de facebook que necesitamos:

 
    {{-- End Twitter --}}

  {{-- End Meta Section --}}

    <meta charset="utf-8">
    {{-- <META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
    <META HTTP-EQUIV="Refresh" CONTENT="86400"> --}}
    {{-- <meta http-equiv="Content-Security-Policy" content="default-src https:"> --}}
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content ="width=device-width,initial-scale=1,user-scalable=no, shrink-to-fit=no" >
    {{-- CSRF TOKEN  --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
   <meta name="_token" content="{{ csrf_token() }}" />

    {{-- BOOTSTRAP CORE CSS  --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    {{-- Slick css --}}
    {{-- <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" /> --}}

    <link href="{{secure_asset('css/app.css?version=2')}}" rel="stylesheet">

    @yield('styles')
  </head>
  <body class="vico-body">

    <div id="react-landingpagecarousel-test"></div>


    <script src="//code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" integrity="sha384-FzT3vTVGXqf7wRfy8k4BiyzvbNfeYjK+frTVqZeNDFl8woCbF0CYG6g2fMEFFo/i" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src='//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.4.0/js/intlTelInput.min.js'></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.0/jquery.waypoints.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    
    <script src="{{ secure_asset('vanilla/app.js?version=2') }}"></script>

    <script src="{{ secure_asset('js/app.js?version=2') }}"></script>

  </body>

</html>
