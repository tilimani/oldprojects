@extends('layouts.app')
@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <div class="card-header">
    Add VICO Referral
  </div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif



      <form method="post" action="{{ route('vicoReferrals.store') }}">
          <div class="form-group">
              @csrf
              <label for="name">Code: (6-15 digits)</label>
              <input type="text" class="form-control" name="code"/ required="">
          </div>
          <div class="form-group">
              <label for="price">User ID:</label>
              <input type="text" class="form-control" name="user_id"/ required="">
          </div>
          <div class="form-group">
              <label for="quantity">Type:</label>
              <input type="text" class="form-control" name="type"/ required="" value="manual">
          </div>          
          <div class="form-group">
              <label for="quantity">Expiration Date:</label>
              <input class="form-control h-100" style="background-color: white" id="datepickersearch" name="expiration_date" placeholder="Fechas de Expiration"
                autocomplete="off" readonly required="">
          </div>         
          <div class="form-group">
              <label for="amount_usd">Discount Amount for users in USD:</label>
              <input type="text" class="form-control" name="amount_usd"/ required="" value="10">
          </div>         
          <div class="form-group">
              <label for="payout">payout:</label>
              <input type="text" class="form-control" name="payout"/ required="">
          </div>
          <button type="submit" class="btn btn-primary">Add</button>
      </form>
  </div>
</div>
@endsection