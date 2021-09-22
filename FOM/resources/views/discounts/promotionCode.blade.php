@extends('layouts.app')
@section('title', 'Confirmación')
@section('content')

<head><meta name="viewport" content="width=device-width, initial-scale=1.0" /></head>
<style>
    #header-image {
        color: white;
        background: url('/images/reservationConfirmation/smilingBanner.jpg') top right/cover no-repeat;
        height: 400px;
        display: flex;
        background-position: center;
        justify-content: center;
        flex-direction: column;
        align-items: center;
        text-transform: uppercase;
        border-radius: 50px 50px 0 0;
    }

    #header-image-2 {
        color: white;
        background: url('https://fom.imgix.net/section-4-bg.png?w=240&fit=crop&h=200&auto=compress') top right/cover no-repeat;
        height: 300px;
        display: flex;
        background-position: center;
        justify-content: center;
        flex-direction: column;
        align-items: center;
        text-transform: uppercase;
    }

    #header-text {
        color: white;
        margin: 0 5% 0 5%;
        text-align: center;
    }

    #vico-icon {
        opacity: 0.8;
        height: 50px;
        width: 50px;
        margin-bottom: 20px;
    }

    .container, #header-image {
        border-bottom: 0;
    }

    .container {
        margin-top: 50px;
        margin-bottom: 50px;
        border-radius: 50px 50px 50px 50px;
        box-shadow: 3px 3px 9px 0px rgba(153,153,153,1);
        border: white solid 0px;
        max-width: 720px;
    }

    #code-holder {
        border: 2px lightgrey dashed;
        padding: 7px;
        display: flex;
        min-width: 300px;
        max-width: 60%;
        border-radius: 30px;
        margin: auto;
        margin-bottom: 40px;
    }

    #social-media {
        display: flex;
        min-width: 300px;
        max-width: 60%;
    }

    .icono-social {
        width: 60px;
    }

    html, body {
        width: 100%; 
        height: 100%; 
        margin: 0px; 
        padding: 0px; 
        overflow-x: hidden;
    }

    .checkmark {
        width: 50px;
    }

    /* ----------- PROBLEMS IN MOBILE ---------- */

    @media (max-width: 400px) {
        #header-text {
            font-size: 25px;
            padding: 0 15px 0 15px;
        }

        #header-text-2 {
            font-size: 30px;
        }

    }

    @media (max-width: 992px) {.small-grey-text {padding-left: 0;}}
    
    /* FAQ STYLES */ 

    @media (max-width: 425px){
        .container {
            margin: 0;
            border: 0;
            border-radius: 0;
            box-shadow: none;
        }

        #header-image {border-radius: 0;}
    }

    .vico-image {
        border-radius: 25px;
        width: 250px;
    }

    .payout-icon {
        height: 100px; 
        max-width: 100px;
        border-radius: 20px;
        -webkit-box-shadow: 5px 5px 13px 3px rgba(115,115,115,0.44);
        -moz-box-shadow: 5px 5px 13px 3px rgba(115,115,115,0.44);
        box-shadow: 5px 5px 13px 3px rgba(115,115,115,0.44);
    }

    .payout-icon.payout-icon-mobile {
        height: 105px; 
        max-width: 105px;
    }

    .faq {
        background-color: none;
        box-shadow: none;
    }

    .faq .card {border-bottom: none;}

    /** Mobile Specific **/

    @media (max-width: 600px) {
        .checkmark {width: 20px;}
        .text-20 {font-size: 15px;}
    }


    /** Modal **/
    @media (min-width: 769px) {
        #vico-payout-logo-img {width: 50px; height: 55px;}
        #cash-payout-logo-img {width: 80px; height: 80px;}
        #paypal-payout-logo-img {width: 100px; height: 100px;}
        #amazon-payout-logo-img {width: 100px; height: 100px;}
        #netflix-payout-logo-img {width: 80px; height: 25px;}
        #spotify-payout-logo-img {width: 80px; height: 80px;}
    }

    @media (max-width: 768px) {
        #vico-payout-logo-img {width: 50px; height: 55px;}
        #cash-payout-logo-img {width: 80px; height: 80px;}
        #paypal-payout-logo-img {width: 100px; height: 100px;}
        #amazon-payout-logo-img {width: 100px; height: 100px;}
        #netflix-payout-logo-img {width: 80px; height: 25px;}
        #spotify-payout-logo-img {width: 80px; height: 80px;}
    }

</style>
<!-- First Container -->
<div class="container">
    <!-- Header Start -->
    <div class="row" id="header-image">
        <div class="row justify-content-center p-3 px-sm-5" style="width: 100%;">
            <h1 id="header-text" class="px-2">{{trans('referrals.remember_share')}}</h1>
            <p class="text-center px-3 py-2 small-grey-text" style="color: white;">{{trans('referrals.important_note')}}</p>
        </div>
    </div>
    <!-- Code Information -->
    <div class="row justify-content-center px-md-5 p-3">
        <p class="small-grey-text">{{trans('rooms/confirmation.for_each_friend')}}</p>        
    </div>
    <div class="row justify-content-center mb-0" id="code-holder">
        <div class="col-5 text-left ml-0" style="margin: auto; font-size: 85%"><p class="m-0 text-uppercase">{{ $vicoReferrals->code}}</p></div>
        <div class="col-7 text-right"><a target="_blank" class="btn btn-primary" href="https://wa.me/?text=Hola!!%20Te%20recomiendo%20usar%20www.getvico.com%20para%20encontrar%20tu%20habitaci%C3%B3n,%20puedes%20ganar%2010%20USD%20si%20utlizas%20mi%20codigo:%20%22{{ $vicoReferrals->code}}%22%20!"><span class=" pr-1 icon-whatsapp-black" class="col-6 text-center btn btn-primary" style="min-width: 115px; color: white !important"></span> {{trans('rooms/confirmation.share')}}</a></div>
    </div>
    <!-- Social Media Logos 
    <div class="row justify-content-center mx-auto" id="social-media">
        <div class="col-3 text-center "><img class="icono-social" src="/svg/whatsapp-icono.svg" alt=""></div>
        <div class="col-3 text-center "><img class="icono-social" src="/svg/mensaje-icono.svg" alt=""></div>
        <div class="col-3 text-center "><img class="icono-social" src="/svg/compartir-icono.svg" alt=""></div>
        <div class="col-3 text-center "><img class="icono-social" src="/svg/enlace-icono.svg" alt=""></div>
    </div>
    -->
    <!-- Body -->
    <div class="row justify-content-center">
        <div class="col-auto py-5 p-md-5 text-sm-left">
            <p class="h2 text-center bold-words">{{trans('referrals.reference_state')}}</p>
        </div>
    </div>
    <div class="row px-sm-5">
        <div class="col-sm-6">
            <div class="pb-sm-3 text-sm-left text-center">
                <p class="orange-text h2 bold-words">${{$pending * 10}} USD</p>
                <p class="text-20">{{trans('referrals.your_balance')}}</p>
            </div>
        </div>
        <div class="col-sm-6 text-sm-right text-center">
            <p class="orange-text h2 mb-0 bold-words text-uppercase" id="payment-method">{{$vicoReferrals->payment_preference}}</p>
            <p class="text-20 mb-0">{{{trans('referrals.payment_method')}}}</p>
            <p data-toggle="modal" data-target="#paymentModal" class="orange-text text-decoration-underline">{{trans('referrals.change_it_here')}}</p>
        </div>
    </div>
    <div class="row d-none justify-content-center" id="successful-change">
        <div class="col-auto mt-3">
            <p class="mb-3 alert-success bold-words">👍 {{trans('referrals.preference_changed')}}</p>
        </div>
    </div>
    @if ($referralUses->count() > 0)
    <div class="row py-5">
        <p class="text-center col-12 bold-words h2">{{trans('referrals.payment_history')}}</p>
    </div>
    <!-- Rows of Referrals -->
    @for ($i = $referralUses->count() -1 ; $i > -1 ; $i--)
        @if ($i < $referralUses->count() - 3)
            @include('discounts.sections._referral', ['dont_display' => true])
        @else
            @include('discounts.sections._referral', ['dont_display' => false])
        @endif
    @endfor
    <!-- Referrals Footer -->
    <div class="row px-md-5 px-3 py-3">
        <div class="col-auto">
            @if ($pending > 1)
                <p class="text-20">{{$pending}} {{trans('referrals.pending_people')}}</p>
            @else 
                <p class="text-20">{{$pending}} {{trans('referrals.pending_person')}}</p>
            @endif
        </div>
        @if($referralUses->count() > 3)
        <div class="col text-right">
            <p class="orange-text text-20" id="see-more">{{trans('referrals.see_more')}}></p>
        </div>
        @endif
    </div>
    @endif
</div>
<!-- Container Two -->
<div class="container">
    <!-- Mobile -->
    <div class="d-md-none">
        <div class="row " id="header-image-2">
            <div class="row justify-content-center" style="width: 100%;">
                <h1 id="header-text-2" class="h1 p-md-5 text-center py-3 mb-4 bold-words">{{trans('referrals.invite_friend')}}</h1>
            </div>
        </div>
        <p class="h5 bold-words py-4 mb-0 text-center">{{trans('referrals.invite_friend_2')}}</p>
        <p class="small-grey-text text-20">{{trans('referrals.earn_money')}}<br> <br> {{trans('referrals.important_note')}}</p>
    </div>
    <!-- Desktop -->
    <div class="d-none d-md-block">
        <p class="h1 p-md-5 text-center py-3 bold-words">{{trans('referrals.invite_friend')}}</p>
        <div class="row justify-content-center pb-5">
            <div class="col-auto d-flex align-items-center">
                <img src="{{url('https://fom.imgix.net/section-4-bg.png?w=240&fit=crop&h=200&auto=compress')}}" class="vico-image ml-5 mr-3 mb-1">
            </div>
            <div class="col my-auto mr-5">
                <p class="h1">{{trans('referrals.invite_friend_2')}}</p>
                <p class="small-grey-text text-20">{{trans('referrals.earn_money')}} <br> <br> {{trans('referrals.important_note')}}</p>
            </div>
        </div>
    </div>    
      <!-- Desktop Modal -->
      <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <p class="h pt-4 p-3 text-center bold-words">{{trans('referrals.define_payout')}}</p>
                <div class="row justify-content-center">
                    <div class="col-md-3 col-5 m-3 p-0 justify-content-center payout-icon align-items-center d-flex referralPaymentMethod" data-name="vico cash" data-dismiss="modal" aria-label="Close" id="vico-payment-logo">
                        <img id="vico-payout-logo-img" src="{{asset('images/vico_v.png')}}" data-name="vico cash">
                    </div>
                    <div class="col-m-3 m-3 p-0 justify-content-center payout-icon align-items-center d-flex referralPaymentMethod" data-dismiss="modal" aria-label="Close" data-name="paypal" id="paypal-payment-logo">
                        <img id="paypal-payout-logo-img" src="{{asset('images/logos/paypal.png')}}" data-dismiss="modal" aria-label="Close" data-name="paypal" >
                    </div>
                    <div class="col-md-3 col-5 m-3 p-0 justify-content-center payout-icon align-items-center d-flex referralPaymentMethod" data-name="amazon" data-dismiss="modal" aria-label="Close" id="amazon-payment-logo">
                        <img id="amazon-payout-logo-img" src="{{asset('images/logos/amazon.png')}}" data-name="amazon">
                    </div>
                    <div class="col-md-3 col-5 m-3 p-0 justify-content-center payout-icon align-items-center d-flex referralPaymentMethod" data-name="netflix" data-dismiss="modal" aria-label="Close" id="netflix-payment-logo">
                        <img id="netflix-payout-logo-img" src="{{asset('images/logos/netflix.png')}}" data-name="netflix">
                    </div>
                    <div class="col-md-3 col-5 m-3 p-0 justify-content-center payout-icon align-items-center d-flex referralPaymentMethod" data-name="spotify" data-dismiss="modal" aria-label="Close" id="spotify-payment-logo">
                        <img id="spotify-payout-logo-img" src="{{asset('images/logos/spotify.png')}}" data-name="spotify">
                    </div>
                    <div class="col-md-3 col-5 m-3 p-0 justify-content-center payout-icon align-items-center d-flex referralPaymentMethod" data-name="cash" data-dismiss="modal" aria-label="Close" id="cash-payment-logo">
                        <img id="cash-payout-logo-img" src="{{asset('images/logos/cash.png')}}" data-name="cash">
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-auto">
            <p class="h1 p-md-5 text-center py-3 mb-4 bold-words">{{trans('referrals.how_work')}}</p>
        </div>
    </div>
    <div class="row justify-content-center text-center mx-md-4">
        <div class="col-lg-4">
            <img src="{{asset('images/referrals/enviar.svg')}}" style="width: 80px; height: 80px;">
            <p class="h3 pt-4">{{trans('referrals.step')}} 1</p>
            <p class="mb-5">{{trans('referrals.share_code')}}</p>
        </div>
        <div class="col-lg-4">
            <img src="{{asset('images/referrals/casa.svg')}}" style="width: 80px; height: 80px;">
            <p class="h3 pt-4">{{trans('referrals.step')}} 2</p>
            <p class="mb-5">{{trans('referrals.your_friend')}}</p>
        </div>
        <div class="col-lg-4">
            <img src="{{asset('images/referrals/dinero.svg')}}" style="width: 80px; height: 80px;">
            <p class="h3 pt-4">{{trans('referrals.step')}} 3</p>
            <p>{{trans('referrals.once_your_friend')}}</p>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-auto text-center">
            <p class="h1 p-md- text-center py-3 bold-words">{{trans('referrals.the_request')}}</p>
        </div>
    </div>
    <div class="row justify-content-center px-md-5 p-3">
        <div class="col-12 mb-3 px-0">
            <div class="faq px-2 mb-0" id="accordion">
                {{-- 1 --}}
                <div class="card">
                    <div class="card-header" id="faqHeading-1">
                        <div class="mb-0">
                            <h5 class="faq-title px-0" data-toggle="collapse" data-target="#faqCollapse-1" data-aria-expanded="true" data-aria-controls="faqCollapse-1">
                                <span class="badge">1</span>{{trans('referrals.where_can_i_find')}}
                            </h5>
                        </div>
                    </div>
                    <div id="faqCollapse-1" class="collapse" aria-labelledby="faqHeading-1" data-parent="#accordion">
                        <div class="card-body">
                            <p>{{trans('referrals.at_top_of_page')}}</p>
                        </div>
                    </div>
                </div>
                {{-- 2 --}}
                <div class="card">
                    <div class="card-header" id="faqHeading-2">
                        <div class="mb-0">
                            <h5 class="faq-title px-0" data-toggle="collapse" data-target="#faqCollapse-2" data-aria-expanded="false" data-aria-controls="faqCollapse-2">
                                <span class="badge">2</span> 
                                {{trans('referrals.how_many_times')}}
                            </h5>
                        </div>
                    </div>
                    <div id="faqCollapse-2" class="collapse" aria-labelledby="faqHeading-2" data-parent="#accordion">
                        <div class="card-body">
                            <p>
                                {{trans('referrals.as_many_times')}}
                            </p>
                        </div>
                    </div>
                </div>
                 {{-- 3 --}}
                 <div class="card">
                    <div class="card-header" id="faqHeading-3">
                        <div class="mb-0">
                            <h5 class="faq-title px-0" data-toggle="collapse" data-target="#faqCollapse-3" data-aria-expanded="false" data-aria-controls="faqCollapse-3">
                                <span class="badge">3</span> 
                                {{trans('referrals.how_do_i_get_paid')}}
                            </h5>
                        </div>
                    </div>
                    <div id="faqCollapse-3" class="collapse" aria-labelledby="faqHeading-3" data-parent="#accordion">
                        <div class="card-body">
                            <p>
                                {{trans('referrals.get_paid')}}
                            </p>
                        </div>
                    </div>
                </div>
                {{-- 4 --}}
                <div class="card">
                    <div class="card-header" id="faqHeading-4">
                        <div class="mb-0">
                            <h5 class="faq-title px-0" data-toggle="collapse" data-target="#faqCollapse-4" data-aria-expanded="false" data-aria-controls="faqCollapse-4">
                                <span class="badge">4</span> 
                                {{trans('referrals.when_pay')}}
                            </h5>
                        </div>
                    </div>
                    <div id="faqCollapse-4" class="collapse" aria-labelledby="faqHeading-4" data-parent="#accordion">
                        <div class="card-body">
                            <p>
                                {{trans('referrals.paid_monthly')}}
                            </p>
                        </div>
                    </div>
                </div>
                {{-- 5 --}}
                <div class="card">
                    <div class="card-header" id="faqHeading-5">
                        <div class="mb-0">
                            <h5 class="faq-title px-0" data-toggle="collapse" data-target="#faqCollapse-5" data-aria-expanded="false" data-aria-controls="faqCollapse-5">
                                <span class="badge">5</span> 
                                {{trans('referrals.what_use_code')}}
                            </h5>
                        </div>
                    </div>
                    <div id="faqCollapse-5" class="collapse" aria-labelledby="faqHeading-5" data-parent="#accordion">
                        <div class="card-body">
                            <p>
                                {{trans('referrals.can_be_applied')}}
                            </p>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>

    // change payment method when different things selected
    var vicoLogo = document.getElementById('vico-payment-logo');
    var amazonLogo = document.getElementById('amazon-payment-logo');
    var paypalLogo = document.getElementById('paypal-payment-logo');
    var cashLogo = document.getElementById('cash-payment-logo');
    var spotifyLogo = document.getElementById('spotify-payment-logo');
    var netflixLogo = document.getElementById('netflix-payment-logo');
    var paymentMethodElement = document.getElementById('payment-method');
    var seeMore = document.getElementById('see-more');
    var unhideMe = document.getElementsByClassName('unhide-me')

    // Modal Logos
    vicoLogo.onclick = function(){paymentMethodElement.innerHTML = "VICO Credit"};
    amazonLogo.onclick = function(){paymentMethodElement.innerHTML = "Amazon"};
    paypalLogo.onclick = function(){paymentMethodElement.innerHTML = "Paypal"};
    cashLogo.onclick = function(){paymentMethodElement.innerHTML = "Cash"};
    spotifyLogo.onclick = function(){paymentMethodElement.innerHTML = "Spotify"};
    netflixLogo.onclick = function(){paymentMethodElement.innerHTML = "Netflix"};    
    
    let seeMoreClicked = false; 
        
    seeMore.onclick = function(){
        
        if (seeMoreClicked){
            // Hide payment history
            for (var i = 0; i < unhideMe.length; i++) {
                (function (i) {
                    setTimeout(function () {
                        unhideMe[i].classList.add("d-none")
                    }, 30*i);
                })(i);
            };
            seeMoreClicked = false;
            seeMore.innerHTML = "{{trans('referrals.see_more')}}";
        }

        else {
            // Unhide payment history
            for (var i = 0; i < unhideMe.length; i++) {
                (function (i) {
                    setTimeout(function () {
                        unhideMe[i].classList.remove("d-none")
                    }, 30*i);
                })(i);
            };
            seeMoreClicked = true;
            seeMore.innerHTML = "{{trans('referrals.see_less')}}";
        }
    }

</script>
@endsection