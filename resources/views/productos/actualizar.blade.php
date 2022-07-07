@extends('layouts.dashboard')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2/select2-bootstrap-5-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('trumbowyg/css/ui/trumbowyg.css') }}">
    <link rel="stylesheet" href="{{ asset('trumbowyg/plugins/colors/ui/trumbowyg.colors.min.css') }}">
@endsection

@section('content')
@include('productos.modals.images')
    <div class="row mb-3">
        <div class="col-12">
            @include('productos.partials.modificarproducto')
        </div>

        <div class="col-12">
            @include('productos.partials.entrada')
        </div>

    </div>
    <div class="row mb-3">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
            @include('productos.partials.existencia')
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
            @include('productos.partials.traslado')
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('trumbowyg/js/trumbowyg.min.js') }}"></script>
    <script src="{{ asset('trumbowyg/plugins/colors/trumbowyg.colors.min.js') }}"></script>

    <script src="{{ asset('js/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/pages/actualizarproductos.js') }}"></script>
    <script> $.trumbowyg.svgPath = '{{ asset('trumbowyg/ui/icons.svg') }}'; </script>
@endsection
