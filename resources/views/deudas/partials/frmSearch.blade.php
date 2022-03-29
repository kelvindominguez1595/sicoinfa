<form action="" method="get" id="frmsearch">
    <div class="mb-3 d-flex justify-content-center">
        <button class="btn btn-primary btn-sm" type="button" id="btnresetall" onclick="$(location).attr('href','deudas');">Mostrar Todo</button>
    </div>
    <div class="col-12  mb-2">
        <label for="nombressearch" class="form-label fw-bold">Nombres</label>
        <input type="text" class="form-control" id="nombressearch" name="nombressearch" value="" placeholder="Nombres">
    </div>
    <div class="col-12  mb-2">
        <label for="apellidossearch" class="form-label fw-bold">Apellidos</label>
        <input type="text" class="form-control" id="apellidossearch" name="apellidossearch" value="" placeholder="Apellidos">
    </div>
    <div class="col-12  mb-2">
        <label for="duisearch" class="form-label fw-bold">DUI</label>
        <input type="text" class="form-control" id="duisearch" name="duisearch" value="" placeholder="DUI">
    </div>
    <div class="col-12 mb-2 " id="searchnit">
        <label for="nitsearch" class="form-label fw-bold">NIT</label>
        <input type="text" class="form-control" id="nitsearch" name="nitsearch" value="" placeholder="NIT">
    </div>
    <div class="col-12  mb-2">
        <label for="telefonosearch" class="form-label fw-bold">Teléfono</label>
        <input type="text" class="form-control" id="telefonosearch" name="telefonosearch" value="" placeholder="Teléfono">
    </div>
    <input type="hidden" id="frmsearchtype" name="frmsearchtype" value="1">
    <div class="col-12  d-flex justify-content-center mb-2">
        <button type="submit" class="btn btn-primary">Buscar <i class="fa fa-search"></i></button>
    </div>
</form>
