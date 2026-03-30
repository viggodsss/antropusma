<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class OtpVerificationController extends Controller
{
    private const OTP_MAX_ATTEMPTS = 5;
    private const OTP_LENGTH = 6;
    private const OTP_TTL_MINUTES = 10;

    public function create(Request $request): View
    {
        $email = (string) $request->query('email', '');

        return view('auth.verify-otp', [
            'email' => $email,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'otp' => ['required', 'digits:' . self::OTP_LENGTH],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'Akun tidak ditemukan.',
            ]);
        }

        if ($user->otp_verified_at) {
            return redirect()->route('login')->with('success', 'OTP sudah diverifikasi. Silakan login.');
        }

        if ((int) $user->otp_attempts >= self::OTP_MAX_ATTEMPTS) {
            throw ValidationException::withMessages([
                'otp' => 'Percobaan OTP sudah mencapai 5 kali. Klik kirim ulang OTP.',
            ]);
        }

        if (!$user->otp_code || !$user->otp_expires_at || now()->gt($user->otp_expires_at)) {
            throw ValidationException::withMessages([
                'otp' => 'Kode OTP sudah kedaluwarsa. Silakan kirim ulang OTP.',
            ]);
        }

        if (!Hash::check($validated['otp'], $user->otp_code)) {
            $user->increment('otp_attempts');
            $remaining = max(self::OTP_MAX_ATTEMPTS - (int) $user->otp_attempts, 0);

            throw ValidationException::withMessages([
                'otp' => $remaining > 0
                    ? "Kode OTP salah. Sisa percobaan {$remaining} kali."
                    : 'Kode OTP salah. Batas percobaan habis, silakan kirim ulang OTP.',
            ]);
        }

        $user->forceFill([
            'status' => 'approved',
            'email_verified_at' => now(),
            'verified_at' => now(),
            'otp_verified_at' => now(),
            'otp_code' => null,
            'otp_expires_at' => null,
            'otp_attempts' => 0,
        ])->save();

        return redirect()->route('login')->with('success', 'Verifikasi OTP berhasil. Akun Anda aktif, silakan login.');
    }

    public function resend(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'Akun tidak ditemukan.',
            ]);
        }

        if ($user->otp_verified_at) {
            return redirect()->route('login')->with('success', 'Akun sudah terverifikasi. Silakan login.');
        }

        try {
            [$otp, $hashedOtp, $expiresAt] = $this->generateOtpPayload();

            $user->forceFill([
                'otp_code' => $hashedOtp,
                'otp_expires_at' => $expiresAt,
                'otp_attempts' => 0,
            ])->save();

            $this->sendOtpEmail($user->email, $user->name, $otp);
        } catch (\Throwable) {
            throw ValidationException::withMessages([
                'email' => 'Kirim ulang OTP gagal. Periksa konfigurasi email server.',
            ]);
        }

        return redirect()->route('otp.verify', ['email' => $user->email])
            ->with('status', 'Kode OTP baru sudah dikirim ke email Anda.');
    }

    public function issueOtpForUser(User $user): void
    {
        [$otp, $hashedOtp, $expiresAt] = $this->generateOtpPayload();

        $user->forceFill([
            'otp_code' => $hashedOtp,
            'otp_expires_at' => $expiresAt,
            'otp_attempts' => 0,
            'otp_verified_at' => null,
        ])->save();

        $this->sendOtpEmail($user->email, $user->name, $otp);
    }

    private function generateOtpPayload(): array
    {
        $otp = str_pad((string) random_int(0, 999999), self::OTP_LENGTH, '0', STR_PAD_LEFT);

        return [$otp, Hash::make($otp), now()->addMinutes(self::OTP_TTL_MINUTES)];
    }

    private function sendOtpEmail(string $email, string $name, string $otp): void
    {
        $message = "Halo {$name},\n\n" .
            "Kode OTP verifikasi akun pasien Anda adalah: {$otp}\n" .
            'Kode ini berlaku selama ' . self::OTP_TTL_MINUTES . " menit.\n\n" .
            'Jika Anda tidak merasa mendaftar, abaikan email ini.';

        try {
            Mail::raw($message, static function ($mail) use ($email): void {
                $mail->to($email)->subject('Kode OTP Verifikasi Akun Pasien');
            });
        } catch (\Throwable $exception) {
            throw new \RuntimeException('Gagal mengirim email OTP.', previous: $exception);
        }
    }
}
