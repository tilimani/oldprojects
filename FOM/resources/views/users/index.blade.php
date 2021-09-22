@extends('layouts.app')
@section('title','Users')
{{--SECTION: META--}}
@section('meta')
<meta name="description" content="">
<meta name="robot" content="noindex, nofollow">
<meta property="og:title" content=""/>
<meta property="og:image" content="" />
<meta property="og:site_name" content="VICO"/>
<meta property="og:description" content=""/>

@endsection

@section('content')
	@section('styles')
	<style type="text/css">
		tr:nth-child(even){
			background-color: #f2f2f2;
		}

		tr:hover{
			background-color: #f5f5f5;
		}
		th, td {
		  padding: 15px;
		  text-align: left;
		  border-bottom: 1px solid #ddd;
		}
		th {
		  background-color: #ea960f;
		  color: white;
		}
	</style>
	@endsection
<div class="container">
	@if (Route::currentRouteName() == 'lazy_users')
		<h1>Usuarios a revisar</h1>
	@elseif (Route::currentRouteName() == 'lazy_managers')
		<h1>Managers a revisar</h1>
	@else
		<h1>Lista de usuarios</h1>
		<a href="{{route('lazy_users')}}" target="_blank"><button type="submit" class="btn btn-primary">Lazy Users</button></a>
		<a href="{{route('lazy_managers')}}" target="_blank"><button type="submit" class="btn btn-primary">Lazy Managers</button></a>
	@endif
	<form action="/users/search/1" method="GET" role="search">
	    {{ csrf_field() }}
	    <div class="input-group my-2">
	        <input type="text" class="form-control" name="name"
	            placeholder="Search for name, mail or phone"> <span class="input-group-btn">     
	        <button type="submit" class="btn btn-primary">Search</button>
	        </span>
	    </div>
	</form>
</div>
@if (\Session::has('success_change_role'))
<div class="alert-success text-center ">
	<h2>👌 Melo mi pez.</h2>
</div>
@endif
@if (\Session::has('success_change_password'))
<div class="alert-success text-center ">
	<h2>👌 Cambio exitoso, se le envió un correo de verificación al usuario.</h2>
</div>
@endif
<div style="overflow-x:auto;" class="container">
  <table class="w-100">
    <tr>
      <th>Name</th>
      <th>Correo</th>
      <th>Phone</th>
      <th>Role</th>
      <th>Edit</th>
	  <th>Bookings</th>
	  <th>Cambiar roll</th>
	  <th>Reset password</th>
    </tr>
	@foreach($users as $user)
	<tr>
		 <td>{{ $user->name  }} {{ $user->last_name }}</td>
		 <td>{{ $user->email }}</td>
		 <td>
		 	<a class=" text-success" href="https://wa.me/{{ substr($user->phone, 1)}}?text=Hola%20{{ $user->name  }}!"><span class="text-success icon-whatsapp-black"></span> {{$user->phone}}</a>
		 </td>
		 @if($user->isUser())
		 <td>User</td>
		 <td><a href="{{route('admin_user_edit', $user->id)}}">Edit User</a></td>
		 <td><a href="{{route('bookings.per.user', $user->id)}}">Ver bookings</a></td>
		 @else
		 <td>Manager</td>
		 <td><a href="{{route('admin_user_edit', $user->id)}}">Edit User</a></td>
		 <td><a href="{{route('bookings_admin', $user->id)}}">Ver bookings</a></td>
		 @endif
		 @if($user->role_id == 2)
			<form method="POST" action="{{route('user.update.role',[$user->id])}}" style="display: inline-block; padding-left: 28%;">
				{{csrf_field()}}
				<input type="hidden" name="user_id" value="{{$user->id}}">
				<input type="hidden" name="change_role" value="3">
				<td><button type="submit" class="btn btn-primary"><h5>to User</h5></button></td>
			</form>
		@elseif($user->role_id == 3)
			<form method="POST" action="{{route('user.update.role',[$user->id])}}" style="display: inline-block; padding-left: 28%;">
				{{csrf_field()}}
				<input type="hidden" name="user_id" value="{{$user->id}}">
				<input type="hidden" name="change_role" value="2">
				<td><button type="submit" class="btn btn-primary"><h6>to Manager</h6></button></td>
			</form>
		@endif
		<td>
			<form method="POST" action="{{route('reset.user.password',[$user->id])}}" style="display: inline-block;">
				{{csrf_field()}}
				<button type="submit" class="btn btn-primary"><h5>Reset</h5></button>
			</form>
		</td>
	</tr>	
	@endforeach
  </table>
{{ $users->links() }}

</div>

@endsection
@section('scripts')
@endsection




