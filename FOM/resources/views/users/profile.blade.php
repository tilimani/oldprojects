@extends('layouts.app')

@section('content')
<section id="profileBg">
  <div class="profile-top-container position-relative">
    <div id="profilePicUser" class="profile-top-container-photo">
    <img src="https://fom.imgix.net/{{$image}}?w=450&h=300&fit=crop" alt="user-pic">
    </div>
    <div class="profile-top-container-name text-center">
    <h3>{{$name}}</h3><span class="badge badge-pill badge-success flex-center"><i class="fas fa-check"></i></span>
    </div>
    <div class="profile-top-container-stars text-center">
      <i class="star"></i>
      <i class="star"></i>
      <i class="star"></i>
      <i class="star"></i>
      <i class="star"></i>
      <span class="vico-color">4.6</span>
    </div>
    <div class="profile-top-container-info text-center">
      <p>Tienes 16 calificaciones</p>
    </div>
  </div>
  <div class="profile-content">
    <ul class="nav nav-tabs nav-justified" id="profileTabList" role="tablist">
      <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#profileTabContent1" role="tab" aria-controls="home" aria-selected="true" id="profileTabTitle1">Mi descripción</a></li>
      <li class="nav-item"><a class="nav-link" href="#profileTabContent2" data-toggle="tab" id="profileTabTitle2" role="tab" aria-controls="home" aria-selected="true">Mis VICOs</a></li>
      <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profileTabContent3" role="tab" aria-controls="home" aria-selected="true" id="profileTabTitle3">Mis notificaciones</a></li>
    </ul>
    <div class="tab-content" id="profileTabContent">
    <div id="profileTabContent1" class="tab-pane fade active show" role="tabpanel" aria-labelledby="profileTabTitle1">{{$description}}</div>
      <div id="profileTabContent2" class="tab-pane fade" role="tabpanel" aria-labelledby="profileTabTitle2">
        
      </div>
      <div id="profileTabContent3" class="tab-pane fade" role="tabpanel" aria-labelledby="profileTabTitle3">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Egestas pretium aenean pharetra magna ac placerat. Ipsum faucibus vitae aliquet nec ullamcorper sit amet risus nullam. Consectetur purus ut faucibus pulvinar elementum integer enim neque volutpat. Sapien nec sagittis aliquam malesuada .</div>
    </div>   
  </div>
</section>
@endsection