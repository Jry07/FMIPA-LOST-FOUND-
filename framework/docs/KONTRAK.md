# 📜 DOKUMEN KONTRAK ARSITEKTUR & PONDASI (FASE 0)
## FMIPA Lost & Found — Sistem Informasi Barang Hilang dan Ditemukan
**Fakultas Matematika dan Ilmu Pengetahuan Alam, Universitas Halu Oleo**
**Branch Pondasi:** `chore/fase-0-foundation`  
**Scrum Master:** Muhammad Fajri Jumadil (F1G125041) — Kelompok 2

---

## 1. Aturan Kolaborasi & Format Marker Komentar

Untuk mencegah *conflict merge* dan *naming collision*, pengembangan sistem dibagi ke dalam 6 modul kerja paralel:
- **[M1-ADMIN]**: Master data kategori, manajemen peran akun, dan monitoring statistik sistem.
- **[M2-AUTH]**: Autentikasi (register NIM unik, login, logout) dan pengelolaan profil pengguna.
- **[M3-LAPORAN]**: Pelaporan barang Lost/Found, edit laporan menunggu, dan pembatalan laporan.
- **[M4-KATALOG]**: Halaman publik (beranda tamu/login, cara kerja), pencarian & filter (9 item/page), detail barang.
- **[M5-KLAIM]**: Pengajuan klaim pada barang Found, pelaporan penemuan pada barang Lost ("Saya Menemukan Barang Ini"), daftar Klaim Saya.
- **[M6-VERIFIKASI]**: Verifikasi laporan barang (Admin), verifikasi klaim/penemuan (Admin/Petugas), dan pencatatan serah terima (Petugas).

### Format Marker Komentar
Setiap anggota modul **WAJIB** menempatkan kodenya di dalam blok penanda yang telah dialokasikan:
- **File Blade**:
  ```blade
  {{-- [M1-ADMIN] --}}
  ... kode modul M1 di sini ...
  {{-- [/M1-ADMIN] --}}
  ```
- **File PHP / Routes**:
  ```php
  // [M1-ADMIN]
  ... kode modul M1 di sini ...
  // [/M1-ADMIN]
  ```

> [!IMPORTANT]
> **Aturan Ketat:**
> 1. Dilarang mengubah nama rute (`route name`), nama kolom database, nama konstanta model, atau *signature* service yang telah dibuat di Fase 0.
> 2. Seluruh manipulasi status barang **HARUS** melalui `App\Services\StatusHistoryService`.
> 3. Notifikasi sistem **HARUS** dikirim menggunakan `App\Services\NotifikasiService`.
> 4. File bukti klaim privat **HARUS** disimpan via `FileUploadService::simpanPrivat()` dan diakses via rute `claims.evidence`.

---

## 2. Skema Basis Data (Database Schema)

Database: `lostfound` (MySQL)

### 2.1 Tabel `users`
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id` | bigint unsigned pk | Auto increment |
| `name` | varchar(255) | Nama lengkap pengguna |
| `email` | varchar(255) unique | Email pengguna / institusi |
| `nim` | varchar(30) unique nullable | Nomor Induk Mahasiswa (null untuk admin/petugas) |
| `role` | varchar(20) default 'pengguna' | Nilai: `pengguna`, `admin`, `petugas` |
| `email_verified_at` | timestamp nullable | |
| `password` | varchar(255) | Hash bcrypt |
| `remember_token` | varchar(100) nullable | |
| `created_at`, `updated_at` | timestamp nullable | |

### 2.2 Tabel `categories`
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id` | bigint unsigned pk | Auto increment |
| `name` | varchar(100) unique | Nama kategori (Elektronik, Tas dan Dompet, dll) |
| `description` | text nullable | Deskripsi kategori |
| `created_at`, `updated_at` | timestamp nullable | |

### 2.3 Tabel `items`
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id` | bigint unsigned pk | Auto increment |
| `user_id` | bigint unsigned fk | Relasi ke `users.id` (cascade on delete) |
| `category_id` | bigint unsigned fk | Relasi ke `categories.id` (restrict on delete) |
| `name` | varchar(255) | Nama barang |
| `type` | enum('lost', 'found') | Tipe laporan |
| `description` | text | Ciri-ciri spesifik & kondisi barang |
| `photo` | varchar(255) nullable | Path file foto (di disk public) |
| `location` | varchar(255) | Lokasi hilang / ditemukan di lingkungan FMIPA |
| `incident_date` | date | Tanggal kejadian |
| `incident_time` | time nullable | Perkiraan jam kejadian |
| `status` | enum default 'menunggu' | Nilai: `menunggu`, `dipublikasikan`, `ditolak`, `dibatalkan`, `selesai` |
| `created_at`, `updated_at` | timestamp nullable | |
*Index:* `type`, `status`, `category_id`, `incident_date`

### 2.4 Tabel `claims`
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id` | bigint unsigned pk | Auto increment |
| `item_id` | bigint unsigned fk | Relasi ke `items.id` (cascade on delete) |
| `user_id` | bigint unsigned fk | Relasi ke `users.id` (pengaju klaim atau penemu) |
| `type` | enum('klaim', 'penemuan') | `klaim` (pada found) atau `penemuan` (pada lost) |
| `description` | text | Deskripsi kepemilikan atau detail barang ditemukan |
| `proof` | varchar(255) nullable | Path file bukti (di disk private local) |
| `found_location` | varchar(255) nullable | Lokasi ditemukan (khusus penemuan) |
| `found_time` | datetime nullable | Waktu ditemukan (khusus penemuan) |
| `storage_location` | varchar(255) nullable | Lokasi penitipan fisik saat ini (khusus penemuan) |
| `status` | enum default 'diajukan' | Nilai: `diajukan`, `diterima`, `ditolak` |
| `verifier_id` | bigint unsigned fk nullable | Relasi ke `users.id` (admin/petugas verifikator) |
| `verified_at` | timestamp nullable | Waktu verifikasi dilakukan |
| `rejection_reason` | text nullable | Alasan penolakan jika ditolak |
| `created_at`, `updated_at` | timestamp nullable | |
*Index:* `item_id`, `user_id`, `type`, `status`

### 2.5 Tabel `item_status_histories`
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id` | bigint unsigned pk | Auto increment |
| `item_id` | bigint unsigned fk | Relasi ke `items.id` (cascade on delete) |
| `user_id` | bigint unsigned fk nullable | Relasi ke `users.id` (aktor pengubah status) |
| `previous_status` | varchar(50) nullable | Status sebelum diubah |
| `new_status` | varchar(50) | Status baru |
| `notes` | text nullable | Catatan perubahan / alasan |
| `created_at`, `updated_at` | timestamp nullable | |

### 2.6 Tabel `handover_records`
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id` | bigint unsigned pk | Auto increment |
| `item_id` | bigint unsigned unique fk | Relasi ke `items.id` (unique: 1 barang 1 serah terima) |
| `claim_id` | bigint unsigned fk nullable | Relasi ke `claims.id` (dasar verifikasi) |
| `officer_id` | bigint unsigned fk | Relasi ke `users.id` (petugas pencatat serah terima) |
| `receiver_id` | bigint unsigned fk | Relasi ke `users.id` (pemilik sah yang menerima barang) |
| `notes` | text nullable | Catatan nomor identitas / verifikasi fisik |
| `handover_date` | timestamp | Waktu serah terima barang |
| `created_at`, `updated_at` | timestamp nullable | |

### 2.7 Tabel `notifications`
Dibuat melalui `php artisan notifications:table` untuk Database Notification bawaan Laravel (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`).

---

## 3. Kontrak Model & Konstanta

### 3.1 `App\Models\User`
- **Konstanta Peran:**
  ```php
  public const ROLE_PENGGUNA = 'pengguna';
  public const ROLE_ADMIN = 'admin';
  public const ROLE_PETUGAS = 'petugas';
  ```
- **Helper:**
  - `isAdmin(): bool`
  - `isPetugas(): bool`
  - `isPengguna(): bool`
  - `homeRoute(): string` (Admin: `admin.dashboard`, Petugas: `petugas.dashboard`, Pengguna: `pengguna.dashboard`)
  - `accountRoute(): string` (`profile.edit`)
- **Relasi:** `items()`, `claims()`, `verifiedClaims()`, `handoversAsOfficer()`, `handoversAsReceiver()`, `statusHistories()`

### 3.2 `App\Models\Category`
- **Relasi:** `items()`

### 3.3 `App\Models\Item`
- **Konstanta Tipe & Status:**
  ```php
  public const TYPE_LOST = 'lost';
  public const TYPE_FOUND = 'found';

  public const STATUS_MENUNGGU = 'menunggu';
  public const STATUS_DIPUBLIKASIKAN = 'dipublikasikan';
  public const STATUS_DITOLAK = 'ditolak';
  public const STATUS_DIBATALKAN = 'dibatalkan';
  public const STATUS_SELESAI = 'selesai';
  ```
- **Accessors:**
  - `kode`: contoh `LST-042` untuk lost, `FND-026` untuk found (`str_pad($this->id, 3, '0', STR_PAD_LEFT)`).
  - `statusLabel()`: Mengembalikan string label bahasa Indonesia.
  - `typeLabel()`: 'Barang Hilang' / 'Barang Ditemukan'.
- **Relasi:** `user()`, `category()`, `claims()`, `statusHistories()`, `handoverRecord()`

### 3.4 `App\Models\Claim`
- **Konstanta Tipe & Status:**
  ```php
  public const TYPE_KLAIM = 'klaim';
  public const TYPE_PENEMUAN = 'penemuan';

  public const STATUS_DIAJUKAN = 'diajukan';
  public const STATUS_DITERIMA = 'diterima';
  public const STATUS_DITOLAK = 'ditolak';
  ```
- **Accessors:**
  - `kode`: contoh `KLM-019` (`str_pad($this->id, 3, '0', STR_PAD_LEFT)`).
  - `statusLabel()`: 'Diajukan', 'Diterima', 'Ditolak'.
- **Relasi:** `item()`, `user()` (pengaju), `verifier()`, `handoverRecord()`

### 3.5 `App\Models\ItemStatusHistory`
- **Relasi:** `item()`, `user()` (pengubah status)

### 3.6 `App\Models\HandoverRecord`
- **Relasi:** `item()`, `claim()`, `officer()`, `receiver()`

---

## 4. Kontrak Service (`app/Services`)

### 4.1 `App\Services\StatusHistoryService`
```php
public function catatAwal(Item $item, ?User $user = null): ItemStatusHistory;
public function ubah(Item $item, string $statusBaru, ?User $user = null, ?string $catatan = null): ItemStatusHistory;
public function catatPerubahan(Item $item, ?string $statusLama, string $statusBaru, ?User $user = null, ?string $catatan = null): ItemStatusHistory;
```
*Catatan:* Operasi `ubah()` dan `catatAwal()` berjalan di dalam `DB::transaction()` untuk menjamin konsistensi status dan riwayat.

### 4.2 `App\Services\NotifikasiService`
```php
public function kirim(User $penerima, string $judul, string $pesan, ?string $url = null, string $jenis = 'info'): void;
```
*Catatan:* Menyimpan ke tabel `notifications` melalui database notification Laravel dengan payload `['title', 'message', 'url', 'type']`.

### 4.3 `App\Services\FileUploadService`
```php
public function simpanPublik(UploadedFile $file, string $folder = 'items'): string;
public function simpanPrivat(UploadedFile $file, string $folder = 'evidences'): string;
public function hapus(string $path, string $disk = 'public'): bool;
```
*Catatan:*
- Validasi maksimal 2 MB.
- Foto publik di-resize otomatis jika lebar > 1280 px menggunakan ekstensi PHP GD.
- Bukti klaim disimpan di disk privat `local` (hanya dapat diakses melalui `EvidenceController`).

---

## 5. Kontrak Rute & Pembagian Modul (`routes/web.php`)

```php
use Illuminate\Support\Facades\Route;

// ============================================================================
// [FASE-0-CORE] - Rute Pondasi, Helper Dev & Halaman Bersama
// ============================================================================
Route::get('/', function () {
    return view('pages.beranda-tamu'); // Dialihkan ke M4 atau beranda
})->name('home');

Route::get('/cara-kerja', function () {
    return view('pages.cara-kerja');
})->name('cara-kerja');

Route::get('/terima-kasih', function () {
    return view('pages.terima-kasih');
})->name('thanks');

// Akses bukti klaim terproteksi
Route::get('/claims/evidence/{claim}', [App\Http\Controllers\EvidenceController::class, 'show'])
    ->middleware('auth')
    ->name('claims.evidence');

// Quick login khusus lokal
if (app()->environment('local')) {
    Route::get('/dev/login/{role}', [App\Http\Controllers\DevLoginController::class, 'login'])
        ->name('dev.login');
}

// ============================================================================
// [M1-ADMIN] - Modul Admin Master Data, Akun & Statistik
// ============================================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)->only(['index', 'update']);
    Route::get('/statistics', fn() => view('admin.statistics'))->name('statistics');
    Route::get('/logs', fn() => view('admin.logs'))->name('logs');
});

// ============================================================================
// [M2-AUTH] - Modul Autentikasi & Akun Pengguna
// ============================================================================
Route::middleware('guest')->group(function () {
    Route::get('/login', fn() => view('auth.login'))->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'store'])->name('login.store');
    Route::get('/register', fn() => view('auth.register'))->name('register');
    Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'store'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'destroy'])->name('logout');
    Route::get('/profile', fn() => view('profile.edit'))->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
});

// ============================================================================
// [M3-LAPORAN] - Modul Pelaporan Barang Lost & Found
// ============================================================================
Route::middleware(['auth', 'role:pengguna'])->prefix('laporan')->name('items.')->group(function () {
    Route::get('/buat', fn() => view('items.create'))->name('create');
    Route::post('/', [App\Http\Controllers\ItemController::class, 'store'])->name('store');
    Route::get('/saya', fn() => view('items.my-reports'))->name('my-reports');
    Route::get('/{item}/edit', fn() => view('items.edit'))->name('edit');
    Route::put('/{item}', [App\Http\Controllers\ItemController::class, 'update'])->name('update');
    Route::post('/{item}/cancel', [App\Http\Controllers\ItemController::class, 'cancel'])->name('cancel');
});

// ============================================================================
// [M4-KATALOG] - Modul Katalog & Pencarian Publik
// ============================================================================
Route::get('/katalog', fn() => view('catalog.index'))->name('catalog.index');
Route::get('/barang/{item}', fn() => view('catalog.show'))->name('catalog.show');

// Dashboard Pengguna (beranda pengguna login)
Route::middleware(['auth', 'role:pengguna'])->get('/pengguna/dashboard', fn() => view('pengguna.dashboard'))
    ->name('pengguna.dashboard');

// ============================================================================
// [M5-KLAIM] - Modul Klaim & Penemuan Barang
// ============================================================================
Route::middleware(['auth', 'role:pengguna'])->prefix('klaim')->name('claims.')->group(function () {
    Route::get('/buat/{item}', fn() => view('claims.create-claim'))->name('create-claim');
    Route::post('/buat/{item}', [App\Http\Controllers\ClaimController::class, 'storeClaim'])->name('store-claim');
    Route::get('/temukan/{item}', fn() => view('claims.create-found'))->name('create-found');
    Route::post('/temukan/{item}', [App\Http\Controllers\ClaimController::class, 'storeFound'])->name('store-found');
    Route::get('/saya', fn() => view('claims.my-claims'))->name('my-claims');
    Route::get('/{claim}', fn() => view('claims.show'))->name('show');
});

// ============================================================================
// [M6-VERIFIKASI] - Modul Verifikasi Laporan, Klaim & Serah Terima
// ============================================================================
Route::middleware(['auth', 'role:admin,petugas'])->prefix('verifikasi')->name('verification.')->group(function () {
    // Verifikasi Laporan Barang (Admin)
    Route::get('/laporan', fn() => view('verification.items.index'))->name('items.index');
    Route::get('/laporan/{item}', fn() => view('verification.items.show'))->name('items.show');
    Route::post('/laporan/{item}/approve', [App\Http\Controllers\Verification\ItemVerificationController::class, 'approve'])->name('items.approve');
    Route::post('/laporan/{item}/reject', [App\Http\Controllers\Verification\ItemVerificationController::class, 'reject'])->name('items.reject');

    // Verifikasi Klaim & Penemuan (Admin & Petugas)
    Route::get('/klaim', fn() => view('verification.claims.index'))->name('claims.index');
    Route::get('/klaim/{claim}', fn() => view('verification.claims.show'))->name('claims.show');
    Route::post('/klaim/{claim}/approve', [App\Http\Controllers\Verification\ClaimVerificationController::class, 'approve'])->name('claims.approve');
    Route::post('/klaim/{claim}/reject', [App\Http\Controllers\Verification\ClaimVerificationController::class, 'reject'])->name('claims.reject');

    // Serah Terima Barang (Petugas)
    Route::get('/serah-terima', fn() => view('verification.handover.index'))->name('handover.index');
    Route::get('/serah-terima/catat/{item}', fn() => view('verification.handover.create'))->name('handover.create');
    Route::post('/serah-terima/catat/{item}', [App\Http\Controllers\Verification\HandoverController::class, 'store'])->name('handover.store');
    Route::get('/serah-terima/{handover}', fn() => view('verification.handover.show'))->name('handover.show');
});

Route::middleware(['auth', 'role:petugas'])->get('/petugas/dashboard', fn() => view('petugas.dashboard'))
    ->name('petugas.dashboard');
```

---

## 6. Aturan Komponen & Stepper Klaim

### 6.1 Stepper Klaim (4 Langkah)
Komponen `<x-claim-stepper :step="$currentStep" :status="$claimStatus" />` menampilkan alur proses:
1. **Langkah 1: Pengajuan Diajukan** (Klaim atau info penemuan telah dikirim ke sistem).
2. **Langkah 2: Verifikasi Berkas & Bukti** (Pemeriksaan berkas kepemilikan/bukti fisik oleh Admin/Petugas).
3. **Langkah 3: Verifikasi Fisik & Serah Terima** (Pemilik sah datang ke pos/lokasi untuk mencocokkan barang).
4. **Langkah 4: Selesai** (Pencatatan berita acara serah terima selesai, status barang menjadi Selesai).

Jika status ditolak: step aktif menampilkan indikator merah bertuliskan "Ditolak".

### 6.2 Komponen Form
- `<x-form.input label="..." name="..." :value="old('...')" type="text" />`
- `<x-form.select label="..." name="..." :options="['k' => 'v']" />`
- `<x-form.textarea label="..." name="..." />`
- `<x-form.file label="..." name="..." accept="image/*" />`

Semua komponen form otomatis membungkus pesan error `@error($name) <span class="form-error">{{ $message }}</span> @enderror`.

---

## 7. Desain & Palet Warna (Terverifikasi dari Figma)

```css
:root {
    --maroon: #730000;
    --maroon-dark: #5B0000;
    --maroon-light: #852C2E;
    --yellow: #FFC900;
    --yellow-hover: #E5B400;
    --cream: #F9E5DE;
    --cream-light: #FDF7F4;
    --dark: #121619;
    --gray: #6B7280;
    --border: #E5E7EB;
    --white: #FFFFFF;
}
```
- Heading: **'Playfair Display', serif**
- Body & Teks: **'Poppins', sans-serif**
- Sidebar Dashboard: Menggunakan latar belakang Maroon (`--maroon`) dengan aksen teks putih/krem dan hover kuning.
- Header Tabel: Menggunakan aksen warna krem (`--cream`).
- Tombol:
  - `.btn-yellow`: background `--yellow`, teks `--dark`, font-weight semi-bold.
  - `.btn-maroon`: background `--maroon`, teks `--white`.
  - `.btn-cream`: background `--cream`, border marun, teks `--maroon`.
