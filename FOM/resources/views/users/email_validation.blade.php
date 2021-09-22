@extends('layouts.app')

@section('content')
<div class="container m-4 p-4">

<p>{{trans('general.still_unvalidated')}}</p>

<br>
<form  method="post" action="/emails/validation/send">
    {{ csrf_field() }}
    <label for="accept">{{trans('general.if_you_want_resend')}}</label><br>
    <input type="email" name="email">
    <br>
    <button type="submit">{{trans('general.send')}}</button>
</form>

<br>
<br>
<br>

<p>{{trans('general.in_case_of_difficulties')}}</p>
</div>
@endsection