/**
 * FMIPA Lost & Found - Application JavaScript Helpers
 * Kelompok 2 (RPL)
 */

document.addEventListener('DOMContentLoaded', function () {
    // 1. Auto dismiss flash alert setelah 6 detik
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function (alert) {
        setTimeout(function () {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(function () {
                alert.remove();
            }, 500);
        }, 6000);
    });

    // 2. Helper konfirmasi penghapusan / pembatalan data
    const confirmButtons = document.querySelectorAll('[data-confirm]');
    confirmButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            const message = this.getAttribute('data-confirm') || 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });

    // 3. Helper preview unggahan gambar
    const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
    imageInputs.forEach(function (input) {
        input.addEventListener('change', function () {
            const file = this.files[0];
            if (file && file.size > 2 * 1024 * 1024) {
                alert('Ukuran berkas melebihi batas maksimal 2 MB!');
                this.value = '';
            }
        });
    });
});
