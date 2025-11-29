@extends('user.layout.app')

@section('title', 'Semua Produk | Watch Store')

@section('content')

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

                                        <p class="text-muted small">{{ $brand->name }}</p>

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
