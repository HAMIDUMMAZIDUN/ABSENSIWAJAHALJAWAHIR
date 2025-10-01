<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class FaceScanController extends Controller
{
    /**
     * Menampilkan halaman untuk scan wajah.
     */
    public function index()
    {
        return view('facescan.index');
    }

    /**
     * Menerima dan memproses gambar untuk MEMPERBARUI FOTO PROFIL.
     */
    public function capture(Request $request)
    {
        $request->validate(['image' => 'required']);

        $user = Auth::user();

        // Mengambil data gambar dari format base64
        $imageData = $request->image;
        list($type, $imageData) = explode(';', $imageData);
        list(, $imageData) = explode(',', $imageData);
        $imageData = base64_decode($imageData);

        // Membuat nama file yang unik berdasarkan ID pengguna
        $fileName = 'profile-photos/' . $user->id . '_' . time() . '.jpeg';

        // Hapus foto lama jika ada
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        // Simpan file baru ke storage/app/public/profile-photos
        Storage::disk('public')->put($fileName, $imageData);

        // Update path foto di database
        $user->photo = $fileName;
        $user->save();

        // Redirect kembali ke halaman profil dengan pesan sukses
        return Redirect::route('profile.edit')->with('status', 'Foto profil dan data wajah berhasil diperbarui!');
    }
}
