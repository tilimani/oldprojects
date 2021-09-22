<style type="text/css">
</style>
<div id="TermsAndConditions" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="TermsAndConditions" style="overflow:scroll" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="min-width: 100%; margin: 0;min-height: 100%;">
        <div class="modal-content p-md-4" style="min-height: 100vh;">
            {{-- MODAL HEADER  --}}
{{--             <div class="modal-header align-items-center">
               
            </div> --}}
            {{-- MODAL BODY  --}}
            <div class="modal-body p-4 large-modal-full-center">
                <p class="text-center">
                    <img class="w-50"  src="{{asset('images/termsandconditions/terminos.png')}}">
                </p>
                 <p class="h4 modal-title pb-2">{{trans('layouts/app.tyc_for_your_safety')}}.</p>
                <hr>

                <p>
                    <a target="_blank" class="text-justify" href="{{route('termsandconditions.showlastversion', '1')}}">{{trans('layouts/app.update_tyc')}}.</a>
                </p>
                <p>
                    @if(Auth::check() and Auth::user()->isUser())
                        {{trans('layouts/app.tyc_whatsnew')}} <br>
                        {{trans('layouts/app.tyc_learnmore_guests')}}
                        <a target="_blank" href="{{route('questions.user')}}" onclick="faqUser()">
                            {{trans('layouts/app.faq_user')}}
                        </a>
                    @else
                        {{trans('layouts/app.tyc_whatsnew')}} <br>
                        {{trans('layouts/app.tyc_learnmore_hosts')}}
                        <a target="_blank" href="{{route('questions.host')}}" onclick="faqManager()">
                            {{trans('layouts/app.faq_host')}}
                        </a>
                    @endif
                    
                </p>

                <form>
                    <p class="text-justify" style="display:none; color: red;" id="errorTaC">{{trans('layouts/app.please_acept')}}.</p>
                    <input type="checkbox" id="acceptTaC" name="TyC" class="acceptTaC" value="true"> {{trans('layouts/app.acept_tyc')}}.<br>
                    <button class="btn btn-primary sendAcceptTaC mt-2" type="button" id="sendAcceptTaC" value="send">{{trans('layouts/app.send_tyc')}}</button>
                </form>


                <p class="mt-4 text-justify">
                    {{trans('layouts/app.tyc_text_one')}} <a target="_blank" href="{{route('termsandconditions.showlastversion', '1')}}/#privacyagreement">{{trans('layouts/app.tyc_text_two')}}</a> {{trans('layouts/app.tyx_text')}} <a target="_blank" href="{{route('termsandconditions.showlastversion', '1')}}">{{trans('layouts/app.privacy_advice')}}</a>.
                </p>


            </div>
            {{-- MODAL FOOTER  --}}
            <div class="modal-footer align-items-center">
            </div>
        </div>
    </div>
</div>
@section('scripts')
<script>
function faqUser() {
    analytics.track('Enter user FAQ',{
        category: 'User knowlage'
    });
}
</script>
<script>
function faqManager() {
    analytics.track('Enter manager FAQ',{
        category: 'User knowlage'
    });
}
</script>
@endsection
