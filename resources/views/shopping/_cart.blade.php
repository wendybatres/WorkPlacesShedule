@use('App\Models\Product')
<ul class="list-group mb-3 sticky-top">
  @foreach(cart()->content() as $item)
    @php
      $product = Product::find($item->id);
    @endphp
    <li class="list-group-item d-flex justify-content-between lh-condensed">
      <div>
        <h6 class="my-0">
          <button>X</button>
          {{ $product->name }}
        </h6>
        <small class="text-muted">{{ $product->description }}</small>
      </div>
      <span class="text-muted">${{ $product->price }}</span>
    </li>
  @endforeach
  <li class="list-group-item d-flex justify-content-between">
      <span>Total (MXN)</span>
      <strong>${{ cart()->total() }}</strong>
    </li>
</ul>