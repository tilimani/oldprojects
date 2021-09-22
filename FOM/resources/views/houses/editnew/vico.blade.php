@extends('layouts.app')

@section('content')

    <form class="d-none" action="{{ route('post_house_description')}}" method="post" id="postHouseDescription">
        <input type="hidden" name="house_id" value="{{ $house->id }}">
        <input type="hidden" name="description_house">
        <input type="hidden" name="description_zone">
    </form>
    <div class="container">

        <br>

        <!-- @if (Auth::user() && Auth::user()->email === 'friendsofmedellin@gmail.com' || true) -->

        <form method="POST" action="{{ URL::to('/houses/editnew/vico') }}" accept-charset="UTF-8" enctype="multipart/form-data">

            {{ csrf_field() }}

            <input type="hidden" name="house_id" value="{{ $house->id }}">

            <div class="row">

                <div class="col-lg-1 col-6">

                    <a  href="/houses/editnew/{{ $house->id }}"
                        data-scroll class="btn btn-primary" role="button">
                        Volver
                    </a>

                </div>

                <div class="col-3">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>

            </div>

            <hr>

            <div class="form-group">

                <label for="descriptionHelp">Descripción de la VICO</label>

                <textarea class="form-control" name="description_house" aria-describedby="description_house_Help" rows="8" cols="80">
                    {{ $house->description_house }}
                </textarea>

                <small id="description_house_Help" class="form-text text-muted">Ingrese el texto que describe la VICO</small>

            </div>

            <div class="form-group">

                <label for="descriptionHelp">Descripción del barrio</label>

                <textarea class="form-control" name="description_zone" aria-describedby="description_zone_Help" rows="8" cols="80">
                    {{ $house->description_zone }}
                </textarea>

                <small id="description_zone_Help" class="form-text text-muted">Ingrese el texto que describe el barrio</small>

            </div>

        </form>

        <!-- @else
            <p>You are not allowed to enter this page.</p>
        @endif -->

    </div>

@endsection
