@extends('user.layout.app')

@section('title', $product->name)

@section('content')
<div class="row">
  <div class="col-md-6">
    <img src="{{ asset('storage/' . $product->image_url) }}" class="img-fluid rounded shadow" alt="{{ $product->name }}">
  </div>
  <div class="col-md-6">
    <h1>{{ $product->brand->name }}</h1>

    <p class="text-muted">{{ $product->brand->name }} • {{ ucfirst($product->type) }}</p>
    <div class="fw-bold mb-3">Rp{{ number_format($product->price,0,',','.') }}</div>
    <p class="text-muted">Stok: {{ $product->stock }}</p>
    <p>{{ $product->description }}</p>
  </div>
</div>

@if($related->count() > 0)
<section class="mt-5">
  <h3>Produk Terkait</h3>
  <div class="row g-3">
    @foreach($related as $rel)
    <div class="col-md-3">
      <div class="card h-100 shadow-sm">
        <img src="{{ asset('storage/' . $rel['image']) }}" class="card-img-top" alt="{{ $rel['name'] }}" style="height: 150px; object-fit: cover;">
        <div class="card-body">
          <h6 class="card-title">{{ $rel['name'] }}</h6>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</section>
@endif
@endsection
