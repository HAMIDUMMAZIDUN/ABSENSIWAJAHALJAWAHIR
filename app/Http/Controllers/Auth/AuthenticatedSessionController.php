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
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        
        // --- LOGIKA PENGECEKAN ROLE YANG DIPERBAIKI (Menggunakan kolom 'role') ---
        
        $user = Auth::user();

        // Cek jika kolom 'role' memiliki nilai 'admin'
        if ($user && $user->role === 'admin') {
            // Jika user adalah admin, arahkan ke dashboard admin
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }

        // Jika user bukan admin (role = 'user'), arahkan ke dashboard user/app
        return redirect()->intended(route('app.dashboard', absolute: false));
        
        // --- AKHIR LOGIKA PENGECEKAN ROLE YANG DIPERBAIKI ---
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}