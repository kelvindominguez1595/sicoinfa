@extends('layouts.dashboard')

@section('css')

@endsection
@section('js')
    <script src="{{ asset('js/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('js/pages/usuarios.js') }}"></script>
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
                            <button class="btn btn-primary btn-sm" type="button" id="btnresetall" onclick="$(location).attr('href','usuarios');">Mostrar Todo</button>
                        </div>

                        <div class="col-12  mb-2">
                            <label for="namesearch" class="form-label fw-bold">Nombre</label>
                            <input type="text" class="form-control" id="namesearch" name="namesearch" value="" placeholder="Nombre">
                        </div>

                        <div class="col-12  mb-2">
                            <label for="emailsearch" class="form-label fw-bold">Usuario</label>
                            <input type="text" class="form-control" id="emailsearch" name="emailsearch" value="" placeholder="Usuario">
                        </div>

                        <div class="col-12  mb-2">
                            <label for="almacensearch" class="form-label fw-bold">Almacen</label>
                            <select class="form-select" id="almacensearch" name="almacensearch">
                                @foreach($sucursal as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
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
                    <div class="">Usuarios </div>
                    <button type="button" class="btn btn-light" id="btnnuevo">
                        Nuevo  <i class="fa fa-save"></i>
                    </button>
                </div>
                <div class="card-body">
                    @include('usuarios.partials.nuevo')
                    <div id="tblclientes"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
