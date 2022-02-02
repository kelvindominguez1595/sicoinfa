@extends('layouts.dashboard')

@section('css')
@endsection

@section('js')
    <script src="{{ asset('js/pages/proveedores.js') }}"></script>
@endsection

@section('content')
    @include('proveedores.modals.modal')

    <div class="row justify-content-center">
        <div class="col col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white">
                    Filtros de búsqueda
                </div>
                <div class="card-body">
                    <form action="{{ route('proveedores.index')}}" method="get">
                        @csrf
                        <div class="mb-3 d-flex justify-content-center">
                            <button class="btn btn-primary btn-sm" type="button" id="btnresetall" onclick="$(location).attr('href','proveedores');">Mostrar Todo</button>
                        </div>
                        <div class="row">
                            <div class="col-12  mb-2">
                                <label for="proveedor" class="form-label fw-bold">Proveedor</label>
                                <input type="text" class="form-control" id="proveedor" name="proveedor" autocomplete="false" value="{{ $proveedor }}" placeholder="Proveedor">
                            </div>
                            <div class="col-12  mb-2">
                                <label for="negocio" class="form-label fw-bold">Negocio</label>
                                <input type="text" class="form-control" id="negocio" name="negocio" autocomplete="false" value="{{ $negocio }}" placeholder="Negocio">
                            </div>
                            <div class="col-12  mb-2">
                                <label for="nombre" class="form-label fw-bold">Giro</label>
                                <input type="text" class="form-control" id="giro" name="giro" autocomplete="false" value="{{ $giro }}" placeholder="Giro">
                            </div>
                            <div class="col-12  mb-2">
                                <label for="nit" class="form-label fw-bold">NIT</label>
                                <input type="text" class="form-control" id="nit" name="nit" autocomplete="false" value="{{ $nit }}" placeholder="NIT">
                            </div>
                            <div class="col-12  mb-2">
                                <label for="registro" class="form-label fw-bold">N. Registro</label>
                                <input type="text" class="form-control" id="registro" name="registro" autocomplete="false" value="{{ $registro }}" placeholder="N. Registro">
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
                                    <option value="activos" @if ($estado == '1') selected @endif>Activos</option>
                                    <option value="inactivos" @if ($estado == '2') selected @endif>Inactivos</option>
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
        <div class="col col-sm-12 col-md-9 col-lg-9 col-xl-9">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white">
                    Proveedores
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <button type="button" class="btn btn-primary" id="btnnuevo" >
                            <i class="fas fa-plus"></i>
                            Crear Proveedor
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>PROVEEDOR</th>
                                <th>NEGOCIO</th>
                                <th>GIRO</th>
                                <th>NIT</th>
                                <th>N° REGISTRO</th>
                                <th colspan="4" class="text-center">OPCIONES</th>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                    <tr >
                                        <td>{{ $item->cliente }}</td>
                                        <td>{{ $item->nombre_comercial }}</td>
                                        <td>{{ $item->giro }}</td>
                                        <td>{{ $item->nit }}</td>
                                        <td>{{ $item->num_registro }}</td>
                                        <td class="text-center"><button value="{{ $item->id }}" id="btndesactiva" class="btn btn-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Desactivar el proveedor"> <i class="fas fa-low-vision"></i> </button></td>
                                        <td class="text-center"><button value="{{ $item->id }}" id="btneditar" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar el proveedor"> <i class="fas fa-edit"></i> </button></td>
                                        <td class="text-center"><button value="{{ $item->id }}" id="btnborrar" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Borrar el proveedor"> <i class="fas fa-trash-alt"></i> </button></td>
                                        <td class="text-center"><button value="{{ $item->id }}" id="btnver" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver datos del proveedor"> <i class="fas fa-book-reader"></i> </button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-between">
                            <div>Mostrando {{ $data->firstItem() }}  a  {{ $data->lastItem() }} de {{ $data->total() }} registros.</div>
                            <div>
                                {!! $data->appends([
                                        'proveedor' => $proveedor,
                                        'negocio' => $negocio,
                                        'giro' => $giro,
                                        'nit' => $nit,
                                        'registro' => $registro,
                                        'pages' => $pages,
                                        'estado' => $estado,
                                ]) !!}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
