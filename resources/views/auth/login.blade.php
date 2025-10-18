<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | E-Commerce</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

<div class="container">
    <div class="row justify-content-center align-items-center shadow rounded bg-white" style="max-width: 900px; margin: auto;">

        <!-- Gambar Jam Tangan -->
        <div class="col-md-6 d-none d-md-block p-0">
            <img src="https://drive.google.com/file/d/1fpRajwbunmhXH8L8TvEMIgBmKlkCXDeU/view?usp=sharing"
                 alt="Watch Image"
                 class="img-fluid rounded-start" style="height:100%; object-fit: cover;">
        </div>

        <!-- Form Login -->
        <div class="col-md-6 p-5">
            <h4 class="text-center mb-4 fw-semibold">Login to Your Account</h4>

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <button class="btn btn-primary w-100 py-2">Login</button>

                <div class="text-center mt-3">
                    <small class="text-muted">Don’t have an account?</small>
                    <a href="{{ route('register') }}" class="text-primary fw-semibold text-decoration-none">Register</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Redirect if already logged in -->
@if(Auth::check())
<script>
  window.location.replace('{{ Auth::user()->role === "admin" ? route("admin.dashboard") : route("user.home") }}');
</script>
@endif

</body>
</html>
