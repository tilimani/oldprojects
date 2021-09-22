<div id="CompleteRegister" 
    class="modal fade" 
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="CompleteRegister" 
    style="overflow:scroll">
    <div class="modal-dialog">
        <div class="modal-content">
            {{-- MODAL HEADER  --}}
            <div class="modal-header align-items-center">
                <p class="h4 modal-title">{{trans('layouts/app.complete_register')}}</p>
                <button type="button" 
                    class="close" 
                    data-dismiss="modal">
                    <span class="icon-close"></span>
                </button>
            </div>
            {{-- MODAL BODY  --}}
            <div class="modal-body">
                <form method="post" action="/users/update">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-12">
                        <label>{{trans('layouts/app.confirm_data')}}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input type="text" 
                                name="name" 
                                id="nameCR" 
                                class="form-control form-group" 
                                placeholder="Name"
                                required>
                        </div>
                        <div class="col-12">
                            <input type="text" 
                                name="lastname" 
                                id="lastnameCR" 
                                class="form-control form-group" 
                                placeholder="Last name"
                                required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input type="email" name="email" id="emailCR" class="form-control  form-group" placeholder="example@gmail.com" required>
                        </div>
                        <div class="col-12">
                            <input type="tel" name="cellphone" id="cellphoneCR" class="form-control  form-group" placeholder=""  required>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-12">
                            <label for="country">{{trans('layouts/app.where_are_u')}}</label>
                            <select class="form-control " name="country" id="lista-usuariosCR" required></select>
                        </div>
                    </div>
                    <div class="row justify-content-center my-3">
                        <div class="col-6 col-sm-3 form-check">
                            <input type="radio" name="gender" value="1" required>
                            <label for="create-male">
                                <span class=" display-4 icon-man"></span>
                            </label>
                        </div>
                        <div class="col-6 col-sm-3 form-check">
                            <input type="radio" name="gender" value="2">
                            <label for="create-female">
                                <span class=" display-4 icon-woman"></span>
                            </label>
                        </div>
                    </div>
                    <div class="row d-flex align-content-center">
                        <div class="col-12 text-center">
                            <p class="h6">{{trans('layouts/app.wanna_be_manager')}}</p>
                        </div>
                        <div class="col-12 text-center">
                            <label class="switch">
                                {{-- <input type="checkbox" name="is_manager" class="checkmanager"> --}}
                                <input type="checkbox" name="is_manager" id="switchIsManager">
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <button type="submit" style="display: none;" id="btnCompleteRegister"></button>
                    <div class="col-12 d-flex justify-content-center">
                        <button class="btn btn-primary btn-block" id="CompleteRegister">{{trans('layouts/app.finalize')}}</button>
                    </div>
                </form>
            </div>
        </div>
        {{-- MODAL FOOTER  --}}
        <div class="modal-footer align-items-center">
        </div>
    </div>
</div>
<script type="text/javascript">
    let switchInput = document.getElementById('switchIsManager');

    if(localStorage.getItem('isCreatingHouse')){
        const isCreatingHouse = JSON.parse(localStorage.getItem('isCreatingHouse'));

        if(isCreatingHouse){
            switchInput.checked = true;
        } else{
            switchInput.checked = false;
        }
    }
    
</script>