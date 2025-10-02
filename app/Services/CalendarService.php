<?php

namespace App\Services;

use Carbon\Carbon;

class CalendarService
{
    /**
     * Mengambil daftar Hari Besar Islam (Hardcode yang Dikelola)
     * Ini digunakan sebagai pengganti paket Hijriyah yang gagal diinstal.
     * @param int $yearsAhead Jumlah tahun ke depan yang dicari.
     * @return array
     */
    public function getIslamicEvents(int $yearsAhead = 5): array
    {
        $now = Carbon::now()->startOfDay();
        $islamicEvents = [];
        
        // Data Hari Besar Islam (SIMULASI Masehi untuk 5 tahun)
        // Keterangan: Data ini harus di-update jika tanggal di Controller tidak sesuai lagi.
        $islamicEventsData = [
            // Tahun 2025 (Tahun ini)
            ['name' => 'Isra Mi\'raj', 'date' => Carbon::create(2025, 1, 27)],
            ['name' => 'Awal Ramadhan', 'date' => Carbon::create(2025, 2, 28)],
            ['name' => 'Idul Fitri', 'date' => Carbon::create(2025, 3, 30)],
            ['name' => 'Idul Adha', 'date' => Carbon::create(2025, 6, 6)],
            ['name' => 'Tahun Baru Islam', 'date' => Carbon::create(2025, 6, 26)],
            ['name' => 'Maulid Nabi', 'date' => Carbon::create(2025, 9, 24)],

            // Tahun 2026
            ['name' => 'Isra Mi\'raj', 'date' => Carbon::create(2026, 2, 16)],
            ['name' => 'Awal Ramadhan', 'date' => Carbon::create(2026, 2, 18)],
            ['name' => 'Idul Fitri', 'date' => Carbon::create(2026, 3, 19)],
            ['name' => 'Idul Adha', 'date' => Carbon::create(2026, 5, 27)],
            ['name' => 'Tahun Baru Islam', 'date' => Carbon::create(2026, 6, 15)],
            ['name' => 'Maulid Nabi', 'date' => Carbon::create(2026, 9, 13)],
            
            // Tahun 2027
            ['name' => 'Isra Mi\'raj', 'date' => Carbon::create(2027, 2, 5)],
            ['name' => 'Awal Ramadhan', 'date' => Carbon::create(2027, 2, 7)],
            ['name' => 'Idul Fitri', 'date' => Carbon::create(2027, 3, 9)],
            ['name' => 'Idul Adha', 'date' => Carbon::create(2027, 5, 17)],
            ['name' => 'Tahun Baru Islam', 'date' => Carbon::create(2027, 6, 4)],
            ['name' => 'Maulid Nabi', 'date' => Carbon::create(2027, 9, 3)],

            // Tahun 2028
            ['name' => 'Isra Mi\'raj', 'date' => Carbon::create(2028, 1, 25)],
            ['name' => 'Awal Ramadhan', 'date' => Carbon::create(2028, 1, 26)],
            ['name' => 'Idul Fitri', 'date' => Carbon::create(2028, 2, 26)],
            ['name' => 'Idul Adha', 'date' => Carbon::create(2028, 5, 5)],
            ['name' => 'Tahun Baru Islam', 'date' => Carbon::create(2028, 5, 23)],
            ['name' => 'Maulid Nabi', 'date' => Carbon::create(2028, 8, 22)],

            // Tahun 2029
            ['name' => 'Isra Mi\'raj', 'date' => Carbon::create(2029, 2, 13)],
            ['name' => 'Awal Ramadhan', 'date' => Carbon::create(2029, 2, 14)],
            ['name' => 'Idul Fitri', 'date' => Carbon::create(2029, 3, 15)],
            ['name' => 'Idul Adha', 'date' => Carbon::create(2029, 4, 23)],
            ['name' => 'Tahun Baru Islam', 'date' => Carbon::create(2029, 5, 12)],
            ['name' => 'Maulid Nabi', 'date' => Carbon::create(2029, 8, 11)],
        ];
        
        foreach ($islamicEventsData as $event) {
            $eventDate = $event['date']->startOfDay();
            
            // Filter: Hanya yang akan datang
            if ($eventDate->greaterThanOrEqualTo($now)) {
                $islamicEvents[] = $event;
            }
        }

        // Urutkan berdasarkan tanggal terdekat
        usort($islamicEvents, fn($a, $b) => $a['date']->timestamp - $b['date']->timestamp);
        
        return $islamicEvents;
    }
    
    /**
     * Mengambil daftar Hari Libur Nasional (Hardcode yang Dikelola)
     * @param int $yearsAhead Jumlah tahun ke depan yang dicari.
     * @return array
     */
    public function getNationalHolidays(int $yearsAhead = 5): array
    {
        $now = Carbon::now()->startOfDay();
        $holidays = [];
        $currentYear = Carbon::now()->year;
        
        // Pola Hari Libur yang Tetap
        $fixedHolidays = [
            '01-01' => 'Tahun Baru Masehi',
            '05-01' => 'Hari Buruh Internasional',
            '06-01' => 'Hari Lahir Pancasila',
            '08-17' => 'Hari Kemerdekaan RI',
            '12-25' => 'Hari Raya Natal',
        ];

        for ($i = 0; $i < $yearsAhead; $i++) {
            $year = $currentYear + $i;
            
            // 1. Hari libur tanggal tetap
            foreach ($fixedHolidays as $monthDay => $name) {
                $date = Carbon::createFromFormat('Y-m-d', "{$year}-{$monthDay}");
                if ($date->greaterThanOrEqualTo($now)) {
                    $holidays[] = ['date' => $date, 'name' => $name];
                }
            }
            
            // 2. Hari libur yang bergeser (Simulasi)
            if ($year == 2025) {
                $holidays[] = ['date' => Carbon::create(2025, 3, 29), 'name' => 'Hari Raya Nyepi'];
                $holidays[] = ['date' => Carbon::create(2025, 4, 18), 'name' => 'Wafat Isa Al Masih'];
            } elseif ($year == 2026) {
                $holidays[] = ['date' => Carbon::create(2026, 3, 19), 'name' => 'Hari Raya Nyepi'];
                $holidays[] = ['date' => Carbon::create(2026, 4, 3), 'name' => 'Wafat Isa Al Masih'];
            } elseif ($year == 2027) {
                $holidays[] = ['date' => Carbon::create(2027, 3, 9), 'name' => 'Hari Raya Nyepi'];
                $holidays[] = ['date' => Carbon::create(2027, 3, 26), 'name' => 'Wafat Isa Al Masih'];
            } elseif ($year == 2028) {
                $holidays[] = ['date' => Carbon::create(2028, 3, 27), 'name' => 'Hari Raya Nyepi'];
                $holidays[] = ['date' => Carbon::create(2028, 4, 14), 'name' => 'Wafat Isa Al Masih'];
            } elseif ($year == 2029) {
                $holidays[] = ['date' => Carbon::create(2029, 3, 17), 'name' => 'Hari Raya Nyepi'];
                $holidays[] = ['date' => Carbon::create(2029, 3, 30), 'name' => 'Wafat Isa Al Masih'];
            }
        }
        
        usort($holidays, fn($a, $b) => $a['date']->timestamp - $b['date']->timestamp);
        
        return $holidays;
    }
}