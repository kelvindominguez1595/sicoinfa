<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titlemodal">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="fmrdata" class="row g-3">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <label for="nombre" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="nombre" name="nombre">
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <label for="apellido" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="apellido" name="apellido">
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <label for="dui" class="form-label">DUI</label>
                        <input type="text" class="form-control" id="dui" name="dui">
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <label for="nit" class="form-label">NIT</label>
                        <input type="text" class="form-control" id="nit" name="nit">
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono">
                    </div>

                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea class="form-control" id="direccion" name="direccion"></textarea>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>
