@extends('layouts.dashboard')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2/select2-bootstrap-5-theme.min.css') }}">
@endsection
@section('js')
    <script src="{{ asset('js/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/pages/empleado.js') }}"></script>

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
                    <form action="{{ url('inventarios')}}" method="get">
                        @csrf
                        <div class="mb-3 d-flex justify-content-center">
                            <button class="btn btn-primary btn-sm" type="button" id="btnresetall" onclick="$(location).attr('href','inventarios');">Mostrar Todo</button>
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
                </div>
            </div>
        </div>
        {{-- columna 2 --}}
        <div class="col-xs-12 co-sm-12 col-md-9 col-lg-9 col-xl-9">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <div class="">
                        {{ $data->total() }} Resultados
                    </div>
                    @can('manufacturer.create')
                        <a class="btn btn btn-light btn-sm" href="{{ route('ingresos.create') }}">Nuevo Producto&nbsp;<i class="fa fa-save"></i></a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <th class="small">Código</th>
                            <th class="small">Código de Barra</th>
                            <th class="small">Categoria</th>
                            <th class="small">Marca</th>
                            <th class="small">Nombre</th>
                            <th class="small">Cantidad</th>
                            <th class="small">Unidad</th>
                            <th class="small">P/Venta</th>
                            <th class="small">Costo</th>
                            <th class="small">Imagen</th>

                            </thead>

                            <tbody>
                            @if (count($data)<=0) <tr>
                                <td colspan="11">No hay resultados</td>
                            </tr>
                            @else

                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="small">{{ $item->code }}</td>
                                            <td class="small">{{ $item->barcode }}</td>
                                            <td class="small">{{ $item->category_name }}</td>
                                            <td class="small">{{ $item->marca_name }}</td>
                                            <td class="small">
                                                {!! $item->name !!}
                                            </td>
                                            <td class="small">{{ $item->quantity }}</td>
                                            <td class="small"> {{ $item->medida_name }}</td>
                                            <td class="small">
                                                <!-- precionuevo -->
                                                @isset($item->description)
                                                    <a
                                                        href="#"
                                                        tabindex="0"
                                                        role="button"
                                                        data-bs-placement="left"
                                                        data-bs-toggle="popover"
                                                        data-bs-trigger="hover focus"
                                                        title="Detalles"
                                                        data-bs-html="true"
                                                        data-bs-content='<div><?php echo $item->description ?></div>'
                                                    >
                                                        @isset($item->precionuevo)
                                                            ${{number_format($item->precionuevo,2)}}
                                                        @else
                                                            ${{number_format($item->precioventa,2)}}
                                                        @endisset
                                                    </a>
                                                @else
                                                    @isset($item->precionuevo)
                                                        ${{number_format($item->precionuevo,2)}}
                                                    @else
                                                        ${{number_format($item->precioventa,2)}}
                                                    @endisset
                                                @endisset

                                            </td>
                                            <td class="text-center">
                                                @if(isset($item->costonuevo))
                                                    @php $costo = number_format($item->costonuevo,4); @endphp
                                                    <a
                                                        href="#"
                                                        tabindex="0"
                                                        role="button"
                                                        data-bs-placement="left"
                                                        data-bs-toggle="popover"
                                                        data-bs-trigger="hover focus"
                                                        title="Costo (IVA Incluido)"
                                                        data-bs-html="true"
                                                        data-bs-content='<div> ${{ $costo }}</div>'
                                                    >
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @elseif(isset($item->costosiniva))
                                                    @php $costo = number_format($item->costosiniva,4); @endphp
                                                    <a
                                                        href="#"
                                                        tabindex="0"
                                                        role="button"
                                                        data-bs-placement="left"
                                                        data-bs-toggle="popover"
                                                        data-bs-trigger="hover focus"
                                                        title="Costo (IVA Incluido)"
                                                        data-bs-html="true"
                                                        data-bs-content='<div> ${{ $costo }}</div>'
                                                    >
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @else
                                                    $0.00
                                                @endisset
                                            </td>
                                            <td width="20px">
                                                @php
                                                    $imagen='';
                                                    if ($item->image) {
                                                    $imagen = '<img class="imgzoom" src="/images/productos/' . $item->image . '" width="20px"
                                                        height="20px" />';
                                                    } else {
                                                    $imagen = '<div class="masonry-thumbs grid-container grid-5" data-big="2"
                                                        data-lightbox="gallery"></div>';
                                                    }
                                                @endphp
                                                {!! $imagen !!}
                                            </td>
                                        </tr>
                                    @endforeach

                            @endif
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-between">
                            <div>Mostrando {{ $data->firstItem() }}  a  {{ $data->lastItem() }} de {{ $data->total() }} registros.</div>
                            <div>
                                {!!
                                 $data->appends([
                                    'estado'=> $estado,
                                    'codigo'=> $codigo,
                                    'codbarra'=> $codbarra,
                                    'categoria'=> $categoria,
                                    'marca'=> $marca,
                                    'nombre'=> $nombre,
                                    'almacen'=> $almacen,
                                    'pages'=> $pages,
                                 ])

                                 !!}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
