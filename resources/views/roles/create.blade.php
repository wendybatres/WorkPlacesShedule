@extends('layouts.app')

@section('content')
<div class="row d-flex justify-content-center">
  <div class="col-sm-8">
    <div class="card">
      <div class="card-body">
        <h3>Crear Rol</h3>
        <form action="{{ route('roles.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @include('roles._form', $role)
        </form>
      </div>
    </div>
  </div>
</div>
@endsection