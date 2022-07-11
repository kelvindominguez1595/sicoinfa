  <!-- Modal -->
  <div class="modal fade" id="showdetailsclient" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header text-white bg-primary">
            <h5 class="modal-title">Detalle de Producto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="content">
            <div class="row mb-3">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="categoriashow" class="fw-bold">Categoria Producto</label>
                    <input type="text" class="form-control" name="categoriashow" id="categoriashow" readonly>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="marcashow" class="fw-bold">Marca</label>
                    <input type="text" class="form-control" name="marcashow" id="marcashow" readonly>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="codigoshow" class="fw-bold">Código</label>
                    <input type="text" class="form-control" name="codigoshow" id="codigoshow" readonly>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="unidaddemedidashow" class="fw-bold">Unidad de Medida</label>
                    <input type="text" class="form-control" name="unidaddemedidashow" id="unidaddemedidashow" readonly>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="codigobarrashow" class="fw-bold">Código de barra</label>
                    <input type="text" class="form-control" name="codigobarrashow" id="codigobarrashow" readonly >
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="categoria" class="fw-bold">Stock</label>
                    <div id="contenedorstock"></div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="nombreshow" class="fw-bold">Descripción</label>
                    <input type="text" class="form-control" name="nombreshow" id="nombreshow" readonly>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <img src="" alt="" width="25" height="25" id="statecheckedshow" class="img-fluid">
                    Producto Activo
                </div>

            </div>

            <div class="row mb-3">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="categoria" class="fw-bold">Detalles</label>
                    <div id="contentshow"></div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <img src="{{asset('images/logoFerreteria.png')}}" class="img-thumbnail" width="300"  id="posteproductshow">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <input type="hidden" name="precioid" id="precioid">
                    <label for="categoria" class="fw-bold">Costo del producto (SIN IVA) </label>
                    <div class="input-group mb-3">
                        <span class="input-group-text fw-bold" id="basic-addon1">$</span>
                        <input type="number" min="0" step="any" class="form-control" name="costosinivashow" id="costosinivashow" readonly value="0">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="categoria" class="fw-bold">Costo del Producto (IVA INCLUIDO)</label>

                    <div class="input-group mb-3">
                        <span class="input-group-text fw-bold" id="basic-addon1">$</span>
                        <input type="number" min="0" step="any" class="form-control " name="costoconivashow" id="costoconivashow" readonly  value="0" data-iva="13">
                    </div>
                </div>
            </div>

            <div class="row mb-3">

                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="row">
                        <div class="col">
                            <label for="categoria" class="fw-bold">Ganancia (IVA INCLUIDO)</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text fw-bold" id="basic-addon1">$</span>
                                <input type="number" min="0" step="any" class="form-control " readonly name="gananciashow" id="gananciashow" value="0">
                            </div>
                        </div>

                        <div class="col">
                            <label for="categoria" class="fw-bold">Porcentaje de Ganancia</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text fw-bold" id="basic-addon1">%</span>
                                <input type="number" min="0" step="any" class="form-control " readonly name="porcentajeshow" id="porcentajeshow" value="0">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="categoria" class="fw-bold">Precio de Venta a Consumidor (IVA INCLUIDO)</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text fw-bold" id="basic-addon1">$</span>
                        <input type="number" min="0" step="any" class="form-control" name="ventashow" id="ventashow" readonly value="0">
                    </div>
                </div>
            </div>

        </div>
      </div>
    </div>
  </div>

