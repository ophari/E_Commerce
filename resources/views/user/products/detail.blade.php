@extends('user.layout.app')

@section('title', $product->name . ' | Watch Store')

@section('content')
<div class="container py-5">
    <div class="row g-5 align-items-center">
        <!-- Gambar Produk -->
        <div class="col-md-6 text-center">
            <div class="border rounded-4 shadow-sm overflow-hidden">
                <img src="{{ asset('storage/' . $product->image) }}" 
                     class="img-fluid w-100" 
                     alt="{{ $product->name }}" 
                     style="max-height: 450px; object-fit: cover;">
            </div>
        </div>

        <!-- Detail Produk -->
        <div class="col-md-6">
            <h2 class="fw-bold text-dark mb-2">{{ $product->name }}</h2>
            <p class="text-muted mb-1">{{ $product->brand->name ?? 'Unknown Brand' }}</p>
            <h3 class="fw-semibold text-dark mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</h3>

            <p class="text-muted mb-4">{{ $product->description ?? 'Tidak ada deskripsi untuk produk ini.' }}</p>

            <div class="d-flex gap-3 mb-4">
                <form action="{{ route('user.cart.add') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="id" value="{{ $product->id }}">
                    <input type="hidden" name="name" value="{{ $product->name }}">
                    <input type="hidden" name="price" value="{{ $product->price }}">
                    <input type="hidden" name="image" value="{{ $product->image }}">
                    <button type="submit" class="btn btn-dark px-4 py-2 rounded-pill shadow-sm">
                        <i class="bi bi-cart me-2"></i> Add to Cart
                    </button>
                </form>
                <a href="{{ route('user.checkout', $product->id) }}" class="btn btn-outline-dark px-4 py-2 rounded-pill">
                    <i class="bi bi-bag-heart me-2"></i> Buy Now
                </a>
            </div>
        </div>
    </div>

    <!-- Produk Terkait -->
    @if($related->count() > 0)
    <hr class="my-5">

    <h4 class="fw-semibold text-dark mb-4 text-center">
        More from <span class="text-warning">{{ $product->brand->name }}</span>
    </h4>

    <div class="row g-4">
        @foreach($related as $r)
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('user.product.detail', $r->id) }}" 
                   class="text-decoration-none text-dark d-block">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden product-card h-100">
                        <img src="{{ asset('storage/' . $r->image) }}" 
                             class="card-img-top" 
                             alt="{{ $r->name }}" 
                             style="height: 230px; object-fit: cover;">
                        <div class="card-body text-center p-3">
                            <p class="fw-semibold text-dark mb-1">{{ $r->name }}</p>
                            <p class="fw-bold text-dark mb-0">Rp {{ number_format($r->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
