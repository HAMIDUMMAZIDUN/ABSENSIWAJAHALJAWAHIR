<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Username</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,600,700,800" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">
    <div class="md:max-w-sm mx-auto bg-white min-h-screen shadow-lg">
        <main class="p-6">
            <header class="flex items-center space-x-4 mb-8">
                <a href="{{ route('settings.index') }}" class="text-gray-800">
                    <i data-feather="arrow-left" class="w-6 h-6"></i>
                </a>
                <h1 class="text-xl font-bold text-gray-800">Ganti Username</h1>
            </header>

            <form method="POST" action="{{ route('settings.username.update') }}">
                @csrf
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username Baru</label>
                    <input type="text" id="username" name="username" value="{{ old('username', auth()->user()->name) }}" class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('username') border-red-500 @enderror" required>
                    @error('username')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-4 rounded-full focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                    Simpan Perubahan
                </button>
            </form>
        </main>
    </div>
    <script>
        feather.replace();
    </script>
</body>
</html>