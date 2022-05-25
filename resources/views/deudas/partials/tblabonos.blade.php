<table class="table table-bordered table-striped table-hover">
    <thead>
        <th>Fecha Factura</th>
        <th>N. Factura</th>
        <th>Tipo Factura</th>
        <th>Total Compra</th>
        <th>Forma de Pago</th>
        <th>Fecha Abono</th>
        <th>Abono</th>
        <th>Saldo</th>
        <th># Nota</th>
        <th>Valor de Nota</th>
        <th>Estado</th>
        <th>Opción</th>
    </thead>
    <tbody>
        @foreach($data as $item)
            <tr>
                <td>{{ date('d-m-Y', strtotime($item->fecha_factura)) }}</td>
                <td>{{ $item->numero_factura }}</td>
                <td>{{ $item->tipofactura }}</td>
                <td>${{ number_format($item->total_compra,2) }}</td>
                <td>{{ $item->formapago }}</td>
                <td>{{ date('d-m-Y', strtotime($item->fecha_abonopago)) }}</td>
                <td>${{ number_format($item->abono, 2) }}</td>
                <td>${{ number_format($item->saldo, 2) }}</td>
                <td>{{ $item->nota_credito }}</td>
                <td>${{ number_format($item->valor_nota,2) }}</td>
                <td class="fw-bold @if($item->destado == 'CONTADO') bg-success @else  bg-primary  @endif bg-gradient text-white">{{ $item->destado }}</td>
                <td>
                    @if($item->destado == 'CRÉDITO')
                        <a href="{{ url('deudas_abonos/'.$item->id) }}"  class="btn btn-primary"><i class="fas fa-hand-holding-usd"></i></a>            
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>