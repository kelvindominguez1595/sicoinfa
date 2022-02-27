<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>DUI</th>
            <th>Teléfono</th>
            <th>Dirección</th>
            <th>Acciones</th>
        </thead>
        <tbody>
        @if (empty($clientes))
            <tr>
                <td colspan="6">No hay datos</td>
            </tr>
        @else
            @foreach($clientes as $item)
                <tr>
                    <td>{{ $item->nombres }}</td>
                    <td>{{ $item->apellidos }}</td>
                    <td>{{ $item->dui }}</td>
                    <td>{{ $item->telefono }}</td>
                    <td>{{ $item->direccion }}</td>
                    <td>
                        <button class="btn btn-primary" type="button" value="{{ $item->id }}" id="btnupdaclie">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-danger" type="button" value="{{ $item->id }}" id="deleteclie">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-between" id="cliente">
    <div>Mostrando {{ $clientes->firstItem() }}  a  {{ $clientes->lastItem() }} de {{ $clientes->total() }} registros.</div>
    <div>
        {!! $clientes->links(); !!}
    </div>
</div>
