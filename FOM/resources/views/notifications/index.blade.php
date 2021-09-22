@extends('layouts.app')
@section('title', 'FOM Admin')
@section('content')

{{-- THIS SECTION IS SHOW TO THE VICO ADMIN --}}
@if (Auth::user() && Auth::user()->role_id === 1)
    <div class="lead text-center">
        Nuevas peticiones <a target="_blank" href="/notifications/daily">hoy</a>: {{ $creation_history_amount['creation_history_amount_day'] }},
        Nuevas peticiones de esta <a target="_blank" href="/notifications/weekly">semana</a>: {{ $creation_history_amount['creation_history_amount_week'] }},
        Nuevas peticiones de este <a target="_blank" href="/notifications/monthly">mes</a>: {{ $creation_history_amount['creation_history_amount_month'] }}
    </div>

    <table class="columns">
      <tr>
        <td><div id="bookings_amount" style="border: 0px solid #ccc"></div></td>
        <td><div id="sankey" style="border: 0px solid #ccc"></div></td>
      </tr>
    </table>

    <div class="jumbotron">
        <h1 class="display-4">Ultimas solicitudes.</h1>
        @foreach ($creation_history as $row)
            @if ($row -> booking_status == 1)
                <div class="lead">
                    {{ $row -> creation_date }} - <a target="_blank" href="/user/profile/{{ $row -> user_id }}"> {{ $row -> user_name }}</a>
                    solicitó la habitacion <a href="#">{{ $row -> room_number }}</a> de la casa <a target="_blank" href="/houses/{{ $row -> house_id }}" target="_blank">{{ $row -> house_name }}</a>
                    desde {{ $row -> booking_from }} hasta {{ $row -> booking_to }}. Booking id: <a target="_blank" href="/booking/show/{{ $row -> booking_id }}">{{ $row -> booking_id }}</a>
                </div>
            @endif
        @endforeach
    </div>

    <div class="jumbotron">
        <h1 class="display-4">Ultimos estados de bookings actualizados.</h1>
        @foreach ($update_history as $row)
            <div class="lead">
                {{ $row -> change_date }} - El booking id <a target="_blank "href="/booking/show/{{ $row -> booking_id }}">{{ $row -> booking_id }}</a> cambió de estado {{ $row -> old_status }}
                al estado {{ $row -> new_status }} en la habitacion número {{ $row -> room_number }}
                de la VICO <a target="_blank" href="/houses/{{ $row -> house_id }}">{{ $row -> house_name }}</a> (Id manager: <a target="_blank" href="/user/profile/{{ $row -> manager_id }}">{{ $row -> manager_id }}</a>).
            </div>
        @endforeach
    </div>

    <div class="jumbotron">
        <h1 class="display-4">Ultimos bookings aceptados.</h1>
        @foreach ($update_history as $row)
            @if ($row -> new_status == 50)
                <div class="lead">
                    {{ $row -> change_date }} - El booking <a target="_blank" href="/booking/show/{{ $row -> booking_id }}">{{ $row -> booking_id }}</a> de la habitación número {{ $row -> room_number }}
                    en la VICO <a target="_blank" href="/houses/{{ $row -> house_id }}">{{ $row -> house_name }}</a> ha concluido en estado 5
                    (Usuario: <a target="_blank" href="/user/profile/{{ $row -> user_id }}">{{ $row -> user_id }}</a>)
                    (Manager: <a target="_blank" href="/user/profile/{{ $row -> manager_id }}">{{ $row -> manager_id }}</a>).
                </div>
            @endif
        @endforeach
    </div>

    <div class="jumbotron">
        <h1 class="display-4">Ultimos usuarios creados.</h1>
        @foreach ($new_users as $row)

            <div class="lead">
                {{ $row -> creation_date }} - Se registró el usuario <a target="_blank" href="/user/profile/{{ $row -> user_id }}">{{ $row -> user_id }}</a> oriundo de {{ $row -> country }}.
            </div>

        @endforeach
    </div>

    <div class="jumbotron">
        <h1 class="display-4">Ultimos mensajes entre bookings.</h1>
        @foreach ($messages as $row)

            <div class="lead">
                {{ $row -> message_date }} - <a target="_blank" href="/user/profile/{{ $row -> sender_id }}">{{ $row -> sender_id }}</a> ha enviado un mensaje a
                <a target="_blank" href="/user/profile/{{ $row -> addressee_id }}">{{ $row -> addressee_id }}</a> en el booking
                <a target="_blank" href="/booking/show/{{ $row -> booking_id }}">{{ $row -> booking_id }}</a> (status booking en el momento: {{ $row -> booking_status_stamp }}).
            </div>

        @endforeach
    </div>

    <div class="jumbotron">
        <h1 class="display-4">Ultimas rooms creadas.</h1>
        @foreach ($new_rooms as $row)

            <div class="lead">
                {{ $row -> creation_date }} - El manager <a target="_blank" href="/user/profile/{{ $row -> manager_id }}">{{ $row -> manager_id }}</a>
                ha creado la habitacion número {{ $row -> room_number }} en la VICO <a target="_blank" href="/houses/{{ $row -> house_id }}">{{ $row -> house_name }}</a>
            </div>

        @endforeach
    </div>

    {{-- THIS SECTION IS SHOWN IF THE USER IS A MANAGER --}}
@elseif (Auth::user() && Auth::user()->role_id === 2)

    <div class="jumbotron">
        <h1 class="display-4">Ultimas acciones en tus solicitudes.</h1>
        @foreach ($information_newsfeed as $row)
            @if ($row['action'] == 0)
                <div class="lead">
                    {{ $row['date'] }} - Se ha creado la solicitud <a target="_blank "href="/booking/show/{{ $row['booking_id'] }}">{{ $row['booking_id']}}</a>
                </div>
            @endif
            @if ($row['action'] == 1)
                <div class="lead">
                    {{ $row['date'] }} - Has recibido un mensaje en la solicitud <a target="_blank "href="/booking/show/{{ $row['booking_id'] }}">{{ $row['booking_id'] }}</a>
                </div>
            @endif
            @if ($row['action'] == 2)
                <div class="lead">
                    {{ $row['date'] }} - la solicitud <a target="_blank "href="/booking/show/{{ $row['booking_id'] }}">{{ $row['booking_id'] }}</a> ha cambiado de estado.
                </div>
            @endif
        @endforeach
    </div>

    <div class="jumbotron">
        <h1 class="display-4">Ultimas solicitudes.</h1>
        @foreach ($creation_history as $row)
            @if ($row -> booking_status = 1)
                <div class="lead">
                    {{ $row -> creation_date }} - Recibiste una solicitud de<a target="_blank" href="/user/profile/{{ $row -> user_id }}"> {{ $row -> user_name }}</a>.
                    Solicitó la habitacion <a href="#">{{ $row -> room_number }}</a> de la casa <a target="_blank" href="/houses/{{ $row -> house_id }}" target="_blank">{{ $row -> house_name }}</a>
                    desde {{ $row -> booking_from }} hasta {{ $row -> booking_to }}. Información directa <a target="_blank" href="/booking/show/{{ $row -> booking_id }}">acá</a>.
                </div>
            @endif
        @endforeach
    </div>

    <div class="jumbotron">
        <h1 class="display-4">Ultimos estados de bookings actualizados.</h1>
        @foreach ($update_history as $row)
            <div class="lead">
                {{ $row -> change_date }} - Esta <a target="_blank "href="/booking/show/{{ $row -> booking_id }}">solicitud</a> cambió del estado {{ $row -> old_status }}
                al estado {{ $row -> new_status }} en la habitacion número {{ $row -> room_number }} de la VICO <a target="_blank" href="/houses/{{ $row -> house_id }}">{{ $row -> house_name }}</a>.
            </div>
        @endforeach
    </div>

    <div class="jumbotron">
        <h1 class="display-4">Ultimos mensajes.</h1>
        @foreach ($messages as $row)

            <div class="lead">
                @if ($row -> sender_id == Auth::user()->id)
                    {{ $row -> message_date }} - Enviaste un mensaje a <a href="#">{{ $row -> adreesee_name }}</a> en esta <a target="_blank" href="/booking/show/{{ $row -> booking_id }}">solicitud</a>.
                @elseif ($row -> adreesee_id == Auth::user()->id)
                    {{ $row -> message_date }} - Recibiste un mensaje de <a href="#">{{ $row -> sender_name }}</a> en esta <a target="_blank" href="/booking/show/{{ $row -> booking_id }}">solicitud</a>.
                @endif
            </div>

        @endforeach
    </div>

    {{-- THIS SECTION IS SHOWN IF USER IS A REGULAR ONE --}}
@elseif (Auth::user() && Auth::user()->role_id === 3)

    <div class="jumbotron">
        <h1 class="display-4">Ultimas solicitudes.</h1>
        @foreach ($creation_history as $row)
            @if ($row -> booking_status = 1)
                <div class="lead">
                    {{ $row -> creation_date }} - Realizaste una solicitud a la VICO<a target="_blank" href="/houses/{{ $row -> house_id }}"> {{ $row -> house_name }}</a>.
                    Solicitaste la habitacion <a href="#">{{ $row -> room_number }}</a> desde {{ $row -> booking_from }} hasta {{ $row -> booking_to }}. Información directa <a target="_blank" href="/booking/show/{{ $row -> booking_id }}">acá</a>.
                </div>
            @endif
        @endforeach
    </div>

    <div class="jumbotron">
        <h1 class="display-4">Ultimos estados de bookings actualizados.</h1>
        @foreach ($update_history as $row)
            <div class="lead">
                {{ $row -> change_date }} - Esta <a target="_blank "href="/booking/show/{{ $row -> booking_id }}">solicitud</a> cambió del estado {{ $row -> old_status }}
                al estado {{ $row -> new_status }} en la habitacion número {{ $row -> room_number }} de la VICO <a target="_blank" href="/houses/{{ $row -> house_id }}">{{ $row -> house_name }}</a>.
            </div>
        @endforeach
    </div>

    <div class="jumbotron">
        <h1 class="display-4">Ultimos mensajes.</h1>
        @foreach ($messages as $row)

            <div class="lead">
                @if ($row -> sender_id == Auth::user()->id)
                    {{ $row -> message_date }} - Enviaste un mensaje a <a href="#">{{ $row -> adreesee_name }}</a> en esta <a target="_blank" href="/booking/show/{{ $row -> booking_id }}">solicitud</a>.
                @elseif ($row -> adreesee_id == Auth::user()->id)
                    {{ $row -> message_date }} - Recibiste un mensaje a <a href="#">{{ $row -> sender_name }}</a> en esta <a target="_blank" href="/booking/show/{{ $row -> booking_id }}">solicitud</a>.
                @endif
            </div>

        @endforeach
    </div>

@else
<p>You are not allowed to enter this page.</p>
@endif

@endsection

@section('scripts')
@if (Auth::user() && Auth::user()->role_id === 1)
    <script type="text/javascript">

        google.charts.setOnLoadCallback(drawBookingsAmount);
        google.charts.setOnLoadCallback(drawChart);

        function drawBookingsAmount() {

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Topping');
            data.addColumn('number', 'Slices');
            data.addRows([
                ['Espera de aceptacion', {{ $bookings_amount[1] }}],
                ['Espera de confirmacion estudiante', {{ $bookings_amount[2] }}],
                ['Espera de reserva dueño', {{ $bookings_amount[3] }}],
                ['Espera de pago al propietario', {{ $bookings_amount[4] }}],
                ['Espera confirmacion de screenshot', {{ $bookings_amount[50] }}],
                ['Estudiante en vico', {{ $bookings_amount[5] }}]
            ]);

            var options = {title:'Estado actual de los bookings',
                           width:600,
                           height:400,
                           slices: {  0: {offset: 0.2},
                                    5: {offset: 0.3},},
                            is3D: true,
                            };

            var chart = new google.visualization.PieChart(document.getElementById('bookings_amount'));
            chart.draw(data, options);
        }


        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'From');
            data.addColumn('string', 'To');
            data.addColumn('number', 'Weight');
            data.addRows([
             [ 'Estado 1', 'Estado 2', {{ $bookings_transition_amount[1] }} ],
             [ 'Estado 2', 'Estado 3', {{ $bookings_transition_amount[2] }} ],
             [ 'Estado 3', 'Estado 4', {{ $bookings_transition_amount[3] }} ],
             [ 'Estado 4', 'Estado Screenshot', {{ $bookings_transition_amount[4] }} ],
             [ 'Estado Screenshot', 'Estado 5', {{ $bookings_transition_amount[50] }} ]
            ]);

            var optionsSankey = {
             width: 600,
            };

            var chart = new google.visualization.Sankey(document.getElementById('sankey'));
            chart.draw(data, optionsSankey);
        }

    </script>
@endif
@endsection
