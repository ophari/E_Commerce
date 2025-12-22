@extends('user.layout.app')

@section('title', 'Home | Watch Store')

@section('content')

<div class="container-fluid px-0">

{{-- HERO SECTION --}}
<!-- Background Fixed -->
<div class="hero-bg-fixed hero-zoom"></div>

<!-- Hero Wrapper -->
<div class="hero-wrapper d-flex align-items-center">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center">

            <!-- Kiri -->
            <div class="col-lg-12 fade-up col-md-8 hero-section mb-4 mb-lg-0">
                <h1 class="fw-bold display-5 mb-3" style="font-family:'Playfair Display', serif;">
                    Desain Abadi<br>Dibuat untuk Anda
                </h1>

                <h6 class="text-uppercase fw-semibold mb-3 bg-dark px-4 py-2 rounded text-center d-inline-block" style="color:#ffffff; letter-spacing:1px;">
                  Jam Tangan Berkualitas Terbaik
                </h6>

                <p class="lead mb-4 text-black" style="max-width: 400px; font-family:'Playfair Display', poppins;">
                    Temukan koleksi jam tangan premium yang memadukan 
                    keanggunan, ketepatan, dan gaya tanpa batas waktu.
                </p>

                <a href="{{ route('product.list') }}"
                   class="btn px-4 py-2 rounded-pill fw-semibold"
                   style="background-color: transparent; color:#0a0a0a; border: 2px solid #0a0a0a;">
                    Belanja Sekarang
                </a>
            </div>

        </div>
    </div>
</div>


{{-- BRAND MARQUEE (TEXT BASED & CLEANER) --}}
<section class="bg-white py-5 text-center position-relative overflow-hidden">
  <div class="container fade-up py-5">
    <h1 class="fw-bold text-dark mb-3">Find Your Perfect Timepiece</h1>
    <p class="text-muted mb-4">
      Discover luxury, style, and precision from world-renowned watch brands.
    </p>
    <a href="{{ route('product.list') }}" class="btn btn-dark px-4 py-2">Shop Now</a>
  </div>

  <div class="brand-marquee fade-up py-4 bg-light mt-5 border-top border-bottom">
    <div class="brand-track d-flex align-items-center">
      
      {{-- ULANGI DUA KALI UNTUK EFEK LOOPING SEMPURNA --}}
      @for ($i = 0; $i < 2; $i++)
        @foreach ($brands as $brand)
          {{-- Item Brand dengan Pembatas dan Lebar Terbatas --}}
          <div class="brand-text-item p-3 border-end border-2" style="width: 250px;"> 
            <p class="fw-bold h6 mb-1 text-dark text-nowrap">
              {{ $brand->name }}
            </p>
            {{-- Menggunakan text-truncate untuk memotong deskripsi jika terlalu panjang --}}
            <p class="text-muted small mb-0 text-truncate">
              {{ $brand->description ?? 'World-renowned precision and style.' }}
            </p>
          </div>
        @endforeach
      @endfor
      
    </div>
</section>

  {{-- PROMO BANNERS --}}
<div class="promo-full-bg my-5">

    <div class="px-4 mx-auto" style="max-width: 1200px;">
        <div class="row g-4">

            <div class="col-md-6">
                <div class="banner-card p-4 d-flex align-items-center slide-left justify-content-between h-100">
                    <div>
                        <h4 class="fw-bold mb-2 text-white">Best Deal</h4>
                        <p class="mb-3 text-white">Jowel Watch for Men</p>
                        <a href="{{ route('product.list') }}" class="btn btn-outline-light btn-sm px-3">Shop Now</a>
                    </div>
                    <img src="{{ asset('image/pmo1.jpg') }}" class="img-fluid rounded-3" style="max-width:180px;">
                </div>
            </div>

            <div class="col-md-6">
                <div class="banner-card p-4 d-flex align-items-center slide-right justify-content-between h-100">
                    <div>
                        <h4 class="fw-bold mb-2 text-white">Rich Watch</h4>
                        <p class="mb-3 text-white">Make a better life. Make a rich life.</p>
                        <a href="{{ route('product.list') }}" class="btn btn-outline-light btn-sm px-3">Shop Now</a>
                    </div>
                    <img src="{{ asset('image/pmo2.jpg') }}" class="img-fluid rounded-3" style="max-width:180px;">
                </div>
            </div>

        </div>
    </div>

</div>


{{-- BEST SELLER SECTION --}}
<section class="container my-5">
    <div class="row align-items-center">

        <!-- Kiri: Text -->
        <div class="col-lg-4 mb-4 fade-up text-lg-start text-center">
            <h3 class="fw-bold text-dark">Best Seller Product</h3>
            <p class="text-muted">
                Produk jam tangan paling laris bulan ini. Kualitas premium dengan desain elegan.
            </p>
            <a href="{{ route('product.list') }}" class="btn btn-outline-dark px-4">
                Lihat Lainnya
            </a>
        </div>

        <!-- Kanan: Slider -->
        <div class="col-lg-8 fade-up">

            <div class="best-seller-slider position-relative">

                <div class="best-seller-track">

                    {{-- 9 produk dibagi menjadi grup isi 3 --}}
                    @foreach ($bestSellers->take(9)->chunk(3) as $chunk)
                        <div class="slide-page">

                            @foreach ($chunk as $product)
                                <div class="product-card">

                                    <div class="ratio ratio-1x1 bg-light">
                                        <img src="{{ $product->image_url }}" class="object-fit-cover w-100 h-100">
                                    </div>

                                    <div class="card-body text-center">
                                        <div class="rating d-flex justify-content-center align-items-center gap-1">
                                          <span class="text-warning" style="font-size: 1.2rem;">★</span>
                                          <span class="fw-semibold">{{ $product->avg_rating }}</span>
                                      </div>

                                        <h6 class="mb-0 text-dark">{{ $product->name }}</h6>

                                        <p class="price mt-1">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </p>
                                    </div>

                                </div>
                            @endforeach

                        </div>
                    @endforeach
                </div>

                {{-- Dots --}}
                <div class="best-seller-dots mt-2"></div>
            </div>

        </div>

    </div>
</section>

  <section class="bg-light py-5 fade-up text-center">
    <div class="container">
      <h3 class="fw-bold mb-3">Why Watches Still Matter</h3>
      <p class="text-muted mx-auto" style="max-width: 700px;">
        Despite smartphones and digital clocks everywhere, a wristwatch remains a
        statement of confidence and class. It tells more than time — it tells your story.
      </p>
    </div>
  </section>

    {{-- OUR PRODUCT SECTION --}}
  <section class="container my-5">
      <div class="d-flex justify-content-between align-items-center fade-up mb-4">
          <h3 class="fw-bold text-dark">Our Products</h3>
          <a href="{{ route('product.list') }}" class="btn btn-outline-dark btn-sm px-3">See All</a>
      </div>

      <div class="row g-4 our-products fade-up">
          @foreach ($ourProducts as $product)
          <div class="col-6 col-md-3">

              <a href="{{ route('product.detail', $product->id) }}"
                class="text-decoration-none text-dark d-block">

                  <div class="our-product-card card border-0 shadow-sm h-100">

                      <div class="ratio ratio-1x1 bg-light">
                          <img src="{{ $product->image_url }}"
                              class="object-fit-cover w-100 h-100 rounded-top">
                      </div>

                      <div class="card-body text-center">

                          <h6 class="product-name mb-1">{{ $product->name }}</h6>

                          <p class="fw-bold price mb-2">
                              Rp {{ number_format($product->price, 0, ',', '.') }}
                          </p>

                          <button type="submit" class="btn btn-sm btn-dark rounded-pill">
                            <i class="bi bi-cart me-1"></i> Add to Cart
                          </button>

                      </div>

                  </div>

              </a>

          </div>
          @endforeach
      </div>
  </section>

<!-- ================= REVIEW SECTION ================= -->
<section class="py-5 ">
    <div class="container">

        <h3 class="fw-bold text-center text-dark mb-4">
            Customer Reviews
        </h3>

        <!-- Wrapper scroll horizontal -->
        <div class="d-flex overflow-auto gap-4 pb-3 pt-2">

            @forelse ($reviews as $review)
                <!-- Card Review -->
                <div class="card border-0 shadow-sm rounded-4 p-4"
                     style="min-width: 300px;">

                    <!-- Profile -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-dark text-white fw-bold d-flex 
                                    align-items-center justify-content-center"
                             style="width: 50px; height: 50px; font-size: 18px;">
                            {{ strtoupper(substr($review->user->name, 0, 1)) }}
                        </div>

                        <div class="ms-3">
                            <h6 class="fw-semibold text-dark mb-0">{{ $review->user->name }}</h6>
                            <small class="text-muted">
                                {{ $review->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>

                    <!-- Rating -->
                    <div class="d-flex align-items-center mb-1">
                        <span class="fw-bold">{{ $review->rating }}</span>
                        <i class="bi bi-star-fill black ms-1"></i>
                    </div>

                    <!-- Comment -->
                    <p class="text-muted mb-0" style="line-height: 1.5;">
                        {{ $review->comment }}
                    </p>
                </div>

            @empty
                <p class="text-center text-muted">Belum ada review.</p>
            @endforelse

        </div>

    </div>
</section>
</div>
@endsection
