<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil 5 user pertama yang bukan admin untuk dijadikan contoh
        $users = User::where('role', 'user')->take(5)->get();

        if ($users->isEmpty()) {
            $this->command->info('Tidak ada user untuk dibuatkan data absensi. Silakan buat user terlebih dahulu.');
            return;
        }

        foreach ($users as $user) {
            // Membuat data absensi untuk 5 hari terakhir di BULAN INI (Oktober 2025)
            for ($i = 0; $i < 5; $i++) {
                Attendance::create([
                    'user_id' => $user->id,
                    'date' => Carbon::now()->subDays($i)->toDateString(), // Tanggal hari ini, kemarin, dst.
                    'check_in' => '08:0' . rand(0, 5), // Jam masuk acak antara 08:00 - 08:05
                    'check_out' => '17:0' . rand(0, 9), // Jam pulang acak antara 17:00 - 17:09
                    'status' => 'Hadir',
                ]);
            }

            // Membuat data absensi untuk BULAN LALU (September 2025)
             Attendance::create([
                'user_id' => $user->id,
                'date' => Carbon::now()->subMonth()->startOfMonth()->addDays(rand(0,4))->toDateString(),
                'check_in' => '08:15',
                'check_out' => '17:00',
                'status' => 'Terlambat',
            ]);
        }
        
        $this->command->info('Data absensi dummy berhasil dibuat.');
    }
}