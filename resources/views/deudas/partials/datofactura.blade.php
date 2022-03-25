<div class="col-7">

    <div class="row mb-2">
        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
            <label for="fechafacturaadd" class="form-label fw-bold text-uppercase">Fecha de Facturación</label>
            <input type="date" class="form-control" id="fechafacturaadd" name="fechafacturaadd">
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
            <label for="fechaabonoadd" class="form-label fw-bold text-uppercase">Fecha de pago</label>
            <input type="date" class="form-control" id="fechaabonoadd" name="fechaabonoadd">
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
            <label for="numfacturaadd" class="form-label fw-bold text-uppercase">Número De Factura</label>
            <input type="text" class="form-control" id="numfacturaadd" name="numfacturaadd">
        </div>
    </div>

    <div class="row mt-1 mb-2">
        <div class="col-9">
            <label for="proveedoradd" class="form-label fw-bold text-uppercase">Proveedor</label>

            <select class="form-control" id="proveedoradd" name="proveedoradd"></select>

        </div>
        <div class="col-1 d-flex align-items-end">
            <button type="button" id="btnaddproveedor" class="btn btn-success">Crear</button>
        </div>
    </div>

    <div class="row mt-1 mb-2">
         <div class="col-3">
            <label for="tocomp" class="form-label fw-bold text-uppercase">Total Compra</label>
            <input type="number" min="0" step="any" class="form-control" id="tocomp" name="tocomp">
        </div>

        <div class="col-9 mb-2" id="tipocdocumentocontenedor">
            <label for="fecha" class="form-label fw-bold text-uppercase">Tipo de Documento</label>
            <div class="row">
                @php $counttipo = 0; @endphp
                @foreach($tipofactura as $item)
                    <div class="col-4 mt-1">
                        <input class="form-check-input" type="radio" name="tipofacturadd" id="tipofacturadd{{$counttipo}}" value="{{ $item }}">
                        <label class="form-check-label" for="tipofacturadd{{$counttipo}}">{{ $item }}</label>
                    </div>
                    @php $counttipo++; @endphp
                @endforeach
            </div>

        </div>

    </div>

    <div class="row mt-1 mb-2">
        <div class="col-12 d-flex justify-content-center align-items-center">
            <div>
                <label class="form-label fw-bold text-uppercase" for="aplicarcredito">
                    Aplicar N/CREDITO A:
                </label>
                <input class="form-check-input" type="checkbox" value="si"  id="aplicarcredito" name="aplicarcredito">
            </div>
        </div>

    </div>

    <div class="row mt-1 mb-2">
        <div class="col-6 d-flex justify-content-end">
            <div>
                <label class="form-label fw-bold text-uppercase" for="pagado1">
                    Pagado
                </label>
                <input class="form-check-input estado" type="radio" name="estadoadd" id="pagado1" value="PAGADO" checked>
            </div>
        </div>
        <div class="col-6">
            <label class="form-label fw-bold text-uppercase" for="pagado2">
                Abonado
            </label>
            <input class="form-check-input estado" type="radio" name="estadoadd" id="pagado2" value="ABONADO" >
        </div>
    </div>

</div>
