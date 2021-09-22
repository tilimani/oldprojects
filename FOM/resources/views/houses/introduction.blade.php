@extends('layouts.app')
@section('title', 'Crear una VICO')

@section('content')

{{-- @if (Auth::user() && (Auth::user()->role_id === 1 || Auth::user()->role_id === 2)) --}}


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <style type="text/css">
      
      .faq-section {
          min-height: 100vh;
          padding: 10vh 0 0;
      }
      .faq-title h2 {
        position: relative;
        margin-bottom: 45px;
        display: inline-block;
        font-weight: 600;
        line-height: 1;
      }
      .faq-title h2::before {
          content: "";
          position: absolute;
          left: 50%;
          width: 60px;
          height: 2px;
          background: #ef8e01;
          bottom: -25px;
          margin-left: -30px;
      }
      .faq-title p {
        padding: 0 190px;
        margin-bottom: 10px;
      }

      .faq {
        background: #FFFFFF;
        box-shadow: 0 2px 48px 0 rgba(0, 0, 0, 0.06);
        border-radius: 4px;
      }

      .faq .card {
        border: none;
        background: none;
        border-bottom: .5px dashed #CEE1F8;
      }

      .faq .card .card-header {
        padding: 0px;
        border: none;
        background: none;
        -webkit-transition: all 0.3s ease 0s;
        -moz-transition: all 0.3s ease 0s;
        -o-transition: all 0.3s ease 0s;
        transition: all 0.3s ease 0s;
      }

      .faq .card .card-header:hover {
          background: rgba(239, 142, 1, 0.1);
          padding-left: 10px;
      }
      .faq .card .card-header .faq-title {
        width: 100%;
        text-align: left;
        padding: 0px;
        padding-left: 30px;
        padding-right: 30px;
        font-weight: 400;
        font-size: 15px;
        letter-spacing: 1px;
        text-decoration: none !important;
        -webkit-transition: all 0.3s ease 0s;
        -moz-transition: all 0.3s ease 0s;
        -o-transition: all 0.3s ease 0s;
        transition: all 0.3s ease 0s;
        cursor: pointer;
        padding-top: 20px;
        padding-bottom: 20px;
      }

      .faq .card .card-header .faq-title .badge {
        display: inline-block;
        width: 24px;
        height: 24px;
        line-height: 14px;
        float: left;
        -webkit-border-radius: 100px;
        -moz-border-radius: 100px;
        border-radius: 100px;
        text-align: center;
        background: #ef8e01;
        color: #fff;
        font-size: 12px;
        margin-right: 20px;
        padding: 0.45em 0.4em;
      }

      .faq .card .card-body {
        padding: 30px;
        padding-left: 35px;
        padding-bottom: 16px;
        font-weight: 400;
        font-size: 16px;
        line-height: 28px;
        border-top: 1px solid #F3F8FF;
      }

      .faq .card .card-body p {
        margin-bottom: 14px;
      }

      @media (max-width: 991px) {
        .faq {
          margin-bottom: 30px;
        }
        .faq .card .card-header .faq-title {
          line-height: 26px;
          margin-top: 10px;
        }
      }
    </style>
    <style type="text/css">
      body {
          margin: 0;
          font-family: sans-serif;
      }

      .section-1 {
          /* Background styles */
          background-image: linear-gradient(rgba(0, 0, 0, 0.5),rgba(0, 0, 0, 0.5)), url('https://fom.imgix.net/house_18.jpeg');

      }
      .section-1 h1{
        font-size: 2rem;
      }
      .section-1 .btn {
          width: 100%;
           padding: 0 25px;
           } 

      .hero h1 {
          /* Text styles */
          font-size: 3em;

          /* Margins */
          margin-top: 0;
          margin-bottom: 0.5em;
      }

      .hero .btn {
          /* Positioning and sizing */
          display: block;
          width: 150px;

          /* Padding and margins */
          margin-top: 50px;
          margin-left: auto;
          margin-right: auto;

          /* Text styles */
          color: white;
          text-decoration: none;
          font-size: 1.2em;
      }
      .section-2 img{
        width: auto;
        max-height: 64px;
        filter:brightness(0%) invert(64%) sepia(48%) saturate(1225%) hue-rotate(354deg) contrast(94%);
      }

      .section-2 h1{
        font-size: 2.25rem;
        font-weight: 500;
        text-align: left;
        color: #3a3a3a;
        margin-left: 0;
      }
      .section-9{
        background: url("https://fom.imgix.net/section-4-bg.png?auto=compress") center center no-repeat;
      }
      .section-6 .vico-slider-item.blue img{
        border-color: white;
      }
      .section-6 .vico-slider-item.blue h6{
        color: #3a3a3a;
        box-shadow: none;
      }
      
    </style>

<body class="fairhaven-homepage">

  <!-- section 1: hero header -->
    <section class="vico-section section-1 mb-4 ">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="vico-flex-container">
              <div class="vico-flex-item">
                <img src="{{ asset('images/landingpage/logo-v.png') }}" alt="VICO landing logo">
                <h1 class="bold-words text-uppercase mb-1">
                 Alquila tus habitaciones de forma sencilla y segura
                </h1>
                <h1 class="" style="font-size: 1.3rem;">
                  En pocos pasos podrás encontrar inquilinos nuevos para tus habitaciones amobladas.
                </h1>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="vico-flex-container">
              <div class="vico-flex-item w-auto">
                  <a href="/houses/create/1" class="btn btn-primary">{{trans('landing.upload')}}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  <!-- section 1 -->

  <!-- section 2: PUV VICO -->
    <section 
      class="vico-section my-4" 
      style="min-height: auto"
      id="react-welcome-vico"
      @if(Auth::user())
      data-connection={{Auth::user()->role_id}}
      @endif>
    </section>
  <!-- section 2 -->

  <!-- section 2: PUV VICO -->
    <section class="vico-section section-2 my-4">
      <div id="vico-particles"></div>
        <div class="container">
          <div class="row">
            <div class="col-12">
              <div class="vico-flex-container">
                <div class="vico-flex-item">
                  <h1 class="bold-words">{{trans('landing.why_publish')}}</h1>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-4 col-md-4 col-12">
              <div class="vico-flex-container">
                <div class="vico-flex-item">
                  <img src="{{ asset('images/landingpage/icons/icon-risk.png') }}" alt="VICO risk">
                  <h2 class="bold-words">
                  ¿Por qué VICO es una muy buena idea?
                    {{-- {{trans('landing.puv_1')}} --}}
                  </h2>
                  <p class="text-justify">
                    Publicar en VICO es completamente gratis. Solamente debes pagar una comisión del 7% cuando consigues clientes a través de la plataforma. ¡No tienes nada que perder!
                    {{-- {{trans('landing.puv_1_text')}} --}}
                  </p>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-12">
              <div class="vico-flex-container">
                <div class="vico-flex-item">
                  <img src="{{ asset('images/landingpage/icons/icon-stay.png') }}" alt="VICO stay">
                  <h2 class="bold-words">{{trans('landing.puv_2')}}</h2>
                  <p class="text-justify">
                    {{-- {{trans('landing.puv_2_text')}} --}}
                    Buscamos ofrecer estabilidad, tanto a los anfitriones como a los invitados, por eso trabajamos con estancias entre 3 y 24 meses. Una VICO no es un alojamiento turístico. Estudiantes y jóvenes profesionales siempre mostrarán más identificación con tu inmueble.
                  </p>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-12">
              <div class="vico-flex-container">
                <div class="vico-flex-item">
                  <img src="{{ asset('images/landingpage/icons/icon-earning.png') }}" alt="VICO earning">
                  <h2 class="bold-words">{{trans('landing.puv_3')}}</h2>
                  <p class="text-justify">
                    {{trans('landing.puv_3_text')}}
                    Ofrecemos un contrato de vivienda compartida especializado para el arriendo de cada habitación de forma independiente. Además, nos encargamos de la administración de los pagos mensuales y de un depósito de seguridad.
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="vico-flex-container">
                <div class="vico-flex-item">
                  <a href="/houses/create/1" class="btn btn-primary">{{trans('landing.upload')}}</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  <!-- section 2 -->


  <!-- section 3: Testimonials-->
    <section class="vico-section section-6 my-4 d-none" style="min-height: auto;">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="vico-flex-container">
              <div class="vico-flex-item">
                <h1 class="bold-words">What our customers say about us.</h1>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="vico-slider">
              <div class="slider-grid">
                <div class="slide-content">
                  <div class="vico-slider-item blue shadow">
                    <div class="major">
                      <div class="has-v-icon">
                        <img src="{{ asset('images/landingpage/slider-item-3.png') }}" alt="">
                      </div>
                      <div>
                        <h6>Edith</h6>
                        <p>
                          Propietaria VICO<br>
                          Colombia<br>
                          45 AÑOS
                        </p>
                      </div>
                    </div>
                    <div class="desc">
                      <p>
                        Conozco a Manuel y a Tilman desde que llegaron a Colombia, he visto su evolución de estudiantes a empresarios en un negocio del cual conocen todos los detalles, las VICOs son la mejor opción de estudiantes en un país extranjero por qué todas pasan por el análisis minucioso de estos dos emprendedores.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="slider-grid">
                <div class="slide-content">
                  <div class="vico-slider-item blue shadow">
                    <div class="major">
                      <div class="has-v-icon">
                        <img src="{{ asset('images/landingpage/slider-item-3.png') }}" alt="">
                      </div>
                      <div>
                        <h6>Mauricio</h6>
                        <p>
                          Propietaria VICO<br>
                          Colombia<br>
                          45 AÑOS
                        </p>
                      </div>
                    </div>
                    <div class="desc">
                      <p>
                        Como propietario de una VICO puedo decir que es un negocio de mejora continua, al contar con aliados como VICO todo se resuelve mucho mas fácil, por qué cuentas con su conocimiento y apoyo en el negocio.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="slider-grid">
                <div class="slide-content">
                  <div class="vico-slider-item blue shadow">
                    <div class="major">
                      <div class="has-v-icon">
                        <img src="{{ asset('images/landingpage/slider-item-3.png') }}" alt="">
                      </div>
                      <div>
                        <h6>Martha</h6>
                        <p>
                          Propietaria VICO<br>
                          Colombia<br>
                          45 AÑOS
                        </p>
                      </div>
                    </div>
                    <div class="desc">
                      <p>
                        VICO no sólo es una oportunidad de negocio. VICO es una experiencia de vida tanto para nosotros los propietarios, como para los chicos que llegan a nuestro país. Es un punto donde nos encontramos varias culturas y nos complementamos. Es el claro ejemplo del emprendimiento de un grupo de jóvenes que con trabajo en equipo han ido creciendo y generando cada vez más ideas de expansión. VICO nos acompaña y nos guía, siempre está dispuesto, hay una comunicación en doble vía que nos permite crecer conjuntamente.¡Gracias VICO!
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  <!-- section 3 -->

  <!-- section 4 -->
  <!-- ***** FAQ Start ***** -->
    <div class="row d-none">         
          <div class="col-md-6 offset-md-3">

              <div class="faq-title text-center pb-3">
                  <h2>Preguntas frecuentes </h2>
              </div>
          
          </div>
          
          <div class="col-md-6 offset-md-3 pb-4">
              <div class="faq" id="accordion">

              {{-- Card Costo --}}
                  <div class="card">
                      <div class="card-header" id="faqHeading-1">
                          <div class="mb-0">
                              <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-1" data-aria-expanded="true" data-aria-controls="faqCollapse-1">
                                  <span class="badge">1</span>¿Cuanto cuesta la publicación en VICO?
                              </h5>
                          </div>
                      </div>
                      <div id="faqCollapse-1" class="collapse" aria-labelledby="faqHeading-1" data-parent="#accordion">
                          <div class="card-body">
                            <p>
                              0%. Exito: 7-10%
                            </p>
                          </div>
                      </div>
                  </div>

              {{-- Card otros lugares --}}
                  <div class="card">
                      <div class="card-header" id="faqHeading-2">
                          <div class="mb-0">
                              <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-2" data-aria-expanded="false" data-aria-controls="faqCollapse-2">
                                  <span class="badge">2</span> 
                                  ¿Puedo seguir ofrecer mis habitaciones en otros lugares?
                              </h5>
                          </div>
                      </div>
                      <div id="faqCollapse-2" class="collapse" aria-labelledby="faqHeading-2" data-parent="#accordion">
                          <div class="card-body">
                              <p>
                                No worries.
                              </p>
                          </div>
                      </div>
                  </div>

              {{-- Card  otro fuente --}}
                  <div class="card">
                      <div class="card-header" id="faqHeading-3">
                          <div class="mb-0">
                              <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-3" data-aria-expanded="false" data-aria-controls="faqCollapse-3">
                                  <span class="badge">3</span> 
                                  Encontré otro inquilino, ¿qué hago?
                              </h5>
                          </div>
                      </div>
                      <div id="faqCollapse-3" class="collapse" aria-labelledby="faqHeading-3" data-parent="#accordion">
                          <div class="card-body">
                              <p>
                                Puedes cambiar la disponibildad en la configuración de tu VICO.
                              </p>
                          </div>
                      </div>
                  </div>

              {{-- Card Give Back Deposit --}}
                  <div class="card">
                      <div class="card-header" id="faqHeading-4">
                          <div class="mb-0">
                              <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-4" data-aria-expanded="false" data-aria-controls="faqCollapse-4">
                                  <span class="badge">4</span>¿Puedo poner mis propias reglas?
                              </h5>
                          </div>
                      </div>
                      <div id="faqCollapse-4" class="collapse" aria-labelledby="faqHeading-4" data-parent="#accordion">
                          <div class="card-body">
                              <p>
                                Puedes hacerlo lo que tu quieres.
                              </p>
                          </div>
                      </div>
                  </div>
                  
              </div>
          </div>

      </div>
  <!-- section 4 -->


    <!-- section 5 -->
      <section class="vico-section section-9" id="cta-section">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="vico-flex-container">
                <div class="vico-flex-item">
                  <img src="{{ asset('images/landingpage/logo-v.png') }}" alt="">
                  {{-- <h1 class="bold-words">{{trans('landing.why_publish')}}</h1> --}}
                  <h1 class="">¿Convencido o todavía tienes preguntas?</h1>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="vico-flex-container">
                <div class="vico-flex-item">
                  <ul> 
                  <li><a href="/houses/create/1" id="pixel-search-last" class="btn btn-primary search-vico">Sube tu VICO</a></li>
                  <li><a id="movilContacUs" class="btn btn-secondary bg-white">Organizar una llamada.</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- section 4 -->

</body>
{{-- @else
<p>You are not allowed to enter this page.</p>
@endif --}}
@endsection
@section('scripts')

      <script type="text/javascript">

      $( ".checkmanager" ).prop( "checked", true );

        $(".checkDescription").hide();
      $(document).ready(function(){


        $(".checkItem").click(function(e) {

          $("#checkDescription"+e.target.value).toggle(500);


          // console.log(e.target.value);

        });
        $("#btn-init").click(function(event) {

          // var check1 = document.getElementById("check1").checked;
          var check2 = document.getElementById("check2").checked;
          var check3 = document.getElementById("check3").checked;
          var check4 = document.getElementById("check4").checked;
          var alert = $("#continueAlert");


          if (check2 && check3 && check4) {

            // console.log("good");
            document.getElementById("btn-init-submit").click();
          }

          else{
            alert.removeClass('d-none');
            $('html, body').animate({
               scrollTop: 0
            }, 'slow');
            // console.log("bad");

          }


        });
      });
      $(function() {
         $('.scroll-down').click (function() {
           $('html, body').animate({scrollTop: $('#start').offset().top }, 'slow');
           return false;
         });
       });
      </script>

      @endsection


