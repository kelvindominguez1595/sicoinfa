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
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="categoria" class="fw-bold">Costo del producto (SIN IVA) </label>
                    <div class="input-group mb-3">
                        <span class="input-group-text fw-bold" id="basic-addon1">$</span>
                        <input type="number" min="0" step="any" class="form-control" name="cost_s_iva" id="cost_s_iva" readonly value="">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="categoria" class="fw-bold">Costo del Producto (IVA INCLUIDO)</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text fw-bold" id="basic-addon1">$</span>
                        <input type="number" min="0" step="any" class="form-control " name="cost_c_iva" id="cost_c_iva" readonly  value="" data-iva="13">
                    </div>
                </div>
            </div>
            <div class="row mb-3">

                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="row">
                        <div class="col">
                            <label for="categoria" class="fw-bold">Ganancia (IVA INCLUIDO)</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text fw-bold" id="basic-addon1">$</span>
                                <input type="number" min="0" step="any" class="form-control " name="earn_c_iva" id="earn_c_iva" value="">
                            </div>
                        </div>

                        <div class="col">
                            <label for="categoria" class="fw-bold">Porcentaje de Ganancia</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text fw-bold" id="basic-addon1">%</span>
                                <input type="number" min="0" step="any" class="form-control " name="earn_porcent" id="earn_porcent" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <label for="categoria" class="fw-bold">Precio de Venta a Consumidor (IVA INCLUIDO)</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text fw-bold" id="basic-addon1">$</span>
                        <input type="number" min="0" step="any" class="form-control" name="sale_price" id="sale_price"  value="">
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <button class="btn btn-primary" type="submit"><i class="fas fa-edit"></i> Modificar Producto</button>
            </div>
        </form>
    </div>
</div>
