<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titlemodal">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <form id="fmrdata"  method="post" enctype="multipart/form-data">
                <div class="modal-body row g-3">
                    @csrf
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <label for="name" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>

                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <label for="email" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="email" name="email">
                    </div>

                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="text" class="form-control" id="password" name="password">
                    </div>

                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <label for="picture" class="form-label">Imagen</label>
                        <input type="file" class="form-control" id="picture" name="picture" accept=".jpg, .jpeg, .png">
                    </div>

                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <label for="branch_offices_id" class="form-label">Almacen</label>
                        <select class="form-select" id="branch_offices_id" name="branch_offices_id">
                            @foreach($sucursal as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="state" name="state" checked>
                            <label class="form-check-label" for="state" id="lblstate">
                                Activo
                            </label>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        @foreach($rol as $item)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rol" id="rol{{$item->id}}" value="{{$item->id}}" @if($item->id == 2) checked @endif>
                                <label class="form-check-label" for="rol">{{$item->name}}</label>
                            </div>
                        @endforeach
                    </div>

                    <input type="hidden" id="id" name="id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btnclose">Cerrar</button>
                <button type="submit" class="btn btn-primary" id="btnnamebutton">Guardar</button>
            </div>
            </form>
        </div>
    </div>
</div>
