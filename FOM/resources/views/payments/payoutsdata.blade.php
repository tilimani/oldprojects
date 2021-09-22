@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
<!-- wrap box -->
    <section id="services-1" class="section-padding-ash">
        <div class="container-fluid">
            <div class="row">
                <!-- left panel -->
                <div class="col-lg-4">                    
                </div>
                <!-- right panel -->
                <div class="col-lg-8 col-sm-12 bl-yes">                    
                        <!-- title -->
                        <div class="titiz1">Mis pagos</div>
                        <!-- rounded box -->
                        <div class="borderme">
                            <div class="col-lg-11 offset-lg-1 col-sm-12">
                                <p class="txty1">Metodo de payout</p>
                                <ul class="big-fnt">
                                    <li><input type="radio" name="a"> Banco colombiano</li>
                                    <li><input type="radio" name="a"> Banco Europeo</li>
                                    <li><input type="radio" name="a"> Payoneer</li>
                                </ul>
                                <button class="btn-col-1 f2 hover-opc">Guardar</button>
                            </div>
                        </div>
                        <!-- down arrow image -->
                        <img src="img/down-arrow.png" class="down-arrow">
                        <!-- title -->
                        <div class="titiz1">Mis pagos</div>
                        <!-- rounded box -->
                        <div class="borderme">
                            <div class="col-lg-11 col-lg-offset-1 col-sm-12">
                                <p class="txty1">Metodo de payout</p>
                                <!-- input boxes -->
                                <ul class="big-fnt">
                                    <li>
                                        <input type="radio" name="a"> Banco colombiano
                                        <div class="fullbox">
                                            <select class="custome1">
                                                <option>Tipo de cuenta</option>
                                                <option>Tipo de</option>
                                                <option>Tipo de cuenta</option>
                                            </select>
                                            <input class="custome1" type="text" name="" value="Numero de cuenta">
                                            <input class="custome1" type="text" name="" value="Nombre">
                                            <input class="custome1" type="text" name="" value="Appellido">
                                            <select class="custome1">
                                                <option>Tipo de documento</option>
                                                <option>Tipo de</option>
                                                <option>Tipo de cuenta</option>
                                            </select>
                                            <input type="text" class="custome1" name="" value="Número de documento">
                                        </div>
                                    </li>
                                    <li><input type="radio" name="a"> Banco Europeo</li>
                                    <li><input type="radio" name="a"> Payoneer</li>
                                </ul>
                                <button class="btn-col-1 f2 hover-opc">Guardar</button>
                            </div>
                        </div>
                        <!-- bottom spacing -->
                        <div class="gap100"></div>                    
                </div>

            </div>
        </div>
    </section>
@endsection

@section('scripts')
    
@endsection