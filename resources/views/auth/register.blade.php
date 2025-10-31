<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | E-Commerce</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

<div class="container">
    <div class="row justify-content-center align-items-center shadow rounded bg-white flex-row-reverse" style="max-width: 900px; margin: auto;">

        <!-- Gambar Jam Tangan (kanan) -->
        <div class="col-md-6 d-none d-md-block p-0">
            <img src="https://i.pinimg.com/736x/e4/b8/a6/e4b8a6f18e9c8e9491a0154e76f2df37.jpg"
                 alt="Watch Image"
                 class="img-fluid rounded-end" style="height:100%; object-fit: cover;">
        </div>

        <!-- Form Register -->
        <div class="col-md-6 p-5">
            <h4 class="text-center mb-4 fw-semibold">Create an Account</h4>

            <form action="{{ route('register.submit') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                    @error('name')
                        <div class="text-danger mt-1"><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    @error('email')
                        <div class="text-danger mt-1"><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    @error('password')
                        <div class="text-danger mt-1"><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2">Register</button>
            </form>

            <div class="text-center mt-3">
                <small class="text-muted">Already have an account?</small>
                <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none">Login</a>
            </div>
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
