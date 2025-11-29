<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth | E-Commerce</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
</head>

<body class="auth-body">

<div class="auth-card shadow-lg">

    <!-- LEFT IMAGE -->
    <div class="auth-image d-none d-md-block">
        <img src="https://i.pinimg.com/736x/e4/b8/a6/e4b8a6f18e9c8e9491a0154e76f2df37.jpg" alt="">
    </div>

    <!-- RIGHT SIDE FORM -->
    <div class="auth-content">
        
        <!-- BRAND -->
        <h2 class="brand-title">
            WATCHSTORE
        </h2>
        <p class="welcome-text">Welcome Back to Elegance</p>

        <!-- NAV SWITCH -->
        <div class="auth-nav">
            <button id="btn-login" class="auth-switch-btn active">Login</button>
            <button id="btn-register" class="auth-switch-btn">Sign Up</button>
        </div>

        <!-- PANELS WRAPPER -->
        <div class="auth-panels">

            <!-- LOGIN PANEL -->
            <div class="panel login-panel active">
                <h4 class="text-center mb-4 fw-semibold text-dark">Login to Your Account</h4>

                <form action="{{ route('login.submit') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" autocomplete="email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" autocomplete="current-password" required>
                    </div>

                    <button class="btn btn-primary w-100 py-2">Login</button>

                    <p class="auth-hint text-center mt-3">
                        Don’t have an account yet? <span id="go-register" class="auth-link">Sign Up</span>
                    </p>

                    <div class="auth-divider"></div>

                    <button onclick="window.location='{{ route('home') }}'" class="btn btn-primary w-100 mt-3">
                        Back to Home
                    </button>
                </form>
            </div>

            <!-- REGISTER PANEL -->
            <div class="panel register-panel">
                <h4 class="text-center mb-4 fw-semibold text-dark">Create an Account</h4>

                <form action="{{ route('register.submit') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" autocomplete="name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" autocomplete="email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" autocomplete="tel" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" name="address" rows="3" autocomplete="street-address" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" autocomplete="new-password" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation" autocomplete="new-password" required>
                    </div>

                    <button class="btn btn-primary w-100 py-2">sign up</button>

                    <div class="auth-divider"></div>

                    <button onclick="window.location='{{ route('home') }}'" class="btn btn-primary w-100 mt-3">
                        Back to Home
                    </button>
                </form>
            </div>

        </div>

    </div>
</div>

<script src="{{ asset('js/auth.js') }}"></script>

@if(isset($mode) && $mode === 'register')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.getElementById("btn-register").click();
    });
</script>
@endif

</body>
</html>
