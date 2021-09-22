@extends('layouts.app')

@section('styles')
    
@endsection

@section('content')
<!-- wrap box -->
    <section id="services-1" class="section-padding-ash">
        <div class="container-fluid">
            <div class="row">
                <!-- left panel -->
                <div class="col col-lg-4">

                </div>
                <!-- right panel -->
                <div class="col-lg-8 col-sm-12 bl-yes">                    
                        <!-- title -->
                        <div class="titiz1">Mis pagos</div>
                        <!-- rounded box -->
                        <div class="borderme row">
                            <div class="col-lg-8 col-sm-8">
                                <h3 class="zui"><img class="Profilimgsml" src="img/icon-jan-2.png"> <font>Metodo de payout</font> Bancolombia <span>xxxx xxxx xxxx 3390</span></h3>
                            </div>
                            <div class="col-lg-4 col-sm-4">
                                <button class="btn-col-1 hover-opc">Cambiar</button>
                            </div>
                        </div>
                        <!-- rounded box -->
                        <div class="borderme row">
                            <div class="col-lg-8 col-sm-8">
                                <h3 class="zui"><img class="Profilimgsml" src="img/icon-jan-1.png"> <font>Next payout: 1.200.000 COP</font> 27.03.2019</h3>
                            </div>
                            <div class="col-lg-4 col-sm-4">
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
                        <p class="txtthis">Ordenar por VICO/Hab/Habitante/Fecha</p>
                        <!-- button -->
                        <button class="btn-col-3">Filtrar: VICO/Hab/Habitante/Fecha</button>
                        <!-- tab head -->
                        <ul id="div1" class="tabz">
                            <li><a href="javascript:;" class="btn btn-filter" data-target="pagado">Febrero</a></li>   
                            <li><a href="javascript:;" class="btn btn-filter" data-target="pendiente">Enero</a></li>
                            <li><a href="javascript:;" class="btn btn-filter" data-target="cancelado">Diciembre</a></li>
                            <li><a href="javascript:;" class="btn btn-filter" data-target="all">Noviembre</a></li>
                        </ul>
                        <!-- border bottom -->
                        <div class="border-bottom"></div>
                        <!-- small title -->
                        <p class="motabhai">VICO Éxito</p>
                        <!-- listing table -->
                        <div class="span5">
                            <table class="table gap30 table-condensed table-filter">
                                <tbody>
                                    <tr data-status="pagado">
                                        <td>Hab 1 - VICO EXITO</td>
                                        <td>600.000 COP</td>
                                        <td>14/12/2018</td>
                                        <td>Tarjeta de Credito</td>
                                        <td>
                                          <span class="f2 hover-magic" href="#">
                                            <img class="dot" src="img/icon-dot.png">
                                            <ul class="toolpit">
                                              <li><a href="#">Hacer reclamo</a></li>
                                              <li><a href="#">Ver transacción</a></li>
                                              <li><a href="#">Imprimir recibo</a></li>
                                            </ul>
                                          </span>
                                          <span class="btn-col-2e f2 hover-opc">Recibido</span>
                                        </td>
                                    </tr>
                                    <tr data-status="pendiente">
                                        <td>Hab 1 - VICO EXITO</td>
                                        <td>600.000 COP</td>
                                        <td>14/12/2018</td>
                                        <td>Tarjeta de Credito</td>
                                        <td>
                                          <span class="f2 hover-magic" href="#">
                                            <img class="dot" src="img/icon-dot.png">
                                            <ul class="toolpit">
                                              <li><a href="#">Hacer reclamo</a></li>
                                              <li><a href="#">Ver transacción</a></li>
                                              <li><a href="#">Imprimir recibo</a></li>
                                            </ul>
                                          </span>
                                          <span class="btn-col-2f f2 hover-opc">Pending</span>
                                        </td>
                                    </tr>
                                    <tr data-status="cancelado">
                                        <td>Hab 1 - VICO EXITO</td>
                                        <td>600.000 COP</td>
                                        <td>14/12/2018</td>
                                        <td>Tarjeta de Credito</td>
                                        <td>
                                          <span class="f2 hover-magic" href="#">
                                            <img class="dot" src="img/icon-dot.png">
                                            <ul class="toolpit">
                                              <li><a href="#">Hacer reclamo</a></li>
                                              <li><a href="#">Ver transacción</a></li>
                                              <li><a href="#">Imprimir recibo</a></li>
                                            </ul>
                                          </span>
                                          <span class="btn-col-2c f2 hover-opc">Payout</span>
                                        </td>
                                    </tr>
                                    <tr data-status="pagado" class="selected">
                                        <td>Hab 1 - VICO EXITO</td>
                                        <td>600.000 COP</td>
                                        <td>14/12/2018</td>
                                        <td>Tarjeta de Credito</td>
                                        <td>
                                          <span class="f2 hover-magic" href="#">
                                            <img class="dot" src="img/icon-dot.png">
                                            <ul class="toolpit">
                                              <li><a href="#">Hacer reclamo</a></li>
                                              <li><a href="#">Ver transacción</a></li>
                                              <li><a href="#">Imprimir recibo</a></li>
                                            </ul>
                                          </span>
                                          <span class="btn-col-2g f2 hover-opc">Efectivo</span>
                                        </td>
                                    </tr>
                                    <tr data-status="pendiente">
                                        <td class="deacto">Hab 5 - VICO EXITO</td>
                                        <td colspan="3"><span class="btn-col-2g f1 hover-opc">EXTERNO</span></td>
                                        <td>
                                          <span class="f2 hover-magic" href="#">
                                            <img class="dot" src="img/icon-dot.png">
                                            <ul class="toolpit">
                                              <li><a href="#">Hacer reclamo</a></li>
                                              <li><a href="#">Ver transacción</a></li>
                                              <li><a href="#">Imprimir recibo</a></li>
                                            </ul>
                                          </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- border bottom -->
                        <div class="border-bottom"></div>
                        <!-- small title -->
                        <p class="motabhai">VICO Malibu</p>
                        <!-- listing table -->
                        <div class="span5">
                            <table class="table gap30 table-condensed">
                                <tbody>
                                    <tr>
                                        <td>Hab 1 - VICO EXITO</td>
                                        <td>600.000 COP</td>
                                        <td>14/12/2018</td>
                                        <td>Tarjeta de Credito</td>
                                        <td>
                                          <span class="f2 hover-magic" href="#">
                                            <img class="dot" src="img/icon-dot.png">
                                            <ul class="toolpit">
                                              <li><a href="#">Hacer reclamo</a></li>
                                              <li><a href="#">Ver transacción</a></li>
                                              <li><a href="#">Imprimir recibo</a></li>
                                            </ul>
                                          </span>
                                          <span class="btn-col-2e f2 hover-opc">Recibido</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hab 1 - VICO EXITO</td>
                                        <td>600.000 COP</td>
                                        <td>14/12/2018</td>
                                        <td>Sepa</td>
                                        <td>
                                          <span class="f2 hover-magic" href="#">
                                            <img class="dot" src="img/icon-dot.png">
                                            <ul class="toolpit">
                                              <li><a href="#">Hacer reclamo</a></li>
                                              <li><a href="#">Ver transacción</a></li>
                                              <li><a href="#">Imprimir recibo</a></li>
                                            </ul>
                                          </span>
                                          <span class="btn-col-2f f2 hover-opc">Pending</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hab 1 - VICO EXITO</td>
                                        <td>600.000 COP</td>
                                        <td>14/12/2018</td>
                                        <td>Paypal</td>
                                        <td>
                                          <span class="f2 hover-magic" href="#">
                                            <img class="dot" src="img/icon-dot.png">
                                            <ul class="toolpit">
                                              <li><a href="#">Hacer reclamo</a></li>
                                              <li><a href="#">Ver transacción</a></li>
                                              <li><a href="#">Imprimir recibo</a></li>
                                            </ul>
                                          </span>
                                          <span class="btn-col-2c f2 hover-opc">Payout</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hab 1 - VICO EXITO</td>
                                        <td>600.000 COP</td>
                                        <td>14/12/2018</td>
                                        <td>Efectivo</td>
                                        <td>
                                          <span class="f2 hover-magic" href="#">
                                            <img class="dot" src="img/icon-dot.png">
                                            <ul class="toolpit">
                                              <li><a href="#">Hacer reclamo</a></li>
                                              <li><a href="#">Ver transacción</a></li>
                                              <li><a href="#">Imprimir recibo</a></li>
                                            </ul>
                                          </span>
                                          <span class="btn-col-2g f2 hover-opc">Efectivo</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="deacto">Hab 5 - VICO EXITO</td>
                                        <td colspan="3"><span class="btn-col-2g f1 hover-opc">EXTERNO</span></td>
                                        <td>
                                          <span class="f2 hover-magic" href="#">
                                            <img class="dot" src="img/icon-dot.png">
                                            <ul class="toolpit">
                                              <li><a href="#">Hacer reclamo</a></li>
                                              <li><a href="#">Ver transacción</a></li>
                                              <li><a href="#">Imprimir recibo</a></li>
                                            </ul>
                                          </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- border bottom -->
                        <div class="border-bottom"></div>
                        <!-- bottom spacing -->
                        <div class="gap100"></div>                    
                </div>

            </div>
        </div>
    </section>
<!-- wrap box end-->

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
                        <p class="leftthis"><img class="tiktok" src="img/tok.png"> No transaction costs, but neither payment confirmation and you will have to pick up the money cash every money at an ATM.</p>
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
                        <p><img class="tiktok" src="img/tik.png"> Easy going payment of rent, no looking for ATM, no carrying a lot of money</p>
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
                        <p><img class="tiktok" src="img/tik.png">Perfect for our European clients, use your normal bank account</p>
                    </div>
                    <button class="btn-col-4 hover-opc">Cambiar</button>
                </div>
            </div>
            <!-- /item -->
          </div>

        </div>
      </div>
    </div>
<!-- Modal end-->
@endsection

@section('scripts')
    
@endsection