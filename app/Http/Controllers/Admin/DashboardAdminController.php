<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Tambahkan Hash untuk password
use Illuminate\Validation\Rule; // Tambahkan Rule untuk validasi unique email

class DashboardAdminController extends Controller
{
    public function index()
    {
        // Pastikan tidak menyertakan user Admin yang sedang login, dan hanya user biasa
        $users = User::where('role', 'user') // Filter hanya user biasa jika ada kolom role
                      ->where('id', '!=', Auth::id())
                      ->latest()
                      ->paginate(10);
        
        return view('admin.dashboard', array_merge($this->getUserStats(), [
            'users' => $users
        ]));
    }

    // --- PENAMBAHAN BARU: Metode untuk menampilkan form edit ---
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // --- PENAMBAHAN BARU: Metode untuk memproses update ---
    public function update(Request $request, User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Aksi tidak diizinkan. Anda tidak dapat mengedit akun Anda sendiri melalui manajemen pengguna.');
        }
        
        // 1. Validasi Data
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 
                        Rule::unique('users')->ignore($user->id)], // Email harus unik kecuali untuk diri sendiri
            'phone' => ['nullable', 'string', 'max:15'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'], // 'confirmed' mencari field password_confirmation
            'role' => ['required', 'string', Rule::in(['admin', 'user'])], // Tambahkan validasi role
        ]);

        // 2. Update Data
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->phone = $validatedData['phone'];
        $user->role = $validatedData['role'];

        // Jika password diisi, update dan hash
        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        return redirect()->route('admin.dashboard')->with('success', "Data pengguna {$user->name} berhasil diperbarui.");
    }
    // --- AKHIR PENAMBAHAN BARU ---

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

    // Metode untuk menghapus pengguna
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
    
    // Helper method untuk mengambil statistik
    private function getUserStats()
    {
        // Pastikan total user menghitung semua, sedangkan active/inactive hanya menghitung user biasa
        return [
            'totalUsers' => User::count(),
            'activeUsers' => User::where('role', 'user')->where('is_active', true)->count(),
            'inactiveUsers' => User::where('role', 'user')->where('is_active', false)->count(),
        ];
    }
}
