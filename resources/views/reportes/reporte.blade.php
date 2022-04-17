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

        <div class="col-xs-12 co-sm-12 col-md-9 col-lg-9 col-xl-6 ">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white ">
                    REPORTE DE PRODUCTOS
                </div>
                <div class="card-body">

                        <form method="get" action="{{ url('/porcentajereporte') }}" >
                            @csrf

                            <div id="row mb-2">
                                <div class="text-center">
                                    <label for="tiporeporte" class="form-label fw-bold">Seleccione Tipo de Reporte</label>
                                    @if (count($errors) > 0)
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                <div class="row">
                                    @for ($i = 0; $i < count($type_report); $i++)
                                        <div class="col-5">
                                            <div class="form-check ">
                                                <input class="form-check-input type_report" type="radio" name="tipo_de_reporte" id="type_report{{ $type_report[$i]['name'] }}" value="{{ $type_report[$i]['name'] }}" >
                                                <label class="form-check-label " for="type_report{{ $type_report[$i]['name'] }}">{{ $type_report[$i]['name'] }}</label>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>

                            <hr>

                            <div class="row mb-3">
                                <div class="col-12 text-center">
                                    <label for="" class="form-label fw-bold">Filtrar por</label>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 mb-2">
                                    <label for="" class="form-label fw-bold">Seleccione</label>
                                    <select name="tiporeporte" id="tiporeporte" class="form-select">
                                        <option value="all">Todos</option>
                                        <option value="marca">Marca</option>
                                        <option value="categoria">Categorias</option>
                                    </select>
                                </div>

                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 mb-2 d-none" id="contentcategoria">
                                    <label for="categoria" class="form-label fw-bold">Categoria Producto</label>
                                    <select  class="form-control mb-1 edit" name="categoria" id="categoria"></select>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 mb-2 d-none" id="contentmarcar">
                                    <label for="categoria" class="form-label fw-bold">Marca</label>
                                    <select class="form-control"  name="marca" id="marca"></select>
                                </div>

                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl- mb-2">
                                    <label for="" class="form-label fw-bold">Código</label>
                                    <input type="text" class="form-control" id="codigotxt" name="codigotxt">
                                </div>

                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl- mb-2">
                                    <label for="" class="form-label fw-bold">Código de Barra</label>
                                    <input type="text" class="form-control" id="codigobarratxt" name="codigobarratxt">
                                </div>
                            </div>

                            <hr>

                            <div class="row mb-3">

                                <div class="col-12">
                                    <label for="tiporeporte" class="form-label fw-bold">Ordenar Por</label>
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

                                            @for ($i = 0; $i < count($order); $i++)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="campo" id="code{{ $order[$i]['name'] }}" value="{{ $order[$i]['val'] }}" @if($order[$i]['name'] == 'NOMBRE') CHECKED @endif>
                                                    <label class="form-check-label " for="code{{ $order[$i]['name'] }}">{{ $order[$i]['name'] }}</label>
                                                </div>
                                            @endfor

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <hr>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="tiporeporte" class="form-label fw-bold">Visibilidad de campos</label>
                                    <div class="row">

                                            @foreach($title as $item)
                                                @php
                                                    $limpiar = str_replace(' ', '', $item);
                                                    $per = str_replace('%', '', $limpiar);
                                                    $name = str_replace('/', '', $per);
                                                @endphp
                                                <div class="col-3">
                                                    <div class="form-check ">
                                                        <input class="form-check-input" type="checkbox" name="visibility[]" id="{{ $name }}" value="{{$item}}">
                                                        <label class="form-check-label size-font-long-small" for="{{ $name }}">{{$item}}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                    </div>
                                </div>
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

                                <div class="col-12 col-sm-12 col-md-4 col-lg-4">
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

                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 text-center d-flex align-items-center">
                                    <button type="submit" class="btn btn-primary">Realizar Reporte</button>
                                </div>

                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 text-center d-flex align-items-center">
                                    <button type="submit" class="btn btn-primary" value="det">REPORTE DET</button>
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
