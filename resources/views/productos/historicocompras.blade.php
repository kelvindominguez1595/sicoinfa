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
                    <form action="{{ url('historialcompras')}}" method="get">
                        @csrf
                        <div class="mb-3 d-flex justify-content-center">
                            <button class="btn btn-primary btn-sm" type="button" id="btnresetall" onclick="$(location).attr('href','historialcompras');">Mostrar Todo</button>
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
                            <div class="col-12  mb-2">
                                <label for="proveedor" class="form-label fw-bold">Proveedor</label>
                                <input type="text" class="form-control" id="proveedor" name="proveedor" value="{{ $proveedor }}" placeholder="Nombre del proveedor">
                            </div>
                            <div class="col-12  mb-2">
                                <label for="credito" class="form-label fw-bold">Crédito Fiscal</label>
                                <input type="text" class="form-control" id="credito" name="credito" value="{{ $credito }}" placeholder="Crédito Fiscal">
                            </div>

                            <div class="col-12  mb-2">
                                <label for="desde" class="form-label fw-bold">Desde</label>
                                <input type="date" class="form-control" id="desde" name="desde" value="{{ $desde }}" placeholder="Crédito Fiscal">
                            </div>
                            <div class="col-12  mb-2">
                                <label for="hasta" class="form-label fw-bold">Hasta</label>
                                <input type="date" class="form-control" id="hasta" name="hasta" value="{{ $hasta }}" placeholder="Crédito Fiscal">
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
                </div>
            </div>
        </div>
        {{-- columna 2 --}}
        <div class="col-xs-12 co-sm-12 col-md-9 col-lg-9 col-xl-9">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <div class="">
                        HISTORICO DE COMPRAS
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-12">
                            <a href="{{ url('historialcompras?report=PDF&codigo='.$codigo.'&codbarra='.$codbarra.'&categoria='.$categoria.'&marca='.$marca.'&nombre='.$nombre.'&almacen='.$almacen.'&orderby='.$orderby.'&estado='.$estado.'&proveedor='.$proveedor.'&credito='.$credito.'&desde='.$desde.'&hasta='.$hasta) }}" target="_blank" class="btn btn-primary">PDF <i class="fas fa-file-pdf"></i></a>
                            <a href="{{ url('historialcompras?report=excel&codigo='.$codigo.'&codbarra='.$codbarra.'&categoria='.$categoria.'&marca='.$marca.'&nombre='.$nombre.'&almacen='.$almacen.'&orderby='.$orderby.'&estado='.$estado.'&proveedor='.$proveedor.'&credito='.$credito.'&desde='.$desde.'&hasta='.$hasta) }}" target="_blank" class="btn btn-success">Excel <i class="fas fa-file-excel"></i></a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <th class="small">CÓDIGO</th>
                                <th class="small">CATEGORÍA</th>
                                <th class="small">MARCA</th>
                                <th class="small">PRODUCTO</th>
                                <th class="small">PROVEEDOR</th>
                                <th class="small">CANTIDAD</th>
                                <th class="small">U. DE MEDIDA</th>
                                <th class="small">P. UNI. SIN IVA</th>
                                <th class="small">P. UNI. CON IVA</th>
                                <th class="small">ALMACÉN</th>
                                <th class="small">FECHA INGRESO</th>
                                <th class="small">CRÉDITO FISCAL</th>
                                <th class="small">FECHA FACTURA</th>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                    <tr>
                                        <td class="small">{{ $item->code }}</td>
                                        <td class="small">{{ $item->category_name }}</td>
                                        <td class="small">{{ $item->marca_name }}</td>
                                        <td class="small">{{ $item->name }}</td>
                                        <td class="small">{{ $item->cliente }}</td>
                                        <td class="small">{{ $item->cantidadnew }}</td>
                                        <td class="small">{{ $item->medida_name }}</td>
                                        @if (isset($item->costosiniva))
                                            <td class="small">${{ number_format($item->costosiniva, 4) }}</td>
                                            <td class="small">${{ number_format($item->costoconiva, 4) }}</td>
                                            @else
                                            <td class="small">${{ number_format($item->cost_s_iva, 4) }}</td>
                                            <td class="small">${{ number_format($item->cost_c_iva, 4) }}</td>
                                        @endif

                                        <td class="small">{{ $item->sucursal }}</td>
                                        <td class="small">{{ date('d-m-Y h:i:s A', strtotime($item->fechaingreso)) }}</td>
                                        <td class="small">{{ $item->nit }}</td>
                                        <td class="small">{{ date('d-m-Y', strtotime($item->fechafactura)) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                        <div class="d-flex justify-content-between">
                            <div>Mostrando {{ $data->firstItem() }}  a  {{ $data->lastItem() }} de {{ $data->total() }} registros.</div>
                            <div>
                            {{
                                $data->appends([
                                    'codigo' => $codigo,
                                    'codbarra' => $codbarra,
                                    'categoria' => $categoria,
                                    'marca' => $marca,
                                    'nombre' => $nombre,
                                    'almacen' => $almacen,
                                    'orderby' =>$orderby,
                                    'estado' => $estado,
                                    'pages' => $pages,
                                    'almaceneslist' => $almaceneslist,
                                    'proveedor' => $proveedor,
                                    'credito' => $credito,
                                    'desde' => $desde,
                                    'hasta' => $hasta,
                                ])
                            }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
