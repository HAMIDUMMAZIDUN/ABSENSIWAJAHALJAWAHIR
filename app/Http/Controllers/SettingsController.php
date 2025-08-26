<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    /**
     * Menampilkan halaman pengaturan utama.
     */
    public function index()
    {
        $user = Auth::user();
        return view('settings.index', compact('user'));
    }

    /**
     * Menampilkan form ganti username.
     */
    public function showUsernameForm()
    {
        return view('settings.username');
    }

    /**
     * Memproses pembaruan username.
     */
    public function updateUsername(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'username' => 'required|string|max:255|unique:users,name,' . $user->id,
        ]);
        $user->name = $request->username;
        $user->save();
        return redirect()->route('settings.index')->with('success', 'Username berhasil diperbarui!');
    }

    /**
     * Menampilkan form ganti kata sandi.
     */
    public function showPasswordForm()
    {
        return view('settings.password');
    }

    /**
     * Memproses pembaruan kata sandi.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('Kata sandi saat ini tidak cocok.');
                }
            }],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('settings.index')->with('success', 'Kata sandi berhasil diperbarui!');
    }
    
    /**
     * Memproses pembaruan notifikasi via AJAX/Fetch.
     */
    public function updateNotifications(Request $request)
    {
        $request->validate([
            'type' => 'required|in:activity,general',
            'status' => 'required|boolean',
        ]);
        
        $user = Auth::user();
        if ($request->type === 'activity') {
            $user->notify_account_activity = $request->status;
        } elseif ($request->type === 'general') {
            $user->notify_general = $request->status;
        }
        $user->save();
        return response()->json(['message' => 'Preferensi notifikasi diperbarui.']);
    }

    // ===== TAMBAHKAN FUNGSI INI =====
    /**
     * Memproses pembaruan tema via AJAX/Fetch.
     */
    public function updateTheme(Request $request)
    {
        $request->validate([
            'theme' => 'required|in:light,dark',
        ]);
        
        $user = Auth::user();
        $user->theme = $request->theme;
        $user->save();
        
        return response()->json(['message' => 'Tema berhasil diperbarui.']);
    }
    // ===================================
}