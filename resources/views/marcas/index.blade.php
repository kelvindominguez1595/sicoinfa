@extends('layouts.dashboard')

@section('css')
@endsection

@section('js')
    <script src="{{ asset('js/pages/marca.js') }}"></script>
@endsection

@section('content')
    @include('marcas.modals.modal')

    <div class="row justify-content-center">
        <div class="col col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white">
                    Filtros de búsqueda
                </div>
            </div>
        </div>
        <div class="col col-sm-12 col-md-8 col-lg-8 col-xl-8">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white">
                   Marcas
                </div>
                <div class="card-body">

                    <div class="mb-3">
                        <button type="button" class="btn btn-primary" id="btnnuevo" >
                            <i class="fas fa-plus"></i>
                            Crear Marca
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>MARCAS</th>
                                <th colspan="2" class="text-center">OPCIONES</th>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                    <tr >
                                        <td>{{ $item->name }}</td>
                                        <td class="text-center"><button value="{{ $item->id }}" id="btneditar" class="btn btn-primary"> <i class="fas fa-edit"></i> </button></td>
                                        <td class="text-center"><button value="{{ $item->id }}" id="btnborrar" class="btn btn-danger"> <i class="fas fa-trash-alt"></i> </button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-between">
                            <div>Mostrando {{ $data->firstItem() }}  a  {{ $data->lastItem() }} de {{ $data->total() }} registros.</div>
                            <div>
                                {!!
                                 $data->links()
                                 !!}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
