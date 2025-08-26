<!DOCTYPE html>
{{-- Mengambil tema dari user yang login, atau default 'light' --}}
<html lang="id" class="{{ auth()->user()?->theme ?? 'light' }}"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Aplikasi Absensi')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,600,700,800" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- SKRIP INI PENTING UNTUK MENGHINDARI KEDIP --}}
    <script>
        // Cek localStorage dulu untuk kecepatan, lalu terapkan class 'dark' jika perlu
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
{{-- Tambahkan class dark mode untuk body --}}
<body class="bg-gray-100 dark:bg-gray-900 font-sans">
    <div class="md:max-w-sm mx-auto bg-white dark:bg-gray-800 min-h-screen shadow-lg">
        
        @yield('content')

    </div>
    <script>
        feather.replace();
    </script>
    @stack('scripts') {{-- Tempat untuk script per halaman --}}
</body>
</html>