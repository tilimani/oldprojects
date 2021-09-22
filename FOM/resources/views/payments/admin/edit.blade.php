@extends('layouts.app')
@section('title', 'Pago manual')
@section('content')

<form method="POST" action="{{ route('paymentmanual.update',[$payment_info->id]) }}" id="edit_payment" enctype="multipart/form-data">
    {{csrf_field()}}
    {{ method_field('PATCH') }}
    <div class="form-group">
        <label for="booking_id">Booking id</label>
        <input type="text" class="form-control" id="booking_id" name="booking_id" value="{{ $payment_info->booking_id }}">
    </div>

    <div class="form-group">
        <label for="amountEur">Total EUR</label>
        <input type="text" class="form-control" id="amountEur" name="amountEur" value="{{ $payment_info->amountEur }}">
      </div>
      
      <div class="form-group">
        <label for="amountCop">Total COP</label>
        <input type="text" class="form-control" id="amountCop" name="amountCop" value="{{ $payment_info->amountCop }}">
      </div>
      
      <div class="form-group">
        <label for="import">Tipo de pago</label>
        <select class="form-control" name="import" id="import">
            @foreach ($types as $key=>$type)
                <option value="{{$key}}" {{$payment_info->import == $key ? 'selected' : ''}} >{{$type}}</option>              
            @endforeach
        </select>
        {{-- <input type="text" class="form-control" id="import" name="import" value="{{ $payment_info->import }}"> --}}
      </div>
      
      <div class="form-group">
        <label for="discount_cop">Descuento COP</label>
        <input type="number" class="form-control" id="discount_cop" name="discount_cop" value="{{ $payment_info->discount_cop }}">
      </div>
      
      <div class="form-group">
        <label for="discount_eur">Descuento EUR</label>
        <input type="number" class="form-control" id="discount_eur" name="discount_eur" value="{{ $payment_info->discount_eur }}">
      </div>
      
      <div class="form-group">
        <label for="room_price_cop">Precio de la room COP</label>
        <input type="number" class="form-control" id="room_price_cop" name="room_price_cop" value="{{ $payment_info->room_price_cop }}">
      </div>
      
      <div class="form-group">
        <label for="room_price_eur">Precio de la room EUR</label>
        <input type="number" class="form-control" id="room_price_eur" name="room_price_eur" value="{{ $payment_info->room_price_eur }}">
      </div>
      
      <div class="form-group">
        <label for="vico_comision_cop">Comision de manejo VICO COP</label>
        <input type="number" class="form-control" id="vico_comision_cop" name="vico_comision_cop" value="{{ $payment_info->vico_comision_cop }}">
      </div>
      
      <div class="form-group">
        <label for="vico_comision_eur">Comision de manejo VICO EUR</label>
        <input type="number" class="form-control" id="vico_comision_eur" name="vico_comision_eur" value="{{ $payment_info->vico_comision_eur }}">
      </div>
      
      <div class="form-group">
        <label for="vico_transaction_fee_cop">Comision de VICO por transacción COP</label>
        <input type="number" class="form-control" id="vico_transaction_fee_cop" name="vico_transaction_fee_cop" value="{{ $payment_info->vico_transaction_fee_cop }}">
      </div>
      
      <div class="form-group">
        <label for="vico_transaction_fee_eur">Comision de VICO por transacción EUR</label>
        <input type="number" class="form-control" id="vico_transaction_fee_eur" name="vico_transaction_fee_eur" value="{{ $payment_info->vico_transaction_fee_eur }}">
      </div>
      
      <div class="form-group">
        <label for="fee_cop">Comision bancaria por transacción COP</label>
        <input type="number" class="form-control" id="fee_cop" name="fee_cop" value="{{ $payment_info->fee_cop }}">
      </div>
      
      <div class="form-group">
        <label for="fee_eur">Comision bancaria por transacción EUR</label>
        <input type="number" class="form-control" id="fee_eur" name="fee_eur" value="{{ $payment_info->fee_eur }}">
      </div>
      
      <div class="form-group">
        <label for="payment_method">Método de pago</label>
        <select class="form-control" name="payment_method" id="payment_method">
            @foreach ($methods as $key=>$method)
              <option value="{{$key}}" {{$payment_info->payment_method == $key ? 'selected' : ''}} >{{$method}}</option>              
            @endforeach
        </select>        
      </div>
      
      <div class="form-group">
        <label for="current_account">Acá lo encuentro</label>
        <select class="form-control" name="current_account" id="current_account">
            @foreach ($methods as $key=>$method)
              <option value="{{$key}}" {{$payment_info->current_account == $key ? 'selected' : ''}} >{{$method}}</option>              
            @endforeach
        </select>        
        {{-- <input type="text" class="form-control" id="current_account" name="current_account" value="{{ $payment_info->current_account }}"> --}}
      </div>
      
      <div class="form-group">
        <label for="payout">Payout</label>
        <input type="number" class="form-control" id="payout" name="payout" value="{{ $payment_info->payout }}">
      </div>
      
      <div class="form-group">
        <label for="payout_fee">Costo de transacción del Payout</label>
        <input type="number" class="form-control" id="payout_fee" name="payout_fee" value="{{ $payment_info->payout_fee }}">
      </div>
      
      <div class="form-group">
        <label for="additional_info">Información adicional</label>
        <input type="text" class="form-control" id="additional_info" name="additional_info" value="{{ $payment_info->additional_info }}">
      </div>

      <button type="submit">Enviar</button>
    
  </form>

@endsection
