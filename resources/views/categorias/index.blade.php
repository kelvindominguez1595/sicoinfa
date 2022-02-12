@extends('layouts.dashboard')

@section('css')
@endsection

@section('js')
    <script src="{{ asset('js/pages/categorias.js') }}"></script>
@endsection

@section('content')
    @include('categorias.modals.modal')

    <div class="row justify-content-center">
        <div class="col col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white">
                    Filtros de búsqueda
                </div>
                <div class="card-body">
                    <form action="{{ route('categorias.index')}}" method="get">
                        @csrf
                        <div class="mb-3 d-flex justify-content-center">
                            <button class="btn btn-primary btn-sm" type="button" id="btnresetall" onclick="$(location).attr('href','categorias');">Mostrar Todo</button>
                        </div>
                        <div class="row">

                            <div class="col-12  mb-2">
                                <label for="nombre" class="form-label fw-bold">Categorías</label>
                                <input type="text" class="form-control" id="name" name="name" autocomplete="false" value="{{ $name }}" placeholder="Categorías">
                            </div>


                            <div class="col-12  mb-2">
                                <label for="countpagination" class="form-label fw-bold">Cantidad por página</label>
                                <select class="form-select"  id="pages" name="pages">
                                    <option value="25"  @if ($pages == 25) selected @endif>25</option>
                                    <option value="50"  @if ($pages == 50) selected @endif>50</option>
                                    <option value="100"  @if ($pages == 100) selected @endif>100</option>
                                </select>
                            </div>

                        </div>

                        <div class="mb-3 d-flex justify-content-center">
                            <button class="btn btn-success" type="submit"><i class="fa fa-search"></i> Filtrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col col-sm-12 col-md-8 col-lg-8 col-xl-8">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white">
                    Categorías
                </div>
                <div class="card-body">

                    <div class="mb-3">
                        <button type="button" class="btn btn-primary" id="btnnuevo" >
                            <i class="fas fa-plus"></i>
                            Crear Categoría
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>CATEGORIAS</th>
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
                                {!! $data->appends(['name' => $name ]) !!}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
