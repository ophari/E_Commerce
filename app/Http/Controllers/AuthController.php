<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Exception\Auth\InvalidIdToken;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // ========================
    //  LOGIN FORM
    // ========================
    public function showLoginForm(Request $request)
    {
        // Cegah browser men-cache halaman login
        $response = response()->view('auth.login');
        $response->header('Cache-Control', 'no-cache, no-store, must-revalidate');
        $response->header('Pragma', 'no-cache');
        $response->header('Expires', '0');

        // Kalau sudah login, arahkan ke halaman sesuai role
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('user.home');
            }
        }

        return $response;
    }

    // ========================
    //  PROSES LOGIN
    // ========================
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        // Cek login
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            return $user->role === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('user.home');
        }

        // Jika gagal login
        return back()->with('error', 'Email atau password salah.');
    }

    // ========================
    //  REGISTER FORM
    // ========================
    public function showRegisterForm()
    {
        // Kalau sudah login, arahkan ke halaman sesuai role
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('user.home');
            }
        }

        return view('auth.register');
    }



    // ========================
    //  LOGIN
    // ========================
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            } else {
                return redirect()->intended(route('user.home'));
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // ========================
    //  REGISTER
    // ========================
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user',
            ]);

            Auth::login($user);

            return redirect()->route('user.home');
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            return back()->withErrors([
                'email' => 'An error occurred while creating your account. Please try again.',
            ]);
        }
    }

    // ========================
    //  LOGOUT
    // ========================
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }

    // =======================
    //  FIREBASE LOGIN
    // =======================
    public function firebaseLogin(Request $request, FirebaseAuth $firebaseAuth)
    {
        $idToken = $request->input('idToken');

        if (empty($idToken)) {
            return response()->json(['error' => 'ID token is missing.'], 400);
        }

        try {
            $verifiedIdToken = $firebaseAuth->verifyIdToken($idToken);
        } catch (InvalidIdToken $e) {
            Log::error('Firebase login failed: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid ID token.'], 401);
        } catch (\Throwable $e) {
            Log::error('Firebase login failed: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred during token verification.'], 500);
        }

        $uid = $verifiedIdToken->claims()->get('sub');
        $email = $verifiedIdToken->claims()->get('email');
        $name = $verifiedIdToken->claims()->get('name', '');

        try {
            $user = User::firstOrCreate(
                ['firebase_uid' => $uid],
                [
                    'email' => $email,
                    'name' => $name,
                    'password' => Hash::make(uniqid()), // Generate a random password
                    'role' => 'user', // default role
                ]
            );

            Auth::login($user);

            return response()->json(['message' => 'Successfully authenticated.']);

        } catch (\Throwable $e) {
            Log::error('Error creating or logging in user: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred while processing your request.'], 500);
        }
    }
}
