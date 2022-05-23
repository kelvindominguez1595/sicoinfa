<div class="modal-dialog modal-dialog-centered" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Agregar factura</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form action="" id="frmFactura">
                  <div class="row mt-1 mb-2">
                      <div class="col-12">
        
                      </div>
                  </div>
                  
                  <div class="row mb-2">
                      <div class="col-12 col-sm-5 col-md-5 col-lg-5">
                         
                      </div>
                      <div class="col-7 mb-2" id="tipocdocumentocontenedor">
                          <label for="tipofacturadd" class="form-label fw-bold text-uppercase">Tipo de Documento</label>
                          <div class="row">
                              @php $counttipo = 0; @endphp
                              @foreach($tipofactura as $item)
                                  <div class="col-4 mt-1">
                                      <input class="form-check-input" type="radio" name="tipofacturadd" id="tipofacturadd{{$counttipo}}" value="{{ $item }}">
                                      <label class="form-check-label" for="tipofacturadd{{$counttipo}}">{{ $item }}</label>
                                  </div>
                                  @php $counttipo++; @endphp
                              @endforeach
                          </div>
                  
                      </div>
                  </div>
                  
                  <div class="row mb-2">
                      <div class="col-12 col-sm-6 col-md-6 col-lg-6">

                      </div>
                      <div class="col-12 col-sm-6 col-md-6 col-lg-6">

                      </div>
                  </div>
                  
                  <div class="row mt-1 mb-2">
                       <div class="col-3">

                      </div>
                  </div>
                  
                  <div class="row mt-1 mb-2">
                      <div class="col-6 d-flex justify-content-end">
                          <div>
                              <label class="form-label fw-bold text-uppercase" for="pagado1">
                                  CREDITO
                              </label>
                              <input class="form-check-input estado" type="radio" name="estadoadd" id="pagado1" value="CREDITO" checked>
                          </div>
                      </div>
                      <div class="col-6">
                          <label class="form-label fw-bold text-uppercase" for="pagado2">
                              CONTADO
                          </label>
                          <input class="form-check-input estado" type="radio" name="estadoadd" id="pagado2" value="CONTADO" >
                      </div>
                  </div>
                  
                  <div class="row mt-1 mb-2 d-none" >
                      <div class="col-6">
                          <div class="row">
                              
                              @php $count = 0; @endphp
                              @foreach($formapago as $item)
                                  <div class="col-4 mt-1">
                                      <input class="form-check-input" type="radio" name="formapagoadd" id="formapagoadd{{$count}}" value="{{ $item }}">
                                      <label class="form-check-label" for="formapagoadd{{$count}}">{{ $item }}</label>
                                  </div>
                                  @php $count++; @endphp
                              @endforeach
                  
                          </div>
                      </div>
                      
                      <div class="col-6">      

                      </div>    
                  </div>

              </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary">Guardar</button>
          </div>
        </div>
      </div>
</div>
  

