@extends('layouts.app')
@section('content')
@if (Auth::user() && Auth::user()->email === 'friendsofmedellin@gmail.com')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <br/>
    <br/>
    <br/>
    <br/>
    <h2>Crear Booking</h2>
    <form method="POST" action="{{ URL::to('/booking/store') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        @if($varsucces=='1')
        <h3>Creaccion exitosa</h3>
        @elseif($varsucces=='-1')
        <h3>Error en los datos </h3>
        @endif
         <div class="row">
            <div class="form-group col-sm-6">
                <select class="form-control" name="status" required>
                    @foreach($status as $state  => $description)
                        @if($state === 0)
                            <option value={{$state}} selected>{{$description}}</option>
                        @else
                            <option value={{$state}}>{{$description}}</option>
                        @endif
                    @endforeach
                </select>
                <label for="status">Estado Booking</label>
            </div>
            <div class="form-group col-sm-6">
                <select class="form-control" name="user" required="">
                    <option selected>-- seleccione --</option>
                    @foreach($users as $user)
                    <option value={{$user->id}}>{{$user->name}} {{$user->last_name}} - {{$user->id}}</option>
                    @endforeach
                </select>
                <label for="user">Nombre Usuario</label>
            </div>

        </div>
        <div class="row">
            <div class="form-group col-sm-6">
                <select class="form-control" name="room" id="room" required>
                    <option selected>-- seleccione --</option>
                    @foreach($rooms as $room)
                    <option value={{$room->id}}>{{$room->house->name}} - {{$room->number}} ({{$room->id}})</option>
                    @endforeach
                </select>
                <label for="room">Numero Habitacion</label>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6">
                <input type="date"  class="form-control" name="datefrom" id="datefrom" min="" required>
                <label for="datefrom">Desde</label>
            </div>
            <div class="form-group col-sm-6">
                <input type="date"  class="form-control" name="dateto" id="dateto" min="" required>
                <label for="dateto">Hasta</label>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6">
                <select class="form-control" name="option" required>
                    <option>-- seleccione</option>
                    <option value=1>Quiero reservar la habitacion online</option>
                    <option value=0>Quiero ver la casa personalmente</option>
                </select>
                <label for="option">Opcion</label>
            </div>
            <div class="form-group col-sm-6">
                <textarea class="form-control" style="resize: none;" name="message"></textarea required>
                <label for="message">Mensaje</label>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6">
                <textarea class="form-control" style="resize: none;" name="note"></textarea required>
                <label for="note">Notas</label>
            </div>
            <div class="form-group col-sm-6">
                <input type="date"  class="form-control" name="dateask" id="dateask" min="">
                <label for="dateask">Fecha Solicitud</label>
            </div>
        </div>
        <div class="text-center ">
            <button type="submit" class="btn btn-default btn-reserv">Crear booking</button>
        </div>
    </form>
@else
<p>You are not allowed to enter this page.</p>
@endif

@endsection

@section('scripts')
    <script type="text/javascript">
        var select = document.getElementById('house');
        var selectroom=document.getElementById('room');
        select.addEventListener('change',function(){
            $.ajax(
                {
                    url: '/houses/housedata/'+select.value+"/"+0,
                    type: "get",
                })
                .done(function(data)
                {
                    console.log(data);
                    var rooms=document.getElementById('room');
                    var ans="<option selected>-- seleccione --</option>";
                    for(var i=0;i<data[0].length;i++){
                        ans+="<option value="+data[0][i].id+">"+data[0][i].number+"</option>";
                    }
                    rooms.innerHTML=ans;
                })
                .fail(function(jqXHR, ajaxOptions, thrownError)
                {
                    //alert('server not responding...');
                });
        });
      /*  selectroom.addEventListener('change',function(){
            $.ajax(
                {
                    url: '/rooms/roomdata/'+selectroom.value,
                    type: "get",
                })
                .done(function(data)
                {
                //    console.log(data);
                /*    document.getElementById("dateto").min=data.available_from;
                    document.getElementById("datefrom").min=data.available_from;
                    document.getElementById("dateto").value=data.available_from;
                    document.getElementById("datefrom").value=data.available_from;
                })
                .fail(function(jqXHR, ajaxOptions, thrownError)
                {
                    //alert('server not responding...');
                });
        });*/
    </script>
@endsection