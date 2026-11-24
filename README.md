# 🎒 FMIPA Lost & Found

**Sistem Informasi Barang Hilang dan Ditemukan di Lingkungan Kampus**

Website pusat laporan barang hilang (*Lost*) dan barang ditemukan (*Found*) bagi civitas akademika Fakultas Matematika dan Ilmu Pengetahuan Alam (FMIPA), Universitas Halu Oleo.

![Laravel](https://img.shields.io/badge/Laravel-PHP-FF2D20?logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?logo=mysql&logoColor=white)
![Status](https://img.shields.io/badge/status-prototipe-orange)
![Versi SRS](https://img.shields.io/badge/SRS-v1.0-blue)

---

## 📖 Latar Belakang

Informasi barang hilang dan ditemukan di kampus selama ini tersebar di grup percakapan, media sosial, atau komunikasi langsung. Akibatnya informasi tidak terpusat, sulit ditelusuri kembali, dan mudah tertumpuk oleh pesan lain.

**FMIPA Lost & Found** hadir sebagai platform terpusat yang memungkinkan pengguna membuat laporan, mencari barang, mengajukan klaim atau melaporkan penemuan, serta memantau statusnya. Admin dan petugas melakukan verifikasi dan mencatat serah terima barang.

## ✨ Fitur Utama

- **Akun pengguna**: registrasi, login/logout, dan pengelolaan profil.
- **Laporan Lost/Found**: format data seragam (nama barang, kategori, deskripsi, foto, lokasi, tanggal kejadian).
- **Pencarian & filter**: berdasarkan kata kunci, kategori, lokasi, tanggal, dan status (9 laporan per halaman).
- **Moderasi laporan**: admin menyetujui atau menolak laporan sebelum dipublikasikan.
- **Klaim kepemilikan**: pengguna mengajukan klaim pada laporan *Found* disertai bukti.
- **Pelaporan penemuan**: pengguna dapat menekan **"Saya Menemukan Barang Ini"** pada laporan *Lost* milik orang lain.
- **Verifikasi klaim/penemuan** oleh admin atau petugas.
- **Serah terima**: petugas mencocokkan identitas dan bukti, lalu mencatat serah terima.
- **Riwayat status**: setiap perubahan status penting tercatat.
- **Administrasi**: pengelolaan kategori barang dan akun (role pengguna).

## 👥 Aktor dan Hak Akses (RBAC)

| Aktor | Peran |
|-------|-------|
| **Pengguna** | Registrasi/login, kelola profil, buat laporan Lost/Found, cari barang, ajukan klaim, laporkan penemuan, pantau status laporan dan klaim miliknya |
| **Admin** | Verifikasi/tolak laporan, verifikasi klaim/penemuan, kelola kategori dan akun, pantau statistik |
| **Petugas** | Periksa barang fisik, bantu verifikasi klaim/penemuan, catat serah terima |

## 🔄 Alur Singkat Sistem

```
Pengguna buat laporan (Lost/Found)
        │
        ▼
Admin verifikasi laporan ──► Ditolak
        │
        ▼
   Dipublikasikan
        │
        ├── Laporan Found ──► Pengguna ajukan klaim
        └── Laporan Lost  ──► Penemu tekan "Saya Menemukan Barang Ini"
                                      │
                                      ▼
                    Admin/Petugas verifikasi (Diterima / Ditolak)
                                      │
                                      ▼
              Petugas cocokkan identitas & catat serah terima
                                      │
                                      ▼
                                  Selesai
```

### Status Laporan

| Status | Keterangan |
|--------|-----------|
| Menunggu Verifikasi | Laporan baru, belum diperiksa admin |
| Dipublikasikan | Lolos pemeriksaan, dapat dilihat dan dicari |
| Ditolak | Dinilai tidak valid oleh admin |
| Dibatalkan | Dibatalkan oleh pelapor |
| Selesai | Barang sudah diserahterimakan ke pemilik yang sah |

### Status Klaim/Penemuan

`Diajukan` → `Diterima` / `Ditolak`

## 🛠️ Teknologi

| Aspek | Teknologi |
|-------|-----------|
| Back end | Laravel (PHP) |
| Front end | Blade, HTML, CSS, JavaScript |
| Basis data | MySQL |
| Arsitektur | MVC (klien–server) |
| Akses data | HTTP GET dan POST |
| Keamanan akses | RBAC |

## 🚀 Instalasi dan Menjalankan Proyek

> **Prasyarat:** PHP, Composer, MySQL, dan Node.js/npm (jika aset front end memerlukan build). Sesuaikan versi dengan `composer.json` pada repo ini.

```bash
# 1. Clone repositori
git clone https://github.com/<username>/<nama-repo>.git
cd <nama-repo>

# 2. Install dependensi PHP
composer install

# 3. Salin file environment dan generate app key
cp .env.example .env
php artisan key:generate

# 4. Atur koneksi database pada file .env
#    DB_DATABASE=nama_database
#    DB_USERNAME=root
#    DB_PASSWORD=

# 5. Jalankan migrasi (tambahkan --seed jika seeder tersedia)
php artisan migrate

# 6. Hubungkan folder penyimpanan untuk unggahan foto
php artisan storage:link

# 7. Jalankan server pengembangan
php artisan serve
```

Aplikasi dapat diakses di `http://localhost:8000`.

## 📋 Kebutuhan Fungsional

| Kode | Kebutuhan | Aktor | Prioritas |
|------|-----------|-------|-----------|
| FR-01 | Registrasi akun | Pengguna | Tinggi |
| FR-02 | Login dan logout | Semua aktor | Tinggi |
| FR-03 | Mengelola profil | Pengguna | Sedang |
| FR-04 | Membuat laporan Lost/Found | Pengguna | Tinggi |
| FR-05 | Melihat, mencari, dan memfilter barang | Semua aktor | Tinggi |
| FR-06 | Mengelola laporan milik sendiri | Pengguna | Sedang |
| FR-07 | Memverifikasi laporan | Admin | Tinggi |
| FR-08 | Mengajukan klaim | Pengguna | Tinggi |
| FR-09 | Melaporkan penemuan barang (Lost) | Pengguna | Tinggi |
| FR-10 | Memverifikasi klaim dan penemuan | Admin, Petugas | Tinggi |
| FR-11 | Mencatat serah terima | Petugas | Tinggi |
| FR-12 | Mengelola kategori barang | Admin | Sedang |
| FR-13 | Mengelola akun pengguna | Admin | Sedang |

## 🔒 Kebutuhan Non-Fungsional

| Aspek | Ringkasan |
|-------|-----------|
| Performa | Daftar dan pencarian tampil dalam waktu wajar; foto dioptimalkan, maksimal 2 MB per foto |
| Keamanan | Kata sandi di-hash (bcrypt), akses berbasis peran, data kontak dan bukti klaim hanya untuk pihak berwenang |
| Usability | Formulir dengan label jelas dan pesan kesalahan informatif; navigasi konsisten; antarmuka Bahasa Indonesia |
| Keandalan | Validasi input dan konsistensi status (laporan *Selesai* tidak dapat diklaim lagi); riwayat perubahan status |
| Kompatibilitas | Responsif, berjalan di peramban modern pada desktop dan ponsel |

## 🚫 Di Luar Lingkup

- Layanan pengiriman barang, pembayaran, dan pelacakan perangkat.
- Penyimpanan barang fisik (disimpan oleh penemu atau di lokasi resmi kampus, misalnya pos satpam).
- Penentuan pemilik secara otomatis (dilakukan lewat verifikasi manusia).
- Pengenalan gambar berbasis AI.

## 📄 Dokumentasi

Spesifikasi lengkap (kebutuhan fungsional, non-fungsional, Use Case, Class Diagram, dan Activity Diagram) tersedia pada dokumen SRS:

📎 [`SRS_FMIPA_Lost_and_Found_Kelompok_2_v1_0.pdf`](./docs/SRS_FMIPA_Lost_and_Found_Kelompok_2_v1_0.pdf)

> Sesuaikan path tautan di atas dengan lokasi file SRS pada repo Anda.

## 👨‍💻 Tim Pengembang (Kelompok 2)

| Nama | NIM |
|------|-----|
| Muhammad Fajri Jumadil | F1G125041 |
| Ferdy Krisnandar | F1G125032 |
| Rahmah Hidayah Lahompu | F1G125047 |
| Sahrun Karimu | F1G125051 |
| Elsya Sagitha Damayanti S. | F1G125029 |
| Muhammad Aimar Razak | F1G125013 |

**Program Studi Ilmu Komputer**
Fakultas Matematika dan Ilmu Pengetahuan Alam
Universitas Halu Oleo, 2026

## 📝 Lisensi

Proyek ini dibuat untuk keperluan akademik (Tugas Praktik Rekayasa Perangkat Lunak). Tentukan lisensi sesuai kebutuhan, misalnya MIT, dengan menambahkan file `LICENSE`.
