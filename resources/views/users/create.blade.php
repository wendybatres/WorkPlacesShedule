@extends('layouts.app')

@section('content')
<div class="row d-flex justify-content-center">
  <div class="col-sm-8">
    <div class="card">
      <div class="card-body">
        <h3>Crear Usuario</h3>
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @include('users._form', $user)
        </form>
      </div>
    </div>
  </div>
</div>
@endsection