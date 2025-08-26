@extends('layouts.app-mobile')

@section('title', 'Profil Pengguna')

@section('content')
<main class="p-6 pb-24">
    <header class="flex items-center justify-between mb-8">
        {{-- Tambahkan class dark mode --}}
        <a href="{{ url()->previous() }}" class="text-gray-800 dark:text-gray-200">
            <i data-feather="arrow-left" class="w-6 h-6"></i>
        </a>
        <h1 class="text-xl font-bold text-gray-800 dark:text-gray-200">Profile</h1>
        <a href="{{ route('settings.index') }}" class="text-gray-800 dark:text-gray-200">
            <i data-feather="settings" class="w-6 h-6"></i>
        </a>
    </header>

    <div class="flex justify-center mb-8">
        <div class="relative w-32 h-32">
            {{-- Tambahkan class dark mode untuk border --}}
            <img src="{{ asset(Auth::user()->photo ?? '/images/default-avatar.png') }}" alt="Foto Profil" class="w-full h-full rounded-full object-cover border-4 border-white dark:border-gray-600 shadow-md">
        </div>
    </div>

    <div class="space-y-6">
        <div>
            {{-- Tambahkan class dark mode --}}
            <label class="text-xs text-gray-500 dark:text-gray-400">Nama Lengkap</label>
            <p class="text-lg font-semibold text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700 pb-2">{{ Auth::user()->name }}</p>
        </div>
        <div>
            <label class="text-xs text-gray-500 dark:text-gray-400">No Handphone</label>
            <p class="text-lg font-semibold text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700 pb-2">{{ Auth::user()->phone ?? 'Belum diatur' }}</p>
        </div>
        <div>
            <label class="text-xs text-gray-500 dark:text-gray-400">Password</label>
            <div class="flex items-center justify-between border-b border-gray-200 dark:border-gray-700 pb-2">
                <p class="text-lg font-semibold text-gray-800 dark:text-gray-200">••••••••••••</p>
                <i data-feather="eye" class="w-5 h-5 text-gray-400 dark:text-gray-500"></i>
            </div>
        </div>
    </div>
</main>

@include('layouts.partials.bottom-nav', ['active' => 'profile'])
@endsection