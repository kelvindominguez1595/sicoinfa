<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover" id="tbldataselected">
        <thead>
        <th>Código</th>
        <th>Categoría</th>
        <th>Marca</th>
        <th>Producto</th>
        <th>Sucursal</th>
        <th>Acciones</th>
        </thead>
        <tbody>
        @if (empty($data))
            <tr>
                <td colspan="6">No hay datos</td>
            </tr>
        @else
            @foreach($data as $item)

                <tr>

                    <td>{{ $item->code }}
                        <input type="hidden" class="proid" id="proid" name="proid[]" value="{{ $item->id }}">
                        <input type="hidden" class="marca" id="marca" name="marca[]" value="{{ $item->marca_name }}">
                        <input type="hidden" class="categoria" id="categoria" name="categoria[]" value="{{ $item->category_name }}">
                        <input type="hidden" class="nombreproducto" id="nombreproducto" name="nombreproducto[]" value="{{ $item->name }}">
                    </td>
                    <td>{{ $item->category_name }}</td>
                    <td>{{ $item->marca_name }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->sucursal }}</td>
                    <td>

                    </td>
                </tr>

            @endforeach
        @endif
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-between" id="paginationmodal">
    <div>Mostrando {{ $data->firstItem() }}  a  {{ $data->lastItem() }} de {{ $data->total() }} registros.</div>
    <div>
        {!!
        $data->appends([
            'codigo'    => $codigo,
            'categoria' => $categoria,
            'marca'     => $marca,
            'producto'  => $producto,
        ]);
        !!}
    </div>
</div>
