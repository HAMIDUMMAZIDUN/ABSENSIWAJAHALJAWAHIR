<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Wajah</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,600,700,800" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Membuat video memenuhi container dan terbalik (seperti cermin) */
        #camera-feed {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scaleX(-1);
        }
    </style>
</head>
<body class="bg-gray-900 font-sans">
    <div class="md:max-w-sm mx-auto bg-black min-h-screen flex flex-col">
        
        <header class="absolute top-0 left-0 w-full p-6 z-20 flex items-center space-x-4">
            <a href="{{ route('dashboard') }}" class="text-white">
                <i data-feather="arrow-left" class="w-6 h-6"></i>
            </a>
        </header>

        <div class="relative flex-grow flex items-center justify-center">
            <video id="camera-feed" autoplay playsinline></video>
            
            <div class="absolute inset-0 flex items-center justify-center p-8">
                <div class="w-full max-w-xs aspect-square border-4 border-dashed border-white/50 rounded-full"></div>
            </div>

            <div class="absolute bottom-28 text-center text-white p-4 z-10">
                <p class="font-semibold">Posisikan Wajah Anda di Dalam Bingkai</p>
                <p class="text-sm opacity-80">Pastikan pencahayaan cukup</p>
            </div>
        </div>

        @include('layouts.partials.bottom-nav', ['active' => 'scan'])
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            feather.replace();

            const videoElement = document.getElementById('camera-feed');

            // Cek dukungan browser
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                // Minta izin akses kamera
                navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' } })
                    .then(function(stream) {
                        videoElement.srcObject = stream;
                    })
                    .catch(function(error) {
                        console.error("Error saat mengakses kamera: ", error);
                        alert("Tidak bisa mengakses kamera. Pastikan Anda memberikan izin.");
                    });
            } else {
                alert("Browser Anda tidak mendukung akses kamera.");
            }
        });
    </script>
</body>
</html>