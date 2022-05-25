@extends('layouts.dashboard')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2/select2-bootstrap-5-theme.min.css') }}">
@endsection
@section('js')
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('js/pages/deudas.js') }}"></script>
@endsection

@section('content')
    <div class="row mb-2">
        @include('proveedores.modals.modal')

        <div class="col-12 co-sm-12 col-md-6 col-lg-6">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <div>
                        DATOS DE FACTURA
                    </div>
                </div>
                <div class="card-body">

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
            </div>
        </div>

        <div class="col-12 co-sm-12 col-md-6 col-lg-6">
            <div class="row">
                <div class="col-12 co-sm-12 col-md-12 col-lg-12">
                    <div class="card mb-4 border-primary">
                        <div class="card-header bg-primary text-white d-flex justify-content-between">
                            <div>
                                PAGOS
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                                    <label for="numerofactura" class="form-label fw-bold text-uppercase">Número De Factura</label>
                                    <input type="text" class="form-control" id="numerofactura" name="numerofactura">
                                </div>
                                <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                                    <label for="numerofactura" class="form-label fw-bold text-uppercase">total compra</label>
                                    <input type="text" class="form-control" id="numerofactura" name="numerofactura">
                                </div>

                                <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                                    <label for="numerofactura" class="form-label fw-bold text-uppercase">total pago</label>
                                    <input type="text" class="form-control" id="numerofactura" name="numerofactura">
                                </div>
                                <hr>
                                <div class="col-12 col-sm- col-md-6 col-lg-6">
                                    <label for="fechafacturado" class="form-label fw-bold text-uppercase">Fecha de Facturación</label>
                                    <input type="date" class="form-control" id="fechafacturado" name="fechafacturado">
                                </div>
        
                                <div class="col-12 col-sm- col-md-6 col-lg-6">
                                    <label for="fechapago" class="form-label fw-bold text-uppercase">Fecha de pago</label>
                                    <input type="date" class="form-control" id="fechapago" name="fechapago">
                                </div>

                                <div class="col-12 col-sm-12 col-md-6 col-lg-6" id="containercondicipago">                                  
                                    <br>
                                    @foreach ($condicion as $item)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="estado" id="pagado{{ $item->id }}" value="{{ $item->id }}" @if($item->name == 'CRÉDITO') checked @endif>
                                            <label class="form-check-label" for="pagado{{ $item->id }}">{{ $item->name }}</label>
                                        </div>                                
                                    @endforeach                      
                                </div>

                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                    <label for="numerofactura" class="form-label fw-bold text-uppercase">Número De recibo</label>
                                    <input type="text" class="form-control" id="numerofactura" name="numerofactura">
                                </div>

                                <div class="col-12 col-sm-12 col-md-6 col-lg-6" id="contenedorpagofrm">                               
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
                </div>

        
                <div class="col-12 co-sm-12 col-md-6 col-lg-6">
                    <div class="card mb-4 border-primary">
                        <div class="card-header bg-primary text-white d-flex justify-content-between">
                            <div>
                                ABONOS
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                    <label for="numerofactura" class="form-label fw-bold text-uppercase">total abono</label>
                                    <input type="text" class="form-control" id="numerofactura" name="numerofactura">
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                    <label for="numerofactura" class="form-label fw-bold text-uppercase">recibo</label>
                                    <input type="text" class="form-control" id="numerofactura" name="numerofactura">
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                    <label for="numerofactura" class="form-label fw-bold text-uppercase">Fecha</label>
                                    <input type="text" class="form-control" id="numerofactura" name="numerofactura">
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6" id="contenedorpagofrm">                               
                                                         
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
                </div>            
          
        
            <div class="col-12 co-sm-12 col-md-6 col-lg-6">
                <div class="card mb-4 border-primary">
                    <div class="card-header bg-primary text-white d-flex justify-content-between">
                        <div>
                            NOTAS DE CRÉDITO
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                <label for="numerofactura" class="form-label fw-bold text-uppercase">n° nota de crédito</label>
                                <input type="text" class="form-control" id="numerofactura" name="numerofactura">
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                <label for="numerofactura" class="form-label fw-bold text-uppercase">fECHA DE eMISION</label>
                                <input type="text" class="form-control" id="numerofactura" name="numerofactura">
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                <label for="numerofactura" class="form-label fw-bold text-uppercase">VALOR nota de credito</label>
                                <input type="text" class="form-control" id="numerofactura" name="numerofactura">
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                <label for="numerofactura" class="form-label fw-bold text-uppercase">aplicar nota de credito a factura </label>
                                <input type="text" class="form-control" id="numerofactura" name="numerofactura">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

        <div class="col-xs-12 co-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <div class="">CUENTAS POR PAGAR </div>
                </div>
                <div class="card-body">

                        <div class="row mb-3">

                         

                            <div class="col-5 border border-dark">
                               
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <button type="button" id="btnadd" class="btn btn-primary">Agregar</button>
                            </div>
                        </div>
                    <form id="frmcuentas" class="row g-3 mt-1">
                        <div class="row table-responsive mb-3">
                            <table id="rowstable" class="table table-hover table-striped table-bordered styletabletable bordertitledeudas">
                                <thead class="">
                                    <tr>
                                        <td class="text-uppercase text-center bg-deudauno " rowspan="2">Fecha Factura</td>
                                        <td class="text-uppercase text-center bg-deudauno " rowspan="2"># Factura</td>
                                        <td class="text-uppercase text-center bg-deudauno " rowspan="2">Tipo Documento</td>
                                        <td class="text-uppercase text-center bg-deudauno " rowspan="2">Compra Total</td>
                                         <td colspan="5" class="text-center bg-deudados fw-bold ">ABONOS</td>
                                        <td colspan="4" class="text-uppercase text-center bg-deudatres fw-bold" >notas de crédito</td> 
                                        <td class="text-uppercase text-center bg-deudacuatro" rowspan="2">importe pendiente</td> 
                                        <td class="text-uppercase text-center bg-deudacinco " rowspan="2"># de Factura</td>
                                        <td class="text-uppercase text-center bg-deudacinco " rowspan="2">Fecha de pago</td>
                                        <td class="text-uppercase text-center bg-deudacinco " rowspan="2">Pago aplicado</td>
                                        <td class="text-uppercase text-center bg-deudacinco " rowspan="2"># de Recibo</td>
                                        <td class="text-uppercase text-center bg-deudacinco " rowspan="2">Forma de pago</td>
                                        <td class="text-uppercase text-center bg-deudacinco " rowspan="2"># de Documento de Pago</td>
                                        <td class="text-uppercase text-center bg-deudacinco " rowspan="2">deuda</td>
                                    </tr>
                                    <tr>
                                        <td class="text-uppercase text-center bg-deudados">abono $</td>
                                        <td class="text-uppercase text-center bg-deudados">Fecha</td>
                                        <td class="text-uppercase text-center bg-deudados">Forma de pago</td>
                                        <td class="text-uppercase text-center bg-deudados"># Recibo</td>
                                        <td class="text-uppercase text-center bg-deudados"># Documento</td>
                                        <td class="text-uppercase text-center bg-deudatres"># Nota de Crédito</td>
                                        <td class="text-uppercase text-center bg-deudatres">Valor Nota de Credito</td>
                                        <td class="text-uppercase text-center bg-deudatres">Aplicado a CCF</td>
                                        <td class="text-uppercase text-center bg-deudatres">FECHA</td>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <button type="submit"  class="btn btn-primary">Guardar cuentas</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
