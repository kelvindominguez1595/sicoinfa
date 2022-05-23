@extends('layouts.dashboard')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2/select2-bootstrap-5-theme.min.css') }}">
@endsection
@section('js')
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('js/pages/deudas.js') }}"></script>
@endsection

@section('content')
    <div class="row mb-2">
        @include('proveedores.modals.modal')
        <div class="col-xs-12 co-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <div class="">CUENTAS POR PAGAR </div>
                </div>
                <div class="card-body">

                        <div class="row mb-3 d-flex justify-content-center">
                            @include('deudas.partials.datofactura')                   

                        </div>
                        <form id="frmcuentas" class="row g-3 mt-1">
                            
                        <div class="row mb-3">
                            <div class="col-6 d-flex justify-content-end">
                                <button type="button" id="btnadd" class="btn btn-primary">Agregar</button>
                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                <button type="submit"  class="btn btn-primary">Guardar cuentas</button>
                            </div>
                        </div>
                        <div class="row table-responsive mb-3">
                            <table id="rowstable" class="table table-hover table-striped table-bordered styletabletable ">
                                <thead class="">                                 
                                        <th class="text-uppercase text-center bg-deudauno">Fecha Factura</th>
                                        <th class="text-uppercase text-center bg-deudauno"># Factura</th>
                                        <th class="text-uppercase text-center bg-deudauno">Tipo Documento</th>
                                        <th class="text-uppercase text-center bg-deudauno">Compra Total</th>                     
                                        <th class="text-uppercase text-center bg-deudacinco">Fecha de pago</th>
                                        <th class="text-uppercase text-center bg-deudacinco">Pago aplicado</th>
                                         <th class="text-uppercase text-center bg-deudacinco">Forma de pago</th>
                                        <th class="text-uppercase text-center bg-deudacinco">deuda</th>                    
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

         
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
