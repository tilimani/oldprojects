<div class="row">
    <!-- right panel -->
    <div class="col-lg-10 offset-lg-1 col-sm-12 pr-0 pl-0">
        <div class="span5">
            <table class="table ml-0 mr-0" >
                <thead>
                    <th>Cuota</th>
                    <th scope="col">
                        <select id="currency-selector" class="custom-select">
                            <option value="cop">COP</option>
                            <option value="eur">EUR</option>
                            <option value="usd">USD</option>
                            </select>
                    </th>
                    <th scope="col" class="d-none d-sm-block d-md-block d-lg-block">Fecha</th>
                    <th scope="col">Estado</th>
                </thead>
                <tbody>  
                    @php
                        $flag = 0;
                    @endphp                                          
                    @for($i = 0; $i < sizeof($bill->payments); $i++)
                        <tr {{$bill->payments[$i]['status'] === 0 ? "onclick=selectRow(this)" : ''}}>  
                            <th scope="row">{{$bill->payments[$i]['cuota']}}</th>
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