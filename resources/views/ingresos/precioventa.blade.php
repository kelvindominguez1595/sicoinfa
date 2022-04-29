@extends('layouts.dashboard')

@section('css')
@endsection

@section('js')
    <script src="{{ asset('js/pages/precioventa.js') }}"></script>
@endsection

@section('content')
    <div class="row mb-2  justify-content-md-center">
        <div class="col-12 col-sm-12 col-md-8 col-lg-8">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white">
                    Configurar Precio de Venta
                </div>
                <div class="card-body">
                    @include('ingresos.modals.information')
                    <form id="frmventa"  >
                        <table  class="table table-bordered table-striped table-hover">
                            <thead>
                            <th class="text-center">Descripción</th>
                            <th class="text-center">Costo Sin IVA</th>
                            <th class="text-center">Costo con IVA</th>
                            <th class="text-center">Ganancia</th>
                            <th class="text-center">Porcentaje</th>
                            <th class="text-center">Precio Venta Actual</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Precio Venta Nuevo</th>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                    <tr>
                                        <td>{{ $item->name }} </td>
                                        <td class="text-center">${{ number_format($item->costosiniva, 4) }}</td>
                                        <td class="text-center">${{ number_format($item->costoconiva, 4) }}</td>
{{--                                        <td class="text-center">${{ number_format($item->ganancia, 4) }}</td>--}}
                                        <td width="145">
                                            <input type="number" step="any" class="form-control ganancia" name="ganancia[]" id="ganancia" value="{{ $item->ganancia }}">
                                        </td>
                                        <td width="125">
                                            <input type="number" step="any" class="form-control porcentaje" name="porcentaje[]"  id="porcentaje"  value="{{ $item->porcentaje}}">
                                        </td>
{{--                                        <td class="text-center">{{ $item->porcentaje }}%</td>--}}
                                        <td class="text-center">${{ number_format($item->precioventa, 4) }}</td>
                                        <td class="text-center">
                                            @if($item->cambio == "subio")
                                                <i class="text-success fas fa-arrow-up" ></i>
                                            @elseif($item->cambio == "mantiene")
                                                <i class="fas fa-equals"></i>
                                            @else
                                                <i class="text-danger fas fa-arrow-down"></i>
                                            @endif

                                        </td>
                                        <td>
                                            <input type="hidden" name="product_id[]"  id="product_id"  value="{{ $item->id }}">
                                            <input type="hidden" class="costosiniva" name="costosiniva[]" id="costosiniva" value="{{ $item->costosiniva }}">
                                            <input type="hidden" class="costoconiva" name="costoconiva[]" id="costoconiva" value="{{ $item->costoconiva }}">
                                            <input type="hidden" class="cambio" name="cambio[]"      id="cambio"      value="{{ $item->cambio }}">
                                            <input type="number" step="any" class="form-control precioventa" name="precioventa[]" id="precioventa" min="0" value="{{ number_format($item->precioventa, 4) }}">
                                        </td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                        <div class="row mt-2 mb-2">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
