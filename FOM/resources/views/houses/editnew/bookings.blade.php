@extends('layouts.app')

@section('content')

<h1>Formulario para la edición de los bookings de la VICO</h1>

    <!-- @if (Auth::user() && Auth::user()->email === 'friendsofmedellin@gmail.com' || true) -->

        <form method="POST" action="{{ URL::to('/houses/editnew/images') }}" enctype="multipart/form-data">

            {{ csrf_field() }}


        </form>

    <!-- @else
        <p>You are not allowed to enter this page.</p>
    @endif -->

@endsection

@section('scripts')

    <script>


    </script>

@endsection
