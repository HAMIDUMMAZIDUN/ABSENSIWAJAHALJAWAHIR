<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\CalendarService; // Import Service yang sudah dibuat

class DashboardController extends Controller
{
    protected $calendarService;

    public function __construct(CalendarService $calendarService)
    {
        $this->calendarService = $calendarService;
    }

    public function index()
    {
        $user = Auth::user();
        Carbon::setLocale('id'); 
        $now = Carbon::now();
        $today = $now->translatedFormat('l, j F Y');
        
        // Atur cakupan tahun yang diinginkan
        $yearsToGenerate = 5; 

        // ------------------------------------------------------------------
        // --- 1. Hari Besar Islam (Diambil dari Service) ---
        // ------------------------------------------------------------------
        $islamicEvents = $this->calendarService->getIslamicEvents($yearsToGenerate);
        
        // Hitung hari tersisa dan siapkan data untuk view
        foreach ($islamicEvents as &$event) {
            $event['days_left'] = $now->diffInDays($event['date'], false);
        }
        
        // Ambil 3 acara terdekat untuk ditampilkan di kartu dashboard utama
        $upcomingEvents = array_slice($islamicEvents, 0, 3); 
        
        // ------------------------------------------------------------------
        // --- 2. Hari Libur Nasional (Diambil dari Service) ---
        // ------------------------------------------------------------------
        $longTermHolidays = $this->calendarService->getNationalHolidays($yearsToGenerate);
        
        $nationalHolidays = [];
        foreach ($longTermHolidays as $holiday) {
            $nationalHolidays[] = [
                'name' => $holiday['name'],
                'date_formatted' => $holiday['date']->translatedFormat('j F Y'),
                'year' => $holiday['date']->year,
            ];
        }
        
        // ------------------------------------------------------------------
        // --- 3. Riwayat Absensi (Data Dummy) ---
        // ------------------------------------------------------------------
        $attendanceHistory = [
            ['day' => 'Senin', 'date' => '21 April, 05:00 PM', 'year' => '2025', 'photo' => $user->photo ?? '/images/default-avatar.png'],
            ['day' => 'Selasa', 'date' => '22 April, 05:00 PM', 'year' => '2025', 'photo' => $user->photo ?? '/images/default-avatar.png'],
            ['day' => 'Rabu', 'date' => '23 April, 05:00 PM', 'year' => '2025', 'photo' => $user->photo ?? '/images/default-avatar.png'],
        ];

        // 4. Kirim semua data ke view
        return view('dashboard.index', [
            'user' => $user,
            'today' => $today,
            'upcomingEvents' => $upcomingEvents, // 3 Hari Besar Islam terdekat (untuk kartu)
            'allIslamicEvents' => $islamicEvents, // Semua Hari Besar Islam (untuk modal)
            'attendanceHistory' => $attendanceHistory,
            'nationalHolidays' => $nationalHolidays, // Semua Hari Libur Nasional (untuk modal)
        ]);
    }
}