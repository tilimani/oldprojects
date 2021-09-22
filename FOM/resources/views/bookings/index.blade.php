@extends('layouts.app')
@section('content')
{{-- @if (Auth::user()->email === 'friendsofmedellin@gmail.com') --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

@if (Auth::user()->email === 'friendsofmedellin@gmail.com')
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
<div class="container">
    <h2>Lista Bookings</h2>
    <form action="/booking/search/1" method="GET" role="search">
        {{ csrf_field() }}
        <div class="input-group my-2">
            <input type="text" class="form-control" name="name"
                placeholder="Search for id o user"> <span class="input-group-btn">     
            <button type="submit" class="btn btn-primary">Search</button>
            </span>
        </div>
    </form>
</div>

<div class="container">
    <a href="{{route('bookings.confirmed.index')}}">Confirmed Bookings (Status 5) </a>
</div>


<div style="overflow-x:auto;">
    <table class="table table-bordered w-100">
        <thead>
            <tr>
                <td>User</td>
                <td>Booking</td>
                <td>VICO</td>
                <td>Manager</td>
                <td>Date</td>
                <td>Hab#</td>
                <td style="width: ">Start</td>
                <td style="width: ">Exit</td>
                <td>Message</td>
                <td>Status</td>
                <td class="d-none">modo</td>
                <td>Notes</td>
                <td>WA Group</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <button class="btn success" type="submit" onclick=saveAllBookingsChanges()>Guardar todo</button>
            <form method="POST" action="{{ URL::to('/booking/update') }}" enctype="multipart/form-data" id="tempData">            
                {{ csrf_field() }}
            </form>
            @forelse( $bookings as $booking)

                <form method="POST" action="{{ URL::to('/booking/update') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <tr>
                        <input type="hidden" name="id_booking" value={{$booking->id}}>
                        <input type="hidden" name="user_id" value={{$booking->user_id}}>

                    {{-- User Name --}}
                        <td><a href="{{route('bookings.per.user', $booking->user_id)}}">{{$booking->name}} {{$booking->last_name}}</a></td>

                    {{-- Booking ID --}}
                        <td><a href="{{route('vico.manager.process', $booking->id)}}" target="_blank">{{$booking->id}}</a></td>

                    {{-- VICO --}}
                        <td>
                            <select class="form-control" name="house" onchange=loadrooms() id={{$booking->id}} required>
                                @foreach($houses as $house)
                                    @if($house->name == $booking->house_name)
                                        <option value="{{$house->id}}" selected>{{$house->name}}</option>
                                    @else
                                        <option value={{$house->id}}>{{$house->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                    
                    {{-- Manager Name --}}
                        <td><a href="{{route('bookings_admin', $booking->manager_id)}}">{{$booking->manager_info->name}}</a></td>
                    
                    {{-- Booking Created at --}}
                        <td>{{date("d.m.y", strtotime($booking->created_at))}}</td>

                    {{-- Room Number --}}
                        <td>
                            <select class="form-control" name="room" id="room{{$booking->id}}" required>
                                @foreach ($booking->rooms_data as $room)
                                    @if($room->number === $booking->number)
                                        <option value={{$room->id}} selected>{{$room->number}}</option>
                                    @else
                                        <option value={{$room->id}}>{{$room->number}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                    {{-- Starting Date --}}
                        <td>
                            <input type="date"  class="form-control" name="date_from" min="" value={{$booking->date_from}} required>
                        </td>

                    {{-- Ending Date --}}
                        <td>
                            <input type="date"  class="form-control" name="date_to" min="" value={{$booking->date_to}} required>
                        </td>

                    {{-- Booking Message --}}
                        <td>{{$booking->message}}</td>

                    {{-- Status --}}
                        <td>
                            <select class="form-control" name="status" required>
                                @foreach ( $status as $state => $value)
                                    @if($state == $booking->status)
                                        <option value="{{$state}}" selected>{{$value}} ({{$state}})</option>
                                    @else
                                        <option value="{{$state}}">{{$value}} ({{$state}})</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>

                    {{-- Booking Mode --}}
                        <td class="d-none">
                            <select class="form-control" name="mode" required>
                                    @if($booking->mode == 1)
                                        <option value="1" selected>online</option>
                                        <option value="0" >visita personal</option>
                                    @else
                                        <option value="1" >online</option>
                                        <option value="0" selected>visita personal</option>
                                    @endif
                            </select>
                        </td>

                    {{-- Booking Notes --}}
                        <td>
                            <textarea rows="4"  name="note" value="">{{$booking->note}}</textarea>
                        </td>

                    {{-- Create WA Group --}}
                        <td>
                            <a href="/whatsapp/creategroup/host/{{$booking->id}}">Create WA Group</a>
                        </td>

                        <td>
                            <button class="btn success" type="submit">Guardar</button>
                            <a class="btn btn-secondary" href="{{route('print.confirmation.user',$booking->id)}}">User Confirmation</a>
                            <a class="btn btn-secondary" href="{{route('print.confirmation.manager',$booking->id)}}">Manager Confirmation</a>
                            <a class="btn danger" href="/booking/delete/{{$booking->id}}">Borrar</a>
                        </td>
                    </tr>
                </form>
            @empty
                <tr>
                    <td>SIN RESULTADOS</td>
                </tr>
            @endforelse

        {!! $bookings->links() !!}
        </tbody>
    </table>
</div>

 @else
   <p>You are not allowed to enter this page.</p>
@endif

@endsection

@section('scripts')
    <script type="text/javascript">
        var src;
        function loadrooms(){
            src = window.event ? window.event.srcElement : ev.target
            $.ajax({
                url: '/houses/housedata/'+src.value+"/"+src.id,
                type: "get",
            })
            .done(function(data)
            {
                var rooms=document.getElementById('room'+data[1]);
                // console.log(rooms);
                var ans="";
                for(var j=0;j<data[0].length;j++){
                    if(data[0][j].choose==true){
                        ans+="<option value="+data[0][j].number+" selected>"+data[0][j].number+"</option>";
                    }
                    else{
                        ans+="<option value="+data[0][j].number+">"+data[0][j].number+"</option>";
                    }
                }
                rooms.innerHTML=ans;
            })
            .fail(function(jqXHR, ajaxOptions, thrownError)
            {
                //alert('server not responding...');
            });
        }

    function saveAllBookingsChanges(){
        var id_booking=document.getElementsByName("id_booking");
        var user_id=document.getElementsByName("user_id");
        var house=document.getElementsByName("house");
        var room=document.getElementsByName("room");
        var date_from=document.getElementsByName("date_from");
        var date_to=document.getElementsByName("date_to");
        var status=document.getElementsByName("status");
        var mode=document.getElementsByName("mode");
        var note=document.getElementsByName("note");
        var ans="";
        for(var i=0;i<id_booking.length;i++){
            ans+="<input type='hidden' name='id_booking[]' value='"+id_booking[i].value+"'>";
            ans+="<input type='hidden' name='user_id[]' value='"+user_id[i].value+"'>";
            ans+="<input type='hidden' name='house[]' value='"+house[i].value+"'>";
            ans+="<input type='hidden' name='room[]' value='"+room[i].value+"'>";
            ans+="<input type='hidden' name='date_from[]' value='"+date_from[i].value+"'>";
            ans+="<input type='hidden' name='date_to[]' value='"+date_to[i].value+"'>";
            ans+="<input type='hidden' name='status[]' value='"+status[i].value+"'>";
            ans+="<input type='hidden' name='mode[]' value='"+mode[i].value+"'>";
            ans+="<input type='hidden' name='note[]' value='"+note[i].value+"'>";
        }
        ans+="<button type='submit' id='saveAllData'> guardar</button>";
        document.getElementById("tempData").innerHTML+=ans;
        $("#saveAllData").click();
    }   
    </script>
@endsection