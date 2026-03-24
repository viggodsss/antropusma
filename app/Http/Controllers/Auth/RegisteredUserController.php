<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\PatientRegistrationOtpNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    private const OTP_SESSION_KEY = 'registration_otp_user_id';

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $otp = $this->generateOtp();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $this->normalizePhone((string) $request->phone),
            'password' => Hash::make($request->password),
            'role' => 'patient',
            'status' => 'pending',
            'otp_code_hash' => Hash::make($otp),
            'otp_expires_at' => now()->addMinutes(10),
            'otp_attempts' => 0,
        ]);

        $user->notify(new PatientRegistrationOtpNotification($otp));

        $request->session()->put(self::OTP_SESSION_KEY, $user->id);

        return redirect()->route('otp.verify.form')
            ->with('success', 'Kode OTP sudah dikirim ke email Anda. Masukkan OTP untuk aktivasi akun dan login otomatis.');
    }

    private function generateOtp(): string
    {
        return str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    private function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone) ?? '';
        if ($digits === '') {
            return '';
        }

        if (str_starts_with($digits, '0')) {
            return '62' . substr($digits, 1);
        }

        if (str_starts_with($digits, '8')) {
            return '62' . $digits;
        }

        return $digits;
    }
}
