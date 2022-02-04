@extends('layouts.dashboard')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2/select2-bootstrap-5-theme.min.css') }}">
@endsection
@section('js')
    <script src="{{ asset('js/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/pages/ingresofactura.js') }}"></script>
@endsection

@section('content')
    <div class="row mb-2">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white">
                    INGRESO DE FACTURAS
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                            <label for="codigo" class="form-label fw-bold">Empresa Proveedora</label>
                            <input type="text" class="form-control" id="codigo" name="codigo" value="" placeholder="Código">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                            <label for="codigo" class="form-label fw-bold">Crédito Fiscal</label>
                            <input type="text" class="form-control" id="codigo" name="codigo" value="" placeholder="Código">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                            <label for="codigo" class="form-label fw-bold">Fecha Factura</label>
                            <input type="date" class="form-control" id="codigo" name="codigo" value="" placeholder="Código">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                            <label for="codigo" class="form-label fw-bold">Producto</label>
                            <input type="text" class="form-control" id="codigo" name="codigo" value="" placeholder="Código">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                            <label for="codigo" class="form-label fw-bold">Cantidad</label>
                            <input type="number" min="0" class="form-control" id="cantidad" name="cantidad" value="" placeholder="0">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                            <label for="codigo" class="form-label fw-bold">Costo Unitario(sin IVA)</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" min="0" step="any" class="form-control" id="codigo" name="codigo" value="" placeholder="0">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                            <label for="codigo" class="form-label fw-bold">Costo Total</label>
                            <div class="input-group">
                                <span class="input-group-text ">$</span>
                                <input type="number" min="0" step="any" class="form-control" id="codigo" name="codigo" value="" placeholder="0">
                            </div>
                        </div>

                        <div class=" justify-content-center text-center">
                            <button type="button" id="btnadd" name="btnadd" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar </button>
                        </div>
                        <div class="col-12 table-responsive">
                            <table class="table table-bordered " id="rowstable">
                                <thead>
                                    <th>Descripción</th>
                                    <th>Marca</th>
                                    <th>Categoría</th>
                                    <th>Cantidad</th>
                                    <th>Costo Unitario(sin IVA)</th>
                                    <th>Costo Total</th>
                                    <th class="text-center"> <i class="fas fa-trash"></i></th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
