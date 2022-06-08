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
    @include('deudas.modals.abonos')
    @include('deudas.modals.nota')
    @include('deudas.modals.nuevo')
    @include('deudas.modals.pagos')
    <div class="row mb-2">
        <div class="col-12">
            <div class="btn-group" role="group" aria-label="Basic outlined example">
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#nuevo">NUEVO</button>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#notacredito">NOTA DE CRÉDITO</button>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#pagos">PAGOS</button>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#abonos">ABONOS</button>
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
                    <div class="table-responsive" id="tbcontentdata"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
