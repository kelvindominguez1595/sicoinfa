<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover" id="tbldataselected">
        <thead>
        <th class="size-font-long-small text-center">Código</th>
        <th class="size-font-long-small text-center">Descripción</th>
        <th class="size-font-long-small text-center">Marca</th>
        <th class="size-font-long-small text-center">Categoría</th>
        <th class="size-font-long-small text-center">Unidad</th>
        <th class="size-font-long-small text-center">Estado</th>
        <th class="size-font-long-small text-center">Sucursal</th>
        <th class="size-font-long-small text-center" colspan="2">Acciones</th>
        </thead>
        <tbody>
        @if (empty($data))
            <tr>
                <td colspan="6">No hay datos</td>
            </tr>
        @else
            @foreach($data as $item)

                <tr>

                    <td class="size-font-long-small text-center">{{ $item->code }}
                        <input type="hidden" class="code" id="code" name="code[]" value="{{ $item->code }}">
                        <input type="hidden" class="proid" id="proid" name="proid[]" value="{{ $item->id }}">
                        <input type="hidden" class="marca" id="marca" name="marca[]" value="{{ $item->marca_name }}">
                        <input type="hidden" class="categoria" id="categoria" name="categoria[]" value="{{ $item->category_name }}">
                        <input type="hidden" class="nombreproducto" id="nombreproducto" name="nombreproducto[]" value="{{ $item->name }}">
                    </td>
                    <td class="size-font-long-small text-center">{{ $item->name }}</td>
                    <td class="size-font-long-small text-center">{{ $item->marca_name }}</td>
                    <td class="size-font-long-small text-center">{{ $item->category_name }}</td>
                    <td class="size-font-long-small text-center">{{ $item->medida_name }}</td>
                    <td class="size-font-long-small text-center">
                        @if($item->state == 1)
                            Activo
                        @else
                            Inactivo
                        @endif
                    </td>
                    <td class="size-font-long-small text-center">{{ $item->sucursal }}</td>
                    <td>
                        <button type="button" id="btnaddproduct" class="btn btn-primary"><i class="fas fa-plus"></i></button>
                    </td>
                    <td>
                        @if($item->state == 1)
                            <button class="btn btn-success" value="{{ $item->id }}" id="btnactive"><i class="fas fa-eye"></i></button>
                        @else
                            <button class="btn btn-danger" value="{{ $item->id }}" id="btnactive"><i class="fas fa-eye-slash"></i></button>
                        @endif
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
            'codigosearch'    => $codigosearch,
            'categoriasearch' => $categoriasearch,
            'marcasearch'     => $marcasearch,
            'productosearch'  => $productosearch,
            'estado'          => $estado,
        ]);
        !!}
    </div>
</div>
