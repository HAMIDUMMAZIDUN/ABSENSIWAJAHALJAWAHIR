<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use App\Models\User; // Import model User

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
        // 1. Validasi diubah ke 'phone'
        $request->validate([
            'phone' => ['required', 'string'],
        ]);

        // 2. Cari pengguna berdasarkan nomor handphone
        $user = User::where('phone', $request->phone)->first();

        // 3. Jika pengguna tidak ditemukan, kembalikan error
        if (!$user) {
            return back()->withInput($request->only('phone'))
                         ->withErrors(['phone' => 'Nomor handphone ini tidak terdaftar.']);
        }

        // 4. Buat token reset dan kirim notifikasi (simulasi)
        // Logika ini menggantikan Password::sendResetLink
        $token = Password::broker()->createToken($user);

        // Di dunia nyata, Anda akan mengirim token ini via SMS/WhatsApp
        // Contoh: $user->notify(new ResetPasswordNotification($token));
        
        // Untuk sekarang, kita anggap link berhasil dikirim
        $status = Password::RESET_LINK_SENT;
        
        return back()->with('status', __($status));
    }
}
