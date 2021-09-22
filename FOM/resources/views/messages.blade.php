@extends('layouts.app')

@section('content')
    <form class="form" action="{{ route('post_message') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="messageFlag">Destination: 1 for user 0 for manager</label>
            <input name="destination" type="number" class="form-control" id="messageFlag" placeholder="1" value=1>
        </div>
        <div class="form-group">
            <label for="messageStatus">Status</label>
            <input name="status" type="number" class="form-control" id="messageStatus" placeholder="5" value="5">
        </div>
        <div class="form-group">
            <label for="messageBookingid">Booking ID</label>
            <input name="bookings_id" type="number" class="form-control" id="messageBookingid" placeholder="822" value="822">
        </div>
        <div class="form-group">
            <label for="messageRead">Read</label>
            <input name="read" ype="number" class="form-control" id="messageRead" placeholder="0" value="0">
        </div>
        <div class="form-group">
            <label for="messageText">Example textarea</label>
            <textarea class="form-control" id="messageText" rows="3" name="message" placeholder="Escribe tu mensaje..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        {{-- <input name="destination" type="number" class="form-control" id="messageFlag" placeholder="1" value=1>
        <input name="status" type="number" class="form-control" id="messageStatus" placeholder="5" value="5">
        <input name="bookings_id" type="number" class="form-control" id="messageBookingid" placeholder="822" value="822">
        <input name="read" ype="number" class="form-control" id="messageRead" placeholder="0" value="0">
        <textarea class="form-control" id="messageText" rows="3" name="message" placeholder="Escribe tu mensaje..."></textarea> --}}
    </form>
@stop