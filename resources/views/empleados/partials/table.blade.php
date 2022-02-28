<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <th>Código</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Email</th>
            <th>DUI</th>
            <th>NIT</th>
            <th>NUP</th>
            <th>ISSS</th>
            <th>Teléfono</th>
            <th>Dirección</th>
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
                    <td>{{ $item->codigo }}</td>
                    <td>{{ $item->first_name }}</td>
                    <td>{{ $item->last_name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->dui }}</td>
                    <td>{{ $item->nit }}</td>
                    <td>{{ $item->nup }}</td>
                    <td>{{ $item->isss }}</td>
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
