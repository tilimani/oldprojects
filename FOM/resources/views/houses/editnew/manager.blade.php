@extends('layouts.app')

@section('content')

    <div class="container">

        <br>

        <!-- @if (Auth::user() && Auth::user()->email === 'friendsofmedellin@gmail.com' || true) -->

        <form accept-charset="UTF-8" enctype="multipart/form-data" id="postManagerDescription">

            {{ csrf_field() }}

            <div class="row">

                <div class="col-lg-1 col-6">

                    <a  onclick="window.close();"
                        data-scroll class="btn btn-primary" role="button">
                        Volver
                    </a>

                </div>

                <div class="col-3">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>

            </div>

            <hr>

            <input type="hidden" name="house_id" value="{{ $house_id }}">

            <input type="hidden" name="manager_id" value="{{ $manager->id }}">

            <div class="form-group">

                <label for="manager_name">Nombre</label>
                <input type="text" class="form-control" name="manager_name" placeholder="Escriba un nombre" value="{{ $manager->name }}">

            </div>

            <div class="form-group">

                <label for="manager_description">Descripción</label>
                <textarea class="form-control" id="manager_description" name="manager_description" rows="8" cols="80">{{ $manager->description }}</textarea>

            </div>

        </form>

        <!-- @else
            <p>You are not allowed to enter this page.</p>
        @endif -->

    </div>

@endsection

@section('scripts')

    <script>


    </script>

@endsection
