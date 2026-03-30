<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display login form (pasien default)
     */
    public function create(): View
    {
        return view('auth.login-pasien');
    }

    /**
     * Handle login (pasien & admin auto redirect)
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        $role = strtolower(trim((string) $user->role));

        if ($request->is('admin/login') && !in_array($role, ['admin', 'petugas'], true)) {
            Auth::logout();
            return redirect()->route('admin.login')
            ->withErrors(['email' => 'Akun ini bukan admin/petugas. Gunakan akun yang valid.']);
        }

        // 🔥 Pastikan role tidak null
        if (!$role) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Role tidak ditemukan.']);
        }

        if (in_array($role, ['patient', 'pasien'], true) && $user->status !== 'approved') {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Akun Anda belum aktif. Selesaikan verifikasi OTP terlebih dahulu.']);
        }

        // 🔥 Redirect berdasarkan role
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($role === 'petugas') {
            return redirect()->route('petugas.dashboard');
        }

        if (in_array($role, ['patient', 'pasien'], true)) {
            return redirect()->route('dashboard');
        }

        // Jika role tidak dikenal
        Auth::logout();
        return redirect()->route('login')
            ->withErrors(['email' => 'Role tidak valid.']);
    }

    /**
     * Logout
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}