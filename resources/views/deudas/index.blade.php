@extends('layouts.dashboard')

@section('css')

@endsection
@section('js')
    <script src="{{ asset('js/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('js/pages/deudas.js') }}"></script>
@endsection

@section('content')
    <div class="row mb-2">
        {{-- columna 1  --}}
        <div class="col-xs-12 co-sm-12 col-md-3 col-lg-3 col-xl-3">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white">
                    Filtros de búsqueda
                </div>
                <div class="card-body">
                    <form action="" method="get" id="frmsearch">
                        <div class="mb-3 d-flex justify-content-center">
                            <button class="btn btn-primary btn-sm" type="button" id="btnresetall" onclick="$(location).attr('href','deudas');">Mostrar Todo</button>
                        </div>
                        <div class="col-12  mb-2">
                            <label for="nombressearch" class="form-label fw-bold">Nombres</label>
                            <input type="text" class="form-control" id="nombressearch" name="nombressearch" value="" placeholder="Nombres">
                        </div>
                        <div class="col-12  mb-2">
                            <label for="apellidossearch" class="form-label fw-bold">Apellidos</label>
                            <input type="text" class="form-control" id="apellidossearch" name="apellidossearch" value="" placeholder="Apellidos">
                        </div>
                        <div class="col-12  mb-2">
                            <label for="duisearch" class="form-label fw-bold">DUI</label>
                            <input type="text" class="form-control" id="duisearch" name="duisearch" value="" placeholder="DUI">
                        </div>
                        <div class="col-12 mb-2 " id="searchnit">
                            <label for="nitsearch" class="form-label fw-bold">NIT</label>
                            <input type="text" class="form-control" id="nitsearch" name="nitsearch" value="" placeholder="NIT">
                        </div>
                        <div class="col-12  mb-2">
                            <label for="telefonosearch" class="form-label fw-bold">Teléfono</label>
                            <input type="text" class="form-control" id="telefonosearch" name="telefonosearch" value="" placeholder="Teléfono">
                        </div>
                            <input type="hidden" id="frmsearchtype" name="frmsearchtype" value="1">
                        <div class="col-12  d-flex justify-content-center mb-2">
                            <button type="submit" class="btn btn-primary">Buscar <i class="fa fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- columna 2 --}}
        <div class="col-xs-12 co-sm-12 col-md-9 col-lg-9 col-xl-9">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <div class="">Deudas </div>
                    <a class="btn btn-light" href="{{ url('ingresardeudas') }}">Ingresar deudas</a>

                </div>
                <div class="card-body">


                    <div id="tblclientes"></div>

                </div>
            </div>
        </div>
    </div>
@endsection
