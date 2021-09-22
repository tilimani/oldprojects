@extends('layouts.app')
@section('title', 'Edit')
@section('content')
@section('styles')
    <style>
    textarea {
    resize: none;
    }

    .subir:hover{
        color:#fff;
        background: #f7cb15;
    }
    .field-icon {
        float: right;
        margin-right: 10px;
        margin-top: -40px;
        position: relative;
        z-index: 2;
    }
    ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
        color: lightgray;
        opacity: 1; /* Firefox */
    }

    :-ms-input-placeholder { /* Internet Explorer 10-11 */
        color: lightgray;
    }

    ::-ms-input-placeholder { /* Microsoft Edge */
        color: lightgray;
    }
    </style>
@endsection
<div class="container">
    <div class="row mt-3">
        <div class="col-sm-3 d-none">
            <br><br>
            <nav id="sidebar" class="hidden-xs d-none">
                 {{-- SIDEBAR HEADER  --}}
                <div class="row text-left">
                    <span class="sidebar-item">
                        <a href="" class="sidebar-itemlink">{{trans('customers/edituser.edit_account')}}</a>
                    </span>
                </div>
                <div class="row text-left">
                    <span class="sidebar-item">
                        <a href="" class="sidebar-itemlink">{{trans('customers/edituser.checking')}}</a>
                    </span>
                </div>
                <div class="row text-left">
                    <span class="sidebar-item">
                        <a href="" class="sidebar-itemlink">{{trans('customers/edituser.my_vicos')}}</a>
                    </span>
                </div>
                <div class="row text-left">
                    <span class="sidebar-item">
                        <a href="" class="sidebar-itemlink">{{trans('customers/edituser.my_reviews')}}</a>
                    </span>
                </div>
                <div class="row text-left">
                    <span class="sidebar-item">
                        <a href="" class="sidebar-itemlink">{{trans('customers/edituser.log_out')}}</a>
                    </span>
                </div>
            </nav>
        </div>
        <div class="col-sm-6 mx-auto">

            <form action="/userUpdate/profileImage" method="POST" accept-charset="UTF-8" enctype="multipart/form-data" style="border: #ea960f 1px solid;border-radius: 20px;">
                {{csrf_field()}}
                <div style="background-color: #ea960f;color: white;border-radius: 15px;height: 40px;border-bottom-left-radius: 0px;border-bottom-right-radius: 0px;  margin-right: -0.1%">
                    <label for="" style="margin-top: 2%; margin-left: 1rem; font-size: 90%;">{{trans('customers/edituser.upload_profile_pic')}}</label>
                </div><br>
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            @if ($user->image == null)
                                @if($user->gender === 2)
                                    <img style="height: 90px; width: 90px; border-radius: 100%" src="../images/homemates/girl.png" alt="girl" srcset="../images/homemates/girl@2x.png 2x, ../images/homemates/girl@3x.png 3x" />
                                @else
                                    <img style="height: 90px; width: 90px; border-radius: 100%" src="../images/homemates/boy.png" alt="boy" srcset="../images/homemates/boy@2x.png 2x, ../images/homemates/boy@3x.png 3x" />
                                @endif
                            @else
                                <img style="height: 90px; width: 90px; border-radius: 100%" src="https://fom.imgix.net/{{$user->image}}?w=500&h=500&fit=crop"/>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <p style="font-size: 85%">{{trans('customers/edituser.upload_pic_generate_confidence')}}</p>
                            <div>
                                @if (\Session::has('success_change_image'))
                                    <div class="alert-success">
                                        {!! \Session::get('success_change_image') !!}
                                    </div>
                                    <label for="file-upload" class="subir btn btn-primary" style="display: inline-block; margin-top: 2%">
                                    {{trans('customers/edituser.upload_file')}}
                                    </label>
                                    <input id="file-upload" autofocus onchange='cambiar()' type="file" name="new_image_profile" style='display: none;'/>
                                    <div id="info" style="display: inline-block"></div>
                                    {{-- <input autofocus class="form-control form-group" type="file" name="new_image_profile" id="new_image_profile" style="display: inline; width: 50%" > --}}
                                @else
                                    <label for="file-upload" class="subir btn btn-primary" style="display: inline-block; margin-top: 2%">
                                    {{trans('customers/edituser.upload_file')}}
                                    </label>
                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                    <input id="file-upload" onchange='cambiar()' type="file" name="new_image_profile" style='display: none;'/>
                                    <div id="info" style="display: inline-block"></div>
                                    {{-- <input class="form-control form-group" type="file" name="new_image_profile" id="new_image_profile" style="display: inline; width: 50%" > --}}
                                @endif
                                <button type="submit" class="btn btn-primary" style="display: inline-block">{{trans('customers/edituser.save_changes')}}s</button>
                            </div>
                        </div>
                    </div>
                </div><br>
            </form><br>
            <form action="/userUpdate/description" method="POST" style="border: #ea960f 1px solid;border-radius: 20px;" id="postUser">
                {{csrf_field()}}
                <div style="background-color: #ea960f;color: white;border-radius: 15px;height: 40px;border-bottom-left-radius: 0px;border-bottom-right-radius: 0px;  margin-right: -0.1%">
                    <label for="" style="margin-top: 2%; margin-left: 1rem; font-size: 90%;">{{trans('customers/edituser.public_profile')}}</label>
                </div><br>
                <div class="container">
                    <p style="font-size: 85%">{{trans('customers/edituser.public_description_vico')}}</p>
                    @if (\Session::has('success_change_description'))
                        <div class="alert-success">
                            <ul>
                                <li>{!! \Session::get('success_change_description') !!}</li>
                            </ul>
                        </div>
                        <textarea class="form-control mb-4" rows="4" cols="40" name="new_description" id="new_description" style="width: 100%" autofocus>{{$user->description}}</textarea>
                    @else                    
                    <textarea rows="4" class="form-control mb-4" cols="40" name="new_description" id="new_description" style="width: 100%">{{$user->description}}</textarea>
                    @endif
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <button type="submit" class="btn btn-primary" style="margin-left: 35%;width: 60%;">{{trans('customers/edituser.save_changes')}}s</button>
                </div> <br>
            </form><br>
            <form action="/userUpdate/channel" method="POST" style="border: #ea960f 1px solid;border-radius: 20px;" id="change_channel">
              @csrf
              <div style="background-color: #ea960f;color: white;border-radius: 15px;height: 40px;border-bottom-left-radius: 0px;border-bottom-right-radius: 0px;  margin-right: -0.1%">
                  <label for="" style="margin-top: 2%; margin-left: 1rem; font-size: 90%;">{{trans('customers/edituser.channels')}}</label>
              </div><br>
              <div class="container">
                  <p style="font-size: 85%">{{trans('customers/edituser.channel_description_vico')}}</p>
                  @if (\Session::has('success_update_channel'))
                      <div class="alert-success">
                          <ul>
                              <li>{!! \Session::get('success_update_channel') !!}</li>
                          </ul>
                      </div>          
                      <label class="custom-checkbox"><p>SMS</p>                      
                        <input name="channel" type="checkbox" value="sms" {{$verification->channel === 'sms' ? 'checked' : ''}}>
                        <span class="checkmark"></span>
                      </label>                        
                        {{-- <label class="custom-checkbox"><p>SMS</p>
                            <input id="sms-checkbox" name="channel" type="checkbox" {{$verification->channel === 'sms' ? 'checked' : ''}}>
                            <span class="checkmark"></span>
                        </label> --}}
                        {{-- <label class="custom-checkbox"><p>Whatsapp</p>
                            <input id="whatsapp-checkbox" name="channel" type="checkbox" {{$verification->channel === 'whatsapp' ? 'checked' : ''}}>
                            <span class="checkmark"></span>
                        </label> --}}
                         <label class="custom-checkbox"><p>Email</p>
                            <input name="email" type="checkbox" {{$verification->email === 1 ? 'checked' : ''}}>
                            <span class="checkmark"></span> 
                        </label>
                  @else
                    
                  <label class="custom-checkbox"><p>SMS</p>                      
                    <input name="channel" type="checkbox" value="sms" {{$verification->channel === 'sms' ? 'checked' : ''}}>
                    <span class="checkmark"></span>
                  </label>
                    {{-- <label class="custom-checkbox"><p>SMS</p>
                      <input id="sms-checkbox" name="channel" type="checkbox" value="sms" {{$verification->channel === 'sms' ? 'checked' : ''}}>
                      <span class="checkmark"></span>
                    </label> --}}
                    {{-- <label class="custom-checkbox"><p>Whatsapp</p>
                        <input id="whatsapp-checkbox" name="channel" type="checkbox" value="whatsapp" {{$verification->channel === 'whatsapp' ? 'checked' : ''}}>
                        <span class="checkmark"></span>
                    </label> --}}
                     <label class="custom-checkbox"><p>Email</p>
                        <input name="email" type="checkbox" {{$verification->email === 1 ? 'checked' : ''}}>
                        <span class="checkmark"></span>
                    </label> 
                  @endif
                  <button type="submit" class="btn btn-primary" style="margin-left: 35%;width: 60%;">{{trans('customers/edituser.save_changes')}}s</button>
              </div> <br>
            </form><br>
            <form action="/userUpdate/personalData" method="POST" style="border: #ea960f 1px solid;border-radius: 20px;">
                {{csrf_field()}}
                <input type="hidden" name="user_id" value="{{$user->id}}">
                <div style="background-color: #ea960f;color: white;border-radius: 15px;height: 40px;border-bottom-left-radius: 0px;border-bottom-right-radius: 0px; margin-right: -0.1%">
                    <label for="" style="margin-top: 2%; margin-left: 1rem; font-size: 90%;">{{trans('customers/edituser.personal_data')}}</label>
                </div><br>
                <div class="container">
                    @if (\Session::has('success_update_personal_data'))
                        <div class="alert-success">
                            <ul>
                                <li>{!! \Session::get('success_update_personal_data') !!}</li>
                            </ul>
                        </div>
                        <label for="name">{{trans('customers/edituser.name')}}</label>
                        <input autofocus class="form-control form-group" type="text" name="name" id="new_name" value={{$user->name}}>
                    @else
                    <label for="name">{{trans('customers/edituser.name')}}</label>
                    <input class="form-control form-group" type="text" name="name" id="new_name" value={{$user->name}}>
                    @endif
                    <label for="last_name">{{trans('customers/edituser.last_name')}}</label>
                    <input class="form-control form-group" type="text" name="last_name" id="new_last_name" value={{$user->last_name}}>
                    <label for="gender">{{trans('customers/edituser.gender')}}</label><br>
                    <select class="form-control form-group" name="gender" id="new_gender">
                        @if ($user->gender === 2)
                            <option value="1">{{trans('customers/edituser.male')}}</option>
                            <option value="2" selected>{{trans('customers/edituser.female')}}</option>
                        @else
                            <option value="1" selected>{{trans('customers/edituser.male')}}</option>
                            <option value="2">{{trans('customers/edituser.female')}}</option>
                        @endif
                    </select>
                    <label for="bithday">{{trans('customers/edituser.birth_date')}}</label><br>
                    <div>
                        <select class="form-control form-group" name="day" id="day" style="display: inline-flex; width: 30%">
                            <option value="0" selected>{{trans('customers/edituser.day')}}</option>
                            @for ($i = 1; $i <= 31; $i++)
                            @if ($user->birthdate != null && \Carbon\Carbon::parse($user->birthdate)->day == $i)
                                <option value="{{$i}}" selected>{{$i}}</option>
                            @else
                                <option value="{{$i}}">{{$i}}</option>
                            @endif
                            @endfor
                        </select>
                        <select class="form-control form-group" name="month" id="month" style="display: inline-flex; width: 30%">
                            <option value="0" selected>{{trans('customers/edituser.month')}}</option>
                            @if ($user->birthdate != null && \Carbon\Carbon::parse($user->birthdate)->month == 1)
                                <option value="1" selected>{{trans('customers/edituser.january')}}</option>
                            @else
                                <option value="1">{{trans('customers/edituser.january')}}</option>
                            @endif
                            @if ($user->birthdate != null && \Carbon\Carbon::parse($user->birthdate)->month == 2)
                                <option value="2" selected>{{trans('customers/edituser.february')}}</option>
                            @else
                                <option value="2">{{trans('customers/edituser.february')}}</option>
                            @endif
                            @if ($user->birthdate != null && \Carbon\Carbon::parse($user->birthdate)->month == 3)
                                <option value="3" selected>{{trans('customers/edituser.march')}}</option>
                            @else
                                <option value="3">{{trans('customers/edituser.march')}}</option>
                            @endif
                            @if ($user->birthdate != null && \Carbon\Carbon::parse($user->birthdate)->month == 4)
                                <option value="4" selected>{{trans('customers/edituser.april')}}</option>
                            @else
                                <option value="4">{{trans('customers/edituser.april')}}</option>
                            @endif
                            @if ($user->birthdate != null && \Carbon\Carbon::parse($user->birthdate)->month == 5)
                                <option value="5">{{trans('customers/edituser.may')}}</option>
                            @else
                                <option value="5">{{trans('customers/edituser.may')}}</option>
                            @endif
                            @if ($user->birthdate != null && \Carbon\Carbon::parse($user->birthdate)->month == 6)
                                <option value="6" selected>{{trans('customers/edituser.june')}}</option>
                            @else
                                <option value="6">{{trans('customers/edituser.june')}}</option>
                            @endif
                            @if ($user->birthdate != null && \Carbon\Carbon::parse($user->birthdate)->month == 7)
                                <option value="7" selected>{{trans('customers/edituser.july')}}</option>
                            @else
                                <option value="7">{{trans('customers/edituser.july')}}</option>
                            @endif
                            @if ($user->birthdate != null && \Carbon\Carbon::parse($user->birthdate)->month == 8)
                                <option value="8" selected>{{trans('customers/edituser.august')}}</option>
                            @else
                                <option value="8">{{trans('customers/edituser.august')}}</option>
                            @endif
                            @if ($user->birthdate != null && \Carbon\Carbon::parse($user->birthdate)->month == 9)
                                <option value="9" selected>{{trans('customers/edituser.september')}}</option>
                            @else
                                <option value="9">{{trans('customers/edituser.september')}}</option>
                            @endif
                            @if ($user->birthdate != null && \Carbon\Carbon::parse($user->birthdate)->month == 10)
                                <option value="10" selected>{{trans('customers/edituser.october')}}</option>
                            @else
                                <option value="10">{{trans('customers/edituser.october')}}</option>
                            @endif
                            @if ($user->birthdate != null && \Carbon\Carbon::parse($user->birthdate)->month == 11)
                                <option value="11" selected>{{trans('customers/edituser.november')}}</option>
                            @else
                                <option value="11">{{trans('customers/edituser.november')}}</option>
                            @endif
                            @if ($user->birthdate != null && \Carbon\Carbon::parse($user->birthdate)->month == 12)
                                <option value="12" selected>{{trans('customers/edituser.december')}}</option>
                            @else
                                <option value="12">{{trans('customers/edituser.december')}}</option>
                            @endif

                        </select>
                        <select class="form-control form-group" name="year" id="year" style="display: inline-flex; width: 30%">
                            <option value="0" selected>{{trans('customers/edituser.year')}}</option>
                            @for ($i = 1970; $i <= intval(\Carbon\Carbon::now()->year); $i++)
                                @if ($user->birthdate != null && \Carbon\Carbon::parse($user->birthdate)->year == $i)
                                    <option value="{{$i}}" selected>{{$i}}</option>
                                @else
                                    <option value="{{$i}}">{{$i}}</option>
                                @endif
                            @endfor
                        </select>
                    </div>
                    <label for="country">{{trans('customers/edituser.nacionality')}}</label>
                    <select class="form-control form-group" name="country" id="new_country">
                        <option value="0">{{trans('customers/edituser.where_you_from')}}</option>
                        @foreach ($countries as $country)
                        @if ($user->country_id == $country->id)
                            <option value="{{$country->id}}" selected>{{$country->name}}</option>
                        @else
                            <option value="{{$country->id}}">{{$country->name}}</option>
                        @endif
                        @endforeach
                    </select>
                    <label for="mail">Correo</label>
                    <input class="form-control form-group" type="email" name="mail" id="new_mail" value={{$user->email}}>
                    <label for="cellphone">{{trans('customers/edituser.wpp_number')}}</label>
                    @if ($user->phone != null)
                        <br><label for="" style="font-size: 85%">{{trans('customers/edituser.actual_number')}} {{$user->phone}}</label>
                    @endif
                    <input type="tel" name="cellphone" id="cellphone-edit-profile" class="form-control  form-group">
                    <br>
                    <br>
                    <button type="submit" class="btn btn-primary" style="margin-left: 35%;width: 60%;">{{trans('customers/edituser.save_changes')}}s</button>
                </div><br>
            </form><br>
            <form action="/userUpdate/password" method="POST" style="border: #ea960f 1px solid;border-radius: 20px;">
                {{csrf_field()}}
                <div style="background-color: #ea960f;color: white;border-radius: 15px;height: 40px;border-bottom-left-radius: 0px;border-bottom-right-radius: 0px;  margin-right: -0.1%">
                    <label for="" style="margin-top: 2%; margin-left: 1rem; font-size: 90%;">{{trans('customers/edituser.security')}}</label>
                </div><br>
                <div class="container">
                    @if (\Session::has('success_change_password'))
                        <div class="alert-success">
                            <ul>
                                <li>{!! \Session::get('success_change_password') !!}</li>
                            </ul>
                        </div>
                        <label for="last_password" style="font-size: 85%">{{trans('customers/edituser.change_pass')}}</label>
                        <input autofocus class="form-control form-group" type="password" name="current_password" id="current_password" placeholder="Contraseña actual" autocomplete="false" readonly onfocus="this.removeAttribute('readonly');">
                        <span toggle="#current_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    @elseif(\Session::has('error_new_password'))
                    <div class="alert alert-danger">
                        <ul>
                            <li>{!! \Session::get('error_new_password')!!}</li>
                        </ul>
                    </div>
                    <label for="last_password" style="font-size: 85%">{{trans('customers/edituser.change_pass')}}</label>
                    <input autofocus class="form-control form-group" type="password" name="current_password" id="current_password" placeholder="Contraseña actual" autocomplete="false" readonly onfocus="this.removeAttribute('readonly');">
                    <span toggle="#current_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    @elseif(\Session::has('error_change_password'))
                    <div class="alert alert-danger">
                        <ul>
                            <li>{!! \Session::get('error_change_password') !!}</li>
                        </ul>
                    </div>
                    <label for="last_password" style="font-size: 85%">{{trans('customers/edituser.change_pass')}}</label>
                    <input autofocus class="form-control form-group" type="password" name="current_password" id="current_password" placeholder="Contraseña actual" autocomplete="false" readonly onfocus="this.removeAttribute('readonly');">
                    <span toggle="#current_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    @else
                    <label for="last_password" style="font-size: 85%">{{trans('customers/edituser.change_pass')}}</label>
                    <input class="form-control form-group" type="password" name="current_password" id="current_password" placeholder="Contraseña actual"  autocomplete="false" readonly onfocus="this.removeAttribute('readonly');">
                    <span toggle="#current_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    @endif
                    <label for="new_password" style="font-size: 85%">{{trans('customers/edituser.new_pass')}}</label>
                    <input class="form-control form-group" type="password" name="new_password" id="new_password" placeholder="{{trans('customers/edituser.new_pass')}}"  autocomplete="false" readonly onfocus="this.removeAttribute('readonly');">
                    <span toggle="#new_password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    <button type="submit" class="btn btn-primary" style="margin-left: 35%;width: 60%;">{{trans('customers/edituser.save_changes')}}s</button>
                </div><br>
            </form><br>
            <form action="/userUpdate/delete" method="POST" style="border: #ea960f 1px solid;border-radius: 20px;">
                {{csrf_field()}}
                <div style="background-color: #ea960f;color: white;border-radius: 15px;height: 40px;border-bottom-left-radius: 0px;border-bottom-right-radius: 0px;  margin-right: -0.1%">
                    <label for="" style="margin-top: 2%; margin-left: 1rem; font-size: 90%;">Eliminar Cuenta</label>
                </div><br>
                <div class="container">
                    <label for="last_password" style="font-size: 85%">Respetando la ley de proteccion al consumidor VICO te da la posibilidad de eliminar tu cuenta</label>
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <button type="submit" class="btn btn-primary" style="margin-left: 35%;width: 60%;">Eliminar mi cuenta</button>
                </div><br>
            </form><br>

            
            <form action="{{route('user.update.role')}}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data" style="border: #ea960f 1px solid;border-radius: 20px;">
                {{csrf_field()}}
                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                <div style="background-color: #ea960f;color: white;border-radius: 15px;height: 40px;border-bottom-left-radius: 0px;border-bottom-right-radius: 0px;  margin-right: -0.1%">
                    <label for="" style="margin-top: 2%; margin-left: 1rem; font-size: 90%;">Quiero ser 
                        @if(Auth::user()->role_id == 2)
                            invitado VICO
                        @elseif(Auth::user()->role_id == 3)
                            manager VICO
                        @endif
                    </label>
                </div><br>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <p style="font-size: 85%">
                                @if(Auth::user()->role_id == 2)

                                    Ten en cuenta que, si tienes VICOs o solicitudes en tu cuenta manager, 
                                    no podrás verlas como invitado VICO. <br>
                                    No te preocupes, podrás cambiar de estado cuando quieras en esta misma sección. <br>
                                    Si tienes inquietudes sobre el cambio de Rol en tu cuenta, no dudes en contactarnos.
                                    
                                @elseif(Auth::user()->role_id == 3)

                                    Ten en cuenta que, si tienes solicitudes en tu cuenta de invitado, 
                                    no podrás verlas como manager VICO. <br>
                                    No te preocupes, podrás cambiar de estado cuando quieras en esta misma sección. <br>
                                    Si tienes inquietudes sobre el cambio de Rol en tu cuenta, no dudes en contactarnos.

                                @endif
                            </p>
                            <div>
                                @if (\Session::has('success_change_role'))
                                    <div class="alert-success">
                                        {!! \Session::get('success_change_role') !!}
                                    </div>
                                @endif
                                <div class="input">
                                    <input type="radio" name="change_role" value="2" {{Auth::user()->role_id == 2 ? 'checked' : ''}} id='button_manager'> <span id='not-bold'>Manager</span> 
                                    <input type="radio" name="change_role" value="3" {{Auth::user()->role_id == 3 ? 'checked' : ''}} id='button_user'> <span id='not-bold'>User</span><br>
                                </div>
                                <br>
                                {{-- <input autofocus class="form-control form-group" type="file" name="new_image_profile" id="new_image_profile" style="display: inline; width: 50%" > --}}
                                <button type="submit" class="btn btn-primary" style="display: inline-block">{{trans('customers/edituser.save_changes')}}s</button>
                            </div>
                        </div>
                    </div>
                </div><br>
            </form><br>

        </div>
        <div class="col-sm-3 d-none"></div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function cambiar(){
        var pdrs = document.getElementById('file-upload').files[0].name;
        document.getElementById('info').innerHTML = pdrs;
    }
    $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
        input.attr("type", "text");
        } else {
        input.attr("type", "password");
        }
    });
</script>
@endsection
