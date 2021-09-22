
@extends('layouts.app')
@section('title', 'Crea habitaciones')
@section('content')

@if (Auth::user() && (Auth::user()->role_id === 1 || Auth::user()->role_id === 2))
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
    </div>
  @endif
  {{-- MAIN ROW --}}
  <div class="create">
      {{-- COL CREATE ROOMS --}}
      <div class="create-vico col-sm-12 mb-5">
        {{-- NAVBAR --}}
        <nav class="navbar navCreate row">
          <div>
            <h1 class="navbar-text">
             Agrega habitaciones
            </h1>
          </div>
        </nav>
        {{-- END NAVBAR --}}

        {{-- CREATE ROOMS --}}
        <form action="" id="formCreateAndUpdateRooms" style="padding-bottom: 20px">
          @include('rooms.create_form')
        </form>
        {{-- END CREATE ROOMS --}}

        <footer class="footerCreate m-lg-0">
          <p class="m-0 text-center font-weight-bold">Habitaciones:</p>
          <div class="controlPagination left d-lg-none"><p>&laquo;</p></div>
          <div class="controlPagination right d-lg-none"><p>&raquo;</p></div>
          <ul class="page-container-room mb-0 justify-content-md-center position-md-static">
              <li class="page-item-room currentHab" item-number='1'><p>1</p></li>
            @for($i = 2; $i <= $count; $i++)
              <li class="page-item-room" item-number={{$i}}><p>{{$i}}</p></li>
            @endfor
          </ul>
        </footer>

      </div >
      {{-- END COL CREATE ROOMS --}}
  </div>
  {{-- END MAIN ROW --}}

  <a href="/houses/finalization/" style="d-none" id="finish"></a>
@else
<p>You are not allowed to enter this page.</p>
@endif
@endsection

@section('scripts')

<script type="text/javascript">

  let wrap,container,houseId,nickname,priceRoom,priceForTwo,description,unavailable,country,nextRoom,nextRoomUpdate,bookeable,roomDescField,unavailableCheck,numberInputs,booking_id,user_id,last_item,current_item,roomNumber;
  let hiddenRoom = false;
  let counterSlides = 1;
  let stepSlide = 1;
  let steps = 5;

  // let isBookeable = document.querySelector('#isBookeable');

  window.onload = () => {
    init();
    document.querySelector('.left').addEventListener('click',( e ) => { slideTabs(2,1) });
    document.querySelector('.right').addEventListener('click',( e ) => { slideTabs(1,1) });
  }


  function init(){
    localStorage.clear();
      history.pushState(null, null, location.href);
        window.onpopstate = function () {
        history.go(1);
      };

      $('#couplePrice').hide();
      $('.unavailableRoom').hide();
      $('.nicknameDesc').hide();
      $('.roomDesc').hide();
      varDeclaration();
      events();
  }

  function varDeclaration(){
    wrap = document.querySelector('.footerCreate');
    container = document.querySelector('.page-container-room');
    houseId = document.querySelector('#houseId');
    nickname = document.querySelector('#nickname');
    // isBookeable = document.querySelector('#isBookeable');
    priceRoom = document.querySelector('#priceRoom');
    priceForTwo = document.querySelector('#priceForTwo');
    description = document.querySelector('#description');
    unavailable = document.querySelector('#unavailable');
    country = document.querySelector('#country');
    nextRoom = document.querySelector('#next');
    nextRoomUpdate = document.querySelector('#update');
    commission = document.querySelectorAll('[name=commission]');
    totalEarned = document.querySelector('#totalEarned');
    
    bookeable = document.querySelector('.bookeable');
    roomDescField = $(".roomDescField");

    unavailableCheck;
    numberInputs = $("input[type='number']");
    if(document.getElementById('booking_id') != undefined){
      booking_id=document.getElementById('booking_id').value;
    }else{
      booking_id=0;
    }
    if(document.getElementById('user_id') != undefined){
      user_id=document.getElementById('user_id').value;
    }else{
      user_id=0;
    }
    let currentHab=document.getElementsByClassName('currentHab');
    current_item=+currentHab[0].getAttribute('item-number')-1;
    roomNumber=current_item+1;
    document.getElementById('numberRoom').innerHTML=roomNumber;
  }

  function events(){

    $('input[name="bookable"]').click(( e ) => {
      let elem = e.target;
      disableRoom(e,elem.id,elem.value);
    });

    priceRoom.addEventListener('keyup', ( e )=>{
      let value = e.target.value;
      let disc = Math.trunc(value*0.07);
      commission.forEach((e)=>{
        e.innerHTML = new Intl.NumberFormat('es-COL').format(disc);
      })
      totalEarned.innerHTML = new Intl.NumberFormat('es-COL').format(value - disc);
    });

    nickname.addEventListener('focus', ( e ) => { $(".nicknameDesc").toggle('slow') });
    nickname.addEventListener('blur', ( e ) => { $(".nicknameDesc").toggle('slow') });
    description.addEventListener('focus', ( e ) => { $('.roomDesc').toggle('slow') });
    description.addEventListener('blur', ( e ) => { $('.roomDesc').toggle('slow') });
    if (nextRoom != undefined) {
      nextRoom.addEventListener('click', ( e ) => {
        if(validateRoom()){

          e.target.setAttribute('disabled','disabled');
          let div_create = document.createElement("div");
          div_create.setAttribute('class', 'loadersmall');
          e.target.parentNode.replaceChild(div_create,e.target);

          createRoom();

        }
      })
    }
    if (nextRoomUpdate != undefined) {
      nextRoomUpdate.addEventListener('click', ( e ) => {
        if(validateRoom()){

          e.target.setAttribute('disabled','disabled');
          let div_create = document.createElement("div");
          div_create.setAttribute('class', 'loadersmall');
          e.target.parentNode.replaceChild(div_create,e.target);

          updateRoom(nextRoomUpdate.getAttribute('id-room'));
        }
      })
    }

    $('.couple').click( ( e ) => {
      let content = $("#couplePrice");

      if(e.target.value == "0"){
        content.hide('slow');
        priceForTwo.setAttribute("disabled","disabled");
      }
      else{
        content.show('slow');
        priceForTwo.removeAttribute('disabled');
      }

    });

    $('.window').click(( e ) => { setWindowMessage(e) });

    $(".availableInput").click(( e ) => {

      let content = $("#unavailableRoom");
      let inputDate = document.querySelector('#unavailable');
      let inputName = document.querySelector('#roomieName');
      let selectCountry = document.querySelector('#country');

      switch(e.target.value){
        case "1":
          content.hide(500);
          inputDate.value = "";
          inputDate.setAttribute('disabled', 'disabled');
          inputName.setAttribute('disabled', 'disabled');
          selectCountry.setAttribute('disabled', 'disabled');
        break;
        case "2":
          content.show(500);
          inputDate.value = "";
          inputDate.removeAttribute('disabled');
          inputDate.focus();
          inputName.removeAttribute('disabled');
          inputName.classList.add('verifiableRoom');
          selectCountry.removeAttribute('disabled');
          selectCountry.classList.add('verifiableRoom');
          break;
        case "3":
          content.show(500);
          inputDate.setAttribute('disabled', 'disabled');
          inputDate.value = "9999-12-30";
          inputName.removeAttribute('disabled');
          inputName.classList.add('verifiableRoom');
          selectCountry.removeAttribute('disabled');
          selectCountry.classList.add('verifiableRoom');

        break;
      }
    });

    $("#unavailable").datepicker({
      minDate:new Date(),
      dateFormat: "yy-mm-dd"
    });

    numberInputs.blur((e)=>removeDots(e.target));
    nickname.addEventListener('blur', ( e ) =>{
      document.querySelector('#roomName').innerHTML = nickname.value == "" ? `( Habitación ${roomNumber} )` : `( ${nickname.value} )`;
    });

  }

  function removeDots(element){

    let newData = element.value;
    let iter = newData.split(".").length-1;

    for (let index = 0; index < iter; index++) {
      newData = element.value.replace(".","");
    }

    // var newData = element.value== "" ? new Intl.NumberFormat('es').format(element.value) : new Intl.NumberFormat('es').format(element.value.replace(".",""));
    // split.forEach((element)=>newData+=element);
    element.value=newData;

  }

  function disableRoom(e,id,value){

    let form = window["noRented"];
    let inputs = form.querySelectorAll("input, textarea");
    let noRented = document.querySelector('#noRented');

    if(value == "0"){

      noRented.classList.add('alquiler-rejected','no-select');
      hiddenRoom = true;
      unavailableCheck = document.querySelector('#dispoRadio3');
      unavailableCheck.click();

      inputs.forEach(( element ) => {
        element.setAttribute('disabled','disabled');
      });


      $('html, body').animate({
        scrollTop: $(document).height()
      }, 'slow');

    }
    else{
      inputs.forEach(( element ) => {
        element.disabled=false;
      });

      inputs[3].setAttribute('disabled','disabled');
      inputs[16].setAttribute('disabled','disabled');
      inputs[0].value = "";
      hiddenRoom = false;
      unavailableCheck = document.getElementById('dispoRadio1');
      unavailableCheck.click();
      noRented.classList.remove("alquiler-rejected");
      noRented.classList.remove('no-select');

    }
  }

  function setWindowMessage(e){
    let windowDesc = document.querySelector('#infoStep2Room');
    switch(e.target.value){
      case 'afuera':
        windowDesc.innerHTML= 'Hacia el aire libre con entrada de sol y vista';
      break;
      case 'patio':
        windowDesc.innerHTML= 'Con entrada de aire pero sin vista';
      break;
      case 'adentro':
        windowDesc.innerHTML= 'Solo muestra el interior de la VICO';
      break;
      case 'sin_ventana':
        windowDesc.innerHTML= '';
      break;
    }
  }

  function focusBathShared(id){
    $('input[name="bath_shared"]').focus();
  }

  function getRadioValue(name) {
    var x = document.getElementsByName(name);
    for(var i=0 ; i< parseInt(x.length) ; i++){
      if(x[i].checked){
          return x[i].value;
      }
    }
  }

  function getData(){
    let room = {};
    let devices ={};
    let homemate = {};
    let data = {};

    room.nickname =  nickname.value === "" ? `Habitación ${roomNumber}` : nickname.value;
    room.number = +roomNumber;
    room.description = description.value !== "" ? description.value : "";
    room.house = houseId.value;

    if ( !hiddenRoom ) {
        // room

        room.price = priceRoom.value;
        room.isAvailable = getRadioValue("isAvailable");
        room.canCouple = getRadioValue("canCouple");

        if ( room.isAvailable == "2" || room.isAvailable == "3" ) {
          room.unavailable = unavailable.value;
        }

        if (room.canCouple === "1") {
          room.price_for_two = priceForTwo.value;
        }

        //devices

        devices.windows_type = getRadioValue("window_type");
        devices.bath_type = getRadioValue("bath_type");

        if (devices.bath_type == "Compartido con:") {
          devices.bath_type = `Compartido con: ${document.getElementsByName("bath_shared")[0].value}`;
        }

        devices.bed_type = getRadioValue("bed_type");

        if (document.getElementsByName("desk")[0].checked) {
            devices.desk = document.getElementsByName("desk")[0].value;
        }
        if (document.getElementsByName("has_closet")[0].checked) {
            devices.has_closet = document.getElementsByName("has_closet")[0].value;
        }
        if (document.getElementsByName("has_tv")[0].checked) {
            devices.has_tv = document.getElementsByName("has_tv")[0].value;
        }

        //homemates

        if ( room.isAvailable === "2" || room.isAvailable === "3" ) {

          homemate.name = document.querySelector("#roomieName").value;
          homemate.gender = getRadioValue("gender");
          homemate.country = document.querySelector("#country").value;

        }
      }
      else {

        room.price = "99999999";
        room.isAvailable = "3";
        room.canCouple = "0";
        room.unavailable = unavailable.value;
        devices.windows_type = "sin_ventana";
        devices.bath_type = "Privado";
        devices.bed_type = "sencilla";

        if ( document.querySelector("#roomieName").value != '' ) {
          homemate.name = document.querySelector("#roomieName").value;
          homemate.gender = getRadioValue("gender");
          homemate.country = document.querySelector("#country").value;
        }
      }

    data.room = room;
    data.devices = devices;
    data.homemate = homemate;

    hiddenRoom = false;

    return data;
  }

  async function createRoom() {
    let data=getData();
    let respuesta = await fetch('/rooms/storeNew',{
        method: 'post',
        credentials: "same-origin",
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json",
          "X-Requested-With": "XMLHttpRequest",
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        body: JSON.stringify(data)
      });
      let response = await respuesta.json();
      // console.log(response);
      if (response[0] === 'last_item') {
        // document.getElementById('finish').href+=response[1];
        document.getElementById('finish').href+=houseId.value;
        document.getElementById('finish').click();
      }
      else{
        let formCreate = document.getElementById('formCreateAndUpdateRooms');
        formCreate.innerHTML = response[0];
        let listItems = document.getElementsByClassName('page-item-room');
        listItems[current_item].classList.remove('currentHab');
        listItems[current_item].classList.add('created');
        listItems[current_item].setAttribute('id-room',response[1]);
        listItems[current_item+1].classList.add('currentHab');

        listItems[current_item].addEventListener('click',function(e){
            let idRoom = this.getAttribute('id-room');
            let itemNumber = this.getAttribute('item-number');
            // console.log(idRoom,itemNumber);
            editRoom(idRoom,itemNumber);
        });

        init();
        $('html, body').animate({
          scrollTop: 0
        }, 'slow');
        if(roomNumber-1 === steps*stepSlide){
          slideTabs(1,1);
          stepSlide++;
        }

        if(roomNumber === {{$count}}){
          document.querySelector('#next').innerHTML = 'Finalizar';
        }

      }
  }

  async function updateRoom(room_id) {
    let data=getData();
    data.room_id=room_id;
    if(booking_id != 0){
      data.booking_id=booking_id;
    }
    if(user_id != 0){
      data.user_id=user_id;
    }
    let respuesta=await fetch('/rooms/updateNew',{
        method: 'post',
        credentials: "same-origin",
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json",
          "X-Requested-With": "XMLHttpRequest",
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        body: JSON.stringify(data)
      });
      let response=await respuesta.json();
      // console.log(response);
      let formCreate=document.getElementById('formCreateAndUpdateRooms');
      formCreate.innerHTML=response[0];
      let listItems=document.getElementsByClassName('page-item-room');
      listItems[last_item].classList.add('currentHab');
      listItems[last_item].classList.remove('lastHab');
      listItems[current_item].classList.remove('currentHab');
      listItems[current_item].classList.remove('currentItem');
      listItems[current_item].setAttribute('id-room',response[1]);
      listItems[current_item].classList.add('created');
      init();
      if(counterSlides < stepSlide){
          let count = stepSlide-counterSlides;
          slideTabs(1,count);
        }
      $('html, body').animate({
        scrollTop: 0
      }, 'slow');
  }

  async function editRoom(room_id,item_room) {
    let respuesta=await fetch('/rooms/editNew/'+room_id,{
        method: 'get',
        credentials: "same-origin",
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json",
          "X-Requested-With": "XMLHttpRequest",
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
      });
      let response=await respuesta.json();
      // console.log(response);
      let formCreate=document.getElementById('formCreateAndUpdateRooms');
      formCreate.innerHTML=response[0];
      let listItems=document.getElementsByClassName('page-item-room');
      listItems[current_item].classList.remove('currentHab');
      listItems[current_item].classList.remove('currentItem');
      if (listItems[current_item].getAttribute('id-room')) {
        listItems[current_item].classList.add('created');
      }
      else{
        listItems[current_item].classList.add('lastHab');
        last_item=current_item;
      }
      listItems[+item_room-1].classList.remove('created');
      listItems[+item_room-1].classList.add('currentHab');
      listItems[+item_room-1].classList.add('currentItem');
      init();

      $('html, body').animate({
        scrollTop: 0
      }, 'slow');

      if( getRadioValue('canCouple') === '1' ){
        document.querySelector('#coupleAff').click();
      }

      if ( getRadioValue('isAvailable') === '1') {
        document.querySelector('#dispoRadio1').click();
      }

      if( getRadioValue('isAvailable') === '3'){
        document.querySelector('#isnotBookeable').click();
      }

      if ( getRadioValue('isAvailable') === '2') {
        document.querySelector('#dispoRadio2').click();
        let date = document.querySelector('#currentDate').getAttribute('value');
        document.querySelector('#unavailable').value = date;
      }

      if( getRadioValue('bath_type') === 'Privado' ){
        document.querySelector('#numBathShared').disabled;
      }
      else{
        let numBaths = document.querySelector('#numBaths').value;
        numBaths = +numBaths.replace(/\D/g,'');
        document.querySelector('#numBathShared').value = numBaths;

      }

  }

  $('input,select').blur((e) => {
    if(e.target.id != ""){
      $('#'+e.target.id).removeClass('invalid');
    }
  });

  function validateRoom(){

    let fields = $(".verifiableRoom");
    let i;

    for (i = 0; i < fields.length; i++) {
      if(fields[i].required==true){
        if (fields[i].disabled!= true) {
          if (fields[i].value == "") {

            $('html, body').animate({
              scrollTop: $('#'+fields[i].id).offset().top -100
              }, 'slow');

            $('#'+fields[i].id).focus();
            $('#'+fields[i].id).addClass('invalid');

            return false;
          }
        }
      }
    }
    return true;

  }


function slideTabs(option,times) {

  let boundsWrap = wrap.getBoundingClientRect();
  let boundsContainer = container.getBoundingClientRect();

  let item = document.querySelector('.page-item-room').getBoundingClientRect();
  let margin = 2;
  let totalTabs = {{$count}};

  let totalWidth = (item.width*steps)+(2*margin*steps);

  if ( option === 1 ) {
    if( boundsContainer.width > boundsWrap.width && counterSlides < Math.ceil(totalTabs/steps) ) {
      container.style = `left:${boundsContainer.left - (times*(totalWidth) + 30)}px`;
      counterSlides += times;
    }
  }
  else if(counterSlides > 1 ) {
    container.style = `left:${boundsContainer.left + (times*(totalWidth) - 30)}px`;
    counterSlides -= times;
  }

}

</script>
@endsection
