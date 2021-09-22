@extends('layouts.app')
{{-- SECTION: TITLE  --}}
@section('title', 'FAQ para invitados')
{{--SECTION: META--}}
@section('meta')
<meta name="description" content="Si tienes preguntas cómo funciona VICO, puedes entrar aquí y aprender más sobre nosotros. No dudes en contactarnos.">
{{-- PRIVATE SITE: NOINDEX NO FOLLOW IN ORDER TO PREVENT LOOKUP IN GOOLGE --}}
<meta property="og:title" content=""/>
<meta property="og:image" content="" />
<meta property="og:site_name" content="VICO"/>
<meta property="og:description" content=""/>
@endsection
{{-- SECTION: STYLES --}}
@section('styles')
{{-- FAQ STYLES --}}
<style type="text/css">
	
	.faq-section {
	    min-height: 100vh;
	    padding: 10vh 0 0;
	}
	.faq-title h2 {
	  position: relative;
	  margin-bottom: 45px;
	  display: inline-block;
	  font-weight: 600;
	  line-height: 1;
	}
	.faq-title h2::before {
	    content: "";
	    position: absolute;
	    left: 50%;
	    width: 60px;
	    height: 2px;
	    background: #ef8e01;
	    bottom: -25px;
	    margin-left: -30px;
	}
	.faq-title p {
	  padding: 0 190px;
	  margin-bottom: 10px;
	}

	.faq {
	  background: #FFFFFF;
	  box-shadow: 0 2px 48px 0 rgba(0, 0, 0, 0.06);
	  border-radius: 4px;
	}

	.faq .card {
	  border: none;
	  background: none;
	  border-bottom: .5px dashed #CEE1F8;
	}

	.faq .card .card-header {
	  padding: 0px;
	  border: none;
	  background: none;
	  -webkit-transition: all 0.3s ease 0s;
	  -moz-transition: all 0.3s ease 0s;
	  -o-transition: all 0.3s ease 0s;
	  transition: all 0.3s ease 0s;
	}

	.faq .card .card-header:hover {
	    background: rgba(239, 142, 1, 0.1);
	    padding-left: 10px;
	}
	.faq .card .card-header .faq-title {
	  width: 100%;
	  text-align: left;
	  padding: 0px;
	  padding-left: 30px;
	  padding-right: 30px;
	  font-weight: 400;
	  font-size: 15px;
	  letter-spacing: 1px;
	  text-decoration: none !important;
	  -webkit-transition: all 0.3s ease 0s;
	  -moz-transition: all 0.3s ease 0s;
	  -o-transition: all 0.3s ease 0s;
	  transition: all 0.3s ease 0s;
	  cursor: pointer;
	  padding-top: 20px;
	  padding-bottom: 20px;
	}

	.faq .card .card-header .faq-title .badge {
	  display: inline-block;
	  width: 24px;
	  height: 24px;
	  line-height: 14px;
	  float: left;
	  -webkit-border-radius: 100px;
	  -moz-border-radius: 100px;
	  border-radius: 100px;
	  text-align: center;
	  background: #ef8e01;
	  color: #fff;
	  font-size: 12px;
	  margin-right: 20px;
	  padding: 0.45em 0.4em;
	}

	.faq .card .card-body {
	  padding: 30px;
	  padding-left: 35px;
	  padding-bottom: 16px;
	  font-weight: 400;
	  font-size: 16px;
	  line-height: 28px;
	  border-top: 1px solid #F3F8FF;
	}

	.faq .card .card-body p {
	  margin-bottom: 14px;
	}

	@media (max-width: 991px) {
	  .faq {
	    margin-bottom: 30px;
	  }
	  .faq .card .card-header .faq-title {
	    line-height: 26px;
	    margin-top: 10px;
	  }
	}
</style>
@endsection
{{-- SECTION: CONTENT --}}
@section('content')
<div>
	<section class="faq-section">
	<div class="container">
		<div class="row">

	        <!-- ***** FAQ Start ***** -->
	        <div class="col-md-6 offset-md-3">

	            <div class="faq-title text-center pb-3">
	                <h2>FAQ</h2>
	            </div>
	        
	        </div>
	        
	        <div class="col-md-6 offset-md-3 pb-4">
	            <div class="faq" id="accordion">

	            {{-- Card Process --}}
	                <div class="card">
	                    <div class="card-header" id="faqHeading-1">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-1" data-aria-expanded="true" data-aria-controls="faqCollapse-1">
	                                <span class="badge">1</span>{{trans('faq.how_works')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqCollapse-1" class="collapse" aria-labelledby="faqHeading-1" data-parent="#accordion">
	                        <div class="card-body">
	                            <div class="row mb-4">
	                                            {{-- PROCESS ICON --}}
	                                            <div class="col-3 text-center">
	                                              <div class="booking-show-process-circle">
	                                                <img style="height: 64px; width: 64px" src="{{asset('images/process/modal/request.png')}}" alt="independent" srcset="{{asset('images/process/modal/request@2x.png')}} 2x, {{asset('images/process/modal/request@3x.png')}} 3x" />
	                                              </div>
	                                            </div>
	                                             {{-- END PROCESS ICON --}}
	                                            {{-- PROCESS EXPLANATION --}}
	                                            <div class="col-9 pr-0 pr-md-4">
	                                              <ul class="bullet-points-off">
	                                                <li><p class="h5 mb-0 mt-1">{{trans('faq.the_first_booking')}}</p>
	                                                </li>
	                                                <li><p class="font-weight-light text-justify">{{trans('faq.first_request_book')}}</p>
	                                                </li>
	                                              </ul>
	                                            </div>
	                                            {{-- END PROCESS EXPLANATION --}}
	                                          </div>
	                                          {{-- END ROW-PROCESS --}}

	                                          {{-- ROW-PROCESS --}}
	                                          <div class="row mb-4">
	                                            {{-- PROCESS ICON --}}
	                                            <div class="col-3 text-center">
	                                              <div class="booking-show-process-circle">
	                                                <img style="height: 64px; width: 64px" src="{{asset('images/process/modal/chat.png')}}" alt="independent" srcset="{{asset('images/process/modal/chat@2x.png')}} 2x, {{asset('images/process/modal/chat@3x.png')}} 3x" />
	                                              </div>
	                                            </div>
	                                            {{-- END PROCESS ICON --}}
	                                            {{-- PROCESS EXPLANATION --}}
	                                            <div class="col-9 pr-0 pr-md-4">
	                                              <ul class="bullet-points-off">
	                                                <li><p class="h5 mb-0 mt-1">{{trans('faq.the_chat')}}</p>
	                                                </li>
	                                                <li><p class="font-weight-light text-justify">{{trans('faq.in_our_chat')}}</p>
	                                                </li>
	                                              </ul>
	                                            </div>
	                                            {{-- END PROCESS EXPLANATION --}}
	                                          </div>
	                                          {{-- END ROW-PROCESS --}}

	                                          {{-- ROW-PROCESS --}}
	                                          <div class="row mb-4">
	                                            {{-- PROCESS ICON --}}
	                                            <div class="col-3 text-center">
	                                              <div class="booking-show-process-circle">
	                                                <img style="height: 64px; width: 64px" src="{{asset('images/process/modal/accept.png')}}" alt="independent" srcset="{{asset('images/process/modal/accept@2x.png')}} 2x, {{asset('images/process/modal/accept@3x.png')}} 3x" />
	                                              </div>
	                                            </div>
	                                            {{-- END PROCESS ICON --}}
	                                            {{-- PROCESS EXPLANATION --}}
	                                            <div class="col-9 pr-0 pr-md-4">
	                                              <ul class="bullet-points-off">
	                                                <li><p class="h5 mb-0 mt-1">{{trans('faq.acceptance')}}</p>
	                                                </li>
	                                                <li><p class="font-weight-light text-justify">{{trans('faq.by_accepting_owner_gives')}}</p>
	                                                </li>
	                                              </ul>
	                                            </div>
	                                            {{-- END PROCESS EXPLANATION --}}
	                                          </div>
	                                         {{-- END ROW-PROCESS --}}

	                                         {{-- ROW-PROCESS --}}
	                                          <div class="row mb-4">
	                                            {{-- PROCESS ICON --}}
	                                            <div class="col-3 text-center">
	                                              <div class="booking-show-process-circle">
	                                                <img style="height: 64px; width: 64px" src="{{asset('images/process/modal/creditcard.png')}}" alt="independent" srcset="{{asset('images/process/modal/creditcard@2x.png')}} 2x, {{asset('images/process/modal/creditcard@3x.png')}} 3x" />
	                                              </div>
	                                            </div>
	                                            {{-- END PROCESS ICON --}}
	                                            {{-- PROCESS EXPLANATION --}}
	                                            <div class="col-9 pr-0 pr-md-4">
	                                              <ul class="bullet-points-off">
	                                                <li><p class="h5 mb-0 mt-1">{{trans('faq.booking_payment')}}</p>
	                                                </li>
	                                                <li><p class="font-weight-light text-justify">{{trans('faq.as_soon_as')}}</p>
	                                                </li>
	                                              </ul>
	                                            </div>
	                                            {{-- END PROCESS EXPLANATION --}}
	                                          </div>
	                                           {{-- END ROW-PROCESS --}}
	                        </div>
	                    </div>
	                </div>

	            {{-- Card Reserva --}}
	                <div class="card">
	                    <div class="card-header" id="faqHeading-2">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-2" data-aria-expanded="false" data-aria-controls="faqCollapse-2">
	                                <span class="badge">2</span> 
	                                {{trans('faq.how_can_i_reserve')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqCollapse-2" class="collapse" aria-labelledby="faqHeading-2" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                                {{trans('faq.reserve_room')}}
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card  Como resera --}}
	                <div class="card">
	                    <div class="card-header" id="faqHeading-3">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-3" data-aria-expanded="false" data-aria-controls="faqCollapse-3">
	                                <span class="badge">3</span> 
	                                {{trans('faq.what_is_amount')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqCollapse-3" class="collapse" aria-labelledby="faqHeading-3" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.value_of_deposit')}}
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card Give Back Deposit --}}
	                <div class="card">
	                    <div class="card-header" id="faqHeading-4">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-4" data-aria-expanded="false" data-aria-controls="faqCollapse-4">
	                                <span class="badge">4</span> {{trans('faq.will_i_get_deposit')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqCollapse-4" class="collapse" aria-labelledby="faqHeading-4" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.yes_if')}}
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card What happens with deposit --}}
	                <div class="card">
	                    <div class="card-header" id="faqHeading-5">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-5" data-aria-expanded="false" data-aria-controls="faqCollapse-5">
	                                <span class="badge">5</span> {{trans('faq.what_happen')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqCollapse-5" class="collapse" aria-labelledby="faqHeading-5" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.deposit_kept')}}
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card Recibe  --}}
	                <div class="card">
	                    <div class="card-header" id="faqHeading-6">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-6" data-aria-expanded="false" data-aria-controls="faqCollapse-6">
	                                <span class="badge">6</span> {{trans('faq.get_receipt')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqCollapse-6" class="collapse" aria-labelledby="faqHeading-6" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.booking_confirmation')}}
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card Cancel --}}
	                <div class="card">
	                    <div class="card-header" id="faqHeading-7">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-7" data-aria-expanded="false" data-aria-controls="faqCollapse-7">
	                                <span class="badge">7</span> {{trans('faq.cancel_booking')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqCollapse-7" class="collapse" aria-labelledby="faqHeading-7" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.of_course_if_you_want_to_cancel')}}
	                            	<p>{{trans('faq.number_of_solicitude')}}</p>
									<p>{{trans('faq.name_last_name')}}
									</p>
	                            	<p>{{trans('faq.last_name')}}</p>
	                            	<p>{{trans('faq.name_of_vico')}}</p>
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card Cancelacion --}}
	                <div class="card">
	                    <div class="card-header" id="faqHeading-8">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-8" data-aria-expanded="false" data-aria-controls="faqCollapse-8">
	                                <span class="badge">8</span> {{trans('faq.do_i_get')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqCollapse-8" class="collapse" aria-labelledby="faqHeading-8" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.yes_refund')}}
	                            	<p>{{trans('faq.with_more_than')}}</p>
	                            	<p>{{trans('faq.with_less_than')}}</p>
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card Room not good --}}
	                <div class="card">
	                    <div class="card-header" id="faqHeading-9">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-9" data-aria-expanded="false" data-aria-controls="faqCollapse-9">
	                                <span class="badge">9</span> {{trans('faq.what_happen_if_arrival')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqCollapse-9" class="collapse" aria-labelledby="faqHeading-9" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.no_problem')}}
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card 1. Rent --}}
	                <div class="card">
	                    <div class="card-header" id="faqHeading-10">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-10" data-aria-expanded="false" data-aria-controls="faqCollapse-10">
	                                <span class="badge">10</span> {{trans('faq.when_do_i')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqCollapse-10" class="collapse" aria-labelledby="faqHeading-10" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.after_arrival')}}
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card How to pay Rent --}}
	                <div class="card">
	                    <div class="card-header" id="faqHeading-11">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-11" data-aria-expanded="false" data-aria-controls="faqCollapse-11">
	                                <span class="badge">11</span> {{trans('faq.how_pay')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqCollapse-11" class="collapse" aria-labelledby="faqHeading-11" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.go_to_site')}}
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            </div>
	        </div>

	    </div>

	    		<div class="row">
			
	        <!-- ***** FAQ Estancia ***** -->
	        <div class="col-md-6 offset-md-3">

	            <div class="faq-title text-center pb-3">
	                <h2>{{trans('faq.faq_stay')}}</h2>
	            </div>
	        
	        </div>
	        
	        <div class="col-md-6 offset-md-3 pb-4">
	            <div class="faq" id="accordion">

	            {{-- Card Process --}}
	                <div class="card">
	                    <div class="card-header" id="faqStayHeading-1">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqStayCollapse-1" data-aria-expanded="true" data-aria-controls="faqStayCollapse-1">
	                                <span class="badge">1</span>{{trans('faq.is_lease')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqStayCollapse-1" class="collapse" aria-labelledby="faqStayHeading-1" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.yes_making_payment')}}
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card Reserva --}}
	                <div class="card">
	                    <div class="card-header" id="faqStayHeading-2">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqStayCollapse-2" data-aria-expanded="false" data-aria-controls="faqStayCollapse-2">
	                                <span class="badge">2</span> 
	                                {{trans('faq.how_terminate')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqStayCollapse-2" class="collapse" aria-labelledby="faqStayHeading-2" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                                <p>E{{trans('faq.send_email')}}</p>
									<p>{{trans('faq.three_ways')}}</p>
									<ul>
										<li>
											<p>{{trans('faq.duration_ends')}}</p>
											<p>{{trans('faq.no_consequences')}}</p>
										</li>
										<li>
											<p>{{trans('faq.one_months_notice')}}</p>
											<p>{{trans('faq.no_consequences')}}</p>
										</li>
										<li>
											<p>{{trans('faq.leave_without')}}</p>
											<p>{{trans('faq.host_keeps')}}</p>
										</li>
									</ul>
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card  Como resera --}}
	                <div class="card">
	                    <div class="card-header" id="faqStayHeading-3">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqStayCollapse-3" data-aria-expanded="false" data-aria-controls="faqStayCollapse-3">
	                                <span class="badge">3</span> 
	                                {{trans('faq.what_worst')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqStayCollapse-3" class="collapse" aria-labelledby="faqStayHeading-3" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.minimize_risk')}}
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card Give Back Deposit --}}
	                <div class="card">
	                    <div class="card-header" id="faqStayHeading-4">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqStayCollapse-4" data-aria-expanded="false" data-aria-controls="faqStayCollapse-4">
	                                <span class="badge">4</span> {{trans('faq.can_i_pay')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqStayCollapse-4" class="collapse" aria-labelledby="faqStayHeading-4" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.yes_for_safety')}}
									<ul>
										<li>
											<p>{{trans('faq.secure_online')}}</p>
										</li>
										<li>
											<p>{{trans('faq.pay_with_card')}}</p>
										</li>
										<li>
											<p>{{trans('faq.formal_payment')}}</p>
										</li>
									</ul>
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card What happens with deposit --}}
	                <div class="card">
	                    <div class="card-header" id="faqStayHeading-5">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqStayCollapse-5" data-aria-expanded="false" data-aria-controls="faqStayCollapse-5">
	                                <span class="badge">5</span>{{trans('faq.what_if_i_leave')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqStayCollapse-5" class="collapse" aria-labelledby="faqStayHeading-5" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.everything_is_flexible')}}
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card Recibe  --}}
	                <div class="card">
	                    <div class="card-header" id="faqStayHeading-6">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqStayCollapse-6" data-aria-expanded="false" data-aria-controls="faqStayCollapse-6">
	                                <span class="badge">6</span>{{trans('faq.when_do_i_pay')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqStayCollapse-6" class="collapse" aria-labelledby="faqStayHeading-6" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.payment_date')}}
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card Cancel --}}
	                <div class="card">
	                    <div class="card-header" id="faqStayHeading-7">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqStayCollapse-7" data-aria-expanded="false" data-aria-controls="faqStayCollapse-7">
	                                <span class="badge">7</span>{{trans('faq.have_questions')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqStayCollapse-7" class="collapse" aria-labelledby="faqStayHeading-7" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.contact_us')}}
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            </div>
	        </div>

	    </div>

    </div>
    </section>
</div>

@endsection
{{-- SECTION: SCRIPTS --}}
@section('scripts')
@endsection






