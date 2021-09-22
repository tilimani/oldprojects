@extends('layouts.app')

@section('title', 'Cambiar método de pago')

@section('scripts')
    @include('payments.final.sections._scripts')
@endsection

@section('styles')
    @if (session('insufficient_funds'))
    <div class="alert-danger center text-center">
        {{ session('insufficient_funds') }}
    </div>
    @elseif(session('msg-alert'))
    <div class="alert-danger center text-center">
        {{ session('msg-alert') }}
    </div>
    @endif
    <style>
        @media (min-width: 769px) {

            .history-container {
                padding-top: 2rem;
                padding-left: 3rem;
                padding-right: 3rem;
                padding-bottom: 2rem;
            }
        }

        @media (max-width: 768px) {

            .history-container {
                padding-top: 2rem;
                padding-left: 0.75rem;
                padding-right: 0.75rem;
                padding-bottom: 2rem;
            }
        }

        @media (max-width: 425px) {
            .no-margin {
                margin: 0;
                padding: 0;
            }

            .history-container {
                padding-top: 0.5rem;
            }
        }
    </style>
@endsection

@section('content')
    <script src="//js.stripe.com/v3/"></script>
    <div class="container">
        <div class="row">
            <div class="col-8 col-sm-8 col-md-8 col-lg-8 offset-2 offset-sm-2 offset-md-2 offset-lg-2">
                <p class="h2 font-weight-bold mt-5">{{trans('general.add_payment')}}</p>
            </div>
            <div class="col-12 text-center">
                <img class="img-fluid" src="{{asset('images/vico_logo_transition/VICO_VIVIR_orange.png')}}" alt="Responsive image">
            </div>
            <div class="col-sm-8 col-md-8 col-lg-8 offset-2 offset-sm-2 offset-md-2 offset-lg-2 no-margin">
                @include(
                    'payments.final.sections._rightpanel', [
                        'content' => false,
                        'addpayment' => true,
                        'change'  => false
                    ]
                )
            </div>
        </div>
    </div>
@endsection
