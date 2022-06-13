<div class="modal fade" id="notacreditoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">NOTA DE CRÉDITO</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="frmNotacredito">
                <div class="row g-3">
    
                    <div class="col-12 col-sm- col-md-6 col-lg-6">
                        <label for="numero" class="form-label fw-bold text-uppercase">N° NOTA DE CRÉDITO</label>
                        <input type="number" class="form-control" id="numero" name="numero">
                    </div>
        
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <label for="totalcompra" class="form-label fw-bold text-uppercase">FECHA EMISION</label>
                        <input type="date" class="form-control" id="fecha_notacredito" name="fecha_notacredito">
                    </div>
        
                    <div class="col-12 col-sm- col-md-6 col-lg-6">
                        <label for="total_pago" class="form-label fw-bold text-uppercase">VALOR NOTA DE CRÉDITO</label>
                        <input type="number" step="any" min="0" class="form-control" id="total_pago" name="total_pago">
                    </div>
        
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <label for="deudas_id" class="form-label fw-bold text-uppercase">aplicar a factura</label>
                        <select class="form-control" id="deudas_id" name="deudas_id"></select>
                    </div>
                    
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
      </div>
    </div>
  </div>