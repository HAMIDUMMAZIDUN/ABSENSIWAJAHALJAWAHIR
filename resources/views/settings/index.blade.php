<x-app-layout>
    <main class="p-6 pb-24 bg-slate-50 dark:bg-slate-900 min-h-screen">
        <header class="flex items-center space-x-4 mb-8">
            <a href="{{ url()->previous() }}" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                <i data-feather="arrow-left" class="w-6 h-6 text-gray-800 dark:text-gray-200"></i>
            </a>
            <h1 class="text-xl font-bold text-gray-800 dark:text-gray-200">Pengaturan</h1>
        </header>

        @if (session('success'))
            <div class="bg-teal-100 border-l-4 border-teal-500 text-teal-700 p-4 rounded-lg mb-8" role="alert">
                <p class="font-bold">Sukses</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <section class="mb-8">
            <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Akun</h2>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
                
                <a href="{{ route('app.settings.username') }}" class="flex justify-between items-center p-4 group border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <div class="flex items-center space-x-4">
                        <i data-feather="user" class="w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                        <span class="font-semibold text-gray-800 dark:text-gray-200">Ganti Username</span>
                    </div>
                    <i data-feather="chevron-right" class="w-5 h-5 text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300"></i>
                </a>
                
                <a href="{{ route('app.settings.password') }}" class="flex justify-between items-center p-4 group border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <div class="flex items-center space-x-4">
                        <i data-feather="lock" class="w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                        <span class="font-semibold text-gray-800 dark:text-gray-200">Ganti Kata Sandi</span>
                    </div>
                    <i data-feather="chevron-right" class="w-5 h-5 text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300"></i>
                </a>

                <a href="{{ route('app.settings.phone') }}" class="flex justify-between items-center p-4 group hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <div class="flex items-center space-x-4">
                        <i data-feather="phone" class="w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                        <span class="font-semibold text-gray-800 dark:text-gray-200">Ganti No Handphone</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $user->phone ?? 'Belum diatur' }}
                        </span>
                        <i data-feather="chevron-right" class="w-5 h-5 text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300"></i>
                    </div>
                </a>
                
                <a href="{{ route('app.settings.face.create') }}" class="flex justify-between items-center p-4 group border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <div class="flex items-center space-x-4">
                        <i data-feather="camera" class="w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                        <span class="font-semibold text-gray-800 dark:text-gray-200">Daftar Wajah</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        @if (Auth::user()->face)
                            <span class="px-2 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                Sudah Terdaftar
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100">
                                Belum Terdaftar
                            </span>
                        @endif
                        <i data-feather="chevron-right" class="w-5 h-5 text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300"></i>
                    </div>
                </a>
            </div>
        </section>

        <section class="mb-8">
            <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Tampilan</h2>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center p-4">
                    <div class="flex items-center space-x-4">
                        <i data-feather="moon" class="w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                        <span class="font-semibold text-gray-800 dark:text-gray-200">Mode Gelap</span>
                    </div>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="theme-toggle" class="sr-only peer">
                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:bg-gray-600 peer-checked:bg-teal-600"></div>
                    </label>
                </div>
            </div>
        </section>

        <section class="mb-8">
            <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Notifikasi</h2>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center p-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center space-x-4">
                        <i data-feather="activity" class="w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                        <span class="font-semibold text-gray-800 dark:text-gray-200">Aktivitas Akun</span>
                    </div>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" data-type="activity" class="sr-only peer notification-toggle" @checked($user->notify_account_activity)>
                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:bg-gray-600 peer-checked:bg-teal-600"></div>
                    </label>
                </div>
                <div class="flex justify-between items-center p-4">
                    <div class="flex items-center space-x-4">
                        <i data-feather="bell" class="w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                        <span class="font-semibold text-gray-800 dark:text-gray-200">Pemberitahuan</span>
                    </div>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" data-type="general" class="sr-only peer notification-toggle" @checked($user->notify_general)>
                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:bg-gray-600 peer-checked:bg-teal-600"></div>
                    </label>
                </div>
            </div>
        </section>

        <section>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center space-x-3 bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-full focus:outline-none focus:shadow-outline transition-colors duration-150 ease-in-out shadow-lg">
                    <i data-feather="log-out" class="w-5 h-5"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </section>
    </main>
    @include('layouts.partials.bottom-nav', ['active' => 'settings'])

@push('scripts')
<script>
    if (typeof window.csrfToken === 'undefined') {
        window.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        document.querySelectorAll('.notification-toggle').forEach(toggle => {
            toggle.addEventListener('change', function() {
                const type = this.dataset.type;
                const status = this.checked;

                fetch("{{ route('app.settings.notifications.update') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': window.csrfToken,
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

        const themeToggle = document.getElementById('theme-toggle');

        if (themeToggle) {
            if (document.documentElement.classList.contains('dark')) {
                themeToggle.checked = true;
            } else {
                themeToggle.checked = false;
            }

            themeToggle.addEventListener('change', function() {
                const newTheme = this.checked ? 'dark' : 'light';
                localStorage.theme = newTheme;

                if (this.checked) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }

                fetch("{{ route('app.settings.theme.update') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': window.csrfToken,
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
    }
</script>
@endpush
</x-app-layout>

