@extends('layouts.app')
@section('content')
@section('styles')
<style>
.selected-row{
  background-color: orange;
  color: white;
}
.badge-done{
  color: white;
  background-color: green;
  padding: 10px 20px;
  border-radius: 20px;
}
.badge-received{
  color: white;
  background-color: gray;
}
.badge-pending{
  color:white;
  background-color: sandybrown;
}
</style>
@endsection
@section('content')
<h1 style="position: relative; text-align:center;">Historial</h1>
<section id="services-1" class="section-padding-ash">
    <div class="container-fluid">
        <div class="row">                                
            <!-- right panel -->
            <div class="col-lg-10 offset-lg-1 col-sm-12 pr-0 pl-0">
                <div class="span5">
                    <table class="table ml-0 mr-0" >
                        <thead>
                            {{-- <th>habitacion</th> --}}
                            <th>valor</th>
                            <th>fecha</th>
                            <th>estado</th>
                        </thead>
                        <tbody>  
                            @php
                                $flag = 0;
                            @endphp                                          
                            @for($i = 0; $i < sizeof($bill->payments); $i++)                                              
                                <tr onclick="selectRow(this)">  
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
                                      {{-- {{ __('Payment day: ' . $bill->payments[$i]['from']->format('m/d/Y'))}} --}}
                                    </td>
                                    <td>{{$bill->payments[$i]['price']}}</td>
                                    <td>{{$bill->payments[$i]['from']->format('m/d/Y')}} {{$bill->payments[$i]['to']->format('m/d/Y')}} </td>
                                    <td>
                                        @switch($bill->payments[$i]['status'])
                                            @case(0)
                                            <span class="badge badge-done">
                                                Payout
                                            </span>
                                                @break
                                            @case(1)
                                            <span class="badge badge-received">
                                                Recibido
                                            </span>
                                            @case(2)
                                            <span class="badge badge-pending">
                                                Pendiente
                                            </span>
                                                @break
                                            @default
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
                <div class="text-center mb-4">
                    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#confirm-payment">Pagar</button>
                </div>
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
                @if($bill->payments[0]['from'] === $nextBill['from'])
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
                @endif
                <form id="payment_verify">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="payment_code" placeholder="Codigo" class="form-control">
                    </div>
                    <p id="verification-payment-response"></p>
                    <button id="submit-payment-verify" type="submit" class="btn btn-primary">Enviar Confirmacion</button>
                </form>
            </div> 
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
        let newPrices;        

      $('#payment_verify').on('submit',(event)=>{
        event.preventDefault();
        let input =$('input[name=payment_code]'); 
        let code = input.val();
        let type = 'payment_code'

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/verification/verify-code',
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                code: code,
                type: type,
            },
            success: function(data)
            {
                let verification = $('#verification-whatsapp-response');
                if(data.success){                
                    verification.text(data.success);
                    verification.css('color','green');
                    input.removeClass('is-invalid');
                    input.addClass('is-valid');
                    // $('#send-whatsapp-verification').addClass('disabled');
                    setTimeout(()=>{
                        $('#confirm-payment').modal('toggle');
                    },1500)
                }else{
                    input.removeClass('is-valid');
                    input.addClass('is-invalid');   
                    verification.text(data.failure);
                    verification.css('color','red');
                }
            }
          });
        return false;  

    });
    function selectRow(element){
      let checkbox = element.getElementsByTagName('input')[0];
      checkbox.click();
      if(checkbox.checked){
        element.classList.add("selected-row");
      }else{
        element.classList.remove("selected-row");
      }      
    }
    function check(id, index) {

        paymentPeriod = document.querySelector(`#${id}`); 

        if (paymentPeriod.checked) {
            newPrices = updatePrices(paymentPeriod, 'add');
        }
        else{
            newPrices = updatePrices(paymentPeriod, 'substract');
        }

        // updateInputPrices(newPrices[0], newPrices[1], newPrices[2]);

    }

        function updatePrices(paymentePeriod, action) {

        let messagePrice = document.querySelector('#total-price').innerHTML;
        let totalPriceCOP = parseFloat(messagePrice.substring(messagePrice.indexOf(':') + 2, messagePrice.indexOf('COP') - 1));
          
        switch (action) {
            case 'add':
                totalPriceCOP += parseFloat(paymentPeriod.value);                
                break;
            case 'substract':
                totalPriceCOP -= parseFloat(paymentPeriod.value);                

            default:
                break;
        }

        let totalPriceUSD = parseFloat((totalPriceCOP* {{ $usd_cop }}).toFixed(2));
        let totalPriceEUR = parseFloat((totalPriceCOP* {{ $eur_cop }}).toFixed(2));

        document.getElementById('total-price').innerHTML = 'TOTAL: ' + totalPriceCOP + ' COP';
        document.getElementById('usdPrice').innerHTML = 'Valor en USD: ' + '$' + totalPriceUSD;
        document.getElementById('eurPrice').innerHTML = 'Valor en EUR: ' + '€' + totalPriceEUR;

        return [totalPriceCOP, totalPriceUSD, totalPriceEUR];

        }

        // function updateInputPrices(priceCOP, priceUSD, priceEUR) {
        // document.getElementById('ctrl_finalPrice').value = priceEUR;
        // document.getElementById('ctrl_finalPriceCOP').value = priceCOP;
        // }

</script>
@endsection
{{-- @section('scripts')
<!-- <script src="https://www.google.com/jsapi?key=2a2d4032fd513a036255a222eb932b1654805d63"></script> -->
<script>
  let testToTranslate=document.getElementsByClassName('text-to-translate');

  function translateTest(element,source,target){
    let url="https://www.googleapis.com/language/translate/v2/";
    let api_key="AIzaSyBZ0XewfPCqZ_iqFZUtxdUortSkpuYY7ho";
    url+="?key="+api_key;
    url+="&target="+target;
    url+="&source="+source;
    url+="&q="+element.innerText;
    return $.ajax({
      url: url,
      type: "GET",
      dataType: "json",
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json"
      },
      success:function(data){
        element.innerText=data.data.translations[0].translatedText;
      }
    });
  }

  function translateAllText(){
    let i=0;
    for(i;i<testToTranslate.length;i++){
      let target='en';
      let source="es";
      translateTest(testToTranslate[i],source,target);
    }
  }
  
</script>
@endsection --}}
