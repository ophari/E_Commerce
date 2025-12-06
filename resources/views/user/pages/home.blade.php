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
                                        <img src="{{ asset('image/' . $product->image_url) }}" class="object-fit-cover w-100 h-100">
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

  {{-- ABOUT SECTION (digabung dari about.blade.php) --}}
  <section class="about-section fade-up container py-5">
    <div class="row align-items-center">
      <div class="col-md-6 mb-4 mb-md-0">
        <img src="{{ asset('image/about-img.jpg') }}"
             class="img-fluid rounded-4 shadow-sm"
             alt="Luxury Watches">
      </div>
      <div class="col-md-6">
        <h2 class="fw-bold text-dark mb-3">About Our Store</h2>
        <p class="text-muted">
          Waktu adalah hal paling berharga yang kita miliki dan di <strong>WATCHSTORE</strong>,
          kami percaya setiap detik layak untuk dirayakan. Koleksi kami menampilkan jam tangan terbaik
          dari merek ternama seperti Rolex, Casio, dan Omega, yang memadukan presisi, keahlian,
          serta desain yang tak lekang oleh waktu.
        </p>
        <p class="text-muted">
          Di era digital saat ini, jam tangan bukan hanya alat penunjuk waktu tetapi juga cerminan
          dari gaya hidup, kedisiplinan, dan jati diri Anda. Baik Anda mencari keanggunan, ketahanan,
          maupun fungsi pintar, kami siap membantu Anda menemukan pasangan yang sempurna.
        </p>
        <a href="{{ route('product.list') }}" class="btn btn-dark mt-3 px-4 py-2">Explore Collection</a>
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
  <section class="container my-5 fade-up">
      <div class="d-flex justify-content-between align-items-center mb-4">
          <h3 class="fw-bold text-dark">Our Products</h3>
          <a href="{{ route('product.list') }}" class="btn btn-outline-dark btn-sm px-3">See All</a>
      </div>

      <div class="row g-4 our-products">
          @foreach ($ourProducts as $product)
          <div class="col-6 col-md-3">

              <a href="{{ route('product.detail', $product->id) }}"
                class="text-decoration-none text-dark d-block">

                  <div class="our-product-card card border-0 shadow-sm h-100">

                      <div class="ratio ratio-1x1 bg-light">
                          <img src="{{ asset('image/' . $product->image_url) }}"
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

    {{-- FAQ SECTION --}}
  <section class="container fade-up py-5">
    <div class="text-center mb-5">
      <h3 class="fw-bold text-dark">Frequently Asked Questions</h3>
      <p class="text-muted">Temukan jawaban dari pertanyaan umum tentang pembelian di Watch Store.</p>
    </div>

    <div class="accordion shadow-sm" id="faqAccordion">

      {{-- Pertanyaan 1 --}}
      <div class="accordion-item">
        <h2 class="accordion-header" id="faqHeadingOne">
          <button class="accordion-button" type="button" data-bs-toggle="collapse"
                  data-bs-target="#faqCollapseOne" aria-expanded="true" aria-controls="faqCollapseOne">
            Bagaimana cara membeli produk di Watch Store?
          </button>
        </h2>
        <div id="faqCollapseOne" class="accordion-collapse collapse show"
             aria-labelledby="faqHeadingOne" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Pilih produk yang kamu suka, klik tombol <strong>“Shop Now”</strong> atau buka halaman detail produk.
            Setelah itu, tambahkan ke keranjang dan lanjutkan ke proses checkout untuk menyelesaikan pembayaran.
          </div>
        </div>
      </div>

      {{-- Pertanyaan 2 --}}
      <div class="accordion-item">
        <h2 class="accordion-header" id="faqHeadingTwo">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#faqCollapseTwo" aria-expanded="false" aria-controls="faqCollapseTwo">
            Metode pembayaran apa saja yang tersedia?
          </button>
        </h2>
        <div id="faqCollapseTwo" class="accordion-collapse collapse"
             aria-labelledby="faqHeadingTwo" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Kami mendukung berbagai metode pembayaran seperti <strong>transfer bank, e-wallet (OVO, GoPay, DANA),</strong>
            serta <strong>kartu kredit/debit</strong> melalui sistem pembayaran yang aman.
          </div>
        </div>
      </div>

      {{-- Pertanyaan 3 --}}
      <div class="accordion-item">
        <h2 class="accordion-header" id="faqHeadingThree">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#faqCollapseThree" aria-expanded="false" aria-controls="faqCollapseThree">
            Berapa lama pengiriman produk?
          </button>
        </h2>
        <div id="faqCollapseThree" class="accordion-collapse collapse"
             aria-labelledby="faqHeadingThree" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Pengiriman biasanya memakan waktu <strong>2–5 hari kerja</strong> tergantung lokasi kamu.
            Kami akan mengirimkan nomor resi agar kamu bisa melacak pesanan secara real-time.
          </div>
        </div>
      </div>

      {{-- Pertanyaan 4 --}}
      <div class="accordion-item">
        <h2 class="accordion-header" id="faqHeadingFour">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#faqCollapseFour" aria-expanded="false" aria-controls="faqCollapseFour">
            Apakah semua produk dijamin orisinal?
          </button>
        </h2>
        <div id="faqCollapseFour" class="accordion-collapse collapse"
             aria-labelledby="faqHeadingFour" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Ya! Semua produk yang dijual di <strong>Watch Store</strong> adalah 100% orisinal,
            bergaransi resmi, dan dikurasi langsung dari brand ternama dunia.
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
