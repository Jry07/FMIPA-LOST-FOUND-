<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Utama & Informasi
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/cara-kerja', function () {
    return view('welcome');
})->name('how-it-works');

Route::get('/terima-kasih', function () {
    return view('welcome');
})->name('thanks');

// Autentikasi & Dev Login untuk Pengujian Cepat
Route::get('/login', function () {
    return redirect()->route('dev.login', 'admin');
})->name('login');

Route::get('/register', function () {
    return redirect()->route('login');
})->name('register');

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('home');
})->name('logout');

Route::get('/dev/login/{role}', function (string $role) {
    $email = match ($role) {
        'admin' => 'admin@fmipa.test',
        'petugas' => 'petugas@fmipa.test',
        'pengguna', 'pengguna1' => 'pengguna1@fmipa.test',
        'pengguna2' => 'pengguna2@fmipa.test',
        default => null,
    };

    if (!$email || !($user = \App\Models\User::where('email', $email)->first())) {
        return "Pengguna untuk peran [{$role}] tidak ditemukan dalam seeder database.";
    }

    auth()->login($user);
    request()->session()->regenerate();

    return redirect()->route($user->homeRoute())
        ->with('success', "Berhasil masuk sebagai {$user->name} ({$user->role}) lewat /dev/login/{$role}.");
})->name('dev.login');

// Dashboard Utama
Route::get('/dashboard', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    return redirect()->route(auth()->user()->homeRoute());
})->middleware('auth')->name('dashboard');

// Stubs Route Modul Lain
Route::get('/barang', fn() => 'Daftar Barang (M1/M2)')->name('items.index');
Route::get('/barang/buat', fn() => 'Form Pelaporan Barang (M1)')->name('items.create');
Route::get('/barang/{item}', fn($item) => 'Detail Barang')->name('items.show');
Route::get('/laporan-saya', fn() => 'Laporan Saya (M3)')->name('my.reports');
Route::get('/klaim-saya', fn() => 'Klaim Saya (M4)')->name('my.claims');
Route::get('/profil', fn() => 'Profil Pengguna (M5)')->name('profile');
Route::get('/admin/kategori', fn() => 'Kelola Kategori (M7)')->name('admin.categories.index');
Route::get('/admin/pengguna', fn() => 'Kelola Pengguna (M7)')->name('admin.users.index');

// Bukti Klaim (EvidenceController)
Route::get('/pengajuan/{claim}/bukti', [\App\Http\Controllers\EvidenceController::class, 'show'])->name('claims.evidence');

// >>> [M6-VERIFIKASI] START
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/verifikasi/laporan', [\App\Http\Controllers\Verifikasi\ReportVerificationController::class, 'index'])->name('verifikasi.reports.index');
    Route::get('/verifikasi/laporan/{item}', [\App\Http\Controllers\Verifikasi\ReportVerificationController::class, 'show'])->name('verifikasi.reports.show');
    Route::patch('/verifikasi/laporan/{item}/setujui', [\App\Http\Controllers\Verifikasi\ReportVerificationController::class, 'approve'])->name('verifikasi.reports.approve');
    Route::patch('/verifikasi/laporan/{item}/tolak', [\App\Http\Controllers\Verifikasi\ReportVerificationController::class, 'reject'])->name('verifikasi.reports.reject');
});

Route::middleware(['auth', 'role:admin,petugas'])->group(function () {
    Route::get('/verifikasi/pengajuan', [\App\Http\Controllers\Verifikasi\ClaimVerificationController::class, 'index'])->name('verifikasi.claims.index');
    Route::get('/verifikasi/pengajuan/{claim}', [\App\Http\Controllers\Verifikasi\ClaimVerificationController::class, 'show'])->name('verifikasi.claims.show');
    Route::patch('/verifikasi/pengajuan/{claim}/terima', [\App\Http\Controllers\Verifikasi\ClaimVerificationController::class, 'accept'])->name('verifikasi.claims.accept');
    Route::patch('/verifikasi/pengajuan/{claim}/tolak', [\App\Http\Controllers\Verifikasi\ClaimVerificationController::class, 'reject'])->name('verifikasi.claims.reject');
});

Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/serah-terima', [\App\Http\Controllers\Verifikasi\HandoverController::class, 'index'])->name('handovers.index');
    Route::get('/serah-terima/{claim}', [\App\Http\Controllers\Verifikasi\HandoverController::class, 'create'])->name('handovers.create');
    Route::post('/serah-terima/{claim}', [\App\Http\Controllers\Verifikasi\HandoverController::class, 'store'])->name('handovers.store');
});
// <<< [M6-VERIFIKASI] END
