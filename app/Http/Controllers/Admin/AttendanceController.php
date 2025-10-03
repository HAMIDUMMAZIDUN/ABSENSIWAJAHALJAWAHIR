<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon; // Import Carbon untuk manipulasi tanggal
use Barryvdh\DomPDF\Facade\Pdf; // Import untuk Ekspor PDF
use Maatwebsite\Excel\Facades\Excel; // Import untuk Ekspor Excel
use App\Exports\AttendanceExport; // Import class Export yang akan kita buat

class AttendanceController extends Controller
{
    /**
     * Menampilkan halaman rekapitulasi absensi dengan filter.
     */
    public function index(Request $request)
    {
        // Ambil tanggal awal dan akhir dari request, jika tidak ada, default ke bulan ini.
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        $query = Attendance::with('user')->latest('date');

        // Filter berdasarkan pencarian nama
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
        
        // Filter berdasarkan rentang tanggal yang sudah ditentukan (termasuk default)
        $query->whereBetween('date', [$startDate, $endDate]);
        
        $attendances = $query->paginate(15)->withQueryString();

        return view('admin.attendance.index', [
            'attendances' => $attendances,
            'startDate' => $startDate, // Kirim tanggal ke view agar form terisi
            'endDate' => $endDate,     // Kirim tanggal ke view agar form terisi
        ]);
    }

    /**
     * Fungsi untuk ekspor ke PDF.
     */
    public function exportPdf(Request $request)
    {
        // Logika query sama seperti di index, tapi tanpa paginasi
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        $query = Attendance::with('user')->latest('date');

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
        
        $query->whereBetween('date', [$startDate, $endDate]);

        // Ambil semua data yang cocok
        $attendances = $query->get();

        // Buat PDF
        $pdf = Pdf::loadView('admin.attendance.pdf', compact('attendances', 'startDate', 'endDate'));
        return $pdf->download('rekap-absensi-'. $startDate .'-'. $endDate .'.pdf');
    }

    /**
     * Fungsi untuk ekspor ke Excel.
     */
    public function exportExcel(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());
        $search = $request->input('search');

        return Excel::download(new AttendanceExport($startDate, $endDate, $search), 'rekap-absensi.xlsx');
    }

    /*
    |--------------------------------------------------------------------------
    | FUNGSI CRUD (Create, Read, Update, Delete) - Opsional
    |--------------------------------------------------------------------------
    | Di bawah ini adalah kerangka jika Anda ingin menambahkan fitur
    | untuk memanipulasi data absensi secara manual.
    */

    public function create()
    {
        // Tampilkan form untuk menambah data absensi baru
    }

    public function store(Request $request)
    {
        // Simpan data absensi baru dari form
    }

    public function edit(Attendance $attendance)
    {
        // Tampilkan form untuk mengedit data absensi
    }

    public function update(Request $request, Attendance $attendance)
    {
        // Update data absensi dari form edit
    }

    public function destroy(Attendance $attendance)
    {
        // Hapus data absensi
    }
}