
<!-- Modal -->
<div class="modal fade" id="exampleModal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titlemodal">REGISTRAR FACTURA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="frmsavefactura">
                @csrf            
                <div class="modal-body">

                    <div class="row g-3">

                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <label for="proveedor" class="form-label fw-bold text-uppercase">Proveedor</label>
                            <select class="form-control" id="proveedor" name="proveedor"></select>
                        </div>

                        <div class="col-12 col-sm-12 col-md-7 col-lg-7" id="contenedortipofactura">
                            <label for="tipofactura" class="form-label fw-bold text-uppercase" >Tipo de Documento</label>
                                <br>

                                @foreach($tipofactura as $item)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="tipofactura" id="tipofactura{{$item->id}}" value="{{ $item->id }}">
                                        <label class="form-check-label" for="tipofactura{{$item->id}}">{{ $item->name }}</label>
                                    </div>                                  
                                @endforeach                           
                        </div>

                        <div class="col-12 col-sm-12 col-md-5 col-lg-5">
                            <label for="numerofactura" class="form-label fw-bold text-uppercase">Número De Factura</label>
                            <input type="text" class="form-control" id="numerofactura" name="numerofactura">
                        </div>

                        <div class="col-12 col-sm- col-md-6 col-lg-6">
                            <label for="fechafacturado" class="form-label fw-bold text-uppercase">Fecha de Facturación</label>
                            <input type="date" class="form-control" id="fechafacturado" name="fechafacturado">
                        </div>
                        <div class="col-12 col-sm- col-md-6 col-lg-6">
                            <label for="fechapago" class="form-label fw-bold text-uppercase">Fecha de pago</label>
                            <input type="date" class="form-control" id="fechapago" name="fechapago">
                        </div>

                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                            <label for="totalcompra" class="form-label fw-bold text-uppercase">Total Compra</label>
                            <input type="number" min="0" step="any" class="form-control" id="totalcompra" name="totalcompra">
                        </div>
                        
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4" id="containercondicipago">
                            <label for="" class="form-label fw-bold text-uppercase">Condición de pago</label>
                            <br>
                            @foreach ($condicion as $item)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="estado" id="pagado{{ $item->id }}" value="{{ $item->id }}" @if($item->name == 'CRÉDITO') checked @endif>
                                    <label class="form-check-label" for="pagado{{ $item->id }}">{{ $item->name }}</label>
                                </div>                                
                            @endforeach                      
                        </div>

                        <div class="d-none row mt-2" id="contenedorformapago">

                            <div class="col-12 col-sm-12 col-md-6 col-lg-6" id="contenedorpagofrm">
                                <label class="form-label fw-bold" for="pagado1">FORMA DE PAGO</label>
                                <br>                            
                                @foreach($formapago as $item)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="formapago" id="formapago{{$item->id}}" value="{{ $item->id }}">
                                        <label class="form-check-label" for="formapago{{$item->id}}">{{ $item->name }}</label>
                                    </div>                                 
                                @endforeach
                            </div>

                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                <label class="form-label fw-bold" for="numerocheque">N° CHEQUE/REMESA</label>
                                <input type="number" min="0" class="form-control fw-bold" id="numerocheque" name="numerocheque" readonly>
                            </div>

                        </div>


                    </div>
        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
