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
    @include('deudas.modals.showitem')
    <div class="row mb-2">
        <div class="d-flex justify-content-between">
            <div class="btn-group" role="group" aria-label="Basic outlined example">
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#nuevoModal">NUEVO</button>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#notacreditoModal">NOTA DE CRÉDITO</button>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#pagosModal">PAGOS</button>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#abonosModal">ABONOS</button>
              </div>
            <div>
                <a class="btn btn-primary" href="{{ url('/deudasreportes') }}">Reporte de Deudas</a>
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
                    <div class="row mb-2 ">

                            <form id="frmbusquedadeuda" class="row d-flex justify-content-end ">
                                <div class="col-3">
                                    <label for="">Proveedor</label>
                                    <input type="text" name="proveedorbuscar" id="proveedorbuscar" class="form-control">
                                </div>
                                <div class="col-3">
                                    <label for="">N° Factura</label>
                                    <input type="text" name="numfacturabuscar" id="numfacturabuscar" class="form-control">
                                </div>

                                <div class="col-2">
                                    <label for="">Estado de Deuda</label>
                                    <select name="estadofacturadeuda" id="estadofacturadeuda" class="form-select">
                                        <option value="0">TODOS</option>
                                        <option value="1">CRÉDITO</option>
                                        <option value="2">PAGADO</option>
                                    </select>
                                </div>

                                <div class="col-1 d-flex align-items-center">
                                    <button class="btn btn-primary" type="submit">Buscar Deuda</button>
                                </div>
                                <div class="col-1 d-flex align-items-center">
                                    <button class="btn btn-primary" id="mostrartododeuda" type="button">Mostrar Todo</button>
                                </div>
                            </form>

                    </div>
                    <div class="row">
                        <div  id="tbcontentdata"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
