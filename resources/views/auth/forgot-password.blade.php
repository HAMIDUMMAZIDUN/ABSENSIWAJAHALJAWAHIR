<x-guest-layout>
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-4">
        Lupa Kata Sandi
    </h1>

    <p class="text-center text-sm text-gray-600 mb-6">
        Tidak masalah. Beri tahu kami alamat email Anda dan kami akan mengirimkan link untuk mengatur ulang kata sandi.
    </p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <label for="email" class="block font-medium text-sm text-gray-700 mb-1">Alamat Email</label>
            <x-text-input id="email" class="block mt-1 w-full px-5 py-3 border-gray-300 rounded-full shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50 bg-white dark:bg-white text-black dark:text-black"
                                type="email"
                                name="email"
                                :value="old('email')"
                                placeholder="Ketik Alamat Email Anda"
                                required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-4 rounded-full focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                Kirim Link Reset Kata Sandi
            </button>
        </div>
    </form>
</x-guest-layout>