<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title', 'Watch Store')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* kecil styling tambahan */
    .hero { background: linear-gradient(90deg, #f8fafc, #ffffff); }
    .product-card img { height: 220px; object-fit: cover; }
  </style>
      <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body class="bg-light">
@include('user.layout.navbar')

<main class="py-4">
  <div class="container">
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @yield('content')
  </div>
</main>

<footer class="bg-white border-top py-3">
  <div class="container text-center text-muted small">
    © {{ date('Y') }} WatchStore • Built with Laravel
  </div>
</footer>

@include('user.layout.firebase') {{-- optional, can be empty or placeholder --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
@include('user.layout.script')
</body>
</html>
