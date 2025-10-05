<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\CalendarService;

class DashboardAdminController extends Controller
{
    protected $calendarService;

    public function __construct(CalendarService $calendarService)
    {
        $this->calendarService = $calendarService;
    }

    public function index(Request $request)
    {
        Carbon::setLocale('id');
        $now = Carbon::now();
        $today = $now->translatedFormat('l, j F Y');

        $totalUsersAsTeachers = User::where('role', 'user')->count();

        $filter = $request->input('filter', 'this_week');
        $attendanceLabels = [];
        $attendanceData = [];
        switch ($filter) {
            case 'this_month':
                $daysInMonth = $now->daysInMonth;
                for ($day = 1; $day <= $daysInMonth; $day++) {
                    $date = $now->copy()->setDay($day);
                    $attendanceLabels[] = $date->format('d M');
                    $attendanceData[] = Attendance::whereDate('date', $date)->count();
                }
                break;
            case 'this_year':
                for ($month = 1; $month <= 12; $month++) {
                    $date = Carbon::create()->month($month);
                    $attendanceLabels[] = $date->format('M');
                    $attendanceData[] = Attendance::whereYear('date', $now->year)->whereMonth('date', $month)->count();
                }
                break;
            default:
                for ($i = 6; $i >= 0; $i--) {
                    $date = $now->copy()->subDays($i);
                    $attendanceLabels[] = $date->format('D');
                    $attendanceData[] = Attendance::whereDate('date', $date)->count();
                }
                break;
        }

        $yearsToGenerate = 5;
        $islamicEvents = $this->calendarService->getIslamicEvents($yearsToGenerate);
        foreach ($islamicEvents as &$event) {
            $event['days_left'] = $now->diffInDays($event['date'], false);
        }
        $longTermHolidays = $this->calendarService->getNationalHolidays($yearsToGenerate);
        $nationalHolidays = [];
        foreach ($longTermHolidays as $holiday) {
            $nationalHolidays[] = [
                'name' => $holiday['name'],
                'date_formatted' => $holiday['date']->translatedFormat('j F Y'),
                'year' => $holiday['date']->year,
            ];
        }

        $teachersPresentToday = 0;
        $teachersAbsentToday = 0;

        if ($totalUsersAsTeachers > 0) {
            $teachersPresentToday = Attendance::whereDate('date', $now)
                ->whereHas('user', function ($query) {
                    $query->where('role', 'user');
                })
                ->count();
            
            $teachersAbsentToday = $totalUsersAsTeachers - $teachersPresentToday;
        }

        return view('admin.dashboard', [
            'totalTeachers' => $totalUsersAsTeachers,
            'teachersPresent' => $teachersPresentToday,
            'teachersAbsent' => $teachersAbsentToday,
            'attendanceLabels' => json_encode($attendanceLabels),
            'attendanceData' => json_encode($attendanceData),
            'currentFilter' => $filter,
            'today' => $today,
            'allIslamicEvents' => $islamicEvents,
            'nationalHolidays' => $nationalHolidays,
        ]);
    }
}