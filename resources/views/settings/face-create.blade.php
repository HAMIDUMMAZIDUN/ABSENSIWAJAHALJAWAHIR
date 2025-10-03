<x-app-layout>
    <main class="p-6 pb-24 bg-slate-50 dark:bg-slate-900 min-h-screen">
        <header class="flex items-center space-x-4 mb-8">
            <a href="{{ route('app.settings.index') }}" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                <i data-feather="arrow-left" class="w-6 h-6 text-gray-800 dark:text-gray-200"></i>
            </a>
            <h1 class="text-xl font-bold text-gray-800 dark:text-gray-200">Daftarkan Wajah Anda</h1>
        </header>

        <div class="max-w-md mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <div id="error-message" class="hidden bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-4" role="alert">
                <p class="font-bold">Error Kamera</p>
                <p id="error-text"></p>
            </div>
            
            <p class="text-center text-gray-600 dark:text-gray-300 mb-4">
                Posisikan wajah Anda di tengah kamera dan pastikan pencahayaan cukup.
            </p>

            <div class="relative w-full aspect-square bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden mb-4 shadow-inner flex items-center justify-center">
                <video id="video" class="w-full h-full object-cover hidden" autoplay playsinline></video>
                <canvas id="canvas" class="hidden w-full h-full object-cover"></canvas>
                <div id="video-placeholder" class="text-gray-500 dark:text-gray-400 flex flex-col items-center space-y-2">
                    <i data-feather="camera" class="w-16 h-16"></i>
                    <span id="placeholder-text" class="text-sm font-medium">Mengaktifkan kamera...</span>
                </div>
            </div>

            <button id="capture-btn" class="w-full flex items-center justify-center space-x-3 bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-4 rounded-full focus:outline-none focus:shadow-outline transition-colors duration-150 ease-in-out shadow-lg mb-4">
                <i data-feather="camera" class="w-5 h-5"></i>
                <span>Ambil Gambar</span>
            </button>
            
            <form id="face-form" method="POST" action="{{ route('app.settings.face.store') }}">
                @csrf
                <input type="hidden" name="image" id="image-data">
                <button type="submit" id="submit-btn" disabled class="w-full flex items-center justify-center space-x-3 bg-gray-400 cursor-not-allowed text-white font-bold py-3 px-4 rounded-full focus:outline-none focus:shadow-outline transition-colors duration-150 ease-in-out shadow-lg">
                    <i data-feather="send" class="w-5 h-5"></i>
                    <span>Simpan Wajah</span>
                </button>
            </form>
        </div>
    </main>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace();

        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const captureBtn = document.getElementById('capture-btn');
        const submitBtn = document.getElementById('submit-btn');
        const imageDataInput = document.getElementById('image-data');
        const context = canvas.getContext('2d');
        const errorMessageDiv = document.getElementById('error-message');
        const errorTextP = document.getElementById('error-text');
        const videoPlaceholder = document.getElementById('video-placeholder');
        const placeholderText = document.getElementById('placeholder-text');

        let isCaptured = false;

        function showError(message) {
            errorTextP.textContent = message;
            errorMessageDiv.classList.remove('hidden');
            videoPlaceholder.classList.remove('hidden');
            placeholderText.textContent = 'Gagal memuat kamera.';
            videoPlaceholder.querySelector('i').setAttribute('data-feather', 'video-off');
            feather.replace();
        }

        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => {
                    video.srcObject = stream;
                    video.onloadedmetadata = () => {
                        videoPlaceholder.classList.add('hidden');
                        video.classList.remove('hidden');
                    };
                })
                .catch(err => {
                    console.error("Error accessing camera: ", err);
                    if (err.name === 'NotAllowedError') {
                        showError('Akses kamera diblokir. Harap izinkan akses kamera di pengaturan browser Anda.');
                    } else if (err.name === 'NotFoundError') {
                         showError('Tidak ada kamera yang ditemukan di perangkat ini.');
                    } else {
                        showError('Gagal mengakses kamera. Pastikan tidak ada aplikasi lain yang sedang menggunakannya.');
                    }
                });
        } else {
            showError('Browser Anda tidak mendukung akses kamera.');
        }

        captureBtn.addEventListener('click', () => {
            if (!isCaptured) {
                if (video.srcObject && video.srcObject.active) {
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    context.drawImage(video, 0, 0, canvas.width, canvas.height);
                    imageDataInput.value = canvas.toDataURL('image/png');
                    
                    video.classList.add('hidden');
                    canvas.classList.remove('hidden');

                    submitBtn.disabled = false;
                    submitBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
                    submitBtn.classList.add('bg-blue-600', 'hover:bg-blue-700');
                    
                    captureBtn.innerHTML = `<i data-feather="refresh-cw" class="w-5 h-5"></i> <span>Ambil Ulang</span>`;
                    feather.replace();
                    
                    isCaptured = true;
                } else {
                    showError('Kamera tidak aktif. Tidak bisa mengambil gambar.');
                }
            } else {
                video.classList.remove('hidden');
                canvas.classList.add('hidden');

                submitBtn.disabled = true;
                submitBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
                submitBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                
                captureBtn.innerHTML = `<i data-feather="camera" class="w-5 h-5"></i> <span>Ambil Gambar</span>`;
                feather.replace();
                
                imageDataInput.value = '';
                isCaptured = false;
            }
        });
    </script>
    @endpush
</x-app-layout>

