<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Selamat Datang - Absensi Guru</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Menambahkan gambar latar belakang ke div */
        .bg-hero-image {
            background-image: url('/images/sakola.jpg');
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="relative flex flex-col min-h-screen bg-white">

        {{-- Bagian Header dengan Gambar --}}
        <div class="relative w-full h-[40vh] bg-hero-image bg-cover bg-center">
            <div class="absolute inset-0 bg-teal-800 opacity-70"></div>
            <div class="absolute bottom-0 w-full text-white">   
            </div>
        </div>

        {{-- Bagian Konten Utama --}}
        <div class="flex flex-1 flex-col justify-center items-center px-6 -mt-10 z-10">
            <div class="w-full max-w-md text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900">
                    Selamat Datang
                </h1>
                <p class="mt-2 text-base text-gray-700 font-bold">
                    di aplikasi absensi guru Pondok Pesantren Salafiyah Al-Jawahir Berbasis Web.
                </p>
                <p class="mt-4 text-sm text-gray-500">
                    Aplikasi ini memudahkan Bapak/Ibu guru dalam melakukan presensi harian secara digital, sehingga proses pencatatan kehadiran menjadi lebih cepat, akurat, dan efisien.
                </p>

                <div class="mt-12 flex justify-end">
                    <a href="{{ route('login') }}" class="inline-flex items-center space-x-3 text-lg font-bold text-gray-800 transition hover:text-teal-600">
                        <span>Login</span>
                        <span class="flex items-center justify-center w-12 h-12 rounded-full border-2 border-gray-300 transition group-hover:border-teal-600">
                            <svg class="w-6 h-6 text-gray-500 transition group-hover:text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>