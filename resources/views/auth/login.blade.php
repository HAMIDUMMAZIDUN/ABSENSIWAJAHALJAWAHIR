<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Login</title>

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
        <div class="absolute inset-0 bg-teal-900/80"></div>

        <div class="relative w-full max-w-md px-6 py-10 bg-white/95 backdrop-blur-sm shadow-2xl overflow-hidden rounded-2xl z-10">
            
            {{-- BAGIAN HEADER/BRANDING --}}
            <div class="text-center mb-8">
                <div class="text-center mb-8"><img src="{{ asset('images/logo-pesantren.png') }}" alt="Logo Pesantren" class="h-20 w-auto mx-auto mb-4">
                <h1 class="text-2xl font-bold text-gray-800">
                    Masuk Akun
                </h1>
                <p class="text-sm text-gray-500">
                    Pondok Pesantren Salafiyah Al-Jawahir
                </p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block font-medium text-sm text-gray-700 sr-only">Username</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
                        </span>
                        <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="username" class="block w-full pl-12 pr-5 py-3 border border-gray-300 rounded-full shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50" placeholder="Username">
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="mb-6">
                    <label for="password" class="block font-medium text-sm text-gray-700 sr-only">Kata Sandi</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>
                        </span>
                        <input id="password" type="password" name="password" required autocomplete="current-password" class="block w-full pl-12 pr-12 py-3 border border-gray-300 rounded-full shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50" placeholder="Kata Sandi">
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 px-4 flex items-center text-gray-500">
                            <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            <svg id="eye-off-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7 .847 0 1.67.127 2.458.365M18.825 13.875A10.05 10.05 0 0119 12c-1.274-4.057-5.064-7-9.542-7a10.05 10.05 0 00-1.458.175M12 15a3 3 0 110-6 3 3 0 010 6z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" /></svg>
                        </button>
                    </div>
                     <div class="text-right mt-2">
                        @if (Route::has('password.request'))
                            <a class="text-sm text-gray-600 hover:text-teal-600 hover:underline" href="{{ route('password.request') }}">Lupa Kata Sandi?</a>
                        @endif
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div class="mt-8 flex items-center justify-end">
                    <button type="submit" class="w-full bg-teal-500 hover:bg-teal-600 text-white font-bold py-3 px-4 rounded-full focus:outline-none focus:shadow-outline transition-transform duration-300 ease-in-out hover:scale-105 shadow-lg">Login</button>
                </div>
                <div class="text-center mt-6">
                    <p class="text-sm text-gray-600">Tidak Punya Akun? <a href="{{ route('register') }}" class="font-bold text-teal-600 hover:underline">Daftar Sekarang</a></p>
                </div>
            </form>
        </div>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        const eyeOffIcon = document.getElementById('eye-off-icon');

        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            eyeIcon.classList.toggle('hidden');
            eyeOffIcon.classList.toggle('hidden');
        });
    </script>
</body>
</html>