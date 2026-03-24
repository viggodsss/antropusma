<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Jika belum login → redirect ke login
        if (!Auth::check()) {
            if (in_array('admin', $roles)) {
                return redirect()->guest(route('admin.login'));
            }

            return redirect()->guest(route('login'));
        }

        $user = Auth::user();

        // Jika role tidak sesuai
        if (!in_array($user->role, $roles)) {
            if (in_array('admin', $roles)) {
                Auth::logout();

                return redirect()->guest(route('admin.login'))
                    ->with('error', 'Silakan login sebagai admin/loket untuk melakukan scan QR.');
            }

            return redirect()->guest(route('login'))
                ->with('error', 'Akses ditolak untuk role saat ini.');
        }

        return $next($request);
    }
}