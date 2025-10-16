@extends('user.layout.app')

@section('title','Home')

@section('content')
<section class="hero py-5">
  <div class="row align-items-center">
    <div class="col-md-6">
      <h1 class="display-5 fw-bold">Koleksi Jam Tangan Elegan</h1>
      <p class="lead">Jam tangan premium untuk gaya sehari-hari & acara spesial.</p>
      <a href="{{ route('user.products') }}" class="btn btn-lg">Belanja Sekarang</a>
    </div>
    <div class="col-md-6 text-center">
      <img src="https://images.unsplash.com/photo-1518552987719-86fbcd8e9fd3?auto=format&fit=crop&w=800&q=80" class="img-fluid rounded shadow" alt="hero">
    </div>
  </div>
</section>

<section class="py-5 bg-light">
  <div class="container">
    <h3 class="mb-4 text-center">Produk Unggulan</h3>
    <div class="products-carousel position-relative">
      <div class="d-flex overflow-hidden pb-3" id="productsCarousel">
        @foreach($featured as $p)
        <div class="product-slide me-4" style="min-width: 280px; flex-shrink: 0;">
          <div class="card h-100 shadow-sm">
            <img src="{{ asset('storage/' . $p['image']) }}" class="card-img-top" alt="{{ $p['name'] }}" style="height: 200px; object-fit: cover;">
            <div class="card-body d-flex flex-column">
              <h6 class="card-title">{{ $p['name'] }}</h6>
              <p class="text-muted mb-2">{{ $p['brand'] }}</p>
              <div class="mt-auto">
                <div class="fw-bold">Rp{{ number_format($p['price'],0,',','.') }}</div>
                <a href="{{ route('user.product.show', ['id' => $p['id']]) }}" class="btn btn-outline-dark btn-sm mt-2">Lihat</a>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      <button class="btn btn-dark position-absolute top-50 start-0 translate-middle-y" id="prevBtn" style="z-index: 10; left: -20px;">‹</button>
      <button class="btn btn-dark position-absolute top-50 end-0 translate-middle-y" id="nextBtn" style="z-index: 10; right: -20px;">›</button>
    </div>
  </div>
</section>

<section class="brands-section py-5">
  <div class="container">
    <h3 class="mb-4 text-center">Merek Terkenal</h3>
    <div class="brands-carousel">
      <div class="d-flex overflow-auto pb-3" style="scrollbar-width: none; -ms-overflow-style: none;">
        @foreach($brands as $brand)
        <div class="brand-card me-4" style="min-width: 300px;">
          <div class="card h-100 shadow-sm">
            <div class="card-body text-center">
              <h5 class="card-title">{{ $brand->name }}</h5>
              <p class="card-text text-muted">{{ Str::limit($brand->description, 100) }}</p>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

@foreach($productsByBrand as $brandGroup)
<section class="py-5 bg-light">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3>{{ $brandGroup['brand']->name }}</h3>
      <a href="{{ route('user.products') }}?brand={{ $brandGroup['brand']->id }}" class="btn btn-outline-dark btn-sm">Lihat Semua</a>
    </div>
    <div class="row g-4">
      @foreach($brandGroup['products'] as $product)
      <div class="col-md-3">
        <div class="card h-100 shadow-sm">
          <img src="{{ asset('storage/' . $product['image']) }}" class="card-img-top" alt="{{ $product['name'] }}" style="height: 200px; object-fit: cover;">
          <div class="card-body d-flex flex-column">
            <h6 class="card-title">{{ $product['name'] }}</h6>
            <div class="mt-auto">
              <div class="fw-bold">Rp{{ number_format($product['price'],0,',','.') }}</div>
              <div class="d-flex gap-2 mt-2">
                <a href="{{ route('user.product.show', ['id' => $product['id']]) }}" class="btn btn-outline-dark btn-sm flex-fill">Lihat</a>
                <form action="{{ route('user.cart.add') }}" method="POST" class="flex-fill">
                  @csrf
                  <input type="hidden" name="id" value="{{ $product['id'] }}">
                  <input type="hidden" name="name" value="{{ $product['name'] }}">
                  <input type="hidden" name="price" value="{{ $product['price'] }}">
                  <input type="hidden" name="image" value="{{ $product['image'] }}">
                  <button class="btn btn-dark btn-sm w-100">Beli</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endforeach
@endsection

@section('scripts')
