@extends('user.layout.app')

@section('title', 'Cart | Watch Store')

@section('content')
{{-- CTA (Ajak Belanja Lagi) --}}
<div class="container text-center my-5 fade-up">
    <h4 class="fw-bold mb-2">Belanja Lagi?</h4>
    <p class="text-muted mb-3">Temukan jam tangan premium lainnya untuk melengkapi gaya kamu.</p>

    <a href="{{ route('product.list') }}" class="btn btn-outline-dark px-4 py-2 rounded-pill">
        Lihat Semua Produk
    </a>
</div>

{{-- PREMIUM DIVIDER --}}
<div class="container my-5">
    <div class="luxury-divider mx-auto"></div>
</div>


{{-- REKOMENDASI PRODUK --}}
<div class="container my-5">
    <h4 class="fw-bold text-dark mb-3">Rekomendasi Untuk Kamu</h4>
    <p class="text-muted mb-4">Produk terbaik pilihan kami, mungkin cocok untuk kamu ✨</p>

    <div class="row g-4">
        @foreach($recommendedProducts->take(6) as $product)
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card border-0 shadow-sm h-100">

                    <div class="ratio ratio-1x1 bg-light">
                        <img src="{{ asset('image/' . $product->image_url) }}"
                             class="object-fit-cover w-100 h-100 rounded-top">
                    </div>

                    <div class="card-body p-2">
                        <h6 class="mb-1 text-dark text-truncate">{{ $product->name }}</h6>
                        <p class="fw-bold mb-0">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('product.list') }}" class="btn btn-dark px-4 py-2">
            Lihat Semua Jam
        </a>
    </div>
</div>
@endsection
