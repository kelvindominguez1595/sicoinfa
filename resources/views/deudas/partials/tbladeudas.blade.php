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
               <tr onclick="myFunction({{$item->id}})" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $item->nombre_comercial }}">
                    <td class="size-font-medium-small">{{ date('d/m/Y', strtotime($item->fecha_factura)) }}</td>
                    <td class="size-font-medium-small">{{ $item->numero_factura }}</td>
                    <td class="size-font-medium-small">{{ $item->documento }}</td>
                    <td class="size-font-medium-small">${{ number_format($item->total_compra, 2) }}</td>

                    <td class="size-font-medium-small"> 
                        @isset($item->totalpago_abono) ${{ number_format($item->totalpago_abono, 2) }}  @endisset
                    </td>
                    <td class="size-font-medium-small">
                        @isset($item->fecha_abono) {{ date('d/m/Y', strtotime($item->fecha_abono)) }}  @endisset                        
                    </td>
                    <td class="size-font-medium-small">{{ $item->formpagoabono }}</td>
                    <td class="size-font-medium-small">{{ $item->numreciboabono }}</td>
                    <td class="size-font-medium-small">{{ $item->numabono }}</td>

                    <td class="size-font-medium-small">{{ $item->numnota }}</td>
                    <td class="size-font-medium-small">
                        @isset($item->totalpago_nota) ${{ number_format($item->totalpago_nota, 2) }}  @endisset
                    </td>
                    <td class="size-font-medium-small">
                        @isset($item->totalpago_nota) {{ $item->numero_factura }}  @endisset
                    </td>
                    <td class="size-font-medium-small">
                        @isset($item->fecha_notacredito) {{ date('d/m/Y', strtotime($item->fecha_notacredito)) }}  @endisset
                    </td>
                    <td class="size-font-medium-small">
                        @php
                            $totalimporta =$item->total_compra - ($abono + $notacredito);
                            $deudafinal = $totalimporta - $deuda;
                        @endphp
                        ${{ number_format($totalimporta, 2) }}
                    </td>

                    <td class="size-font-medium-small">{{ $item->numero_factura }}</td>
                    <td class="size-font-medium-small">{{ date('d/m/Y', strtotime($item->fecha_pago)) }}</td>
                    <td class="size-font-medium-small">
                        @isset($item->totalpago_pago) ${{ number_format($item->totalpago_pago, 2) }}  @endisset
                    </td>
                    <td class="size-font-medium-small">{{ $item->numrecibopago }}</td>
                    <td class="size-font-medium-small">{{ $item->formpago }}</td>
                    <td class="size-font-medium-small">{{ $item->numpago }}</td>
                    <td class="size-font-medium-small">
                        ${{ number_format($deudafinal, 2) }}
                    </td>
               </tr>
           @endforeach