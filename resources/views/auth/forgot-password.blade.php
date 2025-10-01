<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Lupa Kata Sandi</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-image: url('/images/sakola.jpg');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-teal-800 opacity-70"></div>

        <div class="relative w-full max-w-md px-6 py-8 bg-white shadow-lg overflow-hidden rounded-2xl z-10">
            <h1 class="text-3xl font-bold text-center text-gray-800 mb-4">
                Lupa Kata Sandi
            </h1>

            {{-- Deskripsi diubah untuk nomor handphone --}}
            <p class="text-center text-sm text-gray-600 mb-6">
                Tidak masalah. Beri tahu kami nomor handphone Anda yang terdaftar dan kami akan mengirimkan link untuk mengatur ulang kata sandi.
            </p>

            {{-- Menampilkan status sukses --}}
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}"> {{-- Nama rute tetap 'password.email' untuk kompatibilitas --}}
                @csrf

                {{-- Input diubah dari email menjadi nomor handphone --}}
                <div class="mb-4">
                    <label for="phone" class="block font-medium text-sm text-gray-700 mb-1">No. Handphone</label>
                    <input id="phone" type="text" name="phone" :value="old('phone')" required autofocus
                           class="block w-full px-5 py-3 border border-gray-300 rounded-full shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50" 
                           placeholder="Ketik Nomor Handphone Anda">
                    {{-- Menampilkan error untuk field 'phone' --}}
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-6">
                    <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-4 rounded-full focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                        Kirim Link Reset Kata Sandi
                    </button>
                </div>

                <div class="text-center mt-6">
                    <p class="text-sm text-gray-600">
                        Ingat kata sandi? 
                        <a href="{{ route('login') }}" class="font-bold text-teal-600 hover:underline">
                            Kembali ke Login
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
