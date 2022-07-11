@extends('layouts.dashboard')

@section('css')
@endsection

@section('js')

@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <div>Asignar Permiso</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('asignarpermiso') }}" method="POST" class="g-3">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre de rol</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="">
                            <input type="hidden" id="id" name="id" value="{{ $rol->id }}">
                        </div>
                        @foreach($data as $item)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $item->id }}" id="permission_id{{ $item->id }}" name="permission[]">
                                <label class="form-check-label" for="permission_id{{ $item->id }}">
                                    {{ $item->description }}
                                </label>
                            </div>
                        @endforeach

                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
