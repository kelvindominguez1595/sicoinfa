<div class="col-12 col-sm-12 col-md-6 col-lg-6">    
    <label for="numero_reciboedit" class="form-label fw-bold text-uppercase">NÚMERO DE RECIBO</label>
    <input type="text" class="form-control"
     id="numero_reciboedit" name="numero_reciboedit" 
     value="{{ !empty($data->numero_recibo) ? $data->numero_recibo : '' }}">
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
                @if(!empty($data->formapago_id)) 
                    @if($data->formapago_id == $item->id) checked @endif
                @endif
                 >            
            <label class="form-check-label" for="forma_pagoedit{{$item->id}}">{{ $item->name }}</label>
        </div>                                 
    @endforeach
</div>

<div class="col-12 col-sm-12 col-md-6 col-lg-6">
    <label class="form-label fw-bold" for="numerochequeedit">N° CHEQUE/REMESA</label>
    <input type="number" min="0" 
    class="form-control fw-bold" id="numerochequeedit" 
    value="{{ !empty($data->numero) ? $data->numero : '' }}"
    name="numerochequeedit" @if (empty($data->numero)) readonly @endif >
</div>  
