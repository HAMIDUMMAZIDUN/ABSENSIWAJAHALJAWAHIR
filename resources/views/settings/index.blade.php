@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
<main class="p-6 pb-24">
    <header class="flex items-center space-x-4 mb-8">
        <a href="{{ url()->previous() }}" class="text-gray-800 dark:text-gray-200">
            <i data-feather="arrow-left" class="w-6 h-6"></i>
        </a>
        <h1 class="text-xl font-bold text-gray-800 dark:text-gray-200">Pengaturan</h1>
    </header>

    @if (session('success'))
        <div class="bg-teal-100 border border-teal-400 text-teal-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <section class="mb-8">
        {{-- Tambahkan class dark mode --}}
        <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 flex items-center space-x-2 border-b border-gray-200 dark:border-gray-700 pb-2">
            <i data-feather="user" class="w-4 h-4"></i>
            <span>Akun</span>
        </h2>
        <div class="mt-4 space-y-2">
            <a href="{{ route('app.settings.username') }}" class="flex justify-between items-center py-3 text-gray-800 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg px-2">
                <span>Ganti Username</span>
                <i data-feather="chevron-right" class="w-5 h-5 text-gray-400"></i>
            </a>
            <a href="{{ route('app.settings.password') }}" class="flex justify-between items-center py-3 text-gray-800 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg px-2">
                <span>Ganti Kata Sandi</span>
                <i data-feather="chevron-right" class="w-5 h-5 text-gray-400"></i>
            </a>
        </div>
    </section>

    <section class="mb-12">
        <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 flex items-center space-x-2 border-b border-gray-200 dark:border-gray-700 pb-2">
            <i data-feather="bell" class="w-4 h-4"></i>
            <span>Notifikasi</span>
        </h2>
        <div class="mt-4 space-y-4">
            <div class="flex justify-between items-center py-2">
                <span class="text-gray-800 dark:text-gray-200">Aktivitas Akun</span>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" data-type="activity" class="sr-only peer notification-toggle" @checked($user->notify_account_activity)>
                    <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:bg-gray-600 peer-checked:bg-teal-600"></div>
                </label>
            </div>
            <div class="flex justify-between items-center py-2">
                <span class="text-gray-800 dark:text-gray-200">Pemberitahuan</span>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" data-type="general" class="sr-only peer notification-toggle" @checked($user->notify_general)>
                    <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:bg-gray-600 peer-checked:bg-teal-600"></div>
                </label>
            </div>
        </div>
    </section>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-full focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
            Keluar
        </button>
    </form>
</main>
@include('layouts.partials.bottom-nav', ['active' => 'settings'])
@endsection
@push('scripts')
<script>
    // Deklarasikan HANYA SATU KALI di sini
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // --- SKRIP UNTUK NOTIFIKASI ---
    document.querySelectorAll('.notification-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const type = this.dataset.type;
            const status = this.checked;

            // Gunakan variabel csrfToken yang sudah ada
            fetch("{{ route('app.settings.notifications.update') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    type: type,
                    status: status
                })
            })
            .then(response => response.json())
            .then(data => console.log('Notifikasi diperbarui:', data.message))
            .catch(error => console.error('Error:', error));
        });
    });

    // --- SKRIP UNTUK TEMA ---
    const themeToggle = document.getElementById('theme-toggle');

    if (themeToggle) { // Pastikan elemennya ada sebelum menambahkan event listener
        // Atur posisi toggle saat halaman dimuat
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && document.documentElement.classList.contains('dark'))) {
            themeToggle.checked = true;
        } else {
            themeToggle.checked = false;
        }

        // Tambahkan event listener saat toggle diklik
        themeToggle.addEventListener('change', function() {
            const newTheme = this.checked ? 'dark' : 'light';
            localStorage.theme = newTheme;

            if (this.checked) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }

            // Gunakan variabel csrfToken yang sudah ada
            fetch("{{ route('app.settings.theme.update') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    theme: newTheme
                })
            })
            .then(response => response.json())
            .then(data => console.log('Tema diperbarui:', data.message))
            .catch(error => console.error('Error:', error));
        });
    }
</script>
@endpush