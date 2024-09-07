@extends('layouts.app')

@section('content')
<div class="container">
  <div class="card">
    <div class="card-body">
      <div class="py-5 text-center">
        <h2>Checkout form</h2>
        <p>REVIEW YOUR ORDER</p>
      </div>
      <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Your cart</span>
            <span class="badge badge-secondary badge-pill">3</span>
          </h4>
          @include('shopping._cart')
          <div class="card p-2">
            <div class="input-group">
              <button form="orderForm" class="btn btn-primary btn-lg btn-block" type="submit" style="width: 100%;">Continue to checkout</button>
            </div>
          </div>
        </div>
        <div class="col-md-8 order-md-1">
          <h4 class="mb-3">Billing address</h4>
          <form class="needs-validation" id="orderForm" method="POST" action="{{ route('orders.store') }}"> 
            @csrf
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="firstName">First name</label>
                <input type="text" class="form-control" name="first_name" id="firstName" value="" required>
                <div class="invalid-feedback"> Valid first name is required. </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="lastName">Last name</label>
                <input type="text" class="form-control" name="last_name" id="lastName" value="" required>
                <div class="invalid-feedback"> Valid last name is required. </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="address">Address</label>
              <input type="text" class="form-control" name="address" id="address" required>
              <div class="invalid-feedback"> Please enter your shipping address. </div>
            </div>
            <div class="row">
              <div class="col-md-4 mb-3">
                <label for="state">State</label>
                <select class="form-control" id="state" name="state">
                  <option value="">Choose...</option>
                  <option>California</option>
                </select>
                <div class="invalid-feedback"> Please provide a valid state. </div>
              </div>
              <div class="col-md-3 mb-3">
                <label for="zip">Zip</label>
                <input type="text" class="form-control" id="zip" placeholder="" name="zip">
                <div class="invalid-feedback"> Zip code required. </div>
              </div>
            </div>
            <hr class="mb-4">
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection