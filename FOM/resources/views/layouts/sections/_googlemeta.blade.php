  {{-- GOOGLE CHART LIBRARY --}}
  @if (Auth::check())
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <script type="text/javascript">
          // Load Charts and the corechart package.
          google.charts.load('current', {'packages':['corechart','sankey']});
      </script>
  @endif
  {{-- IF condition to desactivate Segment Analytics in local and test environments --}}
  @if (App::environment('production'))
    {{--------------- start segment -------------------------}}
    <script>
      !function(){var analytics=window.analytics=window.analytics||[];if(!analytics.initialize)if(analytics.invoked)window.console&&console.error&&console.error("Segment snippet included twice.");else{analytics.invoked=!0;analytics.methods=["trackSubmit","trackClick","trackLink","trackForm","pageview","identify","reset","group","track","ready","alias","debug","page","once","off","on"];analytics.factory=function(t){return function(){var e=Array.prototype.slice.call(arguments);e.unshift(t);analytics.push(e);return analytics}};for(var t=0;t<analytics.methods.length;t++){var e=analytics.methods[t];analytics[e]=analytics.factory(e)}analytics.load=function(t,e){var n=document.createElement("script");n.type="text/javascript";n.async=!0;n.src="https://cdn.segment.com/analytics.js/v1/"+t+"/analytics.min.js";var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(n,a);analytics._loadOptions=e};analytics.SNIPPET_VERSION="4.1.0";
      analytics.load("{{env('SEGMENT_WRITE_KEY')}}");
      @include('layouts.sections._tracking-routes');
      }}();
    </script>
    {{---------------- end segment --------------------------}}
    {{---------------- Segment identifier -------------------}}
    @if (Auth::check() && Auth::user()->role_id != 1)
      <script>
        analytics.identify('{{auth::user()->id}}', {
        name: '{{auth::user()->name}}',
        email: '{{auth::user()->email}}',
        role: '{{auth::user()->role_id}}',
        gender: '{{auth::user()->gender}}',
        country: '{{auth::user()->Country->name}}'
      });</script>
    @endif
    {{--------------- Segment identifier --------------------}}

    <!-- Facebook Pixel Code -->
    {{-- <script>
     !function(f,b,e,v,n,t,s)
     {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
     n.callMethod.apply(n,arguments):n.queue.push(arguments)};
     if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
     n.queue=[];t=b.createElement(e);t.async=!0;
     t.src=v;s=b.getElementsByTagName(e)[0];
     s.parentNode.insertBefore(t,s)}(window, document,'script',
     'https://connect.facebook.net/en_US/fbevents.js');
     fbq('init', '172531476599293');
     fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
     src="https://www.facebook.com/tr?id=172531476599293&ev=PageView&noscript=1
    https://www.facebook.com/tr?id=172531476599293&ev=PageView&noscript=1
    "
    /></noscript> --}}
    <!-- End Facebook Pixel Code -->
    <!-- Hotjar Tracking Code for getvico.com -->
    {{-- <script>
     !function(f,b,e,v,n,t,s)
     {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
     n.callMethod.apply(n,arguments):n.queue.push(arguments)};
     if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
     n.queue=[];t=b.createElement(e);t.async=!0;
     t.src=v;s=b.getElementsByTagName(e)[0];
     s.parentNode.insertBefore(t,s)}(window, document,'script',
     'https://connect.facebook.net/en_US/fbevents.js');
     fbq('init', '172531476599293');
     fbq('track', 'PageView');
    </script> --}}
    <noscript><img height="1" width="1" style="display:none"
     src="https://www.facebook.com/tr?id=172531476599293&ev=PageView&noscript=1
    https://www.facebook.com/tr?id=172531476599293&ev=PageView&noscript=1
    "
    /></noscript>
    <!-- End Facebook Pixel Code -->
  
  @endif


  @if(App::environment('local') || App::environment('development'))
    <meta name="robot" content="noindex, nofollow">
  @endif

