@extends('layouts.dashboard')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2/select2-bootstrap-5-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('trumbowyg/css/ui/trumbowyg.css') }}">
    <link rel="stylesheet" href="{{ asset('trumbowyg/plugins/colors/ui/trumbowyg.colors.min.css') }}">
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <div class="card border-primary mb-4">
                <div class="card-header text-white bg-primary">
                    <a href="{{ url()->previous() }}" class="btn btn-link text-white"> < Volver</a>
                    Modifica un producto
                </div>
                <div class="card-body">
                <!-- <form action="{{route('productos.update',[$id])}}" id="frmupdate" method="POST" enctype="multipart/form-data"> -->
                    <form  id="frmupdate" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="stocks_id" id="stocks_id" value="{{$id}}">
                        <div class="row mb-3">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <label for="categoria" class="fw-bold">Categoria Producto</label>
                                <select data-categoryid="{{ $stock->category_id }}" class="form-control mb-1 edit" name="category_id" id="category_id"></select>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <label for="categoria" class="fw-bold">Marca</label>
                                <select class="form-control" data-maracid="{{ $stock->manufacturer_id }}" name="manufacturer_id" id="manufacturer_id"></select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <label for="codigo" class="fw-bold">Código</label>
                                <input type="text" class="form-control edit" name="code" id="code" value="{{$stock->code}}" placeholder="Código" required>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <label for="unidaddemedida" class="fw-bold">Unidad de Medida</label>
                                <select class="form-control measures_id " data-unidamedida="{{ $stock->measures_id }}" name="measures_id" id="measures_id"></select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <label for="codigobarra" class="fw-bold">Código de barra</label>
                                <input type="text" class="form-control edit" name="barcode" id="barcode" value="{{ $stock->barcode }}" placeholder="Código barra" >
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <label for="categoria" class="fw-bold">Categoria DET</label>
                                <select class="form-control" name="category_det" id="category_det">
                                    <option disabled>-- Elige una seccion --</option>
                                    <option selected value="1">Productos Terminados</option>
                                    <option value="2">Productos en Proceso</option>
                                    <option value="3">Materia Prima</option>
                                    <option value="4">Bien para la Construcción</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <label for="categoria" class="fw-bold">Descripción</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ $stock->name }}">
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <label for="categoria" class="fw-bold">Referencia Libro DET</label>
                                <select class="form-control"  name="reference_det" id="reference_det">
                                    <option disabled>-- Elige una seccion --</option>
                                    <option value="1">Costos</option>
                                    <option value="2">Retaceos</option>
                                    <option selected value="3">Compras Locales</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <label for="categoria" class="fw-bold">Detalles</label>
                                <textarea  name="editor"  id="editor" rows="3" class="form-control">{!! $stock->description !!}</textarea>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <label for="categoria" class="fw-bold">Stock Minimo</label>
                                <input type="number" name="stock_min_pro" value="{{ $detalle_pro->quantity ?? 1}}" class="form-control" id="stock_min_pro" min="0">
                                <div class="mt-2 mb-2">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="state" id="state" value="1"  @if ($stock->state) checked @endif> Producto Activo
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="exempt_iva" id="exempt_iva" value="1" @if ($stock->exempt_iva) checked @endif> Exento IVA?
                                    </label>
                                </div>
                                <div class="" id="imagecontainer">
                                    <div class="d-flex justify-content-center mb-2" id="addimagen">

                                        @if (!empty($stock->image))
                                            <img src="{{asset("images/productos/{$stock->image}")}}" class=" img-thumbnail" width="100px" height="100px" id="imagenmuestra">
                                        @else
                                            <img src="{{asset('images/logoFerreteria.png')}}" class=" img-thumbnail" width="100px" height="100px" id="imagenmuestra">
                                        @endif
                                    </div>
                                    <input class="form-control"  type="file" name="imagen" id="imagen"  accept=".jpg, .jpeg, .png">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            @php
                                // echo $detalle_price->detalle_stock_id;
                                    $preciosiniva = 0;
                                    $precioconiva = 0;
                                    $ganancia = 0;
                                    $porcentaje = 0;
                                    $preciofinal = 0;
                                    $veralerta = false;
                                    if(isset($detalle_price->detalle_stock_id)){
                                        $preciosiniva = $detalle_price->cost_s_iva;
                                        if(empty($detalle_price->cost_c_iva))  {
                                            $precioconiva = $preciosiniva + ($preciosiniva * 0.13);
                                        } else {
                                            $precioconiva = $detalle_price->cost_c_iva;
                                        }

                                        $ganancia = $detalle_price->earn_c_iva;
                                        $porcentaje = $detalle_price->earn_porcent;
                                        $preciofinal = $detalle_price->sale_price;
                                        $veralerta = false;
                                    } else {
                                        if(isset($detalle_stock->unit_price)){
                                            $preciosiniva = $detalle_stock->unit_price;
                                            $precioconiva = $preciosiniva + ($preciosiniva * 0.13);
                                            $veralerta = true;
                                        } else {
                                            $preciosiniva = 0;
                                            $precioconiva = 0;
                                            $veralerta = false;
                                        }
                                        $ganancia = 0;
                                        $porcentaje = 0;
                                        $preciofinal = 0;

                                    }
                            @endphp
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <label for="categoria" class="fw-bold">Costo del producto (SIN IVA) </label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text fw-bold" id="basic-addon1">$</span>
                                    <input type="number" min="0" step="any" class="form-control" name="cost_s_iva" id="cost_s_iva" readonly value="{{number_format($preciosiniva, 4)}}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <label for="categoria" class="fw-bold">Costo del Producto (IVA INCLUIDO)</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text fw-bold" id="basic-addon1">$</span>
                                    <input type="number" min="0" step="any" class="form-control " name="cost_c_iva" id="cost_c_iva" readonly  value="{{number_format($precioconiva, 4)}}" data-iva="13">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="alert alert-danger d-none" role="alert" id="messagedanger">
                                    <i class="fas fa-info-circle"></i> El costo del producto ah cambiado por favor verificar el precio de venta al consumidor final.
                                </div>
                                @if($veralerta)
                                    <div class="alert alert-danger" role="alert">
                                        <i class="fas fa-info-circle"></i> El costo del producto ah cambiado por favor verificar el precio de venta al consumidor final.
                                    </div>

                                @endif
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <div class="row">
                                    <div class="col">
                                        <label for="categoria" class="fw-bold">Ganancia (IVA INCLUIDO)</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text fw-bold" id="basic-addon1">$</span>
                                            <input type="number" min="0" step="any" class="form-control " name="earn_c_iva" id="earn_c_iva" value="{{ number_format($ganancia, 4) }}">
                                        </div>
                                    </div>

                                    <div class="col">
                                        <label for="categoria" class="fw-bold">Porcentaje de Ganancia</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text fw-bold" id="basic-addon1">%</span>
                                            <input type="number" min="0" step="any" class="form-control " name="earn_porcent" id="earn_porcent" value="{{$porcentaje}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <label for="categoria" class="fw-bold">Precio de Venta a Consumidor (IVA INCLUIDO)</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text fw-bold" id="basic-addon1">$</span>
                                    <input type="number" min="0" step="any" class="form-control" name="sale_price" id="sale_price"  value="{{$preciofinal}}">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-edit"></i> Modificar Producto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border-primary mb-4">
                <div class="card-header text-white bg-primary">Entrada de producto</div>
                <div class="card-body">
                <!-- <form action="{{ route('ingresos.store') }}"  method="POST"> -->
                    <form id="frmentradaproductos"  method="POST">
                        @csrf
                        <input type="hidden" name="stocks_id" id="stocks_id" value="{{$id}}">
                        <div class="row mb-3">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <label for="categoria" class="fw-bold">Elige la Empresa Proveedora</label>
                                @php
                                    $proveedor = 0;
                                    if(isset($detalle_stock->clientefacturas_id)){
                                        $proveedor = $detalle_stock->clientefacturas_id;
                                    } else {
                                        $proveedor = 0;
                                    }
                                @endphp
                                <select class="form-control @error('suppliers_id') is-invalid @enderror" data-idproveedor="{{$proveedor}}" name="suppliers_id" id="suppliers_id"></select>
                                <div class="invalid-feedback ">Este campo es obligatorio *</div>
                                @error('suppliers_id')
                                <div class="invalid-feedback d-block">Este campo es obligatorio *</div>
                                @enderror
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <label for="categoria" class="fw-bold">Número Credito Fiscal</label>
                                <input type="text" class="form-control" name="invoice_number"
                                       id="invoice_number" value="{{$detalle_stock2->invoice_number}}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <label for="codigo" class="fw-bold">Elige el Almacen a ingresar</label>
                                <select class="form-control" name="branch_offices_id" id="branch_offices_id" data-branchoffice="{{$detalle_pro->branch_offices_id}}"></select>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                        <label for="unidaddemedida" class="fw-bold">Fecha de Factura</label>
                                        <input type="date" class="form-control" name="invoice_date" id="invoice_date" value="{{$detalle_stock2->invoice_date}}">
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                        <label for="categoria" class="fw-bold">Fecha de Ingreso</label>
                                        <input type="datetime-local" class="form-control" name="register_date" id="register_date">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <label for="cantidad" class="fw-bold">Cantidad</label>
                                <input type="number" class="form-control" name="quantity" id="quantity" min="0" value="0">
                            </div>
                        <!-- <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                            <label for="unidaddemedida" class="fw-bold">Unidad de Medida</label>
                            <select class="form-control measures_id " data-unidamedida="{{ $stock->measures_id }}" name="measures_id" id="measures_id"></select>
                        </div> -->

                            {{-- <div class="col">
                                <label for="measures_id" class="fw-bold">Unidad de Medida</label>
                                <select class="form-control measures_id" data-unidamedida="{{ $stock->measures_id }}" name="measures_id" id="measures_id"></select>
                            </div> --}}
                        </div>

                        <div class="row mb-3">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <label for="categoria" class="fw-bold">Costo Unitario (INGRESAR SIN IVA)</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text fw-bold" id="basic-addon1">$</span>
                                    <input type="number" step="any" class="form-control " id="unit_price" min="0" name="unit_price">
                                </div>

                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <label for="categoria" class="fw-bold">Costo Total</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text fw-bold" id="basic-addon1">$</span>
                                    <!-- <input type="number" step="any" class="form-control " id="precioventa" name="precioventa" min="0"> -->
                                    <input type="number" step="any" class="form-control " id="costototal" name="costototal" min="0">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-plus"></i> Ingresar producto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <div class="card border-primary mb-4">
                <div class="card-header text-white bg-primary">Existencia del Producto En Almacén</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="existenciaproducto" class="table table-bordered table-hover table-striped">
                            <thead>
                            <th>Almacen</th>
                            <th>Cantidad</th>
                            <th>Ultima transferencia</th>
                            </thead>
                            <tbody >
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <div class="card border-primary mb-4">
                <div class="card-header text-white bg-primary">Traslados de Producto</div>
                <div class="card-body">
                    <form action="">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="categoria" class="fw-bold">Desde el Almacén</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text fw-bold" id="basic-addon1">$</span>
                                    <input type="text" class="form-control " placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="categoria" class="fw-bold">Transferir</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text fw-bold" id="basic-addon1">$</span>
                                    <input type="text" class="form-control " placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="categoria" class="fw-bold">Hasta el Almacén</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text fw-bold" id="basic-addon1">$</span>
                                    <input type="text" class="form-control " placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <button class="btn btn-primary" type="submit"><i class="fas fa-exchange-alt"></i> Transferir</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('trumbowyg/js/trumbowyg.min.js') }}"></script>
    <script src="{{ asset('trumbowyg/plugins/colors/trumbowyg.colors.min.js') }}"></script>

    <script src="{{ asset('js/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/pages/actualizarproductos.js') }}"></script>
    <script> $.trumbowyg.svgPath = '{{ asset('trumbowyg/ui/icons.svg') }}'; </script>
@endsection
