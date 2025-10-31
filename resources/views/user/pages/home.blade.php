@extends('user.layout.app')

@section('title', 'Home | Watch Store')

@section('content')

<div class="container-fluid px-0">

  {{-- HERO SECTION --}}
<section class="hero-section fade-up text-dark d-flex align-items-center py-5">
  <div class="container">
    <div class="row align-items-center">

      {{-- Kiri: Teks --}}
      <div class="col-lg-6 mb-4 mb-lg-0 hero-text">
        <h6 class="text-uppercase fw-semibold mb-2" style="color:#ad833f; letter-spacing:1px;">
          Jam Tangan Berkualitas Terbaik
        </h6>
        <h1 class="fw-bold display-5 mb-3" style="font-family:'Playfair Display', serif;">
          Desain Abadi<br>Dibuat untuk Anda
        </h1>
        <p class="lead mb-4 text-muted" style="max-width: 500px;">
          Temukan koleksi jam tangan premium yang memadukan keanggunan, ketepatan, dan gaya tanpa batas waktu.
        </p>
        <a href="{{ route('product.list') }}"
           class="btn px-4 py-2 rounded-pill fw-semibold"
           style="background-color:#C5A572; color:#000; border:none; transition:all 0.3s ease;">
           Belanja Sekarang
        </a>
      </div>

      {{-- Kanan: Gambar --}}
      <div class="col-lg-6 text-center hero-image">
        <img src="{{ asset('image/watch-hero.png') }}" alt="Watch Hero" class="img-fluid hero-img">
      </div>

    </div>
  </div>
</section>

  {{-- BRAND MARQUEE --}}
  <section class="bg-white py-5 fade-up text-center position-relative overflow-hidden">
    <div class="container py-5">
      <h1 class="fw-bold text-dark mb-3">Find Your Perfect Timepiece</h1>
      <p class="text-muted mb-4">
        Discover luxury, style, and precision from world-renowned watch brands.
      </p>
      <a href="{{ route('product.list') }}" class="btn btn-dark px-4 py-2">Shop Now</a>
    </div>

    <div class="brand-marquee py-4 bg-light mt-5 border-top border-bottom">
      <div class="brand-track d-flex align-items-center gap-5">
        @foreach ($brands as $brand)
          <img src="https://source.unsplash.com/200x100/?{{ urlencode($brand->name) }},watch" alt="{{ $brand->name }}" class="brand-logo">
        @endforeach
      </div>
    </div>
  </section>

  {{-- PROMO BANNERS --}}
  <section class="container fade-up my-5">
    <div class="row g-4">
      <div class="col-md-6">
        <div class="banner-card bg-dark text-white rounded-4 p-4 d-flex align-items-center justify-content-between shadow-sm h-100">
          <div>
            <h4 class="fw-bold mb-2">Best Deal</h4>
            <p class="mb-3">Jowel Watch for Men</p>
            <a href="#" class="btn btn-outline-light btn-sm px-3">Shop Now</a>
          </div>
          <img src="https://images.unsplash.com/photo-1518544801958-efcbf8a7ec10?auto=format&fit=crop&w=400&q=80"
               class="img-fluid rounded-3"
               alt="Watch Promo" style="max-width: 180px;">
        </div>
      </div>

      <div class="col-md-6">
        <div class="banner-card bg-secondary-subtle text-dark rounded-4 p-4 d-flex align-items-center justify-content-between shadow-sm h-100">
          <div>
            <h4 class="fw-bold mb-2">Rich Watch</h4>
            <p class="mb-3">Make a better life. Make a rich life.</p>
            <a href="#" class="btn btn-outline-dark btn-sm px-3">Shop Now</a>
          </div>
          <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=400&q=80"
               class="img-fluid rounded-3"
               alt="Watch Promo" style="max-width: 180px;">
        </div>
      </div>
    </div>
  </section>

  {{-- BEST SELLER PRODUCTS --}}
  <section class="container fade-up my-5">
    <div class="text-center mb-5">
      <h3 class="fw-bold text-dark">Best Seller Products</h3>
      <p class="text-muted">Top selling watches of this month</p>
    </div>

    <div class="row g-4">
      @foreach ($bestSellers as $product)
        <div class="col-6 col-md-4 col-lg-3 d-flex">
          <a href="{{ route('product.detail', $product->id) }}"
             class="text-decoration-none text-dark w-100">
            <div class="card border-0 shadow-sm text-center h-100 hover-shadow">
              <div class="ratio ratio-1x1 overflow-hidden rounded-top">
                <img src="{{ asset($product->image_url) }}"
                     class="card-img-top object-fit-cover"
                     alt="{{ $product->name }}">
              </div>
              <div class="card-body">
                <h6 class="card-title text-dark mb-1">{{ $product->name }}</h6>
                <p class="text-muted small mb-2">{{ $product->brand->name ?? '-' }}</p>
                <p class="fw-semibold text-dark mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <form action="{{ route('user.cart.add') }}" method="POST" class="mt-2">
                  @csrf
                  <input type="hidden" name="id" value="{{ $product->id }}">
                  <input type="hidden" name="name" value="{{ $product->name }}">
                  <input type="hidden" name="price" value="{{ $product->price }}">
                  <input type="hidden" name="image" value="{{ $product->image_url }}">
                  <button type="submit" class="btn btn-sm btn-dark rounded-pill">
                    <i class="bi bi-cart me-1"></i> Add to Cart
                  </button>
                </form>
              </div>
            </div>
          </a>
        </div>
      @endforeach
    </div>
  </section>

  {{-- ABOUT SECTION (digabung dari about.blade.php) --}}
  <section class="about-section fade-up container py-5">
    <div class="row align-items-center">
      <div class="col-md-6 mb-4 mb-md-0">
        <img src="https://source.unsplash.com/700x500/?watch,luxury"
             class="img-fluid rounded-4 shadow-sm"
             alt="Luxury Watches">
      </div>
      <div class="col-md-6">
        <h2 class="fw-bold text-dark mb-3">About Our Store</h2>
        <p class="text-muted">
          Waktu adalah hal paling berharga yang kita miliki dan di <strong>Watch Store</strong>,
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

  {{-- NEWSLETTER --}}
  <section class="newsletter fade-up py-5 bg-light text-center">
    <div class="container">
      <h4 class="fw-bold mb-3 text-dark">Join Our Newsletter Now</h4>
      <form class="d-flex justify-content-center">
        <input type="email" class="form-control w-50 rounded-start-pill" placeholder="Your email address">
        <button type="submit" class="btn btn-dark btn-lg rounded-end-pill px-4">Subscribe</button>
      </form>
    </div>
  </section>

</div>
@endsection
