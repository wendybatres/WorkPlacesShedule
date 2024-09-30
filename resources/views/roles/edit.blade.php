@extends('layouts.app')

@section('content')
<div class="row d-flex justify-content-center">
  <div class="col-sm-5">
    <div class="card">
      <div class="card-body">
        <h3>Roles</h3>
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>¡Ups!</strong> Hubo algunos problemas con tu registro.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('roles.update', $role->id) }}" method="POST" enctype="multipart/form-data">
          @method('PATCH')
          @include('roles._form', $role)
        </form>
      </div>
    </div>
  </div>
</div>
@endsection