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

    <!-- Firebase -->
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js"></script>
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

<div class="container">
    <div class="row justify-content-center align-items-center shadow rounded bg-white" style="max-width: 900px; margin: auto;">

        <!-- Gambar Jam Tangan -->
        <div class="col-md-6 d-none d-md-block p-0">
            <img src="https://i.pinimg.com/736x/e4/b8/a6/e4b8a6f18e9c8e9491a0154e76f2df37.jpg"
                 alt="Watch Image"
                 class="img-fluid rounded-start" style="height:100%; object-fit: cover;">
        </div>

        <!-- Form Login -->
        <div class="col-md-6 p-5">
            <h4 class="text-center mb-4 fw-semibold">Login to Your Account</h4>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2">Login</button>
            </form>

            {{-- <div class="text-center mt-3">
                <small class="text-muted">or</small>
            </div>

            <div class="text-center mt-3">
                <button type="button" id="login-with-google" class="btn btn-outline-primary w-100 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-google" viewBox="0 0 16 16">
                        <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.25C3.21 7.243 3 8.07 3 9s.21 1.757.508 2.584C4.14 13.592 5.913 15 8 15c1.463 0 2.714-.546 3.636-1.491l2.284 2.284A7.959 7.959 0 0 1 8 16Z"/>
                    </svg>
                    Login with Google
                </button> --}}

                <div class="text-center mt-3">
                    <small class="text-muted">Don’t have an account?</small>
                    <a href="{{ route('register') }}" class="text-primary fw-semibold text-decoration-none">Register</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Redirect if already logged in -->
@if(Auth::check())
<script>
  window.location.replace('{{ Auth::user()->role === "admin" ? route("admin.dashboard") : route("home") }}');
</script>
@endif

<script>

      const firebaseConfig = {
          apiKey: "{{ config('firebase.api_key') }}",
          authDomain: "{{ config('firebase.auth_domain') }}",
          projectId: "{{ config('firebase.project_id') }}",
          storageBucket: "{{ config('firebase.storage_bucket') }}",
          messagingSenderId: "{{ config('firebase.messaging_sender_id') }}",
          appId: "{{ config('firebase.app_id') }}"
      };

      // Initialize Firebase
      firebase.initializeApp(firebaseConfig);    const auth = firebase.auth();
    const provider = new firebase.auth.GoogleAuthProvider();

    // Handle Google Login
    document.getElementById('login-with-google').addEventListener('click', () => {
        auth.signInWithPopup(provider)
            .then((result) => {
                // This gives you a Google Access Token. You can use it to access the Google API.
                const credential = result.credential;
                const token = credential.accessToken;
                // The signed-in user info.
                const user = result.user;

                // Get the ID token to send to your backend
                user.getIdToken().then((idToken) => {
                    // Send the token to your backend
                    fetch('{{ route("firebase.login") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            idToken: idToken
                        })
                    }).then(response => {
                        if (response.ok) {
                            // Redirect to the appropriate dashboard
                            window.location.replace('{{ route("home") }}'); // Default to user home
                        } else {
                            // Handle errors
                            console.error('Firebase login failed.');
                            alert('Firebase login failed. Please try again.');
                        }
                    }).catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
                });
            }).catch((error) => {
                // Handle Errors here.
                const errorCode = error.code;
                const errorMessage = error.message;
                // The email of the user's account used.
                const email = error.email;
                // The firebase.auth.AuthCredential type that was used.
                const credential = error.credential;
                console.error(errorCode, errorMessage);
                alert('Google login failed: ' + errorMessage);
            });
    });
</script>

</body>
</html>
