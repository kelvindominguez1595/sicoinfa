@extends('layouts.dashboard')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2/select2-bootstrap-5-theme.min.css') }}">
@endsection
@section('js')
    <script src="{{ asset('js/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/pages/reportedeudas.js') }}"></script>
@endsection

@section('content')
    <div class="row mb-2 justify-content-md-center">

        <div class="col-xs-12 co-sm-12 col-md-9 col-lg-9 col-xl-6 ">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white ">
                    REPORTE DE DEUDAS
                </div>
                <div class="card-body">
                    <form  action="{{ url('/selectereportedeudas') }}" target="_blank"  method="get">
                        @csrf
         
            
                        <div class="row mb-3 d-flex justify-content-evenly">
                            <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                <label for="tiporeporte" class="form-label fw-bold">Seleccione Tipo de deuda </label>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input typereport" type="radio" name="reportetype" id="proveedornormal" value="proveedor" checked>
                                            <label class="form-check-label" for="proveedornormal">Proveedor </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input typereport" type="radio" name="reportetype" id="general" value="general">
                                            <label class="form-check-label" for="general">General </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                              <div class="col-12 col-sm-12 col-md-4 col-lg-4" >
                                <label for="tiporeporte" class="form-label fw-bold">Seleccione Estado de Deuda </label>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input typereport" type="radio" name="estadodeuda" id="creditoreporte" value="1" checked>
                                            <label class="form-check-label" for="creditoreporte">Crédito </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input typereport" type="radio" name="estadodeuda" id="pagadoreporte" value="2">
                                            <label class="form-check-label" for="pagadoreporte">Pagado </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3" id="contentproveedor">
                            <label for="proveedor_id" class="form-label fw-bold text-uppercase">Proveedor</label>
                            <select class="form-control" id="proveedor_id" name="proveedor_id"></select>
                        </div>


                
                        <hr>

                        <div class="row mb-3  justify-content-md-center">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                <label for="desde" class="form-label fw-bold">Desde</label>
                                <input type="date" name="desde" id="desde" class="form-control" >
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                <label for="hasta" class="form-label fw-bold">Hasta</label>
                                <input type="date" name="hasta" id="hasta" class="form-control" >
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 text-center">
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
 <hr>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 text-center ">
                                <button type="submit" class="btn btn-primary">Realizar Reporte</button>
                            </div>

                        </div>

                    </form>
                </div>
            </div>        

    </div> 
@endsection



