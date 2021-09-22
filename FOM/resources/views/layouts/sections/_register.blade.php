<div id="Register" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Register" style="overflow:scroll">
    <div class="modal-dialog">
        <div class="modal-content">
            {{-- MODAL HEADER --}}
            <div class="modal-header align-items-center">
                <p class="h4 modal-title">{{trans('layouts/app.create_new_account')}}</p>
                <button type="button" 
                    class="close" 
                    data-dismiss="modal">
                    <span class="icon-close"></span>
                </button>
            </div>
            {{-- MODAL BODY --}}
            <div class="modal-body">
                <label for="name" class="col-12 control-label">
                    {{trans('layouts/app.login_with')}}
                </label>
                <div class="col-md-12">
                    <a href="{{ url('/auth/facebook') }}" class="btn btn-social-icon btn-facebook loginBtn loginBtn--facebook">
                        {{trans('layouts/app.register_fb')}}</i>
                    </a>
                    <a href="{{ url('/auth/google') }}" class="btn btn-social-icon btn-google-plus loginBtn loginBtn--google">
                        {{trans('layouts/app.register_gl')}}</i>
                    </a>
                    <hr>
                    <button class="btn btn-primary btn-block"  
                        data-toggle="modal" 
                        data-target="#CreateAccount" 
                        data-dismiss="modal" 
                        href=""
                        class="btn-link">
                        {{trans('layouts/app.create_with_email')}}
                    </button>
                </div>

                {{-- Advice Login Problems --}}
                <div class="col-12 w-100 mt-2">
                    <div class="alert-info w-100 p-2 rounded">{{trans('layouts/app.login_issues')}} <a target="_blank"  href="https://www.getvico.com/blog/issues-with-log-in/">{{trans('layouts/app.another_concern')}}</a>
                    </div>
                </div>

            </div>
            {{-- MODAL FOOTER --}}
            <div class="modal-footer align-items-center">
            <p class="text-center">
                {{trans('layouts/app.have_account')}}
                <a role="button" 
                    data-toggle="modal" 
                    data-target="#mlogin" 
                    data-dismiss="modal" 
                    href="" class="btn-link"> 
                    {{trans('layouts/app.login')}}
                </a>
            </p>
            </div>
        </div>
    </div>
</div>

{{-- MODAL CREATE ACCOUNT--}}
<div id="CreateAccount" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="CreateAccount" style="overflow:scroll">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            {{-- MODAL HEADER--}}
            <div class="modal-header align-items-center">
                <p class="h4 modal-title">{{trans('layouts/app.create_new_account')}}</p>
                <button type="button" 
                    class="close" 
                    data-dismiss="modal">
                    <span class="icon-close"></span>
                </button>
            </div>
            {{-- MODAL BODY  --}}
            <div class="modal-body">
                <div class="container">
                    <form method="POST" action="{{route('register')}}">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-12">
                                <input type="text" name="name" id="name" class="form-control form-group" placeholder="Name"  required>
                            </div>
                            <div class="col-12">
                                <input type="text" name="lastname" id="lastname" class="form-control form-group" placeholder="Last Name"  required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            @if (\Session::has('email_taken'))
                                <div class="alert" id="email_taken">
                                    <span class="closebtn" id="email_taken" onclick="this.parentElement.style.display = 'none';">&times;</span>
                                {!! \Session::get('email_taken') !!}
                                </div>
                            @endif
                            <div class="col-12">
                                <div class="input-group">
                                    <input type="email" name="email" id="email" class="form-control form-group" placeholder="Email"  required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">@</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control pass form-group" placeholder="Password"  required>
                                    <div class="input-group-append">
                                        <span toggle="#password-field-reg" class="toggle-password input-group-text">
                                            <i class="fa fa-fw fa-eye field-icon"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="tel" name="cellphone" id="cellphone" class="form-control  form-group" placeholder="WhatsApp Number"  required>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-12">
                                <label for="country">{{trans('layouts/app.where_are_u')}}</label>
                                <select class="form-control " name="country" id="lista-usuarios" required></select>
                            </div>
                        </div>
                        <div class="row justify-content-center my-3">
                            <div class="col-6 col-sm-3 form-check">
                                <input type="radio" name="gender" id="create-male" value="1" required>
                                <label for="create-male">
                                    <span class=" display-4 icon-man"></span>
                                </label>
                            </div>
                            <div class="col-6 col-sm-3 form-check">
                                <input type="radio" name="gender" id="create-female" value="2">
                                <label for="create-female">
                                    <span class=" display-4 icon-woman"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row d-flex align-content-center">
                            <div class="col-12 text-center">
                                <p class="h6">{{trans('layouts/app.wanna_be_manager')}}</p>
                            </div>
                            <div class="col-12 text-center">
                                <label class="switch">
                                {{-- <input type="checkbox" name="is_manager" class="checkmanager"> --}}
                                    <input type="checkbox" name="is_manager" id="registerIsManager">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <button type="submit" style="display: none;" id="btnregister"></button>
                        <div class="col-12 d-flex justify-content-center">
                            <button class="btn btn-primary btn-block" onclick="register()">{{trans('layouts/app.register_f')}}</button>
                        </div>
                    </form>
                </div>
            </div>
            {{-- MODAL FOOTER --}}
            <div class="modal-footer align-items-center">
                <div class="col-12 text-center">
                    <p class="text-center">
                        {{trans('layouts/app.have_account')}} 
                        <a href="" 
                            role="button" 
                            data-toggle="modal" 
                            data-target="#mlogin" 
                            data-dismiss="modal" 
                            class="btn-link">
                            {{trans('layouts/app.login')}}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- END MODAL CREATE ACCOUNT--}}
<script type="text/javascript">
    let switchRegister = document.getElementById('registerIsManager');

    if(localStorage.getItem('isCreatingHouse')){
        const isCreatingHouse = JSON.parse(localStorage.getItem('isCreatingHouse'));

        if(isCreatingHouse){
            switchRegister.checked = true;
        } else{
            switchRegister.checked = false;
        }
    }
    
</script>