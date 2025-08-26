<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $photo = $user->photo ?? '/images/default-avatar.png';

        // Data dummy untuk riwayat absensi
        // Di aplikasi nyata, ini akan diambil dari database
        $allHistory = [
            // Tepat Waktu
            ['day' => 'Senin', 'date' => '21 April, 05:00 PM', 'year' => '2025', 'time' => '13:00', 'status' => 'on_time', 'photo' => $photo],
            ['day' => 'Selasa', 'date' => '22 April, 05:00 PM', 'year' => '2025', 'time' => '13:00', 'status' => 'on_time', 'photo' => $photo],
            ['day' => 'Rabu', 'date' => '23 April, 05:00 PM', 'year' => '2025', 'time' => '13:00', 'status' => 'on_time', 'photo' => $photo],
            
            // Terlambat
            ['day' => 'Kamis', 'date' => '24 April, 05:00 PM', 'year' => '2025', 'time' => '13:15', 'status' => 'late', 'photo' => $photo],
            ['day' => 'Jum\'at', 'date' => '25 April, 05:00 PM', 'year' => '2025', 'time' => '13:05', 'status' => 'late', 'photo' => $photo],
        ];

        // Filter data berdasarkan tab yang aktif
        $filter = $request->query('filter', 'tepat-waktu'); // Default 'tepat-waktu'
        
        $historyData = [];
        if ($filter == 'tepat-waktu') {
            $historyData = array_filter($allHistory, fn($item) => $item['status'] == 'on_time');
        } else {
            $historyData = array_filter($allHistory, fn($item) => $item['status'] == 'late');
        }
        
        return view('history.index', [
            'historyData' => $historyData,
            'filter' => $filter,
        ]);
    }
}