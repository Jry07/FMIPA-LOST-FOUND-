/**
 * FMIPA Lost & Found - Modul M4: JavaScript Katalog & Filter Barang
 * File: public/js/modules/katalog.js
 */

document.addEventListener('DOMContentLoaded', function () {
    const filterForm = document.getElementById('katalogFilterForm');

    if (!filterForm) {
        return;
    }

    // Auto-submit saat pilihan dropdown (kategori, jenis laporan, status) berubah
    const autoSubmitSelects = filterForm.querySelectorAll('select.filter-select');
    autoSubmitSelects.forEach(function (selectEl) {
        selectEl.addEventListener('change', function () {
            // Submit form secara otomatis saat nilai filter berubah
            filterForm.submit();
        });
    });

    // Handle tombol reset jika ada
    const resetBtn = filterForm.querySelector('.btn-reset');
    if (resetBtn) {
        resetBtn.addEventListener('click', function (e) {
            // Izinkan navigasi langsung ke route items.index tanpa parameter
        });
    }
});
