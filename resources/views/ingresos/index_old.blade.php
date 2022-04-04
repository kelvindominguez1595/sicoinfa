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
                        <form id="frmingreo" name="frmingreo" class="row g-3">
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
                            <button type="button" class="btn btn-primary mb-3 mt-3" id="showmodalSearch">
                                Nuevo cliente <i class="fa fa-save"></i>
                            </button>
                            @include('ingresos.modals.searchproduct')
                          <!--
                            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                                <label for="producto_id" class="form-label fw-bold">Producto</label>
                                <select class="form-control" id="producto_id" name="producto_id"></select>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                <label for="cantidad" class="form-label fw-bold">Cantidad</label>
                                <input type="number" min="0" class="form-control" id="cantidad" name="cantidad" value="" placeholder="0">
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                <label for="costosiniva" class="form-label fw-bold">Costo Unitario(sin IVA)</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" min="0" step="any" class="form-control" id="costosiniva" name="costosiniva" value="" placeholder="0">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                <label for="costototal" class="form-label fw-bold">Costo Total</label>
                                <div class="input-group">
                                    <span class="input-group-text ">$</span>
                                    <input readonly type="number" min="0" step="any" class="form-control" id="costototal" name="costototal" value="" placeholder="0">
                                </div>
                            </div>
                            <input type="hidden" id="proid" name="proid">
                            <input type="hidden" id="nombreproducto" name="nombreproducto">
                            <input type="hidden" id="marca" name="marca">
                            <input type="hidden" id="categoria" name="categoria">
                            <input type="hidden" id="unidadmedida" name="unidadmedida">


                            <div class=" justify-content-center text-center">
                                <button type="button" id="btnadd" name="btnadd" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar </button>
                            </div>
                    -->


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
                                    <button type="submit" id="btnguardar" name="btnguardar" class="btn btn-primary"><i class="fas fa-save"></i> Guardar </button>
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
