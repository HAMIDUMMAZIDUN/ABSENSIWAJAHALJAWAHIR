<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Exception;

class UserController extends Controller
{
    /**
     * Menampilkan halaman manajemen pengguna.
     */
    public function index()
    {
        $users = User::where('role', 'user')
                       ->where('id', '!=', Auth::id())
                       ->latest()
                       ->paginate(10);
        
        return view('admin.users.index', array_merge($this->getUserStats(), [
            'users' => $users
        ]));
    }

    /**
     * Menampilkan form untuk mengedit pengguna.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Memperbarui data pengguna di database.
     */
    public function update(Request $request, User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Aksi tidak diizinkan.');
        }
        
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 
                        Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:15'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', Rule::in(['admin', 'user'])],
        ]);

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        try {
            $user->update($validatedData);
            // Redirect kembali ke halaman index pengguna, bukan dashboard utama
            return redirect()->route('admin.users.index')->with('success', "Data pengguna {$user->name} berhasil diperbarui.");
        } catch (Exception $e) {
            return redirect()->back()->with('error', "Gagal memperbarui data. Error: " . $e->getMessage());
        }
    }

    /**
     * Mengubah status aktif/nonaktif satu pengguna.
     */
    public function toggleUserStatus(Request $request, User $user)
    {
        if ($user->id === Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Aksi tidak diizinkan.'], 403);
        }

        $request->validate(['is_active' => 'required|boolean']);

        $user->is_active = $request->is_active ? 1 : 2;

        if ($user->save()) {
            $message = ($user->is_active == 1) ? 'diaktifkan' : 'dinonaktifkan';
            return response()->json(array_merge(
                ['success' => true, 'message' => "Pengguna {$user->name} berhasil {$message}."],
                $this->getUserStats()
            ));
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal mengubah status.'], 500);
        }
    }

    /**
     * Mengubah status beberapa pengguna sekaligus (aksi massal).
     */
    public function bulkStatusUpdate(Request $request)
    {
        $validated = $request->validate([
            'userIds' => 'required|array',
            'userIds.*' => 'exists:users,id',
            'status' => 'required|integer|in:1,2',
        ]);

        $filteredUserIds = collect($validated['userIds'])->filter(fn($id) => $id != Auth::id());

        if ($filteredUserIds->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Tidak ada pengguna yang valid.'], 400);
        }

        User::whereIn('id', $filteredUserIds)->update(['is_active' => $validated['status']]);

        $count = $filteredUserIds->count();
        $action = $validated['status'] == 1 ? 'diaktifkan' : 'dinonaktifkan';
        
        return response()->json(array_merge(
            ['success' => true, 'message' => "$count pengguna berhasil $action."],
            $this->getUserStats()
        ));
    }

    /**
     * Menghapus pengguna dari database.
     */
    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Aksi tidak diizinkan.'], 403);
        }

        $userName = $user->name;
        
        if($user->delete()){
             return response()->json(array_merge(
                ['success' => true, 'message' => "Pengguna {$userName} berhasil dihapus."],
                $this->getUserStats()
            ));
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus pengguna.'], 500);
        }
    }
    
    /**
     * Helper untuk mengambil statistik pengguna.
     */
    private function getUserStats()
    {
        return [
            'totalUsers' => User::count(),
            'activeUsers' => User::where('role', 'user')->where('is_active', 1)->count(),
            'inactiveUsers' => User::where('role', 'user')->where('is_active', 2)->count(),
        ];
    }
}
