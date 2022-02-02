<div class="modal fade " id="modaldata" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="frmdata">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                            <input type="hidden" name="id" id="id">
                            <label class="form-label" for="name">Categoría</label>
                            <input type="text" class="form-control" name="name" autocomplete="false" id="name" placeholder="Categoría">
                            <input type="hidden" name="state" id="state" value="1">
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
