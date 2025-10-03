<x-app-admin-layout>
    {{-- Slot untuk judul halaman --}}
    <x-slot name="title">
        Dashboard Admin
    </x-slot>

    {{-- Notifikasi Sukses --}}
    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
            <span class="font-medium">Sukses!</span> {{ session('success') }}
        </div>
    @endif

    {{-- 1. KARTU STATISTIK --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 flex items-center">
            <div class="bg-teal-500 bg-opacity-20 text-teal-600 dark:text-teal-300 rounded-full p-3">
                <i data-feather="users" class="w-6 h-6"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Pengguna</p>
                <p id="total-users" class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $totalUsers }}</p>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 flex items-center">
            <div class="bg-green-500 bg-opacity-20 text-green-600 dark:text-green-300 rounded-full p-3">
                <i data-feather="user-check" class="w-6 h-6"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Pengguna Aktif</p>
                <p id="active-users" class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $activeUsers }}</p>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 flex items-center">
            <div class="bg-red-500 bg-opacity-20 text-red-600 dark:text-red-300 rounded-full p-3">
                <i data-feather="user-x" class="w-6 h-6"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Pengguna Nonaktif</p>
                <p id="inactive-users" class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $inactiveUsers }}</p>
            </div>
        </div>
    </div>

    {{-- 2. TABEL PENGGUNA --}}
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
        <div class="p-6 border-b dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Manajemen Pengguna</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr id="user-row-{{ $user->id }}" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $user->name }}
                        </th>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span id="status-{{ $user->id }}" class="px-2 py-1 font-semibold leading-tight rounded-full {{ $user->is_active ? 'text-green-700 bg-green-100 dark:bg-green-700 dark:text-green-100' : 'text-red-700 bg-red-100 dark:bg-red-700 dark:text-red-100' }}">
                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{-- Tombol Toggle Status --}}
                            <button 
                                class="toggle-status-btn font-medium {{ $user->is_active ? 'text-yellow-600 dark:text-yellow-500' : 'text-green-600 dark:text-green-500' }} hover:underline"
                                data-user-id="{{ $user->id }}"
                                data-current-status="{{ $user->is_active ? '1' : '0' }}"
                                data-url="{{ route('admin.users.toggle-status', $user) }}">
                                {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                            {{-- Tombol Edit --}}
                            <a href="{{ route('admin.users.edit', $user) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline ml-4">Edit</a>
                            {{-- Tombol Hapus --}}
                            <button 
                                class="delete-user-btn font-medium text-red-600 dark:text-red-500 hover:underline ml-4"
                                data-user-id="{{ $user->id }}"
                                data-user-name="{{ $user->name }}"
                                data-url="{{ route('admin.users.destroy', $user) }}">
                                Hapus
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                            Tidak ada data pengguna.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Link Paginasi --}}
        <div class="p-6">
            {{ $users->links() }}
        </div>
    </div>

</x-admin-layout>