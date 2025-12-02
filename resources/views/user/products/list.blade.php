@extends('user.layout.app')

@section('title', 'Semua Produk | Watch Store')

@section('content')

<div class="container mt-5 pt-5">
    <div class="row align-items-center hero-list-wrapper">

        <!-- LEFT TEXT -->
        <div class="col-lg-6 mb-4 hero-list-text">
            <h1 class="fw-bold display-5 text-dark mb-3">
                Your Next <br>  
                Watch Awaits
            </h1>
            <p class="text-muted mb-3" style="max-width: 420px;">
                Temukan koleksi jam tangan premium dengan desain elegan, kualitas terbaik, 
                dan pengalaman berbelanja yang nyaman.
            </p>

            <a href="#product-section" class="btn btn-dark px-4 py-2 rounded-pill shadow-sm">
                Explore Now
            </a>
        </div>

        <!-- RIGHT IMAGE -->
        <div class="col-lg-6 text-center">
            <div class="hero-list-image rounded-4 overflow-hidden shadow-sm">
                <img src="/image/bg-list.jpg" class="w-100 object-fit-cover">
            </div>
        </div>
    </div>

    <!-- SEARCH / FILTER CARD UNDER IMAGE -->
    <div class="hero-list-card shadow-sm p-4 rounded-4 d-flex justify-content-around gap-4 flex-wrap">
        
        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-geo-alt fs-4 text-dark"></i>
            <div>
                <p class="mb-0 small text-muted">Kategori</p>
                <strong class="small">Semua Produk</strong>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-watch fs-4 text-dark"></i>
            <div>
                <p class="mb-0 small text-muted">Brand</p>
                <strong class="small">Semua Brand</strong>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-people fs-4 text-dark"></i>
            <div>
                <p class="mb-0 small text-muted">Cocok Untuk</p>
                <strong class="small">Pria & Wanita</strong>
            </div>
        </div>
    </div>
</div>

<div id="product-section"></div>

<div class="container py-5" style="margin-top: 130px;">
    <!-- Header -->
    <div class="text-center mb-5 position-relative">
        <h2 class="fw-bold text-dark">All Products</h2>
        <p class="text-muted">Temukan jam tangan premium dari berbagai merek ternama.</p>
        <hr class="mx-auto" style="width: 80px; height: 3px; background-color: #C5A572; opacity: 1;">
    </div>

    <!-- Product by Brand Section -->
    @foreach($brands as $brand)
        @php
            $brandProducts = $products->where('brand_id', $brand->id);
        @endphp

        @if($brandProducts->count() > 0)
            <div class="mb-5">
                <!-- Brand Header -->
                <div class="d-flex justify-content-between align-items-center mb-3 product-list-header">
                    <h4 class="product-list-title text-dark">
                        <i class="bi bi-gem text-warning me-2"></i> {{ $brand->name }}
                    </h4>
                    <a href="{{ route('product.list', ['brand' => $brand->id]) }}" class="text-decoration-none small text-muted">
                        Lihat semua →
                    </a>
                </div>

                <!-- Grid Produk -->
                <div class="row g-4 product-list">
                    @foreach($brandProducts->take(4) as $product)
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="{{ route('product.detail', $product->id) }}" 
                            class="text-decoration-none text-dark d-block">

                                <div class="product-card card border-0 shadow-sm h-100">

                                    <div class="ratio ratio-1x1 bg-light">
                                        <img src="{{ asset('image/' . $product->image_url) }}"
                                            class="object-fit-cover w-100 h-100 rounded-top"
                                            alt="{{ $product->name }}">
                                    </div>

                                    <div class="card-body text-center">

                                        <h6 class="product-name mb-1">{{ $product->name }}</h6>

                                        <p class="fw-bold price mb-2">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </p>

                                        <form action="{{ route('user.cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $product->id }}">

                                            <button type="submit" class="btn btn-sm btn-dark rounded-pill w-100">
                                                <i class="bi bi-cart me-1"></i> Add to Cart
                                            </button>
                                        </form>

                                    </div>

                                </div>

                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <hr class="my-4" style="opacity: 0.15;">
        @endif
    @endforeach

    @if($brands->every(fn($brand) => $products->where('brand_id', $brand->id)->isEmpty()))
        <div class="text-center py-5">
            <h5 class="text-muted">Belum ada produk yang tersedia.</h5>
        </div>
    @endif
</div>

@endsection
