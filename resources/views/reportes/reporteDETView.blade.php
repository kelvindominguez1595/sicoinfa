@extends('layouts.dashboard')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2/select2-bootstrap-5-theme.min.css') }}">
@endsection
@section('js')
    <script src="{{ asset('js/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/pages/reportDet.js') }}"></script>
@endsection

@section('content')
    <div class="row mb-2 justify-content-md-center">

        <div class="col-xs-12 co-sm-12 col-md-6 col-lg-6 col-xl-6 ">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white ">
                    REPORTE DE DET
                </div>
                <div class="card-body">

                    <form target="_blank" method="get" action="{{ url('/reporteDET') }}" >
                        @csrf
                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <label for="tiporeporte" class="form-label fw-bold">Seleccione Formato </label>
                                <div class="row">
                                    <div class="col-12 text-center">
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

                        <div class="row mb-3">
                            <div class="col-12  ">
                                <div class="form-check  justify-content-md-center">
                                    <input class="form-check-input" type="checkbox" value="" id="updateyear">
                                    <label class="form-check-label" for="updateyear">
                                        ¿Desea Generar un reporte DET de un Año Diferente?
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center mb-3 d-none"  id="contentyear">

                                <div class="col-2 ">
                                    <label>Escriba el Año</label>
                                    <input type="number" name="year" id="year" class="form-control" min="2019">
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

@endsection
