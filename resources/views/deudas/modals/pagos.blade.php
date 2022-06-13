<div class="modal fade" id="pagosModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">PAGOS</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="frmpagos">
          <div class="row g-3">

            <div class="col-12 col-sm- col-md-6 col-lg-6">
                <label for="fechafacturado" class="form-label fw-bold text-uppercase">número de factura</label>
                <select class="form-control" id="deudas_idpago" name="deudas_idpago"></select>
            </div>

            <div class="col-12 col-sm- col-md-6 col-lg-6">
                <label for="totalfactura" class="form-label fw-bold text-uppercase">total compra</label>
                <input type="text" class="form-control" id="totalfactura" name="totalfactura" readonly>   
            </div>

            <div class="col-12 col-sm- col-md-6 col-lg-6">
                <label for="totalpagoshow" class="form-label fw-bold text-uppercase">total pago</label>
                <input type="text" class="form-control" id="totalpagoshow" name="totalpagoshow" readonly>
            </div>

            <hr>

            <div class="col-12 col-sm- col-md-6 col-lg-6">
                <label for="fechafacturado_pago" class="form-label fw-bold text-uppercase">Fecha de Facturación</label>
                <input type="date" class="form-control" id="fechafacturado_pago" name="fechafacturado_pago" readonly>
            </div>

            <div class="col-12 col-sm- col-md-6 col-lg-6">
                <label for="fechapago_pago" class="form-label fw-bold text-uppercase">Fecha de pago</label>
                <input type="date" class="form-control" id="fechapago_pago" name="fechapago_pago" readonly>
            </div>

            <div class="col-12 col-sm-12 col-md-6 col-lg-6" id="containercondicipago">
                <label for="" class="form-label fw-bold text-uppercase">Condición de pago</label>
                <br>
                @foreach ($pagos as $item)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="condicionespago_id" id="condicionespago_id{{ $item->id }}" value="{{ $item->id }}" @if($item->name == 'PAGADO') checked @endif>
                        <label class="form-check-label" for="condicionespago_id{{ $item->id }}">{{ $item->name }}</label>
                    </div>                                
                @endforeach                      
            </div>

            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                <label for="numeropago" class="form-label fw-bold text-uppercase">número de recibo</label>
                <input type="number" min="0"  class="form-control" id="numeropago" name="numeropago">
            </div>

            <div class="col-12 col-sm-12 col-md-6 col-lg-6" id="contenedorpagofrm">
                <label class="form-label fw-bold" for="pagado1">FORMA DE PAGO</label>
                <br>                            
                @foreach($formapago as $item)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="formapago_idpago" id="formapago_idpago{{$item->id}}" value="{{ $item->id }}" >
                        <label class="form-check-label" for="formapago_idpago{{$item->id}}">{{ $item->name }}</label>
                    </div>                                 
                @endforeach
            </div>

            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                <label class="form-label fw-bold" for="numerochequepago">N° CHEQUE/REMESA</label>
                <input type="number" min="0" class="form-control fw-bold" id="numerochequepago" name="numerochequepago" readonly>
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