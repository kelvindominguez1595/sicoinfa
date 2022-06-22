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
    <script src="{{ asset('js/pages/deudas_editar.js') }}"></script>
    <script src="{{ asset('js/pages/deudas_pagos.js') }}"></script>
    <script src="{{ asset('js/pages/deudas_abonos.js') }}"></script>
    <script src="{{ asset('js/pages/deudas_notacredito.js') }}"></script>
@endsection

@section('content')
    @include('deudas.modals.abonos')
    @include('deudas.modals.nota')
    @include('deudas.modals.nuevo')
    @include('deudas.modals.pagos')
    @include('deudas.modals.edit')
    <div class="row mb-2">
        <div class="col-12">
            <div class="btn-group" role="group" aria-label="Basic outlined example">
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#nuevoModal">NUEVO</button>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#notacreditoModal">NOTA DE CRÉDITO</button>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#pagosModal">PAGOS</button>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#abonosModal">ABONOS</button>
              </div>    
        </div>
    </div>
    <div class="row mb-2">
       
        {{-- columna 1 --}}
        <div class="col-xs-12 co-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                   Deudas
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <th class="text-center size-font-medium-small bg-deudauno">FECHA DE FAC.</th>
                                <th class="text-center size-font-medium-small bg-deudauno">N. DE FACTURA</th>
                                <th class="text-center size-font-medium-small bg-deudauno">TIPO DE DOC.</th>
                                <th class="text-center size-font-medium-small bg-deudauno">COMPRA TOTAL</th>                    
                                <th class="text-center size-font-medium-small bg-deudados">ABONOS</th>
                                <th class="text-center size-font-medium-small bg-deudados">FECHA</th>
                                <th class="text-center size-font-medium-small bg-deudados">FORMA DE PAGO</th>
                                <th class="text-center size-font-medium-small bg-deudados"># DE RECIBO</th>
                                <th class="text-center size-font-medium-small bg-deudados"># DOCUMENTO DE PAGO</th>                    
                                <th class="text-center size-font-medium-small bg-deudatres"># NOTA DE CRÉDITO</th>
                                <th class="text-center size-font-medium-small bg-deudatres">VALOR NOTA DE CRÉDITO</th>
                                <th class="text-center size-font-medium-small bg-deudatres">APLICADO A CFF:</th>
                                <th class="text-center size-font-medium-small bg-deudatres">FECHA</th>                    
                                <th class="text-center size-font-medium-small bg-deudacuatro">IMPORTE PENDIENTE</th>                    
                                <th class="text-center size-font-medium-small bg-deudacinco"># DE FACTURA</th>
                                <th class="text-center size-font-medium-small bg-deudacinco">FECHA DE PAGO</th>
                                <th class="text-center size-font-medium-small bg-deudacinco">PAGO APLICADO</th>
                                <th class="text-center size-font-medium-small bg-deudacinco"># DE RECIBO</th>
                                <th class="text-center size-font-medium-small bg-deudacinco">FORMA DE PAGO</th>
                                <th class="text-center size-font-medium-small bg-deudacinco"># DE DOCUMENTO DE PAGO</th>
                                <th class="text-center size-font-medium-small bg-deudacinco">DEUDA</th>
                            </thead>
                            <tbody  id="tbcontentdata">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
