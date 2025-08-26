<?php
// File: app/Http/Controllers/WelcomeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Menampilkan halaman selamat datang.
     */
    public function index()
    {
        // Cek apakah pengguna sudah login, jika ya, arahkan ke dashboard
        if (auth()->check()) {
            return redirect('/dashboard');
        }

        // Jika belum, tampilkan halaman welcome
        return view('welcome');
    }
}