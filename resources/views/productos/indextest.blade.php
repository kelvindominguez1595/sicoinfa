@extends('layouts.dashboard')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2/select2-bootstrap-5-theme.min.css') }}">
@endsection
@section('js')
    <script src="{{ asset('js/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/pages/productosajax.js') }}"></script>
@endsection

@section('content')
    <div class="row mb-2">
        {{-- columna 1  --}}
        <div class="col-xs-12 co-sm-12 col-md-3 col-lg-3 col-xl-3">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white">
                    Filtros de búsqueda
                </div>
                {{-- <div class="card-body">
                            @if(Auth::user()->hasRole('Admin'))
                                <form action="{{ url('productos')}}" method="get">
                            @else
                                <form action="{{ url('inventarios')}}" method="get">
                            @endif
                                    @csrf
                                    <div class="mb-3 d-flex justify-content-center">
                                        @if(Auth::user()->hasRole('Admin'))
                                            <button
                                                class="btn btn-primary btn-sm"
                                                type="button"
                                                id="btnresetall"
                                                onclick="$(location).attr('href','productos?estado=activos&pages=25&page=1');">
                                                Mostrar Todo</button>
                                        @else
                                            <button
                                                class="btn btn-primary btn-sm"
                                                type="button"
                                                id="btnresetall"
                                                onclick="$(location).attr('href','inventarios?estado=activos&pages=25&page=1');">
                                                Mostrar Todo</button>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-12  mb-2">
                                            <label for="codigo" class="form-label fw-bold">Código</label>
                                            <input type="text" class="form-control" id="codigo" name="codigo" value="{{ $codigo }}" placeholder="Código">
                                        </div>
                                        <div class="col-12  mb-2">
                                            <label for="codbarra" class="form-label fw-bold">Código de Barra</label>
                                            <input type="text" class="form-control" id="codbarra" name="codbarra" value="{{ $codbarra }}" placeholder="Código de Barra">
                                        </div>
                                        <div class="col-12  mb-2">
                                            <label for="categoria" class="form-label fw-bold">Categoría</label>
                                            <input type="text" class="form-control" value="{{$categoria}}" placeholder="Categoría" name="categoria" id="categoria">
                                        </div>
                                        <div class="col-12  mb-2">
                                            <label for="marca" class="form-label fw-bold">Marca</label>
                                            <input type="text" class="form-control" value="{{$marca}}" placeholder="Marca" name="marca" id="marca">
                                        </div>
                                        <div class="col-12  mb-2">
                                            <label for="nombre" class="form-label fw-bold">Nombre del producto</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $nombre }}" placeholder="Nombre del producto">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12  mb-2">
                                            <label for="almacen" class="form-label fw-bold">Almacen</label>
                                            <select class="form-select"  id="almacen" name="almacen" data-almacen="{{$almacen}}">
                                                <option value="todos" @if($almacen=="todos") selected @endif>Todos</option>
                                                @foreach ($almaceneslist as $item)
                                                    <option value="{{ $item->id }}" @if($almacen==$item->id) selected @endif>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-12  mb-2">
                                            <label for="countpagination" class="form-label fw-bold">Cantidad por página</label>
                                            <select class="form-select"  id="pages" name="pages">
                                                <option value="25"  @if ($pages == 25) selected @endif>25</option>
                                                <option value="50"  @if ($pages == 50) selected @endif>50</option>
                                                <option value="100"  @if ($pages == 100) selected @endif>100</option>
                                            </select>
                                        </div>
                                        <div class="col-12  mb-2">
                                            <label for="estado" class="form-label fw-bold">Estado</label>
                                            <select class="form-select"  id="estado" name="estado">
                                                <option value="activos" @if ($estado == 'activos') selected @endif>Activos</option>
                                                <option value="inactivos" @if ($estado == 'inactivos') selected @endif>Inactivos</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 d-flex justify-content-center">
                                        <button class="btn btn-success" type="submit"><i class="fa fa-search"></i> Filtrar</button>
                                    </div>
                                </form>
                </div> --}}
            </div>
        </div>
        {{-- columna 2 --}}
        <div class="col-xs-12 co-sm-12 col-md-9 col-lg-9 col-xl-9">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between">

                    @if(Auth::user()->hasRole('Admin'))
                        <a class="btn btn btn-light btn-sm" href="{{ route('productos.create') }}">Nuevo Producto&nbsp;<i class="fa fa-save"></i></a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            @include('productos.partials.tabletitle')
                            </thead>
                            <tbody id="tblproductscontent">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
