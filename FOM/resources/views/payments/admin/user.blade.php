@extends('layouts.app')

@section('title', 'My Payments')
@section('styles')
    
@endsection

@section('scripts')
    @include('payments.sections._scripts')
@endsection

@section('content')

<!-- wrap box -->
<section id="services-1" class="section-padding-ash">
    <div class="container-fluid">
        <div class="row">
            <!-- left panel -->
            <div class="col-lg-4 padding-left-no">

            </div>
            <!-- right panel -->
            <div class="col-lg-8 padding-right-no bl-yes">
                <div class="grayz">
                    <!-- title -->
                    <div class="titiz1">Mis pagos</div>
                    <!-- rounded box -->
                    <div class="borderme">
                        <div class="row">
                            <div class="col-8 padding-left-no">
                                <h3 class="zui">
                                    <img class="Profilimgsml" src="{{ asset('images/payments/icon-jan-2.png')}}">
                                    <p class="h2">
                                        Método de pago
                                    </p>
                                    @if($user->stripe_id)
                                        Tarjeta {{ $user->card_brand }}<span>xxxx xxxx xxxx {{$user->card_last_four}}</span>
                                    @endif
                                </h3>
                            </div>
                            <div class="col-4 padding-right-no">
                                @if($user->stripe_id)
                                    <button class="btn-col-1 hover-opc" 
                                        data-toggle="modal" 
                                        data-target="#myModal1">
                                        Cambiar
                                    </button>
                                @else
                                    <button class="btn-col-1 hover-opc" 
                                        data-toggle="modal" 
                                        data-target="#myModal1">
                                        Añadir
                                    </button>
                                @endif

                                
                            </div>
                        </div>
                    </div>
                    <!-- rounded box -->
                    <div class="borderme">
                        <div class="row">
                            <div class="col-8 padding-left-no">
                                <h3 class="zui">
                                    <img class="Profilimgsml" src="{{ asset('images/payments/icon-jan-1.png')}}">
                                    <p class="h2">
                                        Final de mi estancia
                                    </p>
                                    {{ $date_to }}
                                </h3>
                            </div>
                            <div class="col-4 padding-right-no">
                                <button class="btn-col-1 hover-opc" 
                                    data-toggle="modal" 
                                    data-target="#myModal1">
                                    Añadir
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- border bottom -->
                    <div class="border-bottom"></div>
                    <!-- title -->
                    <div class="titiz1">Historial</div>
                    <!-- listing table -->

                    {{-- USER PAYMETS TABLE --}}
                        @include('payments.sections._usertable')
                    {{-- USER PAYMETS TABLE END --}}
                    
                    <!-- bottom spacing -->
                    <div class="gap100"></div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Cambia de metodo de pago.<br>El cambio se realiza a partir del 15/03/2019</h4>
            </div>
            <a class="cross" href="#" value="Refresh Page" onClick="window.location.reload()"><img class="payment-icon" src="img/cross.png" ></a>
            <div class="modal-body">
                <!-- item -->
                <div class="col-md-4 col-sm-4 text-center">
                    <div class="panel panel-danger panel-pricing">
                        <img class="payment-icon" src="img/payment-icon2.png" alt="payment-icon">
                        <div class="panel-body text-center">
                            <p><strong>En efectivo</strong>Without Transaction Fee</p>
                            <p class="leftthis"><img class="tiktok" src="img/tok.png"> 
                                No transaction costs, but neither payment confirmation
                                and you will have to pick up the money cash every money at an ATM.
                            </p>
                        </div>
                        <button class="btn-col-4 hover-opc">Cambiar</button>
                    </div>
                </div>
                <!-- /item -->

                <!-- item -->
                <div class="col-md-4 col-sm-4 text-center">
                    <div class="panel panel-danger panel-pricing">
                        <img class="payment-icon" src="img/payment-icon1.png" alt="payment-icon">
                        <div class="panel-body text-center">
                            <p><strong>Tarjeta de Crédito</strong></p>
                            <p>+ 3% Transaction fee</p>
                            <br><br>
                            <p>
                                <img class="tiktok" src="img/tik.png"> 
                                Easy going payment of rent, no looking for ATM, no carrying
                                a lot of money
                            </p>
                        </div>
                        <button class="btn-col-4 hover-opc">Cambiar</button>
                    </div>
                </div>
                <!-- /item -->

                <!-- item -->
                <div class="col-md-4 col-sm-4 text-center">
                    <div class="panel panel-danger panel-pricing">
                        <img class="payment-icon" src="img/payment-icon3.png" alt="payment-icon">
                        <div class="panel-body text-center">
                            <p><strong>European Bank<br>Transfer</strong></p>
                            <p>+ 2% Transaction fee</p>
                            <p>
                                <img class="tiktok" src="img/tik.png">
                                Perfect for our European clients, use your normal bank
                                account
                            </p>
                        </div>
                        <button class="btn-col-4 hover-opc">Cambiar</button>
                    </div>
                </div>
                <!-- /item -->
            </div>
        </div>
    </div>
</div>
    
@endsection