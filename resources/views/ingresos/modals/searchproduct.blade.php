
<!-- Modal -->
<div class="modal fade" id="exampleModal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titlemodal">Buscar producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

                <div class="modal-body row g-3">
                    <div class="col-3">
                        <div class="card mb-4 border-primary">
                            <div class="card-header bg-primary text-white">
                                Filtros de búsqueda
                            </div>
                            <div class="card-body">
                                <form id="frmseachproducto">
                                    <div class="col-12">
                                        <label for="codigosearch" class="form-label fw-bold">Código</label>
                                        <input type="text" class="form-control" id="codigosearch" name="codigosearch">
                                    </div>

                                    <div class="col-12">
                                        <label for="categoriasearch" class="form-label fw-bold">Categoría</label>
                                        <input type="text" class="form-control" id="categoriasearch" name="categoriasearch">
                                    </div>

                                    <div class="col-12">
                                        <label for="marcasearch" class="form-label fw-bold">Marca</label>
                                        <input type="text" class="form-control" id="marcasearch" name="marcasearch" autocomplete="false">
                                    </div>

                                    <div class="col-12">
                                        <label for="productosearch" class="form-label fw-bold">Descripción</label>
                                        <input type="text" class="form-control" id="productosearch" name="productosearch" autocomplete="false">
                                    </div>
                                    <div class="col-12  mb-2">
                                        <label for="estado" class="form-label fw-bold">Estado</label>
                                        <select class="form-select"  id="estado" name="estado">
                                            <option value="1" >Activos</option>
                                            <option value="0" >Inactivos</option>
                                        </select>
                                    </div>
                                    <div class="col-12 justify-content-center text-center">
                                        <button type="submit" class="btn btn-primary" id="">Buscar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-9">
                        <div id="tblcontent" class="table-responsive"></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
        </div>
    </div>
</div>
