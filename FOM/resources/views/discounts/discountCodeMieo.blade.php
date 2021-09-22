@extends('layouts.app')
@section('content')
<style>
* {
  box-sizing: border-box;
}

#myInput, #myInputMonth {
  background-image: url('/css/searchicon.png');
  background-position: 10px 12px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}

#myUL, #myULMonth {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

#myUL li a, #myULMonth li a {
  border: 1px solid #ddd;
  margin-top: -1px; /* Prevent double borders */
  background-color: #f6f6f6;
  padding: 12px;
  text-decoration: none;
  font-size: 18px;
  color: black;
  display: block
}

#myUL li a:hover:not(.header), #myULMonth li a:hover:not(.header) {
  background-color: #eee;
}
</style>

<script>
  //Search today clients
function myFunction() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

//Seach next month clients
// function myFunctionMonth() {
//     var input, filter, ul, li, a, i, txtValue;
//     input = document.getElementById("myInputMonth");
//     filter = input.value.toUpperCase();
//     ul = document.getElementById("myULMonth");
//     li = ul.getElementsByTagName("li");
//     for (i = 0; i < li.length; i++) {
//         a = li[i].getElementsByTagName("a")[0];
//         txtValue = a.textContent || a.innerText;
//         if (txtValue.toUpperCase().indexOf(filter) > -1) {
//             li[i].style.display = "";
//         } else {
//             li[i].style.display = "none";
//         }
//     }
// }
</script>
@if (Auth::user()->email === 'friendsofmedellin@gmail.com' || Auth::user()->email === 'oscar.bertron.simpson@gmail.com' )

<div class="container mt-4">
  <div class="col-12">
    <h1>Lista de descuentos para MIEO</h1>
  </div>
  <div class="row">
    <div class="col-md-6 mx-auto">
      <h2>Clientes activos hoy</h2>
      <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for codes.." title="Type in a name">
      <ul id="myUL">
        @foreach($usersActiveNow as $user)
        <li><a href="#" class="text-uppercase list-group-item list-group-item-action">{{str_limit($user->name, $limit = 3, $end='')}}{{str_limit($user->last_name, $limit = 3, $end='')}}{{str_limit($user->id, $limit = 2, $end='')}}{{substr($user->created_at, -2)}}
        </a></li>
        @endforeach
      </ul>
    </div>
    <div class="col-md-6 mx-auto">
      {{-- <h2>Clientes dentro de 4 semanas</h2>
      <input type="text" id="myInputMonth" onkeyup="myFunctionMonth()" placeholder="Search for codes.." title="Type in a name">
      <ul id="myULMonth">
        @foreach($usersActiveMonth as $user)
        <li><a href="#" class="text-uppercase list-group-item list-group-item-action">{{str_limit($user->name, $limit = 3, $end='')}}{{str_limit($user->last_name, $limit = 3, $end='')}}{{str_limit($user->id, $limit = 2, $end='')}}{{substr($user->created_at, -2)}}
        </a></li>
        @endforeach
      </ul> --}}
    </div>
  </div>
</div>

@else
<p>No tienes derechos para acceder esa página.</p>
@endif

@endsection

