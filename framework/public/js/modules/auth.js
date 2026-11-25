/**
 * Module JS: auth.js
 * Fitur: Tampilkan/Sembunyikan Kata Sandi (Toggle Password Visibility)
 * Modul M2: Autentikasi, Profil, Beranda, dan Cara Kerja
 */

document.addEventListener('DOMContentLoaded', function () {
    const eyeIconSvg = `
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon-eye">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
            <circle cx="12" cy="12" r="3"></circle>
        </svg>
    `;

    const eyeSlashIconSvg = `
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon-eye-slash">
            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
            <line x1="1" y1="1" x2="23" y2="23"></line>
        </svg>
    `;

    const toggleButtons = document.querySelectorAll('[data-toggle="password"], .btn-toggle-password, .m2-btn-toggle-pw');

    toggleButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            // Cari target input berdasarkan attribute data-target atau sibling input
            let input = null;
            const targetId = button.getAttribute('data-target');

            if (targetId) {
                input = document.getElementById(targetId);
            } else {
                const parentGroup = button.closest('.input-password-wrapper') || button.closest('.m2-input-wrapper') || button.closest('.form-group') || button.closest('.m2-form-group');
                if (parentGroup) {
                    input = parentGroup.querySelector('input');
                }
            }

            if (!input) return;

            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            button.innerHTML = isPassword ? eyeSlashIconSvg : eyeIconSvg;
            button.setAttribute('aria-label', isPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
            button.setAttribute('title', isPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
        });
    });
});
