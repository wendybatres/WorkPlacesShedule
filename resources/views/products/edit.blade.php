@extends('layouts.app')

@section('content')
<div class="row d-flex justify-content-center">
  <div class="col-sm-5">
    <div class="card">
      <div class="card-body">
        <h3>Create product</h3>
        <form action="{{ route('products.update', ['product' => $product]) }}" method="POST" enctype="multipart/form-data">
          @method('PATCH')
          @include('products._form', ['product' => $product])
        </form>
      </div>
    </div>
  </div>
</div>
@endsection