<x-app-admin-layout>
    <x-slot name="title">
        Dasbor
    </x-slot>

    <div class="mb-6">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-5 flex items-center">
            <div class="bg-orange-100 dark:bg-orange-900/50 rounded-lg p-3">
                <svg class="w-6 h-6 text-orange-500 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2"></path></svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Guru</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ number_format($totalTeachers) }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <div class="flex flex-wrap justify-between items-center mb-4 gap-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Rekapitulasi Kehadiran</h3>
                <div class="flex space-x-1 border border-gray-200 dark:border-gray-700 rounded-md p-1 text-sm">
                    <a href="{{ route('admin.dashboard', ['filter' => 'this_week']) }}" class="px-3 py-1 rounded-md {{ $currentFilter == 'this_week' ? 'bg-indigo-500 text-white' : 'text-gray-500 dark:text-gray-400' }}">Minggu Ini</a>
                    <a href="{{ route('admin.dashboard', ['filter' => 'this_month']) }}" class="px-3 py-1 rounded-md {{ $currentFilter == 'this_month' ? 'bg-indigo-500 text-white' : 'text-gray-500 dark:text-gray-400' }}">Bulan Ini</a>
                    <a href="{{ route('admin.dashboard', ['filter' => 'this_year']) }}" class="px-3 py-1 rounded-md {{ $currentFilter == 'this_year' ? 'bg-indigo-500 text-white' : 'text-gray-500 dark:text-gray-400' }}">Tahun Ini</a>
                </div>
            </div>
            <div class="h-72"><canvas id="attendanceRecapChart"></canvas></div>
        </div>

        <div x-data="{ open: false }" class="relative">
            <button @click="open = true" class="w-full h-full text-left bg-gradient-to-br from-teal-500 to-teal-600 text-white p-6 rounded-lg shadow-lg transition-transform transform hover:-translate-y-1 active:scale-95 flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-semibold mb-2">Kalender Acara</h3>
                    <p class="font-light opacity-80">{{ explode(',', $today)[0] }},</p>
                    <p class="text-2xl font-bold tracking-wide">{{ trim(explode(',', $today, 2)[1]) }}</p>
                </div>
                <div class="text-right">
                    <i data-feather="calendar" class="w-10 h-10 opacity-30 inline-block"></i>
                </div>
            </button>

            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" @click="open = false"></div>
                <div class="flex items-center justify-center min-h-full p-4 text-center sm:p-0">
                    <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-xl transform transition-all sm:my-8 sm:w-full sm:max-w-lg w-full">
                        <div class="bg-teal-500 dark:bg-teal-700 px-6 py-4">
                            <h3 class="text-lg font-bold text-white" id="modal-title">Kalender & Agenda</h3>
                        </div>
                        <div class="p-6 text-left">
                            <h4 class="mb-3 text-md font-bold text-teal-600 dark:text-teal-400">Hari Besar Islam Mendatang</h4>
                            <div class="max-h-60 overflow-y-auto pr-2 mb-6">
                                @forelse($allIslamicEvents as $event)
                                <div class="flex justify-between items-center py-2 border-b last:border-b-0 dark:border-gray-700">
                                    <p class="text-gray-700 dark:text-gray-300 font-medium">{{ $event['name'] }}</p>
                                    <span class="text-xs font-semibold bg-teal-100 dark:bg-teal-900 text-teal-700 dark:text-teal-300 px-2 py-1 rounded-full">{{ $event['date']->translatedFormat('j M Y') }}</span>
                                </div>
                                @empty
                                <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada data.</p>
                                @endforelse
                            </div>
                            <h4 class="mb-3 text-md font-bold text-red-600 dark:text-red-400 border-t pt-4 dark:border-gray-700">Hari Libur Nasional</h4>
                            <div class="max-h-60 overflow-y-auto pr-2">
                                @forelse($nationalHolidays as $holiday)
                                <div class="flex justify-between items-center py-2 border-b last:border-b-0 dark:border-gray-700">
                                    <p class="text-gray-700 dark:text-gray-300 font-medium">{{ $holiday['name'] }}</p>
                                    <span class="text-xs font-semibold bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 px-2 py-1 rounded-full">{{ $holiday['date_formatted'] }}</span>
                                </div>
                                @empty
                                <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada data.</p>
                                @endforelse
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-900 px-4 py-3 sm:flex sm:flex-row-reverse">
                            <button type="button" @click="open = false" class="inline-flex w-full justify-center rounded-md border border-transparent bg-teal-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Kehadiran Guru Hari Ini</h3>
            <div class="h-40 relative"><canvas id="attendanceChart"></canvas></div>
            <div class="flex justify-around mt-4 text-center">
                <div>
                    <p class="text-2xl font-bold text-green-500">{{ $teachersPresent }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Hadir</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-red-500">{{ $teachersAbsent }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Tidak Hadir</p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') { feather.replace(); }

            const isDarkMode = document.documentElement.classList.contains('dark');
            const textColor = isDarkMode ? '#E5E7EB' : '#4B5563';
            const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';

            const recapCtx = document.getElementById('attendanceRecapChart').getContext('2d');
            new Chart(recapCtx, {
                type: 'bar',
                data: {
                    labels: {!! $attendanceLabels !!},
                    datasets: [{
                        label: 'Jumlah Kehadiran',
                        data: {!! $attendanceData !!},
                        backgroundColor: 'rgba(99, 102, 241, 0.8)',
                        borderColor: 'rgba(99, 102, 241, 1)',
                        borderWidth: 1,
                        borderRadius: 5,
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { color: textColor, stepSize: 10 },
                            grid: { color: gridColor }
                        },
                        x: { ticks: { color: textColor }, grid: { display: false } }
                    },
                    plugins: { legend: { display: false } }
                }
            });

            const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
            new Chart(attendanceCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Hadir', 'Tidak Hadir'],
                    datasets: [{
                        data: [{{ $teachersPresent }}, {{ $teachersAbsent }}],
                        backgroundColor: [
                            'rgba(16, 185, 129, 1)',
                            'rgba(239, 68, 68, 1)'
                        ],
                        borderColor: isDarkMode ? '#1F2937' : '#FFFFFF',
                        borderWidth: 4,
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed !== null) {
                                        label += context.parsed + ' orang';
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-admin-layout>