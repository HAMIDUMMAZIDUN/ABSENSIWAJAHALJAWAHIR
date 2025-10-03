<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Face; // Asumsi Anda punya model bernama Face
use App\Models\User; // Import model User

class FaceController extends Controller
{
    /**
     * Menampilkan halaman manajemen data wajah.
     */
    public function index(Request $request)
    {
        // Query dasar untuk model Face dengan relasi ke User
        // Eager loading 'user' untuk optimasi query
        $query = Face::with('user')->latest();

        // Logika untuk pencarian
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->whereHas('user', function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('nip', 'like', '%' . $searchTerm . '%'); // Asumsi ada kolom 'nip' di tabel user
            });
        }

        // Ambil data dengan paginasi
        $faces = $query->paginate(10)->withQueryString(); // withQueryString agar filter tetap ada saat pindah halaman

        // Kirim data ke view
        return view('admin.faces.index', compact('faces'));
    }
}
