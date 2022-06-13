<table class="table table-striped " id="tbdata">

    <thead style="border: 2px solid;">
        <th style="">Código</th>
        <th style="">C. de Barra</th>
        <th style="">Categoría</th>
        <th style="">Marca</th>
        <th style="">Nombre</th>
        <th style="">Cantidad</th>
        <th style="">Costo</th>
        <th style="">Total de Compra</th>
        <th style="">P. Venta</th>
        <th style="">Venta Total</th>
        <th style="">% Diferencia</th>
        <th style="">Diferencia Unitaria</th>
        <th style="">Utilidad Total</th>
    </thead>

    <tbody>
        @php
            $totalcosto = 0; $totalGlobalCompra = 0; $totalprecioventa = 0; $totalventatotal = 0; $totaldiferencia = 0; $totalutilidad = 0;
        @endphp
        @foreach ($data as $item)
            <tr>
                <td style="">{{ $item->code }}</td>
                <td style="">{{ $item->barcode }}</td>
                <td style="">{{ $item->category_name }}</td>
                <td style="">{{ $item->marca_name }}</td>
                <td style="">{{ $item->name }}</td>

                <td style="">
                    @isset($item->cantidadnew)
                        {{ $item->cantidadnew }}
                    @else
                     0
                    @endisset
                </td>

                <td style="">
                    @php
                    if(isset($item->cost_s_iva)){
                        $costoReal = $item->cost_s_iva;
                    }else {
                        $costoReal = $item->costosiniva;
                    }
                    $totalcosto += $costoReal;
                    @endphp
                    ${{number_format($costoReal,2)}}
                </td>

                <td style="">
                    @php
                        if(isset($item->cost_s_iva)){
                            $costo = $item->cost_s_iva;
                        }else {
                            $costo = $item->costosiniva;
                        }
                        $totalCompra =  $item->cantidadnew * $costo;
                        $totalGlobalCompra += $totalCompra;
                    @endphp
                     ${{number_format($totalCompra,2)}}
                </td>

                <td style="">
                    @php
                    if(isset($item->precioventa)){
                        $preVenta = $item->precioventa;
                    }else {
                        $preVenta = $item->sale_price;
                    }
                    $totalprecioventa += $preVenta;
                    @endphp
                    ${{number_format($preVenta,2)}}
                </td>

                <td style="">
                    @php
                    if(isset($item->precioventa)){
                        $precioventa = $item->precioventa;
                    }else {
                        $precioventa = $item->sale_price;
                    }
                    $ventatotal =  $item->cantidadnew * $precioventa;
                    $totalventatotal += $ventatotal;
                    @endphp
                    ${{number_format($ventatotal,2)}}
                </td>

                <td style="">
                    @php
                        if(isset($item->cost_s_iva)){
                            $costoper = $item->cost_s_iva;
                        }else {
                            $costoper = $item->costosiniva;
                        }

                        if(isset($item->precioventa)){
                            $precioventaper = $item->precioventa;
                        }else {
                            $precioventaper = $item->sale_price;
                        }

                        if(isset($costoper)){
                            $costoperval = $costoper;
                        } else {
                            $costoperval = 0;
                        }

                        if(isset($precioventaper)){
                            $precioventapervali =  $precioventaper;
                        } else {
                            $precioventapervali = 0;
                        }
                        if($costoperval == 0 || $precioventapervali == 0 )
                        {
                            $diferencia = 0;

                        } else {
                            $diferencia =  ((($precioventapervali / $costoperval) - 1) *100);
                        }
                    @endphp
                    {{number_format(abs($diferencia),2)}}%
                </td>

                <td style="">
                    @php
                    if(isset($item->cost_s_iva)){
                        $costoUni = $item->cost_s_iva;
                    }else {
                        $costoUni = $item->costosiniva;
                    }
                    if(isset($item->precioventa)){
                        $ventaUni = $item->precioventa;
                    }else {
                        $ventaUni = $item->sale_price;
                    }
                        $diferenciauni = $ventaUni - $costoUni;
                        $totaldiferencia += $diferenciauni;
                    @endphp
                    ${{number_format(abs($diferenciauni),2)}}
                </td>

                <td style="">
                    @php
                        $utilidad = $ventatotal - $totalCompra;
                        $totalutilidad += $utilidad;
                    @endphp
                    ${{number_format(abs($utilidad),2)}}
                </td>

            </tr>
        @endforeach
    </tbody>
    <tfoot>

        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="">${{ number_format($totalcosto, 2) }}</td>
            <td style="">${{ number_format($totalGlobalCompra, 2) }}</td>
            <td style="">${{ number_format($totalprecioventa, 2) }}</td>
            <td style="">${{ number_format($totalventatotal, 2) }}</td>
            <td></td>
            <td style="">${{ number_format($totaldiferencia, 2) }}</td>
            <td style="">${{ number_format($totalutilidad, 2) }}</td>
        </tr>

    </tfoot>
</table>

