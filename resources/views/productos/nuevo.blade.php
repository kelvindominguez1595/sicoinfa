@extends('layouts.dashboard')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2/select2-bootstrap-5-theme.min.css') }}">
@endsection
@section('js')
    <script src="{{ asset('js/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/pages/nuevoproducto.js') }}"></script>
@endsection

@section('content')
    <div class="row justify-content-md-center">
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8 ">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white">
                    Nuevo producto
                </div>
                <div class="card-body">
                    <form id="frmnuevo" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
                                <label for="codigo" class="form-label fw-bold">Código</label>
                                <input type="text" class="form-control" id="code" name="code" value="" placeholder="Código">
                                <div class="invalid-feedback " id="codemessage">Este campo es obligatorio *</div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
                                <label for="codigobarra" class="form-label fw-bold">Código de Barra</label>
                                <input type="text" class="form-control" id="codigobarra" name="codigobarra" value="" placeholder="Código de barra">
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
                                <label for="nombre" class="form-label fw-bold">Nombre del producto</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="Nombre del producto">
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
                                <label for="marca" class="form-label fw-bold">Marca</label>
                                <select name="marca" id="marca" class="form-select"></select>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
                                <label for="categoria" class="form-label fw-bold">Categoria</label>
                                <select name="categoria" id="categoria" class="form-select"></select>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
                                <label for="medidas" class="form-label fw-bold">Unidad de medida</label>
                                <select name="medidas" id="medidas" class="form-select"></select>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
                                <label for="codigo" class="form-label fw-bold">Categoria Categoria DET</label>
                                <select class="form-control save " name="category_det" aria-label="Default example">
                                    <option disabled>-- Elige una seccion --</option>
                                    <option selected value="1">Productos Terminados</option>
                                    <option value="2">Productos en Proceso</option>
                                    <option value="3">Materia Prima</option>
                                    <option value="4">Bien para la Construcción</option>
                                </select>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
                                <label for="codigo" class="form-label fw-bold">Referencia Libro DET</label>
                                <select class="form-control  save" name="reference_det" id="reference_det"
                                        aria-label="Default example">
                                    <option disabled>-- Elige una seccion --</option>
                                    <option value="1">Costos</option>
                                    <option value="2">Retaceos</option>
                                    <option selected value="3">Compras Locales</option>
                                </select>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="exentoiva" name="exentoiva">
                                    <label class="form-check-label fw-bold" for="exentoiva">
                                        Exento de IVA?
                                    </label>
                                </div>
                                <div class="mb-2 mt-2">
                                    <div class="d-flex justify-content-center mb-2" id="addimagen">
                                        <img src="{{asset('images/logoFerreteria.png')}}" class=" img-thumbnail" width="100px" height="100px" id="imagenmuestra">
                                    </div>
                                    <input type="file" class="form-control save" id="imagen" name="imagen" accept=".jpg, .jpeg, .png">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex justify-content-center">
                                <button class="btn btn-primary" type="submit">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
