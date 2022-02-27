<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
        <th>Nombres</th>
        <th>Apellidos</th>
        <th>DUI</th>
        <th>NIT</th>
        <th>Teléfono</th>
        <th>Dirección</th>
        <th>Acciones</th>
        </thead>
        <tbody>
        @if (empty($contribu))
            <tr>
                <td colspan="6">No hay datos</td>
            </tr>
        @else
            @foreach($contribu as $item)
                <tr>
                    <td>{{ $item->nombres }}</td>
                    <td>{{ $item->apellidos }}</td>
                    <td>{{ $item->dui }}</td>
                    <td>{{ $item->nit }}</td>
                    <td>{{ $item->telefono }}</td>
                    <td>{{ $item->direccion }}</td>
                    <td>
                        <button class="btn btn-primary" type="button" value="{{ $item->id }}" id="btnupdatecontribu">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-danger" type="button" value="{{ $item->id }}" id="deletecontribu">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-between" id="contribuyente">
    <div>Mostrando {{ $contribu->firstItem() }}  a  {{ $contribu->lastItem() }} de {{ $contribu->total() }} registros.</div>
    <div>
        {!! $contribu->links(); !!}
    </div>
</div>
