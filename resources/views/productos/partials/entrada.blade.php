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
                    <label for="categoria" class="fw-bold">Número Crédito Fiscal</label>
                    <input type="text" class="form-control" name="invoice_number"
                           id="invoice_number" value="{{ !isset($ultimoingreso->invoice_number) ? '' : $ultimoingreso->invoice_number }}">
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
                            <input type="date" class="form-control" name="invoice_date" id="invoice_date" value="{{ !isset($ultimoingreso->invoice_date) ? '' : $ultimoingreso->invoice_date }}">
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                            <label for="categoria" class="fw-bold">Fecha de Ingreso</label>
                            <input type="text" class="form-control" id="fechaingreso" readonly name="fechaingreso" value="" placeholder="">

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
