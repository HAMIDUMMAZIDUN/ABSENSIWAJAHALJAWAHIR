<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin dengan data pengguna.
     */
    public function index()
    {
        // KEMBALI KE VERSI AWAL: Statistik menghitung semua user
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $inactiveUsers = User::where('is_active', false)->count();

        // KEMBALI KE VERSI AWAL: Daftar pengguna hanya menyembunyikan admin yang sedang login
        $users = User::where('id', '!=', Auth::id())->latest()->paginate(10);

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeUsers',
            'inactiveUsers',
            'users'
        ));
    }

    /**
     * Mengubah status aktif/nonaktif pengguna via AJAX.
     */
    public function toggleUserStatus(Request $request, User $user)
    {
        // PERUBAHAN: Hanya memeriksa apakah admin mencoba menonaktifkan diri sendiri.
        // Logika untuk admin lain dihapus.
        if ($user->id === Auth::id()) {
            return response()->json([
                'success' => false, 
                'message' => 'Aksi tidak diizinkan. Anda tidak dapat mengubah status akun Anda sendiri.'
            ], 403); // 403 Forbidden
        }

        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $user->is_active = $request->is_active;
        $user->save();

        $message = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return response()->json(['success' => true, 'message' => "Pengguna {$user->name} berhasil {$message}."]);
    }
}