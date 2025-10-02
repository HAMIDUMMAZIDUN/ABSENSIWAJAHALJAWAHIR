<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Selamat Datang - Absensi Guru</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .bg-hero-image { background-image: url('/images/sakola.jpg'); }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .animate-fadeInUp { animation: fadeInUp 0.8s ease-out forwards; }
        .animate-fadeIn { animation: fadeIn 0.8s ease-out forwards; }
        .delay-200 { animation-delay: 200ms; }
        .delay-400 { animation-delay: 400ms; }
        .delay-600 { animation-delay: 600ms; }
    </style>
</head>
<body class="font-sans antialiased text-gray-800 bg-gray-900">
    <div class="relative min-h-screen overflow-hidden">
        <div class="absolute inset-0 bg-hero-image bg-cover bg-center"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-teal-900/80 to-gray-900/90"></div>

        <header class="absolute top-0 left-0 right-0 z-20 animate-fadeIn">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
                <a href="/" class="block">                  
                </a>

                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}" class="text-white font-medium hover:text-teal-300 transition-colors duration-300">
                        Login
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-5 py-2 text-sm font-bold text-teal-800 bg-white rounded-full shadow-lg transition-transform duration-300 ease-in-out hover:bg-gray-200 hover:scale-105">
                            Register
                        </a>
                    @endif
                </div>
            </nav>
        </header>

        <main class="relative z-10 flex items-center justify-center min-h-screen">
            <div class="max-w-4xl px-6 text-center text-white">
                <h1 class="text-4xl font-extrabold leading-tight tracking-tight md:text-6xl drop-shadow-md animate-fadeInUp" style="opacity: 0;">
                    Sistem Presensi Modern untuk Pendidik
                </h1>
                <p class="mt-4 text-lg font-medium text-teal-100/90 md:text-xl drop-shadow animate-fadeInUp delay-200" style="opacity: 0;">
                    Pondok Pesantren Salafiyah Al-Jawahir
                </p>
                <p class="max-w-2xl mx-auto mt-6 text-base text-gray-300 md:text-lg animate-fadeInUp delay-400" style="opacity: 0;">
                    Mudahkan pencatatan kehadiran harian Anda dengan sistem digital yang cepat, akurat, dan efisien. Fokus pada mengajar, biarkan kami yang mengurus administrasi.
                </p>
                <div class="mt-12 animate-fadeInUp delay-600" style="opacity: 0;">
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-10 py-4 text-lg font-bold text-white bg-teal-500 rounded-full shadow-xl transition-transform duration-300 ease-in-out hover:bg-teal-600 hover:scale-105">
                        Mulai Absensi
                    </a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>