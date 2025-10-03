<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Face;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;

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
        $user = Auth::user();
        return view('settings.index', compact('user'));
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
        return redirect()->route('app.settings.index')->with('success', 'Username berhasil diperbarui!');
    }

    /**
     * Menampilkan form ganti kata sandi.
     */
    public function showPasswordForm()
    {
        $user = Auth::user();
        return view('settings.index', compact('user'));
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
        return redirect()->route('app.settings.index')->with('success', 'Kata sandi berhasil diperbarui!');
    }
    
    /**
     * Menampilkan form untuk mengubah nomor handphone.
     */
    public function showPhoneForm()
    {
        return view('settings.phone', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Memproses pembaruan nomor handphone.
     */
    public function updatePhone(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'phone' => [
                'required',
                'numeric',
                'min:10',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        $user->phone = $request->phone;
        $user->save();

        return redirect()->route('app.settings.index')->with('success', 'Nomor handphone berhasil diperbarui.');
    }

    /**
     * Menampilkan halaman form pendaftaran wajah.
     */
    public function showFaceForm()
    {
        return view('settings.face-create', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Menyimpan data gambar wajah yang diambil.
     */
    public function storeFace(Request $request)
    {
        $request->validate([
            'image' => 'required',
        ]);

        $user = Auth::user();
        $imageData = $request->image;
        
        list($type, $imageData) = explode(';', $imageData);
        list(, $imageData)      = explode(',', $imageData);
        
        $decodedImage = base64_decode($imageData);
        
        $fileName = 'face_' . $user->id . '_' . uniqid() . '.png';
        $path = 'face_images/' . $fileName;

        Storage::disk('public')->put($path, $decodedImage);

        Face::updateOrCreate(
            ['user_id' => $user->id],
            ['face_image_path' => $path, 'is_verified' => true]
        );

        return redirect()->route('app.settings.index')->with('success', 'Wajah Anda berhasil didaftarkan!');
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

