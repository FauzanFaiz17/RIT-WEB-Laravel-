<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;


class OtpController extends Controller
{
    public function form()
    {
        return view('pages.auth.two-step');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        if (!session()->has('otp_code') || !session()->has('otp_email')) {
            return redirect()->route('signin')
                ->withErrors(['otp' => 'Session OTP tidak valid.']);
        }

        if (
            $request->otp !== (string) session('otp_code') ||
            now()->gt(session('otp_expires_at'))
        ) {
            return back()->withErrors(['otp' => 'Kode OTP salah atau kedaluwarsa.']);
        }

        $user = User::where('email', session('otp_email'))->first();

        if (!$user) {
            return redirect()->route('signin')
                ->withErrors(['otp' => 'User tidak ditemukan.']);
        }

        $user->update([
            'is_verified' => true,
            'email_verified_at' => now(),
        ]);

        session()->forget([
            'otp_code',
            'otp_email',
            'otp_expires_at',
        ]);

        auth()->login($user);

        return redirect()->route('dashboard');
    }



    // public function send()
    // {
    //     $otp = random_int(100000, 999999);

    //     Session::put('otp_code', $otp);
    //     Session::put('otp_expires_at', now()->addMinutes(5));

    //     // contoh kirim via log / email / sms
    //     logger("OTP: " . $otp);

    //     return view('auth.two-step');
    // }

    public function resend()
    {
        if (!session()->has('otp_email')) {
            return redirect()->route('signin')
                ->withErrors(['otp' => 'Session email tidak ditemukan.']);
        }

        $otp = random_int(100000, 999999);

        Session::put('otp_code', $otp);
        Session::put('otp_expires_at', now()->addMinutes(5));

        Mail::raw(
            "Kode OTP Anda adalah: {$otp}. Berlaku selama 5 menit.",
            function ($message) {
                $message->to(session('otp_email'))
                    ->subject('Kode OTP Verifikasi');
            }
        );

        logger("Resend OTP: " . $otp);

        return back()->with('success', 'OTP berhasil dikirim ulang');
    }


    // testing
    // public function resendOtp()
    // {
    //     $user = auth()->user();

    //     if (!$user) {
    //         return redirect('/two-step-verification');
    //     }

    //     $otp = random_int(100000, 999999);

    //     session([
    //         'otp_code' => $otp,
    //         'otp_email' => $user->email,
    //         'otp_expires_at' => now()->addMinutes(5),
    //     ]);

    //     Mail::raw(
    //         "Kode OTP kamu: $otp\nBerlaku 5 menit.",
    //         fn ($m) => $m->to($user->email)->subject('Verifikasi Akun')
    //     );

    //     return back()->with('success', 'OTP dikirim ulang ke email kamu');
    // }

}
