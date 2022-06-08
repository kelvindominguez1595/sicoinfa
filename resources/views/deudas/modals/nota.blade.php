<div class="modal fade" id="notacredito" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">NOTA DE CRÉDITO</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row g-3">

                <div class="col-12 col-sm- col-md-6 col-lg-6">
                    <label for="fechapago" class="form-label fw-bold text-uppercase">N° NOTA DE CRÉDITO</label>
                    <input type="date" class="form-control" id="fechapago" name="fechapago">
                </div>
    
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <label for="totalcompra" class="form-label fw-bold text-uppercase">FECHA EMISION</label>
                    <input type="number" min="0" step="any" class="form-control" id="totalcompra" name="totalcompra">
                </div>
    
                <div class="col-12 col-sm- col-md-6 col-lg-6">
                    <label for="fechapago" class="form-label fw-bold text-uppercase">VALOR NOTA DE CRÉDITO</label>
                    <input type="date" class="form-control" id="fechapago" name="fechapago">
                </div>
    
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <label for="totalcompra" class="form-label fw-bold text-uppercase">aplicar a factura</label>
                    <input type="number" min="0" step="any" class="form-control" id="totalcompra" name="totalcompra">
                </div>
                
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </div>
  </div>