<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil data pengguna yang sedang login
        $user = Auth::user();

        // 2. Format tanggal hari ini dalam bahasa Indonesia
        // Pastikan Carbon sudah di-setting ke locale Indonesia (biasanya di AppServiceProvider)
        $today = Carbon::now()->translatedFormat('l, j F Y');

        // 3. Data dummy untuk Acara Mendatang
        // Di aplikasi nyata, ini akan diambil dari database
        $upcomingEvents = [
            ['name' => 'Maulid Nabi', 'date' => Carbon::parse('2025-09-04'), 'logo' => '/images/logo-pesantren.png'],
            ['name' => 'Isra Mi\'raj', 'date' => Carbon::parse('2026-01-27'), 'logo' => '/images/logo-pesantren.png'],
        ];

        // Hitung sisa hari untuk setiap acara
        foreach ($upcomingEvents as &$event) {
            $event['days_left'] = Carbon::now()->diffInDays($event['date'], false);
        }

        // 4. Data dummy untuk Riwayat Absen
        // Di aplikasi nyata, ini akan diambil dari tabel absensi
        $attendanceHistory = [
            ['day' => 'Senin', 'date' => '21 April, 05:00 PM', 'year' => '2025', 'photo' => $user->photo ?? '/images/default-avatar.png'],
            ['day' => 'Selasa', 'date' => '22 April, 05:00 PM', 'year' => '2025', 'photo' => $user->photo ?? '/images/default-avatar.png'],
            ['day' => 'Rabu', 'date' => '23 April, 05:00 PM', 'year' => '2025', 'photo' => $user->photo ?? '/images/default-avatar.png'],
        ];

        // 5. Kirim semua data ke view
        return view('dashboard.index', [
            'user' => $user,
            'today' => $today,
            'upcomingEvents' => $upcomingEvents,
            'attendanceHistory' => $attendanceHistory,
        ]);
    }
}