@extends('layouts.app')

@section('styles')

    <style type="text/css">

        /* The switch - the box around the slider */
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
            vertical-align: middle;
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
        background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

    </style>

@endsection

@section('content')

<div class="container">

    <br>

    <!-- @if (Auth::user() && Auth::user()->email === 'friendsofmedellin@gmail.com' || true) -->

    <form method="POST" action="{{ URL::to('/houses/editnew/devices') }}" accept-charset="UTF-8" enctype="multipart/form-data">

        {{ csrf_field() }}

        <input type="hidden" name="house_id" value="{{ $house->id }}">

        <div class="row">

            <div class="col-6">
                <a href="/houses/editnew/{{ $house->id }}" class="btn btn-primary">
                    Volver
                </a>
            </div>

            <div class="col-6">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>

        </div>

        <div class="row">

            @foreach($devices as $device)

                <div class="col-lg-2 col-md-4 col-sm-6">

                    <span class="{{ $device->icon }} vico-show-equipos"></span>

                    <ul class="bullet-points-off">

                        <li class="text-uppercase font-weight-bold">

                            <label for="device_{{ $device->id }}">
                                {{ $device->name }}
                            </label>

                        </li>

                        <li>
                            <label class="switch">

                                @if($device->device_id !== null)
                                    <input name="device_{{ $device->id }}" type="checkbox" checked=checked>
                                @else
                                    <input name="device_{{ $device->id }}" type="checkbox">
                                @endif

                                <span class="slider round"></span>

                            </label>
                        </li>

                    </ul>

                </div>

            @endforeach

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
