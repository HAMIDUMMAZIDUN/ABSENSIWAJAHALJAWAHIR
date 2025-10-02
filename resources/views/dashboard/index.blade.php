<x-app-layout>
    {{-- Merombak total tema visual dashboard agar lebih modern dan estetik --}}
    <main class="p-6 pb-24 bg-slate-50 dark:bg-slate-900 min-h-screen">
        {{-- Header dengan sentuhan personal --}}
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

        {{-- Banner Tanggal dengan Gradasi --}}
        <div class="bg-gradient-to-br from-teal-500 to-teal-600 text-white p-6 rounded-2xl shadow-lg mb-10 flex justify-between items-center">
            <div>
                <p class="text-sm font-light opacity-80">{{ explode(',', $today)[0] }},</p>
                <p class="text-2xl font-bold tracking-wide">{{ trim(explode(',', $today, 2)[1]) }}</p>
            </div>
            <i data-feather="calendar" class="w-10 h-10 opacity-30"></i>
        </div>

        {{-- Kartu Acara Mendatang dengan Efek Hover --}}
        <section class="mb-10">
            <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Acara Mendatang</h2>
            <div class="flex space-x-4 overflow-x-auto pb-4 -mx-6 px-6">
                @forelse($upcomingEvents as $event)
                    <div class="flex-shrink-0 w-48 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-center p-4 rounded-2xl shadow-sm transition-transform transform hover:-translate-y-2">
                        <img src="{{ asset($event['logo']) }}" alt="Logo" class="w-14 h-14 mx-auto mb-3">
                        <p class="font-bold text-gray-800 dark:text-gray-200">{{ $event['name'] }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">{{ $event['date']->translatedFormat('j F Y') }}</p>
                        <span class="text-xs font-bold bg-teal-100 dark:bg-teal-900 text-teal-700 dark:text-teal-300 px-3 py-1 rounded-full">{{ $event['days_left'] }} Hari lagi</span>
                    </div>
                @empty
                    <div class="w-full text-center py-4">
                        <p class="text-gray-500 dark:text-gray-400">Tidak ada acara mendatang.</p>
                    </div>
                @endforelse
            </div>
        </section>

        {{-- Daftar Riwayat Absen yang Lebih Rapi --}}
        <section>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200">Riwayat Absen</h2>
                <a href="#" class="text-sm font-semibold text-teal-600 dark:text-teal-400 hover:underline">Lihat Semua</a>
            </div>
            <div class="space-y-3">
                @forelse($attendanceHistory as $history)
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl flex items-center justify-between shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset($history['photo']) }}" alt="Avatar" class="w-12 h-12 rounded-full object-cover">
                            <div>
                                <p class="font-bold text-gray-800 dark:text-gray-200">{{ $history['day'] }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $history['date'] }}</p>
                            </div>
                        </div>
                        <p class="font-mono font-bold text-gray-600 dark:text-gray-400 text-lg">{{ $history['year'] }}</p>
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-800 text-center p-8 rounded-2xl">
                        <p class="text-gray-500 dark:text-gray-400">Belum ada riwayat absen.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </main>
    @include('layouts.partials.bottom-nav', ['active' => 'home'])
</x-app-layout>

