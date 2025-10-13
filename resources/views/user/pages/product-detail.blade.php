@extends('user.layout.app')

@section('title', $product['name'])

@section('content')
<div class="row">
  <div class="col-md-6">
    <img src="{{ $product['image'] }}" class="img-fluid rounded shadow" alt="{{ $product['name'] }}">
  </div>
  <div class="col-md-6">
    <h2>{{ $product['name'] }}</h2>
    <p class="text-muted">{{ $product['brand'] }} • {{ $product['type'] }}</p>
    <div class="fw-bold mb-3">Rp{{ number_format($product['price'],0,',','.') }}</div>
    <p class="text-muted">Stok: {{ $product['stock'] }}</p>

    <form action="{{ route('user.cart.add') }}" method="POST" class="mb-3">
      @csrf
      <input type="hidden" name="id" value="{{ $product['id'] }}">
      <input type="hidden" name="name" value="{{ $product['name'] }}">
      <input type="hidden" name="price" value="{{ $product['price'] }}">
      <input type="hidden" name="image" value="{{ $product['image'] }}">

      <div class="mb-2">
        <label class="form-label">Jumlah</label>
        <input type="number" name="qty" value="1" min="1" class="form-control" style="width:120px;">
      </div>

      <button class="btn btn-dark">Tambah ke Keranjang</button>
    </form>

    <hr>

    <h5>Ulasan</h5>
    <form action="{{ route('user.review.store', $product['id']) }}" method="POST">
      @csrf
      <div class="mb-2">
        <input type="text" name="user" class="form-control" placeholder="Nama (atau Guest)">
      </div>
      <div class="mb-2">
        <select name="rating" class="form-select">
          <option value="5">5 — Excellent</option>
          <option value="4">4 — Very Good</option>
          <option value="3">3 — Good</option>
          <option value="2">2 — Fair</option>
          <option value="1">1 — Poor</option>
        </select>
      </div>
      <div class="mb-2">
        <textarea name="comment" class="form-control" rows="3" placeholder="Tulis ulasan..."></textarea>
      </div>
      <button class="btn btn-primary btn-sm">Kirim Ulasan</button>
    </form>
  </div>
</div>

<hr>
<h5 class="mt-4">Produk Terkait</h5>
<div class="row g-3">
  @foreach($related as $r)
    <div class="col-md-3">
      <div class="card">
        <img src="{{ $r['image'] }}" class="card-img-top" alt="{{ $r['name'] }}">
        <div class="card-body p-2">
          <small>{{ $r['name'] }}</small>
        </div>
      </div>
    </div>
  @endforeach
</div>
@endsection
