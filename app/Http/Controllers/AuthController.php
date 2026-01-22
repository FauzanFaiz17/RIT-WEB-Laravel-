<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan Halaman Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect ke Dashboard atau Halaman Profile setelah login
            return redirect()->intended('/profile');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }
    // 3. Tampilkan Halaman Register
    public function showRegisterForm()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        // 1. Validasi Input 
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255|unique:users,email',
            'npm'       => 'required|numeric|unique:users,npm',
            'no_hp'     => 'required|numeric|digits_between:10,15',
            'password'  => 'required|string|min:8|confirmed',
        ], [
            // pesan error 
            'npm.unique' => 'NPM ini sudah terdaftar.',
            'npm.numeric' => 'NPM harus berupa angka.',
            'no_hp.numeric' => 'Nomor HP harus berupa angka.',
            'no_hp.digits_between' => 'Nomor HP harus antara 10 hingga 15 digit.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // 2. Simpan ke Database
        $user = \App\Models\User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'npm'      => $validated['npm'],
            'no_hp'    => $validated['no_hp'],
            'password' => bcrypt($validated['password']),
            // Kolom prodi, semester, tgl_lahir otomatis NULL (sesuai database)
        ]);

        // 3. Auto Login & Redirect
        \Illuminate\Support\Facades\Auth::login($user);

        return redirect()->route('profile.index')->with('success', 'Selamat bergabung! Silakan lengkapi profil Anda.');
    }

    // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
