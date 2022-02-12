<div class="card border-primary mb-4">
    <div class="card-header text-white bg-primary">Traslados de Producto</div>
    <div class="card-body">
        <form action="" id="traslado">
            <input type="hidden" name="stockid" id="stockid" value="{{$id}}">
            <div class="row mb-3">
                <div class="col">
                    <label for="desde" class="fw-bold">Desde el Almacén</label>
                    <select class="form-select" id="desde" name="desde">
                        <option value="0">Seleccione...</option>
                        @foreach($almacenes as $item)
                            <option value="{{ $item->id }}">{!! $item->name !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="cantidadtransferrer" class="fw-bold">Transferir</label>
                    <input type="number" min="0" value="0" id="cantidadtransferrer" name="cantidadtransferrer" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="hasta" class="fw-bold">Hasta el Almacén</label>
                    <select class="form-select" id="hasta" name="hasta">
                        <option value="0">Seleccione...</option>
                        @foreach($almacenes as $item)
                            <option value="{{ $item->id }}">{!! $item->name !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col text-center">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-exchange-alt"></i> Transferir</button>
                </div>
            </div>
        </form>
    </div>
</div>
