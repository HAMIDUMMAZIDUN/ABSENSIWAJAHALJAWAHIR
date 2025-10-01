@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<main class="p-6 pb-24">
    <header class="flex justify-between items-center mb-6">
        <div>
            {{-- Tambahkan class dark mode --}}
            <p class="text-gray-500 dark:text-gray-400 text-sm">Assalamu'alaikum,</p>
            <h1 class="text-xl font-bold text-gray-800 dark:text-gray-200 truncate">{{ $user->name }}</h1>
        </div>
        <div class="flex items-center space-x-3">
            {{-- Tambahkan class dark mode --}}
            <button class="p-2 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-full text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                <i data-feather="search" class="w-5 h-5"></i>
            </button>
            <button class="p-2 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-full text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                <i data-feather="bell" class="w-5 h-5"></i>
            </button>
        </div>
    </header>

    <div class="bg-teal-600 text-white p-5 rounded-2xl shadow-md mb-8 flex justify-between items-center">
        <div>
            <p class="text-sm font-light">{{ explode(',', $today)[0] }},</p>
            <p class="text-2xl font-bold">{{ trim(explode(',', $today, 2)[1]) }}</p>
        </div>
        <i data-feather="calendar" class="w-8 h-8 opacity-50"></i>
    </div>

    <section class="mb-8">
        <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Acara Mendatang</h2>
        <div class="flex space-x-4 overflow-x-auto pb-4">
            @forelse($upcomingEvents as $event)
                {{-- Tambahkan class dark mode --}}
                <div class="flex-shrink-0 w-40 bg-teal-50 dark:bg-teal-900/50 border border-teal-200 dark:border-teal-800 text-center p-4 rounded-2xl">
                    <img src="{{ asset($event['logo']) }}" alt="Logo" class="w-12 h-12 mx-auto mb-2">
                    <p class="font-bold text-gray-800 dark:text-gray-200">{{ $event['name'] }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $event['date']->translatedFormat('l, j F') }}</p>
                    <p class="text-xs font-bold text-teal-700 dark:text-teal-400 mt-2">{{ $event['days_left'] }} Hari lagi</p>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400">Tidak ada acara mendatang.</p>
            @endforelse
        </div>
    </section>

    <section>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200">Riwayat Absen</h2>
            <a href="#" class="text-sm font-semibold text-teal-600 dark:text-teal-400 hover:underline">Lihat Semua</a>
        </div>
        <div class="space-y-3">
            @forelse($attendanceHistory as $history)
                {{-- Tambahkan class dark mode --}}
                <div class="bg-white dark:bg-gray-700/50 border border-gray-200 dark:border-gray-700 p-3 rounded-xl flex items-center justify-between shadow-sm">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset($history['photo']) }}" alt="Avatar" class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-bold text-gray-800 dark:text-gray-200">{{ $history['day'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $history['date'] }}</p>
                        </div>
                    </div>
                    <p class="font-bold text-gray-600 dark:text-gray-400">{{ $history['year'] }}</p>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-center p-4">Belum ada riwayat absen.</p>
            @endforelse
        </div>
    </section>
</main>
@include('layouts.partials.bottom-nav', ['active' => 'home'])
@endsection