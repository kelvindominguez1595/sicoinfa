@extends('layouts.dashboard')

@section('css')
@endsection

@section('js')

@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <div>Roles</div>
                    <a class="btn btn btn-light btn-sm" href="{{ route('permisos.create') }}">Nuevo permision&nbsp;<i class="fa fa-save"></i></a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <th>Route</th>
                        <th>Name</th>
                        <th>Opciones</th>
                        </thead>
                        <tbody>
                        @foreach($data as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->description }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                        <button type="button" class="btn btn-success"><i class="fas fa-edit"></i> </button>
                                        <button type="button" class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-between">
                        <div> Mostrando {{ $data->firstItem() }} a {{ $data->lastItem() }} de {{ $data->total() }} registros.</div>
                        <div> {!! $data->links() !!} </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
