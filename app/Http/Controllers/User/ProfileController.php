<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // 🏠 Halaman utama user
    public function home()
    {
        $user = Auth::user();
        return view('user.pages.home', compact('user'));
    }

    // 🧑‍💻 Form Edit Profil
    public function edit()
    {
        $user = Auth::user();
        return view('user.profile.edit', compact('user'));
    }

    // 💾 Simpan Perubahan Profil
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi data input
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'phone'       => 'nullable|string|max:20',
            'address'     => 'nullable|string|max:255',
        ]);

        // Simpan ke database
        $user->update($validated);

        return redirect()->route('user.profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }
}
