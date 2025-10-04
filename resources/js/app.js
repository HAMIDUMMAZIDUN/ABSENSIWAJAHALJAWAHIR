import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

/**
 * ============================================================================
 * LOGIKA BARU UNTUK SIDEBAR RESPONSIVE
 * ============================================================================
 * Kode ini akan berjalan setelah semua elemen HTML selesai dimuat.
 */
document.addEventListener('DOMContentLoaded', () => {
    // Inisialisasi Feather Icons agar semua ikon tampil
    // Pastikan Anda sudah memuat script Feather Icons di layout Anda
    if (typeof feather !== 'undefined') {
        feather.replace();
    }

    // Ambil semua elemen yang dibutuhkan untuk interaksi sidebar
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const openBtn = document.getElementById('open-sidebar-btn');
    const closeBtn = document.getElementById('close-sidebar-btn');

    // Fungsi untuk membuka sidebar
    const openSidebar = () => {
        if (sidebar && overlay) {
            sidebar.classList.remove('-translate-x-full'); // Geser sidebar ke dalam layar
            overlay.classList.remove('hidden'); // Tampilkan overlay gelap
        }
    };

    // Fungsi untuk menutup sidebar
    const closeSidebar = () => {
        if (sidebar && overlay) {
            sidebar.classList.add('-translate-x-full'); // Geser sidebar ke luar layar
            overlay.classList.add('hidden'); // Sembunyikan overlay gelap
        }
    };

    // Tambahkan event listener ke elemen-elemen yang relevan
    if (openBtn) {
        openBtn.addEventListener('click', openSidebar);
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', closeSidebar);
    }
    
    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }
});