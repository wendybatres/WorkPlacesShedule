@extends('layouts.app')

@section('content')
<div class="row d-flex justify-content-center">
  <div class="col-sm-8">
    <div class="card">
      <div class="card-body">
        <h3>Crear Grupo de Trabajo</h3>
        <form action="{{ route('workgroups.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @include('workgroups._form', $workgroup)
        </form>
      </div>
    </div>
  </div>
</div>
@endsection