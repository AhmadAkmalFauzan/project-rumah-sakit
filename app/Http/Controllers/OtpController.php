<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\OtpMail;
use App\Models\User;
use Carbon\Carbon;

class OtpController extends Controller
{
    // Halaman permintaan OTP (input email)
    public function showRequestForm()
    {
        return view('auth.request-otp');
    }

    // Kirim OTP ke email
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $otp = rand(100000, 999999);
        $expiresAt = now()->addMinutes(10);

        DB::table('otp_codes')->updateOrInsert(
            ['email' => $request->email],
            ['otp' => $otp, 'expires_at' => $expiresAt, 'updated_at' => now()]
        );

        Mail::to($request->email)->send(new OtpMail($otp));

        // Simpan email ke session agar bisa dipakai nanti
        session(['email' => $request->email]);

        return redirect()->route('otp.form.verify')->with('status', 'Kode OTP dikirim ke email.');
    }

    // Halaman verifikasi OTP
    public function showVerifyForm()
    {
        return view('auth.verify-otp', ['email' => session('email')]);
    }

    // Verifikasi OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required'
        ]);

        $otpData = DB::table('otp_codes')
            ->where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$otpData || Carbon::parse($otpData->expires_at)->isPast()) {
            return back()->with('error', 'OTP tidak valid atau kadaluarsa.');
        }

        // Simpan email ke session untuk keperluan form reset
        session(['email_verified' => $request->email]);

        return redirect()->route('password.reset.otp.form');
    }

    // Halaman reset password setelah OTP terverifikasi
    public function showResetForm(Request $request)
    {
        $email = session('email_verified');

        if (!$email) {
            return redirect()->route('otp.form.request')->with('error', 'Akses tidak valid.');
        }

        return view('auth.reset-password-otp', ['email' => $email]);
    }

    // Proses ganti password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'User tidak ditemukan.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Bersihkan OTP dan session
        DB::table('otp_codes')->where('email', $request->email)->delete();
        session()->forget(['email', 'email_verified']);

        return redirect()->route('login')->with('status', 'Password berhasil diubah.');
    }
}
