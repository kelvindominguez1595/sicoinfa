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
        <div class="col-xs-12 co-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <div class="">CUENTAS POR PAGAR </div>
                </div>
                <div class="card-body">

                        <div class="row mb-3">

                            @include('deudas.partials.datofactura')
                            @include('deudas.partials.preciosfactura')

                        </div>
                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <button type="button" id="btnadd" class="btn btn-primary">Agregar</button>
                            </div>
                        </div>
                    <form id="frmcuentas" class="row g-3 mt-1">
                        <div class="row table-responsive mb-3">
                            <table id="rowstable" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <th class="text-uppercase">Fecha Factura</th>
                                    <th class="text-uppercase">N° Factura</th>
                                    <th class="text-uppercase">Documento</th>
                                    <th class="text-uppercase">total compra</th>
                                    <th class="text-uppercase">nota de credito</th>
                                    <th class="text-uppercase">n° nota de credito</th>
                                    <th class="text-uppercase">fecha pago/abono</th>
                                    <th class="text-uppercase">forma de pago</th>
                                    <th class="text-uppercase">n° recibo</th>
                                    <th class="text-uppercase">n° cheque/remesa</th>
                                    <th class="text-uppercase">abono</th>
                                    <th class="text-uppercase">saldo pte.</th>
                                    <th class="text-uppercase">cancelado</th>
                                    <th class="text-uppercase">estado</th>
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
