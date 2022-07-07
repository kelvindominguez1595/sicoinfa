  <!-- Modal -->
  <div class="modal fade" id="shownoti" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
            Detalle de Historial de Producto
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <div class="row mb-3">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="categoria" class="fw-bold">Categoria Producto</label>
                    <input type="text" name="categoriatxt" id="categoriatxt" class="form-control" disabled>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="categoria" class="fw-bold">Marca</label>
                    <input type="text" name="marcatxt" id="marcatxt" class="form-control" disabled>

                </div>
            </div>

            <div class="row mb-3">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="codigo" class="fw-bold">Código</label>
                    <input type="text" name="codigotxt" id="codigotxt" class="form-control" disabled>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="unidaddemedida" class="fw-bold">Unidad de Medida</label>
                    <input type="text" name="unidadmedidatxt" id="unidadmedidatxt" class="form-control" disabled>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="codigobarra" class="fw-bold">Código de barra</label>
                    <input type="text" name="codigobarratxt" id="codigobarratxt" class="form-control" disabled>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="categoria" class="fw-bold">Descripción</label>
                    <input type="text" name="descripcciontxt" id="descripcciontxt" class="form-control" disabled>
                </div>

            </div>

            <div class="row mb-3">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="categoria" class="fw-bold">Detalles</label><br>
                    <label for="" id="detallestxt"></label>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="categoria" class="fw-bold">Stock</label>
                    <input type="text" name="cantidadtxt" id="cantidadtxt" class="form-control" disabled>

                    <div class="" id="imagecontainer">
                        <div id="contentimage"></div>

                    </div>
                </div>
            </div>

        </div>
      </div>
    </div>
  </div>
