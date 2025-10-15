<!DOCTYPE html>
<html lang="id" class="{{ auth()->user()?->theme ?? 'light' }}"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $title ?? 'Admin Panel' }} - {{ config('app.name', 'Laravel') }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,600,700,800" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
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
<body class="font-sans bg-gray-100 dark:bg-gray-900">
    <div class="relative min-h-screen lg:flex">
        
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>

        <aside id="sidebar" class="fixed inset-y-0 left-0 bg-white dark:bg-gray-800 shadow-lg w-64 transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:relative lg:inset-0 z-50">
            <div class="flex justify-between items-center p-4 border-b dark:border-gray-700">
                <span class="text-xl font-bold text-teal-600 dark:text-teal-400">
                    Admin Al-Jawahir
                </span>
                <button id="close-sidebar-btn" class="text-gray-700 dark:text-gray-300 lg:hidden">
                    <i data-feather="x" class="w-6 h-6"></i>
                </button>
            </div>
            <nav class="mt-4 flex flex-col justify-between h-[calc(100%-65px)]">
                <div>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center px-6 py-3 mx-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-200 dark:bg-gray-700 font-bold' : '' }}">
                        <i data-feather="grid" class="w-5 h-5"></i>
                        <span class="ml-3">Dashboard</span>
                    </a>
                    
                    <a href="{{ route('admin.users.index') }}"
                       class="flex items-center px-6 py-3 mx-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('admin.users.*') ? 'bg-gray-200 dark:bg-gray-700 font-bold' : '' }}">
                        <i data-feather="users" class="w-5 h-5"></i>
                        <span class="ml-3">Manajemen Pengguna</span>
                    </a>

                    <a href="{{ route('admin.attendance.index') }}"
                       class="flex items-center px-6 py-3 mx-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('admin.attendance.*') ? 'bg-gray-200 dark:bg-gray-700 font-bold' : '' }}">
                        <i data-feather="clipboard" class="w-5 h-5"></i>
                        <span class="ml-3">Rekap Absensi</span>
                    </a>

                    <a href="{{ route('admin.faces.index') }}"
                       class="flex items-center px-6 py-3 mx-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('admin.faces.*') ? 'bg-gray-200 dark:bg-gray-700 font-bold' : '' }}">
                        <i data-feather="smile" class="w-5 h-5"></i>
                        <span class="ml-3">Daftar Wajah</span>
                    </a>

                    <a href="{{ route('admin.announcements.index') }}"
                       class="flex items-center px-6 py-3 mx-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('admin.announcements.*') ? 'bg-gray-200 dark:bg-gray-700 font-bold' : '' }}">
                        <i data-feather="bell" class="w-5 h-5"></i>
                        <span class="ml-3">Pengumuman</span>
                    </a>
                </div>

                <div class="p-2 border-t dark:border-gray-700 mx-2">
                    <div class="flex items-center justify-between px-4 py-3">
                         <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Ganti Tema</span>
                         <div class="relative inline-flex items-center">
                              <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                                   <i data-feather="sun" id="theme-toggle-light-icon" class="w-5 h-5 hidden"></i>
                                   <i data-feather="moon" id="theme-toggle-dark-icon" class="w-5 h-5 hidden"></i>
                              </button>
                         </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="flex items-center w-full px-6 py-3 text-left rounded-lg text-gray-700 dark:text-gray-300 hover:bg-red-100 dark:hover:bg-red-800/50">
                            <i data-feather="log-out" class="w-5 h-5"></i>
                            <span class="ml-3">Keluar</span>
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex justify-between items-center p-4 bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                <div class="flex items-center">
                    <button id="open-sidebar-btn" class="text-gray-800 dark:text-gray-200 mr-4 lg:hidden">
                        <i data-feather="menu" class="w-6 h-6"></i>
                    </button>
                    <h1 class="text-xl font-bold text-gray-800 dark:text-gray-200">{{ $title ?? 'Dashboard' }}</h1>
                </div>
            </header>
            
            <main class="flex-1 overflow-y-auto p-4 md:p-6 pb-20 lg:pb-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    <nav class="fixed bottom-0 left-0 right-0 h-16 bg-white dark:bg-gray-800 border-t dark:border-gray-700 flex justify-around items-center z-30 lg:hidden">
        <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('admin.dashboard') ? 'text-teal-600 dark:text-teal-400' : 'text-gray-500 dark:text-gray-400' }} hover:text-teal-500 transition-colors">
            <i data-feather="grid" class="w-6 h-6"></i>
            <span class="text-xs mt-1">Dashboard</span>
        </a>
        <a href="{{ route('admin.users.index') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('admin.users.*') ? 'text-teal-600 dark:text-teal-400' : 'text-gray-500 dark:text-gray-400' }} hover:text-teal-500 transition-colors">
            <i data-feather="users" class="w-6 h-6"></i>
            <span class="text-xs mt-1">Pengguna</span>
        </a>
        <a href="{{ route('admin.attendance.index') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('admin.attendance.*') ? 'text-teal-600 dark:text-teal-400' : 'text-gray-500 dark:text-gray-400' }} hover:text-teal-500 transition-colors">
            <i data-feather="clipboard" class="w-6 h-6"></i>
            <span class="text-xs mt-1">Absensi</span>
        </a>
        <a href="{{ route('admin.faces.index') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('admin.faces.*') ? 'text-teal-600 dark:text-teal-400' : 'text-gray-500 dark:text-gray-400' }} hover:text-teal-500 transition-colors">
            <i data-feather="smile" class="w-6 h-6"></i>
            <span class="text-xs mt-1">Wajah</span>
        </a>
        <a href="{{ route('admin.announcements.index') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('admin.announcements.*') ? 'text-teal-600 dark:text-teal-400' : 'text-gray-500 dark:text-gray-400' }} hover:text-teal-500 transition-colors">
            <i data-feather="bell" class="w-6 h-6"></i>
            <span class="text-xs mt-1">Info</span>
        </a>
    </nav>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const themeToggleBtn = document.getElementById('theme-toggle');
            const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

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

                // Mengirim event agar halaman lain (seperti dashboard) bisa mendengarkan
                document.dispatchEvent(new CustomEvent('themeChanged'));

                fetch('{{ route("admin.settings.theme.update") }}', { 
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ theme: newTheme })
                })
                .then(response => {
                    if (!response.ok) { console.error('Network response was not ok'); }
                    return response.json();
                })
                .then(data => {
                    if(data.status !== 'success') { console.error('Gagal menyimpan tema ke server.'); }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
            
            // Inisialisasi awal untuk sidebar dan feather icons
            const openSidebarBtn = document.getElementById('open-sidebar-btn');
            const closeSidebarBtn = document.getElementById('close-sidebar-btn');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            if (openSidebarBtn) {
                openSidebarBtn.addEventListener('click', () => {
                    sidebar.classList.remove('-translate-x-full');
                    sidebarOverlay.classList.remove('hidden');
                });
            }

            if (closeSidebarBtn) {
                closeSidebarBtn.addEventListener('click', () => {
                    sidebar.classList.add('-translate-x-full');
                    sidebarOverlay.classList.add('hidden');
                });
            }
            
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', () => {
                    sidebar.classList.add('-translate-x-full');
                    sidebarOverlay.classList.add('hidden');
                });
            }

            feather.replace();
        });
    </script>
    
    @stack('scripts')
</body>
</html>

