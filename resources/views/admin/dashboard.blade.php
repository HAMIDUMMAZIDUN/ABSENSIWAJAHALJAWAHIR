<x-app-admin-layout>
    {{-- Ini akan mengisi variabel $title di layout --}}
    <x-slot name="title">
        Admin Dashboard
    </x-slot>

    {{-- Seluruh kode di bawah ini akan masuk ke dalam {{ $slot }} --}}

    {{-- Notifikasi Toast akan muncul di sini --}}
    <div id="toast-container" class="fixed top-5 right-5 z-50 space-y-2"></div>

    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        {{-- Konten statistik Anda --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pengguna</h3>
            <p id="total-users-stat" class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalUsers }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Pengguna Aktif</h3>
            <p id="active-users-stat" class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">{{ $activeUsers }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Pengguna Nonaktif</h3>
            <p id="inactive-users-stat" class="text-3xl font-bold text-red-600 dark:text-red-400 mt-2">{{ $inactiveUsers }}</p>
        </div>
    </section>

    <section>
        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Manajemen Pengguna</h2>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Foto</th>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Status Login</th>
                        {{-- PENAMBAHAN BARU: Kolom Aksi --}}
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    {{-- Tambahkan id unik untuk setiap baris --}}
                    <tr id="user-row-{{ $user->id }}" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            <img src="{{ $user->photo ? Storage::url($user->photo) : asset('images/default-avatar.png') }}" alt="Foto {{ $user->name }}" class="w-10 h-10 rounded-full object-cover">
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $user->name }}
                        </td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox"
                                       data-url="{{ route('admin.users.toggle-status', $user) }}"
                                       class="sr-only peer user-status-toggle"
                                       @checked($user->is_active)>
                                <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:bg-gray-600 peer-checked:bg-teal-600"></div>
                            </label>
                        </td>
                        {{-- PENAMBAHAN BARU: Tombol Hapus --}}
                        <td class="px-6 py-4">
                            <button type="button"
                                    data-url="{{ route('admin.users.destroy', $user) }}"
                                    data-user-name="{{ $user->name }}"
                                    class="delete-user-button font-medium text-red-600 dark:text-red-500 hover:underline">
                                Hapus
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        {{-- PENAMBAHAN BARU: colspan diubah menjadi 5 --}}
                        <td colspan="5" class="px-6 py-4 text-center">Tidak ada pengguna untuk ditampilkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </section>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function showToast(message, isSuccess = true) {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            const bgColor = isSuccess ? 'bg-teal-500' : 'bg-red-500';
            toast.className = `max-w-xs ${bgColor} text-sm text-white rounded-md shadow-lg p-4 transition-transform transform translate-x-full`;
            toast.textContent = message;
            container.appendChild(toast);
            setTimeout(() => toast.classList.remove('translate-x-full'), 100);
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => toast.remove(), 500);
            }, 3000);
        }

        // --- Logika untuk Toggle Status (Kode Lama Anda) ---
        document.querySelectorAll('.user-status-toggle').forEach(toggle => {
            toggle.addEventListener('change', async function (event) {
                const url = this.dataset.url;
                const newStatus = this.checked;

                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ is_active: newStatus })
                    });
                    const result = await response.json();
                    if (!response.ok) { throw new Error(result.message || 'Gagal memperbarui status.'); }
                    showToast(result.message, true);

                    // Update statistik tanpa reload
                    document.getElementById('active-users-stat').textContent = result.activeUsers;
                    document.getElementById('inactive-users-stat').textContent = result.inactiveUsers;

                } catch (error) {
                    console.error('Terjadi kesalahan:', error);
                    showToast(error.message, false);
                    event.target.checked = !newStatus;
                }
            });
        });

        // --- PENAMBAHAN BARU: Logika untuk Tombol Hapus ---
        document.querySelectorAll('.delete-user-button').forEach(button => {
            button.addEventListener('click', async function (event) {
                event.preventDefault();

                const url = this.dataset.url;
                const userName = this.dataset.userName;

                if (confirm(`Apakah Anda yakin ingin menghapus pengguna "${userName}"? Aksi ini tidak dapat dibatalkan.`)) {
                    try {
                        const response = await fetch(url, {
                            method: 'DELETE', // Menggunakan method DELETE
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            }
                        });

                        const result = await response.json();
                        if (!response.ok) { throw new Error(result.message || 'Gagal menghapus pengguna.'); }

                        showToast(result.message, true);

                        // Hapus baris dari tabel
                        this.closest('tr').remove();

                        // Update statistik tanpa reload
                        document.getElementById('total-users-stat').textContent = result.totalUsers;
                        document.getElementById('active-users-stat').textContent = result.activeUsers;
                        document.getElementById('inactive-users-stat').textContent = result.inactiveUsers;

                    } catch (error) {
                        console.error('Terjadi kesalahan:', error);
                        showToast(error.message, false);
                    }
                }
            });
        });
    });
    </script>
    @endpush
</x-app-admin-layout>