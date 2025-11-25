document.addEventListener("DOMContentLoaded", () => {

        const loginBtn = document.getElementById("btn-login");
    const registerBtn = document.getElementById("btn-register");

    const loginPanel = document.querySelector(".login-panel");
    const registerPanel = document.querySelector(".register-panel");

    // Default
    loginBtn.addEventListener("click", () => {
        loginBtn.classList.add("active");
        registerBtn.classList.remove("active");

        loginPanel.classList.add("active");
        registerPanel.classList.remove("active");
    });

    registerBtn.addEventListener("click", () => {
        registerBtn.classList.add("active");
        loginBtn.classList.remove("active");

        registerPanel.classList.add("active");
        loginPanel.classList.remove("active");
    });

    document.addEventListener("DOMContentLoaded", () => {
        let loginHeight = document.querySelector(".login-panel").offsetHeight;
        document.querySelector(".register-panel").style.minHeight = loginHeight + "px";
    });

    document.getElementById('go-register')?.addEventListener('click', () => {
        document.getElementById('btn-register').click();
    });

        // Your web app's Firebase configuration
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

    const btnLogin = document.getElementById("btn-login");
    const btnRegister = document.getElementById("btn-register");
    const swap = document.getElementById("swap-container");

    btnLogin.addEventListener("click", () => {
        swap.classList.remove("swap-right");
    });

    btnRegister.addEventListener("click", () => {
        swap.classList.add("swap-right");
    });

});