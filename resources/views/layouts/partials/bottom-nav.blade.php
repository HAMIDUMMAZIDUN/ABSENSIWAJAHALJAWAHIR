<div class="fixed bottom-0 left-0 right-0 h-16 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 z-40">
    <div class="max-w-7xl mx-auto h-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-around items-center h-full relative">
            
            {{-- Tombol Home/Dashboard --}}
            <a href="{{ route('app.dashboard') }}" class="flex flex-col items-center justify-center w-full text-center {{ request()->routeIs('app.dashboard') ? 'text-teal-500' : 'text-gray-500 dark:text-gray-400' }} hover:text-teal-500 transition-colors duration-200">
                <i data-feather="home" class="w-6 h-6"></i>
                <span class="text-xs mt-1">Beranda</span>
            </a>

            {{-- Tombol Riwayat --}}
            <a href="{{ route('app.history') }}" class="flex flex-col items-center justify-center w-full text-center {{ request()->routeIs('app.history') ? 'text-teal-500' : 'text-gray-500 dark:text-gray-400' }} hover:text-teal-500 transition-colors duration-200">
                <i data-feather="archive" class="w-6 h-6"></i>
                <span class="text-xs mt-1">Riwayat</span>
            </a>

            {{-- Tombol Scan (Tombol Tengah Menonjol) --}}
            <a href="{{ route('app.scan') }}" class="absolute -top-10 left-1/2 -translate-x-1/2 
                    flex items-center justify-center w-20 h-20 
                    bg-teal-500 rounded-full border-4 border-white dark:border-gray-800 
                    text-white shadow-lg z-50 transform transition-transform 
                    hover:scale-110 active:scale-95 animate-pulse-once">
                <i data-feather="camera" class="w-8 h-8"></i>
            </a>
            
            {{-- Tombol Pengaturan --}}
            <a href="{{ route('app.settings.index') }}" class="flex flex-col items-center justify-center w-full text-center {{ request()->routeIs('app.settings.*') ? 'text-teal-500' : 'text-gray-500 dark:text-gray-400' }} hover:text-teal-500 transition-colors duration-200">
                <i data-feather="settings" class="w-6 h-6"></i>
                <span class="text-xs mt-1">Setelan</span>
            </a>

            {{-- Tombol Profil --}}
            <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center w-full text-center {{ request()->routeIs('profile.edit') ? 'text-teal-500' : 'text-gray-500 dark:text-gray-400' }} hover:text-teal-500 transition-colors duration-200">
                <i data-feather="user" class="w-6 h-6"></i>
                <span class="text-xs mt-1">Profil</span>
            </a>
        </div>
    </div>
</div>

<style>
/* Custom keyframes for a subtle, single pulse animation */
@keyframes pulse-once {
    0% {
        transform: scale(1) translateX(-50%);
    }
    50% {
        transform: scale(1.05) translateX(-50%);
    }
    100% {
        transform: scale(1) translateX(-50%);
    }
}

/* Apply the custom animation */
.animate-pulse-once {
    animation: pulse-once 1.5s ease-in-out; /* Play once on load */
    /* Untuk mengulang animasi, gunakan: animation: pulse-once 1.5s ease-in-out infinite; */
}
</style>