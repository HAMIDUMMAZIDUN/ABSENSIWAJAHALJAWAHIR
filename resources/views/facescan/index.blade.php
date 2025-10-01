<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Wajah - Absensi</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,600,700,800" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    {{-- Memuat library face-api.js dari CDN yang andal --}}
    <script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        #face-frame-container {
            width: 280px; height: 280px;
            border-radius: 50%;
            border: 4px dashed rgba(255, 255, 255, 0.5);
            overflow: hidden;
            position: relative;
            background-color: #333;
            transition: border-color 0.3s ease-in-out; /* Animasi perubahan warna border */
        }
        #camera-feed, #overlay-canvas {
            width: 100%; height: 100%;
            object-fit: cover;
            transform: scaleX(-1);
            position: absolute;
            top: 0; left: 0;
        }
        #overlay-canvas {
            z-index: 15; /* Canvas untuk menggambar di atas video */
        }
    </style>
</head>
<body class="bg-gray-900 font-sans">
    <div class="md:max-w-sm mx-auto bg-black min-h-screen flex flex-col">
        <header class="absolute top-0 left-0 w-full p-6 z-20 flex items-center space-x-4">
            {{-- Mengarahkan kembali ke halaman profil setelah scan --}}
            <a href="{{ route('profile.edit') }}" class="text-white">
                <i data-feather="arrow-left" class="w-6 h-6"></i>
            </a>
        </header>

        <div class="relative flex-grow flex items-center justify-center">
            <div id="face-frame-container">
                <video id="camera-feed" autoplay playsinline></video>
                <canvas id="overlay-canvas"></canvas>
            </div>
            
            <div id="error-message" class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-11/12 bg-red-500/80 text-white text-center p-4 rounded-lg hidden z-30">
                <p class="font-bold">Gagal Mengakses Kamera</p>
                <p class="text-sm mt-1">Pastikan Anda memberikan izin dan kamera tidak digunakan aplikasi lain.</p>
            </div>

            <div id="status-message" class="absolute bottom-28 text-center text-white p-4 z-10">
                <p id="status-text" class="font-semibold">Posisikan Wajah Anda di Dalam Bingkai</p>
                <p class="text-sm opacity-80">Pastikan pencahayaan cukup</p>
            </div>

            <div class="absolute bottom-8 z-20">
                <button id="capture-btn" class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg transform transition-transform active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    <i data-feather="camera" class="w-8 h-8 text-gray-800"></i>
                </button>
            </div>
        </div>
        
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', async () => {
        feather.replace();

        const videoElement = document.getElementById('camera-feed');
        const canvasElement = document.getElementById('overlay-canvas');
        const errorMessageElement = document.getElementById('error-message');
        const statusTextElement = document.getElementById('status-text');
        const frameContainer = document.getElementById('face-frame-container');
        const captureBtn = document.getElementById('capture-btn');
        let detectionInterval;

        async function loadModels() {
            statusTextElement.innerText = 'Memuat model...';
            // Pengecekan apakah faceapi sudah ada sebelum digunakan
            if (typeof faceapi === 'undefined') {
                console.error('face-api.js belum termuat. Periksa path file.');
                errorMessageElement.querySelector('p.font-bold').innerText = 'Gagal Memuat Library';
                errorMessageElement.querySelector('p.text-sm').innerText = 'File face-api.js tidak ditemukan.';
                errorMessageElement.classList.remove('hidden');
                return;
            }

            // **PERBAIKAN: Muat model dari CDN yang sama dengan library**
            const MODEL_URL = 'https://cdn.jsdelivr.net/gh/justadudewhohacks/face-api.js@0.22.2/weights';
            await Promise.all([
                faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL),
                faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL),
                faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL),
            ]).catch(err => {
                console.error("Gagal memuat model:", err)
                errorMessageElement.querySelector('p.font-bold').innerText = 'Gagal Memuat Model AI';
                errorMessageElement.querySelector('p.text-sm').innerText = 'Periksa koneksi internet Anda.';
                errorMessageElement.classList.remove('hidden');
            });
        }

        async function startCamera() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' } });
                videoElement.srcObject = stream;
            } catch (error) {
                console.error("Error saat mengakses kamera: ", error);
                errorMessageElement.classList.remove('hidden');
            }
        }

        function startFaceDetection() {
            videoElement.addEventListener('play', () => {
                const displaySize = { width: videoElement.clientWidth, height: videoElement.clientHeight };
                faceapi.matchDimensions(canvasElement, displaySize);
                
                detectionInterval = setInterval(async () => {
                    const detections = await faceapi.detectSingleFace(videoElement, new faceapi.TinyFaceDetectorOptions());
                    canvasElement.getContext('2d').clearRect(0, 0, canvasElement.width, canvasElement.height);

                    if (detections) {
                        statusTextElement.innerText = 'Wajah Terdeteksi!';
                        frameContainer.style.borderColor = '#14b8a6';
                        captureBtn.disabled = false;
                        const resizedDetections = faceapi.resizeResults(detections, displaySize);
                        faceapi.draw.drawDetections(canvasElement, resizedDetections);
                    } else {
                        statusTextElement.innerText = 'Posisikan Wajah Anda di Dalam Bingkai';
                        frameContainer.style.borderColor = 'rgba(255, 255, 255, 0.5)';
                        captureBtn.disabled = true;
                    }
                }, 100);
            });
        }

        captureBtn.addEventListener('click', () => {
            clearInterval(detectionInterval);
            statusTextElement.innerText = 'Menyimpan foto...';
            captureBtn.disabled = true;

            const tempCanvas = document.createElement('canvas');
            tempCanvas.width = videoElement.videoWidth;
            tempCanvas.height = videoElement.videoHeight;
            const context = tempCanvas.getContext('2d');
            
            context.translate(tempCanvas.width, 0);
            context.scale(-1, 1);
            context.drawImage(videoElement, 0, 0, tempCanvas.width, tempCanvas.height);
            
            const imageDataUrl = tempCanvas.toDataURL('image/jpeg');

            const formData = new FormData();
            formData.append('image', imageDataUrl);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            fetch("{{ route('app.scan.capture') }}", {
                method: 'POST',
                body: new URLSearchParams(formData) 
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                } else {
                    return response.json().then(data => {
                        alert('Gagal memperbarui: ' + (data.message || 'Error tidak diketahui'));
                        startFaceDetection();
                    });
                }
            })
            .catch(err => {
                console.error('Error:', err);
                alert('Terjadi kesalahan. Silakan coba lagi.');
                startFaceDetection();
            });
        });

        async function initialize() {
            await loadModels();
            await startCamera();
            startFaceDetection();
        }

        initialize();
    });
    </script>
</body>
</html>

