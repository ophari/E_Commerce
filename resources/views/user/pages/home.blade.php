@extends('user.layout.app')

@section('title','Home')

@section('content')
<section class="hero py-5">
  <div class="row align-items-center">
    <div class="col-md-6">
      <h1 class="display-5 fw-bold">Koleksi Jam Tangan Elegan</h1>
      <p class="lead text-muted">Jam tangan premium untuk gaya sehari-hari & acara spesial.</p>
      <a href="{{ route('user.products') }}" class="btn btn-dark btn-lg">Belanja Sekarang</a>
    </div>
    <div class="col-md-6 text-center">
      <img src="https://images.unsplash.com/photo-1518552987719-86fbcd8e9fd3?auto=format&fit=crop&w=800&q=80" class="img-fluid rounded shadow" alt="hero">
    </div>
  </div>
</section>

<section class="py-5">
  <h3 class="mb-4">Produk Unggulan</h3>
  <div class="row g-4">
    @foreach($featured as $p)
    <div class="col-3">
      <div class="card product-card h-100 shadow-sm">
        <img src="{{ $p['image'] }}" class="card-img-top" alt="{{ $p['name'] }}">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title">{{ $p['name'] }}</h5>
          <p class="text-muted mb-2">{{ $p['brand'] }}</p>
          <div class="mt-auto">
            <div class="fw-bold">Rp{{ number_format($p['price'],0,',','.') }}</div>
            <a href="{{ route('user.product.show', $p['id']) }}" class="btn btn-outline-dark btn-sm mt-2">Lihat</a>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</section>
@endsection
