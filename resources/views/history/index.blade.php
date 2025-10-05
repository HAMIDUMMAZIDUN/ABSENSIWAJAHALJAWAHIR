<x-app-layout>
    {{-- Merombak total tema visual halaman riwayat agar lebih modern dan estetik --}}
    <main class="p-6 pb-24 bg-slate-50 dark:bg-slate-900 min-h-screen">
        {{-- Header Halaman --}}
        <header class="flex items-center space-x-4 mb-8">
            <a href="{{ route('dashboard') }}" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                <i data-feather="arrow-left" class="w-6 h-6 text-gray-800 dark:text-gray-200"></i>
            </a>
            <h1 class="text-xl font-bold text-gray-800 dark:text-gray-200">Riwayat Absensi</h1>
        </header>

        {{-- Tab Filter dengan Desain Baru --}}
        <nav class="bg-white dark:bg-gray-800 p-1.5 rounded-full flex items-center mb-8 shadow-sm">
            <a href="{{ route('history', ['filter' => 'tepat-waktu']) }}"
            class="flex-1 text-center py-2 px-4 rounded-full font-semibold transition-colors
                    {{ $filter == 'tepat-waktu' ? 'bg-teal-600 text-white shadow' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                Tepat Waktu
            </a>
            <a href="{{ route('history', ['filter' => 'terlambat']) }}"
            class="flex-1 text-center py-2 px-4 rounded-full font-semibold transition-colors
                    {{ $filter == 'terlambat' ? 'bg-rose-600 text-white shadow' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                Terlambat
            </a>
        </nav>

        {{-- Daftar Riwayat dalam Bentuk Kartu --}}
        <section class="space-y-4">
            @forelse($historyData as $history)
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl flex items-center justify-between shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center space-x-4">
                        <img src="{{ $history['photo'] && str_starts_with($history['photo'], 'photos/') ? Storage::url($history['photo']) : asset($history['photo']) }}" alt="Avatar" class="w-12 h-12 rounded-full object-cover">
                        <div>
                            <p class="font-bold text-gray-800 dark:text-gray-200">{{ $history['day'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $history['date'] }}</p>
                            <div class="flex items-center space-x-2 mt-1">
                                <span class="w-2.5 h-2.5 rounded-full {{ $history['status'] == 'on_time' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                <p class="text-xs font-semibold {{ $history['status'] == 'on_time' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $history['time'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <p class="font-mono font-bold text-gray-600 dark:text-gray-400 text-lg">{{ $history['year'] }}</p>
                </div>
            @empty
                <div class="bg-white dark:bg-gray-800 text-center p-12 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <i data-feather="archive" class="w-12 h-12 mx-auto text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Data Kosong</h3>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">Tidak ada riwayat untuk kategori ini.</p>
                </div>
            @endforelse
        </section>
    </main>

    @include('layouts.partials.bottom-nav', ['active' => 'history'])
</x-app-layout>

