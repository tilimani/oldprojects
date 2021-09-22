<div class="{{__('container history-container no-margin')}}">
    <div class="row no-margin">
        <div class="col-12 no-margin" id="accordion">
            @if($content or $addpayment or ($change and !$cards))
                {{--  @if($content and !$user->card_last_four)  --}}
                @if($content)
                    <form action="{{ route('pay_booking') }}" method="POST" id="payment-form-card">
                @elseif($addpayment or ($change and !$cards))
                    <form action="{{ route('payments_card_add') }}" method="POST" id="payment-form-card">
                {{--  @elseif($content and $cards)
                    <form action="{{route('payments_card')}}" method="POST" id="payment-form-card">  --}}
                @endif
                <div class="card">
                    <a class="card-collapse card-collapse-active collapsed show" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                        aria-controls="collapseOne">
                        <div class="card-header text-secondary" id="headingOne">
                            <h5 class="mb-0">
                                1 {{trans('payments.select_payment')}}
                                <i class="fa fa-chevron-right float-right"></i>
                            </h5>
                        </div>
                    </a>

                        @csrf
                        <input type="hidden" id="name_card"         name="name_card">
                        <input type="hidden" id="document_card"     name="document_card">
                        <input type="hidden" id="address_card"      name="address_card">
                        <input type="hidden" id="booking_id_card"   name="booking_id_card" value="{{ $booking->id }}">
                        <input type="hidden" id="stripeEmail"       name="stripeEmail" value=" {{ $user->email }}">
                        <input type="hidden" id="ctrl_finalPrice"   name="ctrl_finalPrice" value="{{ $priceEUR }}">
                        <input type="hidden" id="ctrl_finalPriceCOP"    name="ctrl_finalPriceCOP" value="{{ $totalPrice }}">
                        @if (Route::currentRouteName() == 'payments_deposit')
                            <input type="hidden" name="ctrl_deposit" value="true">
                        @endif
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                @if($content and $cards)
                                    @foreach($cards as $card)
                                        <label class="custom-radio d-inline-block">
                                            <p class="h6 font-weight-bold text-left">
                                                <img style="width: 1.5875rem" class="m-0 p-0" src="{{ asset('images/payments/icon-jan-2.png')}}">
                                                {{__('---- ---- ---- ' . $card->last4)}}
                                            </p>                                        
                                            <input name="payment_method" type="radio" value="{{ $card->id }}" data-last4={{$card->last4}} data-brand={{$card->brand}} {{ ($card->id === $customer->default_source) ? "checked" : "" }}>
                                            <span class="checkmark"></span>
                                        </label>
                                        <span class="text-danger mx-3 cursor-pointer" onclick="showConfirmationPopup(this)" data-source="{{$card->id}}">Borrar</span>
                                        <div class="payment-method">
                                        <div class="popup-delete-method" id="{{$card->id}}">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <p class="h6">{{trans('payments.are_you_sure')}}</p>
                                                        <div class="mt-3 d-flex justify-content-around">
                                                            <button type="button" class="btn btn-secondary float-right" onclick="hideDeletePopup(this)" data-source="{{$card->id}}" >{{trans('payments.cancel')}}</button>
                                                            <button type="button" class="btn btn-primary float-right" onclick="deletePaymentMethod(this)" data-source="{{$card->id}}" data-token="{!! csrf_token() !!}">{{trans('payments.confirm')}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <a class="text-left" href="{{__('/payments/add/'.$booking->id)}}">{{trans('payments.add_payment')}}</a>
                                @elseif($addpayment or (!$cards and $content) or ($change and !$cards))
                                    <label class="custom-radio">
                                        <p>
                                            {{trans('payments.credit_card')}}
                                            <img style="width: 1.5875rem" class="m-0 p-0" src="{{ asset('images/payments/icon-jan-2.png')}}">
                                        </p>
                                        <input value="paymentCard" name="payment-method-type" type="radio" checked>
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="custom-radio text-secondary">
                                        <p>
                                            {{trans('payments.paypal')}}
                                        </p>
                                        {{-- <input name="payment-method-type" type="radio"> --}}
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="custom-radio text-secondary">
                                        <p>
                                            {{trans('payments.sepa')}}
                                            <img style="width: 1.5875rem" class="m-0 p-0" src="{{ asset('images/payments/payment-icon3.png')}}">
                                            {{trans('payments.coming_soon')}}

                                        </p>
                                        {{-- <input name="payment-method-type" type="radio"> --}}
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="custom-radio">
                                        <p>
                                            {{trans('payments.cash')}} 
                                            <img style="width: 1.5875rem" class="m-0 p-0" src="{{ asset('images/payments/payment-icon2.png')}}">
                                        </p>
                                        <input value="cash" name="payment-method-type" type="radio">
                                        <span class="checkmark"></span>
                                    </label>
                                @endif
                                <a class="btn btn-primary float-right mb-4 select-payment-method"
                                        data-toggle="collapse"
                                        @if($addpayment or !$cards)
                                            data-target="#collapseTwo"
                                        @else
                                            data-target="#collapseThree"
                                        @endif
                                        aria-expanded="true"
                                        aria-controls="collapseTwo">
                                    {{trans('payments.use_this')}}
                                </a>
                            </div>
                        </div>
                    </div>
                    @if($addpayment or !$cards)
                        <div class="card">
                            <a class="card-collapse collapsed select-payment-method"
                                data-toggle="collapse"
                                data-target="#collapseTwo"
                                aria-expanded="false"
                                aria-controls="collapseTwo">
                                <div class="card-header text-secondary" id="headingTwo">
                                    <h5 class="mb-0">
                                        2 {{trans('payments.add_payment_details')}}
                                        <i class="fa fa-chevron-right float-right"></i>
                                    </h5>
                                </div>
                            </a>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body">
                                <div class="alert alert-danger" style="display:none"></div>
                                <div id="card-form">

                                    <div class="form-group pb-0 mb-1">
                                        <label for="ctrl_name" class="text-secondary p-0 m-0">{{trans('payments.complete_name')}}</label>
                                        <div class="input-group">
                                            <input type="text" vico="name" class="form-control vico-payment-control border-radius" name="ctrl_name" id="ctrl_name" value="{{ __($user->name . ' ' . $user->last_name)}}">
                                        </div>
                                    </div>
                                    <div class="form-group pb-0 mb-1">
                                        <label class="text-secondary p-0 m-0"
                                                for="ctrl_document">
                                                {{trans('payments.id_number')}}
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="form-group">
                                                    <select name="ctrl_document_type" class="form-control border-radius-left" id="document-type">
                                                        <option value="passport" selected>{{trans('payments.passport')}}</option>
                                                        <option value="id">Cedula</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <input type="text"
                                                    class="form-control vico-payment-control border-radius-right"
                                                    aria-label=""
                                                    vico="document"
                                                    id="ctrl_document"
                                                    name="ctrl_document">
                                        </div>
                                    </div>
                                    <div class="form-group pb-0 mb-1">
                                        <label for="ctrl_address" class="text-secondary p-0 m-0">{{trans('payments.address')}}</label>
                                        <div class="input-group">
                                            <input
                                                    type="text"
                                                    vico="address"
                                                    id="ctrl_address"
                                                    name="ctrl_address"
                                                    class="form-control vico-payment-control border-radius">
                                        </div>
                                    </div>
                                    <div class="form-row pb-0 mb-1">
                                        <div class="form-group pb-0 mb-1 col-4">
                                            <label class="text-secondary p-0 m-0" for="ctrl_postal">{{trans('payments.postal')}}</label>
                                            <input
                                                    type="number"
                                                    vico="postal"
                                                    id="ctrl_postal"
                                                    name="ctrl_postal"
                                                    class="form-control border-radius">
                                        </div>
                                        <div class="form-group pb-0 mb-1 col-8">
                                            <label class="text-secondary p-0 m-0" for="ctrl_city">{{trans('payments.city')}}</label>
                                            <input
                                                    type="text"
                                                    vico="city"
                                                    id="ctrl_city"
                                                    name="ctrl_city"
                                                    class="form-control border-radius">
                                        </div>
                                    </div>
                                    <div class="form-group pb-0 mb-1">
                                        <label for="country" class="text-secondary p-0 m-0">{{trans('payments.country')}}</label>
                                        <div class="input-group">
                                            <select class="form-control border-radius" name="ctrl_country" id="manager-lista-usuarios">
                                            <input type="text" hidden>
                                        </div>
                                    </div>
                                    <div id="method-paymentCard" class="d-none">
                                        <div class="form-group m-0 p-0">
                                            <label class="text-secondary m-0 p-0" for="card-element">
                                                Tarjeta de crédito
                                            </label>
                                            {{--  @if($user->stripe_id and $content)  --}}
                                            @if($cards and $content)
                                                <span class="text-center">
                                                    {{__($user->card_brand . ' terminada en ' . $user->card_last_four)}}
                                                </span>
                                            @else
                                                <div id="card-element" class="border-radius"></div>
                                            @endif
                                            <div class="card-errors" role="alert"></div>
                                        </div>
                                    </div>
                                    <a class="btn btn-primary float-right mt-4 mb-4"
                                        id="submit-payment-data">
                                    {{trans('payments.save_payment')}}
                                </a>
                                </div>
                                <div id="method-cash" class="d-none">
                                    {{trans('payments.cash_payments')}}
                                    <a class="btn btn-primary float-right mb-4"
                                    data-toggle="collapse"
                                    data-target="#collapseThree"
                                    aria-expanded="true"
                                    aria-controls="collapseThree">
                                {{trans('payments.accept')}}
                                </a>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="card">
                        <a class="card-collapse collapsed">
                            <div class="card-header text-secondary" id="headingThree">
                                <h5 class="mb-0">
                                    @if(($content and $cards) or ($change and $cards))
                                        2 {{trans('payments.confirm_order')}}
                                    @elseif(($content and !$cards) or $addpayment or ($change and !$cards))
                                        3 {{trans('payments.confirm_order')}}
                                    @endif
                                    <i class="fa fa-chevron-right float-right"></i>
                                </h5>
                            </div>
                        </a>
                        <div id="collapseThree"
                            class="collapse"
                            aria-labelledby="headingThree"
                            data-parent="#accordion">
                            <div class="card-body">
                                @if($content)
                                    <p><b>{{trans('payments.summary_of_order')}}</b></p>
                                    <table class="table no-margin">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{trans('payments.monthly_rent_cost')}}
                                                </td>
                                                <td>
                                                    @if($nextBill)
                                                    {{__($nextBill['from']->format('d. F') . ' hasta el ' . $nextBill['to']->format('d. F'))}}
                                                    @else
                                                        {{trans('payments.monthly_rent_cost')}}: {{__($date_now->format('d. F') . ' hasta el ' . $date_now->format('d. F'))}}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{trans('payments.for')}}:
                                                </td>
                                                <td>
                                                    {{__('Habitación ' . $room->number . ' en ' .$house->name)}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{trans('payments.owner')}}
                                                </td>
                                                <td>
                                                    {{$manager}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{trans('payments.total_value')}}
                                                </td>
                                                <td>
                                                    @if (Route::currentRouteName() == 'payments_user')
                                                        {{-- {{'$ ' . __(round($totalPrice, 0)) . ' COP'}} --}}
                                                        {{__(round($totalPrice*$currency->value, 2)) . ' '.$currency->code}}                                                      
                                                    @elseif(Route::currentRouteName() == 'payments_deposit')
                                                        {{-- {{'$ ' . __(round($depositPrice, 0)) . ' COP'}} --}}
                                                        {{__(round($depositPrice*$currency->value, 2)) . ' '.$currency->code}}

                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{trans('payments.payment_method')}}
                                                </td>
                                                <td>
                                                    {{-- <p class="text-nowrap text-right" id="selected-payment-method"></p> --}}
                                                    <p class="" id="selected-payment-method">{{ __('Tarjeta de crédito') }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{trans('payments.date_of_payment')}}
                                                </td>
                                                <td>
                                                    {{$date_now->format('d.m.Y h:i a')}}
                                                </td>
                                            </tr>
                                            <tr>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p class="text-right mb-4">
                                        <button type="submit"
                                        class="btn btn-primary ">{{__('Realizar el pago.')}}
                                        </button>
                                    </p>
                                @else
                                    <p class="text-success"><b>{{trans('payments.successful_registration')}}</b></p>
                                    <p>{{trans('payments.payment_method')}}
                                        {{$user->card_brand . ' XXXX XXXX XXXX ' . $user->card_last_four}}
                                    </p>
                                    <p>{{trans('payments.your_departure_date')}} {{$end_date}}.{{trans('payments.please_remember')}}</p>
                                    <p class="text-right mb-4">
                                        <button type="submit"
                                            class="btn btn-primary ">{{__('Terminar.')}}
                                        </button>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            @elseif($change and $cards)
            <form action="{{route('change_payment_method')}}" method="POST" id="payment-form-card">
            @csrf
            <input type="hidden" id="booking_id_card"   name="booking_id_card" value="{{ $booking->id }}">
            {{-- href="{{ route('change_payment_method') }}" --}}
                <div class="card">
                    <a class="card-collapse card-collapse-active collapsed show" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                        aria-controls="collapseOne">
                        <div class="card-header text-secondary" id="headingOne">
                            <h5 class="mb-0">
                                1 {{trans('payments.change_payment')}}
                                <i class="fa fa-chevron-right float-right"></i>
                            </h5>
                        </div>
                    </a>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        @if(($content and $user->card_last_four) or $change)
                            @foreach($cards as $card)
                                <label class="custom-radio d-inline-block">
                                    <p class="h6 font-weight-bold text-left">
                                        <img style="width: 1.5875rem" class="m-0 p-0" src="{{ asset('images/payments/icon-jan-2.png')}}">
                                        {{__('---- ---- ---- ---- ' . $card->last4)}}
                                    </p>
                                    <input name="payment_method" type="radio"  data-last4={{$card->last4}} data-brand={{$card->brand}} value="{{ $card->id }}" {{ ($card->id === $customer->default_source) ? "checked" : "" }}>
                                    <span class="checkmark"></span>
                                </label>
                                <span class="text-danger mx-3 cursor-pointer" onclick="showConfirmationPopup(this)" data-source="{{$card->id}}">Borrar</span>
                                <div class="payment-method">
                                    <div class="popup-delete-method" id="{{$card->id}}">
                                        <div class="card">
                                            <div class="card-body">
                                                <p class="h6">{{trans('payments.are_you_sure')}}</p>
                                                <div class="mt-3 d-flex justify-content-around">
                                                    <button type="button" class="btn btn-secondary float-right" onclick="hideDeletePopup(this)"  data-source="{{$card->id}}" >Cancelar</button>
                                                    <button type="button" class="btn btn-primary float-right" onclick="deletePaymentMethod(this)" data-source="{{$card->id}}" data-token="{!! csrf_token() !!}">Confirmar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <a class="text-left" href="{{__('/payments/add/'.$booking->id)}}">{{trans('payments.add_payment')}}</a>

                        <a class="btn btn-primary float-right mb-4 select-payment-method"
                                data-toggle="collapse"
                                data-target="#collapseThree"
                                aria-expanded="true"
                                aria-controls="collapseThree">
                            {{trans('payments.use_this')}}
                        </a>
                    </div>
                </div>
                <div class="card">
                    <a class="card-collapse collapsed"
                        data-toggle="collapse"
                        data-target="#collapseThree"
                        aria-expanded="false"
                        aria-controls="collapseThree">
                        <div class="card-header text-secondary" id="headingThree">
                            <h5 class="mb-0">                                
                                    2 Confirmar                                
                                <i class="fa fa-chevron-right float-right"></i>
                            </h5>
                        </div>
                    </a>
                    <div id="collapseThree"
                        class="collapse"
                        aria-labelledby="headingThree"
                        data-parent="#accordion">
                        <div class="card-body">
                            <p class="text-success"><b>{{trans('payments.successful_registration')}}</b></p>
                            <p>{{trans('payments.payment_method')}}
                                <span id="card-brand"></span> XXXX XXXX XXXX <span id="card-last4"></span>
                            </p>
                            <p>{{trans('payments.your_departure_date')}} {{$end_date}}. {{trans('payments.please_remember')}}</p>
                            <button type="submit" class="btn btn-primary float-right mb-4" >{{__('Terminar.')}}</button>
                        </div>
                    </div>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>
