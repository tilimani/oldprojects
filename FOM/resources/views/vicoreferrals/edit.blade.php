@extends('layouts.app')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <div class="card-header">
    Edit vicoreferral
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
       <form method="post" action="{{ route('vicoReferrals.update', $vicoreferral->id) }}">
        @method('PATCH')
        @csrf
        <div class="form-group">
          <label for="name">Code:</label>
          <input type="text" class="form-control" name="code" value={{ $vicoreferral->code }} />
        </div>
        <div class="form-group">
          <label for="price">{{ $vicoreferral->user->name}} {{ $vicoreferral->user->last_name}} created this code, the user_id is:</label>
          <input type="text" class="form-control" name="user_id" value={{ $vicoreferral->user_id}} />
        </div>
        <div class="form-group">
          <label for="quantity">type:</label>
          <input type="text" class="form-control" name="type" placeholder="{{ $vicoreferral->type }}" />
        </div>  
        <div class="form-group">
          <label for="amount_usd">amount_usd:</label>
          <input type="text" class="form-control" name="amount_usd" placeholder={{ $vicoreferral->amount_usd }} />
        </div>  
        <div class="form-group">
          <label for="payout">This code was used {{ $vicoreferral->referralsCountSuccess->count() }} times, how many we paid out of these to the user:</label>
          <input type="text" class="form-control" name="payout" placeholder={{ $vicoreferral->payout }} />
        </div>        

        <div class="form-group">
          <label for="quantity">expiration_date:</label>
          <input type="text" class="form-control" name="expiration_date" placeholder={{ $vicoreferral->expiration_date }} />
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
      </form>
  </div>
</div>
@endsection