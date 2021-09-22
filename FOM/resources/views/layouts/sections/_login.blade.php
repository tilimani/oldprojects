<div id="mlogin" class="modal fade" role="dialog" tabindex="-1" role="dialog" aria-labelledby="CreateAccount" style="overflow:scroll">
    <div class="modal-dialog modal-dialog-centered">
        {{-- MODAL CONTENT --}}
        <div class="modal-content">
            {{-- MODAL HEADER --}}
            <div class="modal-header align-items-center">
                <p class="h4 btn-link">{{trans('layouts/app.login')}}</p>
                <button type="button" class="close" data-dismiss="modal"><span class="icon-close"></span></button>
            </div>
            {{-- MODAL BODY --}}
            <div class="modal-body">
                {{--
                <label id="errorlogin" style="display: none;">These credentials do not mat our records</label>
                <label id="haveaccount" style="display: none;">Actually you have a FOM account</label> --}}
                <label for="name" class="col-12 control-label">
                    {{trans('layouts/app.login_with')}}
                </label>
                <div class="col-md-12">
                    @if (\Session::has('error_social'))
                        <div class="alert" id="error_social">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                            {!! \Session::get('error_social')!!}
                        </div>
                    @endif
                    <a href="{{ url('/auth/facebook') }}" class="btn btn-social-icon btn-facebook loginBtn loginBtn--facebook">
                        {{trans('layouts/app.register_fb')}}</i>
                    </a>
                    <a href="{{ url('/auth/google') }}" class="btn btn-social-icon btn-google-plus loginBtn loginBtn--google">
                        {{trans('layouts/app.register_gl')}}</i>
                    </a>
                </div>
                <hr>
                <form class="form-horizontal" method="POST" action="{{ route('login')}}">
                    {{csrf_field()}} 
                    {{-- @if(!empty($errors->any()))
                    <label id="errorMessage">{{$errors->first()}}</label id="errorMessage">
                    @endif --}}
                    @if (\Session::has('error_mail_paswwd'))
                        <div class="alert" id="error_mail_paswwd">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                            {!! \Session::get('error_mail_paswwd') !!}
                            </div>
                        @endif
                    <div class="col-12 form-group">
                        <div class="input-group">
                            <input type="email" name="email" class="form-group form-control" id="emaillog" placeholder="Email" required>
                            <div class="input-group-append">
                                <span class="input-group-text">@</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 form-group">
                        <div class="input-group">
                            <input type="password" name="password" class="form-group form-control pass" id="passwordlog" placeholder="Contraseña" required autocomplete="off">
                            <div class="input-group-append">
                                <span toggle="#password-field-log" class="toggle-password input-group-text">
                                    <i class="fa fa-fw fa-eye field-icon"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 form-group">
                        <button class="submit btn btn-primary btn-block">{{trans('layouts/app.login')}}</button>
                    </div>
                </form>
                {{-- Advice Login Problems --}}
                <div class="col-12 w-100 mt-2">
                    <div class="alert-info w-100 p-2 rounded">{{trans('layouts/app.login_issues')}} <a target="_blank" href="https://www.getvico.com/blog/issues-with-log-in/">{{trans('layouts/app.another_concern')}}</a>
                    </div>
                </div>
                
            </div>
            {{-- MODAL FOOTER --}}
            <div class="modal-footer">
                <div class="col-12 text-center">
                    <p><a href="{{route('password.request')}}" role="button">{{trans('layouts/app.forgot_password')}}</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

