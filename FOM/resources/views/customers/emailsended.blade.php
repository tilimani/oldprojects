@extends('layouts.app')
@section('title', 'Verificacion') 
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
<div class="container-fluid">
    <div class="row mt-5 row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header">¡Bienvenidos a VICO!</div>
                <div class="card-body">
                    <p class="card-text">Por favor verifica tu correo electronico para asegurar una comunicación fluida. Ingresa a tu correo electronico y haz click al link que te enviamos.</p>
                    <a class="btn btn-primary" href="{{url()->previous()}}">Entiendo</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection