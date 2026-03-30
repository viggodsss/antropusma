<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );
        } catch (TransportExceptionInterface $e) {
            Log::error('Password reset email transport failed.', [
                'email' => $request->input('email'),
                'message' => $e->getMessage(),
            ]);

            return back()->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Email reset belum dapat dikirim. Konfigurasi SMTP sedang bermasalah. Silakan coba lagi beberapa saat atau hubungi admin.',
                ]);
        } catch (\Throwable $e) {
            Log::error('Password reset email unexpected failure.', [
                'email' => $request->input('email'),
                'message' => $e->getMessage(),
            ]);

            return back()->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Terjadi kendala saat mengirim email reset. Silakan coba lagi.',
                ]);
        }

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', $this->statusMessage($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => $this->statusMessage($status)]);
    }

    private function statusMessage(string $status): string
    {
        return match ($status) {
            Password::RESET_LINK_SENT => 'Link reset kata sandi sudah dikirim ke email Anda. Silakan cek inbox atau folder spam.',
            Password::RESET_THROTTLED => 'Terlalu banyak percobaan. Silakan tunggu sebentar sebelum mengirim ulang.',
            Password::INVALID_USER => 'Email tidak terdaftar di sistem kami.',
            default => 'Permintaan reset kata sandi gagal diproses. Silakan coba lagi.',
        };
    }
}
