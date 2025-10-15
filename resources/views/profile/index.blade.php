<x-app-layout>
    {{-- Merombak total tema visual halaman profil agar lebih modern dan estetik --}}
    <main class="p-6 pb-24 bg-slate-50 dark:bg-slate-900 min-h-screen">
        {{-- Header Halaman --}}
        <header class="flex items-center justify-between mb-8">
            {{-- Tombol Kembali --}}
            <a href="{{ url()->previous() }}" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                <i data-feather="arrow-left" class="w-6 h-6 text-gray-800 dark:text-gray-200"></i>
            </a>
            <h1 class="text-xl font-bold text-gray-800 dark:text-gray-200">Profil Saya</h1>
            {{-- Tombol Pengaturan --}}
            <a href="{{ route('settings.index') }}" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                <i data-feather="settings" class="w-6 h-6 text-gray-800 dark:text-gray-200"></i>
            </a>
        </header>

        {{-- Notifikasi Sukses --}}
        @if (session('status'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-8" role="alert">
                <p class="font-bold">Sukses</p>
                <p>{{ session('status') }}</p>
            </div>
        @endif

        {{-- Menampilkan Error Validasi Foto --}}
        @error('photo')
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-8" role="alert">
                <p class="font-bold">Gagal</p>
                <p>{{ $message }}</p>
            </div>
        @enderror

        {{-- Kartu Profil Utama --}}
        <section class="mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 flex flex-col items-center text-center">
                
                {{-- 
                    CATATAN PENTING UNTUK MENAMPILKAN FOTO:
                    1. Kode ini menggunakan helper `asset()` untuk membuat URL yang lebih andal.
                    2. Pastikan Anda sudah menjalankan perintah `php artisan storage:link` di terminal.
                       Ini akan membuat file di 'storage' dapat diakses dari folder 'public'.
                    3. Pastikan method `updatePhoto` di `ProfileController` Anda menyimpan file
                       TANPA awalan 'public/' di path database. Path yang benar adalah, contohnya:
                       'profile-photos/namafile.jpg'
                --}}
                <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('images/default-avatar.png') }}" alt="Foto Profil" class="w-24 h-24 rounded-full object-cover mb-4 border-4 border-teal-500">
                
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</h2>
                <p class="text-gray-500 dark:text-gray-400 mb-6">{{ Auth::user()->email }}</p>

                {{-- FORM UNTUK UPLOAD FOTO PROFIL --}}
                <form id="photo-upload-form" action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data" class="w-full">
                    @csrf
                    {{-- Input file yang disembunyikan --}}
                    <input type="file" name="photo" id="photo-input" class="hidden" onchange="document.getElementById('photo-upload-form').submit()">

                    {{-- Label yang digayakan seperti tombol untuk memicu input file --}}
                    <label for="photo-input" class="cursor-pointer inline-flex items-center justify-center space-x-2 w-full px-4 py-2 bg-teal-600 border border-transparent rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 active:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        <i data-feather="upload" class="w-4 h-4"></i>
                        <span>Ubah Foto Profil</span>
                    </label>
                </form>

            </div>
        </section>

        {{-- Kartu Informasi & Aksi --}}
        <section>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center p-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center space-x-4">
                        <i data-feather="smartphone" class="w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                        <span class="font-semibold text-gray-800 dark:text-gray-200">No Handphone</span>
                    </div>
                    <a href="{{ route('settings.phone') }}" class="flex items-center space-x-2 group">
                        <span class="font-semibold text-gray-600 dark:text-gray-300 group-hover:text-teal-600 dark:group-hover:text-teal-400">
                            {{ Auth::user()->phone ?? 'Belum diatur' }}
                        </span>
                        <i data-feather="chevron-right" class="w-5 h-5 text-gray-400 group-hover:text-teal-600 dark:group-hover:text-teal-400"></i>
                    </a>
                </div>
                <a href="{{ route('settings.password') }}" class="flex justify-between items-center p-4 group hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <div class="flex items-center space-x-4">
                        <i data-feather="lock" class="w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                        <span class="font-semibold text-gray-800 dark:text-gray-200">Kata Sandi</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="font-semibold text-gray-600 dark:text-gray-300 group-hover:text-teal-600 dark:group-hover:text-teal-400">
                            Ubah
                        </span>
                        <i data-feather="chevron-right" class="w-5 h-5 text-gray-400 group-hover:text-teal-600 dark:group-hover:text-teal-400"></i>
                    </div>
                </a>
            </div>
        </section>

    </main>
    @include('layouts.partials.bottom-nav', ['active' => 'profile'])
</x-app-layout>

