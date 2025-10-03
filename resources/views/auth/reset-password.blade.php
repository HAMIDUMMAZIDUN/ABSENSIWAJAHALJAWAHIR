<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <h2 class="mb-6 text-center text-3xl font-bold text-black dark:text-black">
            Reset Kata Sandi
        </h2>

        <div>
            <x-input-label for="email" value="Email" class="text-black dark:text-black" />
            <x-text-input id="email" class="block mt-1 w-full text-black dark:text-black"
                        type="email" name="email" :value="old('email', $request->email)"
                        required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Password" class="text-black dark:text-black" />
            <x-text-input id="password" class="block mt-1 w-full text-black dark:text-black"
                        type="password" name="password" required
                        autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Konfirmasi Password" class="text-black dark:text-black" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full text-black dark:text-black"
                        type="password" name="password_confirmation" required
                        autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>