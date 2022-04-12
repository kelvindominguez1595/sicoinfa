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
            <div class="card border-primary">
                <div class="card-header bg-primary text-white ">
                    REPORTE DE PRODUCTOS
                </div>
                <div class="card-body">

                        <form target="_blank" method="get" action="{{ url('/porcentajereporte') }}" >
                            @csrf
                            <div class="row mb-2">
                                <div class="col-12">
                                    <label for="tiporeporte" class="form-label fw-bold">Seleccione Formato </label>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input typereport" type="radio" name="tipoprint" id="pdf" value="pdf" checked>
                                                <label class="form-check-label" for="pdf">PDF <i class="text-primary fas fa-file-pdf"></i></label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input typereport" type="radio" name="tipoprint" id="excel" value="excel">
                                                <label class="form-check-label" for="excel">Excel <i class="text-success fas fa-file-excel"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr>
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

                            </div>
                            <hr>

                            <div class="row mb-3">

                                <div class="col-12">
                                    <label for="tiporeporte" class="form-label fw-bold">Ordernar Por</label>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="orderby" id="asc" value="ASC" checked>
                                                <label class="form-check-label" for="asc">A-Z</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="orderby" id="desc" value="DESC">
                                                <label class="form-check-label" for="desc">Z-A</label>
                                            </div>
                                        </div>
                                        <label for="tiporeporte" class="form-label fw-bold">Por Campo</label>
                                        <div class="col-12">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="campo" id="code" value="sk.code" >
                                                <label class="form-check-label " for="code">CÓDIGO</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="campo" id="codebarra" value="sk.barcode">
                                                <label class="form-check-label " for="codebarra">C. DE BARRA</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="campo" id="rcategoria" value="c.name">
                                                <label class="form-check-label " for="rcategoria">CATEGORIA</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="campo" id="rmarca" value="man.name">
                                                <label class="form-check-label " for="rmarca">MARCA</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="campo" id="rnombre" value="sk.name" checked>
                                                <label class="form-check-label " for="rnombre">NOMBRE</label>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <hr>

                            <div class="row mb-3  justify-content-md-center">
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <label for="desde" class="form-label fw-bold">Desde</label>
                                    <input type="date" name="desde" id="desde" class="form-control" required>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <label for="hasta" class="form-label fw-bold">Hasta</label>
                                    <input type="date" name="hasta" id="hasta" class="form-control" required>
                                </div>


                            </div>

                            <div class="row mb-2 ">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">Realizar Reporte</button>
                                </div>
                            </div>

                        </form>





                </div>
            </div>
        </div>
    </div>

    <div class="row " id="showresultcontent">
        <div class="col-12 mb-2 d-none"  id="tblsucontenedorexcel">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    RESULTADOS
                </div>
                <div class="card-body">
                    <div id="tblshow"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
