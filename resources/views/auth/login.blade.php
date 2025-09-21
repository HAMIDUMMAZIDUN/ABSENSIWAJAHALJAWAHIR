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
        <div class="absolute inset-0 bg-teal-800 opacity-70"></div>

        <div class="relative w-full max-w-md px-6 py-8 bg-white shadow-lg overflow-hidden rounded-2xl z-10">
            <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">
                Login
            </h1>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- == BAGIAN USERNAME DIUBAH == --}}
                <div class="mb-4">
                    {{-- UBAH INI: for="name" --}}
                    <label for="name" class="block font-medium text-sm text-gray-700 mb-1">Username</label>
                    
                    {{-- UBAH INI: id, type, name, old() --}}
                    <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="username" 
                           class="block w-full px-5 py-3 border border-gray-300 rounded-full shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50" 
                           placeholder="Ketik Username Disini">

                    {{-- UBAH INI: $errors->get('name') --}}
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- == BAGIAN PASSWORD TETAP SAMA == --}}
                <div class="mb-4">
                    <label for="password" class="block font-medium text-sm text-gray-700 mb-1">Kata Sandi</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required autocomplete="current-password" 
                               class="block w-full px-5 py-3 border border-gray-300 rounded-full shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50" 
                               placeholder="Ketik Kata Sandi Disini">
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 px-4 flex items-center text-gray-500">
                            <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eye-off-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7 .847 0 1.67.127 2.458.365M18.825 13.875A10.05 10.05 0 0119 12c-1.274-4.057-5.064-7-9.542-7a10.05 10.05 0 00-1.458.175M12 15a3 3 0 110-6 3 3 0 010 6z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                
                <div class="text-right mb-6">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-gray-600 hover:text-gray-900 hover:underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                            Lupa Kata Sandi?
                        </a>
                    @endif
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-4 rounded-full focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                        Masuk
                    </button>
                </div>
            </form>
        </div>
        
        <div class="absolute bottom-6 text-center z-10">
            <p class="text-sm text-white">
                Tidak Punya Akun? 
                <a href="{{ route('register') }}" class="font-bold hover:underline">
                    Sign Up
                </a>
            </p>
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