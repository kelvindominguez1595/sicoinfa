@extends('layouts.dashboard')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2/select2-bootstrap-5-theme.min.css') }}">
@endsection
@section('js')
    <script src="{{ asset('js/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/pages/filterproductos.js') }}"></script>
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
                    <form action="{{ route('productos.index')}}" method="get">

                    </form>
                </div>
            </div>
        </div>
        {{-- columna 2 --}}
        <div class="col-xs-12 co-sm-12 col-md-9 col-lg-9 col-xl-9">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <div class="">

                    </div>
                    <a class="btn btn btn-light btn-sm" href="{{ route('productos.create') }}">Nuevo Producto&nbsp;<i class="fa fa-save"></i></a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <th class="small">Código</th>
                                <th class="small">Fecha</th>
                                <th class="small">C. de Barra</th>
                                <th class="small">Categoría</th>
                                <th class="small">Marca</th>
                                <th class="small">Nombre</th>
                                <th class="small">Cantidad</th>
                                <th class="small">Costo</th>
                                <th class="small">Total de Compra</th>
                                <th class="small">P. Venta</th>
                                <th class="small">Venta Total</th>
                                <th class="small">% Diferencia</th>
                                <th class="small">Diferencia Unitaria</th>
                                <th class="small">Utilidad Total</th>
                            </thead>

                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-between">
{{--                            <div>Mostrando {{ $data->firstItem() }}  a  {{ $data->lastItem() }} de {{ $data->total() }} registros.</div>--}}
                            <div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
