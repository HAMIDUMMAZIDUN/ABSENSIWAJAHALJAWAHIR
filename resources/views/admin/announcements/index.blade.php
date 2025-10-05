<x-app-admin-layout>
    <x-slot name="title">
        Manajemen Pengumuman
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">
                Daftar Pengumuman
            </h1>
            {{-- PERBAIKAN DI SINI --}}
            <a href="{{ route('admin.announcements.create') }}" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 flex items-center">
                <i data-feather="plus" class="w-4 h-4 mr-2"></i>
                Buat Pengumuman
            </a>
        </div>

        {{-- Menampilkan pesan sukses --}}
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Judul</th>
                            <th scope="col" class="px-6 py-3">Level</th>
                            <th scope="col" class="px-6 py-3 text-center">Status</th>
                            <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($announcements as $announcement)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $announcement->title }}
                            </td>
                            <td class="px-6 py-4 capitalize">
                                {{ $announcement->level }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($announcement->is_active)
                                    <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">Aktif</span>
                                @else
                                    <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center space-x-4">
                                    {{-- PERBAIKAN DI SINI --}}
                                    <a href="{{ route('admin.announcements.edit', $announcement) }}" class="text-blue-500 hover:text-blue-700" title="Edit">
                                        <i data-feather="edit-2" class="w-5 h-5"></i>
                                    </a>
                                    {{-- PERBAIKAN DI SINI --}}
                                    <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700" title="Hapus">
                                            <i data-feather="trash-2" class="w-5 h-5"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-8 text-gray-500 dark:text-gray-400">
                                Belum ada pengumuman yang dibuat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
             @if ($announcements->hasPages())
                <div class="p-6">
                    {{ $announcements->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-admin-layout>