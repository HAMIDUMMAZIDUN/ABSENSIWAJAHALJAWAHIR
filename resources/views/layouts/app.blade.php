<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ auth()->user()?->theme ?? 'light' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            if ('{{ auth()->user()?->theme }}' === 'dark') {
                 document.documentElement.classList.add('dark');
            } else {
                 document.documentElement.classList.remove('dark');
            }
        }
    </script>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        {{-- Navigasi ditambahkan di sini --}}
        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main>
            {{ $slot }}
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const themeToggleBtn = document.getElementById('theme-toggle-user');
            if(themeToggleBtn) {
                const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon-user');
                const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon-user');

                function updateIcon() {
                    if (document.documentElement.classList.contains('dark')) {
                        themeToggleLightIcon.classList.remove('hidden');
                        themeToggleDarkIcon.classList.add('hidden');
                    } else {
                        themeToggleDarkIcon.classList.remove('hidden');
                        themeToggleLightIcon.classList.add('hidden');
                    }
                }

                updateIcon();

                themeToggleBtn.addEventListener('click', function() {
                    document.documentElement.classList.toggle('dark');
                    const newTheme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
                    localStorage.setItem('theme', newTheme);
                    updateIcon();

                    // Menggunakan route untuk pengguna biasa
                    fetch('{{ route("app.settings.theme.update") }}', { 
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ theme: newTheme })
                    })
                    .catch(error => console.error('Error:', error));
                });
            }
            
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
</body>
</html>
