@extends('layouts.app')

@section('title', 'Registrar un Nuevo Pago')

@section('styles')
<style>

    body {
      background-image: url('https://i.ibb.co/Ttt3gj7/shutterstock-767299450-2.jpg');
      background-repeat: no-repeat;
      background-color: #3d3d3d;
      background-blend-mode: overlay;
      background-size: cover;
      font-family: Nunitoregular;
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
      margin: 0 10px 0 10px;
      border-radius: 15px;
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
    
    .bold {
      font-family: Nunitobold;
    }
    
    .upload-btn {
      padding: 10px 0 10px 0;
    }
    
    .enviar-btn {
      margin-top: 8px;
      padding-bottom: 15px;
      margin-bottom: 25px;
      width: 85%;
    }
    
    .input {
      width: 85%;
      justify-content: center;
      margin: 10px auto;
    }
    
    
    input[type="radio"] {
      margin-right: 10px;
      margin-left: 15px;
    
    }
    
    input[type="checkbox"] {
      margin-right: 10px;
    }
    
    input {
      text-align: center;
      font-family: Nunitoregular;
      justify-content: center;
    }
    
    .booking-dropdown {
      width: 85%;
      margin: 10px auto;
    }
    
    select {
      width: 400px; 
      text-align-last: center; 
      font-family: Nunitoregular;
    }
    
    #not-bold {
      font-family: Nunitoregular;
    }
</style>
  
@endsection

{{-- <script> window.onload = datepicker("{{$manager_date}}"); </script> --}}

@section('content')
    




  <!-- null image handling currently its always the male one -->
  <!-- set the proper routes -->
  <!-- image hosting -->
  @if (session('error-manual-payment'))
    <div class="alert alert-success" role="alert">
        {{ session('error-manual-payment') }}
    </div>
  @endif
  <div class="container justify-content-center">
    <div class="row">
      <div class="col-sm-5 content-to-left text-center">
      <img src = '{{asset('images/editBookingDate/vivir-naranja.png')}}' alt="" id="vico-orange-logo">

        <p class="nuevo-pago bold"> Registrar un nuevo pago </p>
        <form action="
			@if(Route::currentRouteName() == 'manager.paymentmanual')
				{{ route('manager.paymentmanual.store') }}
			@elseif(Route::currentRouteName() == 'user.paymentmanual')
				{{ route('user.paymentmanual.store') }}
			@endif
        " method="POST" id="pago-form" enctype="multipart/form-data">
          {{ csrf_field() }}
          <input type="hidden" name="booking_id" id="booking_id" value="{{ $booking_id }}">
          <div class="input">
              <input type="radio" name="payment_import" value="Deposit" {{$payment_import == 'Deposit' ? 'checked' : ''}} id='button_deposit'> <span id='not-bold'>Deposito</span> 
              <input type="radio" name="payment_import" value="Rent" {{$payment_import == 'Rent' ? 'checked' : ''}} id='button_rent'> <span id='not-bold'>Renta</span><br>
          </div>

          <input type="text" name="amountCop" id="amountCop" placeholder="Valor en COP Estimado {{ $payment_amount }}" class="input"> <br>
          
          <div class="form-group booking-dropdown">
              <select name="booking" value="select booking" class="form-control" id="sel1" {{Auth::user()->role_id == 3 ? 'disabled': ''}}>
                <option disabled>Activo</option>
                @foreach ($bookings as $vicoInfo)
                    @if ($vicoInfo[key($vicoInfo)]->status == 5)
                    <option value="{{$vicoInfo[key($vicoInfo)]->id}}" {{ $booking_id == $vicoInfo[key($vicoInfo)]->id ? 'selected' : ''}}> {{__(key($vicoInfo).': '.$vicoInfo[key($vicoInfo)]->user->name.' '.$vicoInfo[key($vicoInfo)]->user->last_name)}} </option> 
                    @endif
                @endforeach
                <option disabled>Esperando</option>
                @foreach ($bookings as $vicoInfo)
                    @if ($vicoInfo[key($vicoInfo)]->status == 4)
                    <option value="{{$vicoInfo[key($vicoInfo)]->id}}" {{ $booking_id == $vicoInfo[key($vicoInfo)]->id ? 'selected' : ''}}> {{__(key($vicoInfo).': '.$vicoInfo[key($vicoInfo)]->user->name.' '.$vicoInfo[key($vicoInfo)]->user->last_name)}} </option> 
                    @endif
                @endforeach
              </select>
            </div>
          
          <textarea name="additional_info" class='input' style = "font-family: Nunitoregular;" form="pago-form" placeholder="Nota"></textarea> <br>
          
          <div class="input-group mb-3 input"> 
              <div class="custom-file" id="not-bold">
                <input type="file" class="custom-file-input" id="payment_proof" name="payment_proof" {{Auth::user()->role_id == 3 ? 'required' : ''}}>
                <label class="custom-file-label" for="payment_proof">Subir archivos</label>
              </div>
            </div>

          <div class="input"> 
              <input type="checkbox" name="may_send_confirmation" id="may_send_confirmation"> <span id="not-bold">Mandar confirmación de pago </span> <br>
          </div>
          <button type="submit" class="btn btn-primary enviar-btn" id="accept-btn">Enviar</button>
        </form>
      </div>

      <div class="col-sm-6 content-to-right">
        <img src="https://i.ibb.co/6rwvdTk/logo.png" id="vico-white-logo">
        <h2>TODO PARA TU SEGURIDAD</h2>
      </div>
    </div>
@endsection
