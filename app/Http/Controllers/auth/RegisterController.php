<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class RegisterController extends Controller
{
    public function show()
    {
        return view('pages.auth.signup');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'no_hp'    => 'required|string|max:15',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'no_hp'    => $request->no_hp,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'is_verified' => false,
        ]);

        $otp = random_int(100000, 999999);

        session([
            'otp_code' => $otp,
            'otp_email' => $user->email,
            'otp_expires_at' => now()->addMinutes(5)
        ]);

        Mail::raw(
            "Kode OTP kamu: $otp\nBerlaku 5 menit.",
            fn ($m) => $m->to($user->email)->subject('Verifikasi Akun')
        );

        return redirect()->route('otp.form');
    }
}
