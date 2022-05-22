@extends('layouts.dashboard')

@section('css')

@endsection
@section('js')
    <script src="{{ asset('js/pages/notificaciones.js') }}"></script>
@endsection
@section('content')
    <div class="row mb-2">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 border-end">
            <div class="row mb-2">
               <div class="col-12">
                   {{ $listNoti->links() }}
               </div>
            </div>
           @include('notificaciones.components.items')
        </div>
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
            @if(count($data) > 0)
            @include('notificaciones.components.verNoti')
               @else
            @endif
        </div>
    </div>
@endsection