<x-app-admin-layout>
    <x-slot name="title">
        Dashboard Admin
    </x-slot>

    {{-- 1. KARTU STATISTIK UTAMA --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 flex items-center">
            <div class="bg-teal-500 bg-opacity-20 text-teal-600 dark:text-teal-300 rounded-full p-3"><i data-feather="users" class="w-6 h-6"></i></div>
            <div class="ml-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Pengguna</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $totalUsers ?? 'N/A' }}</p>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 flex items-center">
            <div class="bg-green-500 bg-opacity-20 text-green-600 dark:text-green-300 rounded-full p-3"><i data-feather="user-check" class="w-6 h-6"></i></div>
            <div class="ml-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Pengguna Aktif</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $activeUsers ?? 'N/A' }}</p>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 flex items-center">
            <div class="bg-red-500 bg-opacity-20 text-red-600 dark:text-red-300 rounded-full p-3"><i data-feather="user-x" class="w-6 h-6"></i></div>
            <div class="ml-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Pengguna Nonaktif</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $inactiveUsers ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    {{-- 2. GRAFIK VISUALISASI DATA --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        
        {{-- Grafik Tren Absensi (Lebih besar) --}}
        <div class="lg:col-span-3 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Tren Absensi Mingguan</h3>
            <canvas id="attendanceChart"></canvas>
        </div>

        {{-- Grafik Status Pengguna (Lebih kecil) --}}
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Distribusi Status Pengguna</h3>
            <canvas id="userStatusChart"></canvas>
        </div>

    </div>

    @push('scripts')
    {{-- Memuat library Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }

            // --- Logika untuk Grafik Status Pengguna (Donut Chart) ---
            const userStatusCtx = document.getElementById('userStatusChart').getContext('2d');
            new Chart(userStatusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Aktif', 'Nonaktif'],
                    datasets: [{
                        label: 'Status Pengguna',
                        data: [{{ $activeUsers ?? 0 }}, {{ $inactiveUsers ?? 0 }}],
                        backgroundColor: [
                            'rgba(16, 185, 129, 0.7)', // Green-500
                            'rgba(239, 68, 68, 0.7)'   // Red-500
                        ],
                        borderColor: [
                            'rgba(16, 185, 129, 1)',
                            'rgba(239, 68, 68, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                color: document.documentElement.classList.contains('dark') ? '#E5E7EB' : '#4B5563'
                            }
                        }
                    }
                }
            });

            // --- Logika untuk Grafik Tren Absensi (Bar Chart) ---
            const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
            new Chart(attendanceCtx, {
                type: 'bar',
                data: {
                    labels: {!! $attendanceLabels !!},
                    datasets: [{
                        label: 'Jumlah Absensi',
                        data: {!! $attendanceData !!},
                        backgroundColor: 'rgba(79, 70, 229, 0.7)', // Indigo-600
                        borderColor: 'rgba(79, 70, 229, 1)',
                        borderWidth: 1,
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: document.documentElement.classList.contains('dark') ? '#E5E7EB' : '#4B5563',
                                stepSize: 5
                            },
                             grid: {
                                color: document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                            }
                        },
                        x: {
                             ticks: {
                                color: document.documentElement.classList.contains('dark') ? '#E5E7EB' : '#4B5563'
                            },
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                           display: false
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-admin-layout>

