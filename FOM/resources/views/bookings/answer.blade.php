@extends('layouts.app')
@section('title', 'Gracias por tu respuesta')

@section('content')
  <div class="jumbotron jumbotron-fluid px-4 mx-4" style="background-color: white; height: 80vh">
    <div class="col-12">
      <div class="row d-flex justify-content-center">
        <h1 class="">¡Gracias por tu respuesta!</h1>
      </div>

      <div class="row d-flex justify-content-center">
        <span style="font-size: 10rem; color: green;" class="icon-check"></span>
      </div>
      <div class="row d-flex justify-content-center">
        <p>¿Tienes preguntas? Síganos en nuestras redes sociales y nuestro blog para que siempre estés actualizado.</p>
      </div>
      <div class="row d-flex justify-content-center">
        <ul class="text-center list-inline">
          <li class="list-inline-item m-2 text-body" style="font-size: 35px;"><a href="http://facebook.com/friendsofmedellin" target="_blank"><span style="color: #3a3a3a" class="icon-facebook-black"></span></a></li>
          <li class="list-inline-item m-2 text-body"   style="font-size: 35px;"><a href="mailto:contacto@friendsofmedellin.com" target="_blank"><span style="color: #3a3a3a" class="icon-mail-black"><span class="path1"></span><span class="path2"></span></span></a></li>
          <li class="list-inline-item m-2 text-body"   style="font-size: 35px;"><a href="http://instagram.com/friendsofmedellin" target="_blank"><span style="color: #3a3a3a" class="icon-instagram-black"></span></a></li>
          <li class="list-inline-item m-2 text-body"   style="font-size: 35px;"><a href="https://api.whatsapp.com/send?phone=573054440424" target="_blank"><span style="color: #3a3a3a" class="icon-whatsapp-black"></span></span></a></li>
        </ul>
      </div>
    </div>
  </div>

@endsection
