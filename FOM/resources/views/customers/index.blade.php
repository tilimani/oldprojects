@extends('layouts.app') 
@section('content') {{--
<link href="{{ asset('css/review_style.css') }}" rel="stylesheet"> --}}

<div class="container-fluid">
    <div class="row">
        {{--
        <div class="sidebar px-1 d-none d-sm-block">
            <div class="profile-info">
                <img src="//:0" class="profile-picture">
                <h4 class="profile-name">Santiago</h4>
            </div>
            <hr/>
            <div class="py-2 sticky-top flex-grow-1">
                <div class="nav flex-sm-column mt-5 text-center">
                    <a href="{{route('profile',[Auth::user()->id])}}" class="sidebar-link mt-1">Editar mi cuenta</a>
                    <a href="/user/verification" class="sidebar-link mt-1">Verificación</a>
                    <a href="/myhouses" class="sidebar-link mt-1">Mis vicos</a>
                    <a href="" class="sidebar-link mt-1">Mis reseñas</a>
                    <a href="" class="sidebar-link mt-1">Log-Out</a>
                </div>
            </div>
        </div> --}}

        {{-- <div class="sidebar">
            <div class="profile-info">
                <img src="//:0" alt="" class="profile-picture">
                <div class="profile-text">
                    <h4 class="profile-name">Santiago</h4>
                    <span class="profile-email">santisanchez.1214@gmail.com</span>
                    <span class="profile-number">+573022136907</span>
                </div>
            </div>
            <hr>
            <ul class="sidebar-links">
                <li class="sidebar-link">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </li>
                <li class="sidebar-link">
                    <i class="far fa-heart"></i>
                    <span>Favoritos</span>
                </li>
                <li class="sidebar-link">
                    <i class="far fa-address-book"></i>
                    <span>Mis Solicitudes</span>
                </li>
                <li class="sidebar-link" id="my-profile" data-toggle="collapse" data-target="#profile-list">
                    
                        <i class="far fa-user"></i>
                        <span>Mi Perfil</span>
                        <i id="profile-arrow" class="right"></i>
                    
                </li>
                <ul class="list" id="profile-list">
                    <li class="sidebar-link">Datos</li>
                    <li class="sidebar-link">Notificaciones</li>
                    <li class="sidebar-link">Verificación</li>
                </ul>
                <li class="sidebar-link">
                    <i class="fas fa-home"></i>
                    <span>Mi VICO</span>
                    <i class="right"></i>
                </li>
            </ul>
            <div class="sidebar-footer">
                <hr>
                <ul class="sidebar-links">
                    <li class="sidebar-link">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </li>
                    <li class="sidebar-link">
                        <span>@vico_vivirentreamigos</span>
                        <i class="fab fa-facebook-square"></i>
                        <i class="fab fa-instagram"></i>
                    </li>
                </ul>
            </div>
        </div> --}}

        <div class="col" id="main">
            <div class="row">
                @yield('contentReview')
            </div>
        </div>
    </div>
</div>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>
{{--
<script src="{{ asset('js/review_js.js') }}"></script> --}}
@endsection