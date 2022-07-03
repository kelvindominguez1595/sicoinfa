  <!-- Modal -->
  <div class="modal fade" id="showselecteditem" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ url('/finddeudas') }}" class="row g-3" id="frmmodaleditpagos">
                <input type="hidden" name="id" id="id">
                <div class="text-center">
                    <span class="fs-3">ESTADO DE DEUDA:</span>
                    <br>
                    <span class="fs-3 fw-bold" id="txtshowestado"></span>
                    <br>
            
                    <br>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Editar Deuda</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>