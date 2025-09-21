<!DOCTYPE html>
<html lang="id" class="{{ auth()->user()?->theme ?? 'light' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - {{ config('app.name', 'Laravel') }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,600,700,800" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="font-sans bg-gray-100 dark:bg-gray-900">
    <div class="flex h-screen">
        <aside class="w-64 flex-shrink-0 bg-white dark:bg-gray-800 shadow-lg">
            <div class="p-4 text-2xl font-bold text-teal-600 dark:text-teal-400 border-b dark:border-gray-700 text-center">
                Admin Panel
            </div>
            <nav class="mt-4">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-6 py-3 mx-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700
                          {{ request()->routeIs('admin.dashboard') ? 'bg-gray-200 dark:bg-gray-700 font-bold' : '' }}">
                    <i data-feather="grid" class="w-5 h-5"></i>
                    <span class="ml-3">Dashboard</span>
                </a>
            </nav>

            <div class="absolute bottom-0 w-64 p-2">
                 <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-6 py-3 text-left rounded-lg text-gray-700 dark:text-gray-300 hover:bg-red-100 dark:hover:bg-red-800/50">
                          <i data-feather="log-out" class="w-5 h-5"></i>
                          <span class="ml-3">Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex justify-between items-center p-4 bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                 <h1 class="text-xl font-bold text-gray-800 dark:text-gray-200">@yield('title')</h1>
                 <div class="text-gray-600 dark:text-gray-300">
                    Selamat datang, {{ Auth::user()->name }}!
                 </div>
            </header>
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        feather.replace();
    </script>
    @stack('scripts')
</body>
</html>