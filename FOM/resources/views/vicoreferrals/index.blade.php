@extends('layouts.app')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="uper">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div><br />
  @endif
  <table class="table table-striped">
    <thead>
        <tr>
          <td>ID</td>
          <td>code</td>
          <td>user_id</td>
          <td>type</td>
          <td>expiration_date</td>
          <td>amount_usd</td>
          <td>How many paid out</td>
          <td>used</td>
          <td>active (status 5)</td>
          <td>total success (status > 4)</td>
          <td colspan="2">Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach($vicoReferrals as $vicoReferral)
        <tr>
            <td>{{$vicoReferral->id}}</td>
            <td>{{$vicoReferral->code}}</td>
            <td>{{$vicoReferral->user_id}}</td>
            <td>{{$vicoReferral->type}}</td>
            <td>{{$vicoReferral->expiration_date}}</td>
            <td>{{$vicoReferral->amount_usd}}</td>
            <td>{{$vicoReferral->payout}}</td>
            <td>{{ $vicoReferral->referralsCountUsed->count() }}</td>
            <td>{{ $vicoReferral->referralsCountActive->count() }}</td>
            <td>{{ $vicoReferral->referralsCountSuccess->count() }}</td>
            <td><a href="{{ route('vicoReferrals.edit', $vicoReferral->id)}}" class="btn btn-primary">Edit</a></td>
            <td>
                <form action="{{ route('vicoReferrals.destroy', $vicoReferral->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
<div>
@endsection