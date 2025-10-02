<!DOCTYPE html>
<html lang="id" class="{{ Auth::user()->theme === 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah No Handphone</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,600,700,800" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 dark:bg-slate-900 font-sans">
    {{-- Container utama untuk tampilan mobile --}}
    <div class="md:max-w-sm mx-auto bg-white dark:bg-gray-800 min-h-screen shadow-lg">
        <main class="p-6">
            {{-- Header halaman --}}
            <header class="flex items-center space-x-4 mb-8">
                <a href="{{ route('app.settings.index') }}" class="text-gray-800 dark:text-gray-200">
                    <i data-feather="arrow-left" class="w-6 h-6"></i>
                </a>
                <h1 class="text-xl font-bold text-gray-800 dark:text-gray-200">Ubah No Handphone</h1>
            </header>

            {{-- Form untuk mengubah nomor handphone --}}
            <form method="POST" action="{{ route('app.settings.phone.update') }}">
                @csrf
                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">No Handphone Baru</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}" 
                        class="shadow appearance-none border dark:border-gray-600 bg-white dark:bg-gray-700 rounded-lg w-full py-3 px-4 text-gray-900 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline @error('phone') border-red-500 @enderror" 
                        placeholder="Contoh: 081234567890" required>
                    
                    @error('phone')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-4 rounded-full focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                    Simpan Perubahan
                </button>
            </form>
        </main>
    </div>
    
    {{-- Script untuk mengaktifkan Feather Icons --}}
    <script>
        feather.replace();
    </script>
</body>
</html>