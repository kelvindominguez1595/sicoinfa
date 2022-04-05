<table class="table table-striped table-bordered table-hover">
    <thead>
    <th class="small">Código</th>
    <th class="small">C. de Barra</th>
    <th class="small">Categoría</th>
    <th class="small">Marca</th>
    <th class="small">Nombre</th>
    <th class="small">Cantidad</th>
    <th class="small">Costo</th>
    <th class="small">Total de Compra</th>
    <th class="small">P. Venta</th>
    <th class="small">Venta Total</th>
    <th class="small">% Diferencia</th>
    <th class="small">Diferencia Unitaria</th>
    <th class="small">Utilidad Total</th>
    </thead>

    <tbody>
        @php
            $totalcosto         = 0;
            $totalGlobalCompra       = 0;
            $totalprecioventa   = 0;
            $totalventatotal    = 0;
            $totaldiferencia    = 0;
            $totalutilidad      = 0;
        @endphp
        @foreach ($data as $item)
            <tr>
                <td>{{ $item->code }}</td>
                <td>{{ $item->barcode }}</td>
                <td>{{ $item->category_name }}</td>
                <td>{{ $item->marca_name }}</td>
                <td>{{ $item->name }}</td>
                <td>
                    @isset($item->cantidadnew)    
                        {{ $item->cantidadnew }}
                    @else
                     0
                    @endisset
                </td>

                <td>
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

                <td>
                    
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

                <td>
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

                <td>
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

                <td>
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
                    {{number_format($diferencia,2)}}%
                </td>
                
                
                <td>
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
                    ${{number_format($diferenciauni,2)}}                   
                </td>

                <td>
                    @php       
                        $utilidad = $ventatotal - $totalCompra; 
                        $totalutilidad += $utilidad;
                    @endphp
                    ${{number_format($utilidad,2)}}
                </td>
            </tr>
        @endforeach
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>${{ number_format($totalcosto, 2) }}</td>
                <td>${{ number_format($totalGlobalCompra, 2) }}</td>    
                <td>${{ number_format($totalprecioventa, 2) }}</td>
                <td>${{ number_format($totalventatotal, 2) }}</td> 
                <td></td>
                <td>${{ number_format($totaldiferencia, 2) }}</td> 
                <td>${{ number_format($totalutilidad, 2) }}</td> 
            </tr>
        </tfoot>
    </tbody>
</table>