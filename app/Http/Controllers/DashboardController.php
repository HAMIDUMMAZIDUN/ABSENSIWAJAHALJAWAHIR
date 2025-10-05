<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\CalendarService;
use App\Models\Attendance;
use Illuminate\Support\Facades\Storage;
use App\Models\Announcement; // 1. PASTIKAN MODEL INI DI-IMPORT

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
        
        // 3. Mengambil Riwayat Absensi dari Database
        $rawAttendanceHistory = Attendance::where('user_id', $user->id)
                                            ->orderBy('created_at', 'desc')
                                            ->take(3)
                                            ->get();
                                            
        $attendanceHistory = $rawAttendanceHistory->map(function ($record) {
            $date = $record->check_in_at ?? $record->created_at; 
            
            return [
                'day' => $date->translatedFormat('l'),
                'date' => $date->translatedFormat('j F, h:i A'),
                'year' => $date->format('Y'),
                'status' => $record->status,
                'photo' => $record->photo_path ? Storage::url($record->photo_path) : ($record->user->photo ? Storage::url($record->user->photo) : asset('images/default-avatar.png')),
            ];
        })->toArray();
        
        // 4. MENGAMBIL DATA PENGUMUMAN (BARIS PENTING)
        $announcements = Announcement::where('is_active', true)->latest()->get();

        // 5. Kirim semua data ke view
        return view('dashboard.index', [
            'user' => $user,
            'today' => $today,
            'upcomingEvents' => $upcomingEvents,
            'allIslamicEvents' => $islamicEvents,
            'attendanceHistory' => $attendanceHistory,
            'nationalHolidays' => $nationalHolidays,
            'announcements' => $announcements, // <-- PASTIKAN VARIABEL INI DIKIRIM
        ]);
    }
}