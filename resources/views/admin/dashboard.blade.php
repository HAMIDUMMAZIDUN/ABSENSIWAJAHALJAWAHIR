@extends('layouts.app-admin')

@section('title', 'Admin Dashboard')

@section('content')
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pengguna</h3>
            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalUsers }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Pengguna Aktif</h3>
            <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">{{ $activeUsers }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Pengguna Nonaktif</h3>
            <p class="text-3xl font-bold text-red-600 dark:text-red-400 mt-2">{{ $inactiveUsers }}</p>
        </div>
    </section>

    <section>
        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Manajemen Pengguna</h2>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Status Login</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $user->name }}
                        </td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" data-user-id="{{ $user->id }}" class="sr-only peer user-status-toggle" @checked($user->is_active)>
                                <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:bg-gray-600 peer-checked:bg-teal-600"></div>
                            </label>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center">Tidak ada pengguna untuk ditampilkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        document.querySelectorAll('.user-status-toggle').forEach(toggle => {
            toggle.addEventListener('change', async function (event) {
                const userId = this.dataset.userId;
                const newStatus = this.checked;
                const url = `/admin/users/${userId}/toggle-status`;

                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            is_active: newStatus
                        })
                    });

                    if (!response.ok) {
                        throw new Error('Gagal memperbarui status.');
                    }

                    const result = await response.json();
                    // Anda bisa mengganti alert() dengan notifikasi yang lebih baik
                    alert(result.message);

                } catch (error) {
                    console.error('Terjadi kesalahan:', error);
                    alert('Gagal memperbarui status. Silakan coba lagi.');
                    event.target.checked = !newStatus; 
                }
            });
        });
    });
</script>
@endpush