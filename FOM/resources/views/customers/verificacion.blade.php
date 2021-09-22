@extends('customers.index')
@section('title', 'Verificación del perfil')
@section('contentReview')

<div class="col-12 col-lg-8 mx-auto my-4">
    <div class="vico-card">
            <a id="id-card"></a>

        <div class="vico-card-header">
            <p class="vico-card-header-text">
                {{trans('general.personal_verification')}}
            </p>
        </div>
        <div class="vico-card-body" >
            {{trans('general.upload_photo')}}
        </div>
        <div class="vico-card-btn">
            <form action="/verification/upload-identification" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                @csrf
                <div>
                    @if (\Session::has('success_change_image'))
                        <div class="alert-success">
                            <ul>
                                <li>{!! \Session::get('success_change_image') !!}</li>
                            </ul>
                        </div>
                        <label for="file-upload" >
                            <span class="btn btn-primary">{{trans('customers/edituser.upload_file')}}</span>
                            <input id="file-upload" autofocus type="file" name="passport_image" accept="image/*" style='display: none;' />
                        </label>
                    @else
                        <label for="file-upload" >
                            <span class="btn btn-primary">{{trans('customers/edituser.upload_file')}}</span>
                            <input id="file-upload" type="file" name="passport_image" accept="image/*" style='display: none;' />
                        </label>
                    @endif
                    <button type="submit" class="btn btn-primary {{ Request::session()->get('verification')->document_verified ? 'disabled' : '' }}"
                         style="display: inline-block">{{trans('customers/edituser.save_changes')}}s</button>

                </div>
                <small class="text-danger">{{$errors->first('passport_image')}}</small>
            </form>
        </div>
    </div>
</div>
<div class="col-12 col-lg-8 mx-auto my-4">
    <div class="vico-card">
        <a id="email-card"></a>
        <div class="vico-card-header">
            <p class="vico-card-header-text">
                {{trans('general.email_verification')}}
            </p>
        </div>
        <div class="vico-card-body">
            {{trans('general.in_community_vico')}}<br>
            {{trans('general.in_email')}}
        </div>
        <div class="vico-card-btn">
            <a id="send-email-verification" class="btn btn-primary {{ Request::session()->get('verification')->email_verified ? 'disabled' : '' }}">
                {{trans('general.send_verification_code')}}
            </a>
            @if(Request::session()->get('verification')->email_verified)
                <i id="whatsapp_verified" class="fa fa-check" aria-hidden="true"></i>
            @endif
        </div>
    </div>
</div>

<div class="col-12 col-lg-8 mx-auto my-4">
    <div class="vico-card">
        <a id="phone-card"></a>
        <div class="vico-card-header">
            <p class="vico-card-header-text">
                {{trans('general.verify_phone_number')}}
            </p>
        </div>
        <div class="vico-card-body">
            <p>
                {{trans('general.very_important_youre_up_to_date')}}<br>
                {{trans('general.to_verify_number')}}
                {{-- Queremos que la comunicación entre todos los partidos sea la más fácil posible, así que verificamos tu número de celular.
                Para eso solamente te enviamos un código por SMS, que ingresas aquí para que sepamos que realmente eres tu,
                quien quiere reservar una habitación --}}
            </p>
        </div>

        <div class="vico-card-btn">
            <a  id="send-phone-verification"
                class="btn btn-primary
                {{ Request::session()->get('verification')->phone_verified ? 'disabled' : '' }}"
                data-toggle="modal" data-target="#phone-verify">
                @if(Request::session()->get('phone_code_sended') ? 'disabled':'')
                    {{trans('general.ingresar_code')}}
                @else
                {{trans('general.send_verification_code')}}
                @endif
            </a>

        @if(Request::session()->get('verification')->phone_verified)
            <i id="phone_verified" class="fa fa-check" aria-hidden="true"></i>
        @endif

        </div>
    </div>
</div>
@include('customers.whatsappVerification')
<!-- Email Modal -->
<div class="modal fade" id="email-sended" tabindex="-1" role="dialog" aria-labelledby="EmailModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{trans('general.email')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <p>
                        {{trans('general.click_the_link')}}
                        {{-- Te enviamos un correo electronico haz click en el link dentro del correo para verificar --}}
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
{{-- Phone Modal --}}
<div class="modal fade" id="phone-verify" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{trans('general.ingresa_code')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

                <p>{{trans('general.put_code_here_we_sent')}}</p>
                <form id="phone_verify">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="phone_code" placeholder="Codigo" class="form-control">
                    </div>
                    <p id="verification-phone-response"></p>
                    <button id="submit-phone-code" type="submit" class="btn btn-primary">{{trans('general.send')}}</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
