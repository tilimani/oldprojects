<section id="dropdownNavContact" class="">
    <div class="dropdown-nav-overlay" tabindex="-1" role="dialog">
        <span class="dropdown-nav-close"> <i class="fas fa-times"></i></span>
        <div class="dropdown-nav-left">
            <div class="dropdown-nav-left-container">
                <span>{{trans('layouts/app.we_will_in')}}</span>
                <p></p>
            </div>
            <div class="dropdown-nav-left-form">
            <form action="{{route('contact')}}" method="post">
                {{ csrf_field()}}
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="name">{{trans('layouts/app.full_name')}} *</label>
                        <input type="text" 
                            class="form-control" 
                            name="name" 
                            placeholder="Ana Maria Restrepo" 
                            required 
                            autofocus
                            @if(Auth::check())
                                value={{ __(Auth::user()->name.Auth::user()->lastname)}}
                            @else
                                value=""
                            @endif>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="email">{{trans('layouts/app.email')}} *</label>
                        <input type="email" 
                        class="form-control" 
                        name="email" 
                        {{-- pattern="/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/"  --}}
                        required
                        @if(Auth::check())
                            placeholder={{ __(Auth::user()->email)}}
                            value={{ __(Auth::user()->email)}}
                        @else
                            value=""
                            placeholder="me@example.com"
                        @endif>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="cellphone">{{trans('layouts/app.phone_number')}}</label>
                        <input type="tel" 
                            name="cellphone" 
                            id="manager-cellphone" 
                            class="form-control  form-group" 
                            @if(Auth::check())
                                placeholder={{ __(Auth::user()->phone)}}
                                value={{ __(Auth::user()->phone)}}
                            @else
                                value=""
                            @endif
                            required>
                    </div>
                    <div class="d-block form-group col-sm-6">
                        <div class="custom-control custom-radio">
                            <input id="credit" name="option" type="radio" class="custom-control-input" checked required value="1">
                            <label class="custom-control-label" for="credit">{{trans('layouts/app.have_vico')}}</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input id="debit" name="option" type="radio" class="custom-control-input" required value="2">
                            <label class="custom-control-label" for="debit">{{trans('layouts/app.need_vico')}}</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input id="paypal" name="option" type="radio" class="custom-control-input" required value="3">
                            <label class="custom-control-label" for="paypal">{{trans('layouts/app.another_concern')}}</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12">
                        <label for="description">{{trans('layouts/app.description')}}</label>
                        <textarea class="form-control" name="description" rows="3" maxlength="766" required></textarea>
                    </div>
                </div>
                <div class="row pl-3">
                <button type="submit" class="btn btn-primary" style="display: inline-block" onclick="actionContact('description')">
                    <i class="fas fa-location-arrow"></i>
                    {{trans('layouts/app.send_tyc')}}
                </button>
                </div>
            </form>
            </div>
            <span class="dropdown-nav-left-conditions">
{{--                 {{trans('layouts/app.tyc_text_one')}}
                <a class="vico-color" href="#">
                {{trans('layouts/app.tyx_text')}}
                </a>
                {{trans('layouts/app.tyc_text_two')}}
                <a class="vico-color" href="#">
                {{trans('layouts/app.privacy_advice')}}
                </a>. --}}
            </span>
        </div>
        <div class="dropdown-nav-right">
            <div class="dropdown-nav-right-infocall">
                <span>{{trans('layouts/app.call_us')}}</span>
                <p>
                    {{trans('layouts/app.take_a_look')}}. (
                    <u><a href="https://www.google.com/chrome/" target="_blank" data-toggle="tooltip" data-placement="top" title="Abrir enlace">Google Chrome</a></u>, 
                    <u><a href="https://www.mozilla.org/es-ES/firefox/new/" target="_blank" data-toggle="tooltip" data-placement="top" title="Abrir enlace">Mozilla Firefox</a></u>.)
                    <br>
                    {{trans('layouts/app.support_center')}}.

                </p>
                <div class="number-area">
                    <span class="ml-2">
                    <i class="icon-whatsapp-black" style="color: rgb(37,211,102)"></i>
                        <a href="https://wa.me/573054440424" 
                            target="_blank"
                            data-toggle="tooltip" 
                            data-placement="top" 
                            title="Mensaje directo"
                            style="color: rgba(37,211,102, 0.9)">
                                (+57) 305-444-04-24
                        </a>
                    </span>
                </div>
            </div>
            <div class="dropdown-nav-right-faq">
                <span>{{trans('layouts/app.yet_call_us')}}.</span>
                <p class="">
                    <span class="icon-instagram-black pr-1" style="color: rgba(233, 89, 80, 1)"></span>   
                    <a href="https://www.instagram.com/vico_vivirentreamigos"
                        target="_blank" 
                        data-toggle="tooltip" 
                        data-placement="top" 
                        title="Abrir enlace"
                        style="color: rgba(233, 89, 80, 0.9)">
                            Instagram
                    </a>
                </p>
                <p class="">
                    <span class="icon-facebook-black pr-1" style="color: rgba(59, 89, 152, 1)"></span>
                    <a href="https://facebook.com/vico.vivirentreamigos/"
                        target="_blank" 
                        data-toggle="tooltip" 
                        data-placement="top" 
                        title="Abrir enlace"
                        style="color: rgba(59, 89, 152, 0.9)">
                            Facebook
                    </a>
                </p>
            </div>
        </div>
    </div>
</section>



