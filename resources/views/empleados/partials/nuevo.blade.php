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
                        <label for="first_name" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="first_name" name="first_name">
                    </div>

                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <label for="last_name" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="last_name" name="last_name">
                    </div>

                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <label for="dui" class="form-label">DUI</label>
                        <input type="text" class="form-control" id="dui" name="dui" autocomplete="off">
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <label for="nit" class="form-label">NIT</label>
                        <input type="text" class="form-control" id="nit" name="nit" autocomplete="off">
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <label for="nup" class="form-label">NUP</label>
                        <input type="text" class="form-control" id="nup" name="nup" autocomplete="off">
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <label for="isss" class="form-label">ISSS</label>
                        <input type="text" class="form-control" id="isss" name="isss" autocomplete="off">
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <label for="phone" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="phone" name="phone">
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <label for="codigo" class="form-label">Código</label>
                        <input type="text" class="form-control" id="codigo" name="codigo">
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
