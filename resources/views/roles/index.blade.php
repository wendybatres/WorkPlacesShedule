@extends('layouts.app')

@section('content')
<div class="row d-flex justify-content-center">
  <div class="col-sm-8">
    <div class="card">
      <div class="card-body">
        <h3>Roles</h3>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                {{ $message }}
            </div>
        @endif
        <a href="{{ route('roles.create') }}" class="btn btn-primary">+ Rol</a>
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Rol</th>
              <th>Descripción</th>
              <th colspan="2">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($roles as $role)
              <tr>
                <td>{{ $role->id }}</td>
                <td>{{ $role->name }}</td>
                <td>{{ $role->description }}</td>
                <td><a href="{{ route('roles.edit', ['role' => $role->id]) }}" class="btn btn-warning">Editar</a></td>
                <td>
                    <form action="{{ route('roles.destroy', ['role' => $role->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
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