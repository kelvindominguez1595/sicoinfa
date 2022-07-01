<input type="hidden" name="pagoidedit" id="pagoidedit" value="">

<div class="col-12 col-sm-12 col-md-3 col-lg-3">
    <div class="form-check form-switch">
        <label class="form-check-label" for="presentafacturaeditpago">¿Presenta factura?</label>
        <input class="form-check-input" type="checkbox" role="switch" id="presentafacturaeditpago" name="presentafacturaeditpago" value="si" checked>
    </div>
</div>

<div class="col-12 col-sm-12 col-md-9 col-lg-9">    
    <label for="numero_reciboeditpago" class="form-label fw-bold text-uppercase">NÚMERO DE RECIBO</label>
    <input
        type="text" 
        class="form-control"
        id="numero_reciboeditpago"
        name="numero_reciboeditpago" 
        value="">
</div>

<div class="col-12 col-sm-12 col-md-6 col-lg-6" id="contenedorpagofrm">
    <label class="form-label fw-bold" for="forma_pagoedit">FORMA DE PAGO</label>
    <br>                            
    @foreach($formapago as $item)
        <div class="form-check form-check-inline">
            <input 
                class="form-check-input"
                type="radio"
                name="forma_pagoedit" 
                id="forma_pagoedit{{$item->id}}" 
                value="{{ $item->id }}"
                 >            
            <label class="form-check-label" for="forma_pagoedit{{$item->id}}">{{ $item->name }}</label>
        </div>                                 
    @endforeach
</div>

<div class="col-12 col-sm-12 col-md-6 col-lg-6">
    <label class="form-label fw-bold" for="numerochequeedit">N° CHEQUE/REMESA</label>
    <input type="number" min="0" 
    class="form-control fw-bold" id="numerochequeedit" 
    value=""
    name="numerochequeedit" readonly  >
</div>  
