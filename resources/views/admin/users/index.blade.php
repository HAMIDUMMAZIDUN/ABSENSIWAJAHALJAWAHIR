<x-app-admin-layout>
    <x-slot name="title">
        Manajemen Pengguna
    </x-slot>

    @if (session('success'))
        <div id="success-notification" class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
            <span class="font-medium">Sukses!</span> {{ session('success') }}
        </div>
    @endif
    
    {{-- STATISTIK KHUSUS PENGGUNA --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 flex items-center">
            <div class="bg-teal-500 bg-opacity-20 text-teal-600 dark:text-teal-300 rounded-full p-3"><i data-feather="users" class="w-6 h-6"></i></div>
            <div class="ml-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Pengguna</p>
                <p id="total-users" class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $totalUsers }}</p>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 flex items-center">
            <div class="bg-green-500 bg-opacity-20 text-green-600 dark:text-green-300 rounded-full p-3"><i data-feather="user-check" class="w-6 h-6"></i></div>
            <div class="ml-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Pengguna Aktif</p>
                <p id="active-users" class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $activeUsers }}</p>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 flex items-center">
            <div class="bg-red-500 bg-opacity-20 text-red-600 dark:text-red-300 rounded-full p-3"><i data-feather="user-x" class="w-6 h-6"></i></div>
            <div class="ml-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Pengguna Nonaktif</p>
                <p id="inactive-users" class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $inactiveUsers }}</p>
            </div>
        </div>
    </div>

    {{-- MANAJEMEN PENGGUNA --}}
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
        <div class="p-6 border-b dark:border-gray-700 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Daftar Pengguna</h2>
            
            <div id="bulk-actions-container" class="hidden flex items-center gap-2">
                <button id="bulk-activate-btn" class="px-3 py-1 text-xs font-medium text-white bg-green-600 rounded-md hover:bg-green-700">Aktifkan Terpilih</button>
                <button id="bulk-deactivate-btn" class="px-3 py-1 text-xs font-medium text-white bg-red-600 rounded-md hover:bg-red-700">Nonaktifkan Terpilih</button>
            </div>
        </div>

        <div class="p-6">
            @if ($users->isEmpty())
                <div class="text-center py-12 text-gray-500 dark:text-gray-400"><p>Tidak ada data pengguna.</p></div>
            @else
                <div class="flex items-center mb-4">
                    <input type="checkbox" id="select-all-users" class="h-4 w-4 rounded border-gray-300 text-teal-600 focus:ring-teal-500">
                    <label for="select-all-users" class="ml-2 text-sm text-gray-600 dark:text-gray-400">Pilih Semua</label>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @php
                        $colors = ['bg-blue-500', 'bg-indigo-500', 'bg-purple-500', 'bg-pink-500', 'bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-green-500', 'bg-teal-500'];
                    @endphp
                    @foreach ($users as $user)
                        <div id="user-card-{{ $user->id }}" class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg shadow-sm flex flex-wrap items-center justify-between gap-y-4">
                            <div class="flex items-center gap-4 min-w-0 flex-1">
                                <input type="checkbox" class="user-checkbox h-4 w-4 rounded border-gray-300 text-teal-600 focus:ring-teal-500" data-user-id="{{ $user->id }}">
                                <div class="{{ $colors[ord(strtoupper($user->name[0])) % count($colors)] }} rounded-full w-12 h-12 flex-shrink-0 flex items-center justify-center text-white font-bold text-xl">{{ strtoupper($user->name[0]) }}</div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-900 dark:text-white truncate">{{ $user->name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 sm:gap-4 flex-shrink-0 w-full sm:w-auto justify-end">
                                @if (isset($user->is_active))
                                <label for="status-toggle-{{ $user->id }}" class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="status-toggle-{{ $user->id }}" class="sr-only peer toggle-status-checkbox" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}" data-url="{{ route('admin.users.toggle-status', $user) }}" {{ $user->is_active == 1 ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-red-500 rounded-full peer peer-checked:after:translate-x-full after:content[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
                                </label>
                                @endif
                                <div class="flex items-center">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-gray-400 hover:text-blue-500 p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700" aria-label="Edit Pengguna"><i data-feather="edit-2" class="w-5 h-5"></i></a>
                                    <button class="delete-user-btn text-gray-400 hover:text-red-500 p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}" data-url="{{ route('admin.users.destroy', $user) }}" aria-label="Hapus Pengguna"><i data-feather="trash-2" class="w-5 h-5"></i></button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        
        <div class="p-6 border-t dark:border-gray-700">
            {{ $users->links() }}
        </div>
    </div>
    
    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof feather !== 'undefined') feather.replace();

        const successNotification = document.getElementById('success-notification');
        if (successNotification) {
            setTimeout(() => {
                successNotification.style.transition = 'opacity 0.5s ease';
                successNotification.style.opacity = '0';
                setTimeout(() => successNotification.style.display = 'none', 500);
            }, 5000);
        }

        const selectAllCheckbox = document.getElementById('select-all-users');
        const userCheckboxes = document.querySelectorAll('.user-checkbox');
        const bulkActionsContainer = document.getElementById('bulk-actions-container');
        const bulkActivateBtn = document.getElementById('bulk-activate-btn');
        const bulkDeactivateBtn = document.getElementById('bulk-deactivate-btn');

        function toggleBulkActions() {
            const anyChecked = Array.from(userCheckboxes).some(cb => cb.checked);
            bulkActionsContainer.classList.toggle('hidden', !anyChecked);
        }

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', () => {
                userCheckboxes.forEach(checkbox => checkbox.checked = selectAllCheckbox.checked);
                toggleBulkActions();
            });
        }
        
        userCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                if (!checkbox.checked) selectAllCheckbox.checked = false;
                toggleBulkActions();
            });
        });

        function handleBulkAction(status, actionText) {
            const selectedUserIds = Array.from(userCheckboxes).filter(cb => cb.checked).map(cb => cb.dataset.userId);
            if (selectedUserIds.length === 0) {
                Swal.fire('Tidak Ada Pengguna', 'Silakan pilih pengguna terlebih dahulu.', 'info');
                return;
            }

            Swal.fire({
                title: 'Konfirmasi Aksi Massal',
                text: `Apakah Anda yakin ingin ${actionText} ${selectedUserIds.length} pengguna yang dipilih?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: `Ya, ${actionText}!`,
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('{{ route("admin.users.bulk-status-update") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ userIds: selectedUserIds, status: status })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Berhasil!', data.message, 'success').then(() => location.reload());
                        } else {
                            Swal.fire('Gagal!', data.message || 'Gagal melakukan aksi massal.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'Terjadi kesalahan.', 'error');
                    });
                }
            });
        }

        if (bulkActivateBtn) bulkActivateBtn.addEventListener('click', () => handleBulkAction(1, 'mengaktifkan'));
        if (bulkDeactivateBtn) bulkDeactivateBtn.addEventListener('click', () => handleBulkAction(2, 'menonaktifkan'));

        document.querySelectorAll('.toggle-status-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function(event) {
                const self = this;
                const userName = self.dataset.userName;
                const newStatus = self.checked;
                const actionText = newStatus ? 'mengaktifkan' : 'menonaktifkan';

                Swal.fire({
                    title: 'Konfirmasi Perubahan Status',
                    text: `Apakah Anda yakin ingin ${actionText} pengguna "${userName}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: `Ya, ${actionText}!`,
                    cancelButtonText: 'Batal',
                    allowOutsideClick: false, 
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(self.dataset.url, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                            body: JSON.stringify({ is_active: newStatus })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('total-users').textContent = data.totalUsers;
                                document.getElementById('active-users').textContent = data.activeUsers;
                                document.getElementById('inactive-users').textContent = data.inactiveUsers;
                                Swal.fire('Berhasil!', data.message, 'success');
                            } else {
                                self.checked = !newStatus;
                                Swal.fire('Gagal!', data.message || 'Gagal mengubah status pengguna.', 'error');
                            }
                        })
                        .catch(error => {
                            self.checked = !newStatus;
                            console.error('Error:', error);
                            Swal.fire('Error!', 'Terjadi kesalahan.', 'error');
                        });
                    } else {
                        self.checked = !newStatus;
                    }
                });
            });
        });

        document.querySelectorAll('.delete-user-btn').forEach(button => {
            button.addEventListener('click', function() {
                // ... (Kode untuk hapus pengguna tetap sama)
            });
        });
    });
    </script>
    @endpush
</x-app-admin-layout>
