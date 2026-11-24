/**
 * Modul M5: Pengajuan Klaim, Pelaporan Penemuan, dan Klaim Saya
 * Pratinjau Bukti (Image Previewer) & Validasi Sisi Klien (NFR-02, NFR-06)
 */

document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('evidence');
    const dropzone = document.getElementById('uploadDropzone');
    const previewContainer = document.getElementById('previewContainer');
    const previewImage = document.getElementById('previewImage');
    const removeBtn = document.getElementById('removePreviewBtn');
    const fileErrorMsg = document.getElementById('fileErrorMsg');

    if (!fileInput || !dropzone || !previewContainer || !previewImage) {
        return;
    }

    const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2 MB
    const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];

    function validateAndPreview(file) {
        if (!file) return;

        // Reset error
        if (fileErrorMsg) {
            fileErrorMsg.textContent = '';
            fileErrorMsg.style.display = 'none';
        }

        // Cek tipe file
        if (!ALLOWED_TYPES.includes(file.type.toLowerCase())) {
            showError('Format file tidak didukung. Harap unggah foto dengan format JPG, JPEG, PNG, atau WEBP.');
            clearFileInput();
            return;
        }

        // Cek ukuran file
        if (file.size > MAX_FILE_SIZE) {
            showError('Ukuran file terlalu besar (' + (file.size / (1024 * 1024)).toFixed(2) + ' MB). Batas maksimum adalah 2 MB.');
            clearFileInput();
            return;
        }

        // Render pratinjau gambar
        const reader = new FileReader();
        reader.onload = function (e) {
            previewImage.src = e.target.result;
            previewContainer.style.display = 'block';
            dropzone.style.display = 'none';
        };
        reader.readAsDataURL(file);
    }

    function showError(msg) {
        if (fileErrorMsg) {
            fileErrorMsg.textContent = msg;
            fileErrorMsg.style.display = 'block';
        } else {
            alert(msg);
        }
    }

    function clearFileInput() {
        fileInput.value = '';
        previewImage.src = '';
        previewContainer.style.display = 'none';
        dropzone.style.display = 'block';
    }

    // Event listener: file change
    fileInput.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            validateAndPreview(this.files[0]);
        }
    });

    // Event listener: remove button
    if (removeBtn) {
        removeBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            clearFileInput();
        });
    }

    // Drag and Drop
    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, function (e) {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.add('dragover');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, function (e) {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.remove('dragover');
        }, false);
    });

    dropzone.addEventListener('drop', function (e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        if (files && files.length > 0) {
            fileInput.files = files;
            validateAndPreview(files[0]);
        }
    });
});
