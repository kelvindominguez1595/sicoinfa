@extends('layouts.dashboard')

@section('css')

@endsection
@section('js')
    <script src="{{ asset('js/pages/clientes.js') }}"></script>
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
                    <form action="" method="get">

                        <div class="mb-3 d-flex justify-content-center">
                            <button class="btn btn-success" type="submit"><i class="fa fa-search"></i> Filtrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- columna 2 --}}
        <div class="col-xs-12 co-sm-12 col-md-9 col-lg-9 col-xl-9">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <div class="">
                        Clientes
                    </div>
{{--                    <a class="btn btn btn-light btn-sm" href="#">Nuevo cliente&nbsp;<i class="fa fa-save"></i></a>--}}
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Clientes</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Contribuyentes</button>
                        </li>
                    </ul>
                    @include('clientes.partials.nuevo')
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active " id="home" role="tabpanel" aria-labelledby="home-tab">
                            <button type="button" class="btn btn-primary mb-3 mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Nuevo cliente <i class="fa fa-save"></i>
                            </button>
                            @include('clientes.partials.clientetbl')
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <button type="button" class="btn btn-primary  mb-3 mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Nuevo Contribuyente <i class="fa fa-save"></i>
                            </button>
                            @include('clientes.partials.contribuyentetbl')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
