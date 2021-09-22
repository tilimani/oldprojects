@extends('customers.index')
@section('title', 'FOM')
@section('contentReview')
<form method="POST" action="" enctype="multipart/form-data">
    {{csrf_field()}}
    <div class="container main-container">
        <div class="row">
            <h3 class="text-center rev-tittle">Thanks for your review!</h3>
            <h2 class="text-center">Would you like to give us some feedback or let us know from FOM?</h2>
        </div>
        <div class="row">
            <textarea name="comment">
            </textarea>
        </div>
        <div class="row text-center">
             {{-- SUBMIT BUTTON --}}
            <a href="{{'/myvico/'.$user[0]->id}}" ><button class="submit"><span>Submit</span></button></a>
        </div>
    </div>
</form>
@endsection
