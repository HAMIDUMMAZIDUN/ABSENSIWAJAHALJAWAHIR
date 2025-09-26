<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan pengguna sudah login DAN memiliki peran 'admin'.
        // Sesuaikan 'role' === 'admin' dengan struktur tabel users Anda (misal: is_admin == 1).
        if (auth()->check() && auth()->user()->role === 'admin') {
            // Jika benar admin, lanjutkan ke halaman yang dituju.
            return $next($request);
        }

        // Jika bukan admin, tolak akses dan arahkan ke halaman lain.
        return redirect('/home')->with('error', 'Anda tidak memiliki hak akses.');
    }
}