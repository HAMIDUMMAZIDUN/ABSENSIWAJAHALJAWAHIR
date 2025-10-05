<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Langsung gunakan model User

class FaceController extends Controller
{
    /**
     * Menampilkan halaman manajemen data wajah dari tabel users.
     */
    public function index(Request $request)
    {
        // Query dasar langsung ke model User
        $query = User::query()->latest();

        // Logika untuk pencarian nama atau nip
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('nip', 'like', '%' . $searchTerm . '%');
            });
        }

        // Ambil data dengan paginasi
        // Ganti nama variabel dari $faces menjadi $users
        $users = $query->paginate(10)->withQueryString();

        // Kirim data ke view
        return view('admin.faces.index', compact('users'));
    }
}