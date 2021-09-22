@extends('customers.index')
@section('title', 'VICO')
@section('contentReview')
<div class="container main-container">
    
    <div class="row">
        <div class="col-md-6 image-holder">
            <figure class="image-holder">
                <img src="{{'http://fom.imgix.net/'.$image_room[0]->image}}" class="img-responsive" />           
            </figure>
        </div>

        <div class="col-md-3 details">
            <p>{{$house[0]->name}}</p>
            <p>{{$room[0]->number}}</p>
            <p>{{$booking[0]->date_from}} - {{$booking[0]->date_to}}</p>
        </div>    
    </div>
    <div class="row text-center">
        <a href="{{'/review/general/'.$user->id}}" class="btn btn-primary">{{trans('general.write_review')}}</a>
        <a href="{{'/review/fom/'.$user->id}}" class="btn btn-primary">{{trans('general.send_message')}}</a>
    </div>
</div>
@endsection