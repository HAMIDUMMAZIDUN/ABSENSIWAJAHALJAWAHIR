<x-app-admin-layout>
<x-slot name="title">
Edit Pengguna: {{ $user->name }}
</x-slot>

<div class="max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6 border-b pb-2">
        Edit Detail Pengguna
    </h2>

    {{-- Menampilkan pesan sukses dari Controller (setelah update) --}}
    @if (session('success'))
        <div class="bg-teal-100 border border-teal-400 text-teal-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('error') }}
        </div>
    @endif

    {{-- Form Edit --}}
    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
        @csrf
        @method('PATCH')

        {{-- Nama --}}
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Lengkap</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required 
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required 
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Nomor Telepon --}}
        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">No. Handphone</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" 
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                   placeholder="Masukkan jika belum ada">
            @error('phone')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        {{-- Role --}}
        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role Pengguna</label>
            <select name="role" id="role" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>


        {{-- === PERGANTIAN PASSWORD (Optional) === --}}
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mt-8 mb-4 border-t pt-4">Ganti Kata Sandi (Opsional)</h3>

        {{-- Password Baru --}}
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password Baru</label>
            <input type="password" name="password" id="password" 
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                   placeholder="Biarkan kosong jika tidak ingin mengubah password">
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Minimal 8 karakter.</p>
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Konfirmasi Password --}}
        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" id="password_confirmation" 
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            @error('password_confirmation')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('admin.dashboard') }}" class="text-gray-600 dark:text-gray-400 hover:underline">
                &larr; Kembali ke Dashboard
            </a>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-md hover:bg-teal-700 active:bg-teal-900 focus:outline-none focus:border-teal-900 focus:ring ring-teal-300 disabled:opacity-25 transition ease-in-out duration-150">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

</x-app-admin-layout>