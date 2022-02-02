<div class="modal fade " id="modaldata" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="frmdata">
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label class="form-label" for="cliente">Proveedor</label>
                            <input type="text" class="form-control" name="cliente" autocomplete="false" id="cliente" placeholder="Proveedor">
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label class="form-label" for="nombre_comercial">Nombre comercial</label>
                            <input type="text" class="form-control" name="nombre_comercial" autocomplete="false" id="nombre_comercial" placeholder="Nombre comercial">
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label class="form-label" for="razon_social">Razón Social</label>
                            <input type="text" class="form-control" name="razon_social" autocomplete="false" id="razon_social" placeholder="Razón Social">
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label class="form-label" for="giro">Giro</label>
                            <input type="text" class="form-control" name="giro" autocomplete="false" id="giro" placeholder="Giro">
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label class="form-label" for="giro">N° Registro</label>
                            <input type="text" class="form-control" name="num_registro" autocomplete="false" id="num_registro" placeholder="N° Registro">
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label class="form-label" for="nit">NIT</label>
                            <input type="text" class="form-control" name="nit" autocomplete="false" id="nit" placeholder="NIT">
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label class="form-label" for="telefono">Teléfono</label>
                            <input type="text" class="form-control" name="telefono" autocomplete="false" id="telefono" placeholder="Teléfono">
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" class="form-control" name="email" autocomplete="false" id="email" placeholder="Email">
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label class="form-label" for="direccion">Dirección</label>
                            <textarea class="form-control" name="direccion" id="direccion"></textarea>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="estado" name="estado" checked>
                                <label class="form-check-label" for="estado">
                                    Estado
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="Submit" class="btn btn-primary" id="btnmodal">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade " id="borrarmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modaltitleborrar">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="frmborrardata">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <input id="idite" name="idite" type="hidden">
                    <div class="" id="contenedor">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="Submit" class="btn btn-primary" id="btnborramodal">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
