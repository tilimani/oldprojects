@extends('layouts.app')
@section('title', 'Pago manual')
@section('content')
  <div class="container">
    <h1 class="display-4">Formulario de pago manual</h1>

    <div class="custom-control">
        <label for="booking_id">Booking ID:
            <input type="text" name="booking_id" id="booking_id" value="{{ $booking->id }}" disabled>
        </label>
        <label for="vico_name">VICO:
            <input type="text" name="vico_name" id="vico_name" value="{{ $vico->name }}" disabled>
        </label>
        <label for="vico_manager">Manager:
            <input type="text" name="vico_manager" id="vico_manager" value="{{ $manager->name }}" disabled>
        </label>
    </div>
    
    <form method="POST" action="{{ route('paymentmanual.store') }}" id="manual_payment" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
            <input type="hidden" name="payment_import" id="payment_import" value="{{$payment_import}}">
            <input type="hidden" name="payment_type" id="payment_type" value="{{$payment_type}}">
            <input type="hidden" name="payment_resource" id="payment_resource" value="{{$payment_resource}}">
            <input type="hidden" name="booking_id" id="booking_id" value="{{ $booking->id }}">
            <input type="hidden" name="current_account" id="current_account" value="{{$current_account}}">

            <label for="vico_price_cop">Precio VICO Actual COP:
                <input type="text" name="vico_price_cop" id="vico_price_cop" placeholder="{{ $room->price }}">
            </label>

            <label for="vico_price_eur">Precio VICO Actual EUR:
                <input type="text" name="vico_price_eur" id="vico_price_eur" placeholder="{{ $room_price_eur }}">
            </label>

            <label for="amountCOP">Total COP: 
                <input type="text" name="amountCOP" id="amountCOP" placeholder="{{ $total_cop }}">
            </label>

            <label for="amountEUR">Total EUR: 
                <input type="text" name="amountEUR" id="amountEUR" placeholder="{{ $total_eur }}">
            </label>

            <label for="discount_cop">Descuento COP: 
                <input type="text" name="discount_cop" id="discount_cop" placeholder="{{ $discountCop }}">
            </label>

            <label for="discount_eur">Descuento EUR: 
                <input type="text" name="discount_eur" id="discount_eur" placeholder="{{ $discountEur }}">
            </label>

            <label for="comision_cop">Comision de VICO COP: 
            <input type="text" name="comision_cop" id="comision_cop" placeholder="{{ $vico_comision_cop }}">
            </label>

            <label for="comision_eur">Comision de VICO EUR: 
                <input type="text" name="comision_eur" id="comision_eur" placeholder="{{ $vico_comision_eur }}">
            </label>

            <label for="P">Cuota de transacción VICO COP: 
                <input type="text" name="vico_transaction_fee_cop" id="vico_transaction_fee_cop" placeholder="{{ $vico_transaction_fee_cop }}">
            </label>

            <label for="vico_transaction_fee_eur">Cuota de transacción VICO EUR: 
                <input type="text" name="vico_transaction_fee_eur" id="'vico_transaction_fee_eur" placeholder="{{ $vico_transaction_fee_eur }}">
            </label>

            <label for="transaction_fee_cop">Cuota de transacción bancos COP: 
                <input type="text" name="transaction_fee_cop" id="transaction_fee_cop" placeholder="{{ $transaction_fee_cop }}">
            </label>

            <label for="transaction_fee_eur">Cuota de transacción bancos EUR: 
                <input type="text" name="transaction_fee_eur" id="transaction_fee_eur" placeholder="{{ $transaction_fee_eur }}">
            </label>

            <label for="payout">Payout: 
                <input type="text" name="payout" id="payout">
            </label>

            <label for="payout_fee">Costo de transacción para el payou: 
                <input type="text" name="payout_fee" id="payout_fee">
            </label>
        
        </div>
        <div class="col-sm-6">
            <input type="file" name="image" multiple required>
            <label for="image">Foto de comprobante</label>
        </div>
        <div class="form-group">
            <label for="additional_info">Notas adicionales:</label>
            <textarea class="form-control" id="additional_info" rows="3"></textarea>
        </div>
        <button type="submit">Enviar</button>

    </form>
@endsection
