@extends('layouts.app')

@section('title', 'Confirma tu contraseña')
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
@section('content')
<div class="container">
        <h1 class="text-center text-white mt-3">Verifica tu contraseña</h1>

        <div class="row justify-content-md-center mt-5">
                <div class="col-md-8">
                    <div class="card shadow">
                        {{-- <div class="card-header">Login</div> --}}
                        <div class="card-body">
                            <div>En VICO tu seguridad es lo primero.<br>
                            Necesitamos validar tu contraseña para estar seguros de que eres tú; por favor, digita la contraseña de tu cuenta para ingresar a la sección de pagos.</div>
                            <form class="form-horizontal mt-4" method="POST" action="{{ route('verifyPassword', $id) }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="email" class="col-lg-4 col-form-label text-lg-right">E-Mail Address</label>
                                    @if (\Session::has('url'))
                                        <input type="hidden" name="url" value="{!! \Session::get('url') !!}">
                                    @endif
                                    <div class="col-lg-6">
                                        <input
                                                id="email_normal"
                                                type="email"
                                                class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                name="email"
                                                placeholder="{{ Auth::user()->email }}"
                                                required
                                                autofocus
                                                readonly
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
                                    <div class="col-md-8 col-lg-8 offset-md-2 offset-lg-2">
                                        <div class="col-12 form-group">
                                            <button class="submit btn btn-primary btn-block">{{trans('layouts/app.login')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
