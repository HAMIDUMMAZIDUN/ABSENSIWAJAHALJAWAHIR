<x-app-admin-layout>
    <x-slot name="title">
        Manajemen Data Wajah
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">
                Data Wajah Pengguna
            </h1>
        </div>

        {{-- // 1. Tambahkan x-data untuk mengelola state modal --}}
        <div x-data="{ isModalOpen: false, selectedUser: {} }" class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden p-6">

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

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">No</th>
                            <th scope="col" class="px-6 py-3">Foto Wajah</th>
                            <th scope="col" class="px-6 py-3">Nama Pengguna</th>
                            <th scope="col" class="px-6 py-3">NIP/ID</th>
                            <th scope="col" class="px-6 py-3">Tanggal Bergabung</th>
                            <th scope="col" class="px-6 py-3 text-center">Status Wajah</th>
                            <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $index => $user)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4">{{ $users->firstItem() + $index }}</td>
                                <td class="px-6 py-4">
                                    @if($user->photo)
                                        <img src="{{ asset('storage/'  . $user->photo) }}" alt="Foto Wajah" class="w-16 h-16 object-cover rounded-lg shadow-md">
                                    @else
                                        <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center text-gray-500">
                                            <i data-feather="user" class="w-8 h-8"></i>
                                        </div>
                                    @endif
                                </td>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $user->name }}
                                </th>
                                <td class="px-6 py-4">{{ $user->nip ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $user->created_at->translatedFormat('d M Y') }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($user->photo)
                                        <span class="px-3 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">Terdaftar</span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">Belum Ada</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        {{-- // 2. Ubah tombol detail untuk memicu modal --}}
                                        <button @click="selectedUser = {{ json_encode($user) }}; isModalOpen = true" class="p-2 text-blue-500 hover:text-blue-700" title="Lihat Detail Pengguna">
                                            <i data-feather="eye" class="w-5 h-5"></i>
                                        </button>
                                        <button class="p-2 text-red-500 hover:text-red-700" title="Hapus Data Wajah" onclick="/* Logika hapus */">
                                            <i data-feather="trash-2" class="w-5 h-5"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <p class="mt-4 text-lg">Tidak ada data pengguna yang ditemukan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $users->links() }}
            </div>
            
            {{-- // 3. Tambahkan struktur HTML untuk modal --}}
            <div x-show="isModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" @click="isModalOpen = false"></div>
                <div class="flex items-center justify-center min-h-full p-4 text-center sm:p-0">
                    <div @click.away="isModalOpen = false" x-show="isModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-xl transform transition-all sm:my-8 sm:w-full sm:max-w-lg w-full">
                        <div class="bg-gray-100 dark:bg-gray-900 px-6 py-4 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100" id="modal-title">Detail Pengguna</h3>
                            <button @click="isModalOpen = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                <i data-feather="x" class="w-6 h-6"></i>
                            </button>
                        </div>
                        <div class="p-6 text-left">
                            <div class="flex flex-col items-center sm:flex-row sm:items-start gap-6">
                                <img :src="selectedUser.photo ? '{{ asset('storage') }}/' + selectedUser.photo : 'https://i.pravatar.cc/150?u=' + selectedUser.id" alt="Foto Profil" class="w-24 h-24 rounded-full object-cover shadow-lg">
                                <div class="w-full text-center sm:text-left">
                                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white" x-text="selectedUser.name"></h2>
                                    <p class="text-sm text-gray-500 dark:text-gray-400" x-text="selectedUser.email"></p>
                                </div>
                            </div>
                            <div class="mt-6 border-t dark:border-gray-700 pt-4">
                                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2">
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">NIP/ID</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200" x-text="selectedUser.nip || '-'"></dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Telepon</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200" x-text="selectedUser.phone || '-'"></dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Role</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 capitalize" x-text="selectedUser.role"></dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Akun</dt>
                                        <dd class="mt-1 text-sm">
                                            <span x-show="selectedUser.is_active == 1" class="px-2 py-0.5 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">Aktif</span>
                                            <span x-show="selectedUser.is_active != 1" class="px-2 py-0.5 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">Nonaktif</span>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-900/50 px-4 py-3 sm:flex sm:flex-row-reverse">
                            <button type="button" @click="isModalOpen = false" class="inline-flex w-full justify-center rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2 text-base font-medium text-gray-700 dark:text-gray-200 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-admin-layout>