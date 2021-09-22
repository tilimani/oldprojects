<div class="row px-md-5 px-2 pb-4 {{__(($dont_display) ? 'd-none unhide-me': '')}}">
    <div class="col">
        <div class="row">
            <div class="col-auto pr-0">
                <img src="{{asset('images/accepted.png')}}" class="checkmark">
            </div>
            <div class="col pl-1">
                <p class="m-0 text-20">{{$referralUses[$i]->user->name}}</p>
                <p class="small-grey-text p-0">$10.00</p>
            </div>
        </div>
    </div>
    <div class="col-auto text-20 text-right">
        {{--how do we know if its been paid out?--}}
        @if($referralUses[$i]->paid == 1)
            <p class="m-0 text-capitalize">{{trans('referrals.paid')}} // {{$referralUses[$i]->payment_method}}</p>
            <p class="small-grey-text p-0 m-0 text-capitalize">{{$referralUses[$i]->updated_at->toFormattedDateString()}}</p>
        @else 
            <p class="m-0">{{trans('referrals.pending')}}</p>
            <p class="small-grey-text p-0">{{$referralUses[$i]->updated_at->toFormattedDateString()}}</p>
        @endif
    </div>
</div>
