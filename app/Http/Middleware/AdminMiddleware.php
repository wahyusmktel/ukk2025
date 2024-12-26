<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Periksa apakah pengguna saat ini adalah admin
        if (Auth::guard('admin')->check()) {
            return $next($request); // Lanjutkan jika sudah login sebagai admin
        }

        // Redirect jika tidak diotorisasi
        return redirect()->route('login')->with('error', 'Unauthorized access.');
    }
}
