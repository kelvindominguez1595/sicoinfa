
<!-- Modal -->
<div class="modal fade" id="editarDeudaModal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titlemodal">EDITAR</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formDeudasEdit">
                @csrf            
                <div class="modal-body">
                    <div class="row">

                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="card border-bottom-0 border-start-0 border-end-0">
                                <div class="card-header bg-primary text-white border-start border-end">
                                    DATOS DE FACTURA 
                                </div>
                                <div class="card-body ">
                                    <div class="row g-3">
                                        <label id="titlteprovedor" class="form-label fw-bold text-uppercase">Proveedor</label>
                                        <input type="hidden" name="deuda_idglobal" id="deuda_idglobal">
                                        <input type="hidden" name="proveedorid_selectedupdate" id="proveedorid_selectedupdate">
                
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                            <label for="proveedor_idedit" class="form-label fw-bold text-uppercase">Proveedor</label>
                                            <select class="form-control" id="proveedor_idedit" name="proveedor_idedit"></select>
                                        </div>
                
                                        <div class="col-12 col-sm-12 col-md-5 col-lg-5">
                                            <label for="numero_facturaupdate" class="form-label fw-bold text-uppercase">Número De Factura</label>
                                            <input type="text" class="form-control" id="numero_facturaupdate" name="numero_facturaupdate">
                                        </div>
                        
                                        <div class="col-12 col-sm-12 col-md-7 col-lg-7" id="contenedortipofactura">
                                            <label for="tipofactura" class="form-label fw-bold text-uppercase" >Tipo de Documento</label>
                                                <br>    
                                                @foreach($tipofactura as $item)
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input documentoupdate" type="radio" name="documentoupdate" id="documentoupdate{{$item->id}}" value="{{ $item->id }}">
                                                        <label class="form-check-label" for="documentoupdate{{$item->id}}">{{ $item->name }}</label>
                                                    </div>                                  
                                                @endforeach                           
                                        </div>
                               
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                            <label for="fecha_facturaupdate" class="form-label fw-bold text-uppercase">Fecha de Facturación</label>
                                            <input type="date" class="form-control" id="fecha_facturaupdate" name="fecha_facturaupdate">
                                        </div>
                        
                                        <div class="col-12 col-sm- col-md-6 col-lg-6">
                                            <label for="fecha_pagoupdate" class="form-label fw-bold text-uppercase">Fecha de pago</label>
                                            <input type="date" class="form-control" id="fecha_pagoupdate" name="fecha_pagoupdate">
                                        </div>
                
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                            <label for="total_compraupdate" class="form-label fw-bold text-uppercase">Total Compra</label>
                                            <input type="number" min="0" step="any" class="form-control" id="total_compraupdate" name="total_compraupdate">
                                        </div>   
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6" id="">
                                            <label for="" class="form-label fw-bold text-uppercase">Condición de pago</label>
                                            <br>
                                            @foreach ($condicion as $item)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="condicionespago_idupdate" id="condicionespago_idupdate{{ $item->id }}" value="{{ $item->id }}" @if($item->name == 'CRÉDITO') checked @endif>
                                                    <label class="form-check-label" for="condicionespago_idupdate{{ $item->id }}">{{ $item->name }}</label>
                                                </div>                                
                                            @endforeach                      
                                        </div>     
                                    </div>
                              
                                </div>
                              </div>

                              <div class="card border-bottom-0 border-start-0 border-end-0">
                                <div class="card-header bg-primary text-white border-start border-end  d-flex justify-content-between">
                                  DATOS DE PAGO
                                    <button type="button" id="btnborrarpago" class="btn btn-light btn-sm">Borrar Pago</button>
                                </div>
                                <div class="card-body row g-3" id="contentpagos"></div>
                              </div>

                        </div>

                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">

                            <div class="card border-bottom-0 border-start-0 border-end-0">
                                <div class="card-header bg-primary text-white border-start border-end">
                                  DATOS DE NOTA DE CRÉDITO
                                </div>
                                <div class="card-body ">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>                          
                                                <th>NUMERO</th>
                                                <th>FECHA</th>
                                                <th>PAGO</th>
                                                <th></th>
                                            </thead>
                                            <tbody id="bodynot"></tbody>
                                        </table>
                                    </div>                              
                                </div>
                              </div>

                            <div class="card border-bottom-0 border-start-0 border-end-0">
                                <div class="card-header bg-primary text-white border-start border-end">
                                  DATOS DE ABONOS
                                </div>
                                <div class="card-body ">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>                          
                                                <th>FECHA</th>
                                                <th>RECIBO</th>
                                                <th>ABONO</th>
                                                <th>FORMA DE PAGO</th>
                                                <th>NUMERO</th>
                                                <th></th>
                                            </thead>
                                            <tbody id="bodyabo"></tbody>
                                        </table>
                                    </div>
                              
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div class="">
                        <button type="button" id="btndeleteall" class="btn btn-danger">Borrar Deuda</button>
                    </div>
                    <div class="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
