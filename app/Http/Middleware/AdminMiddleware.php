<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Pastikan ini ada
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek jika user login DAN rolenya adalah 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request); // Lanjutkan
        }

        // Jika bukan admin, lempar ke dashboard user biasa
        return redirect(route('dashboard'))->with('error', 'Anda tidak memiliki hak akses admin.');
    }
}