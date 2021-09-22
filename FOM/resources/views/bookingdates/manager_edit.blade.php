@extends('layouts.app')

@section('title', 'Edit Booking Dates')

@section('styles')
<style>

  body {
    background-image: url('https://i.ibb.co/Ttt3gj7/shutterstock-767299450-2.jpg');
    background-repeat: no-repeat;
    background-color: #3d3d3d;
    background-blend-mode: overlay;
    background-size: cover;
  }

  p {
    font-family: Nunitoregular;
    margin-bottom: 0;
    font-size: 16px;
  }

  #datepickersearch {
    padding-left: 52px;
  }

  .content-to-right {
    color: white;
    display: block;
    margin: auto;
    text-align: center;
    padding: 25px 0px 25px 10px;
  }

  .content-to-left {
    background-color: white;
    border-radius: 15px;
    margin: 0 10px 0 10px;
  }

  .container {
    padding-top: 18.750px;
    margin-top: 30px;
  }

  #vico-orange-logo {
    max-width: 100px;
    padding-bottom: 15px;
    padding-top: 30px;
  }

  #vico-white-logo {
    max-width: 50px;
    padding-bottom: 15px;
  }

  .thumbnail {
    width: 150px;
    height: 150px;
    margin: 25px 0 15px 0;
  }

  .bold {
    font-family: Nunitobold;
  }

  #sabes-fecha {
    margin: 15px 35px 15px 35px;
  }

  .date-picker {
    width: 85%;
    margin: auto;
  }

  .enviar-btn {
    margin-top: 8px;
    padding-bottom: 15px;
    margin-bottom: 25px;
    width: 85%;
  }

  #early-exit {
    display: none;
    color: red;
    padding: 8px 5px 0 5px;
  }

  </style>
@endsection


@section('content')

  <div class="container justify-content-center">
    <div class="row">
      <div class="col-sm-5 content-to-left text-center mb-3">
        <img src = '{{asset('images/editBookingDate/vivir-naranja.png')}}' alt="" id="vico-orange-logo">
        <p><span class="bold">{{trans('bookings/editbookingdates.hello')}}</span>{{trans('bookings/editbookingdates.manager_edit')}} {{$user->name}}
          {{trans('bookings/editbookingdates.here')}} </p>
        @if ($user->image)
        <img class='thumbnail' src="https://fom.imgix.net/{{$user->image}}?w=500&h=500&fit=crop&mask=ellipse&border=6,f19528" id="user-photo">
        @else
        <img class='thumbnail' src="https://fom.imgix.net/{{$user->gender== 1  ? 'manager_7.png' : 'manager_47.png'}}?w=500&h=500&fit=crop">
        @endif
        <p>{{$booking->room->house->name}} - {{trans('bookings/editbookingdates.room')}} #{{$booking->room->number}}</p>
        <p>{{date("d. M y", strtotime($booking->date_from))}} - {{date("d. M y", strtotime($vico_date))}} </p>

        @if ($date_bool)
        <p class='bold' id='sabes-fecha'>{{trans('bookings/editbookingdates.date_will_change')}} {{$user->name}}{{trans('bookings/editbookingdates.going_to_change')}}?</p>
        @else
        <p class='bold' id='sabes-fecha'>
          {{trans('bookings/editbookingdates.renter_changed_date')}}<br>
          {{date("d. M y", strtotime($user_date))}}.</p>
        @endif
        <form action="{{route('bookingdate.manager', $booking->bookingDate->id)}}" method="post" class='justify-content-center'>
          @csrf
          <div class="input-group date-picker">
            <input name = "manager_date" onchange="checkDate('{{$dates_required}}', this.value)"
              class="form-control bg-white text-center" id="datepickersearch" name="date" value=" " autocomplete="off" readonly>
            <div class="input-group-append">
            <label data-input="datepickersearch" class="datepicker-button input-group-text bg-white">
              <i class="icon-z-date"></i>
            </label>
            </div>
          </div>
        <p id="early-exit">{{trans('bookings/editbookingdates.avoid_fine')}}</p>
        @if ($date_bool)
        <button type="submit" class="btn btn-primary enviar-btn" id="accept-btn">{{trans('bookings/editbookingdates.send')}}</button>
        @else
        <button type="submit" class="btn btn-primary enviar-btn" id="accept-btn">{{trans('bookings/editbookingdates.accept')}}</button>

        @endif
        </form>
      </div>
      <div class="col-sm-6 content-to-right">
        <img src="{{asset('images/editBookingDate/logo-blanco.png')}}" id="vico-white-logo">
        <h2>{{strtoupper($user->name)}} {{trans('bookings/editbookingdates.they_always_part')}} <br> {{trans('bookings/editbookingdates.the')}} {{strtoupper($booking->room->house->name)}}
        @if(trans('bookings/editbookingdates.stay') != "bookings/editbookingdates.stay")
          {{trans('bookings/editbookingdates.stay')}}
        @endif
        </h2>
      </div>
    </div>
</form>
@endsection

@section('scripts')

<script>
  //sets date to current date
  function datepicker(userDate){
    userDate = userDate.split('-');
    const y = userDate[0];
    const m = String(userDate[1] - 1);
    const d = userDate[2];
    $('#datepickersearch').datepicker("setDate", new Date(y,m,d));
  }

  function checkDate(earliest, selected){

    // check if giving enough notice
    var earlyExit = document.getElementById('early-exit');
    earliest = earliest.split(' ')[0];
    if (earliest > selected){
     earlyExit.style.display = 'block';
    }
    else {earlyExit.style.display = 'none';}

    // check if accepting or changing
    var enviarBtn = document.getElementById('accept-btn');

    if (selected != "{{$user_date}}"){
      enviarBtn.innerHTML = "{{trans('bookings/editbookingdates.change')}}";
    }
    else {enviarBtn.innerHTML = "{{trans('bookings/editbookingdates.accept')}}";}
  }

  </script>
  
  <script>
    window.onload = init;

    function init() {
        datepicker("{{$user_date}}");
    }
</script>

@endsection
