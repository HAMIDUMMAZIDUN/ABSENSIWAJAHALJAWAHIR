<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class GuruDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        Carbon::setLocale('id');
        $today = Carbon::now()->translatedFormat('l, d F Y');
        $upcomingEvents = [/* data acara */];
        $attendanceHistory = [/* data riwayat */];

        return view('guru.dashboard', compact('user', 'today', 'upcomingEvents', 'attendanceHistory'));
    }
}