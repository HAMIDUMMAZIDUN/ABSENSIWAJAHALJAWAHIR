<x-app-admin-layout>
    <x-slot name="title">
        Buat Pengumuman Baru
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-6">
            Buat Pengumuman Baru
        </h1>

        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg p-6">
            <form action="{{ route('admin.announcements.store') }}" method="POST">
                @csrf
                
                {{-- Judul Pengumuman --}}
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:border-teal-500 focus:ring-teal-500">
                    @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Konten Pengumuman --}}
                <div class="mb-4">
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Isi Pengumuman</label>
                    <textarea name="content" id="content" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:border-teal-500 focus:ring-teal-500">{{ old('content') }}</textarea>
                    @error('content')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Level Pengumuman --}}
                <div class="mb-4">
                    <label for="level" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Level</label>
                    <select name="level" id="level" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:border-teal-500 focus:ring-teal-500">
                        <option value="info" {{ old('level') == 'info' ? 'selected' : '' }}>Info (Biru)</option>
                        <option value="warning" {{ old('level') == 'warning' ? 'selected' : '' }}>Peringatan (Kuning)</option>
                        <option value="danger" {{ old('level') == 'danger' ? 'selected' : '' }}>Penting (Merah)</option>
                    </select>
                    @error('level')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Status Aktif --}}
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-teal-600 shadow-sm focus:ring-teal-500" checked>
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Aktifkan pengumuman ini?</span>
                    </label>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('admin.announcements.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500">
                        Batal
                    </a>
                    <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700">
                        Simpan Pengumuman
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-admin-layout>