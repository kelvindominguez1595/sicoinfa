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
        <input type="hidden" name="routepath" id="routepath" value="{{ Auth::user()->hasRole('Admin') ? 'loadproducts' : 'loadproductsclient' }}">
        <input type="hidden" name="routerlast" id="routerlast" value="{{ Auth::user()->hasRole('Admin') ? 'loadlastproduct' : 'no' }}">
        @include('productos.modals.images')
        {{-- columna 1  --}}
        <div class="col-xs-12 co-sm-12 col-md-3 col-lg-3 col-xl-3">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white">
                    Filtros de búsqueda
                </div>
                <div class="card-body">
                                <form  id="frmbusquedaproduct">
                                    @csrf
                                    <div class="mb-3 d-flex justify-content-center">
                                        <input type="hidden" name="router" id="router" value="{{Auth::user()->hasRole('Admin') ? 'loadproducts' : 'loadproductsclient'}}">
                                        <button
                                            class="btn btn-primary btn-sm"
                                            type="button"
                                            id="btnresetall"
                                            value="{{Auth::user()->hasRole('Admin') ? 'loadproducts' : 'loadproductsclient'}}"
                                        >
                                          Mostrar Todo
                                    </button>

                                    </div>
                                    <div class="row">
                                        <div class="col-12  mb-2">
                                            <label for="codigo" class="form-label fw-bold">Código</label>
                                            <input type="text" class="form-control" id="codigo" name="codigo" value="" placeholder="Código">
                                        </div>
                                        <div class="col-12  mb-2">
                                            <label for="codbarra" class="form-label fw-bold">Código de Barra</label>
                                            <input type="text" class="form-control" id="codbarra" name="codbarra" value="" placeholder="Código de Barra">
                                        </div>
                                        <div class="col-12  mb-2">
                                            <label for="categoria" class="form-label fw-bold">Categoría</label>
                                            <input type="text" class="form-control"  name="categoria" id="categoria" placeholder="Categoría">
                                        </div>
                                        <div class="col-12  mb-2">
                                            <label for="marca" class="form-label fw-bold">Marca</label>
                                            <input type="text" class="form-control" name="marca" id="marca" placeholder="Marca" >
                                        </div>
                                        <div class="col-12  mb-2">
                                            <label for="nombre" class="form-label fw-bold">Nombre del producto</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="Nombre del producto">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12  mb-2">
                                            <label for="almacen" class="form-label fw-bold">Almacen</label>
                                            <select class="form-select"  id="almacen" name="almacen">
                                                <option value="todos" >Todos</option>
                                                @foreach ($almaceneslist as $item)
                                                    <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-12  mb-2">
                                            <label for="countpagination" class="form-label fw-bold">Cantidad por página</label>
                                             <select class="form-select"  id="pages" name="pages">
                                                <option value="25" >25</option>
                                                <option value="50" >50</option>
                                                <option value="100" >100</option>
                                            </select>
                                        </div>
                                        <div class="col-12  mb-2">
                                            <label for="estado" class="form-label fw-bold">Estado</label>
                                            <select class="form-select"  id="estado" name="estado">
                                                <option value="activos">Activos</option>
                                                <option value="inactivos">Inactivos</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 d-flex justify-content-center">
                                        <button class="btn btn-success" type="submit"><i class="fa fa-search"></i> Filtrar</button>
                                    </div>
                                </form>
                </div>
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
                    <div id="contenpagination"></div>
                </div>
            </div>
        </div>
    </div>


    @if(Auth::user()->hasRole('Admin'))
    <div class="row mb-3">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white">
                    Últimos ingresos
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="table-utlimo-registro">
                            <thead>
                            <tr>
                                <th>N° Factura</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Fecha</th>
                            </tr>
                            </thead>
                            <tbody id="bodylast">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection
