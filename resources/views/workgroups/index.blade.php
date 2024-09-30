@extends('layouts.app')

@section('content')
<div class="row d-flex justify-content-center">
  <div class="col-sm-8">
    <div class="card">
      <div class="card-body">
        <h3>Grupos de Trabajo</h3>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                {{ $message }}
            </div>
        @endif
        <a href="{{ route('workgroups.create') }}" class="btn btn-primary">+ Grupo de Trabajo</a>
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Grupo de Trabajo</th>
              <th>Descripción</th>
              <th colspan="2">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($workgroups as $workgroup)
              <tr>
                <td>{{ $workgroup->id }}</td>
                <td>{{ $workgroup->name }}</td>
                <td>{{ $workgroup->description }}</td>
                <td><a href="{{ route('workgroups.edit', ['workgroup' => $workgroup->id]) }}" class="btn btn-warning">Editar</a></td>
                <td>
                    <form action="{{ route('workgroups.destroy', ['workgroup' => $workgroup->id]) }}" method="POST">
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