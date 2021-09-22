<style>
    @media (max-width: 1025px) {
              .room-img {
                  display: none;
              }
          }
  
  .vico-logo-header {
      max-width: 200px;
  }
          
  
  </style>
  
  @if (sizeof($booking->room->imageRooms->take(1)) !== 0)
  <div class="container pt-5">
          <div class="row text-center">
                  <p class="col-12 h2 vico-color text-center" style="margin-bottom: 15px;">
                      {{'Room #'.$room->number.' in '.$house->name}}
                  </p>
              </div>
      <div class="row text-center">
          <div class="col-12">
              <img class="img-fluid" style="max-width: 200px; border-radius: 5px;" src="https://fom.imgix.net/{{ ($booking->room->imageRooms->take(1)[0]->image) }}" alt="Responsive image">
              @if (sizeof($booking->room->imageRooms->slice(1)->take(2)) == 2)
              @foreach($booking->room->imageRooms->slice(1)->take(2) as $img)
              <img class="room-img img-fluid" style="max-width: 200px; border-radius: 5px;" src="https://fom.imgix.net/{{ $img->image }}" alt="Responsive image">
              @endforeach
              @endif
          </div>
      </div>
  @else 
  <img class="vico-logo-header" src="{{asset('images/editBookingDate/vivir-naranja.png')}}" alt="">
  @endif
      @if (Route::currentRouteName() === 'payments_user')
      <div class="row py-4">
          <div class="col-12">
              <p class="h3 vico-color text-center bold-words">
                {{trans('payments.monthly_rent')}}
              </p>
          </div>
          <hr class="w-100">
          <div class="col-12">
              <p class="jn-tui">
                    {{trans('payments.monthly_rent_of')}}{{__(date("d.m.y", strtotime($nextBill['from'])).' hasta '.date("d.m.y", strtotime($nextBill['to'])) )}}
                  {{-- <span class="nodaag">{{ __('$' . $price . ' COP') }}</span> --}}
                  <span class="nodaag">{{ __($price * $currency->value . ' ' . $currency->code) }}</span>
  
              </p>
              @if($first)
                  <p class="jn-tui">
                        {{trans('payments.cost_of_transaction')}}
                        {{-- <span class="nodaagyes">{{ __('$' . round($price*0.03, 0)  . ' COP') }}</span> --}}
                      <span class="nodaagyes">{{ __(round($price * $currency->value*0.03, 2)  . ' ' . $currency->code) }}</span>
                  </p>
                  <p class="arrow_box">
                    {{trans('payments.first_month')}}
                  </p>
              @else
                  <p class="jn-tui">
                        {{trans('payments.cost_of_transaction')}}  
                      {{-- <span class="nodaag">{{ __('$' . round($price*0.03, 0)  . ' COP') }}</span> --}}
                      <span class="nodaag">{{ __(round($price * $currency->value*0.03, 2)  . ' ' . $currency->code) }}</span>
                  </p>
              @endif
          </div>
          @if(!$first)
              <hr class="w-100">
          @endif
          <div class="col-12">
              {{-- <p class="katla">{{ __('Total: $' . round($totalPrice, 0) . ' COP') }}</p> --}}
              <p class="katla">{{trans('payments.Total')}}: ${{ __(round($totalPrice * $currency->value, 2) . ' ' . $currency->code) }}</p>
              {{-- <p class="aha">{{ __('Valor en USD: ' . round($totalPrice * $usd_cop, 2) . '$') }}</p> --}}
              {{-- <p class="aha">{{ __('Valor en EUR: ' . round($totalPrice * $eur_cop, 2) . '€') }}</p> --}}
          </div>
      </div>
      <div class="col-12 text-right">
          <p>
              <a class="btn-link" style="font-family: nunitoregular;" target="_blank" href="{{route('questions.user', ['#faqStayHeading-5'])}}">{{trans('payments.what_if')}}<span class="small text-color-orange icon icon-next-fom"></span></a>
          </p>
      </div>
  
      @endif
      @if (Route::currentRouteName() == 'payments_deposit')
      <div class="row py-4">
            <div class="col-12">
                <p class="h3 vico-color text-center">
                {{trans('payments.deposit_payment')}}
                </p>
            </div>
            <hr class="w-100">
            <div class="col-12">
                <div class="row jn-tui">
                    <div class="col text-left">
                        <p>{{trans('payments.deposit_equal')}}</p>
                    </div>
                    <div class="col-auto text-right">
                        <p><span class="nodaag">{{ __($price * $currency->value. ' ' . $currency->code) }}</span></p>
                    </div>
                </div>
                <div class="row jn-tui">
                    <div class="col text-left">
                        <p>{{trans('payments.vico_fee')}}</p>
                    </div>
                    <div class="col-auto text-right">
                        <span class="nodaag">{{ __(round($price*$currency->value*0.05, 2) . ' ' . $currency->code) }}</span>
                    </div>
                </div>
                <div class="row jn-tui">
                    <div class="col text-left">
                        <p>{{trans('payments.cost_of_transaction')}}</p>
                    </div>
                    <div class="col-auto text-right">
                        <p><span class="nodaag">{{ __(round($price*$currency->value*0.03, 2)  . ' ' . $currency->code) }}</span></p>
                    </div>
                </div>
                @if($discountCOP != 0)
                <div class="row jn-tui">
                    <div class="col text-left">
                        <p class="mb-0">{{trans('payments.your_discount_code')}}</p>
                    </div>
                    <div class="col-auto text-right">
                        <p class="mb-0"> -{{ __(round($discountCOP * $currency->value, 2)  . ' ' . $currency->code) }}</p>
                    </div>
                </div>
                @else
                
                    <form action="{{route('referrals.check')}}" method="post"> 
                        {{csrf_field()}}
                        <div class="row jn-tui align-items-center mb-3">
                                <div class="col text-left">
                                    <p class="m-0">{{trans('payments.your_discount_code')}}</p>
                                </div>
                                <div class="col-auto text-right">
                                        <input name="discount_code" type="text" style="border: 1px solid #ea960f">
                                        <input type="hidden" name="booking_id" value="{{$booking->id}}">
                                        <button class="btn btn-primary">{{trans('payments.check')}}</button>
                                </div>
                            </div>
                      </form>
                      @endif
                    </div>
              @if(!$first)
                  <hr class="w-100">
              @endif
              <div class="col-12">
                    @if (\Session::has('code_success'))
                        @if (\Session::get('code_success') == 1)
                            <div class="my-3 mt-2 p-2 alert-success text-center" role="alert" style="color: black;">
                                <p class="mb-0">👍 {{trans('payments.code_worked')}}</p>
                            </div>
                        @else 
                            <div class="my-3 mt-2 alert p-2 alert-danger text-center">
                                <p class="mb-0">👎 {{trans('payments.code_didnt_work')}}</p>
                            </div>
                        @endif
                    @endif
                  </div>
              <div class="col-12">
                  {{-- <p class="katla">{{ __('Total: $' . round($depositPrice, 0) . ' COP') }}</p> --}}
                  <p class="katla my-2 mb-3">{{trans('payments.total')}}: {{ __(round($depositPrice * $currency->value, 2) . ' ' . $currency->code) }}</p>
                  {{-- <p class="aha">{{ __('Valor en USD: ' . round($depositPrice * $usd_cop, 2) . '$') }}</p> --}}
                  {{-- <p class="aha">{{ __('Valor en EUR: ' . round($depositPrice * $eur_cop, 2) . '€') }}</p> --}}
              </div>
              @if($discountCOP = 0)
                      <p class="jn-tui">
                        {{trans('payments.your_discount_code')}}{{-- <span class="nodaagyes">{{ __('$' . round($price*0.03, 0)  . ' COP') }}</span>    --}}
                          <span class="float-right">- {{ __(round($discountCOP * $currency->value, 2)  . ' ' . $currency->code) }}</span>
                      </p>
                      <p class="arrow_box">
                        {{trans('payments.deposit')}}
                      </p>                    
                      @endif
                      
              <div class="col-12 text-right">
                  <p>
                      <a class="btn-link" style="font-family: nunitoregular;" target="_blank" href="{{route('questions.user', ['#faqHeading-2'])}}">{{trans('payments.what_is_deposit')}}<span class="small text-color-orange icon icon-next-fom"></span></a>
                  </p>
                  <p>
                      <a class="btn-link" style="font-family: nunitoregular;" target="_blank" href="{{route('questions.user', ['#faqHeading-7'])}}">{{trans('payments.can_i_cancel')}}<span class="small text-color-orange icon icon-next-fom"></span></a>
                  </p>
              </div>
          </div>
      @endif
  
  </div>  