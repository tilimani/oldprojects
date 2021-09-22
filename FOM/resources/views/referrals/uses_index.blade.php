@extends('layouts.app')
@section('content')
{{-- @if (Auth::user()->email === 'friendsofmedellin@gmail.com') --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

@if (Auth::user()->email === 'friendsofmedellin@gmail.com')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <br/>
    <br/>
    <br/>
    <br/>

<div class="container" style="overflow-x:auto;">
        <div class="nav-admin">
            <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active " 
                    id="noRespondidas-tab" data-toggle="tab" href="#tabNoRespondidas" role="tab" aria-controls="noRespondidas"
                        aria-selected="true">No respondidas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="respondidas-tab" data-toggle="tab" href="#tabRespondidas" role="tab" aria-controls="respondidas" aria-selected="false">
                        Respondidas
                    </a>
                </li>
            </ul>

        </div>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade" id="tabRespondidas" role="tabpanel" aria-labelledby="Respondidas-tab">
                <br>
                <br>
                <table class="table table-bordered w-100">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Created_at</td>
                                <td>Updated_at</td>
                                <td>Paid</td>
                                <td>Payment_method</td>
                                <td>Vico_referral_id</td>
                                <td>User_id</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse( $referrals_uses_paid as $use)
            
                            <form method="POST" action="{{ URL::to('/usesreferrals/update') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <tr>
                                    <input type="hidden" name="use_id" value={{$use->id}}>
                                    <input type="hidden" name="user_id" value={{$use->user_id}}>
                                    <input type="hidden" name="created_at" value={{$use->created_at}}>
                                    <input type="hidden" name="updated_at" value={{$use->updated_at}}>
                                    <input type="hidden" name="vico_referral_id" value={{$use->vico_referral_id}}>
            
                                {{-- use ID --}}
                                <td>{{$use->id}}</td>
            
                                {{-- CREATED AT --}}
                                <td>{{$use->created_at}}</td>
            
                                {{-- UPDATED AT --}}
                                <td>{{$use->updated_at}}</td>
            
                                {{-- PAID --}}
                                <td>
                                    <select class="form-control" name="paid" required>
                                        @if($use->paid == 0)
                                            <option value="0" selected>No pagado</option>
                                            <option value="1" >Pagado</option>
                                        @else
                                            <option value="0">No pagado</option>
                                            <option value="1" selected>Pagado</option>
                                        @endif
                                    </select>
                                </td>
            
                                {{-- PAYMENT METHOD --}}
                                <td>
                                    <select class="form-control" name="payment_method" required>
                                        @foreach ( $pay_options as $option)
                                            @if($option == $use->payment_method)
                                                <option value="{{$option}}" selected>{{$option}}</option>
                                            @else
                                                <option value="{{$option}}">{{$option}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </td>
            
                                {{-- VICO REFERRAL ID --}}
                                <td>{{$use->vico_referral_id}}</td>
            
                                {{-- USER ID --}}
                                    <td>{{$use->user_id}}</td>
                                {{-- ACTIONS --}}
                                <td>
                                    <button class="btn btn-primary" type="submit">Guardar Cambios</button>
                                </td>
                            </form>
                        @empty
                            <tr>
                                <td>SIN RESULTADOS</td>
                            </tr>
                        @endforelse
            
                    {!! $referrals_uses_paid->links() !!}
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade show active" id="tabNoRespondidas" role="tabpanel" aria-labelledby="noRespondidas-tab">
                <br/>
                <br/>
                <table class="table table-bordered w-100">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Created_at</td>
                            <td>Updated_at</td>
                            <td>Paid</td>
                            <td>Payment_method</td>
                            <td>Vico_referral_id</td>
                            <td>User_id</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse( $referrals_uses_no_paid as $use)
        
                        <form method="POST" action="{{ URL::to('/usesreferrals/update') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <tr>
                                <input type="hidden" name="use_id" value={{$use->id}}>
                                <input type="hidden" name="user_id" value={{$use->user_id}}>
                                <input type="hidden" name="created_at" value={{$use->created_at}}>
                                <input type="hidden" name="updated_at" value={{$use->updated_at}}>
                                <input type="hidden" name="vico_referral_id" value={{$use->vico_referral_id}}>
        
                            {{-- use ID --}}
                            <td>{{$use->id}}</td>
        
                            {{-- CREATED AT --}}
                            <td>{{$use->created_at}}</td>
        
                            {{-- UPDATED AT --}}
                            <td>{{$use->updated_at}}</td>
        
                            {{-- PAID --}}
                            <td>
                                <select class="form-control" name="paid" required>
                                    @if($use->paid == 0)
                                        <option value="0" selected>No pagado</option>
                                        <option value="1" >Pagado</option>
                                    @else
                                        <option value="0">No pagado</option>
                                        <option value="1" selected>Pagado</option>
                                    @endif
                                </select>
                            </td>
        
                            {{-- PAYMENT METHOD --}}
                            <td>
                                <select class="form-control" name="payment_method" required>
                                    @foreach ( $pay_options as $option)
                                        @if($option == $use->payment_method)
                                            <option value="{{$option}}" selected>{{$option}}</option>
                                        @else
                                            <option value="{{$option}}">{{$option}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
        
                            {{-- VICO REFERRAL ID --}}
                            <td>{{$use->vico_referral_id}}</td>
        
                            {{-- USER ID --}}
                                <td>{{$use->user_id}}</td>
                            {{-- ACTIONS --}}
                            <td>
                                <button class="btn btn-primary" type="submit">Guardar Cambios</button>
                            </td>
                        </form>
                    @empty
                        <tr>
                            <td>SIN RESULTADOS</td>
                        </tr>
                    @endforelse            
                    {!! $referrals_uses_no_paid->links() !!}
                    </tbody>
                </table>
            </div>

        </div>
        
</div>

 @else
   <p>You are not allowed to enter this page.</p>
@endif

@endsection
