<?php

use Illuminate\Support\Facades\Route;

// ============================================================================
// [FASE-0-CORE] - Rute Pondasi, Helper Dev & Halaman Bersama
// ============================================================================
Route::get('/', [\App\Http\Controllers\PageController::class, 'home'])->name('home');
Route::get('/cara-kerja', [\App\Http\Controllers\PageController::class, 'caraKerja'])->name('cara-kerja');
Route::get('/terima-kasih', function () {
    return view('pages.terima-kasih');
})->name('thanks');

// Akses berkas bukti klaim privat terproteksi
Route::get('/claims/evidence/{claim}', [\App\Http\Controllers\EvidenceController::class, 'show'])
    ->middleware('auth')
    ->name('claims.evidence');

// Quick login khusus lokal
if (app()->environment('local')) {
    Route::get('/dev/login/{role}', [\App\Http\Controllers\DevLoginController::class, 'login'])
        ->name('dev.login');
}

// ============================================================================
// [M1-ADMIN] - Modul Admin Master Data, Akun & Statistik
// >>> [M1-ADMIN] START
// ============================================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])
        ->name('dashboard');

    // FR-12 Kelola Kategori
    Route::get('/kategori', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])
        ->name('categories.index');
    Route::get('/kategori/buat', [\App\Http\Controllers\Admin\CategoryController::class, 'create'])
        ->name('categories.create');
    Route::post('/kategori', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])
        ->name('categories.store');
    Route::get('/kategori/{category}/ubah', [\App\Http\Controllers\Admin\CategoryController::class, 'edit'])
        ->name('categories.edit');
    Route::put('/kategori/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])
        ->name('categories.update');
    Route::delete('/kategori/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])
        ->name('categories.destroy');

    // FR-13 Kelola Akun
    Route::get('/akun', [\App\Http\Controllers\Admin\UserController::class, 'index'])
        ->name('users.index');
    Route::patch('/akun/{user}/role', [\App\Http\Controllers\Admin\UserController::class, 'updateRole'])
        ->name('users.role');

    // Stub halaman statistik & log (akan diisi modul lain jika perlu)
    Route::get('/statistics', fn () => view('admin.statistics'))->name('statistics');
    Route::get('/logs', fn () => view('admin.logs'))->name('logs');
});
// <<< [M1-ADMIN] END

// ============================================================================
// [M2-AUTH] - Modul Autentikasi & Akun Pengguna
// >>> [M2-AUTH] START
// ============================================================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'create'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'store'])->name('login.store');
    Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'create'])->name('register');
    Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'store'])->name('register.store');

    // Alias URL bahasa Indonesia
    Route::get('/masuk', [\App\Http\Controllers\Auth\LoginController::class, 'create']);
    Route::get('/daftar', [\App\Http\Controllers\Auth\RegisterController::class, 'create']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'destroy'])->name('logout');
    Route::post('/keluar', [\App\Http\Controllers\Auth\LoginController::class, 'destroy']);
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profil', [\App\Http\Controllers\ProfileController::class, 'edit']);
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profil', [\App\Http\Controllers\ProfileController::class, 'update']);
    Route::put('/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
});
// <<< [M2-AUTH] END

// ============================================================================
// [M3-LAPORAN] - Modul Pelaporan Barang Lost & Found & Dashboard Pengguna
// >>> [M3-LAPORAN] START
// ============================================================================
Route::middleware(['auth'])->group(function () {
    // Dashboard Pengguna
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/pengguna/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('pengguna.dashboard');

    // Buat Laporan
    Route::get('/laporan/buat', [\App\Http\Controllers\Laporan\ReportController::class, 'create'])->name('items.create');
    Route::post('/laporan', [\App\Http\Controllers\Laporan\ReportController::class, 'store'])->name('items.store');
    // Alias nama rute reports.*
    Route::get('/lapor', [\App\Http\Controllers\Laporan\ReportController::class, 'create'])->name('reports.create');
    Route::post('/lapor', [\App\Http\Controllers\Laporan\ReportController::class, 'store'])->name('reports.store');

    // Laporan Saya
    Route::get('/laporan/saya', [\App\Http\Controllers\Laporan\MyReportController::class, 'index'])->name('items.my-reports');
    Route::get('/laporan-saya', [\App\Http\Controllers\Laporan\MyReportController::class, 'index'])->name('my-reports.index');

    Route::get('/laporan/{item}/edit', [\App\Http\Controllers\Laporan\MyReportController::class, 'edit'])->name('items.edit');
    Route::get('/laporan-saya/{item}/ubah', [\App\Http\Controllers\Laporan\MyReportController::class, 'edit'])->name('my-reports.edit');

    Route::put('/laporan/{item}', [\App\Http\Controllers\Laporan\MyReportController::class, 'update'])->name('items.update');
    Route::put('/laporan-saya/{item}', [\App\Http\Controllers\Laporan\MyReportController::class, 'update'])->name('my-reports.update');

    Route::post('/laporan/{item}/cancel', [\App\Http\Controllers\Laporan\MyReportController::class, 'cancel'])->name('items.cancel');
    Route::patch('/laporan-saya/{item}/batal', [\App\Http\Controllers\Laporan\MyReportController::class, 'cancel'])->name('my-reports.cancel');

    // Notifikasi
    Route::get('/notifikasi', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifikasi/{id}/dibaca', [\App\Http\Controllers\NotificationController::class, 'read'])->name('notifications.read');
    Route::patch('/notifikasi/baca-semua', [\App\Http\Controllers\NotificationController::class, 'readAll'])->name('notifications.read-all');
});
// <<< [M3-LAPORAN] END

// ============================================================================
// [M4-KATALOG] - Modul Katalog & Pencarian Publik
// ============================================================================
Route::get('/katalog', fn () => view('catalog.index'))->name('catalog.index');
Route::get('/barang/{item}', function (\App\Models\Item $item) {
    return view('catalog.show', compact('item'));
})->name('catalog.show');

// ============================================================================
// [M5-KLAIM] - Modul Klaim & Penemuan Barang
// ============================================================================
Route::middleware(['auth', 'role:pengguna'])->prefix('klaim')->name('claims.')->group(function () {
    Route::get('/buat/{item}', [\App\Http\Controllers\ClaimController::class, 'createClaim'])->name('create-claim');
    Route::post('/buat/{item}', [\App\Http\Controllers\ClaimController::class, 'storeClaim'])->name('store-claim');
    Route::get('/temukan/{item}', [\App\Http\Controllers\ClaimController::class, 'createFound'])->name('create-found');
    Route::post('/temukan/{item}', [\App\Http\Controllers\ClaimController::class, 'storeFound'])->name('store-found');
    Route::get('/saya', [\App\Http\Controllers\ClaimController::class, 'myClaims'])->name('my-claims');
    Route::get('/{claim}', [\App\Http\Controllers\ClaimController::class, 'show'])->name('show');
});

// ============================================================================
// [M6-VERIFIKASI] - Modul Verifikasi Laporan, Klaim & Serah Terima
// ============================================================================
Route::middleware(['auth', 'role:admin,petugas'])->prefix('verifikasi')->name('verification.')->group(function () {
    // Verifikasi Laporan Barang (Admin)
    Route::get('/laporan', [\App\Http\Controllers\Verification\ItemVerificationController::class, 'index'])->name('items.index');
    Route::get('/laporan/{item}', [\App\Http\Controllers\Verification\ItemVerificationController::class, 'show'])->name('items.show');
    Route::post('/laporan/{item}/approve', [\App\Http\Controllers\Verification\ItemVerificationController::class, 'approve'])->name('items.approve');
    Route::post('/laporan/{item}/reject', [\App\Http\Controllers\Verification\ItemVerificationController::class, 'reject'])->name('items.reject');

    // Verifikasi Klaim & Penemuan (Admin & Petugas)
    Route::get('/klaim', [\App\Http\Controllers\Verification\ClaimVerificationController::class, 'index'])->name('claims.index');
    Route::get('/klaim/{claim}', [\App\Http\Controllers\Verification\ClaimVerificationController::class, 'show'])->name('claims.show');
    Route::post('/klaim/{claim}/approve', [\App\Http\Controllers\Verification\ClaimVerificationController::class, 'approve'])->name('claims.approve');
    Route::post('/klaim/{claim}/reject', [\App\Http\Controllers\Verification\ClaimVerificationController::class, 'reject'])->name('claims.reject');

    // Serah Terima Barang (Petugas)
    Route::get('/serah-terima', [\App\Http\Controllers\Verification\HandoverController::class, 'index'])->name('handover.index');
    Route::get('/serah-terima/catat/{item}', [\App\Http\Controllers\Verification\HandoverController::class, 'create'])->name('handover.create');
    Route::post('/serah-terima/catat/{item}', [\App\Http\Controllers\Verification\HandoverController::class, 'store'])->name('handover.store');
    Route::get('/serah-terima/{handover}', [\App\Http\Controllers\Verification\HandoverController::class, 'show'])->name('handover.show');
});

Route::middleware(['auth', 'role:petugas'])->get('/petugas/dashboard', fn () => view('petugas.dashboard'))
    ->name('petugas.dashboard');
