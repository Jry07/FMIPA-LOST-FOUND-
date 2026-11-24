<?php

use Illuminate\Support\Facades\Route;

// >>> [M2-AUTH] START
Route::get('/', [\App\Http\Controllers\PageController::class, 'home'])->name('home');
Route::get('/cara-kerja', [\App\Http\Controllers\PageController::class, 'caraKerja'])->name('how-it-works');

Route::middleware('guest')->group(function () {
    Route::get('/daftar', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/daftar', [\App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.store');
    Route::get('/masuk', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/masuk', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.store')->middleware('throttle:6,1');
});

Route::middleware('auth')->group(function () {
    Route::post('/keluar', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    Route::get('/profil', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
// <<< [M2-AUTH] END

// =============================================================================
// STUB FASE 0 & DEV HELPER (Placeholder rute antar-modul dan pengujian seed)
// =============================================================================
Route::get('/barang', fn() => 'Daftar Barang (M1/M3)')->name('items.index');
Route::get('/lapor', fn() => 'Form Pelaporan Barang (M3)')->name('reports.create');
Route::get('/admin/dashboard', fn() => 'Dashboard Admin (M4)')->name('admin.dashboard');
Route::get('/verifikasi/klaim', fn() => 'Daftar Verifikasi Klaim (M4)')->name('verifikasi.claims.index');
Route::get('/terima-kasih', fn() => 'Halaman Terima Kasih')->name('thanks');

// Rute dev login untuk pengujian cepat dengan akun seed
Route::get('/dev/login/{role}', function ($role) {
    $email = match ($role) {
        'admin' => 'admin@fmipa.test',
        'petugas' => 'petugas@fmipa.test',
        default => 'pengguna1@fmipa.test',
    };

    $user = \App\Models\User::firstOrCreate(
        ['email' => $email],
        [
            'name' => ucfirst($role) . ' Test',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => $role,
            'nim' => $role === 'pengguna' ? 'F1G125032' : null,
        ]
    );

    \Illuminate\Support\Facades\Auth::login($user);

    $homeRoute = method_exists($user, 'homeRoute')
        ? $user->homeRoute()
        : match ($user->role ?? 'pengguna') {
            'admin' => 'admin.dashboard',
            'petugas' => 'verifikasi.claims.index',
            default => 'home',
        };

    return redirect()->route($homeRoute);
})->name('dev.login');
