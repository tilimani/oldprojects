@extends('layouts.app')

@section('content')
<div class="container m-4 p-4">
<form  method="post" action="/emails/unsubscribe/store">
    {{ csrf_field() }}
    <input type="hidden" name="encrypted" value="{{$encrypted}}">
    <label for="accept">Estas seguro de no querer recibir mas correos de nuestro equipo</label><br>
    <input type="checkbox" name="accept">
    <br>
    <button type="submit">Enviar</button>
</form>

<br>
<br>
<br>
</div>
@endsection