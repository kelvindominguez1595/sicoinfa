<div class="table-responsive" >

    <table class="table table-bordered table-striped table-hover">
        <thead>
            <th class="text-center size-font-medium-small bg-deudauno">FECHA DE FAC.</th>
            <th class="text-center size-font-medium-small bg-deudauno">N. DE FACTURA</th>
            <th class="text-center size-font-medium-small bg-deudauno">TIPO DE DOC.</th>
            <th class="text-center size-font-medium-small bg-deudauno">COMPRA TOTAL</th>                    
            <th class="text-center size-font-medium-small bg-deudados">ABONOS</th>
            <th class="text-center size-font-medium-small bg-deudados">FECHA</th>
            <th class="text-center size-font-medium-small bg-deudados">FORMA DE PAGO</th>
            <th class="text-center size-font-medium-small bg-deudados"># DE RECIBO</th>
            <th class="text-center size-font-medium-small bg-deudados"># DOCUMENTO DE PAGO</th>                    
            <th class="text-center size-font-medium-small bg-deudatres"># NOTA DE CRÉDITO</th>
            <th class="text-center size-font-medium-small bg-deudatres">VALOR NOTA DE CRÉDITO</th>
            <th class="text-center size-font-medium-small bg-deudatres">APLICADO A CFF:</th>
            <th class="text-center size-font-medium-small bg-deudatres">FECHA</th>                    
            <th class="text-center size-font-medium-small bg-deudacuatro">IMPORTE PENDIENTE</th>                    
            <th class="text-center size-font-medium-small bg-deudacinco"># DE FACTURA</th>
            <th class="text-center size-font-medium-small bg-deudacinco">FECHA DE PAGO</th>
            <th class="text-center size-font-medium-small bg-deudacinco">PAGO APLICADO</th>
            <th class="text-center size-font-medium-small bg-deudacinco"># DE RECIBO</th>
            <th class="text-center size-font-medium-small bg-deudacinco">FORMA DE PAGO</th>
            <th class="text-center size-font-medium-small bg-deudacinco"># DE DOCUMENTO DE PAGO</th>
            <th class="text-center size-font-medium-small bg-deudacinco">DEUDA</th>
        </thead>
        <tbody  >

            @php $abono = 0; $notacredito = 0; $deuda = 0; @endphp
            @foreach ($data as $item)
            @php
                if(isset($item->totalpago_abono)) {
                    $abono = $item->totalpago_abono;
                 } else {
                     $abono = 0;
                 }
                if(isset($item->totalpago_nota)) {
                    $notacredito = $item->totalpago_nota;
                 } else {
                     $notacredito = 0;
                }
                if(isset($item->totalpago_pago)) {
                    $deuda = $item->totalpago_pago;
                 } else {
                    $deuda = 0;
                }
            @endphp
                <tr  
                     data-bs-toggle="tooltip" 
                     data-bs-placement="top"
                     title="{{ $item->nombre_comercial }}" 
                     id="rowtable" 
                     data-deudaid="{{$item->id}}"
                     data-estadodeuda="{{$item->estadodeuda}}"
                >
                     <td class="size-font-medium-small  bg-deudauno">{{ date('d/m/Y', strtotime($item->fecha_factura)) }}</td>
                     <td class="size-font-medium-small  bg-deudauno">{{ $item->numero_factura }}</td>
                     <td class="size-font-medium-small  bg-deudauno">{{ $item->documento }}</td>
                     <td class="size-font-medium-small  bg-deudauno fw-bold">${{ number_format($item->total_compra, 2) }}</td>
 
                     <td class="size-font-medium-small bg-deudados fw-bold">
                         @isset($item->totalpago_abono) ${{ number_format($item->totalpago_abono, 2) }}  @endisset
                     </td>
                     <td class="size-font-medium-small bg-deudados">
                         @isset($item->fecha_abono) {{ date('d/m/Y', strtotime($item->fecha_abono)) }}  @endisset                        
                     </td>
                     <td class="size-font-medium-small bg-deudados">{{ $item->formpagoabono }}</td>
                     <td class="size-font-medium-small bg-deudados">{{ $item->numreciboabono }}</td>
                     <td class="size-font-medium-small bg-deudados">{{ $item->numabono }}</td>
 
                     <td class="size-font-medium-small bg-deudatres">{{ $item->numnota }}</td>
                     <td class="size-font-medium-small bg-deudatres fw-bold">
                         @isset($item->totalpago_nota) ${{ number_format($item->totalpago_nota, 2) }}  @endisset
                     </td>
                     <td class="size-font-medium-small bg-deudatres">
                         @isset($item->totalpago_nota) {{ $item->numero_factura }}  @endisset
                     </td>
                     <td class="size-font-medium-small bg-deudatres">
                         @isset($item->fecha_notacredito) {{ date('d/m/Y', strtotime($item->fecha_notacredito)) }}  @endisset
                     </td>
                     <td class="size-font-medium-small bg-deudacuatro fw-bold">
                         @php
                             $totalimporta =$item->total_compra - ($abono + $notacredito);
                             $deudafinal = $totalimporta - $deuda;
                         @endphp
                         ${{ number_format($totalimporta, 2) }}
                     </td>
 
                     <td class="size-font-medium-small bg-deudacinco">{{ $item->numero_factura }}</td>
                     <td class="size-font-medium-small bg-deudacinco">{{ date('d/m/Y', strtotime($item->fecha_pago)) }}</td>
                     <td class="size-font-medium-small bg-deudacinco">
                         @isset($item->totalpago_pago) ${{ number_format($item->totalpago_pago, 2) }}  @endisset
                     </td>
                     <td class="size-font-medium-small bg-deudacinco">{{ $item->numrecibopago }}</td>
                     <td class="size-font-medium-small bg-deudacinco">{{ $item->formpago }}</td>
                     <td class="size-font-medium-small bg-deudacinco">{{ $item->numpago }}</td>
                     <td class="size-font-medium-small bg-deudacinco fw-bold">
                         ${{ number_format($deudafinal, 2) }}
                     </td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
<div class="d-flex justify-content-between mt-3" id="pagination">
    <div>Mostrando {{ $data->firstItem() }}  a  {{ $data->lastItem() }} de {{ $data->total() }} registros.</div>
    <div>
        {!! $data->links(); !!}
    </div>
</div>
       
