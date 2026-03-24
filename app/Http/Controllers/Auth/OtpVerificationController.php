<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\PatientRegistrationOtpNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class OtpVerificationController extends Controller
{
    private const OTP_SESSION_KEY = 'registration_otp_user_id';
    private const OTP_TTL_MINUTES = 10;
    private const OTP_MAX_ATTEMPTS = 5;

    public function show(Request $request): View|RedirectResponse
    {
        $user = $this->getPendingUserFromSession($request);
        if (!$user) {
            return redirect()->route('register')->withErrors([
                'email' => 'Sesi verifikasi OTP tidak ditemukan. Silakan daftar kembali.',
            ]);
        }

        return view('auth.verify-otp', [
            'email' => $user->email,
            'expiresAt' => $user->otp_expires_at,
        ]);
    }

    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $user = $this->getPendingUserFromSession($request);
        if (!$user) {
            return redirect()->route('register')->withErrors([
                'email' => 'Sesi verifikasi OTP tidak ditemukan. Silakan daftar kembali.',
            ]);
        }

        if (($user->otp_attempts ?? 0) >= self::OTP_MAX_ATTEMPTS) {
            return back()->withErrors([
                'otp' => 'Percobaan OTP melebihi batas. Silakan kirim ulang OTP baru.',
            ]);
        }

        if (!$user->otp_expires_at || $user->otp_expires_at->isPast()) {
            return back()->withErrors([
                'otp' => 'Kode OTP sudah kedaluwarsa. Silakan kirim ulang OTP.',
            ]);
        }

        if (!Hash::check((string) $request->otp, (string) $user->otp_code_hash)) {
            $user->increment('otp_attempts');

            return back()->withErrors([
                'otp' => 'Kode OTP tidak sesuai.',
            ]);
        }

        $user->forceFill([
            'status' => 'approved',
            'verified_at' => now(),
            'email_verified_at' => now(),
            'otp_code_hash' => null,
            'otp_expires_at' => null,
            'otp_attempts' => 0,
        ])->save();

        Auth::login($user);

        $request->session()->forget(self::OTP_SESSION_KEY);
        $request->session()->regenerate();

        return redirect()->route('dashboard')
            ->with('success', 'OTP berhasil diverifikasi. Anda sudah login otomatis.');
    }

    public function resend(Request $request): RedirectResponse
    {
        $user = $this->getPendingUserFromSession($request);
        if (!$user) {
            return redirect()->route('register')->withErrors([
                'email' => 'Sesi verifikasi OTP tidak ditemukan. Silakan daftar kembali.',
            ]);
        }

        $otp = $this->generateOtp();

        $user->forceFill([
            'otp_code_hash' => Hash::make($otp),
            'otp_expires_at' => now()->addMinutes(self::OTP_TTL_MINUTES),
            'otp_attempts' => 0,
        ])->save();

        $user->notify(new PatientRegistrationOtpNotification($otp));

        return back()->with('success', 'OTP baru sudah dikirim ke email Anda.');
    }

    private function getPendingUserFromSession(Request $request): ?User
    {
        $userId = (int) $request->session()->get(self::OTP_SESSION_KEY, 0);
        if ($userId <= 0) {
            return null;
        }

        return User::where('id', $userId)
            ->whereIn('role', ['patient', 'pasien'])
            ->first();
    }

    private function generateOtp(): string
    {
        return str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }
}
