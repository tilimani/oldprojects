@extends('layouts.app')

@section('title', 'VICO Payments')

{{-- @section('styles')
    @include('payments.sections._styles')
@endsection --}}

@section('scripts')
    @include('payments.sections._scripts')
@endsection

@section('content')

<script src="//js.stripe.com/v3/"></script>
<section id="mainSection">
    <div class="row m-0 p-0 text-center bg-light">
        <div class="col-12 mt-1 p-0 mb-1">
            <img class="img-fluid m-0 p-0" style="width: 135px; height: 75px;" src="{{asset('images/vico_logo_transition/VICO_VIVIR_orange.png')}}"  alt="Responsive image">
        </div>
    </div>
    <div class="container-fluid">
        <div class="row mt-3 p-0">
            <div class="col-12 my-0 py-0">
                <p class="text-center h2 m-0 p-0">
                    {{__('Resúmen - Renta #'. $nextBill["cuota"])}}
                </p>
            </div>
        </div>
        <hr class="my-3 w-75">
        <dl class="row m-0 p-0">
            {{-- Each item data list --}}
                <dt class="col-6 my-0 py-0 mx-0 px-0">
                    <p class="text-center"><em>{{__('Renta Mensual') }}</em></p>
                </dt>
                <dd class="col-6 m-0 p-0">
                    <div class="card border-none m-0 p-0">
                        <a class="card-header bg-white m-0 p-0"
                            data-toggle="collapse"
                            href="#billPrice"
                            role="button"
                            aria-expanded="false"
                            aria-controls="billPrice">
                                <p class="text-left m-0 p-0 ml-1">
                                    {{ __('$' . $price . ' COP') }}
                                    <span class="arrow-dropdown ml-3 pt-2 icon-next-fom"></span>
                                </p>
                        </a>
                        <div class="collapse card-body m-0 p-0" id="billPrice">
                            <p class="text-center m-1 p-1">
                                {{ __('$' . round($price * $eur_cop, 2) . ' EUR') }}
                            </p>
                            <p class="text-center m-1 p-1">
                                {{ __('$' . round($price * $usd_cop, 2) . ' USD') }}
                            </p>
                        </div>
                    </div>
                </dd>
            {{-- End item --}}
            <dt class="col-6 my-0 py-0">
                <p class="text-center"><em>Comisión VICO</em></p>
            </dt>
            <dd class="col-6 m-0 p-0">
                <div class="card border-none m-0 p-0">
                    <a class="card-header bg-white m-0 p-0"
                        data-toggle="collapse"
                        href="#vicoPrice"
                        role="button"
                        aria-expanded="false"
                        aria-controls="vicoPrice">
                            <p class="text-left m-0 p-0 ml-1">
                                {{ __('$' . round($price*0.05, 0)  . ' COP') }}
                                <span class="arrow-dropdown ml-4 pt-2 icon-next-fom"></span>
                            </p>
                    </a>
                    <div class="collapse card-body m-0 p-0" id="vicoPrice">
                        <p class="text-center m-1 p-1">
                            {{ __('$' . round($price*0.05 * $eur_cop, 2) . ' EUR') }}
                        </p>
                        <p class="text-center m-1 p-1">
                            {{ __('$' . round($price*0.05 * $usd_cop, 2) . ' USD') }}
                        </p>
                    </div>
                </div>
            </dd>
            <dt class="col-6 my-0 py-0">
                <p class="text-center"><em>Servicio de pago</em></p>
            </dt>
            <dd class="col-6 m-0 p-0">
                <div class="card border-none m-0 p-0">
                    <a class="card-header bg-white m-0 p-0"
                        data-toggle="collapse"
                        href="#servicePrice"
                        role="button"
                        aria-expanded="false"
                        aria-controls="servicePrice">
                            <p class="text-left m-0 p-0 ml-1">
                                {{ __('$' . round($price*0.03, 0) . ' COP') }}
                                <span class="arrow-dropdown ml-4 pt-2 icon-next-fom"></span>
                            </p>
                    </a>
                    <div class="collapse card-body m-0 p-0" id="servicePrice">
                        <p class="text-center m-1 p-1">
                            {{ __('$' . round($price*0.03 * $eur_cop, 2) . ' EUR') }}
                        </p>
                        <p class="text-center m-1 p-1">
                            {{ __('$' . round($price*0.03 * $usd_cop, 2) . ' USD') }}
                        </p>
                    </div>
                </div>
            </dd>
            {{-- Item total --}}
                <dt class="col-6 my-0 py-0">
                    <p class="text-right h3">Total</p>
                </dt>
                <dd class="col-6 m-0 p-0">
                    <hr class="pt-3 m-0">
                    <div class="card border-none m-0 p-0">
                        <a class="card-header bg-white m-0 p-0"
                            data-toggle="collapse"
                            href="#totalPrice"
                            role="button"
                            aria-expanded="false"
                            aria-controls="totalPrice">
                                <p class="text-left m-0 p-0 ml-1">
                                    {{ __('$' . round($totalPrice, 0) . ' COP') }}
                                    <span class="arrow-dropdown ml-3 pt-2 icon-next-fom"></span>
                                </p>
                        </a>
                        <div class="collapse card-body m-0 p-0" id="totalPrice">
                            <p class="text-center m-1 p-1">
                                {{ __('$' . round($totalPrice * $eur_cop, 2) . ' EUR') }}
                            </p>
                            <p class="text-center m-1 p-1">
                                {{ __('$' . round($totalPrice * $usd_cop, 2) . ' USD') }}
                            </p>
                        </div>
                    </div>
                </dd>
            {{-- Ent Total --}}
            <dt class="col-12 m-0 p-0">
                @if($user->stripe_id)
                    <p class="text-center m-0 py-2">
                        <button type="submit"
                            data-toggle="modal"
                            data-target="#confirm-payment"
                            class="btn
                                @if($late)
                                    btn-danger
                                @else
                                    btn-primary
                                @endif">{{__('('.$days.') Pagar')}}</button>
                    </p>
                @else
                    <p class="text-center m-0 py-2">
                        <button type="submit"
                            class="btn
                                @if($late)
                                    btn-danger
                                @else
                                    btn-primary
                                @endif" disabled>{{__('('.$days.') Añadir método de pago')}}</button>
                    </p>
                @endif

            </dt>
        </dl>
    </div>

    <div class="container-fluid mx-0 px-0 drop-bottom">
        <div class="row mx-0 px-0">
            <div class="col-12 mx-0 px-0">
                <div class="card payment-method p-0">
                    @if($user->stripe_id)

                        <a class="card-header selected-payment-method"
                            role="button">
                            <img class="Profilimgsml" src="{{ asset('images/payments/icon-jan-2.png')}}">
                            <p>
                                <span class="text-center">
                                    {{__('Tarjeta ' . $user->card_brand . ' terminada en ' . $user->card_last_four)}}
                                </span>
                            </p>
                        </a>
                    @else
                        <a class="card-header not-selected-payment-method"
                            data-toggle="collapse"
                            href="#creditcardadd"
                            role="button"
                            aria-expanded="false"
                            aria-controls="creditcardadd">
                            <img class="Profilimgsml" src="{{ asset('images/payments/icon-jan-2.png')}}">
                            <p>
                                <span class="text-left m-0 p-0">
                                    Tarjeta
                                </span>
                            </p>
                        </a>
                    @endif

                    <div class="collapse card-body py-1" id="creditcardadd">
                        <form class="m-0 p-0" action="/vico/payments/card" method="post" id="payment-form-card">
                            @include('layouts.sections._paymentform')
                            {{-- <script
                                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                data-key="{{ config('services.stripe.key') }}"
                                data-amount="{{ $priceUSD * 100}}"
                                data-name="Renta VICO"
                                data-description="{{ __('Habitación #'.$room->number) }}"
                                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                data-locale="auto">
                            </script> --}}
                            {{ csrf_field() }}
                            {{-- <input type="hidden" id="use_data_card"     name="use_data_card"> --}}
                            <input type="hidden" id="name_card"         name="name_card">
                            <input type="hidden" id="document_card"     name="document_card">
                            {{-- <input type="hidden" id="document_type_card"name="document_type_card"> --}}
                            <input type="hidden" id="address_card"      name="address_card">
                            {{-- <input type="hidden" id="postal_code_card"  name="postal_code_card"> --}}
                            {{-- <input type="hidden" id="city_card"         name="city_card"> --}}
                            {{-- <input type="hidden" id="country_card"      name="country_card"> --}}
                            <input type="hidden" id="booking_id_card"   name="booking_id_card"  value="{{ $booking->id }}">
                            {{-- <input type="hidden" id="usd_card"          name="usd_card" class="usd"> --}}
                            <input type="hidden" id="stripeEmail"       name="stripeEmail"      value=" {{ $user->email }}">
                            <input type="hidden" id="ctrl_finalPrice"   name="ctrl_finalPrice"  value="{{ $priceEUR }}">
                            <input type="hidden" id="ctrl_finalPriceCOP"   name="ctrl_finalPriceCOP"  value="{{ $totalPrice }}">
                            <input type="hidden" id="ctrl_from" name="ctrl_from" value="{{$nextBill['from']->format('d/m/Y')}}">
                            <input type="hidden" id="ctrl_to" name="ctrl_to" value="{{$nextBill['to']->format('d/m/Y')}} ">

                            <div class="form-group m-0 p-0" id="paymentCard">
                                <label class="text-secondary m-0 p-0" for="card-element">
                                    Tarjeta de crédito
                                </label>
                                @if($user->stripe_id)
                                    <span class="text-center">
                                        {{__($user->card_brand . ' terminada en ' . $user->card_last_four)}}
                                    </span>
                                @else
                                    <div id="card-element"></div>
                                @endif
                                <div class="card-errors" role="alert"></div>
                            </div>
                            <p class="text-center m-0 py-2">
                                <button type="submit"
                                    class="btn
                                    @if($late)
                                        btn-danger
                                    @else
                                        btn-primary
                                    @endif">{{__('('.$days.') Pagar')}}</button>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mx-0 px-0">
            <div class="col-12 mx-0 px-0">
                <div class="card payment-method p-0">
                    <a class="card-header not-selected-payment-method"
                        data-toggle="collapse"
                        href="#paypaladd"
                        role="button"
                        aria-expanded="false"
                        aria-controls="paypaladd">
                        <img class="Profilimgsml" src="{{ asset('images/payments/payment-icon2.png')}}" alt="payment-icon">
                        Paypal
                    </a>
                    {{-- <div class="collapse card-body" id="paypaladd">
                            @include('layouts.sections._paymentform')
                            <form action="/payments/paypal" method="post" id="payment-form-paypal">

                                {{ csrf_field() }}

                                <input type="hidden" id="use_data_paypal" name="use_data_paypal">
                                <input type="hidden" id="name_paypal" name="name_paypal">
                                <input type="hidden" id="document_paypal" name="document_paypal">
                                <input type="hidden" id="document_type_paypal" name="document_type_paypal">
                                <input type="hidden" id="address_paypal" name="address_paypal">
                                <input type="hidden" id="postal_code_paypal" name="postal_code_paypal">
                                <input type="hidden" id="city_paypal" name="city_paypal">
                                <input type="hidden" id="country_paypal" name="country_paypal">

                                <input type="hidden" id="booking_id_paypal" name="booking_id_paypal" value="{{ $booking->id }}">
                                <input type="hidden" id="usd_paypal" name="usd_paypal" >
                                <input type="hidden" id="eur_paypal" name="eur_paypal" >

                                <div class="form-group" id="paymentPaypal">

                                    <label class="text-secondary" style="height: 65px">Paypal</label>

                                    <div class="paypal-errors" role="alert"></div>

                                </div>

                                <button type="submit" class="btn btn-primary">Pagar</button>

                            </form>

                    </div> --}}
                </div>
            </div>
        </div>
        <div class="row mx-0 px-0">
            <div class="col-12 mx-0 px-0">
                <div class="card payment-method p-0">
                    <a class="card-header not-selected-payment-method"
                        data-toggle="collapse"
                        href="#sepaadd"
                        role="button"
                        aria-expanded="false"
                        aria-controls="sepaadd">
                        <img class="Profilimgsml" src="{{ asset('images/payments/payment-icon3.png')}}" alt="payment-icon">
                        Sepa
                    </a>
                    <div class="collapse card-body" id="sepaadd">
                            {{-- @include('layouts.sections._paymentform') --}}
                            <form class="m-0 p-0" action="/payments/sepa" method="post" id="payment-form-sepa">

                                {{ csrf_field() }}

                                <input type="hidden" id="use_data_sepa" name="use_data_sepa">
                                <input type="hidden" id="name_sepa" name="name_sepa">
                                <input type="hidden" id="document_sepa" name="document_sepa">
                                <input type="hidden" id="document_type_sepa" name="document_type_sepa">
                                <input type="hidden" id="address_sepa" name="address_sepa">
                                <input type="hidden" id="postal_code_sepa" name="postal_code_sepa">
                                <input type="hidden" id="city_sepa" name="city_sepa">
                                <input type="hidden" id="country_sepa" name="country_sepa">

                                <input type="hidden" id="booking_id_sepa" name="booking_id_sepa" value="{{ $booking->id }}">
                                <input type="hidden" id="usd_sepa" name="usd_sepa" >
                                <input type="hidden" id="eur_sepa" name="eur_sepa" >

                                <div class="form-group m-0 p-0" id="paymentSepa">

                                    <label for="iban-element" class="text-secondary m-0 p-0">IBAN</label>

                                    <!-- <input type="text" name="iban_element"> -->

                                    <div id="iban-element" name="iban_element"></div>

                                    <div class="sepa-errors text-secondary" role="alert"></div>

                                    <div class="bank-name text-secondary" role="alert"></div>

                                    {{-- <div id="mandate-acceptance">
                                        By providing your IBAN and confirming this payment, you are
                                        authorizing Rocketship Inc. and Stripe, our payment service
                                        provider, to send instructions to your bank to debit your account and
                                        your bank to debit your account in accordance with those instructions.
                                        You are entitled to a refund from your bank under the terms and
                                        conditions of your agreement with your bank. A refund must be claimed
                                        within 8 weeks starting from the date on which your account was debited.
                                    </div> --}}
                                </div>
                                <p class="text-center m-0 p-0">
                                    <button type="submit" class="btn btn-primary">Pagar</button>
                                </p>

                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="services-1" class="section-padding-ash">
    <div class="container-fluid">
        <div class="row mt-3 p-0">
            <div class="col-12 my-0 py-0">
                <p class="text-center h2 m-0 p-0">
                    {{__('Historial')}}
                </p>
            </div>
        </div>
        <div class="row">
            <!-- right panel -->
            <div class="col-lg-10 offset-lg-1 col-sm-12 pr-0 pl-0">
                <div class="span5">
                    <table class="table ml-0 mr-0" >
                        <thead>
                            <th>Cuota</th>
                            <th>
                                <select id="currency-selector" class="custom-select">
                                    <option value="cop">COP</option>
                                    <option value="eur">EUR</option>
                                    <option value="usd">USD</option>
                                 </select>
                            </th>
                            <th class="d-none d-sm-block d-md-block d-lg-block">Fecha</th>
                            <th>Estado</th>
                        </thead>
                        <tbody>
                            @php
                                $flag = 0;
                            @endphp
                            @for($i = 0; $i < sizeof($bill->payments); $i++)
                                <tr {{$bill->payments[$i]['status'] === 0 ? "onclick=selectRow(this)" : ''}}>
                                    <td>{{$bill->payments[$i]['cuota']}}</td>
                                    <td class="form-check-label d-none">
                                      <input type="checkbox" class="payment-periods d-none"
                                          name="payment-period-{{ $i }}"
                                          id="payment-period-{{ $i }}"
                                          value="{{$bill->payments[$i]['price']}}"
                                          {{ $bill->payments[$i]['status'] ? 'checked disabled' : '' }}
                                          <?php
                                              if (!$bill->payments[$i]['status']) {
                                                  $flag ++;
                                              }
                                          ?>
                                          {{ $flag == 1 ? 'checked' : '' }}
                                          onclick="check('payment-period-{{ $i }}', {{$i}})">
                                    </td>
                                    <td>
                                        <p class="currencies cop">
                                            {{ __('$' . $price . ' COP') }}
                                        </p>
                                        <p class="currencies eur d-none">
                                             {{ __('$' . round($price * $eur_cop, 2) . ' EUR') }}
                                        </p>
                                        <p class="currencies usd d-none">
                                            {{ __('$' . round($price * $usd_cop, 2) . ' USD') }}
                                        </p>
                                        {{-- <a class="bg-white m-0 p-0"
                                            data-toggle="dropdown"
                                            id="#price-{{$i}}"
                                            role="button"
                                            aria-haspopup="true"
                                            aria-expanded="false"
                                            aria-controls="price-{{$i}}">
                                            <p class="text-left m-0 p-0 ml-1">
                                                {{ __('$' . $totalPrice . ' COP') }}
                                                <span class="arrow-dropdown ml-3 pt-2 icon-next-fom"></span>
                                            </p>
                                        </a>
                                    <div class="dropdown-menu m-0 p-0" aria-labelledby="price-{{$i}}">
                                            <p class="text-center m-1 p-1">
                                                {{ __('$' . round($totalPrice * $eur_cop, 2) . ' EUR') }}
                                            </p>
                                            <p class="text-center m-1 p-1">
                                                {{ __('$' . round($totalPrice * $usd_cop, 2) . ' USD') }}
                                            </p>
                                        </div>                                         --}}
                                    </td>
                                    <td class="d-none d-sm-block d-md-block d-lg-block">
                                        {{$bill->payments[$i]['from']->format('d/m/Y')}}
                                        <p></p>
                                        {{$bill->payments[$i]['to']->format('d/m/Y')}}
                                    </td>
                                    <td class="">
                                        @switch($bill->payments[$i]['status'])
                                            @case(1)
                                                <span class="badge badge-done pt-2">
                                                    Pagado
                                                </span>
                                            @break
                                            @default
                                                @if($bill->payments[$i]['to'] === $nextBill['to'])
                                                    <span class="badge badge-pending pt-2">
                                                        En proceso
                                                    </span>
                                                @else
                                                    <span class="badge badge-received pt-2">
                                                        Pendiente
                                                    </span>
                                                @endif
                                        @endswitch
                                    </td>
                                </tr>
                            @endfor
                            {{-- <tr class="payment-row pt-1 pb-1" onclick="selectRow(this)">
                                <td>Hab 1 - VICO EXITO</td>
                                <td>600.000 COP</td>
                                <td>14/12/2018</td>
                                <td><img class="Profilimgsml" src="{{ asset('images/payments/icon-jan-2.png')}}"></td>
                                <td>
                                  <span class="badge badge-secondary">
                                      Recibido
                                  </span>

                                </td>
                            </tr>
                            <tr class="payment-row" onclick="selectRow(this)">
                                <td>Hab 1 - VICO EXITO</td>
                                <td>600.000 COP</td>
                                <td>14/12/2018</td>
                                <td><img class="Profilimgsml" src="{{ asset('images/payments/icon-jan-2.png')}}"></td>
                                <td>
                                  <span class="badge badge-secondary">
                                      Recibido
                                  </span>

                                </td>
                            </tr>                                    --}}
                        </tbody>
                    </table>
                </div>
                {{-- <div class="text-center mb-4">
                    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#confirm-payment">Pagar</button>
                </div> --}}
            </div>
        </div>
     </div>
</section>

<div class="modal fade" id="confirm-payment" tabindex="-1" role="dialog" aria-labelledby="confirmPayment" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- @if($bill->payments[0]['from'] === $nextBill['from'])
                    <p class="jn-tui">
                        <span>
                            Costo de transacción + 3%
                        </span>
                        <span class="nodaagyes">
                            {{ __($room->price * 0.03 . 'COP')}}
                        </span>
                    </p>
                    <p class="arrow_box">
                        <font>First month - no transaction fee!</font>
                    </p>
                    <p class="katla" id="total-price">
                        {{ __('Total: ' . $price  . ' COP')}}
                        <p class="aha" id="usdPrice">{{ __('Valor en USD: ' . '$' . $priceUSD)}}</p>
                        <p class="aha" id="eurPrice">{{ __('Valor en EUR: ' . '€' . $priceEUR)}}</p>
                    </p>
                @else
                    <p class="jn-tui">
                        <span>
                            Costo de transacción + 3%
                        </span>
                        <span class="nodaag">
                            {{ __($room->price * 0.03 . 'COP')}}
                        </span>
                    </p>
                    <p class="katla" id="total-price">
                        {{ __('Total: ' . $price . ' COP')}}
                        <p class="aha" id="usdPrice">{{ __('Valor en USD: ' . '$' . $priceUSD)}}</p>
                        <p class="aha" id="eurPrice">{{ __('Valor en EUR: ' . '€' . $priceEUR)}}</p>
                    </p>
                @endif --}}
                <form id="payment_verify">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="payment_code" placeholder="Codigo" class="form-control">
                    </div>
                    <p id="verification-payment-response"></p>
                    <p class="text-right">
                        <button id="submit-payment-verify" type="submit" class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('payment-form-card').submit();">Pagar</button>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
