@extends('layouts.dashboard')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2/select2-bootstrap-5-theme.min.css') }}">
@endsection


@section('content')
    <div class="row mb-2">
        <div class="col-12 co-sm-12 col-md-12 col-lg-12">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <div>
                        DETALLE DE LA DEUDA
                    </div>
                </div>
                <div class="card-body">

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
                                                <label id="titlteprovedor" class="form-label fw-bold text-uppercase">Proveedor: {{ $data->nombre_comercial }}</label>
                                                <input type="hidden" name="deuda_idglobal" id="deuda_idglobal" value="{{ $data->id }}">
                                                <input type="hidden" name="proveedorid_selectedupdate" id="proveedorid_selectedupdate" value="{{ $data->proveedor_id }}">
                        
                                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                    <label for="proveedor_idedit" class="form-label fw-bold text-uppercase">Proveedor</label>
                                                    <select class="form-control" id="proveedor_idedit" name="proveedor_idedit"></select>
                                                </div>
                        
                                                <div class="col-12 col-sm-12 col-md-5 col-lg-5">
                                                    <label for="numero_facturaupdate" class="form-label fw-bold text-uppercase">Número De Factura</label>
                                                    <input type="text" class="form-control" id="numero_facturaupdate" name="numero_facturaupdate" value="{{ $data->numero_factura }}">
                                                </div>
                                
                                                <div class="col-12 col-sm-12 col-md-7 col-lg-7" id="contenedortipofactura">
                                                    <label for="tipofactura" class="form-label fw-bold text-uppercase" >Tipo de Documento</label>
                                                        <br>    
                                                        @foreach($tipofactura as $item)
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input documentoupdate" type="radio" name="documentoupdate" id="documentoupdate{{$item->id}}" value="{{ $item->id }}" @if ($data->documento_id == $item->id) checked @endif>
                                                                <label class="form-check-label" for="documentoupdate{{$item->id}}">{{ $item->name }}</label>
                                                            </div>                                  
                                                        @endforeach                           
                                                </div>
                                       
                                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                                    <label for="fecha_facturaupdate" class="form-label fw-bold text-uppercase">Fecha de Facturación</label>
                                                    <input type="date" class="form-control" id="fecha_facturaupdate" name="fecha_facturaupdate" value="{{ $data->fecha_factura }}">
                                                </div>
                                
                                                <div class="col-12 col-sm- col-md-6 col-lg-6">
                                                    <label for="fecha_pagoupdate" class="form-label fw-bold text-uppercase">Fecha de pago</label>
                                                    <input type="date" class="form-control" id="fecha_pagoupdate" name="fecha_pagoupdate" value="{{ $data->fecha_pago }}">
                                                </div>
                        
                                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                                    <label for="total_compraupdate" class="form-label fw-bold text-uppercase">Total Compra</label>
                                                    <input type="number" min="0" step="any" class="form-control" id="total_compraupdate" name="total_compraupdate" value="{{ $data->total_compra }}">
                                                </div>   
                                                <div class="col-12 col-sm-12 col-md-6 col-lg-6" id="">
                                                    <label for="" class="form-label fw-bold text-uppercase">Condición de pago</label>
                                                    <br>
                                                    @foreach ($condicion as $item)
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="condicionespago_idupdate" id="condicionespago_idupdate{{ $item->id }}" value="{{ $item->id }}" @if ($data->condicionespago_id == $item->id) checked @endif>
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
                                        <div class="card-body row g-3 d-none" id="contentpagos">
                                            @include('deudas.partials.frmPagoEdit')
                                        </div>
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
    </div>
@endsection

@section('js')

    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('js/pages/deudas_editar.js') }}"></script>
    
@endsection