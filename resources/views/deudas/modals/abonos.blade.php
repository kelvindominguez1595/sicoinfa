<div class="modal fade" id="abonosModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">ABONOS</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="frmAbonos">
                <input type="hidden" name="condicionpago_abono" id="condicionpago_abono" value="4">
                <div class="row g-3">
    
                    <div class="col-12 col-sm- col-md-6 col-lg-6">
                        <label for="deudas_idabonos" class="form-label fw-bold text-uppercase">número de factura</label>
                        <select name="deudas_idabonos" id="deudas_idabonos" class="form-control"></select>
                    </div>
    
                    <div class="col-12 col-sm- col-md-6 col-lg-6">
                        <label for="fecha_abono" class="form-label fw-bold text-uppercase">Fecha</label>
                        <input type="date" class="form-control" id="fecha_abono" name="fecha_abono">
                    </div>
    
                    <div class="col-12 col-sm- col-md-6 col-lg-6">
                        <label for="numfactura" class="form-label fw-bold text-uppercase">número de recibo</label>
                        <input type="text" class="form-control" id="numfactura" name="numfactura">
                    </div>
                    <div class="col-12 col-sm- col-md-6 col-lg-6">
                        <label for="total_pagoabono" class="form-label fw-bold text-uppercase">total abono</label>
                        <input type="text" class="form-control" id="total_pagoabono" name="total_pagoabono">
                    </div>
                    <hr>
    
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6" id="contenedorpagofrm">
                        <label class="form-label fw-bold" for="pagado1">FORMA DE PAGO</label>
                        <br>                            
                        @foreach($formapago as $item)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="form_pagoabono" id="form_pagoabono{{$item->id}}" value="{{ $item->id }}">
                                <label class="form-check-label" for="form_pagoabono{{$item->id}}">{{ $item->name }}</label>
                            </div>                                 
                        @endforeach
                    </div>
        
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <label class="form-label fw-bold" for="numcheque_abono">N° CHEQUE/REMESA</label>
                        <input type="number" min="0" class="form-control fw-bold" id="numcheque_abono" name="numcheque_abono" readonly>
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