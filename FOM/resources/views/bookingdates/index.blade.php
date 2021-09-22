@extends('layouts.app')

@section('title', 'Booking Dates')

@section('content')
<div class="container">
    <h2>Index de fechas por bookings</h2>
    <p>Tabla con los datos de la tabla BookingDate: </p>
    <!-- Button to Open the Modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">
        Crear BookingDate
    </button>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>UserDate</th>
        <th>AdminDate</th>
        <th>VicoDate</th>
        <th>Validate</th>
        <th>BookingID</th>
        <th>Edit</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($bookingDates as $bookingDate)
        <tr>
            <form action="{{route('bookingdate.update',$bookingDate->id)}}" method="POST">
                @csrf
                @method('PUT')
                <td>
                    <input type="date"  class="form-control" name="user_date" min="" value={{$bookingDate->user_date}} required>
                    <label for="user_date">Fecha Usuario</label>
                    {{$bookingDate->user_date}}
                </td>
                <td>
                    <input type="date"  class="form-control" name="manager_date" min="" value={{$bookingDate->manager_date}} required>
                    <label for="manager_date">Fecha Manager</label>
                    {{$bookingDate->manager_date}}
                </td>
                <td>
                    <input type="date"  class="form-control" name="vico_date" min="" value={{$bookingDate->vico_date}} required>
                    <label for="vico_date">Fecha VICO</label>
                    {{$bookingDate->vico_date}}
                </td>
                <td>
                    <select class="form-control" name="validation" required>
                            @if($bookingDate->validation == 1)
                                <option value="1" selected>valido</option>
                                <option value="0" >no validado</option>
                            @else
                                <option value="1" >valido</option>
                                <option value="0" selected>no validado</option>
                            @endif
                    </select>
                    {{$bookingDate->validation}}
                </td>
                <td>{{$bookingDate->bookings_id}}</td>
                <td>
                    <button class="btn btn-primary" type="submit" style="margin: 10px;">Editar</button>
            </form>
            <form action="{{route('bookingdate.destroy',$bookingDate->id)}}" method="POST">
                {{ csrf_field() }}
                @method('DELETE')
                <button class="btn btn-danger" type="submit" style="margin: 10px;" >Eliminar</button>
            </form>
                </td>
        </tr>
      @empty
        <tr>
            <td>sin datos</td>
            <td>sin datos</td>
            <td>sin datos</td>
            <td>sin datos</td>
            <td>sin datos</td>
            <td></td>
        </tr>
      @endforelse

    </tbody>
    <!-- The Modal -->
    <div class="modal" id="createModal">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Crear BookingDate</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form action="{{route('bookingdate.store')}}" method="post">
                    @csrf
                    <div class="form-group">
                      <label for="user_date">fecha del usuario</label>
                      <input type="date"
                        class="form-control" name="user_date" id="user_date" aria-describedby="user_date" placeholder="08/11/2012" required>
                      <small id="user_date" class="form-text text-muted">Fecha del usuario</small>
                    </div>

                    <div class="form-group">
                      <label for="manager_date">Fecha del administrador</label>
                      <input type="date"
                        class="form-control" name="manager_date" id="manager_date" aria-describedby="manager_date" placeholder="08/11/2012" required>
                      <small id="manager_date" class="form-text text-muted">Fecha del administrador</small>
                    </div>

                    <div class="form-group">
                      <label for="vico_date">Fecha de vico</label>
                      <input type="date"
                        class="form-control" name="vico_date" id="vico_date" aria-describedby="vico_date" placeholder="08/11/2012" required>
                      <small id="vico_date" class="form-text text-muted">Fecha de VICO</small>
                    </div>

                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" name="validation" id="validation" value="true" >
                        Fecha validada
                      </label>
                    </div>

                    <br>

                    <div class="form-group">
                      <label for="booking_id">Booking_id</label>
                      <input type="number"
                        class="form-control" name="booking_id" id="booking_id" aria-describedby="booking_id" placeholder="id" required>
                      <small id="booking_id" class="form-text text-muted">Booking id</small>
                    </div>

                    <button type="submit" class="btn btn-primary">Crear</button>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

          </div>
        </div>
      </div>

    </div>
  </table>
</div>

@endsection
