<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
            <th class="text-center">CODIGO</th>
            <th class="text-center">MARCA</th>
            <th class="text-center">NOMBRE</th>
            <th class="text-center">UNIDAD DE MEDIDAD</th>
            <th class="text-center">CANTIDAD</th>
            <th class="text-center">PRECIO VENTA</th>
            <th class="text-center">VER</th>
            </thead>
            <tbody>
            @foreach($data as $item)
                <tr>
                    <td class="text-center">{{ $item->code }}</td>
                    <td class="text-center">{{ $item->marca_name }}</td>
                    <td class="text-center">{{ $item->name }}</td>
                    <td class="text-center">{{ $item->medida_name }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-center">$ {{ number_format($item->precioventa, 2) }}</td>
                    <td class="text-center">
                        <button
                            type="button"
                            class="btn btn-outline-primary"
                            id="btnverdetalle"
                            value="{{ $item->id }}"
                            data-productoid="{{ $item->id }}">
                             <span class="fas fa-eye"  ></span>
                        </button>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
