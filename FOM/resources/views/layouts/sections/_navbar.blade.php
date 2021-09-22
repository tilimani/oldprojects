<header class="container-fluid" style="margin: 0px; padding: 0px;">
    <nav class="navbar navbar-expand-lg navbar-dark vico-navbar shadow-lg justify-content-start" id="nav-sticky">
        <button class="navbar-toggler px-0"
                type="button"
                data-toggle="collapse"
                data-target="#navbarCollapse"
                aria-controls="navbarCollapse"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
            <a class="navbar-brand pt-0" href="/">
                <img  style="height: 30px;" alt="VICO" src="{{asset('images/vico_logo/VICO_VIVIR_orange.png')}}" srcset="{{asset('images/vico_logo/VICO_VIVIR_orange@2x.png')}} 2x, {{asset('images/vico_logo/VICO_VIVIR_orange@3x.png')}} 3x">
            </a>
        
        {{-- Select region/language/currency Mobile--}}
        <li class="nav-item lang-container pl-0 d-block d-lg-none">
            <div class="nav-link" data-toggle="modal" data-target="#regionConfig" onclick="getCurrentCity()">
                <img class="btn-flag">
                <span>{{Session::has('currency') ? Session::get('currency') : 'COP'}} / {{Session::has('city_code') ? Session::get('city_code') : 'MDE'}}</span>                
            </div>  
        </li>


        <div class="collapse navbar-collapse  justify-content-between" id="navbarCollapse">
            @guest
            @else

            {{-- My profile for mobile Collapsed Information for logged in user --}}
                <ul class="navbar-nav mr-auto d-lg-none collapse show" id="myProfileCollapse">
                    @if (Auth::check())
                        <span class="input-group-text border-0 active mt-2 bold-words">{{ ucfirst(Auth::user()->name)}}</span>

                    {{-- My Profile for all users --}}
                        <li class="d-block d-lg-none"><a href="{!! route('profile',Auth::user()->id) !!}" class="nav-link ml-4">{{trans('layouts/app.my_profile')}}</a></li>

                    {{-- Functions for Admin and Manager --}}
                    
                        @if (Auth::user()->role_id === 1 || Auth::user()->role_id === 2)
                        {{-- My VICOs --}}
                            <li class="nav-item d-block d-lg-none"><a class="nav-link ml-4" href="{{route('my_houses')}}">{{trans('layouts/app.my_houses')}}</a></li>

                        {{-- Bookings Admin --}}
                            <li class="nav-item d-block d-lg-none"><a class="nav-link ml-4" href="{{route('vico.process')}}">{{trans('layouts/app.my_requests')}}</a></li>

                        {{-- Verificactions --}}
                            <li class="nav-item d-block d-lg-none"><a class="nav-link ml-4" href="{{ route('my_verifications') }}">{{trans('layouts/app.my_verifications')}}</a></li>

                        {{-- Referrals --}}
                            <li class="nav-item d-block d-lg-none"><a class="nav-link ml-4" href="{{ route('my_referrals') }}">{{trans('layouts/app.my_referrals')}}</a></li>
                        
                      
                    {{-- Functions for Students  --}}
                       
                        @else
                        {{-- Bookings Admin --}}
                            <li class="nav-item d-block d-lg-none"><a class="nav-link ml-4" href="{{route('vico.process')}}">{{trans('layouts/app.my_requests')}}</a></li>
                        
                        {{-- Stays Admin -> Enter to payments --}}
                            <li class="nav-item d-block d-lg-none"><a class="nav-link ml-4" href="{{route('bookings.confirmed.user')}}">{{trans('layouts/app.my_stays')}}</a></li>

                        {{-- Favorites --}}
                            <li class="nav-item d-block d-lg-none"><a class="nav-link ml-4" href="{!! route('favorites',Auth::user()->id) !!}">{{trans('layouts/app.my_favourites')}}</a></li>

                        {{-- Verificactions --}}
                            <li class="nav-item d-block d-lg-none"><a class="nav-link ml-4" href="{{ route('my_verifications') }}">{{trans('layouts/app.my_verifications')}}</a></li>

                        {{-- Referrals --}}
                            <li class="nav-item d-block d-lg-none"><a class="nav-link ml-4" href="{{ route('my_referrals') }}">{{trans('layouts/app.my_referrals')}}</a></li>

                        @endif
                        {{-- Logout --}}
                        <li class="nav-item d-block d-lg-none"><a class="ml-4" href="{{route('logout')}}" onclick="event.preventDefault();document.getElementById('fom-logout-form').submit()">{{trans('layouts/app.logout')}}</a></li>
                    @endif
                </ul>

            @endguest


            <ul class="navbar-nav mr-auto">
                {{-- Search for VICO --}}
                <li class="nav-item" onclick="searchOnNavbar()">
                    <a class="nav-link" href=
                        {{
                            Session::has('city_code') ? 
                                __("/vicos/". str_replace(' ','%20',mb_strtolower(\Illuminate\Support\Str::ascii(\App\City::where('city_code', Session::get('city_code'))->first()->name)))) : 
                                '/vicos/medellín'
                        }}><span class="icon-search-black small font-weight-bold" style="color:rgba(255, 255, 255, 0.5);"></span> {{trans('layouts/app.search_vico')}} <span class="sr-only">(current)</span></a>
                </li>

                {{-- About Us --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{route('home.about')}}" onclick="aboutVico()">  <span class="icon-smile small font-weight-bold" style="color:rgba(255, 255, 255, 0.5);"></span> {{trans('layouts/app.about_us')}} <span class="sr-only">(current)</span> </a>
                </li>

                {{-- Blog mobile --}}
                    <li class="nav-item d-block d-lg-none">
                        <a class="nav-link"
                            data-toggle="collapse"
                            data-target="#blogCollapse"
                            aria-expanded="false"
                            aria-controls="blogCollapse"
                            href="#">
                            <span class="icon-edit-black small font-weight-bold" style="color:rgba(255, 255, 255, 0.5);"></span> {{trans('layouts/app.blog')}}<i class="fas fa-caret-right fs-rem-10 ml-2"></i></span>
                        </a>
                    </li>

                    {{-- Blog mobile Collapse --}}
                    <ul class="navbar-nav mr-auto collapse" id="blogCollapse">

                        {{-- Faq Hosts --}}
                        <li class="nav-item d-block d-lg-none" onclick="faqManager()">
                            <a class="nav-link ml-4" href="{{route('questions.host')}}">{{trans('layouts/app.faq_host')}}</a>
                        </li>

                        {{-- Faq Users --}}
                        <li class="nav-item d-block d-lg-none" onclick="faqUser()">
                            <a class="nav-link ml-4" href="{{route('questions.user')}}">{{trans('layouts/app.faq_user')}}</a>
                        </li>

                        {{-- Landingpage Bogota --}}
                        <li class="nav-item d-block d-lg-none">
                            <a class="nav-link ml-4" href="{{route('landingpage.bogota')}}">Bogotá</a>
                        </li>


                        {{-- Blog City --}}
                        <li class="nav-item d-block d-lg-none">
                            <a class="nav-link ml-4" href="https://www.getvico.com/blog/es/medellin/">
                                {{-- {{trans('layouts/app.blog_city')}} --}}
                                Medellín
                            </a>
                        </li>

                        {{-- Blog Info Guests --}}
                        <li class="nav-item d-block d-lg-none">
                            <a class="nav-link ml-4" href="https://www.getvico.com/blog/es/info-invitados/">{{trans('layouts/app.blog_guests')}}</a>
                        </li>

                        {{-- Blog Info Manager --}}
                        <li class="nav-item d-block d-lg-none">
                            <a class="nav-link ml-4" href="https://www.getvico.com/blog/es/info-propietarios/">{{trans('layouts/app.blog_manager')}}</a>
                        </li>
                    </ul>
                {{-- End Blog mobile --}}

                {{-- Blog desktop --}}
                    <li class="nav-item dropdown d-none d-lg-block">
                        <a class="nav-link dropdown-toggle"
                            href="#" role="button"
                            id="blogDropdown"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            <span class="icon-edit-black small font-weight-bold" style="color:rgba(255, 255, 255, 0.5);"></span> {{trans('layouts/app.blog')}}
                        </a>

                        {{-- Blog desktop dropdown --}}
                        <div class="dropdown-menu" aria-labelledby="blogDropdown">

                            {{-- Faq Hosts --}}
                                <a class="dropdown-item" href="{{route('questions.host')}}" onclick="faqManager()">{{trans('layouts/app.faq_host')}}</a>

                            {{-- Faq Users --}}
                                <a class="dropdown-item" href="{{route('questions.user')}}" onclick="faqUser()">{{trans('layouts/app.faq_user')}}</a>

                            {{-- Landing Page Bogota --}}
                            <a class="dropdown-item" href="{{route('landingpage.bogota')}}">Bogotá</a>

                            {{-- Blog City --}}
                            <a class="dropdown-item" href="https://www.getvico.com/blog/es/medellin/">
                            {{-- {{trans('layouts/app.blog_city')}} --}} Medellín</a>

                            {{-- Blog Info Guests --}}
                            <a class="dropdown-item" href="https://www.getvico.com/blog/es/info-invitados/">{{trans('layouts/app.blog_guests')}}</a>

                            {{-- Blog Info Manager --}}
                            <a class="dropdown-item" href="https://www.getvico.com/blog/es/info-propietarios/">{{trans('layouts/app.blog_manager')}}</a>

                        </div>
                    </li>
                {{-- End Blog Desktop --}}

            {{-- Check if User Logged IN --}}
                @if (Auth::check()) 

                {{-- Enable Dashboard for Admin --}}
                    @if (Auth::user()->role_id === 1) 
                        <li>
                            <a class="btn-primary btn mx-2" href="{{route('dashboardForAdmin')}}"><span class="icon-plant-black font-weight-bold text-white"></span> Dashboard</a>
                        </li>
                    @endif

                {{-- Enable Upload VICO for Admin and Manager --}}
                    @if (Auth::user()->role_id === 1 || Auth::user()->role_id === 2)
                        <li>
                            <a class="btn-outline-primary btn vico-color" href="{{route('introduction', 1)}}">+ {{trans('layouts/app.upload_vico')}}</a>
                        </li>
                    @endif 
                
                {{-- Enable Upload VICO for Guests -> Introduction --}}  
                @else
                    <li class="nav-item">
                        <a class="btn-outline-primary btn vico-color" href="/houses/introduction/1">+ {{trans('layouts/app.upload_vico')}}</a>
                    </li>
                @endif
            {{-- End User Logged IN --}}
            </ul>

            <li class="navbar-nav">
                @guest

                @else
                    {{-- Contact Us Button for Logged User and Mobile --}}
                    <li class="nav-item d-none d-lg-block">
                        <a class="nav-link active pl-0 " id="movilContacUs" style="color:rgba(255, 255, 255, 0.5);" href="#"><i class="far fa-comments"></i> {{trans('layouts/app.contact_us')}}</span></a>
                    </li>

                {{-- User My Profile Collapse Desktop --}}
                    <div class="dropdown d-none d-lg-block">
                        <button class="btn btn-secondary dropdown-toggle"
                            type="button" id="dropdownMenu1"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            <span class="icon-no-user font-weight-bold text-white"></span>  {{ ucfirst(Auth::user()->name)}}
                        </button>
                    
                    {{-- Collapse Desktop --}}
                        <div class="dropdown-menu dropdown-menu-right bg-white pb-0 overflow-hidden" aria-labelledby="dropdownMenu1">

                            @if (Auth::check())

                            {{-- User Name --}}
                                <span class="input-group-text border-0 active bold-words">{{ ucfirst(Auth::user()->name)}}</span>

                            {{-- My profile for all users --}}
                                <a class="dropdown-item" href="{!! route('profile',Auth::user()->id) !!}">{{trans('layouts/app.my_profile')}}</a>

                            {{-- Functions for Admin and Manager --}}
                                @if (Auth::user()->role_id === 1 || Auth::user()->role_id === 2)
                                {{-- My VICOs --}}
                                    <a class="dropdown-item" href="{{route('my_houses')}}">{{trans('layouts/app.my_houses')}}</a>

                                {{-- Bookings Admin --}}
                                    <a class="dropdown-item" href="{{route('vico.process')}}">{{trans('layouts/app.my_requests')}}</a>

                                {{-- Verificactions --}}
                                    <a class="dropdown-item" href="{{ route('my_verifications') }}">{{trans('layouts/app.my_verifications')}}</a>

                                {{-- Referrals --}}
                                    <a class="dropdown-item" href="{{ route('my_referrals') }}">{{trans('layouts/app.my_referrals')}}</a>

                                {{-- Reviews --}}
                                    <a class="dropdown-item" href="{{ route('admin_reviews','1') }}">{{trans('layouts/app.my_reviews')}}</a>

                            {{-- Functions for Students  --}}  
                                @else
                                {{-- Bookings Admin --}}
                                    <a class="dropdown-item" href="{{route('vico.process')}}">{{trans('layouts/app.my_requests')}}</a>

                                {{-- Favorites --}}
                                    <a class="dropdown-item" href="{!! route('favorites',Auth::user()->id) !!}">{{trans('layouts/app.my_favourites')}}</a>

                                {{-- Verifications --}}
                                    <a class="dropdown-item" href="{{ route('my_verifications') }}">{{trans('layouts/app.my_verifications')}}</a>

                                {{-- Referrals --}}
                                    <a class="dropdown-item" href="{{ route('my_referrals') }}">{{trans('layouts/app.my_referrals')}}</a>

                                {{-- Stays Admin -> Enter to payments --}}
                                    <a class="dropdown-item" href="{{route('bookings.confirmed.user')}}">{{trans('layouts/app.my_stays')}}</a>
                                
                                {{-- Reviews --}}
                                    <a class="dropdown-item" href="{{ route('user_reviews') }}">{{trans('layouts/app.my_reviews')}}</a>

                                @endif

                            @endif
                          
                        {{-- Logout Button --}}
                            <a class="dropdown-item logout"
                                href="{{route('logout')}}"
                                onclick="event.preventDefault();document.getElementById('fom-logout-form').submit()">
                                {{trans('layouts/app.logout')}}
                            </a>

                            <form id="fom-logout-form" action="{{route('logout')}}" method="POST">
                                {{csrf_field()}}
                            </form>
                        {{-- End Logout Button  --}}

                        </div>
                    </div>
                @endguest
            </li>
            <ul class="navbar-nav">

            
                @guest
                {{-- Contact us Button Desktop--}}
                    <li class="nav-item d-none d-lg-block">
                        <a class="nav-link pl-0 " id="movilContacUs" style="color:rgba(255, 255, 255, 0.5);" href="#"><i class="far fa-comments"></i> {{trans('layouts/app.contact_us')}}</span></a>
                    </li>

                {{-- Login / Register Button for Guests --}}
                    <li class="nav-item">
                        <a class="nav-link btn-primary btn border-radius" data-toggle="modal" id="registerBtn" data-target="#Register" data-dismiss="modal" href="#"><span class="icon-no-user text-white font-weight-bold"></span> {{trans('layouts/app.login')}} / {{trans('layouts/app.register')}}</a>
                    </li>
                    @else
                @endguest
                
            {{-- Contact us Button Mobile --}}
                <a class="nav-link pl-0 d-block d-lg-none" id="movilContacUs" style="color:rgba(255, 255, 255, 0.5);" href="#"><i class="far fa-comments"></i> {{trans('layouts/app.contact_us')}}</span></a>

            {{-- Select region/language/currency Desktop --}}
                <li class="nav-item lang-container d-none d-lg-block">
                    <div class="nav-link"  data-toggle="modal" data-target="#regionConfig" onclick="getCurrentCity()">
                        <img class="btn-flag">
                        <span>{{Session::has('currency') ? Session::get('currency') : 'COP'}} / {{Session::has('city_code') ? Session::get('city_code') : 'MDE'}}</span>
                    </div>  
                </li>
            </ul>
        </div>
    </nav>

    {{-- Message_sent for feedback on method "back->with('message_sent','Your message goes here')" --}}
    @if (\Session::has('message_sent'))
        <div class="alert bg-success text-center p-2 rounded-0" id="message_sent">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            {!! \Session::get('message_sent')!!}
        </div>
    @endif


    <div class="modal fade" id="regionConfig" tabindex="-1" role="dialog" aria-labelledby="regionalConfiguration" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">{{trans('layouts/app.region_header')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="{{route('set_preferences')}}" method="POST">
                @csrf
                <div class="content-display">
                  <div class="select-container">
                    <label for="countryDropdown">{{__('Pais/Region')}}</label>
                      <select name="city_code" class="custom-select" id="cities-select">
                        {{--  <optgroup label="Colombia">
                            <option value="MDE" {{Session::get('city_code') === 'MDE' ? 'selected':''}}>Medellín</option>
                            <option value="BOG" {{Session::get('city_code') === 'BOG' ? 'selected':''}}>Bogotá</option>
                        </optgroup>
                        <optgroup label="Mexico">
                            <option value="MEX" {{Session::get('city_code') === 'MEX' ? 'selected':''}}>Ciudad de México</option>
                        </optgroup>  --}}
                      </select>
                  </div>
                  <div class="select-container" >
                    <img class="btn-flag">                  
                    <label for="languageDropdown" >{{__('Idioma')}}</label>                    
                    <select name="language" class="custom-select" id="language" data-lang={{Lang::locale()}} required>                        
                        <option selected disabled>{{trans('layouts/app.region_language')}}</option>
                        <option {{ Lang::locale() === 'es' ? 'selected': ''}} value="CO">Español</option>
                        <option {{ Lang::locale() === 'en' ? 'selected': ''}} value="US">English</option>
                        <option {{ Lang::locale() === 'de' ? 'selected': ''}} value="DE">Deutsch</option>
                        <option {{ Lang::locale() === 'fr' ? 'selected': ''}} value="FR">Français</option>
                    </select>
                  </div>
                  <div  class="select-container">
                    <label for="currencyDropdown">{{__('Moneda')}}</label>
                    <select name="currency" class="custom-select" required>
                        <option {{!Session::has('currency') ? 'selected': ''}}  disabled>{{trans('layouts/app.region_currency')}}</option>
                        <option {{ Session::get('currency') === 'COP' ? 'selected': ''}} value="COP">COP</option>
                        <option {{ Session::get('currency') === 'EUR' ? 'selected': ''}} value="EUR">EUR</option>
                        <option {{ Session::get('currency') === 'USD' ? 'selected': ''}} value="USD">USD</option>                      
                    </select>                
                  </div>
              </div>            
              <div class="modal-footer align-center">            
                <button type="submit" class="btn btn-primary save-button">Guardar</button>
              </div>
              </form>
          </div>
        </div>
    </div>
</header>
@section('scripts')
<script>
function faqUser() {
    analytics.track('Enter user FAQ',{
        category: 'User knowlage'
    });
}

function faqManager() {
    analytics.track('Enter manager FAQ',{
        category: 'User knowlage'
    });
}

function aboutVico() {
    analytics.track('Enter About VICO page',{
        category: 'User knowlage'
    });
}
</script>
@endsection

