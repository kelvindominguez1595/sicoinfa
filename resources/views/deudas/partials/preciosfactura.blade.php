<div class="col-5 border border-dark">

    <div class="row mb-2 mt-2">
        <div class="col-6">
            <label class="form-label fw-bold" for="totalcompraadd">TOTAL COMPRA $</label>
        </div>
        <div class="col-6">
            <input type="number" step="any" class="form-control fw-bold" id="totalcompraadd" name="totalcompraadd">
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-6">
            <label class="form-label fw-bold" for="abonoadd">ABONO $</label>
        </div>
        <div class="col-6">
            <input readonly type="number" step="any" class="form-control fw-bold" id="abonoadd" name="abonoadd" value="0">
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-6">
            <label class="form-label fw-bold" for="saldopendienteadd">SALDO PENDIENTE $</label>
        </div>
        <div class="col-6">
            <input readonly type="number" step="any" class="form-control fw-bold text-danger" id="saldopendienteadd" name="saldopendienteadd" value="0">
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-6">
            <label class="form-label fw-bold" for="notacreditoadd">N° NOTA DE CREDITO</label>
        </div>
        <div class="col-6">
            <input readonly type="number"  class="form-control fw-bold text-danger" id="notacreditoadd" name="notacreditoadd" value="0">
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-6">
            <label class="form-label fw-bold" for="valornotacreditoadd">VALOR N. DE CREDITO $</label>
        </div>
        <div class="col-6">
            <input readonly type="number" step="any" class="form-control fw-bold text-danger" id="valornotacreditoadd" name="valornotacreditoadd" value="0">
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-6">
            <label class="form-label fw-bold" for="pagototaladd">PAGO TOTAL $</label>
        </div>
        <div class="col-6">
            <input type="number" step="any" class="form-control fw-bold" id="pagototaladd" name="pagototaladd">
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-6">
            <label class="form-label fw-bold" for="numreciboadd">N° DE RECIBO </label>
        </div>
        <div class="col-6">
            <input type="number" step="any" class="form-control fw-bold" id="numreciboadd" name="numreciboadd">
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-6">
            <label class="form-label fw-bold" for="numchequeremesa">N° CHEQUE/REMESA</label>
        </div>
        <div class="col-6">
            <input type="number" min="0" class="form-control fw-bold" id="numchequeremesa" name="numchequeremesa">
        </div>
    </div>

    <div class="row mb-2" id="contenedorformapago">
        <label class="form-label fw-bold" for="pagado1">FORMA DE PAGO</label>
        @php $count = 0; @endphp
        @foreach($formapago as $item)
            <div class="col-4 mt-1">
                <input class="form-check-input" type="radio" name="formapagoadd" id="formapagoadd{{$count}}" value="{{ $item }}">
                <label class="form-check-label" for="formapagoadd{{$count}}">{{ $item }}</label>
            </div>
            @php $count++; @endphp
        @endforeach
    </div>

</div>
