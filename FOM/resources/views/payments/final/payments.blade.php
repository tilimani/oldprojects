@extends('layouts.app')

@section('title', 'Proceso de pago VICO')

@section('styles')
    <style>
        @media (min-width: 769px) {
            .history-container{
                padding-top: 5rem;
                padding-left: 3rem;
                padding-right: 3rem;
            }
        }
        @media (max-width: 768px) {
            .history-container{
                padding-top: 5rem;
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }
        }
        @media (max-width: 425px) {
            .no-margin{
                margin: 0;
                padding: 0;
            }
        }

        .emojis {font-size: 30px;}
    </style>
@endsection

@section('scripts')
    @include('payments.final.sections._scripts')
    <script>
        $(document).ready(function () {$('#warningModal').modal('show');});
    </script>
@endsection

@section('content')
<script src="//js.stripe.com/v3/"></script>
    @if (session('insufficient_funds'))
        <div class="alert-danger center text-center">
            {{ session('insufficient_funds') }}
        </div>
    @elseif(session('msg-alert'))
        <div class="alert-danger center text-center">
            {{ session('msg-alert') }}
        </div>
    @endif
    <!-- Main Content -->
    <div class="container-fluid">
        <div class="row">
            {{-- Left panel --}}
                <div class="col-sm-12 col-md-6">
                    @include('payments.final.sections._leftpanel')
                </div>
            {{-- Left panel end --}}

            {{-- Right panel --}}
                <div class="col-sm-12 col-md-6 no-margin">
                    @include(
                        'payments.final.sections._rightpanel', [
                            'content' => true,
                            'change' => false,
                            'addpayment' => false,
                            ]
                    )
                </div>
            {{-- Right panel end --}}
        </div>
    </div>
    <!-- Popup Modal -->
    <div class="modal fade" data-backdrop="static" id="warningModal" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content px-sm-5 py-sm-3">
            <div class="modal-body pt-3 px-4">
                <div class="row justify-content-center">
                <div class="col-12">
                    <p class="bold-words text-center mb-0" style="font-size: 40px;">{{trans('deposit.the_deposit')}}</p>
                    <p class="pb-2 text-center">{{trans('deposit.we_will_return')}}</p>
                    <p class="bold-words"><u>{{trans('deposit.important_info')}}</u></p>
                </div>
                </div>
                <div class="row">
                <div class="col-2 align-items-center d-flex justify-content-center">
                    <p class="emojis">📅</p>
                </div>
                <div class="col-10">
                    <p>{{trans('deposit.if_you_want_to_end')}}</p>
                </div>
                </div>
                <div class="row">
                <div class="col-2 align-items-center d-flex justify-content-center">
                    <p class="emojis">🛠</p>
                </div>
                <div class="col-10">
                    <p>{{trans('deposit.if_cause_damage')}}</p>
                </div>
                </div>
                <div class="row">
                <div class="col-2 align-items-center d-flex justify-content-center">
                    <p class="emojis">💶</p>
                </div>
                <div class="col-10">
                    <p>{{trans('deposit.returned_in_cop')}}</p>
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary">{{trans('deposit.accept')}}</button>
            </div>
            </div>
        </div>
    </div>
@endsection
