@extends('layouts.app')

@section('title', 'Proceso de pago VICO')

@section('content')
@if (session('success-stored'))
    <div class="alert-success">
        {{ session('success-stored') }}
    </div>
@endif
@if (session('error-stored'))
    <div class="alert-warning">
        {{ session('error-stored') }}
    </div>
@endif
@if (session('error-booking_id'))
    <div class="alert-warning">
        {{ session('error-booking_id') }}
    </div>
@endif
<div class="container">

  <h1 class="display-4">Agregar un pago manual</h1>
  
	<form method="post" action="{{ route('paymentmanual.info') }}" id="payment_info" enctype="multipart/form-data">
		{{csrf_field()}}
		<div class="form-group">

			<label for="booking_id">Booking Id: 
				<input type="text" name="booking_id" id="booking_id">
      		</label>
      
			<label for="payment_import">Tipo de pago:
				<select class="form-control" name="payment_import" id="payment_import">
					@foreach ($types as $key=>$type)
					<option value="{{$key}}">{{$type}}</option>              
					@endforeach
				</select>
      		</label>
      
			<label for="payment_type">Modo de pago:
				<select class="form-control" name="payment_type" id="payment_type">
					<option value="1">Credit Card</option>
					<option value="2">Sepa/Idel Bank</option>
					<option value="3">Paypal</option>
				</select>
      		</label>
      
			<label for="payment_resource">Fuente de pago:
			<select class="form-control" name="payment_resource" id="payment_resource">
          	@foreach ($methods as $key=>$method)
				<option value="{{$key}}">{{$method}}</option>              
          	@endforeach
			</select>
      </label>
      
      <label for="current_account">Hubicación del pago:
			<select class="form-control" name="current_account" id="current_account">
			@foreach ($methods as $key=>$method)
				<option value="{{$key}}">{{$method}}</option>              
			@endforeach
			</select>
			</label>
		
		</div>
    <button type="submit" class="btn btn-dark">Enviar</button>
    
	</form>
</div>
<br>
<div class="overflow-auto">
<table id="table-payments" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
    <thead>
      <tr>
        <th class="th-sm">Booking id
  
        </th>
        <th class="th-sm">Tipo de pago
  
        </th>
        <th class="th-sm">Nombre
  
        </th>
        <th class="th-sm">Apellido
  
        </th>
        <th class="th-sm">Sexo
  
        </th>
        <th class="th-sm">Nacionalidad
  
        </th>
        <th class="th-sm">Fecha llegada
  
        </th>
        <th class="th-sm">fecha salida
  
        </th>
        <th class="th-sm">VICO
  
        </th>
        <th class="th-sm">Propietario
  
        </th>
        <th class="th-sm">Habitación
  
        </th>
        <th class="th-sm">Total COP
  
        </th>
        <th class="th-sm">Total EUR
  
        </th>
        <th class="th-sm">Valor Habitación
  
        </th>
        <th class="th-sm">Descuento COP - EUR
  
        </th>
        <th class="th-sm">Comision VICO COP - EUR
  
		</th>
		<th class="th-sm">Cuota de Transacción VICO COP - EUR
  
		</th>
        <th class="th-sm">Cuota de Transacción COP - EUR
  
		</th>
		<th class="th-sm">Método de pago
  
		</th>
		<th class="th-sm">Localización actual de estos fondos
  
		</th>
		<th class="th-sm">Imagen sobre el pago
  
		</th>
		<th class="th-sm">Anotaciones
  
		</th>
		<th class="th-sm">Opciones
  
		</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($payments_info as $payment)
      <tr>
		  {{-- booking_id --}}
          <td><a target="_blank" href="/booking/show/{{ $payment['booking_id'] }}">{{ $payment['booking_id'] }}</a></td>
		  {{-- tipo de pago --}}
		  <td>{{ $payment['payment_info']->import }}</td>
		  {{-- nombre --}}
		  <td>{{ $payment['customer_name'] }}</td>
		  {{-- Apellido --}}
		  <td>{{ $payment['customer_lastname'] }}</td>
		  {{-- sexo --}}
		  <td>{{ $payment['customer_gender'] }}</td>
		  {{-- Nacionalidad --}}
		  <td>{{ $payment['customer_nationality'] }}</td>
		  {{-- Fecha llegada --}}
		  <td>{{ $payment['date_from'] }}</td>
		  {{-- Fecha salida --}}
		  <td>{{ $payment['date_to'] }}</td>
			{{-- VICO --}}
          <td><a target="_blank" href="/houses/{{ $payment['vico_id'] }}">{{ $payment['vico_name'] }}</a></td>
		  {{-- Propietario --}}
		  <td>{{ $payment['vico_owner_name'] }}</td>
		  {{-- Habitación --}}
		  <td>{{ $payment['room_number'] }}</td>
		  {{-- Total COP --}}
		  <td>{{ $payment['payment_info']->amountCop }}</td>
		  {{-- Total EUR --}}
		  <td>{{ $payment['payment_info']->amountEur }}</td>
		  {{-- Valor Habitación  --}}
		  <td>{{ $payment['payment_info']->room_price_cop }}</td>
		  {{-- Descuento COP - EUR  --}}
		  <td>{{ __($payment['payment_info']->discount_cop.' - '.$payment['payment_info']->discount_eur) }}</td>
		  {{-- Comision VICO COP - EUR --}}
		  <td>{{ __($payment['payment_info']->vico_comision_cop.' - '.$payment['payment_info']->vico_comision_eur) }}</td>
		  {{-- Cuota de Transacción VICO COP - EUR --}}
		  <td>{{ __($payment['payment_info']->vico_transaction_fee_cop.' - '.$payment['payment_info']->vico_transaction_fee_eur) }}</td>
		  {{-- Cuota de Transacción COP - EUR --}}
		  <td>{{ __($payment['payment_info']->stripe_fee_cop.' - '.$payment['payment_info']->stripe_fee_eur) }}</td>
		  {{-- Metodo de pago --}}
		  @foreach ($methods as $dbMethodName=>$method)
			@if ($payment['payment_info']->payment_method == $dbMethodName)
				<td>{{ $method }}</td>
				{{$exists = true}}		
				@break
			@endif
			{{$exists = false}}
		  @endforeach
		  @if (!$exists)
		  	<td>No registrado</td>
		  @endif
		  {{-- Localización actual de estos fondos --}}
		  @foreach ($methods as $dbMethodName=>$method)
			@if ($payment['payment_info']->current_account == $dbMethodName)
				<td>{{ $method }}</td>
				{{$exists = true}}
				@break
			@endif
			{{$exists = false}}
			@endforeach
			@if (!$exists)
				<td>No registrado</td>
			@endif
		
		{{-- Imagen sobre el pago --}}
		@if ($payment['payment_info']->payment_proof)
			<td><a href="http://fom.imgix.net/{{$payment['payment_info']->payment_proof}}?w=500&h=500&fit=crop">Ver</a></td>
		@else
			<td>No registra imagen</td>
		@endif
		{{-- Anotaciones --}}
			<td><textarea name="info" id="info" cols="30" rows="2" disabled>{{$payment['payment_info']->additional_info}}</textarea></td>
		{{-- Opciones --}}
	  		<td><a href="{{ route('paymentmanual.edit',[$payment['payment_info']->id]) }}" target="_blank">Editar</a></td>
        </tr>
      @endforeach
      
    </tbody>
    {{-- <tfoot>
      <tr>
        <th>Name
        </th>
        <th>Position
        </th>
        <th>Office
        </th>
        <th>Age
        </th>
        <th>Start date
        </th>
        <th>Salary
        </th>
      </tr>
    </tfoot> --}}
  </table>
</div>
@endsection


