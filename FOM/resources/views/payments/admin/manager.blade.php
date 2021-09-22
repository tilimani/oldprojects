@extends('layouts.app')

@section('styles')
    
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
                        <div class="col-lg-8 col-sm-8 padding-left-no">
                            <h3 class="zui"><img class="Profilimgsml" src="img/icon-jan-2.png">
                                <font>Metodo de payout</font> Bancolombia <span>xxxx xxxx xxxx 3390</span>
                            </h3>
                        </div>
                        <div class="col-lg-4 col-sm-4 padding-right-no">
                            <button class="btn-col-1 hover-opc">Cambiar</button>
                        </div>
                    </div>
                    <!-- rounded box -->
                    <div class="borderme">
                        <div class="col-lg-8 col-sm-8 padding-left-no">
                            <h3 class="zui"><img class="Profilimgsml" src="img/icon-jan-1.png">
                                <font>Next payout: 1.200.000 COP</font> 27.03.2019
                            </h3>
                        </div>
                        <div class="col-lg-4 col-sm-4 padding-right-no">
                            <button class="btn-col-1 hover-opc">Ver Historial</button>
                        </div>
                    </div>
                    <!-- border bottom -->
                    <div class="border-bottom"></div>
                    <!-- title -->
                    <div class="titiz1">Historial de pagos</div>
                    <!-- sub title -->
                    <p class="txtthis">Mostrar solamente habitaciones ocupadas por VICO</p>
                    <!-- on/off switch -->
                    <div class="onoffswitch">
                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
                        <label class="onoffswitch-label" for="myonoffswitch">
                            <div class="onoffswitch-inner"></div>
                            <div class="onoffswitch-switch"></div>
                        </label>
                    </div>
                    <br clear="all">
                    {{-- MANAGER TABLE --}}
                        @include('payments.sections._managertable.blade.php')
                    {{-- MANAGER TABLE END--}}
                    
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@section('scripts')
    
@endsection