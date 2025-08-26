<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // TAMBAHKAN PENGECEKAN INI DI PALING ATAS
        if (auth()->user()->role !== 'admin') {
            // Jika pengguna yang login BUKAN admin,
            // tendang mereka ke dashboard biasa dengan pesan error.
            return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }

        // Kode di bawah ini hanya akan berjalan jika pengguna adalah admin
        $users = User::latest()->paginate(10); 
        
        return view('admin.dashboard', compact('users'));
    }
}