@extends('layouts.dashboard')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2/select2-bootstrap-5-theme.min.css') }}">
@endsection

@section('content')
    <div class="row mb-2">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white">
                    INGRESO DE FACTURAS
                </div>
                <div class="card-body">
                    @include('ingresos.partials.searchproduct')
                    <form id="frmdataingresofactura" name="frmdataingresofactura" class="row g-3">

                        <div class="d-flex flex-row-reverse">
                            <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                <label for="fechafactura" class="form-label fw-bold">Fecha Ingreso</label>
                                <input type="text" class="form-control" id="fechaingreso" readonly name="fechaingreso" value="" placeholder="">
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                            <label for="proveedor_id" class="form-label fw-bold">Empresa Proveedora</label>
                            <select class="form-control" id="proveedor_id" name="proveedor_id"></select>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                            <label for="creditofiscal" class="form-label fw-bold">Crédito Fiscal</label>
                            <input type="text" class="form-control" id="creditofiscal" name="creditofiscal" value="" placeholder="0000-000000-000-0">
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                            <label for="fechafactura" class="form-label fw-bold">Fecha Factura</label>
                            <input type="date" class="form-control" id="fechafactura" name="fechafactura" value="" placeholder="Código">
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                            <label for="branch_offices_id" class="form-label fw-bold">Sucursal</label>
                            <select class="form-control" id="branch_offices_id" name="branch_offices_id">
                                @foreach($sucursal as $item)
                                    <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class=" justify-content-center text-center">
                            <button type="button" class="btn btn-primary mb-3 mt-3" id="showmodalSearch">
                                Buscar Producto <i class="fa fa-search"></i>
                            </button>
                        </div>

                        <div class="col-12 table-responsive">
                            <table class="table table-bordered " id="rowstable">
                                <thead>
                                    <th>Descripción</th>
                                    <th>Marca</th>
                                    <th>Categoría</th>
                                    <th>Cantidad</th>
                                    <th>C. U.(sin IVA)</th>
                                    <th>Costo Total</th>
                                    <th class="text-center"> <i class="fas fa-trash"></i></th>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <div class="d-flex flex-row-reverse">
                                <div>
                                    <label class="fs-5 fw-bold">TOTAL: </label> <span class="fs-5" id="result">$0.00</span>
                                </div>
                            </div>
                            <div class=" justify-content-center text-center">
                                <button type="button" id="btnguardar" name="btnguardar" class="btn btn-primary">
                                    Guardar <i class="fas fa-save"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('js/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/pages/ingresofactura.js') }}"></script>
@endsection
