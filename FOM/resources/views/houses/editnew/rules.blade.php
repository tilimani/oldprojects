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

            <form method="POST" action="{{ URL::to('/houses/editnew/rules') }}" accept-charset="UTF-8" enctype="multipart/form-data">

                {{ csrf_field() }}

                <div class="row">

                    <p class="col-9 h1 mb-4 vico-color">Reglas</p>

                    <div class="col-3">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>

                </div>

                <div class="row">

                    @for ($i = 0; $i < count($rules) && $rule = $rules[$i]; $i++)

                        @if ($i > 7)
                            @break
                        @endif

                        <div class="col-12 col-lg-4 col-md-6 card vico-show-rule-card">

                            <div class="row">

                                <div class="col-3" style="text-align: right;">

                                    @if($rule->icon === 6)

                                        @if($rule->description == 0)
                                            <img style="height: 64px; width: 64px" src="../../../images/rules/independent.png" alt="independent" srcset="../../../images/rules/independent@2x.png 2x, ../../../images/rules/independent@3x.png 3x" />
                                        @else
                                            <img style="height: 64px; width: 64px" src="../../../images/rules/family.png" alt="family" srcset="../../../images/rules/family@2x.png 2x, ../../../images/rules/family@3x.png 3x" />
                                        @endif

                                     @else
                                        <img style="height: 64px; width: 64px"
                                            src="../../../images/rules/{!! $rule->icon_span !!}.png"
                                            alt="{!! $rule->icon_span !!}"
                                            srcset="../../../images/rules/{!! $rule->icon_span !!}@2x.png 2x, ../../../images/rules/{!! $rule->icon_span !!}@3x.png 3x"
                                        />
                                    @endif

                                </div>

                                <div class="col-9">

                                    <ul class="bullet-points-off align-middle ">

                                        <li class="text-uppercase font-weight-bold">

                                            @if($rule->icon === 1 )

                                                @if($rule->description == 0) No aplica
                                                    @elseif($rule->description == 14) 2 Semanas
                                                    @elseif($rule->description == 30) 1 mes
                                                    @elseif($rule->description == 360) No aplica
                                                    @else {{$rule->description}}
                                                @endif

                                            {{-- Deposito --}}
                                            @elseif($rule->icon === 2)
                                                1 Renta mensual

                                            {{-- Tiempo minimo de estancia  || Tiempo para salir --}}
                                            @elseif($rule->icon === 3 || $rule->icon === 8 )

                                                @if($rule->description == 30) 1 mes
                                                @elseif($rule->description == 14) 2 Semanas
                                                @elseif($rule->description == 60) 2 meses
                                                @elseif($rule->description == 90) 3 meses
                                                @elseif($rule->description == 120) 4 meses
                                                @elseif($rule->description == 150) 5 meses
                                                @elseif($rule->description == 180) 6 meses
                                                @elseif($rule->description == 210) 7 meses
                                                @elseif($rule->description == 240) 8 meses
                                                @elseif($rule->description == 270) 9 meses
                                                @elseif($rule->description == 300) 10 meses
                                                @elseif($rule->description == 330) 11 meses
                                                @elseif($rule->description == 360) 12 meses
                                                @else {{$rule->description}}
                                                @endif

                                            {{-- Aseo en zona sociales || Alimentación--}}
                                            @elseif($rule->icon === 4)

                                                @if($rule->description==0) No incluye @else Incluye @endif

                                            {{-- Servicios incluidos --}}
                                            @elseif($rule->icon === 5)

                                                @if($rules[8]->description == 1) Internet, @else @endif
                                                @if($rules[9]->description == 1) Gas, @else @endif
                                                @if($rules[10]->description == 1) Agua, @else @endif
                                                @if($rules[11]->description == 1) Electricidad @else @endif
                                                @if($rules[8]->description == 0 && $rules[9]->description == 0 && $rules[10]->description == 0 && $rules[11]->description == 0) No incluye @else @endif

                                            @elseif($rule->icon === 6 )
                                                    @if($rule->description==0) VICO independiente @else VICO de familia @endif
                                                {{-- Valor adicional por huesped --}}
                                            @elseif($rule->icon === 7)
                                                @if($rule->description == 0) Gratis @else {{$rule->description}} @endif
                                            @else
                                                {{$rule->description}}

                                            @endif

                                        </li>

                                        <li class="font-weight-light" style="word-wrap: break-word; line-height: 1.2">

                                            <small>

                                                @if($rule->icon === 6 )
                                                    @if($rule->description==0)Aquí exclusivamente viven estudiantes y jóvenes profesionales.
                                                    @else En esta VICO vive una familia colombiana, que comparte sus espacios con estudiantes y jóvenes profesionales.
                                                    @endif
                                                @else
                                                    {{$rule->name}}
                                                @endif

                                            </small>

                                        </li>

                                        <li>
                                            <label class="switch">
                                                <input type="checkbox">
                                                <span class="slider round"></span>
                                            </label>
                                        </li>
                                    </ul>

                                </div>

                            </div>

                        </div>

                    @endfor

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
