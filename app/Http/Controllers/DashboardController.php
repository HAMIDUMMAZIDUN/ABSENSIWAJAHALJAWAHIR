<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\CalendarService; // Import Service yang sudah dibuat
use App\Models\Attendance; // Import Model Attendance

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
        
        $yearsToGenerate = 5; 

        // 1. Hari Besar Islam
        $islamicEvents = $this->calendarService->getIslamicEvents($yearsToGenerate);
        
        foreach ($islamicEvents as &$event) {
            $event['days_left'] = $now->diffInDays($event['date'], false);
        }
        
        $upcomingEvents = array_slice($islamicEvents, 0, 3); 
        
        // 2. Hari Libur Nasional
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
        // --- PERUBAHAN UTAMA: Mengambil Riwayat Absensi dari Database ---
        // ------------------------------------------------------------------
        
        // Ambil 3 riwayat absensi terbaru dari database
        $rawAttendanceHistory = Attendance::where('user_id', $user->id)
                                          ->orderBy('created_at', 'desc')
                                          ->take(3)
                                          ->get();
                                          
        $attendanceHistory = $rawAttendanceHistory->map(function ($record) {
            // Menggunakan check_in_at sebagai waktu utama (karena created_at bisa saja berbeda)
            $date = $record->check_in_at ?? $record->created_at; 
            
            return [
                'day' => $date->translatedFormat('l'), // Contoh: Senin
                'date' => $date->translatedFormat('j F, h:i A'), // Contoh: 21 Oktober, 07:45 AM
                'year' => $date->format('Y'),
                'status' => $record->status, // Status: Hadir, Izin, etc.
                // Menggunakan foto profil user sebagai default jika foto_path absen kosong
                'photo' => $record->photo_path ? Storage::url($record->photo_path) : ($record->user->photo ? Storage::url($record->user->photo) : asset('images/default-avatar.png')),
            ];
        })->toArray();


        // 4. Kirim semua data ke view
        return view('dashboard.index', [
            'user' => $user,
            'today' => $today,
            'upcomingEvents' => $upcomingEvents,
            'allIslamicEvents' => $islamicEvents,
            'attendanceHistory' => $attendanceHistory, // Data Real dari DB
            'nationalHolidays' => $nationalHolidays,
        ]);
    }
}
