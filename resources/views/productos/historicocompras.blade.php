@extends('layouts.dashboard')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2/select2-bootstrap-5-theme.min.css') }}">
@endsection
@section('js')
    <script src="{{ asset('js/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/pages/filterproductos.js') }}"></script>
@endsection

@section('content')
    <div class="row mb-2">
        {{-- columna 1  --}}
        <div class="col-xs-12 co-sm-12 col-md-3 col-lg-3 col-xl-3">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white">
                    Filtros de búsqueda
                </div>
                <div class="card-body">
                    <form action="{{ route('productos.index')}}" method="get">
                        @csrf

                    </form>
                </div>
            </div>
        </div>
        {{-- columna 2 --}}
        <div class="col-xs-12 co-sm-12 col-md-9 col-lg-9 col-xl-9">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <div class="">

                    </div>

                </div>
                <div class="card-body">


{{--                        <div class="d-flex justify-content-between">--}}
{{--                            <div>Mostrando {{ $data->firstItem() }}  a  {{ $data->lastItem() }} de {{ $data->total() }} registros.</div>--}}
{{--                            <div>--}}
{{--                                {!!--}}
{{--                                 $data->appends([--}}
{{--                                    'estado'=> $estado,--}}
{{--                                    'codigo'=> $codigo,--}}
{{--                                    'codbarra'=> $codbarra,--}}
{{--                                    'categoria'=> $categoria,--}}
{{--                                    'marca'=> $marca,--}}
{{--                                    'nombre'=> $nombre,--}}
{{--                                    'almacen'=> $almacen,--}}
{{--                                    'pages'=> $pages,--}}
{{--                                 ])--}}

{{--                                 !!}--}}
{{--                            </div>--}}
{{--                        </div>--}}

                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
