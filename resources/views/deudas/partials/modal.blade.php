
<!-- Modal -->
<div class="modal fade" id="exampleModal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titlemodal">REALIZAR ABONO</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="frmdata">
                @csrf
                <input type="hidden" id="id" name="id">
                <div class="modal-body row g-3">
                    <div class="row mb-2">
                        <div class="col-3">
                            <label class="form-label fw-bold text-uppercase">FECHA DE FACTURACIÓN:</label><br>
                            <span id="ff"></span>
                        </div>
                        <div class="col-3">
                            <label class="form-label fw-bold text-uppercase">NÚMERO DE FACTURA:</label><br>
                            <span id="nf"></span>
                        </div>
                        <div class="col-3">
                            <label class="form-label fw-bold text-uppercase">TOTAL COMPRA:</label><br>
                            <span id="tc"></span>
                        </div>
                        <div class="col-3">
                            <label class="form-label fw-bold text-uppercase">TIPO DE DOCUMENTO :</label><br>
                            <span id="tp"></span>
                        </div>
                    </div>

                    <div class="row mb-2 ">
                        <div class="col-12 border-bottom">
                            <label class="form-label fw-bold text-uppercase">PROVEEDOR:</label><br>
                            <span id="pp"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4 border-end">
                            @include('deudas.partials.preciosfactura')
                        </div>
                        <div class="col-8">
                            <div class="bg-primary text-white text-center p-1">CANTIDAD DE ABONOS</div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="tblabono">
                                    <thead>
                                    <th class="text-center text-uppercase">Forma de Pago</th>
                                    <th class="text-center text-uppercase">Fecha de Abono</th>
                                    <th class="text-center text-uppercase">Num. Documento</th>
                                    <th class="text-center text-uppercase">Abono</th>
                                    <th class="text-center text-uppercase">Saldo</th>
                                    <th class="text-center text-uppercase">Nota Credito</th>
                                    <th class="text-center text-uppercase">Valor Nota</th>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
