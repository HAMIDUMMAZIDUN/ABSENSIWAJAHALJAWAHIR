<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    /**
     * Menampilkan halaman pengaturan utama.
     */
    public function index()
    {
        $user = Auth::user();
        // Diperbarui: Mengarahkan ke view 'app.settings' yang benar
        return view('settings.index', compact('user'));
    }

    /**
     * Menampilkan form ganti username.
     */
    public function showUsernameForm()
    {
        // Diperbarui: Mengarahkan ke view 'app.settings.username'
        return view('settings.index');
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
        // Diperbarui: Redirect ke route 'app.settings.index'
        return redirect()->route('app.settings.index')->with('success', 'Username berhasil diperbarui!');
    }

    /**
     * Menampilkan form ganti kata sandi.
     */
    public function showPasswordForm()
    {
        // Diperbarui: Mengarahkan ke view 'app.settings.password'
        return view('settings.index');
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
        // Diperbarui: Redirect ke route 'app.settings.index'
        return redirect()->route('app.settings.index')->with('success', 'Kata sandi berhasil diperbarui!');
    }
    
    /**
     * Menampilkan form untuk mengubah nomor handphone.
     */
    public function showPhoneForm()
    {
        // Diperbarui: Mengarahkan ke view 'app.settings.phone'
        return view('settings.index', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Memproses pembaruan nomor handphone.
     */
    public function updatePhone(Request $request)
    {
        $user = Auth::user();

        // Validasi input nomor handphone
        $request->validate([
            'phone' => [
                'required',
                'numeric',      // Pastikan hanya angka
                'min:10',       // Minimal 10 digit
                Rule::unique('users')->ignore($user->id), // Unik, kecuali untuk user itu sendiri
            ],
        ]);

        // Simpan perubahan ke database
        $user->phone = $request->phone;
        $user->save();

        // Arahkan kembali ke halaman profil dengan pesan sukses
        return redirect()->route('profile.edit')->with('status', 'Nomor handphone berhasil diperbarui.');
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
}
