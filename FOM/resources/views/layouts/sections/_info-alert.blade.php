
@auth
    
@php 
\App\Http\Controllers\AlertController::getInstance()->Init(Auth::user()->id,Request::path());
$alert = \App\Http\Controllers\AlertController::getInstance()->GetValues();
@endphp
@if($alert['show'])
<div id="info-navbar" class="alert-navbar bg-primary">
    <div class="verify-alert-content">
        <div class="navbar-brand text-white">
            <i class="fa{{$alert['icon']}}"></i>
        </div>
        <span class="nav-link text-white">{{$alert['message']}}</span>
        <a class="btn-outline-light btn" href="{{$alert['url']}}">Verificar</a>
    </div>
    <a class="navbar-btn close-navbar align-middle text-white">X</a>
</div>
@endif
@endauth
