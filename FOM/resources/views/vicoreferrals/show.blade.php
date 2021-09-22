@extends('layouts.app')

@section('content')
<div class="uper">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div><br />
  @endif
  <p>{{$vicoreferral->id}}</p>
  <p>{{$vicoreferral->code}}</p>
  <p>{{$vicoreferral->user_id}}</p>
  <p>{{$vicoreferral->type}}</p>
  <p>{{$vicoreferral->expiration_date}}</p>
  <p><a href="{{ route('vicoReferrals.edit', $vicoreferral->id)}}" class="btn btn-primary">Edit</a></p>
  <p>
      <form action="{{ route('vicoReferrals.destroy', $vicoreferral->id)}}" method="post">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" type="submit">{{trans('general.delete')}}</button>
      </form>
  </p>
<div>
@endsection