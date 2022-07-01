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
                <div class="card-body" id="tbcontentdata"></div>
            </div>
        </div>
    </div>
@endsection
