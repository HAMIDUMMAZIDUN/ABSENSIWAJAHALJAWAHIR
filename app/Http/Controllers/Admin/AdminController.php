<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->latest()->paginate(10);
        
        return view('admin.dashboard', array_merge($this->getUserStats(), [
            'users' => $users
        ]));
    }

    public function toggleUserStatus(Request $request, User $user)
    {
        if ($user->id === Auth::id()) {
            return response()->json(['message' => 'Aksi tidak diizinkan. Anda tidak dapat mengubah status akun Anda sendiri.'], 403);
        }

        $request->validate(['is_active' => 'required|boolean']);

        $user->is_active = $request->is_active;
        $user->save();

        $message = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return response()->json(array_merge(
            ['success' => true, 'message' => "Pengguna {$user->name} berhasil {$message}."],
            $this->getUserStats()
        ));
    }

    // PENAMBAHAN BARU: Metode untuk menghapus pengguna
    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return response()->json(['message' => 'Aksi tidak diizinkan. Anda tidak dapat menghapus akun Anda sendiri.'], 403);
        }

        $userName = $user->name;
        $user->delete();

        return response()->json(array_merge(
            ['success' => true, 'message' => "Pengguna {$userName} berhasil dihapus."],
            $this->getUserStats()
        ));
    }
    
    // PENAMBAHAN BARU: Helper method untuk mengambil statistik
    private function getUserStats()
    {
        return [
            'totalUsers' => User::count(),
            'activeUsers' => User::where('is_active', true)->count(),
            'inactiveUsers' => User::where('is_active', false)->count(),
        ];
    }
}