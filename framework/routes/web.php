<?php

use Illuminate\Support\Facades\Route;

// ============================================================================
// [FASE-0-CORE] - Rute Pondasi, Helper Dev & Halaman Bersama
// ============================================================================
Route::get('/', [\App\Http\Controllers\PageController::class, 'home'])->name('home');
Route::get('/cara-kerja', [\App\Http\Controllers\PageController::class, 'caraKerja'])->name('cara-kerja');
Route::get('/how-it-works', [\App\Http\Controllers\PageController::class, 'caraKerja'])->name('how-it-works');
Route::get('/terima-kasih', function () {
    return view('pages.terima-kasih');
})->name('thanks');

// Akses berkas bukti klaim privat terproteksi
Route::get('/claims/evidence/{claim}', [\App\Http\Controllers\EvidenceController::class, 'show'])
    ->middleware('auth')
    ->name('claims.evidence');
Route::get('/bukti/{claim}', [\App\Http\Controllers\EvidenceController::class, 'show'])
    ->middleware('auth');

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
// >>> [M4-KATALOG] START
// ============================================================================
Route::get('/katalog', [\App\Http\Controllers\Katalog\ItemController::class, 'index'])->name('catalog.index');
Route::get('/barang', [\App\Http\Controllers\Katalog\ItemController::class, 'index'])->name('items.index');
Route::get('/barang/{item}', [\App\Http\Controllers\Katalog\ItemController::class, 'show'])->name('catalog.show');
Route::get('/katalog/{item}', [\App\Http\Controllers\Katalog\ItemController::class, 'show'])->name('items.show');
// <<< [M4-KATALOG] END

// ============================================================================
// [M5-KLAIM] - Modul Klaim & Penemuan Barang
// >>> [M5-KLAIM] START
// ============================================================================
Route::middleware(['auth'])->group(function () {
    // Form Klaim Kepemilikan (pada barang Found)
    Route::get('/barang/{item}/klaim', [\App\Http\Controllers\Klaim\ClaimController::class, 'create'])->name('claims.create');
    Route::post('/barang/{item}/klaim', [\App\Http\Controllers\Klaim\ClaimController::class, 'store'])->name('claims.store');
    Route::get('/klaim/buat/{item}', [\App\Http\Controllers\Klaim\ClaimController::class, 'create'])->name('claims.create-claim');
    Route::post('/klaim/buat/{item}', [\App\Http\Controllers\Klaim\ClaimController::class, 'store'])->name('claims.store-claim');

    // Form Pelaporan Penemuan (pada barang Lost)
    Route::get('/barang/{item}/temuan', [\App\Http\Controllers\Klaim\ClaimController::class, 'createFinding'])->name('claims.finding.create');
    Route::post('/barang/{item}/temuan', [\App\Http\Controllers\Klaim\ClaimController::class, 'storeFinding'])->name('claims.finding.store');
    Route::get('/klaim/temukan/{item}', [\App\Http\Controllers\Klaim\ClaimController::class, 'createFinding'])->name('claims.create-found');
    Route::post('/klaim/temukan/{item}', [\App\Http\Controllers\Klaim\ClaimController::class, 'storeFinding'])->name('claims.store-found');

    // Daftar & Detail Klaim Saya
    Route::get('/klaim-saya', [\App\Http\Controllers\Klaim\MyClaimController::class, 'index'])->name('my-claims.index');
    Route::get('/klaim/saya', [\App\Http\Controllers\Klaim\MyClaimController::class, 'index'])->name('claims.my-claims');

    Route::get('/klaim-saya/{claim}', [\App\Http\Controllers\Klaim\MyClaimController::class, 'show'])->name('my-claims.show');
    Route::get('/klaim/{claim}', [\App\Http\Controllers\Klaim\MyClaimController::class, 'show'])->name('claims.show');
});
// <<< [M5-KLAIM] END

// ============================================================================
// [M6-VERIFIKASI] - Modul Verifikasi Laporan, Klaim & Serah Terima
// >>> [M6-VERIFIKASI] START
// ============================================================================
// Verifikasi Laporan Barang (Admin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/verifikasi/laporan', [\App\Http\Controllers\Verifikasi\ReportVerificationController::class, 'index'])->name('verification.items.index');
    Route::get('/verifikasi/laporan-masuk', [\App\Http\Controllers\Verifikasi\ReportVerificationController::class, 'index'])->name('verifikasi.reports.index');

    Route::get('/verifikasi/laporan/{item}', [\App\Http\Controllers\Verifikasi\ReportVerificationController::class, 'show'])->name('verification.items.show');
    Route::get('/verifikasi/laporan-detail/{item}', [\App\Http\Controllers\Verifikasi\ReportVerificationController::class, 'show'])->name('verifikasi.reports.show');

    Route::match(['post', 'patch'], '/verifikasi/laporan/{item}/approve', [\App\Http\Controllers\Verifikasi\ReportVerificationController::class, 'approve'])->name('verification.items.approve');
    Route::patch('/verifikasi/laporan/{item}/setujui', [\App\Http\Controllers\Verifikasi\ReportVerificationController::class, 'approve'])->name('verifikasi.reports.approve');

    Route::match(['post', 'patch'], '/verifikasi/laporan/{item}/reject', [\App\Http\Controllers\Verifikasi\ReportVerificationController::class, 'reject'])->name('verification.items.reject');
    Route::patch('/verifikasi/laporan/{item}/tolak', [\App\Http\Controllers\Verifikasi\ReportVerificationController::class, 'reject'])->name('verifikasi.reports.reject');
});

// Verifikasi Klaim & Penemuan (Admin & Petugas)
Route::middleware(['auth', 'role:admin,petugas'])->group(function () {
    Route::get('/verifikasi/klaim', [\App\Http\Controllers\Verifikasi\ClaimVerificationController::class, 'index'])->name('verification.claims.index');
    Route::get('/verifikasi/pengajuan', [\App\Http\Controllers\Verifikasi\ClaimVerificationController::class, 'index'])->name('verifikasi.claims.index');

    Route::get('/verifikasi/klaim/{claim}', [\App\Http\Controllers\Verifikasi\ClaimVerificationController::class, 'show'])->name('verification.claims.show');
    Route::get('/verifikasi/pengajuan/{claim}', [\App\Http\Controllers\Verifikasi\ClaimVerificationController::class, 'show'])->name('verifikasi.claims.show');

    Route::match(['post', 'patch'], '/verifikasi/klaim/{claim}/approve', [\App\Http\Controllers\Verifikasi\ClaimVerificationController::class, 'approve'])->name('verification.claims.approve');
    Route::patch('/verifikasi/pengajuan/{claim}/terima', [\App\Http\Controllers\Verifikasi\ClaimVerificationController::class, 'accept'])->name('verifikasi.claims.accept');

    Route::match(['post', 'patch'], '/verifikasi/klaim/{claim}/reject', [\App\Http\Controllers\Verifikasi\ClaimVerificationController::class, 'reject'])->name('verification.claims.reject');
    Route::patch('/verifikasi/pengajuan/{claim}/tolak', [\App\Http\Controllers\Verifikasi\ClaimVerificationController::class, 'reject'])->name('verifikasi.claims.reject');
});

// Serah Terima Barang (Petugas)
Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/verifikasi/serah-terima', [\App\Http\Controllers\Verifikasi\HandoverController::class, 'index'])->name('verification.handover.index');
    Route::get('/serah-terima', [\App\Http\Controllers\Verifikasi\HandoverController::class, 'index'])->name('handovers.index');

    Route::get('/verifikasi/serah-terima/catat/{claim}', [\App\Http\Controllers\Verifikasi\HandoverController::class, 'create'])->name('verification.handover.create');
    Route::get('/serah-terima/{claim}', [\App\Http\Controllers\Verifikasi\HandoverController::class, 'create'])->name('handovers.create');

    Route::post('/verifikasi/serah-terima/catat/{claim}', [\App\Http\Controllers\Verifikasi\HandoverController::class, 'store'])->name('verification.handover.store');
    Route::post('/serah-terima/{claim}', [\App\Http\Controllers\Verifikasi\HandoverController::class, 'store'])->name('handovers.store');

    Route::get('/verifikasi/serah-terima/detail/{handover}', [\App\Http\Controllers\Verifikasi\HandoverController::class, 'show'])->name('verification.handover.show');
});

Route::middleware(['auth', 'role:petugas'])->get('/petugas/dashboard', fn () => view('petugas.dashboard'))
    ->name('petugas.dashboard');
// <<< [M6-VERIFIKASI] END
