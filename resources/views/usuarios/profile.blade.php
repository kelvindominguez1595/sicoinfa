@extends('layouts.dashboard')

@section('css')

@endsection
@section('js')
    <script src="{{ asset('js/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('js/pages/usuarios.js') }}"></script>
@endsection

@section('content')
    <div class="row mb-2 justify-content-md-center">

        {{-- columna 2 --}}
        <div class="col-xs-12 co-sm-12 col-md-6 col-lg-6 col-xl-6">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <div class="">Perfil </div>
                </div>
                <div class="card-body">
                    <form class="row g-3" id="fmrdataprofile" >
                        @csrf
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 text-center">
                            @isset($data->picture)
                                <img src="/images/usuarios/{{ $data->picture }}" width="150"  class="rounded-circle">
                            @else
                                <img src="/images/logoFerreteria.png" width="150" class="rounded-circle img-thumbnail">
                            @endisset
                                <input type="file" class="form-control mt-3" id="picture" name="picture" accept=".jpg, .jpeg, .png">
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                            <label for="name" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{$data->name}}">
                        </div>

                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="text" class="form-control" id="password" name="password">
                        </div>

                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                            <label for="email" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{$data->email}}">
                        </div>



                        <input type="hidden" id="id" name="id" value="{{$data->id}}">
                        <div class="col-12  d-flex justify-content-center mb-2">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
