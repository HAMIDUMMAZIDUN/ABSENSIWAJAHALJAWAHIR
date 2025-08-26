<footer class="fixed bottom-0 md:max-w-sm w-full bg-white border-t p-2 flex justify-around items-center">
    @php
        // Definisikan kelas untuk link aktif dan tidak aktif
        $activeClass = 'p-3 bg-teal-600 text-white rounded-2xl';
        $inactiveClass = 'p-3 text-gray-500 hover:text-teal-600';
    @endphp

    <a href="{{ route('dashboard') }}" class="{{ $active === 'home' ? $activeClass : $inactiveClass }}">
        <i data-feather="home" class="w-6 h-6"></i>
    </a>
    
    <a href="{{ route('history') }}" class="{{ $active === 'history' ? $activeClass : $inactiveClass }}">
        <i data-feather="list" class="w-6 h-6"></i>
    </a>
    
   <a href="{{ route('scan') }}" class="p-5 -mt-16 bg-white border-8 border-gray-100 rounded-full text-teal-600 shadow-lg">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 0h-4m4 0l-5-5" />
    </svg>
   </a>
    
    <a href="{{ route('settings') }}" class="{{ $active === 'settings' ? $activeClass : $inactiveClass }}">
        <i data-feather="settings" class="w-6 h-6"></i>
    </a>
    
    <a href="{{ route('profile.edit') }}" class="{{ $active === 'profile' ? $activeClass : $inactiveClass }}">
        <i data-feather="user" class="w-6 h-6"></i>
    </a>
</footer>