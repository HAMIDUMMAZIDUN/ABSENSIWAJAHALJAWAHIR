<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
// Anda mungkin perlu mengimpor model Absensi Anda di sini
// use App\Models\Attendance; 

class DashboardAdminController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama admin dengan statistik dan data grafik.
     */
    public function index()
    {
        // --- Data Statistik Pengguna ---
        $activeUsers = User::where('role', 'user')->where('is_active', 1)->count();
        $inactiveUsers = User::where('role', 'user')->where('is_active', 2)->count();
        $totalUsers = User::count();

        // --- Data Grafik Tren Absensi (Contoh Data untuk 7 Hari Terakhir) ---
        // Catatan: Ganti logika ini dengan query absensi Anda yang sebenarnya.
        $attendanceLabels = [];
        $attendanceData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            // Menambahkan label hari (e.g., 'Senin', 'Selasa')
            $attendanceLabels[] = $date->translatedFormat('l'); 
            
            // Contoh: Menghitung absensi pada hari tersebut (ganti dengan query Anda)
            // $attendanceCount = Attendance::whereDate('created_at', $date)->count();
            // $attendanceData[] = $attendanceCount;

            // Untuk sekarang, kita gunakan data acak sebagai contoh
            $attendanceData[] = rand(5, 25); 
        }

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'inactiveUsers' => $inactiveUsers,
            'attendanceLabels' => json_encode($attendanceLabels),
            'attendanceData' => json_encode($attendanceData),
        ]);
    }
}

