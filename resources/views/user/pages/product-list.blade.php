@extends('user.layout.app')

@section('title','Products')

@section('content')
<div class="row">
  <div class="col-md-3">
    <h5>Filter</h5>
    <form method="GET" action="{{ route('user.products') }}">
      <div class="mb-2">
        <label class="form-label">Brand</label>
        <select class="form-select" name="brand">
          <option value="">All</option>
          <option value="Timeless">Timeless</option>
          <option value="ActiveX">ActiveX</option>
          <option value="Elegance">Elegance</option>
          <option value="Regal">Regal</option>
        </select>
      </div>
      <div class="mb-2">
        <label class="form-label">Type</label>
        <select class="form-select" name="type">
          <option value="">All</option>
          <option value="Classic">Classic</option>
          <option value="Sport">Sport</option>
          <option value="Digital">Digital</option>
          <option value="Luxury">Luxury</option>
        </select>
      </div>
      <div class="mb-2">
        <label class="form-label">Max Price</label>
        <input type="number" name="max_price" class="form-control" placeholder="e.g. 1000000">
      </div>
      <button class="btn btn-primary btn-sm">Terapkan</button>
    </form>
  </div>

  <div class="col-md-9">
    <h4 class="mb-3">Semua Produk</h4>
    <div class="row g-4">
      @foreach($products as $p)
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <img src="{{ $p['image'] }}" class="card-img-top" alt="{{ $p['name'] }}">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ $p['name'] }}</h5>
            <p class="text-muted mb-1">{{ $p['brand'] }}</p>
            <div class="fw-bold">Rp{{ number_format($p['price'],0,',','.') }}</div>

            <form action="{{ route('user.cart.add') }}" method="POST" class="mt-3">
              @csrf
              <input type="hidden" name="id" value="{{ $p['id'] }}">
              <input type="hidden" name="name" value="{{ $p['name'] }}">
              <input type="hidden" name="price" value="{{ $p['price'] }}">
              <input type="hidden" name="image" value="{{ $p['image'] }}">
              <button class="btn btn-dark btn-sm">Tambah ke Keranjang</button>
              <a href="{{ route('user.product.show', $p['id']) }}" class="btn btn-outline-secondary btn-sm ms-2">Detail</a>
            </form>

          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
