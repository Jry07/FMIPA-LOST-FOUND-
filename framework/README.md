# FMIPA Lost & Found

Website sistem pelaporan dan pencarian barang hilang/ditemukan di lingkungan FMIPA Universitas Halu Oleo.

**Stack:** Laravel 11 · PHP 8.2+ · MySQL · Blade · HTML/CSS/JS (tanpa Tailwind/Livewire/Vue)  
**Branch aktif:** `chore/fase-0-foundation`

---

## Setup Lokal

```bash
# 1. Clone dan masuk ke direktori framework
git clone <repo-url>
cd FMIPA-LOST-FOUND-/framework

# 2. Install dependensi PHP
composer install

# 3. Salin konfigurasi environment
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Buat database MySQL
# Buka MySQL client dan jalankan:
#   CREATE DATABASE lostfound CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# 6. Jalankan migrasi dan seeder
php artisan migrate:fresh --seed

# 7. Buat symlink storage
php artisan storage:link

# 8. Jalankan server lokal
php artisan serve
```

Akses aplikasi di: **http://localhost:8000**

---

## Ekstensi PHP yang Diperlukan

Pastikan ekstensi berikut aktif di `php.ini`:

```
extension=fileinfo
extension=gd
extension=mysqli
extension=pdo_mysql
extension=pdo_sqlite
extension=zip
```

---

## Akun Seed (Hanya untuk Lokal)

| Role     | Email                    | Kata Sandi |
|----------|--------------------------|------------|
| Admin    | admin@fmipa.test         | password   |
| Petugas  | petugas@fmipa.test       | password   |
| Pengguna | pengguna1@fmipa.test     | password   |
| Pengguna | pengguna2@fmipa.test     | password   |
| Pengguna | pengguna3@fmipa.test     | password   |

### Login Cepat (Hanya di Environment `local`)

```
http://localhost:8000/dev/login/admin
http://localhost:8000/dev/login/petugas
http://localhost:8000/dev/login/pengguna
```

---

## Struktur Modul

| Kode  | Modul             | PIC (Anggota)  | Branch              |
|-------|-------------------|----------------|---------------------|
| M1    | Admin Panel       | —              | `feat/m1-admin`     |
| M2    | Autentikasi       | —              | `feat/m2-auth`      |
| M3    | Laporan Barang    | —              | `feat/m3-laporan`   |
| M4    | Katalog Barang    | —              | `feat/m4-katalog`   |
| M5    | Klaim             | —              | `feat/m5-klaim`     |
| M6    | Verifikasi        | —              | `feat/m6-verifikasi`|

Lihat [`docs/KONTRAK.md`](docs/KONTRAK.md) untuk kontrak lengkap (skema DB, nama route, nama komponen).

---

## Aturan Blok Marker

Setiap file yang dikerjakan anggota **wajib** dibungkus marker blok sesuai modul:

**PHP/Controller:**
```php
// [M1-ADMIN]
// kode modul di sini
// [/M1-ADMIN]
```

**Blade:**
```blade
{{-- [M3-LAPORAN] --}}
{{-- konten modul --}}
{{-- [/M3-LAPORAN] --}}
```

Gunakan kode modul masing-masing: `M1-ADMIN`, `M2-AUTH`, `M3-LAPORAN`, `M4-KATALOG`, `M5-KLAIM`, `M6-VERIFIKASI`.

---

## Service yang Wajib Digunakan

| Service                | Fungsi                          | Metode Utama                      |
|------------------------|---------------------------------|-----------------------------------|
| `StatusHistoryService` | Mencatat perubahan status item  | `ubah($item, $status, $catatan)`  |
| `NotifikasiService`    | Kirim notifikasi database       | `kirim($user, $judul, $pesan, $url, $jenis)` |
| `FileUploadService`    | Upload & resize foto (GD)       | `simpanPublik($file, $folder)`, `simpanPrivat($file, $folder)` |

> **Penting:** JANGAN mengubah status item secara langsung (`$item->status = ...`). Selalu gunakan `StatusHistoryService::ubah()`.

---

## Route Penting (Fase 0)

```
GET  /                          → pages.beranda (beranda tamu/login)
GET  /cara-kerja                → pages.cara-kerja
GET  /terima-kasih              → pages.terima-kasih
GET  /katalog                   → catalog.index
GET  /barang/{item}             → catalog.show
GET  /dev/login/{role}          → (hanya local)
```

Daftar lengkap: `php artisan route:list`

---

## Aset yang Perlu Ditambahkan Manual

- `public/images/logo.png` — Logo resmi FMIPA UHO (placeholder SVG sudah ada)
- `public/images/gedung.jpg` — Foto gedung untuk halaman beranda

---

## Lisensi

Proyek akademik — Kelompok 2, Mata Kuliah Rekayasa Perangkat Lunak, FMIPA UHO 2026.
