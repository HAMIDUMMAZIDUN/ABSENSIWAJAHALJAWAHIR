@extends('layouts.app-mobile')

@section('title', 'Riwayat Absensi')

@section('content')
<main class="p-6 pb-24">
    <header class="flex items-center space-x-4 mb-6">
        {{-- Tambahkan class dark mode --}}
        <a href="{{ route('dashboard') }}" class="text-gray-800 dark:text-gray-200">
            <i data-feather="arrow-left" class="w-6 h-6"></i>
        </a>
        <h1 class="text-xl font-bold text-gray-800 dark:text-gray-200">Riwayat</h1>
    </header>

    {{-- Tambahkan class dark mode --}}
    <nav class="flex border-b border-gray-200 dark:border-gray-700 mb-6">
        <a href="{{ route('history', ['filter' => 'tepat-waktu']) }}" 
           class="flex-1 text-center py-3 font-semibold 
                  {{ $filter == 'tepat-waktu' ? 'border-b-2 border-teal-600 text-teal-600 dark:text-teal-400' : 'text-gray-500 dark:text-gray-400' }}">
            Tepat Waktu
        </a>
        <a href="{{ route('history', ['filter' => 'terlambat']) }}" 
           class="flex-1 text-center py-3 font-semibold 
                  {{ $filter == 'terlambat' ? 'border-b-2 border-teal-600 text-teal-600 dark:text-teal-400' : 'text-gray-500 dark:text-gray-400' }}">
            Terlambat
        </a>
    </nav>

    <section class="space-y-3">
        @forelse($historyData as $history)
            {{-- Tambahkan class dark mode --}}
            <div class="bg-white dark:bg-gray-700/50 border border-gray-200 dark:border-gray-700 p-3 rounded-xl flex items-center justify-between shadow-sm">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset($history['photo']) }}" alt="Avatar" class="w-10 h-10 rounded-full">
                    <div>
                        <p class="font-bold text-gray-800 dark:text-gray-200">{{ $history['day'] }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $history['date'] }}</p>
                        <div class="flex items-center space-x-1 mt-1">
                            <span class="w-2 h-2 rounded-full {{ $history['status'] == 'on_time' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                            <p class="text-xs font-semibold {{ $history['status'] == 'on_time' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">{{ $history['time'] }}</p>
                        </div>
                    </div>
                </div>
                <p class="font-bold text-gray-600 dark:text-gray-400">{{ $history['year'] }}</p>
            </div>
        @empty
            <div class="text-center py-10">
                <p class="text-gray-500 dark:text-gray-400">Tidak ada riwayat untuk kategori ini.</p>
            </div>
        @endforelse
    </section>
</main>
    
@include('layouts.partials.bottom-nav', ['active' => 'history'])
@endsection