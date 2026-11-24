/**
 * Modul M3: JavaScript Laporan & Dashboard Pengguna
 * - Preview foto sebelum upload dan validasi ukuran (maks 2MB)
 * - Label lokasi dinamis (Hilang: Lokasi Kehilangan, Temuan: Lokasi Penemuan)
 * - Konfirmasi sebelum membatalkan laporan
 */

document.addEventListener('DOMContentLoaded', function () {
    // -------------------------------------------------------------
    // 1. Dinamika Pilihan Jenis Laporan (Lost / Found) & Label Lokasi
    // -------------------------------------------------------------
    const radioTypes = document.querySelectorAll('input[name="type"]');
    const labelLokasi = document.getElementById('label-lokasi');
    const inputLokasi = document.getElementById('location');
    const typeOptionCards = document.querySelectorAll('.report-type-option');

    function updateTypeUI(typeValue) {
        // Update visual card active state
        typeOptionCards.forEach(card => {
            const radio = card.querySelector('input[type="radio"]');
            if (radio && radio.checked) {
                card.classList.add('active');
            } else {
                card.classList.remove('active');
            }
        });

        // Update dynamic location label & placeholder
        if (labelLokasi && inputLokasi) {
            if (typeValue === 'lost') {
                labelLokasi.innerHTML = 'Lokasi Kehilangan <span class="text-danger">*</span>';
                inputLokasi.placeholder = 'Contoh: Taman FMIPA / Area Parkir / Gedung Kuliah B';
            } else {
                labelLokasi.innerHTML = 'Lokasi Penemuan <span class="text-danger">*</span>';
                inputLokasi.placeholder = 'Contoh: Gazebo FMIPA - Samping Gedung A / Meja Lab';
            }
        }
    }

    if (radioTypes.length > 0) {
        radioTypes.forEach(radio => {
            radio.addEventListener('change', function () {
                updateTypeUI(this.value);
            });
        });

        // Inisialisasi saat pertama kali halaman dimuat
        const checkedRadio = document.querySelector('input[name="type"]:checked');
        if (checkedRadio) {
            updateTypeUI(checkedRadio.value);
        }
    }

    // -------------------------------------------------------------
    // 2. Unggah & Preview Foto Barang
    // -------------------------------------------------------------
    const photoInput = document.getElementById('photo-input');
    const dropzone = document.getElementById('photo-dropzone');
    const previewBar = document.getElementById('photo-preview-bar');
    const previewImg = document.getElementById('photo-preview-img');
    const previewName = document.getElementById('photo-preview-name');
    const previewSize = document.getElementById('photo-preview-size');
    const btnRemovePhoto = document.getElementById('btn-remove-photo');

    function handleFile(file) {
        if (!file) return;

        // Validasi tipe file
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            alert('Format file tidak didukung. Harap pilih gambar dengan format JPG, JPEG, PNG, atau WEBP.');
            if (photoInput) photoInput.value = '';
            return;
        }

        // Validasi ukuran maks 2 MB (2 * 1024 * 1024 bytes)
        const maxSize = 2 * 1024 * 1024;
        if (file.size > maxSize) {
            alert('Ukuran file foto melebihi batas maksimal 2 MB.');
            if (photoInput) photoInput.value = '';
            return;
        }

        // Tampilkan preview
        const reader = new FileReader();
        reader.onload = function (e) {
            if (previewImg) previewImg.src = e.target.result;
            if (previewName) previewName.textContent = file.name;
            if (previewSize) {
                const sizeKb = (file.size / 1024).toFixed(1);
                const sizeMb = (file.size / (1024 * 1024)).toFixed(2);
                previewSize.textContent = file.size > 1024 * 1024
                    ? `${sizeMb} MB · Berhasil diunggah`
                    : `${sizeKb} KB · Berhasil diunggah`;
            }
            if (previewBar) previewBar.style.display = 'flex';
        };
        reader.readAsDataURL(file);
    }

    if (photoInput) {
        photoInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                handleFile(this.files[0]);
            }
        });
    }

    if (dropzone && photoInput) {
        dropzone.addEventListener('click', function () {
            photoInput.click();
        });

        dropzone.addEventListener('dragover', function (e) {
            e.preventDefault();
            this.style.borderColor = 'var(--maroon, #6B1D2F)';
            this.style.backgroundColor = '#FFF5F7';
        });

        dropzone.addEventListener('dragleave', function (e) {
            e.preventDefault();
            this.style.borderColor = '#D1D5DB';
            this.style.backgroundColor = '#FBFBFB';
        });

        dropzone.addEventListener('drop', function (e) {
            e.preventDefault();
            this.style.borderColor = '#D1D5DB';
            this.style.backgroundColor = '#FBFBFB';

            if (e.dataTransfer.files && e.dataTransfer.files[0]) {
                photoInput.files = e.dataTransfer.files;
                handleFile(e.dataTransfer.files[0]);
            }
        });
    }

    if (btnRemovePhoto && photoInput) {
        btnRemovePhoto.addEventListener('click', function () {
            photoInput.value = '';
            if (previewImg) previewImg.src = '';
            if (previewBar) previewBar.style.display = 'none';
        });
    }

    // -------------------------------------------------------------
    // 3. Konfirmasi Pembatalan Laporan
    // -------------------------------------------------------------
    const cancelForms = document.querySelectorAll('.form-cancel-report');
    cancelForms.forEach(form => {
        form.addEventListener('submit', function (e) {
            const confirmed = confirm('Apakah Anda yakin ingin membatalkan laporan ini? Tindakan ini tidak dapat diurungkan.');
            if (!confirmed) {
                e.preventDefault();
            }
        });
    });
});
