@foreach ($data as $item)
<tr>
    <td>{{ $item->invoice_number }}</td>
    <td>{{ $item->name }}</td>
    <td>{{ $item->cantidadnew }}</td>
    <td>${{ number_format($item->costosiniva, 5) }}</td>
    <td>{{ $item->updated_at}}</td>
</tr>
@endforeach
