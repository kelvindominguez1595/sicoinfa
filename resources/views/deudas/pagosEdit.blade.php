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

                        <div class="row mb-3">

                            @include('deudas.partials.datofactura')

                            <div class="col-5 border border-dark">
                                @include('deudas.partials.preciosfactura')
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <button type="button" id="btnadd" class="btn btn-primary">Agregar</button>
                            </div>
                        </div>
                    <form id="frmcuentas" class="row g-3 mt-1">
                        <div class="row table-responsive mb-3">
                            <table id="rowstable" class="table table-hover table-striped table-bordered styletabletable bordertitledeudas">
                                <thead class="">
                                    <tr>
                                        <td class="text-uppercase text-center bg-deudauno " rowspan="2">Fecha Factura</td>
                                        <td class="text-uppercase text-center bg-deudauno " rowspan="2"># Factura</td>
                                        <td class="text-uppercase text-center bg-deudauno " rowspan="2">Tipo Documento</td>
                                        <td class="text-uppercase text-center bg-deudauno " rowspan="2">Compra Total</td>
                                        {{-- <td colspan="5" class="text-center bg-deudados fw-bold ">ABONOS</td>
                                        <td colspan="4" class="text-uppercase text-center bg-deudatres fw-bold" >notas de crédito</td> --}}
                                        {{-- <td class="text-uppercase text-center bg-deudacuatro" rowspan="2">importe pendiente</td> --}}
                                        {{-- <td class="text-uppercase text-center bg-deudacinco " rowspan="2"># de Factura</td> --}}
                                        <td class="text-uppercase text-center bg-deudacinco " rowspan="2">Fecha de pago</td>
                                        <td class="text-uppercase text-center bg-deudacinco " rowspan="2">Pago aplicado</td>
                                        <td class="text-uppercase text-center bg-deudacinco " rowspan="2"># de Recibo</td>
                                        <td class="text-uppercase text-center bg-deudacinco " rowspan="2">Forma de pago</td>
                                        <td class="text-uppercase text-center bg-deudacinco " rowspan="2"># de Documento de Pago</td>
                                        <td class="text-uppercase text-center bg-deudacinco " rowspan="2">deuda</td>
                                    </tr>
                                    {{-- <tr>
                                        <td class="text-uppercase text-center bg-deudados">abono $</td>
                                        <td class="text-uppercase text-center bg-deudados">Fecha</td>
                                        <td class="text-uppercase text-center bg-deudados">Forma de pago</td>
                                        <td class="text-uppercase text-center bg-deudados"># Recibo</td>
                                        <td class="text-uppercase text-center bg-deudados"># Documento</td>
                                        <td class="text-uppercase text-center bg-deudatres"># Nota de Crédito</td>
                                        <td class="text-uppercase text-center bg-deudatres">Valor Nota de Credito</td>
                                        <td class="text-uppercase text-center bg-deudatres">Aplicado a CCF</td>
                                        <td class="text-uppercase text-center bg-deudatres">FECHA</td>
                                    </tr> --}}
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <button type="submit"  class="btn btn-primary">Guardar cuentas</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
