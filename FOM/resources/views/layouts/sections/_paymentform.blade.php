<div class="form-group pb-0 mb-1">
    <label for="ctrl_name" class="text-secondary p-0 m-0">Nombre completo</label>
    <div class="input-group">
        <input type="text" vico="name" class="form-control vico-payment-control" name="ctrl_name" id="ctrl_name" value="{{ __($user->name . ' ' . $user->last_name)}}">
    </div>
</div>

<div class="form-group pb-0 mb-1">
    <label class="text-secondary p-0 m-0" for="ctrl_document">Número de cedula o pasaporte</label>
    <div class="input-group">
        <input type="text" class="form-control vico-payment-control" aria-label="" vico="document" id="ctrl_document" name="ctrl_document">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary dropdown-toggle btn_document_type" 
                type="button" 
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">Pasaporte</button>
            <div class="dropdown-menu">
                <a class="dropdown-item" onclick="document_type_onclick(1)">Pasaporte</a>
                <a class="dropdown-item" onclick="document_type_onclick(2)">Cedula</a>
            </div>
        </div>
    </div>
</div>

<div class="form-group pb-0 mb-1">
    <label for="ctrl_address" class="text-secondary p-0 m-0">Dirección</label>
    <div class="input-group">
        <input type="text" vico="address" id="ctrl_address" name="ctrl_address" class="form-control vico-payment-control">
    </div>
</div>

<div class="form-row pb-0 mb-1">
    <div class="form-group pb-0 mb-1 col-4">
        <label class="text-secondary p-0 m-0" for="ctrl_postal">Postal</label>
        <input type="text" vico="postal" id="ctrl_postal" name="ctrl_postal" class="form-control">
    </div>
    <div class="form-group pb-0 mb-1 col-8">
        <label class="text-secondary p-0 m-0" for="ctrl_city">Ciudad</label>
        <input type="text" vico="city" id="ctrl_city" name="ctrl_city" class="form-control">
    </div>
</div>
<div class="form-group pb-0 mb-1">
    <label for="ctrl_country" class="text-secondary p-0 m-0">País</label>
    <div class="input-group">
        <input type="text" vico="country" id="ctrl_country" name="ctrl_country" class="form-control" value="{{ $user->country()->first()->name }}">
    </div>
</div>