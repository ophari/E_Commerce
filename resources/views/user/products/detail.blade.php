@extends('user.layout.app')

@section('title', $product->name . ' | Watch Store')

@section('content')
<div class="container py-5">
    <div class="row g-5 align-items-center">
        <!-- Gambar Produk -->
        <div class="col-md-6 text-center">
            <div class="border rounded-4 shadow-sm overflow-hidden">
                <img src="{{ asset('image/' . $product->image_url) }}" 
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
                    <input type="hidden" name="image" value="{{ $product->image_url }}">
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
                <a href="{{ route('product.detail', $r->id) }}" 
                   class="text-decoration-none text-dark d-block">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden product-card h-100">
                        <img src="{{ asset('image/' . $r->image_url) }}" 
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

    <!-- REVIEW SECTION -->
    <hr class="my-5">

    <h3 class="fw-bold text-dark text-center mb-4">Customer Reviews</h3>

    @if($averageRating)
        <div class="text-center mb-4">
            <h4 class="fw-semibold">
                ⭐ {{ number_format($averageRating, 1) }} / 5.0
            </h4>
            <p class="text-muted">Berdasarkan {{ $reviews->count() }} ulasan</p>
        </div>
    @endif

    <div class="row g-4">
        @forelse($reviews as $review)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    
                    <!-- Profile -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center" 
                            style="width: 45px; height: 45px; font-size: 18px;">
                            {{ strtoupper(substr($review->user->name, 0, 1)) }}
                        </div>
                        <div class="ms-3">
                            <h6 class="fw-semibold mb-0">{{ $review->user->name }}</h6>
                            <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                        </div>
                    </div>

                    <!-- Rating (WHITE STARS) -->
                    <div class="mb-2 d-flex align-items-center gap-2">
                        <span style="color: #111111; font-size: 18px;">★</span>
                        <span class="fw-semibold text-dark">{{ number_format($review->rating, 1) }}</span>
                    </div>

                    <!-- Comment -->
                    <p class="text-muted mb-0">{{ $review->comment }}</p>
                </div>
            </div>
        @empty
            <p class="text-center text-muted">Belum ada review untuk produk ini.</p>
        @endforelse
    </div>
</div>
@endsection
