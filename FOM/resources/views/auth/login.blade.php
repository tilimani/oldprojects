@extends('layouts.app')
@section('title', 'Login')
@section('meta')
  <meta name="robot" content="noindex, nofollow">
@stop
@section('content')
@section('styles')
    <style type="text/css">
        .vico-body{
            background: rgb(231,192,129);
            background: -moz-linear-gradient(158deg, rgba(231,192,129,1) 0%, rgba(234,150,15,1) 50%, rgba(173,107,0,1) 100%);
            background: -webkit-linear-gradient(158deg, rgba(231,192,129,1) 0%, rgba(234,150,15,1) 50%, rgba(173,107,0,1) 100%);
            background: linear-gradient(158deg, rgba(231,192,129,1) 0%, rgba(234,150,15,1) 50%, rgba(173,107,0,1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#e7c081",endColorstr="#ad6b00",GradientType=1);
            height: 100vh;
        }
    </style>
@endsection
<div class="container">
    <div class="row justify-content-md-center mt-5">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label for="email" class="col-lg-4 col-form-label text-lg-right">E-Mail Address</label>
                           @if (isset($url))
                                <input type="hidden" name="url" value={{$url}}>
                           @endif 
                            @if (\Session::has('url') && isset(\Session::get('url')['intended']))
                                <input type="hidden" name="url" value="{{ \Session::get('url')['intended'] }}">
                            @endif
                            <div class="col-lg-6">
                                <input
                                        id="email_normal"
                                        type="email"
                                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        name="email"
                                        value="{{ old('email') }}"
                                        required
                                        autofocus
                                >

                                @if ($errors->has('email'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-lg-4 col-form-label text-lg-right">Password</label>

                            <div class="col-lg-6">
                                <input
                                        id="password_normal"
                                        type="password"
                                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        name="password"
                                        required
                                >

                                @if ($errors->has('password'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6 offset-lg-4">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-8 offset-lg-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                    <div class="col-md-12 text-center">
                        <a href="{{ url('login/facebook') }}" class="btn btn-social-icon btn-facebook loginBtn loginBtn--facebook">Login con Facebook</i></a>
                        <a href="{{ url('login/google') }}" class="btn btn-social-icon btn-google-plus loginBtn loginBtn--google">Login con Google</i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
