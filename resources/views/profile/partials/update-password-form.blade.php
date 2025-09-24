@extends('layouts.app-mobile')

@section('title', 'Ubah Password')

@section('content')
<main class="p-6 pb-24">
    <header class="flex items-center mb-6">
        {{-- Tombol kembali bisa disesuaikan, mungkin ke halaman profil atau setting --}}
        <a href="{{ route('profile.edit') }}" class="text-gray-800 dark:text-gray-200">
            <i data-feather="arrow-left" class="w-6 h-6"></i>
        </a>
        <h1 class="text-xl font-bold text-gray-800 dark:text-gray-200 mx-auto">Ubah Password</h1>
    </header>

    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 mb-6 text-center">
        Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.
    </p>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        {{-- Input Password Saat Ini --}}
        <div>
            <label for="update_password_current_password" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Password Saat Ini</label>
            <div class="relative">
                <input id="update_password_current_password" name="current_password" type="password" class="block w-full px-5 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-full shadow-sm" autocomplete="current-password">
                <button type="button" onclick="togglePasswordVisibility('update_password_current_password')" class="absolute inset-y-0 right-0 px-4 flex items-center text-gray-500">
                    <i data-feather="eye" class="w-5 h-5"></i>
                </button>
            </div>
            @error('current_password', 'updatePassword')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Input Password Baru --}}
        <div>
            <label for="update_password_password" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Password Baru</label>
            <div class="relative">
                <input id="update_password_password" name="password" type="password" class="block w-full px-5 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-full shadow-sm" autocomplete="new-password">
                <button type="button" onclick="togglePasswordVisibility('update_password_password')" class="absolute inset-y-0 right-0 px-4 flex items-center text-gray-500">
                    <i data-feather="eye" class="w-5 h-5"></i>
                </button>
            </div>
             @error('password', 'updatePassword')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Konfirmasi Password Baru --}}
        <div>
            <label for="update_password_password_confirmation" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Konfirmasi Password</label>
            <div class="relative">
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="block w-full px-5 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-full shadow-sm" autocomplete="new-password">
                <button type="button" onclick="togglePasswordVisibility('update_password_password_confirmation')" class="absolute inset-y-0 right-0 px-4 flex items-center text-gray-500">
                    <i data-feather="eye" class="w-5 h-5"></i>
                </button>
            </div>
             @error('password_confirmation', 'updatePassword')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-4 rounded-full focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                Simpan
            </button>
        </div>
        
        @if (session('status') === 'password-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 3000)"
                class="text-sm text-green-600 dark:text-green-400 text-center"
            >
                Password berhasil diperbarui.
            </p>
        @endif
    </form>
</main>
@endsection

@push('scripts')
{{-- Pastikan AlpineJS sudah di-load di layout utama Anda jika belum --}}
<script src="//unpkg.com/alpinejs" defer></script>
<script>
    function togglePasswordVisibility(fieldId) {
        const passwordField = document.getElementById(fieldId);
        // Targetkan ikon di dalam tombol
        const icon = passwordField.parentElement.querySelector('button i');
        
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);

        // Ubah ikon berdasarkan tipe input
        if (type === 'password') {
            icon.setAttribute('data-feather', 'eye');
        } else {
            icon.setAttribute('data-feather', 'eye-off');
        }
        
        // Render ulang ikon feather setelah diubah
        feather.replace();
    }
</script>
@endpush