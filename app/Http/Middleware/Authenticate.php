<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika belum login → redirect ke login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
