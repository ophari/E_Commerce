<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Watch Store')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
      <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">
@include('user.layout.navbar')

<main class="py-4">
  
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @yield('content')

</main>

<footer class="footer-modern bg-dark text-white pt-5 pb-4 mt-5">
    <div class="container">

        {{-- TOP: BRAND + NAV --}}
        <div class="row align-items-start mb-5 gy-4">

            {{-- BRAND --}}
            <div class="col-lg-4 ">
                <h2 class="fw-bold mb-3 " style="color: #C5A572; font-family: 'Playfair Display', serif;">
                    WATCHSTORE</span>
                </h2>

                <p class="text-white-50" style="max-width: 320px;">
                    Premium timepieces crafted with precision and timeless elegance.
                    Discover the perfect watch that reflects your personality.
                </p>
            </div>

            {{-- QUICK LINKS --}}
            <div class="col-lg-2 col-6">
                <h6 class="fw-bold mb-3 text-uppercase small text-white-50">Navigate</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="/" class="footer-link">Home</a></li>
                    <li class="mb-2"><a href="{{ route('product.list') }}" class="footer-link">Products</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">About Us</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Contact</a></li>
                </ul>
            </div>

            {{-- SUPPORT --}}
            <div class="col-lg-2 col-6">
                <h6 class="fw-bold mb-3 text-uppercase small text-white-50">Support</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#" class="footer-link">FAQ</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Shipping</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Returns</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Warranty</a></li>
                </ul>
            </div>
        </div>

        <hr class="border-secondary mb-4">

        {{-- BOTTOM: COPYRIGHT + SOCIAL --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">

            <p class="mb-2 mb-md-0 text-white-50 small">
                © {{ date('Y') }} WATCHSTORE. All rights reserved.
            </p>

            {{-- SOCIAL ICONS --}}
            <div class="d-flex gap-3">
                <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                <a href="#" class="social-icon"><i class="bi bi-tiktok"></i></a>
                <a href="#" class="social-icon"><i class="bi bi-youtube"></i></a>
            </div>
        </div>
    </div>
</footer>

{{-- FOOTER STYLE --}}
<style>
    .footer-link {
        color: #d4d4d4;
        text-decoration: none;
        transition: 0.2s ease;
    }
    .footer-link:hover {
        color: #C5A572;
        padding-left: 3px;
    }

    .social-icon {
        font-size: 1.25rem;
        color: #d4d4d4;
        transition: 0.25s ease;
    }
    .social-icon:hover {
        color: #C5A572;
        transform: translateY(-3px);
    }
</style>


@include('user.layout.firebase') {{-- optional, can be empty or placeholder --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
@include('user.layout.script')
</body>
</html>
