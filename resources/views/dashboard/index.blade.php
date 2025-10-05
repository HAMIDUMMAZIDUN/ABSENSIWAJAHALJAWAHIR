<x-app-layout>
    <main class="p-6 pb-24 bg-slate-50 dark:bg-slate-900 min-h-screen">
        <header class="flex justify-between items-center mb-8">
            <div class="flex items-center space-x-4">
                <img src="{{ Auth::user()->photo ? Storage::url(Auth::user()->photo) : asset('images/default-avatar.png') }}" alt="Avatar" class="w-12 h-12 rounded-full object-cover border-2 border-teal-500">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Assalamu'alaikum,</p>
                    <h1 class="text-xl font-bold text-gray-800 dark:text-gray-200 truncate">{{ $user->name }}</h1>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <button class="p-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <i data-feather="bell" class="w-5 h-5"></i>
                </button>
            </div>
        </header>

        <div x-data="{ open: false }" class="relative">
            <button @click="open = true" 
                    class="w-full text-left bg-gradient-to-br from-teal-500 to-teal-600 text-white p-6 rounded-2xl shadow-lg mb-10 transition-transform transform hover:-translate-y-1 active:scale-95">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm font-light opacity-80">{{ explode(',', $today)[0] }},</p>
                        <p class="text-2xl font-bold tracking-wide">{{ trim(explode(',', $today, 2)[1]) }}</p>
                    </div>
                    <i data-feather="calendar" class="w-10 h-10 opacity-30"></i>
                </div>
            </button>

            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" @click="open = false"></div>
                <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
                    <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-xl transform transition-all sm:my-8 sm:w-full sm:max-w-lg w-full">
                        <div class="bg-teal-500 dark:bg-teal-700 px-6 py-4">
                            <h3 class="text-lg font-bold text-white" id="modal-title">Kalender & Agenda</h3>
                        </div>
                        <div class="p-6">
                            <p class="text-sm font-semibold text-teal-600 dark:text-teal-400 mb-2">Tanggal saat ini:</p>
                            <p class="text-3xl font-extrabold text-gray-800 dark:text-gray-200 mb-6">{{ $today }}</p>

                            <h4 class="mt-2 mb-3 text-md font-bold text-teal-600 dark:text-teal-400 border-t pt-4 dark:border-gray-700">Hari Besar Islam Mendatang</h4>
                            <div class="max-h-72 overflow-y-auto pr-2 mb-6">
                                @php $currentYearDisplayIslamic = null; @endphp
                                @forelse($allIslamicEvents as $event)
                                    @if ($event['date']->year != $currentYearDisplayIslamic)
                                        @if ($currentYearDisplayIslamic !== null)
                                            <hr class="my-3 border-gray-200 dark:border-gray-700">
                                        @endif
                                        <p class="text-base font-extrabold text-teal-700 dark:text-teal-300 mt-2 sticky top-0 bg-white dark:bg-gray-800 py-1 z-10">{{ $event['date']->year }}</p>
                                        @php $currentYearDisplayIslamic = $event['date']->year; @endphp
                                    @endif
                                    
                                    <div class="flex justify-between items-center py-2 border-b last:border-b-0 dark:border-gray-700">
                                        <p class="text-gray-700 dark:text-gray-300 font-medium">{{ $event['name'] }}</p>
                                        <span class="text-xs font-bold bg-teal-100 dark:bg-teal-900 text-teal-700 dark:text-teal-300 px-3 py-1 rounded-full flex items-center">
                                            {{ $event['date']->translatedFormat('j F') }} ({{ $event['days_left'] }} Hari)
                                            <i data-feather="moon" class="w-3 h-3 inline ml-1"></i>
                                        </span>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada hari besar Islam yang terdaftar.</p>
                                @endforelse
                            </div>

                            <h4 class="mt-2 mb-3 text-md font-bold text-red-600 dark:text-red-400 border-t pt-4 dark:border-gray-700">Hari Libur Nasional</h4>
                            <div class="max-h-72 overflow-y-auto pr-2">
                                @php $currentYearDisplayHoliday = null; @endphp
                                @forelse($nationalHolidays as $holiday)
                                    @if ($holiday['year'] != $currentYearDisplayHoliday)
                                        @if ($currentYearDisplayHoliday !== null)
                                            <hr class="my-3 border-gray-200 dark:border-gray-700">
                                        @endif
                                        <p class="text-base font-extrabold text-red-700 dark:text-red-300 mt-2 sticky top-0 bg-white dark:bg-gray-800 py-1 z-10">{{ $holiday['year'] }}</p>
                                        @php $currentYearDisplayHoliday = $holiday['year']; @endphp
                                    @endif
                                    
                                    <div class="flex justify-between items-center py-2 border-b last:border-b-0 dark:border-gray-700">
                                        <p class="text-gray-700 dark:text-gray-300 font-medium">{{ $holiday['name'] }}</p>
                                        <span class="text-xs font-bold bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 px-3 py-1 rounded-full flex items-center">
                                            {{ $holiday['date_formatted'] }}
                                            <i data-feather="flag" class="w-3 h-3 inline ml-1"></i>
                                        </span>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada hari libur nasional yang terdaftar.</p>
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

        <section class="mb-10">
            <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Hari Besar Islam Terdekat</h2>
            <div class="flex space-x-4 overflow-x-auto pb-4 -mx-6 px-6">
                @forelse($upcomingEvents as $event)
                    <div class="flex-shrink-0 w-48 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-center p-4 rounded-2xl shadow-sm transition-transform transform hover:-translate-y-2">
                        <i data-feather="moon" class="w-10 h-10 text-teal-500 mx-auto mb-3"></i>
                        <p class="font-bold text-gray-800 dark:text-gray-200">{{ $event['name'] }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">{{ $event['date']->translatedFormat('j F Y') }}</p>
                        <span class="text-xs font-bold bg-teal-100 dark:bg-teal-900 text-teal-700 dark:text-teal-300 px-3 py-1 rounded-full">{{ $event['days_left'] }} Hari lagi</span>
                    </div>
                @empty
                    <div class="w-full text-center py-4">
                        <p class="text-gray-500 dark:text-gray-400">Tidak ada hari besar Islam yang akan datang.</p>
                    </div>
                @endforelse
            </div>
        </section>

        {{-- PERUBAHAN DI SINI: Bagian Pengumuman dipindahkan ke bawah "Hari Besar Islam Terdekat" --}}
        @if($announcements->isNotEmpty())
        <section class="mb-10">
            <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Pengumuman</h2>
            <div class="space-y-3">
                @foreach($announcements as $announcement)
                    @php
                        $levelClasses = [
                            'info' => 'bg-blue-100 border-blue-500 text-blue-700 dark:bg-blue-900/50 dark:border-blue-700 dark:text-blue-300',
                            'warning' => 'bg-yellow-100 border-yellow-500 text-yellow-700 dark:bg-yellow-900/50 dark:border-yellow-700 dark:text-yellow-300',
                            'danger' => 'bg-red-100 border-red-500 text-red-700 dark:bg-red-900/50 dark:border-red-700 dark:text-red-300',
                        ];
                        $alertClass = $levelClasses[$announcement->level] ?? $levelClasses['info'];
                    @endphp
                    <div class="{{ $alertClass }} border-l-4 p-4 rounded-r-lg" role="alert">
                        <p class="font-bold">{{ $announcement->title }}</p>
                        <p class="text-sm">{{ $announcement->content }}</p>
                    </div>
                @endforeach
            </div>
        </section>
        @endif

        <section>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200">Riwayat Absen Terakhir</h2>
                <a href="{{ route('history') }}" class="text-sm font-semibold text-teal-600 dark:text-teal-400 hover:underline">Lihat Semua</a>
            </div>
            <div class="space-y-3">
                @forelse($attendanceHistory as $history)
                    @php
                        $statusClasses = [
                            'Hadir' => 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300',
                            'Izin' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300',
                            'Sakit' => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300',
                            'Cuti' => 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300',
                            'Terlambat' => 'bg-orange-100 text-orange-700 dark:bg-orange-900 dark:text-orange-300',
                        ];
                        $badgeClass = $statusClasses[$history['status']] ?? 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300';
                    @endphp
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl flex items-center justify-between shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center space-x-4">
                            <img src="{{ $history['photo'] }}" alt="Foto Absen" class="w-12 h-12 rounded-full object-cover">
                            <div>
                                <p class="font-bold text-gray-800 dark:text-gray-200">{{ $history['day'] }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $history['date'] }}</p>
                            </div>
                        </div>
                        <span class="text-sm font-bold px-3 py-1 rounded-full {{ $badgeClass }}">
                            {{ $history['status'] }}
                        </span>
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-800 text-center p-8 rounded-2xl">
                        <p class="text-gray-500 dark:text-gray-400">Belum ada riwayat absen yang tercatat.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </main>
    @include('layouts.partials.bottom-nav', ['active' => 'home'])
</x-app-layout>