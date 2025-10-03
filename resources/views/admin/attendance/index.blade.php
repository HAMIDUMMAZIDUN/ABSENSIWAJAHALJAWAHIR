<x-app-admin-layout>
    {{-- Slot untuk judul halaman --}}
    <x-slot name="title">
        Rekapitulasi Absensi
    </x-slot>

    {{-- Konten utama halaman --}}
    <div class="container mx-auto px-4 py-8">
        
        {{-- Header Halaman --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">
                Rekap Absensi Pengguna
            </h1>
            <div class="flex space-x-2">
                <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 flex items-center">
                    <i data-feather="file-text" class="w-4 h-4 mr-2"></i>
                    Export PDF
                </button>
                <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 flex items-center">
                    <i data-feather="file" class="w-4 h-4 mr-2"></i>
                    Export Excel
                </button>
            </div>
        </div>

        {{-- Kotak utama untuk konten --}}
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden p-6">

            {{-- Form untuk filter data --}}
            <form method="GET" action="{{ route('admin.attendance.index') }}">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0 md:space-x-4 mb-6">
                    <div class="w-full md:w-auto flex-grow">
                        <label for="search" class="sr-only">Cari...</label>
                        {{-- Input search akan tetap terisi setelah filter diterapkan --}}
                        <input type="text" name="search" id="search" placeholder="Cari nama pengguna..." value="{{ request('search') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                    <div class="flex items-center space-x-2">
                        <div>
                            <label for="start_date" class="text-sm text-gray-600 dark:text-gray-300">Dari</label>
                            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                        <div>
                            <label for="end_date" class="text-sm text-gray-600 dark:text-gray-300">Hingga</label>
                            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>
                    <button type="submit" class="w-full md:w-auto px-6 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-opacity-50">
                        Filter
                    </button>
                </div>
            </form>

            {{-- Tabel Data Absensi --}}
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">No</th>
                            <th scope="col" class="px-6 py-3">Nama Pengguna</th>
                            <th scope="col" class="px-6 py-3">Tanggal</th>
                            <th scope="col" class="px-6 py-3">Jam Masuk</th>
                            <th scope="col" class="px-6 py-3">Jam Pulang</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attendances as $index => $attendance)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4">{{ $attendances->firstItem() + $index }}</td>
                                
                                {{-- INI BARIS KODENYA --}}
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $attendance->user->name }}
                                </th>
                                
                                <td class="px-6 py-4">{{ $attendance->date->format('d F Y') }}</td>
                                <td class="px-6 py-4">{{ $attendance->check_in ? $attendance->check_in->format('H:i') : '-' }}</td>
                                <td class="px-6 py-4">{{ $attendance->check_out ? $attendance->check_out->format('H:i') : '-' }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                        {{ $attendance->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data absensi untuk periode yang dipilih.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Link Paginasi --}}
            <div class="mt-6">
                {{ $attendances->links() }}
            </div>

        </div>
    </div>
</x-admin-layout>