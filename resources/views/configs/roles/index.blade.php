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
                    <div>Roles</div>
                    <a class="btn btn btn-light btn-sm" href="{{ route('roles.create') }}">Nuevo rol&nbsp;<i class="fa fa-save"></i></a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <th>Rol</th>
                            <th>Opciones</th>
                        </thead>
                        <tbody>
                          @foreach($data as $item)
                              <tr>
                                  <td>{{ $item->name }}</td>
                                  <td>
                                      <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                          <a href="{{ url('/premissionasig', ["id" => $item->id]) }}" class="btn btn-primary"><i class="fas fa-user-shield"></i> </a>
                                          <button type="button" class="btn btn-success"><i class="fas fa-edit"></i> </button>
                                          <button type="button" class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                      </div>
                                  </td>
                              </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
