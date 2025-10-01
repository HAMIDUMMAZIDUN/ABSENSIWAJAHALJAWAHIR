<!DOCTYPE html>
<html lang="id" class="{{ auth()->user()?->theme ?? 'light' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Menggunakan title yang dinamis dari @yield --}}
    <title>@yield('title', 'Aplikasi Absensi')</title>

    {{-- Menggunakan font Plus Jakarta Sans & ikon Feather --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,600,700,800" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Skrip untuk menghindari kedip dark mode --}}
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        
        {{-- Menggunakan header parsial kustom Anda --}}
        @include('layouts.partials.header')

        {{-- Menggunakan struktur konten utama kustom Anda --}}
        <main>
            <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- Menambahkan skrip untuk Feather Icons dan script per halaman --}}
    <script>
        feather.replace();
    </script>
    @stack('scripts')
</body>
</html>