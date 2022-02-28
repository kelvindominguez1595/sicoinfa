<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Dirección</th>
            <th>Acciones</th>
        </thead>
        <tbody>
        @if (empty($data))
            <tr>
                <td colspan="4">No hay datos</td>
            </tr>
        @else
            @foreach($data as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->address }}</td>
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
    <div>Mostrando {{ $data->firstItem() }}  a  {{ $data->lastItem() }} de {{ $data->total() }} registros.</div>
    <div>
        {!! $data->links(); !!}
    </div>
</div>
