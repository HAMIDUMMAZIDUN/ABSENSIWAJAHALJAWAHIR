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
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $inactiveUsers = User::where('is_active', false)->count();

        // Ambil daftar pengguna selain admin yang sedang login
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
        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $user->is_active = $request->is_active;
        $user->save();

        $message = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return response()->json(['success' => true, 'message' => "Pengguna {$user->name} berhasil {$message}."]);
    }
}