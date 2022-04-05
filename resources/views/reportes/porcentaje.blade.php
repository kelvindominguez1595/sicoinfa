@extends('layouts.dashboard')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2/select2-bootstrap-5-theme.min.css') }}">
@endsection
@section('js')
    <script src="{{ asset('js/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/pages/porcentajes.js') }}"></script>
@endsection

@section('content')
    <div class="row mb-2 justify-content-md-center">

        <div class="col-xs-12 co-sm-12 col-md-6 col-lg-6 col-xl-6 ">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white ">
                    REPORTE DE PORCENTAJES
                </div>
                <div class="card-body">
                    <form id="" method="get" action="{{ url('porcentajereporte') }}">
                        @csrf
                        <div class="row mb-3">

                            <div class="col-4">
                                <label for="tiporeporte" class="form-label fw-bold">Seleccione Tipo de Reporte</label>
                                <select name="tiporeporte" id="tiporeporte" class="form-select">
                                    <option value="all">Todos</option>
                                    <option value="marca">Marca</option>
                                    <option value="categoria">Categorias</option>
                                </select>
                            </div>

                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 d-none" id="contentcategoria">
                                <label for="categoria" class="form-label fw-bold">Categoria Producto</label>
                                <select  class="form-control mb-1 edit" name="categoria" id="categoria"></select>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 d-none" id="contentmarcar">
                                <label for="categoria" class="form-label fw-bold">Marca</label>
                                <select class="form-control"  name="marca" id="marca"></select>
                            </div>

                            <div class="col-4">
                                <label for="tiporeporte" class="form-label fw-bold">Ordernar Por</label>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="orderby" id="inlineRadio1" value="ASC" checked>
                                            <label class="form-check-label fw-bold" for="inlineRadio1">A-Z</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="orderby" id="inlineRadio2" value="DESC">
                                            <label class="form-check-label fw-bold" for="inlineRadio2">Z-A</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                <label for="desde" class="form-label fw-bold">Desde</label>
                                <input type="date" name="desde" id="desde" class="form-control">
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                <label for="hasta" class="form-label fw-bold">Hasta</label>
                                <input type="date" name="hasta" id="hasta" class="form-control">
                            </div>
                            <div class="col-4">
                                <label for="tiporeporte" class="form-label fw-bold">Tipo</label>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="tipoprint" id="inlineRadio1" value="pdf" checked>
                                            <label class="form-check-label fw-bold" for="inlineRadio1">PDF</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="tipoprint" id="inlineRadio2" value="excel">
                                            <label class="form-check-label fw-bold" for="inlineRadio2">Excel</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2 ">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary">Imprimir</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="tblshow">

    </div>
@endsection
