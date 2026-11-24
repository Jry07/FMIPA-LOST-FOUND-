<?php

use Illuminate\Support\Facades\Route;   // satu-satunya "use": JANGAN tambah lagi

/*
|----------------------------------------------------------------------
| routes/web.php  -  FILE BERSAMA (6 anggota)
|----------------------------------------------------------------------
| 1. Edit HANYA di dalam blok milik Anda (antara START dan END).
| 2. Jangan tambah "use". Tulis nama kelas lengkap: \App\Http\...::class
| 3. Jangan ubah ->name(). Nama route adalah kontrak antarmodul.
| 4. Ganti closure 'TODO' dengan controller asli milik Anda.
| 5. Jangan memindahkan blok; sisakan 1 baris kosong antar blok.
*/

// ===== FASE 0 (Scrum Master) - anggota lain jangan ubah ==============
if (app()->environment('local')) {
    Route::get('/dev/login/{role}', function ($role) {
        if (! in_array($role, ['admin', 'petugas', 'pengguna'])) {
            abort(404);
        }
        $user = \App\Models\User::where('role', $role)->first();
        if ($user) {
            auth()->login($user);
            return redirect()->route('dashboard');
        }
        return 'Akun seed ' . $role . ' belum tersedia.';
    })->name('dev.login');
}
Route::middleware('auth')->group(function () {
    Route::view('/terima-kasih', 'pages.terima-kasih')->name('thanks');
    Route::get('/bukti/{claim}', function ($claim) {
        return 'Bukti klaim privat: ' . $claim;
    })->name('claims.evidence');
});
// ===== AKHIR FASE 0 ===================================================


// >>> [M1-ADMIN] START ------------------------------------------------
// Pemilik: Muhammad Fajri Jumadil | Branch: feature/m1-admin-master-data
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', fn () => 'TODO M1: Dashboard Admin')->name('admin.dashboard');
    Route::get('/kategori', fn () => 'TODO M1')->name('admin.categories.index');
    Route::get('/kategori/buat', fn () => 'TODO M1')->name('admin.categories.create');
    Route::post('/kategori', fn () => 'TODO M1')->name('admin.categories.store');
    Route::get('/kategori/{category}/ubah', fn () => 'TODO M1')->name('admin.categories.edit');
    Route::put('/kategori/{category}', fn () => 'TODO M1')->name('admin.categories.update');
    Route::delete('/kategori/{category}', fn () => 'TODO M1')->name('admin.categories.destroy');
    Route::get('/akun', fn () => 'TODO M1: Kelola Akun')->name('admin.users.index');
    Route::patch('/akun/{user}/role', fn () => 'TODO M1')->name('admin.users.role');
});
// <<< [M1-ADMIN] END --------------------------------------------------


// >>> [M2-AUTH] START -------------------------------------------------
// Pemilik: Ferdy Krisnandar | Branch: feature/m2-auth-profil-landing
Route::get('/', fn () => 'TODO M2: Beranda')->name('home');
Route::get('/cara-kerja', fn () => 'TODO M2: Cara Kerja')->name('how-it-works');
Route::middleware('guest')->group(function () {
    Route::get('/daftar', fn () => 'TODO M2: Daftar')->name('register');
    Route::post('/daftar', fn () => 'TODO M2')->name('register.store');
    Route::get('/masuk', fn () => 'TODO M2: Masuk')->name('login');
    Route::post('/masuk', fn () => 'TODO M2')->name('login.store');
});
Route::middleware('auth')->group(function () {
    Route::post('/keluar', fn () => 'TODO M2')->name('logout');
    Route::get('/profil', fn () => 'TODO M2: Profil')->name('profile.edit');
    Route::put('/profil', fn () => 'TODO M2')->name('profile.update');
});
// <<< [M2-AUTH] END ---------------------------------------------------


// >>> [M3-LAPORAN] START ----------------------------------------------
// Pemilik: Rahmah Hidayah Lahompu | Branch: feature/m3-laporan-dashboard
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => 'TODO M3: Dashboard')->name('dashboard');
    Route::get('/laporan/buat', fn () => 'TODO M3: Form Buat Laporan')->name('reports.create');
    Route::post('/laporan', fn () => 'TODO M3')->name('reports.store');
    Route::get('/laporan-saya', fn () => 'TODO M3: Laporan Saya')->name('my-reports.index');
    Route::get('/laporan-saya/{item}/ubah', fn () => 'TODO M3')->name('my-reports.edit');
    Route::put('/laporan-saya/{item}', fn () => 'TODO M3')->name('my-reports.update');
    Route::patch('/laporan-saya/{item}/batal', fn () => 'TODO M3')->name('my-reports.cancel');
    Route::get('/notifikasi', fn () => 'TODO M3: Notifikasi')->name('notifications.index');
    Route::patch('/notifikasi/{id}/dibaca', fn () => 'TODO M3')->name('notifications.read');
});
// <<< [M3-LAPORAN] END ------------------------------------------------


// >>> [M4-KATALOG] START ----------------------------------------------
// Pemilik: Sahrun Karimu | Branch: feature/m4-katalog-detail
Route::middleware('auth')->group(function () {
    Route::get('/barang', fn () => 'TODO M4: Katalog Barang')->name('items.index');
    Route::get('/barang/{item}', fn () => 'TODO M4: Detail Barang')->name('items.show');
});
// <<< [M4-KATALOG] END ------------------------------------------------


// >>> [M5-KLAIM] START ------------------------------------------------
// Pemilik: Elsya Sagitha Damayanti S. | Branch: feature/m5-klaim-penemuan
Route::middleware('auth')->group(function () {
    Route::get('/barang/{item}/klaim', [\App\Http\Controllers\Klaim\ClaimController::class, 'create'])->name('claims.create');
    Route::post('/barang/{item}/klaim', [\App\Http\Controllers\Klaim\ClaimController::class, 'store'])->name('claims.store');
    Route::get('/barang/{item}/temuan', [\App\Http\Controllers\Klaim\ClaimController::class, 'createFinding'])->name('claims.finding.create');
    Route::post('/barang/{item}/temuan', [\App\Http\Controllers\Klaim\ClaimController::class, 'storeFinding'])->name('claims.finding.store');
    Route::get('/klaim-saya', [\App\Http\Controllers\Klaim\MyClaimController::class, 'index'])->name('my-claims.index');
    Route::get('/klaim-saya/{claim}', [\App\Http\Controllers\Klaim\MyClaimController::class, 'show'])->name('my-claims.show');
});
// <<< [M5-KLAIM] END --------------------------------------------------


// >>> [M6-VERIFIKASI] START -------------------------------------------
// Pemilik: Muhammad Aimar Razak | Branch: feature/m6-verifikasi-serah-terima
Route::middleware(['auth'])->prefix('verifikasi/laporan')->group(function () {
    Route::get('/', fn () => 'TODO M6')->name('verifikasi.reports.index');
    Route::get('/{item}', fn () => 'TODO M6')->name('verifikasi.reports.show');
    Route::patch('/{item}/setujui', fn () => 'TODO M6')->name('verifikasi.reports.approve');
    Route::patch('/{item}/tolak', fn () => 'TODO M6')->name('verifikasi.reports.reject');
});
Route::middleware(['auth'])->prefix('verifikasi/pengajuan')->group(function () {
    Route::get('/', fn () => 'TODO M6')->name('verifikasi.claims.index');
    Route::get('/{claim}', fn () => 'TODO M6')->name('verifikasi.claims.show');
    Route::patch('/{claim}/terima', fn () => 'TODO M6')->name('verifikasi.claims.accept');
    Route::patch('/{claim}/tolak', fn () => 'TODO M6')->name('verifikasi.claims.reject');
});
Route::middleware(['auth'])->prefix('serah-terima')->group(function () {
    Route::get('/', fn () => 'TODO M6')->name('handovers.index');
    Route::get('/{claim}', fn () => 'TODO M6')->name('handovers.create');
    Route::post('/{claim}', fn () => 'TODO M6')->name('handovers.store');
});
// <<< [M6-VERIFIKASI] END ---------------------------------------------
