<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
    //  PROSES REGISTER
    // ========================
    public function register(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Simpan user baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // default role
        ]);

        // Redirect ke login page dengan pesan sukses
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // ========================
    //  LOGOUT
    // ========================
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}
