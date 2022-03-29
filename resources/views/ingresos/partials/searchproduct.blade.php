
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
                        <label for="codigosearch" class="form-label">Código</label>
                        <input type="text" class="form-control" id="codigosearch" name="codigosearch">
                    </div>

                    <div class="col-3">
                        <label for="categoriasearch" class="form-label">Categoría</label>
                        <input type="text" class="form-control" id="categoriasearch" name="categoriasearch">
                    </div>

                    <div class="col-2">
                        <label for="marcasearch" class="form-label">Marca</label>
                        <input type="text" class="form-control" id="marcasearch" name="marcasearch" autocomplete="false">
                    </div>

                    <div class="col-4">
                        <label for="productosearch" class="form-label">Producto</label>
                        <input type="text" class="form-control" id="productosearch" name="productosearch" autocomplete="false">
                    </div>

                    <div class="col-12 justify-content-center text-center">
                        <button type="button" class="btn btn-primary" id="btnmodalSearch">Buscar</button>
                    </div>

                </div>

            <div id="tblcontent" class="mt-3 container-fluid" ></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>

        </div>
    </div>
</div>
