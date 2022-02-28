@extends('layouts.dashboard')

@section('css')

@endsection
@section('js')
    <script src="{{ asset('js/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('js/pages/empleados.js') }}"></script>
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
                            <button class="btn btn-primary btn-sm" type="button" id="btnresetall" onclick="$(location).attr('href','empleados');">Mostrar Todo</button>
                        </div>
                        <div class="col-12  mb-2">
                            <label for="codigosearch" class="form-label fw-bold">Código</label>
                            <input type="text" class="form-control" id="codigosearch" name="codigosearch" value="" placeholder="Código">
                        </div>
                        <div class="col-12  mb-2">
                            <label for="first_namesearch" class="form-label fw-bold">Nombres</label>
                            <input type="text" class="form-control" id="first_namesearch" name="first_namesearch" value="" placeholder="Nombres">
                        </div>
                        <div class="col-12  mb-2">
                            <label for="last_namesearch" class="form-label fw-bold">Apellidos</label>
                            <input type="text" class="form-control" id="last_namesearch" name="last_namesearch" value="" placeholder="Apellidos">
                        </div>
                        <div class="col-12  mb-2">
                            <label for="emailsearch" class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control" id="emailsearch" name="emailsearch" value="" placeholder="Email">
                        </div>
                        <div class="col-12  mb-2">
                            <label for="duisearch" class="form-label fw-bold">DUI</label>
                            <input type="text" class="form-control" id="duisearch" name="duisearch" value="" placeholder="DUI">
                        </div>
                        <div class="col-12 mb-2">
                            <label for="nitsearch" class="form-label fw-bold">NIT</label>
                            <input type="text" class="form-control" id="nitsearch" name="nitsearch" value="" placeholder="NIT">
                        </div>

                        <div class="col-12 mb-2 ">
                            <label for="nupsearch" class="form-label fw-bold">NUP</label>
                            <input type="text" class="form-control" id="nupsearch" name="nupsearch" value="" placeholder="NUP">
                        </div>
                        <div class="col-12 mb-2 ">
                            <label for="issssearch" class="form-label fw-bold">ISSS</label>
                            <input type="text" class="form-control" id="issssearch" name="issssearch" value="" placeholder="ISSS">
                        </div>
                        <div class="col-12  mb-2">
                            <label for="phonesearch" class="form-label fw-bold">Teléfono</label>
                            <input type="text" class="form-control" id="phonesearch" name="phonesearch" value="" placeholder="Teléfono">
                        </div>
                        <div class="col-12  mb-2">
                            <label for="statesearch" class="form-label fw-bold">Estado</label>
                            <select class="form-select" id="statesearch" name="statesearch">
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>

                        </div>

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
                    <div class="">Empleados </div>
                    <button type="button" class="btn btn-light" id="btnnuevo">
                        Nuevo  <i class="fa fa-save"></i>
                    </button>
                </div>
                <div class="card-body">
                    @include('empleados.partials.nuevo')
                    <div id="tblclientes"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
