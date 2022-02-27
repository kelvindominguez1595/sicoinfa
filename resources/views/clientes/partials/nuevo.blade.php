<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titlemodal">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <form id="fmrdata"  method="post">
            <div class="modal-body row g-3">
                    @csrf
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <label for="nombre" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="nombres" name="nombres">
                    </div>

                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <label for="apellido" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos">
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <label for="dui" class="form-label">DUI</label>
                        <input type="text" class="form-control" id="dui" name="dui" autocomplete="false">
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 d-none" id="connit">
                        <label for="nit" class="form-label">NIT</label>
                        <input type="text" class="form-control" id="nit" name="nit" autocomplete="false">
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono">
                    </div>

                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea class="form-control" id="direccion" name="direccion"></textarea>
                    </div>

                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="state" name="state" checked>
                            <label class="form-check-label" for="state" id="lblstate">
                                Activo
                            </label>
                        </div>
                    </div>

                    <input type="hidden" id="tipocliente" name="tipocliente">
                    <input type="hidden" id="id" name="id">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" id="btnnamebutton">Guardar</button>
            </div>
            </form>
        </div>
    </div>
</div>
