<x-app-admin-layout>
    {{-- Slot untuk judul halaman --}}
    <x-slot name="title">
        Manajemen Data Wajah
    </x-slot>

    {{-- Konten utama halaman --}}
    <div class="container mx-auto px-4 py-8">
        
        {{-- Header Halaman --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">
                Data Wajah Pengguna
            </h1>
            {{-- Tombol Tambah Data (Opsional) --}}
            {{-- <a href="#" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-opacity-50 flex items-center">
                <i data-feather="plus" class="w-4 h-4 mr-2"></i>
                Tambah Data
            </a> --}}
        </div>

        {{-- Kotak utama untuk konten --}}
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden p-6">

            {{-- Form untuk filter dan pencarian data --}}
            <form method="GET" action="{{ route('admin.faces.index') }}">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0 md:space-x-4 mb-6">
                    <div class="w-full md:w-1/2 lg:w-2/3">
                        <label for="search" class="sr-only">Cari...</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-feather="search" class="w-5 h-5 text-gray-400"></i>
                            </div>
                            <input type="text" name="search" id="search" placeholder="Cari nama atau NIP pengguna..." value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>
                    <button type="submit" class="w-full md:w-auto px-6 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-opacity-50">
                        Cari
                    </button>
                </div>
            </form>

            {{-- Tabel Data Wajah --}}
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">No</th>
                            <th scope="col" class="px-6 py-3">Foto Wajah</th>
                            <th scope="col" class="px-6 py-3">Nama Pengguna</th>
                            <th scope="col" class="px-6 py-3">NIP/ID</th>
                            <th scope="col" class="px-6 py-3">Tanggal Pendaftaran</th>
                            <th scope="col" class="px-6 py-3 text-center">Status</th>
                            <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Ganti $faces dengan variabel yang Anda kirim dari controller --}}
                        @forelse ($faces as $index => $face)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4">{{ $faces->firstItem() + $index }}</td>
                                <td class="px-6 py-4">
                                    {{-- Ganti 'face_image_path' dengan nama kolom di database Anda --}}
                                    <img src="{{ asset('storage/' . $face->face_image_path) }}" alt="Foto Wajah" class="w-16 h-16 object-cover rounded-lg shadow-md">
                                </td>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $face->user->name ?? 'Pengguna tidak ditemukan' }}
                                </th>
                                <td class="px-6 py-4">{{ $face->user->nip ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $face->created_at->translatedFormat('d M Y, H:i') }}</td>
                                <td class="px-6 py-4 text-center">
                                    {{-- Contoh logika untuk status --}}
                                    @if($face->is_verified)
                                        <span class="px-3 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                            Terverifikasi
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100">
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        {{-- Ganti # dengan route yang sesuai --}}
                                        <a href="#" class="p-2 text-blue-500 hover:text-blue-700" title="Lihat Detail">
                                            <i data-feather="eye" class="w-5 h-5"></i>
                                        </a>
                                        <a href="#" class="p-2 text-yellow-500 hover:text-yellow-700" title="Edit Data">
                                            <i data-feather="edit" class="w-5 h-5"></i>
                                        </a>
                                        <button class="p-2 text-red-500 hover:text-red-700" title="Hapus Data" onclick="/* Logika hapus */">
                                            <i data-feather="trash-2" class="w-5 h-5"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center">
                                        
                                        <p class="mt-4 text-lg">Tidak ada data wajah yang ditemukan.</p>
                                        <p class="text-sm">Coba ubah kata kunci pencarian Anda atau daftarkan data wajah baru.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Link Paginasi --}}
            <div class="mt-6">
                {{-- Pastikan Anda menggunakan paginasi di controller --}}
                {{ $faces->links() }}
            </div>

        </div>
    </div>
</x-app-admin-layout>
