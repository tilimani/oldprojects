@if(Request::session()->get('verification')->whatsapp)

<div class="row col-lg-6 col-md-8 col-sm-8 col-10 mb-2 mt-2 offset-md-2 offset-sm-2 offset-1">
    
    <div class="vico-card">
        <a id="whatsapp-card"></a>
        <div class="vico-card-header">
            <p class="vico-card-header-text">
                Verificación de tu Whatsapp
                
            </p>
        </div>
        <div class="vico-card-body">
            <p>
                {{trans('general.we_want_communication')}}
            </p>
        </div>
        <div class="vico-card-btn">
            <a id="send-whatsapp-verification" class="btn btn-primary {{ Request::session()->get('verification')->whatsapp_verified ? 'disabled' : '' }}"
                data-toggle="modal" data-target="#whatsapp-verify">
                @if(Request::session()->get('whatsapp_code_sended') ? 'disabled':'')
                    {{trans('general.ingresar_code')}}
                @else
                    {{trans('general.send_verification_code')}}
                @endif
          </a> @if(Request::session()->get('verification')->whatsapp_verified)
            <i class="fa fa-check" aria-hidden="true"></i> @endif
        </div>
    </div>
</div>
@endif
{{-- Whatsapp Modal --}}
<div class="modal fade" id="whatsapp-verify" tabindex="-1" role="dialog" aria-labelledby="WhatsappModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{trans('general.ingresa_code')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

                <p>{{trans('general.ingresa_codigo_we_sent')}}</p>
                <form id="whatsapp_verify">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="whatsapp_code" placeholder="Codigo" class="form-control">
                    </div>
                    <p id="verification-whatsapp-response"></p>
                    <button type="submit" class="btn btn-primary">{{trans('general.send')}}</button>
                </form>
                <small id="verification-response"></small>
            </div>
        </div>
    </div>
</div>