<div class="modal fade" id="nuevoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Nueva Factura</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        


        <div class="modal-body">
            <form action="" id="frmnuevo">
                <div class="row g-3">


                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <label for="proveedor_id" class="form-label fw-bold text-uppercase">Proveedor</label>
                        <select class="form-control" id="proveedor_id" name="proveedor_id"></select>
                    </div>

             
                        <div class="col-12 col-sm-12 col-md-5 col-lg-5">
                            <label for="numero_factura" class="form-label fw-bold text-uppercase">Número De Factura</label>
                            <input type="text" class="form-control" id="numero_factura" name="numero_factura">
                        </div>
        
                        <div class="col-12 col-sm-12 col-md-7 col-lg-7" id="contenedortipofactura">
                            <label for="tipofactura" class="form-label fw-bold text-uppercase" >Tipo de Documento</label>
                                <br>    
                                @foreach($tipofactura as $item)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="documento_id" id="documento_id{{$item->id}}" value="{{ $item->id }}">
                                        <label class="form-check-label" for="documento_id{{$item->id}}">{{ $item->name }}</label>
                                    </div>                                  
                                @endforeach                           
                        </div>
        
                   
    
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <label for="fecha_factura" class="form-label fw-bold text-uppercase">Fecha de Facturación</label>
                        <input type="date" class="form-control" id="fecha_factura" name="fecha_factura">
                    </div>
    
                    <div class="col-12 col-sm- col-md-6 col-lg-6">
                        <label for="fecha_pago" class="form-label fw-bold text-uppercase">Fecha de pago</label>
                        <input type="date" class="form-control" id="fecha_pago" name="fecha_pago">
                    </div>
    
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <label for="total_compra" class="form-label fw-bold text-uppercase">Total Compra</label>
                        <input type="number" min="0" step="any" class="form-control" id="total_compra" name="total_compra">
                    </div>
    
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6" id="containercondicipago">
                        <label for="" class="form-label fw-bold text-uppercase">Condición de pago</label>
                        <br>
                        @foreach ($condicion as $item)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="condicionespago_id" id="condicionespago_id{{ $item->id }}" value="{{ $item->id }}" @if($item->name == 'CRÉDITO') checked @endif>
                                <label class="form-check-label" for="condicionespago_id{{ $item->id }}">{{ $item->name }}</label>
                            </div>                                
                        @endforeach                      
                    </div>
                    <div id="contenedorpagos" class="row g-3 d-none">

                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="presentafactura">¿Presenta factura?</label>
                                <input class="form-check-input" type="checkbox" role="switch" id="presentafactura" name="presentafactura" value="si" checked>
                            </div>
                        </div>
    
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                            <label for="numero_recibonuevo" class="form-label fw-bold text-uppercase">NÚMERO DE RECIBO</label>
                            <input type="text" class="form-control" id="numero_recibonuevo" name="numero_recibonuevo">
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6" id="contenedorpagofrm">
                            <label class="form-label fw-bold" for="pagado1">FORMA DE PAGO</label>
                            <br>                            
                            @foreach($formapago as $item)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="formpago_nuevo" id="formpago_nuevo{{$item->id}}" value="{{ $item->id }}" >
                                    <label class="form-check-label" for="formpago_nuevo{{$item->id}}">{{ $item->name }}</label>
                                </div>                                 
                            @endforeach
                        </div>
            
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                            <label class="form-label fw-bold" for="numerochequenuevo">N° CHEQUE/REMESA</label>
                            <input type="number" min="0" class="form-control fw-bold" id="numerochequenuevo" name="numerochequenuevo" readonly>
                        </div>   

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