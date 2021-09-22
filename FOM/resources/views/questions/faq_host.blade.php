@extends('layouts.app')
{{-- SECTION: TITLE  --}}
@section('title', 'Preguntas frecuentes para anfitriones')
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
{{-- FAQ STYLES NOW IN _generals.scss--}}
@endsection
{{-- SECTION: CONTENT --}}
@section('content')
<div>
	<section class="faq-section">
	<div class="container">
	
	<!-- ***** FAQ Start ***** -->
		<div class="row">	        
	        <div class="col-md-6 offset-md-3">

	            <div class="faq-title text-center pb-3">
	                <h2>{{trans('faq.the_booking')}}</h2>
	            </div>
	        
	        </div>
	        
	        <div class="col-md-6 offset-md-3 pb-4">
	            <div class="faq" id="accordion">

	            {{-- Card Process --}}
	                <div class="card">
	                    <div class="card-header" id="faqHeading-1">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-1" data-aria-expanded="true" data-aria-controls="faqCollapse-1">
	                                <span class="badge">1</span>{{trans('faq.what_is_solicitud')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqCollapse-1" class="collapse" aria-labelledby="faqHeading-1" data-parent="#accordion">
	                        <div class="card-body">
	                        	<p>
	                        		{{trans('faq.its_a_message')}}
	                        	</p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card Reserva --}}
	                <div class="card">
	                    <div class="card-header" id="faqHeading-2">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-2" data-aria-expanded="false" data-aria-controls="faqCollapse-2">
	                                <span class="badge">2</span> 
	                                {{trans('faq.what_information')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqCollapse-2" class="collapse" aria-labelledby="faqHeading-2" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.it_contains')}}
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
	                                {{trans('faq.how_do_i_know')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqCollapse-3" class="collapse" aria-labelledby="faqHeading-3" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.there_are_three_ways')}}
	                            	<ul>
	                            		<li>
	                            			{{trans('faq.email')}}
	                            		</li>
	                            		<li>
	                            			{{trans('faq.whatsapp')}}
	                            		</li>
	                            		<li>
	                            			{{trans('faq.log_in')}}
	                            		</li>
	                            	</ul>
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card Give Back Deposit --}}
	                <div class="card">
	                    <div class="card-header" id="faqHeading-4">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-4" data-aria-expanded="false" data-aria-controls="faqCollapse-4">
	                                <span class="badge">4</span>{{trans('faq.how_can_i')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqCollapse-4" class="collapse" aria-labelledby="faqHeading-4" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.you_can_do')}}
	                            </p>
	                            <p>
	                            	{{trans('faq.this_button_takes')}}
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card What happens with deposit --}}
	                <div class="card">
	                    <div class="card-header" id="faqHeading-5">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-5" data-aria-expanded="false" data-aria-controls="faqCollapse-5">
	                                <span class="badge">5</span>{{trans('faq.can_i_speak')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqCollapse-5" class="collapse" aria-labelledby="faqHeading-5" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.of_course_in_section')}}
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card Recibe  --}}
	                <div class="card">
	                    <div class="card-header" id="faqHeading-6">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-6" data-aria-expanded="false" data-aria-controls="faqCollapse-6">
	                                <span class="badge">6</span> {{trans('faq.what_happens')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqCollapse-6" class="collapse" aria-labelledby="faqHeading-6" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.by_accepting')}}
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card Cancel --}}
	                <div class="card">
	                    <div class="card-header" id="faqHeading-7">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-7" data-aria-expanded="false" data-aria-controls="faqCollapse-7">
	                                <span class="badge">7</span>{{trans('faq.what_if')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqCollapse-7" class="collapse" aria-labelledby="faqHeading-7" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.if_the_person')}}
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card Cancelacion --}}
	                <div class="card">
	                    <div class="card-header" id="faqHeading-8">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-8" data-aria-expanded="false" data-aria-controls="faqCollapse-8">
	                                <span class="badge">8</span> {{trans('faq.is_it_possible')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqCollapse-8" class="collapse" aria-labelledby="faqHeading-8" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.you_can_cancel')}}
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card Room not good --}}
	                <div class="card">
	                    <div class="card-header" id="faqHeading-9">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-9" data-aria-expanded="false" data-aria-controls="faqCollapse-9">
	                                <span class="badge">9</span> {{trans('faq.what_guarantee_do_i_have')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqCollapse-9" class="collapse" aria-labelledby="faqHeading-9" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.the_user_must')}}
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card 1. Rent --}}
	                <div class="card">
	                    <div class="card-header" id="faqHeading-10">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-10" data-aria-expanded="false" data-aria-controls="faqCollapse-10">
	                                <span class="badge">10</span>{{trans('faq.do_i_receive')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqCollapse-10" class="collapse" aria-labelledby="faqHeading-10" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.in_general')}}
	                            	<ul>
	                            		<li>
	                            			{{trans('faq.if_never_show')}}
	                            		</li>
	                            		<li>
	                            			{{trans('faq.if_leaves_vico')}}
	                            		</li>
	                            		<li>
	                            			{{trans('faq.if_damage_vico')}}
	                            		</li>
	                            	</ul>
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card How to pay Rent --}}
	                <div class="card">
	                    <div class="card-header" id="faqHeading-11">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-11" data-aria-expanded="false" data-aria-controls="faqCollapse-11">
	                                <span class="badge">11</span>{{trans('faq.if_wants_to_see')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqCollapse-11" class="collapse" aria-labelledby="faqHeading-11" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.if_already_in')}}
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card How to pay Rent --}}
	                <div class="card">
	                    <div class="card-header" id="faqHeading-12">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-12" data-aria-expanded="false" data-aria-controls="faqCollapse-12">
	                                <span class="badge">12</span>{{trans('faq.dont_get_booking')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqCollapse-12" class="collapse" aria-labelledby="faqHeading-12" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.may_be_different')}}
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            </div>
	        </div>

	    </div>


    <!-- ***** FAQ Pagos ***** -->

	    <div class="row">	

	        <div class="col-md-6 offset-md-3">

	            <div class="faq-title text-center pb-3">
	                <h2>{{trans('faq.faq_payments')}}</h2>
	            </div>
	        
	        </div>
	        
	        <div class="col-md-6 offset-md-3 pb-4">
	            <div class="faq" id="accordion">

	            {{-- Card Process --}}
	                <div class="card">
	                    <div class="card-header" id="faqPaymentHeading-1">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqPaymentCollapse-1" data-aria-expanded="true" data-aria-controls="faqPaymentCollapse-1">
	                                <span class="badge">1</span>{{trans('faq.how_do_payments')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqPaymentCollapse-1" class="collapse" aria-labelledby="faqPaymentHeading-1" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.we_have_2_payments')}}

	                            	<p>{{trans('faq.booking_payment_reserve')}}</p>
	                            	<p>{{trans('faq.payment_of_monthly')}}</p>
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card Reserva --}}
	                <div class="card">
	                    <div class="card-header" id="faqPaymentHeading-2">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqPaymentCollapse-2" data-aria-expanded="false" data-aria-controls="faqPaymentCollapse-2">
	                                <span class="badge">2</span> 
	                                {{trans('faq.how_terminate')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqPaymentCollapse-2" class="collapse" aria-labelledby="faqPaymentHeading-2" data-parent="#accordion">
	                        <div class="card-body">
	                            	<p>
		                                {{trans('faq.payment_of_booking')}}
		                            </p>

		                            <ul>
		                            	<li>
		                            		{{trans('faq.if_never_show')}}
		                            	</li>
		                            	<li>
		                            		{{trans('faq.person_leaves_your_vico')}}
		                            	</li>
		                            	<li>
		                            		{{trans('faq.if_damage_vico')}}
		                            	</li>
		                            </ul>
	                                <p>
	                                	{{trans('faq.monthly_rent_payment')}}
	                                </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card  Como resera --}}
	                <div class="card">
	                    <div class="card-header" id="faqPaymentHeading-3">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqPaymentCollapse-3" data-aria-expanded="false" data-aria-controls="faqPaymentCollapse-3">
	                                <span class="badge">3</span> 
	                                {{trans('faq.do_i_receive')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqPaymentCollapse-3" class="collapse" aria-labelledby="faqPaymentHeading-3" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.in_general')}}
	                            	<ul>
	                            		<li>
	                            			{{trans('faq.if_never_show')}}
	                            		</li>
	                            		<li>
	                            			{{trans('faq.if_leaves_vico')}}

	                            		</li>
	                            		<li>
	                            			{{trans('faq.if_damage_vico')}}
	                            		</li>
	                            	</ul>
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card Give Back Deposit --}}
	                <div class="card">
	                    <div class="card-header" id="faqPaymentHeading-4">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqPaymentCollapse-4" data-aria-expanded="false" data-aria-controls="faqPaymentCollapse-4">
	                                <span class="badge">4</span>{{trans('faq.when_is_rent')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqPaymentCollapse-4" class="collapse" aria-labelledby="faqPaymentHeading-4" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.when_is_rent')}}
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card What happens with deposit --}}
	                <div class="card">
	                    <div class="card-header" id="faqPaymentHeading-5">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqPaymentCollapse-5" data-aria-expanded="false" data-aria-controls="faqPaymentCollapse-5">
	                                <span class="badge">5</span>{{trans('faq.what_percentage')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqPaymentCollapse-5" class="collapse" aria-labelledby="faqPaymentHeading-5" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.vico_receives_7')}}
	                            </p>
	                        </div>
	                    </div>
	                </div>
	             {{-- End Card --}}
	                
	            </div>
	        </div>

	    </div>	    

	<!-- ***** FAQ Reglas ***** -->
	    <div class="row">	

	        
	        <div class="col-md-6 offset-md-3">

	            <div class="faq-title text-center pb-3">
	                <h2>{{trans('faq.faq_rules')}}</h2>
	            </div>
	        
	        </div>
	        
	        <div class="col-md-6 offset-md-3 pb-4">
	            <div class="faq" id="accordion">

	            {{-- Card Process --}}
	                <div class="card">
	                    <div class="card-header" id="faqReglasHeading-1">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqReglasCollapse-1" data-aria-expanded="true" data-aria-controls="faqReglasCollapse-1">
	                                <span class="badge">1</span>{{trans('faq.is_there_lease')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqReglasCollapse-1" class="collapse" aria-labelledby="faqReglasHeading-1" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.co_living_contract')}}
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card Reserva --}}
	                <div class="card">
	                    <div class="card-header" id="faqReglasHeading-2">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqReglasCollapse-2" data-aria-expanded="false" data-aria-controls="faqReglasCollapse-2">
	                                <span class="badge">2</span> 
	                                {{trans('faq.what_happens_if')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqReglasCollapse-2" class="collapse" aria-labelledby="faqReglasHeading-2" data-parent="#accordion">
	                        <div class="card-body">
	                            	<p>
	                            		{{trans('faq.guest_must_notify')}}
		                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card  Como resera --}}
	                <div class="card">
	                    <div class="card-header" id="faqReglasHeading-3">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqReglasCollapse-3" data-aria-expanded="false" data-aria-controls="faqReglasCollapse-3">
	                                <span class="badge">3</span> 
	                                {{trans('faq.do_i_need')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqReglasCollapse-3" class="collapse" aria-labelledby="faqReglasHeading-3" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.no_work_with_vico')}}
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card Give Back Deposit --}}
	                <div class="card">
	                    <div class="card-header" id="faqReglasHeading-4">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqReglasCollapse-4" data-aria-expanded="false" data-aria-controls="faqReglasCollapse-4">
	                                <span class="badge">4</span>{{trans('faq.who_defines_rules')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqReglasCollapse-4" class="collapse" aria-labelledby="faqReglasHeading-4" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.when_you_put')}}
	                            </p>
	                        </div>
	                    </div>
	                </div>

	            {{-- Card What happens with deposit --}}
	                <div class="card">
	                    <div class="card-header" id="faqReglasHeading-5">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqReglasCollapse-5" data-aria-expanded="false" data-aria-controls="faqReglasCollapse-5">
	                                <span class="badge">5</span>{{trans('faq.do_i_have_update')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqReglasCollapse-5" class="collapse" aria-labelledby="faqReglasHeading-5" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.yes_it_important')}}
	                            </p>
	                        </div>
	                    </div>
	                </div>
	             {{-- End Card --}}

	            {{-- Card What happens with deposit --}}
	                <div class="card">
	                    <div class="card-header" id="faqReglasHeading-6">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqReglasCollapse-6" data-aria-expanded="false" data-aria-controls="faqReglasCollapse-6">
	                                <span class="badge">6</span>{{trans('faq.can_i_rate_guests')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqReglasCollapse-6" class="collapse" aria-labelledby="faqReglasHeading-6" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.as_soon_as_guest')}}
	                            </p>
	                        </div>
	                    </div>
	                </div>
	             {{-- End Card --}}

	            {{-- Card What happens with deposit --}}
	                <div class="card">
	                    <div class="card-header" id="faqReglasHeading-7">
	                        <div class="mb-0">
	                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqReglasCollapse-7" data-aria-expanded="false" data-aria-controls="faqReglasCollapse-7">
	                                <span class="badge">7</span>{{trans('faq.can_i_upload')}}
	                            </h5>
	                        </div>
	                    </div>
	                    <div id="faqReglasCollapse-7" class="collapse" aria-labelledby="faqReglasHeading-7" data-parent="#accordion">
	                        <div class="card-body">
	                            <p>
	                            	{{trans('faq.faq_prop')}}
	                            </p>
	                        </div>
	                    </div>
	                </div>
	             {{-- End Card --}}
	                
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






