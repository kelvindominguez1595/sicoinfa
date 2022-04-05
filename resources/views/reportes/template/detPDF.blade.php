<table class="table table-striped table-bordered table-hover">
    <thead>
    <th class="small">Código</th>
    <th class="small">C. de Barra</th>
    <th class="small">Categoría</th>
    <th class="small">Marca</th>
    <th class="small">Nombre</th>
    <th class="small">Cantidad</th>
    <th class="small">Medida</th>
    <th class="small">Costo</th>    
    <th class="small">Total de Compra</th>
    </thead>

    <tbody>
        @php
            $totalcosto         = 0;
            $totalGlobalCompra  = 0;         
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
                <td>{{ $item->medida_name }}</td>

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
                <td></td>
                <td>${{ number_format($totalcosto, 2) }}</td>
                <td>${{ number_format($totalGlobalCompra, 2) }}</td>
            </tr>
        </tfoot>
    </tbody>
</table>