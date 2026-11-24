<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (FMIPA Lost & Found)
|--------------------------------------------------------------------------
*/

// --- Rute Publik & Fase 0 (Stub Antar-Modul) ---
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/terima-kasih', function () {
    return view('thanks');
})->name('thanks');

Route::get('/barang/{item}', function ($item) {
    return "Detail barang {$item}";
})->name('items.show');

Route::get('/klaim-saya/{claim}', function ($claim) {
    return "Detail klaim {$claim}";
})->name('my-claims.show');

Route::get('/klaim-saya', function () {
    return "Daftar klaim saya";
})->name('my-claims.index');

Route::get('/profil', function () {
    return "Halaman Profil";
})->name('profile');

Route::post('/logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('home');
})->name('logout');

// Rute pembantu login dev untuk pengujian manual
Route::get('/dev/login/{role}', function ($role) {
    $email = match ($role) {
        'admin' => 'admin@fmipa.test',
        'petugas' => 'petugas@fmipa.test',
        default => 'pengguna1@fmipa.test',
    };

    if (class_exists(\App\Models\User::class)) {
        $user = \App\Models\User::firstOrCreate(
            ['email' => $email],
            [
                'name' => ucfirst($role) . ' Test',
                'nim' => 'F1G125000',
                'role' => $role,
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
            ]
        );
        \Illuminate\Support\Facades\Auth::login($user);
    }

    return redirect()->route('dashboard');
})->name('dev.login');

// >>> [M3-LAPORAN] START
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/laporan/buat', [\App\Http\Controllers\Laporan\ReportController::class, 'create'])->name('reports.create');
    Route::post('/laporan', [\App\Http\Controllers\Laporan\ReportController::class, 'store'])->name('reports.store');

    Route::get('/laporan-saya', [\App\Http\Controllers\Laporan\MyReportController::class, 'index'])->name('my-reports.index');
    Route::get('/laporan-saya/{item}/ubah', [\App\Http\Controllers\Laporan\MyReportController::class, 'edit'])->name('my-reports.edit');
    Route::put('/laporan-saya/{item}', [\App\Http\Controllers\Laporan\MyReportController::class, 'update'])->name('my-reports.update');
    Route::patch('/laporan-saya/{item}/batal', [\App\Http\Controllers\Laporan\MyReportController::class, 'cancel'])->name('my-reports.cancel');

    Route::get('/notifikasi', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifikasi/{id}/dibaca', [\App\Http\Controllers\NotificationController::class, 'read'])->name('notifications.read');
    Route::patch('/notifikasi/baca-semua', [\App\Http\Controllers\NotificationController::class, 'readAll'])->name('notifications.read-all');
});
// <<< [M3-LAPORAN] END
