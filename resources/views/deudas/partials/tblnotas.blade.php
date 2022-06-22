@foreach ($data as $item)
    <tr>
        <td>
            <input type="hidden" name="notacreidedit" value="{{ $item->id }}">
            <input type="text" class="form-control" name="numero_notaedit" value="{{ $item->numero }}">
        </td>
        <td>
            <input type="date" class="form-control" name="fecha_notaedit" value="{{ date('Y-m-d', strtotime($item->fecha_notacredito))}}">
        </td>
        <td>
            <input type="text" class="form-control" name="total_pagonotaedit" value="{{ $item->total_pago }}">
        </td>
        <td>
            <button id="btndeletenota" value="{{ $item->id }}" class="btn btn-danger" type="button"><i class="fa fa-trash"></i></button>
        </td>
    </tr>    
@endforeach