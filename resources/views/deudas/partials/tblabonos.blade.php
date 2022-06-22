@foreach ($data as $item)
    <tr>
        <td>
            <input type="date" class="form-control" name="fecha_abonoedit" value="{{ date('Y-m-d', strtotime($item->fecha_abono))}}">
        </td>
        <td>
            <input type="hidden" name="deudaabonoidedit" value="{{ $item->id }}">
            <input type="text" class="form-control" name="numero_reciboedit" value="{{ $item->numero_recibo }}">
        </td>
        <td>
            <input type="text" class="form-control" name="total_pagoabonoedit" value="{{ $item->total_pago }}">
        </td>
        <td>
            <select name="formapago_idedit" id="formapago_idedit" class="form-select">
                @foreach ($formapago as $fp)
                    <option value="{{ $item->id }}" @if($fp->id == $item->formapago_id) selected @endif>{{ $fp->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="text" class="form-control" name="numeroedit" value="{{ $item->numero }}">
        </td>
        <td>
            <button class="btn btn-danger" type="button"><i class="fa fa-trash"></i></button>
        </td>
    </tr>    
@endforeach