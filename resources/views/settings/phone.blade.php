@extends('layouts.app-mobile')

@section('title', 'Ubah No Handphone')

@section('content')
<main class="p-6 pb-24">
    <header class="flex items-center mb-8">
        <a href="{{ route('profile.edit') }}" class="text-gray-800 dark:text-gray-200">
            <i data-feather="arrow-left" class="w-6 h-6"></i>
        </a>
        <h1 class="text-xl font-bold text-gray-800 dark:text-gray-200 mx-auto">Ubah No Handphone</h1>
    </header>

    <form action="{{ route('settings.phone.update') }}" method="POST">
        @csrf
        <div class="space-y-6">
            <div>
                <label for="phone" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">No Handphone</label>
                <div class="relative">
                    <input id="phone" name="phone" type="tel" value="{{ old('phone', $user->phone) }}" required 
                           class="block w-full px-5 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-full shadow-sm" 
                           placeholder="Contoh: 081234567890">
                </div>
                @error('phone')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-8">
            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-4 rounded-full">
                Simpan Perubahan
            </button>
        </div>
    </form>
</main>
@endsection