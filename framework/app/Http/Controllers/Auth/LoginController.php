<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Tampilkan formulir masuk/login.
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Proses autentikasi pengguna masuk ke sistem.
     * Sesuai SRS FR-02:
     * - Menggunakan Auth::attempt dengan opsi remember me.
     * - Regenerasi sesi setelah berhasil.
     * - Pesan kesalahan seragam jika gagal ('Email atau kata sandi salah').
     * - Redirect ke rute beranda peran masing-masing.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = [
            'email' => strtolower(trim($request->email)),
            'password' => $request->password,
        ];

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            $targetRoute = method_exists($user, 'homeRoute')
                ? $user->homeRoute()
                : match ($user->role ?? 'pengguna') {
                    'admin' => 'admin.dashboard',
                    'petugas' => 'verifikasi.claims.index',
                    default => 'home',
                };

            $redirectUrl = Route::has($targetRoute)
                ? route($targetRoute)
                : route('home');

            return redirect()->intended($redirectUrl);
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'Email atau kata sandi salah.',
            ]);
    }

    /**
     * Proses keluar/logout dari sistem.
     * Sesuai SRS FR-02:
     * - Menghapus sesi autentikasi.
     * - Invalidate session & regenerate CSRF token.
     * - Redirect ke halaman beranda publik.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
