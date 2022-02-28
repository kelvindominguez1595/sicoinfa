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
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>

                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <label for="phone" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="phone" name="phone">
                    </div>

                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <label for="address" class="form-label">Dirección</label>
                        <textarea class="form-control" id="address" name="address"></textarea>
                    </div>

                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="state" name="state" checked>
                            <label class="form-check-label" for="state" id="lblstate">
                                Activo
                            </label>
                        </div>
                    </div>
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
