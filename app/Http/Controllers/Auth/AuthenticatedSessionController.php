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

        if ($request->is('admin/login') && $user->role !== 'admin') {
            Auth::logout();
            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Akun ini bukan admin. Gunakan akun admin yang valid.']);
        }

        // 🔥 Pastikan role tidak null
        if (!$user->role) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Role tidak ditemukan.']);
        }

        if (in_array($user->role, ['patient', 'pasien']) && $user->status !== 'approved') {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Akun Anda masih menunggu verifikasi admin.']);
        }

        // 🔥 Redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }

        if (in_array($user->role, ['patient', 'pasien'])) {
            return redirect()->intended(route('dashboard'));
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