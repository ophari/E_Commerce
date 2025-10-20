@extends('user.layout.app')

@section('title', 'All Products | Watch Store')

@section('content')
<div class="container py-5">

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
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-semibold text-dark">
                    <i class="bi bi-gem text-warning me-2"></i> {{ $brand->name }}
                </h4>
                <a href="{{ route('user.product.list', ['brand' => $brand->id]) }}" class="text-decoration-none small text-muted">
                    Lihat semua →
                </a>
            </div>

            <!-- Grid Produk -->
            <div class="row g-4">
                @foreach($brandProducts->take(4) as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="{{ route('user.product.detail', $product->id) }}" 
                           class="text-decoration-none text-dark d-block">
                            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative product-card">
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         class="card-img-top" 
                                         alt="{{ $product->name }}" 
                                         style="height: 230px; object-fit: cover;">
                                </div>
                                <div class="card-body text-center p-3">
                                    <h6 class="fw-semibold text-dark mb-1">{{ $product->name }}</h6>
                                    <p class="text-muted small mb-1">{{ $brand->name }}</p>
                                    <p class="fw-bold text-dark mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
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
