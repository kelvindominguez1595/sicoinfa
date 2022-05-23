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
        @include('deudas.partials.modal')
        {{-- columna 1  --}}
        <div class="col-xs-12 co-sm-12 col-md-3 col-lg-3 col-xl-3">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white">
                    Filtros de búsqueda
                </div>
                <div class="card-body">
        
                </div>
            </div>
        </div>
        {{-- columna 2 --}}
        <div class="col-xs-12 co-sm-12 col-md-9 col-lg-9 col-xl-9">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <div class="">Deudas </div>
                    <a class="btn btn-light"  data-bs-toggle="modal" data-bs-target="#exampleModal">Ingresar deudas</a>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <th>Fecha Factura</th>
                                <th>N. Factura</th>
                                <th>Tipo Factura</th>
                                <th>Total Compra</th>
                                <th>Forma de Pago</th>
                                <th>Fecha Abono</th>
                                <th>Abono</th>
                                <th>Saldo</th>
                                <th>Número de Nota</th>
                                <th>Valor de Nota</th>
                                <th>Estado</th>
                                <th>Opción</th>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                    <tr>
                                        <td>{{ date('d-m-Y', strtotime($item->fecha_factura)) }}</td>
                                        <td>{{ $item->numero_factura }}</td>
                                        <td>{{ $item->tipo_factura }}</td>
                                        <td>${{ number_format($item->total_compra,2) }}</td>
                                        <td>{{ $item->forma_pago }}</td>
                                        <td>{{ date('d-m-Y', strtotime($item->fecha_abonopago)) }}</td>
                                        <td>${{ number_format($item->abono, 2) }}</td>
                                        <td>${{ number_format($item->saldo, 2) }}</td>
                                        <td>{{ $item->nota_credito }}</td>
                                        <td>${{ number_format($item->valor_nota,2) }}</td>
                                        <td class="fw-bold @if($item->destado == 'PAGADO') bg-success @else  bg-primary  @endif bg-gradient text-white">{{ $item->destado }}</td>
                                        <td>
                                            @if($item->destado == 'ABONADO')
                                                <button class="btn btn-primary" id="btnupdate" value="{{ $item->id }}"><i class="fas fa-hand-holding-usd"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
