
<nav class="bg-white dark:bg-gray-800 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex-shrink-0">
                <a href="{{ route('app.dashboard') }}" class="text-2xl font-bold text-teal-500">
                    AbsensiApp
                </a>
            </div>

            <div class="hidden md:flex md:items-center md:space-x-8">
                <a href="{{ route('app.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('app.dashboard') ? 'text-teal-500' : 'text-gray-700 dark:text-gray-300' }} hover:text-teal-500">
                    Beranda
                </a>
                <a href="{{ route('history') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('history') ? 'text-teal-500' : 'text-gray-700 dark:text-gray-300' }} hover:text-teal-500">
                    Riwayat
                </a>
                <a href="{{ route('settings.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('app.settings.*') ? 'text-teal-500' : 'text-gray-700 dark:text-gray-300' }} hover:text-teal-500">
                    Setelan
                </a>
                <a href="{{ route('profile.edit') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('profile.edit') ? 'text-teal-500' : 'text-gray-700 dark:text-gray-300' }} hover:text-teal-500">
                    Profil
                </a>
                <a href="{{ route('app.scan') }}" class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-full text-white bg-teal-500 hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                    Scan Wajah
                </a>
            </div>

            <div class="md:hidden">
                </div>
        </div>
    </div>
</nav>